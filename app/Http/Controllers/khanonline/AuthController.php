<?php

namespace App\Http\Controllers\khanonline;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    private const TEST_OTP_CODE = '11111';
    private const OTP_EXPIRATION_MINUTES = 5;
    private const OTP_RESEND_COOLDOWN_SECONDS = 120;

    public function show(): View|RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }

        return view('2khanonline.auth.index');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $phone = $this->validatePhone($request);

        User::query()->updateOrCreate(
            ['phone' => $phone],
            []
        );

        if ($remainingSeconds = $this->otpCooldownRemainingSeconds($phone)) {
            return $this->otpStepResponse(
                phone: $phone,
                errors: ['resend' => $this->cooldownMessage($remainingSeconds)],
                resendSeconds: $remainingSeconds,
            );
        }

        $this->createOtp($phone);

        return $this->otpStepResponse(
            phone: $phone,
            status: 'کد تأیید برای شما ارسال شد. کد تست: ۱۱۱۱۱',
            resendSeconds: self::OTP_RESEND_COOLDOWN_SECONDS,
        );
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $phone = $this->validatePhone($request);

        User::query()->updateOrCreate(
            ['phone' => $phone],
            []
        );

        if ($remainingSeconds = $this->otpCooldownRemainingSeconds($phone)) {
            return $this->otpStepResponse(
                phone: $phone,
                errors: ['resend' => $this->cooldownMessage($remainingSeconds)],
                resendSeconds: $remainingSeconds,
            );
        }

        $this->createOtp($phone);

        return $this->otpStepResponse(
            phone: $phone,
            status: 'کد تأیید جدید ارسال شد. کد تست: ۱۱۱۱۱',
            resendSeconds: self::OTP_RESEND_COOLDOWN_SECONDS,
        );
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $phone = $this->validatePhone($request);

        $code = $this->normalizeDigits($request->input('otp', ''));

        if (! preg_match('/^[0-9]{5}$/', $code)) {
            return $this->otpStepResponse(
                phone: $phone,
                errors: ['otp' => $code === '' ? 'کد تأیید را وارد کنید.' : 'کد تأیید باید دقیقاً ۵ رقم باشد.'],
                resendSeconds: $this->otpCooldownRemainingSeconds($phone),
            );
        }

        $otp = Otp::query()
            ->where('phone', $phone)
            ->where('code', $code)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (! $otp) {
            return $this->otpStepResponse(
                phone: $phone,
                errors: ['otp' => 'کد تأیید واردشده نادرست است.'],
                resendSeconds: $this->otpCooldownRemainingSeconds($phone),
            );
        }

        if ($otp->expires_at->isPast()) {
            return $this->otpStepResponse(
                phone: $phone,
                errors: ['otp' => 'کد تأیید منقضی شده است. لطفاً دوباره کد دریافت کنید.'],
                resendSeconds: $this->otpCooldownRemainingSeconds($phone),
            );
        }

        $otp->update([
            'verified_at' => now(),
        ]);

        $user = User::query()->updateOrCreate(
            ['phone' => $phone],
            ['phone_verified_at' => now()]
        );

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function validatePhone(Request $request): string
    {
        $request->merge([
            'phone' => $this->normalizePhone($request->input('phone')),
        ]);

        $validated = $request->validate([
            'phone' => ['required', 'regex:/^09[0-9]{9}$/'],
        ], [
            'phone.required' => 'شماره موبایل را وارد کنید.',
            'phone.regex' => 'شماره موبایل معتبر نیست.',
        ]);

        return $validated['phone'];
    }

    private function createOtp(string $phone): Otp
    {
        return Otp::query()->create([
            'phone' => $phone,
            'code' => $this->generateOtpCode(),
            'expires_at' => now()->addMinutes(self::OTP_EXPIRATION_MINUTES),
        ]);
    }

    private function otpCooldownRemainingSeconds(string $phone): int
    {
        $latestOtp = Otp::query()
            ->where('phone', $phone)
            ->latest()
            ->first();

        if (! $latestOtp) {
            return 0;
        }

        $availableAt = $latestOtp->created_at->copy()->addSeconds(self::OTP_RESEND_COOLDOWN_SECONDS);

        if ($availableAt->isPast()) {
            return 0;
        }

        return (int) ceil(now()->diffInSeconds($availableAt));
    }

    private function otpStepResponse(
        string $phone,
        ?string $status = null,
        array $errors = [],
        int $resendSeconds = 0,
    ): RedirectResponse {
        $response = back()
            ->withInput([
                'phone' => $phone,
                'step' => 'otp',
            ])
            ->with([
                'auth_phone' => $phone,
                'auth_step' => 'otp',
                'otp_resend_seconds' => $resendSeconds,
            ]);

        if ($status) {
            $response->with('status', $status);
        }

        if ($errors !== []) {
            $response->withErrors($errors);
        }

        return $response;
    }

    private function cooldownMessage(int $seconds): string
    {
        return 'برای ارسال مجدد کد، لطفاً '.$this->toPersianDigits((string) $seconds).' ثانیه دیگر صبر کنید.';
    }

    private function toPersianDigits(string $value): string
    {
        return strtr($value, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);
    }

    private function normalizePhone(?string $phone): string
    {
        $phone = $this->normalizeDigits($phone ?? '');
        $phone = preg_replace('/\D+/', '', $phone) ?? '';

        if (str_starts_with($phone, '0098')) {
            $phone = '0'.substr($phone, 4);
        } elseif (str_starts_with($phone, '98')) {
            $phone = '0'.substr($phone, 2);
        } elseif (str_starts_with($phone, '9') && strlen($phone) === 10) {
            $phone = '0'.$phone;
        }

        return $phone;
    }

    private function normalizeDigits(string $value): string
    {
        return strtr($value, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',
            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ]);
    }

    private function generateOtpCode(): string
    {
        return self::TEST_OTP_CODE;
    }
}
