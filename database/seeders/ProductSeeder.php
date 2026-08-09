<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Database\Seeders\Concerns\DownloadsSigarCenterImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    use DownloadsSigarCenterImages;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('media')->where('model_type', Product::class)->delete();
        Product::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            ProductCategorySeeder::class,
            ProductBrandSeeder::class,
        ]);

        $categories = ProductCategory::query()->pluck('id', 'slug');
        $brandRecords = ProductBrand::query()->get(['id', 'slug', 'name']);
        $brands = $brandRecords->pluck('id', 'slug');
        $brandNames = $brandRecords->pluck('name', 'id');

        $catalog = [
            'imported-cigarettes' => [
                ['Marlboro Filter Plus Extra', 'marlboro-filter-plus-extra', 'marlboro', 480000, 'marlboro-filter-plus-extra'],
                ['Marlboro Red 100s', 'marlboro-red-100s', 'marlboro', 450000, 'marlboro-red'],
                ['Marlboro Shuffle Arab', 'marlboro-shuffle-arab', 'marlboro', 460000, 'marlboro-shuffle'],
                ['Marlboro Gold Arabic', 'marlboro-gold-arabic', 'marlboro', 380000, 'marlboro-gold'],
                ['Marlboro Flavor Code', 'marlboro-flavor-code', 'marlboro', 340000, 'marlboro-flavor-code'],
                ['Marlboro Gold Touch', 'marlboro-gold-touch', 'marlboro', 350000, 'marlboro-gold-touch'],
                ['Marlboro Edge Blue', 'marlboro-edge-blue', 'marlboro', 280000, 'marlboro-edge'],
                ['Marlboro Edge Prime', 'marlboro-edge-prime', 'marlboro', 270000, 'marlboro-edge-prime'],
                ['Captain Black Cherise', 'captain-black-cherise', 'captain-black', 355000, 'captain-black-cherise'],
                ['Captain Black Grape', 'captain-black-grape', 'captain-black', 350000, 'captain-black-grape'],
            ],
            'iranian-cigarettes' => [
                ['بهمن قرمز', 'bahman-red', 'bahman', 85000, 'maddox-nano'],
                ['بهمن لایت', 'bahman-light', 'bahman', 90000, 'maddox-nano'],
                ['بهمن مشکی', 'bahman-black', 'bahman', 90000, 'maddox-nano'],
                ['بهمن نانو', 'bahman-nano', 'bahman', 95000, 'maddox-nano'],
                ['کنت ایرانی نقره‌ای', 'iranian-kent-silver', 'iranian-kent', 110000, '520-green'],
                ['کنت ایرانی آبی', 'iranian-kent-blue', 'iranian-kent', 110000, '520-purple'],
                ['۵۲۰ سبز نعنایی', '520-green-menthol', '520', 120000, '520-green'],
                ['۵۲۰ بنفش', '520-purple', '520', 125000, '520-purple'],
                ['جی تی ام دوسیب', 'gtm-double-apple', 'gtm', 200000, 'gtm-double-apple'],
                ['جی تی ام آلبالو', 'gtm-cherry', 'gtm', 210000, 'gtm-cherry'],
            ],
            'vape-and-pod' => [
                ['Vaporesso XROS 3', 'vaporesso-xros-3', 'vaporesso', 2850000, 'marlboro-edge'],
                ['Vaporesso XROS 4', 'vaporesso-xros-4', 'vaporesso', 3400000, 'marlboro-edge'],
                ['Vaporesso Luxe Q2', 'vaporesso-luxe-q2', 'vaporesso', 3200000, 'marlboro-edge'],
                ['Vaporesso Eco Nano', 'vaporesso-eco-nano', 'vaporesso', 2300000, 'marlboro-edge'],
                ['SMOK Nord 5', 'smok-nord-5', 'smok', 3100000, 'marlboro-edge-prime'],
                ['SMOK Novo 5', 'smok-novo-5', 'smok', 2200000, 'marlboro-edge-prime'],
                ['SMOK RPM 5', 'smok-rpm-5', 'smok', 3300000, 'marlboro-edge-prime'],
                ['Vuse Alto Starter Kit', 'vuse-alto-starter-kit', 'vuse', 1750000, 'marlboro-edge'],
                ['Vuse Go 5000', 'vuse-go-5000', 'vuse', 950000, 'marlboro-edge'],
                ['Vuse Pro Device', 'vuse-pro-device', 'vuse', 2450000, 'marlboro-edge'],
            ],
            'e-liquid-and-nicotine-salt' => [
                ['Nasty Juice Fat Boy 60ml', 'nasty-juice-fat-boy-60ml', 'nasty-juice', 420000, 'captain-black-peach'],
                ['Nasty Juice Slow Blow 60ml', 'nasty-juice-slow-blow-60ml', 'nasty-juice', 420000, 'captain-black-grape'],
                ['Nasty Salt Slow Blow 30ml', 'nasty-salt-slow-blow-30ml', 'nasty-juice', 360000, 'captain-black-grape'],
                ['Nasty Salt Cush Man 30ml', 'nasty-salt-cush-man-30ml', 'nasty-juice', 360000, 'captain-black-mango'],
                ['Nasty Salt ASAP Grape 30ml', 'nasty-salt-asap-grape-30ml', 'nasty-juice', 360000, 'captain-black-grape'],
                ['Vuse Mango Cartridge', 'vuse-mango-cartridge', 'vuse', 390000, 'captain-black-mango'],
                ['Vuse Berry Cereal Cartridge', 'vuse-berry-cereal-cartridge', 'vuse', 390000, 'captain-black-cherise'],
                ['Vaporesso Blueberry E-Liquid', 'vaporesso-blueberry-e-liquid', 'vaporesso', 320000, 'captain-black-grape'],
                ['Vaporesso Mango E-Liquid', 'vaporesso-mango-e-liquid', 'vaporesso', 320000, 'captain-black-mango'],
                ['SMOK Watermelon Salt', 'smok-watermelon-salt', 'smok', 340000, 'teton-peach'],
            ],
            'packaged-barbecue-charcoal' => [
                ['زغال کبابی سکه‌ای ۱ کیلویی', 'three-stars-barbecue-charcoal-1kg', 'three-stars', 180000, 'marlboro-red'],
                ['زغال کبابی سکه‌ای ۳ کیلویی', 'three-stars-barbecue-charcoal-3kg', 'three-stars', 320000, 'marlboro-red'],
                ['زغال کبابی لیمویی ۱ کیلویی', 'lemon-barbecue-charcoal-1kg', 'three-stars', 190000, 'marlboro-gold'],
                ['زغال کبابی لیمویی ۳ کیلویی', 'lemon-barbecue-charcoal-3kg', 'three-stars', 340000, 'marlboro-gold'],
                ['زغال کبابی نارگیلی', 'coconut-barbecue-charcoal', 'three-stars', 240000, 'marlboro-red'],
                ['زغال کبابی فشرده مکعبی', 'cube-barbecue-charcoal', 'three-stars', 260000, 'marlboro-red'],
                ['زغال کبابی سریع‌الاشتعال', 'quick-light-barbecue-charcoal', 'three-stars', 170000, 'marlboro-gold'],
                ['زغال کبابی چوب لیمو', 'lemonwood-barbecue-charcoal', 'three-stars', 210000, 'marlboro-gold'],
                ['زغال کبابی چوب مرکبات', 'citruswood-barbecue-charcoal', 'three-stars', 210000, 'marlboro-gold'],
                ['زغال کبابی رستورانی', 'restaurant-barbecue-charcoal', 'three-stars', 390000, 'marlboro-red'],
            ],
            'hookah-charcoal' => [
                ['زغال قلیان نارگیلی مکعبی', 'coconut-hookah-charcoal-cubes', 'three-stars', 220000, 'marlboro-red'],
                ['زغال قلیان سریع‌الاشتعال', 'quick-light-hookah-charcoal', 'three-stars', 150000, 'marlboro-gold'],
                ['زغال قلیان فلت', 'flat-hookah-charcoal', 'three-stars', 190000, 'marlboro-red'],
                ['زغال قلیان سکه‌ای', 'coin-hookah-charcoal', 'three-stars', 180000, 'marlboro-gold'],
                ['زغال قلیان نارگیلی ۲۵ میلی‌متری', '25mm-coconut-hookah-charcoal', 'three-stars', 230000, 'marlboro-red'],
                ['زغال قلیان نارگیلی ۲۶ میلی‌متری', '26mm-coconut-hookah-charcoal', 'three-stars', 240000, 'marlboro-red'],
                ['زغال قلیان سه‌ستاره ۱ کیلویی', 'three-stars-hookah-charcoal-1kg', 'three-stars', 260000, 'marlboro-gold'],
                ['زغال قلیان بدون بو', 'odorless-hookah-charcoal', 'three-stars', 280000, 'marlboro-gold'],
                ['زغال قلیان فشرده ممتاز', 'premium-pressed-hookah-charcoal', 'three-stars', 300000, 'marlboro-red'],
                ['زغال قلیان بسته اقتصادی', 'economy-hookah-charcoal-pack', 'three-stars', 160000, 'marlboro-gold'],
            ],
            'hookah-tobacco' => [
                ['تنباکوی دوسیب', 'two-apple-hookah-tobacco', 'al-fakher', 280000, 'captain-black-grape'],
                ['تنباکوی نعناع', 'mint-hookah-tobacco', 'al-fakher', 280000, 'captain-black-peach'],
                ['تنباکوی انگور', 'grape-hookah-tobacco', 'al-fakher', 280000, 'captain-black-grape'],
                ['تنباکوی هلو', 'peach-hookah-tobacco', 'adalya', 290000, 'captain-black-peach'],
                ['تنباکوی هندوانه', 'watermelon-hookah-tobacco', 'adalya', 290000, 'teton-peach'],
                ['تنباکوی آدامس بادکنکی', 'bubble-gum-hookah-tobacco', 'mazaya', 270000, 'captain-black-mango'],
                ['تنباکوی لیمو نعناع', 'lemon-mint-hookah-tobacco', 'mazaya', 270000, 'captain-black-cherise'],
                ['تنباکوی بلوبری', 'blueberry-hookah-tobacco', 'fumari', 390000, 'captain-black-grape'],
                ['تنباکوی انبه', 'mango-hookah-tobacco', 'fumari', 390000, 'captain-black-mango'],
                ['تنباکوی قهوه', 'coffee-hookah-tobacco', 'fumari', 390000, 'captain-black-dark-crema'],
            ],
            'cigars' => [
                ['Cohiba Mini Cigarillos', 'cohiba-mini-cigarillos', 'cohiba', 950000, 'captain-black-dark-crema'],
                ['Cohiba Club Cigar', 'cohiba-club-cigar', 'cohiba', 1250000, 'captain-black-dark-crema'],
                ['Davidoff Mini Cigarillos', 'davidoff-mini-cigarillos', 'davidoff', 1100000, 'captain-black-cherise'],
                ['Davidoff Nicaragua Cigar', 'davidoff-nicaragua-cigar', 'davidoff', 2800000, 'captain-black-dark-crema'],
                ['Captain Black Little Cigar Dark Crema', 'captain-black-little-dark-crema', 'captain-black', 330000, 'captain-black-dark-crema'],
                ['Captain Black Little Cigar Peach', 'captain-black-little-peach', 'captain-black', 330000, 'captain-black-peach'],
                ['Captain Black Little Cigar Mango', 'captain-black-little-mango', 'captain-black', 330000, 'captain-black-mango'],
                ['Captain Black Little Cigar Cherise', 'captain-black-little-cherise', 'captain-black', 355000, 'captain-black-cherise'],
                ['Montecristo Mini Cigarillos', 'montecristo-mini-cigarillos', 'montecristo', 980000, 'captain-black-dark-crema'],
                ['Romeo y Julieta Mini Cigarillos', 'romeo-y-julieta-mini-cigarillos', 'romeo-y-julieta', 1050000, 'captain-black-dark-crema'],
            ],
            'heated-tobacco-devices' => [
                ['IQOS ILUMA One', 'iqos-iluma-one', 'iqos', 5200000, 'marlboro-gold'],
                ['IQOS ILUMA Prime', 'iqos-iluma-prime', 'iqos', 7800000, 'marlboro-gold'],
                ['IQOS ILUMA', 'iqos-iluma', 'iqos', 6500000, 'marlboro-gold'],
                ['IQOS 3 Duo', 'iqos-3-duo', 'iqos', 4200000, 'marlboro-gold'],
                ['IQOS TEREA Amber', 'iqos-terea-amber', 'iqos', 420000, 'marlboro-gold-touch'],
                ['IQOS TEREA Bronze', 'iqos-terea-bronze', 'iqos', 420000, 'marlboro-red'],
                ['IQOS TEREA Turquoise', 'iqos-terea-turquoise', 'iqos', 420000, 'marlboro-edge'],
                ['IQOS TEREA Yellow', 'iqos-terea-yellow', 'iqos', 420000, 'marlboro-gold'],
                ['Vuse ePod Heated Device', 'vuse-epod-heated-device', 'vuse', 2900000, 'marlboro-edge'],
                ['Vuse ePod Tobacco Pods', 'vuse-epod-tobacco-pods', 'vuse', 450000, 'marlboro-edge'],
            ],
            'hookahs' => [
                ['قلیان مصری Khalil Mamoon', 'khalil-mamoon-egyptian-hookah', 'khalil-mamoon', 3800000, 'captain-black-dark-crema'],
                ['قلیان Khalil Mamoon دو شلنگ', 'khalil-mamoon-two-hose-hookah', 'khalil-mamoon', 4900000, 'captain-black-dark-crema'],
                ['قلیان استیل مدرن', 'modern-stainless-hookah', 'khalil-mamoon', 3200000, 'captain-black-dark-crema'],
                ['قلیان مسی سنتی', 'traditional-copper-hookah', 'khalil-mamoon', 2900000, 'captain-black-dark-crema'],
                ['قلیان شیشه‌ای رومیزی', 'tabletop-glass-hookah', 'khalil-mamoon', 1800000, 'captain-black-dark-crema'],
                ['قلیان سفالی کوچک', 'small-ceramic-hookah', 'khalil-mamoon', 1250000, 'captain-black-dark-crema'],
                ['قلیان سفری آلومینیومی', 'aluminium-travel-hookah', 'khalil-mamoon', 1500000, 'captain-black-dark-crema'],
                ['قلیان طرح دار بزرگ', 'large-patterned-hookah', 'khalil-mamoon', 4200000, 'captain-black-dark-crema'],
                ['قلیان شیشه‌ای طرح طلایی', 'gold-pattern-glass-hookah', 'khalil-mamoon', 3600000, 'captain-black-dark-crema'],
                ['قلیان یک شلنگ لوکس', 'luxury-single-hose-hookah', 'khalil-mamoon', 5500000, 'captain-black-dark-crema'],
            ],
            'lighters' => [
                ['فندک Zippo Classic', 'zippo-classic-lighter', 'zippo', 1450000, 'marlboro-gold-touch'],
                ['فندک Zippo مات مشکی', 'zippo-matte-black-lighter', 'zippo', 1650000, 'marlboro-gold-touch'],
                ['فندک Zippo آرم‌دار', 'zippo-logo-lighter', 'zippo', 1850000, 'marlboro-gold-touch'],
                ['فندک زیپو طرح موتور', 'zippo-motorcycle-lighter', 'zippo', 1950000, 'marlboro-gold-touch'],
                ['فندک گازی جت فلیم', 'jet-flame-gas-lighter', 'bic', 280000, 'marlboro-red'],
                ['فندک اتمی شارژی', 'rechargeable-arc-lighter', 'bic', 450000, 'marlboro-red'],
                ['فندک فلزی کلاسیک', 'classic-metal-lighter', 'bic', 220000, 'marlboro-gold'],
                ['فندک آشپزخانه بلند', 'long-kitchen-lighter', 'bic', 180000, 'marlboro-gold'],
                ['فندک ضدباد کوهنوردی', 'windproof-camping-lighter', 'zippo', 980000, 'marlboro-gold-touch'],
                ['فندک جیبی طرح چوب', 'wood-design-pocket-lighter', 'zippo', 1250000, 'marlboro-gold-touch'],
            ],
            'smoking-accessories' => [
                ['فیلتر یدک ویپ XROS', 'xros-replacement-pod', 'vaporesso', 480000, 'marlboro-edge'],
                ['کارتریج یدک SMOK Nord', 'smok-nord-replacement-pod', 'smok', 450000, 'marlboro-edge-prime'],
                ['جاسیگاری جیبی فلزی', 'metal-pocket-ashtray', 'zippo', 380000, 'marlboro-gold-touch'],
                ['کیف نگهداری ویپ', 'vape-carrying-case', 'vaporesso', 320000, 'marlboro-edge'],
                ['پیپ چوبی کلاسیک', 'classic-wooden-pipe', 'zippo', 850000, 'captain-black-dark-crema'],
                ['پک فیلتر پیپ', 'pipe-filter-pack', 'zippo', 180000, 'marlboro-gold'],
                ['انبر زغال قلیان', 'hookah-charcoal-tongs', 'zippo', 160000, 'marlboro-red'],
                ['فویل آلومینیومی قلیان', 'hookah-aluminium-foil', 'three-stars', 95000, 'marlboro-gold'],
                ['سری یدک قلیان', 'hookah-replacement-bowl', 'khalil-mamoon', 240000, 'captain-black-dark-crema'],
                ['شلنگ سیلیکونی قلیان', 'silicone-hookah-hose', 'khalil-mamoon', 290000, 'captain-black-dark-crema'],
            ],
        ];

        foreach ($catalog as $categorySlug => $products) {
            foreach ($products as [$name, $slug, $brandSlug, $price, $image]) {
                $product = Product::create([
                    'product_category_id' => $categories[$categorySlug],
                    'product_brand_id' => $brands[$brandSlug],
                    'name' => $name,
                    'slug' => $slug,
                    'description' => sprintf('%s از برند %s، تهیه‌شده بر اساس کاتالوگ فروشگاه سیگارسنتر.', $name, $brandNames[$brands[$brandSlug]]),
                    'price' => $price,
                    'stock' => rand(15, 180),
                ]);

                $this->addSigarCenterImage($product, $this->sigarCenterImageUrl($image), $slug);
            }
        }
    }
}
