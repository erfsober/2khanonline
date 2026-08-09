<?php

namespace Database\Seeders;

use App\Models\ProductBrand;
use Database\Seeders\Concerns\DownloadsSigarCenterImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductBrandSeeder extends Seeder
{
    use DownloadsSigarCenterImages;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('media')->where('model_type', ProductBrand::class)->delete();
        ProductBrand::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $brands = [
            ['name' => 'Marlboro', 'slug' => 'marlboro', 'description' => 'برند جهانی سیگار و محصولات گرمایشی تنباکو.', 'image' => 'marlboro-gold'],
            ['name' => 'Winston', 'slug' => 'winston', 'description' => 'برند باسابقه سیگار با تنوع طعم و شدت.', 'image' => 'marlboro-red'],
            ['name' => 'Camel', 'slug' => 'camel', 'description' => 'برند کلاسیک دخانیات با ترکیب تنباکوی معطر.', 'image' => 'captain-black-grape'],
            ['name' => 'Kent', 'slug' => 'kent', 'description' => 'برند سیگار با تمرکز بر فیلتر و تجربه نرم‌تر.', 'image' => 'esse-lights'],
            ['name' => 'Parliament', 'slug' => 'parliament', 'description' => 'برند پریمیوم سیگار با فیلتر فرورفته متمایز.', 'image' => 'marlboro-gold'],
            ['name' => 'بهمن', 'slug' => 'bahman', 'description' => 'برند ایرانی شناخته‌شده در بازار سیگار.', 'image' => 'maddox-nano'],
            ['name' => 'کنت ایرانی', 'slug' => 'iranian-kent', 'description' => 'برند تولید داخل با مدل‌های متنوع سیگار.', 'image' => '520-green'],
            ['name' => 'Cohiba', 'slug' => 'cohiba', 'description' => 'برند مشهور کوبایی سیگار برگ دست‌پیچ.', 'image' => 'captain-black-dark-crema'],
            ['name' => 'IQOS', 'slug' => 'iqos', 'description' => 'سیستم گرمایش تنباکو از خانواده محصولات فیلیپ موریس.', 'image' => 'marlboro-gold'],
            ['name' => 'Vuse', 'slug' => 'vuse', 'description' => 'برند بین‌المللی دستگاه‌های ویپ و کارتریج.', 'image' => 'marlboro-edge'],
            ['name' => 'Vaporesso', 'slug' => 'vaporesso', 'description' => 'تولیدکننده دستگاه‌ها و پادهای ویپ قابل شارژ.', 'image' => 'marlboro-edge'],
            ['name' => 'SMOK', 'slug' => 'smok', 'description' => 'برند شناخته‌شده تجهیزات ویپ و پاد سیستم.', 'image' => 'marlboro-edge-prime'],
            ['name' => 'Nasty Juice', 'slug' => 'nasty-juice', 'description' => 'برند جویس ویپ با طعم‌های میوه‌ای و ترکیبی.', 'image' => 'captain-black-peach'],
            ['name' => 'Three Stars', 'slug' => 'three-stars', 'description' => 'تولیدکننده زغال فشرده مناسب قلیان و کباب.', 'image' => 'marlboro-red'],
            ['name' => 'Zippo', 'slug' => 'zippo', 'description' => 'برند آمریکایی فندک‌های فلزی قابل شارژ و بادوام.', 'image' => 'marlboro-gold-touch'],
            ['name' => 'Khalil Mamoon', 'slug' => 'khalil-mamoon', 'description' => 'سازنده سنتی قلیان‌های دست‌ساز مصری.', 'image' => 'captain-black-dark-crema'],
            ['name' => 'Captain Black', 'slug' => 'captain-black', 'description' => 'برند محبوب سیگارهای معطر و سیگار برگ کوچک.', 'image' => 'captain-black-dark-crema'],
            ['name' => 'Chapman', 'slug' => 'chapman', 'description' => 'برند سیگارهای معطر با مدل‌های متنوع.', 'image' => 'chapman-cherry'],
            ['name' => '520', 'slug' => '520', 'description' => 'برند سیگار اسلیم و معطر.', 'image' => '520-green'],
            ['name' => 'GTM', 'slug' => 'gtm', 'description' => 'برند سیگارهای طعم‌دار و متنوع.', 'image' => 'gtm-double-apple'],
            ['name' => 'Milano', 'slug' => 'milano', 'description' => 'برند سیگارهای معطر با طعم‌های میوه‌ای.', 'image' => 'milano-vanilla'],
            ['name' => 'Davidoff', 'slug' => 'davidoff', 'description' => 'برند لوکس سوئیسی در حوزه سیگار و سیگار برگ.', 'image' => 'captain-black-dark-crema'],
            ['name' => 'Montecristo', 'slug' => 'montecristo', 'description' => 'برند معتبر سیگار برگ کوبایی.', 'image' => 'captain-black-dark-crema'],
            ['name' => 'Romeo y Julieta', 'slug' => 'romeo-y-julieta', 'description' => 'برند کلاسیک سیگار برگ.', 'image' => 'captain-black-dark-crema'],
            ['name' => 'Al Fakher', 'slug' => 'al-fakher', 'description' => 'برند شناخته‌شده تنباکوی قلیان.', 'image' => 'captain-black-grape'],
            ['name' => 'Adalya', 'slug' => 'adalya', 'description' => 'برند تنباکوی قلیان با طعم‌های میوه‌ای.', 'image' => 'captain-black-peach'],
            ['name' => 'Mazaya', 'slug' => 'mazaya', 'description' => 'تولیدکننده تنباکوی معسل قلیان.', 'image' => 'captain-black-mango'],
            ['name' => 'Fumari', 'slug' => 'fumari', 'description' => 'برند آمریکایی تنباکوی قلیان با طعم‌های متنوع.', 'image' => 'captain-black-cherise'],
            ['name' => 'BIC', 'slug' => 'bic', 'description' => 'برند معتبر فندک‌های کاربردی و روزمره.', 'image' => 'marlboro-red'],
        ];

        foreach ($brands as $brand) {
            $image = $brand['image'];
            unset($brand['image']);
            $record = ProductBrand::create($brand);
            $this->addSigarCenterImage($record, $this->sigarCenterImageUrl($image), $record->slug);
        }
    }
}
