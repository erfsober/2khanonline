<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProductCategory::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $categories = [
            ['name' => 'سیگار'],
            ['name' => 'سیگار برگ'],
            ['name' => 'ویپ'],
            ['name' => 'قلیان'],
            ['name' => 'تنباکو'],
            ['name' => 'لوازم جانبی'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}
