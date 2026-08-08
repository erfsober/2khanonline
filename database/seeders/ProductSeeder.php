<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Product::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $cigarette = ProductCategory::where('slug', 'سیگار')->first();
        $cigar = ProductCategory::where('slug', 'سیگار-برگ')->first();
        $vape = ProductCategory::where('slug', 'ویپ')->first();
        $hookah = ProductCategory::where('slug', 'قلیان')->first();
        $tobacco = ProductCategory::where('slug', 'تنباکو')->first();
        $accessories = ProductCategory::where('slug', 'لوازم-جانبی')->first();

        $marlboro = ProductBrand::where('slug', 'marlboro')->first();
        $winston = ProductBrand::where('slug', 'winston')->first();
        $camel = ProductBrand::where('slug', 'camel')->first();
        $kent = ProductBrand::where('slug', 'kent')->first();
        $parliament = ProductBrand::where('slug', 'parliament')->first();
        $davidoff = ProductBrand::where('slug', 'davidoff')->first();
        $iqos = ProductBrand::where('slug', 'iqos')->first();
        $juul = ProductBrand::where('slug', 'juul')->first();

        $products = [
            // سیگار
            ['name' => 'Marlboro Gold', 'category' => $cigarette, 'brand' => $marlboro, 'price' => 285000, 'stock' => 150],
            ['name' => 'Marlboro Red', 'category' => $cigarette, 'brand' => $marlboro, 'price' => 275000, 'stock' => 200],
            ['name' => 'Marlboro Ice Blast', 'category' => $cigarette, 'brand' => $marlboro, 'price' => 310000, 'stock' => 80],
            ['name' => 'Winston Blue', 'category' => $cigarette, 'brand' => $winston, 'price' => 245000, 'stock' => 180],
            ['name' => 'Winston Silver', 'category' => $cigarette, 'brand' => $winston, 'price' => 250000, 'stock' => 120],
            ['name' => 'Camel Yellow', 'category' => $cigarette, 'brand' => $camel, 'price' => 265000, 'stock' => 90],
            ['name' => 'Camel Blue', 'category' => $cigarette, 'brand' => $camel, 'price' => 260000, 'stock' => 110],
            ['name' => 'Kent Blue', 'category' => $cigarette, 'brand' => $kent, 'price' => 255000, 'stock' => 140],
            ['name' => 'Kent Silver', 'category' => $cigarette, 'brand' => $kent, 'price' => 260000, 'stock' => 100],
            ['name' => 'Parliament Aqua Blue', 'category' => $cigarette, 'brand' => $parliament, 'price' => 310000, 'stock' => 70],

            // سیگار برگ
            ['name' => 'Davidoff Mini Cigarillos', 'category' => $cigar, 'brand' => $davidoff, 'price' => 450000, 'stock' => 40],
            ['name' => 'Davidoff Gold', 'category' => $cigar, 'brand' => $davidoff, 'price' => 395000, 'stock' => 35],

            // ویپ
            ['name' => 'IQOS 3 Duo', 'category' => $vape, 'brand' => $iqos, 'price' => 3500000, 'stock' => 25],
            ['name' => 'IQOS TEREA Bronze', 'category' => $vape, 'brand' => $iqos, 'price' => 280000, 'stock' => 200],
            ['name' => 'IQOS TEREA Turquoise', 'category' => $vape, 'brand' => $iqos, 'price' => 280000, 'stock' => 180],
            ['name' => 'JUUL Starter Kit', 'category' => $vape, 'brand' => $juul, 'price' => 1800000, 'stock' => 30],
            ['name' => 'JUUL Pod Virginia Tobacco', 'category' => $vape, 'brand' => $juul, 'price' => 350000, 'stock' => 150],

            // قلیان
            ['name' => 'قلیان مسی سنتی', 'category' => $hookah, 'brand' => $marlboro, 'price' => 2500000, 'stock' => 15],
            ['name' => 'قلیان استیل مدرن', 'category' => $hookah, 'brand' => $winston, 'price' => 3200000, 'stock' => 10],

            // تنباکو
            ['name' => 'تنباکو معسل سیب', 'category' => $tobacco, 'brand' => $marlboro, 'price' => 180000, 'stock' => 300],
            ['name' => 'تنباکو معسل انگور', 'category' => $tobacco, 'brand' => $marlboro, 'price' => 180000, 'stock' => 280],
            ['name' => 'تنباکو معسل نعناع', 'category' => $tobacco, 'brand' => $winston, 'price' => 190000, 'stock' => 250],

            // لوازم جانبی
            ['name' => 'فندک زیپو کلاسیک', 'category' => $accessories, 'brand' => $camel, 'price' => 850000, 'stock' => 50],
            ['name' => 'جاسیگاری چرمی', 'category' => $accessories, 'brand' => $kent, 'price' => 450000, 'stock' => 60],
            ['name' => 'کیف تنباکو', 'category' => $accessories, 'brand' => $davidoff, 'price' => 320000, 'stock' => 45],
        ];

        foreach ($products as $product) {
            if ($product['category'] && $product['brand']) {
                Product::create([
                    'product_category_id' => $product['category']->id,
                    'product_brand_id' => $product['brand']->id,
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name']),
                    'description' => 'محصول باکیفیت از برند ' . $product['brand']->name,
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                ]);
            }
        }
    }
}
