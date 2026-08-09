@extends('2khanonline.layout.main')

@section('title', 'محصولات ' . $category->name . ' | دو خان')

@section('content')
    <section class="pt-8 pb-20">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-[#737373] mb-6" aria-label="breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#171717] transition-colors">خانه</a>
                <span class="text-[#D4D4D4]">/</span>
                <span class="text-[#171717] font-medium">محصولات {{ $category->name }}</span>
            </nav>

            <div class="flex items-end justify-between gap-4 mb-8">
                <div>
                    <p class="text-sm text-[#737373] mb-2">دسته‌بندی</p>
                    <h1 class="text-2xl lg:text-3xl font-bold">محصولات {{ $category->name }}</h1>
                </div>
                <span class="text-sm text-[#737373]">{{ number_format($products->total()) }} محصول</span>
            </div>

            <form method="GET" action="{{ route('categories.show', ['category' => $category->slug]) }}" class="bg-white border border-[#E5E5E5] rounded-2xl p-4 mb-8 flex flex-col md:flex-row md:items-end gap-4">
                <div class="flex-1">
                    <label for="brand" class="block text-xs font-medium text-[#737373] mb-2">برند</label>
                    <select id="brand" name="brand" class="w-full rounded-lg border border-[#E5E5E5] bg-[#FAFAF9] px-3 py-2.5 text-sm focus:outline-none focus:border-[#171717]">
                        <option value="">همه برندها</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected($brandId === $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="sort" class="block text-xs font-medium text-[#737373] mb-2">مرتب‌سازی</label>
                    <select id="sort" name="sort" class="w-full rounded-lg border border-[#E5E5E5] bg-[#FAFAF9] px-3 py-2.5 text-sm focus:outline-none focus:border-[#171717]">
                        <option value="">جدیدترین</option>
                        <option value="price_asc" @selected($sort === 'price_asc')>قیمت: کم به زیاد</option>
                        <option value="price_desc" @selected($sort === 'price_desc')>قیمت: زیاد به کم</option>
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-[#171717] px-6 py-2.5 text-sm font-medium text-white hover:bg-[#2a2a2a] transition-colors">
                    اعمال فیلتر
                </button>
                @if ($brandId > 0 || $sort !== '')
                    <a href="{{ route('categories.show', ['category' => $category->slug]) }}" class="text-center text-sm text-[#737373] hover:text-[#171717] transition-colors md:pb-2.5">
                        حذف فیلترها
                    </a>
                @endif
            </form>

            @if ($products->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @foreach ($products as $product)
                        <a href="{{ route('products.show', $product->slug) }}" class="bg-white border border-[#E5E5E5] rounded-[14px] overflow-hidden hover:border-[#d4d4d4] hover:-translate-y-1 transition-all duration-200 group block">
                            <div class="relative aspect-square bg-[#FAFAF9]">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-contain scale-80">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[#737373]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h2 class="text-xs font-medium mb-2 truncate">{{ $product->name }}</h2>
                                <p class="text-sm font-bold mb-3">{{ number_format($product->price) }} <span class="text-[10px] font-normal text-[#737373]">تومان</span></p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-10 flex justify-center">
                    {{ $products->links() }}
                </div>
            @else
                <div class="rounded-2xl border border-[#E5E5E5] bg-white px-6 py-16 text-center text-sm text-[#737373]">
                    محصولی در این دسته‌بندی یافت نشد.
                </div>
            @endif
        </div>
    </section>
@endsection
