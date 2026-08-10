<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Database\Seeders\Concerns\DownloadsSigarCenterImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    use DownloadsSigarCenterImages;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('media')->where('model_type', ProductCategory::class)->delete();
        ProductCategory::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $categories = [
            ['name' => 'سیگار خارجی', 'slug' => 'imported-cigarettes'],
            ['name' => 'سیگار ایرانی', 'slug' => 'iranian-cigarettes'],
            ['name' => 'ویپ و پاد', 'slug' => 'vape-and-pod'],
            ['name' => 'جویس و سالت', 'slug' => 'e-liquid-and-nicotine-salt'],
            ['name' => 'زغال کبابی بسته‌ای', 'slug' => 'packaged-barbecue-charcoal'],
            ['name' => 'زغال قلیان', 'slug' => 'hookah-charcoal'],
            ['name' => 'تنباکوی قلیان', 'slug' => 'hookah-tobacco'],
            ['name' => 'سیگار برگ', 'slug' => 'cigars'],
            ['name' => 'دستگاه گرمایش تنباکو', 'slug' => 'heated-tobacco-devices'],
            ['name' => 'قلیان', 'slug' => 'hookahs'],
            ['name' => 'فندک', 'slug' => 'lighters'],
            ['name' => 'لوازم جانبی دخانیات', 'slug' => 'smoking-accessories'],
        ];

        $image = 'https://sigarcenter.com/wp-content/uploads/2025/03/sigarcenter-full-logo-2-e1767206153551.webp';

        foreach ($categories as $category) {
            $record = ProductCategory::create($category);
            $this->addSigarCenterImage($record, $image, $category['slug']);
        }
    }
}
