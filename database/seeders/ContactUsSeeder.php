<?php

namespace Database\Seeders;

use App\Models\ContactUs;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    public function run(): void
    {
        ContactUs::query()->truncate();

        $description = <<<'HTML'
<p>
تیم پشتیبانی ما آماده پاسخگویی به سوالات، پیشنهادات و مشکلات شما عزیزان است. از طریق راه‌های ارتباطی زیر می‌توانید با ما در تماس باشید.
</p>

<p>
ساعات پاسخگویی: شنبه تا پنجشنبه، ۹ صبح تا ۶ عصر
</p>
HTML;

        ContactUs::create([
            'title' => 'تماس با ما',
            'description' => $description,
            'location' => '29.591800,52.583700',
            'telegram' => 'https://t.me/',
            'whatsapp' => 'https://wa.me/989121234567',
            'address' => 'شیراز، ایران',
        ]);
    }
}
