<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const SUFFIX = ' این محصول برای سفارش آنلاین در شیراز با ارسال سریع از Smokify عرضه می‌شود.';

    public function up(): void
    {
        DB::table('products')
            ->whereNotNull('description')
            ->whereNotLike('description', '%' . self::SUFFIX)
            ->update([
                'description' => DB::raw($this->appendDescriptionExpression()),
            ]);
    }

    public function down(): void
    {
        DB::table('products')
            ->where('description', 'like', '%' . self::SUFFIX)
            ->update([
                'description' => DB::raw("REPLACE(description, '" . self::SUFFIX . "', '')"),
            ]);
    }

    private function appendDescriptionExpression(): string
    {
        $suffix = str_replace("'", "''", self::SUFFIX);

        return DB::connection()->getDriverName() === 'mysql'
            ? "CONCAT(description, '{$suffix}')"
            : "description || '{$suffix}'";
    }
};
