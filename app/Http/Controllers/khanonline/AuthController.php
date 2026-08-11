<?php

namespace App\Http\Controllers\khanonline;

use App\Exceptions\OtpException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Auth\OtpService;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService,
        private readonly CartService $cartService,
    ) {}

    public function show(): View|RedirectResponse
    {
        if (Auth::guard('web')->check()) {
            return redirect()->intended(route('home'));
        }

        return view('2khanonline.auth.index');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $phone = $this->validatePhone($request);

        User::query()->updateOrCreate(['phone' => $phone], []);

        try {
            $this->otpService->send($phone, $request->ip());
        } catch (OtpException $e) {
            if ($e->getCode() === 429) {
                return $this->otpStepResponse(
                    phone: $phone,
                    errors: ['resend' => $e->getMessage()],
                    resendSeconds: $this->otpService->getCooldownSeconds($phone),
                );
            }

            return $this->otpStepResponse(
                phone: $phone,
                errors: ['resend' => $e->getMessage()],
            );
        }

        return $this->otpStepResponse(
            phone: $phone,
            status: 'کد تأیید برای شما ارسال شد.',
            resendSeconds: $this->otpService->getCooldownSeconds($phone) ?: 120,
        );
    }

    public function resendOtp(Request $request): RedirectResponse
    {
        $phone = $this->validatePhone($request);

        User::query()->updateOrCreate(['phone' => $phone], []);

        try {
            $this->otpService->send($phone, $request->ip());
        } catch (OtpException $e) {
            if ($e->getCode() === 429) {
                return $this->otpStepResponse(
                    phone: $phone,
                    errors: ['resend' => $e->getMessage()],
                    resendSeconds: $this->otpService->getCooldownSeconds($phone),
                );
            }

            return $this->otpStepResponse(
                phone: $phone,
                errors: ['resend' => $e->getMessage()],
            );
        }

        return $this->otpStepResponse(
            phone: $phone,
            status: 'کد تأیید جدید ارسال شد.',
            resendSeconds: $this->otpService->getCooldownSeconds($phone) ?: 120,
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
                resendSeconds: $this->otpService->getCooldownSeconds($phone),
            );
        }

        try {
            $this->otpService->verify($phone, $code);
        } catch (OtpException $e) {
            return $this->otpStepResponse(
                phone: $phone,
                errors: ['otp' => $e->getMessage()],
                resendSeconds: $this->otpService->getCooldownSeconds($phone),
            );
        }

        $user = User::query()->updateOrCreate(
            ['phone' => $phone],
            ['phone_verified_at' => now()]
        );

        Auth::guard('web')->login($user);
        $request->session()->regenerate();
        $this->cartService->mergeGuestCartForUser($user);

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
}
