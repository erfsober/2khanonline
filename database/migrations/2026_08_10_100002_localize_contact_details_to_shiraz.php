<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('contact_us')
            ->where('address', 'تهران، خیابان ولیعصر، پلاک ۱۲۳')
            ->update([
                'location' => '29.591800,52.583700',
                'address' => 'شیراز، ایران',
            ]);
    }

    public function down(): void
    {
        DB::table('contact_us')
            ->where('address', 'شیراز، ایران')
            ->update([
                'location' => '35.689200,51.389000',
                'address' => 'تهران، خیابان ولیعصر، پلاک ۱۲۳',
            ]);
    }
};
