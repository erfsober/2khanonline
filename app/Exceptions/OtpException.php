<?php

namespace App\Exceptions;

use RuntimeException;

class OtpException extends RuntimeException
{
    public static function cooldown(int $seconds): static
    {
        return new static("لطفاً {$seconds} ثانیه دیگر صبر کنید.", 429);
    }

    public static function hourlyPhoneLimit(): static
    {
        return new static('تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً یک ساعت دیگر تلاش کنید.', 429);
    }

    public static function hourlyIpLimit(): static
    {
        return new static('تعداد درخواست‌های شما بیش از حد مجاز است. لطفاً بعداً تلاش کنید.', 429);
    }

    public static function verificationLocked(): static
    {
        return new static('تعداد تلاش‌های ناموفق بیش از حد مجاز است. لطفاً کد جدید دریافت کنید.', 429);
    }

    public static function notFound(): static
    {
        return new static('کد تأیید یافت نشد. لطفاً کد جدید دریافت کنید.', 404);
    }

    public static function expired(): static
    {
        return new static('کد تأیید منقضی شده است. لطفاً کد جدید دریافت کنید.', 410);
    }

    public static function invalid(): static
    {
        return new static('کد تأیید واردشده نادرست است.', 422);
    }

    public static function smsFailed(?string $message = null): static
    {
        return new static($message ?? 'ارسال پیامک با خطا مواجه شد. لطفاً دوباره تلاش کنید.', 502);
    }
}
