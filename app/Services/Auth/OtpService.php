<?php

namespace App\Services\Auth;

use App\Exceptions\OtpException;
use App\Models\Otp;
use App\Services\Sms\MedianaService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class OtpService
{
    private const EXPIRATION_MINUTES = 5;
    private const RESEND_COOLDOWN_SECONDS = 120;
    private const MAX_OTPS_PER_PHONE_PER_HOUR = 5;
    private const MAX_OTPS_PER_IP_PER_HOUR = 10;
    private const MAX_FAILED_VERIFICATIONS = 5;

    public function __construct(
        private readonly MedianaService $sms,
    ) {}

    public function send(string $phone, ?string $ip = null): void
    {
        $this->enforceSendRateLimits($phone, $ip);

        $code = $this->generateCode();
        $salt = bin2hex(random_bytes(16));

        $this->invalidatePreviousOtps($phone);

        Otp::query()->create([
            'phone' => $phone,
            'code' => hash('sha256', $code.$salt).':'.$salt,
            'expires_at' => now()->addMinutes(self::EXPIRATION_MINUTES),
        ]);

        $this->sms->sendOtp($phone, $code);
    }

    public function verify(string $phone, string $code): Otp
    {
        $otp = Otp::query()
            ->where('phone', $phone)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (! $otp) {
            throw OtpException::notFound();
        }

        if ($otp->expires_at->isPast()) {
            $otp->delete();
            throw OtpException::expired();
        }

        $cacheKey = 'otp_failed:'.$phone;
        $failedAttempts = (int) Cache::get($cacheKey, 0);

        if ($failedAttempts >= self::MAX_FAILED_VERIFICATIONS) {
            throw OtpException::verificationLocked();
        }

        [$storedHash, $salt] = explode(':', $otp->code, 2);
        $inputHash = hash('sha256', $code.$salt);

        if (! hash_equals($storedHash, $inputHash)) {
            Cache::put($cacheKey, $failedAttempts + 1, now()->addHour());
            throw OtpException::invalid();
        }

        Cache::forget($cacheKey);
        $otp->update(['verified_at' => now()]);

        return $otp;
    }

    public function getCooldownSeconds(string $phone): int
    {
        $latestOtp = Otp::query()
            ->where('phone', $phone)
            ->latest()
            ->first();

        if (! $latestOtp) {
            return 0;
        }

        $availableAt = $latestOtp->created_at->copy()->addSeconds(self::RESEND_COOLDOWN_SECONDS);

        if ($availableAt->isPast()) {
            return 0;
        }

        return (int) ceil(now()->diffInSeconds($availableAt));
    }

    private function enforceSendRateLimits(string $phone, ?string $ip): void
    {
        $cooldown = $this->getCooldownSeconds($phone);

        if ($cooldown > 0) {
            throw OtpException::cooldown($cooldown);
        }

        $phoneKey = 'otp_hourly_phone:'.$phone;
        $phoneCount = (int) Cache::get($phoneKey, 0);

        if ($phoneCount >= self::MAX_OTPS_PER_PHONE_PER_HOUR) {
            throw OtpException::hourlyPhoneLimit();
        }

        Cache::put($phoneKey, $phoneCount + 1, now()->addHour());

        if ($ip) {
            $ipKey = 'otp_hourly_ip:'.$ip;
            $ipCount = (int) Cache::get($ipKey, 0);

            if ($ipCount >= self::MAX_OTPS_PER_IP_PER_HOUR) {
                throw OtpException::hourlyIpLimit();
            }

            Cache::put($ipKey, $ipCount + 1, now()->addHour());
        }
    }

    private function invalidatePreviousOtps(string $phone): void
    {
        Otp::query()
            ->where('phone', $phone)
            ->whereNull('verified_at')
            ->update(['verified_at' => now()]);
    }

    private function generateCode(): string
    {
        return str_pad((string) random_int(0, 99999), 5, '0', STR_PAD_LEFT);
    }
}
