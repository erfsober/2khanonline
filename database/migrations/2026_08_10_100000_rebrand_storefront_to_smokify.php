<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('product_categories')
            ->where('slug', 'e-liquid-and-nicotine-salt')
            ->update(['name' => 'جویس و سالت']);

        DB::table('products')
            ->where('description', 'like', '%سیگارسنتر%')
            ->update([
                'description' => DB::raw("REPLACE(description, 'سیگارسنتر', 'اسموکیفای')"),
            ]);
    }

    public function down(): void
    {
        DB::table('product_categories')
            ->where('slug', 'e-liquid-and-nicotine-salt')
            ->update(['name' => 'جویس و سالت نیکوتین']);

        DB::table('products')
            ->where('description', 'like', '%اسموکیفای%')
            ->update([
                'description' => DB::raw("REPLACE(description, 'اسموکیفای', 'سیگارسنتر')"),
            ]);
    }
};
