<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductBrandSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProductBrand::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $brands = [
            ['name' => 'Marlboro', 'description' => 'برند پیشتاز جهانی سیگار با سابقه طولانی در تولید محصولات دخانی باکیفیت'],
            ['name' => 'Winston', 'description' => 'یکی از شناخته‌شده‌ترین برندهای سیگار در جهان با طعم ملایم'],
            ['name' => 'Camel', 'description' => 'برند کلاسیک آمریکایی با ترکیب منحصر به فرد تنباکو'],
            ['name' => 'Kent', 'description' => 'برند معتبر سیگار با فیلتر نوآورانه'],
            ['name' => 'Parliament', 'description' => 'برند پریمیوم سیگار با طراحی خاص فیلتر فرورفته'],
            ['name' => 'Davidoff', 'description' => 'برند لوکس سوئیسی با محصولات دخانی پریمیوم'],
            ['name' => 'IQOS', 'description' => 'سیستم گرمایش تنباکو فیلیپ موریس'],
            ['name' => 'JUUL', 'description' => 'برند پیشتاز ویپ و سیگار الکترونیکی'],
        ];

        foreach ($brands as $brand) {
            ProductBrand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'description' => $brand['description'],
            ]);
        }
    }
}
