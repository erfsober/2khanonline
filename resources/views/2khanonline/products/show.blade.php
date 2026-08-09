@extends('2khanonline.layout.main')

@section('title', ($product->name ?? $product->title ?? 'محصول') . ' | دو خان')

@section('content')
    @php
        $productName = $product->name ?? $product->title ?? 'محصول';
        $description = trim((string) ($product->description ?? ''));
        $isAvailable = $stock > 0;
        $initialQuantity = $isAvailable ? 1 : 0;
        $initialTotal = $unitPrice * $initialQuantity;
    @endphp

    <section class="pt-6 lg:pt-8 pb-16 lg:pb-20">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-[#737373] mb-6" aria-label="breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#171717] transition-colors">خانه</a>
                <span class="text-[#D4D4D4]">/</span>
                @if ($categoryName)
                    <span>{{ $categoryName }}</span>
                    <span class="text-[#D4D4D4]">/</span>
                @endif
                <span class="text-[#171717] font-medium truncate">{{ $productName }}</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-6 lg:gap-8 items-start">
                <div class="bg-white border border-[#E5E5E5] rounded-[24px] overflow-hidden shadow-[0_24px_70px_rgba(23,23,23,0.06)]">
                    <div class="relative aspect-square bg-[#FAFAF9]">
                        @if ($imageUrl)
                            <img
                                src="{{ $imageUrl }}"
                                alt="{{ $productName }}"
                                class="absolute inset-0 w-full h-full object-contain scale-80"
                            >
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 text-[#A3A3A3] p-8">
                                <div class="w-20 h-20 rounded-3xl bg-white border border-[#E5E5E5] flex items-center justify-center shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">تصویر محصول موجود نیست</span>
                            </div>
                        @endif

                        <div class="absolute top-4 right-4 flex flex-wrap gap-2">
                            @if ($categoryName)
                                <span class="inline-flex text-xs font-medium text-[#171717] bg-white/90 backdrop-blur px-3 py-1.5 rounded-full border border-white/70 shadow-sm">
                                    {{ $categoryName }}
                                </span>
                            @endif
                            @if (! $isAvailable)
                                <span class="inline-flex text-xs font-medium text-red-600 bg-red-50 px-3 py-1.5 rounded-full border border-red-100 shadow-sm">
                                    ناموجود
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-5 lg:sticky lg:top-24">
                    <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-6 lg:p-8 shadow-[0_24px_70px_rgba(23,23,23,0.06)]">
                        <div class="flex flex-wrap items-center gap-2 mb-5">
                            @if ($categoryName)
                                <span class="inline-flex text-xs font-medium text-[#B88A2A] bg-[#B88A2A]/10 px-3 py-1 rounded-full">
                                    دسته‌بندی: {{ $categoryName }}
                                </span>
                            @else
                                <span class="inline-flex text-xs font-medium text-[#737373] bg-[#FAFAF9] border border-[#E5E5E5] px-3 py-1 rounded-full">
                                    دسته‌بندی: نامشخص
                                </span>
                            @endif
                            @if ($brandName)
                                <span class="inline-flex text-xs font-medium text-[#525252] bg-[#FAFAF9] border border-[#E5E5E5] px-3 py-1 rounded-full">
                                    برند: {{ $brandName }}
                                </span>
                            @else
                                <span class="inline-flex text-xs font-medium text-[#737373] bg-[#FAFAF9] border border-[#E5E5E5] px-3 py-1 rounded-full">
                                    برند: نامشخص
                                </span>
                            @endif
                        </div>

                        <h1 class="text-2xl lg:text-[36px] font-bold leading-tight text-[#171717] mb-4">
                            {{ $productName }}
                        </h1>

                        <div
                            class="rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-5 space-y-4"
                            data-product-purchase
                            data-product-id="{{ $product->id }}"
                            data-cart-add-url="{{ route('cart.add') }}"
                            data-cart-url="{{ route('cart.index') }}"
                            data-unit-price="{{ $unitPrice }}"
                            data-stock="{{ $stock }}"
                        >
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm text-[#737373]">قیمت واحد</span>
                                <strong class="text-xl lg:text-2xl font-bold text-[#171717]">
                                    {{ number_format($unitPrice) }}
                                    <span class="text-xs font-normal text-[#737373]">تومان</span>
                                </strong>
                            </div>

                            <div class="flex items-center justify-between gap-4 border-t border-[#E5E5E5] pt-4">
                                <span class="text-sm text-[#737373]">موجودی</span>
                                <span class="text-sm font-semibold {{ $isAvailable ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ number_format($stock) }} عدد
                                </span>
                            </div>

                            <div class="flex items-center justify-between gap-4 border-t border-[#E5E5E5] pt-4">
                                <span class="text-sm text-[#737373]">تعداد</span>
                                <div class="inline-flex items-center rounded-2xl border border-[#E5E5E5] bg-white p-1 shadow-sm" aria-label="انتخاب تعداد">
                                    <button
                                        type="button"
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-semibold text-[#171717] hover:bg-[#FAFAF9] disabled:opacity-35 disabled:cursor-not-allowed transition-colors"
                                        data-quantity-decrease
                                        @disabled(! $isAvailable)
                                        aria-label="کم کردن تعداد"
                                    >−</button>
                                    <input
                                        type="text"
                                        value="{{ $initialQuantity }}"
                                        inputmode="numeric"
                                        readonly
                                        class="w-12 h-10 text-center text-base font-bold bg-transparent focus:outline-none"
                                        data-quantity-value
                                        aria-label="تعداد انتخاب‌شده"
                                    >
                                    <button
                                        type="button"
                                        class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-semibold text-[#171717] hover:bg-[#FAFAF9] disabled:opacity-35 disabled:cursor-not-allowed transition-colors"
                                        data-quantity-increase
                                        @disabled(! $isAvailable)
                                        aria-label="زیاد کردن تعداد"
                                    >+</button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4 border-t border-[#E5E5E5] pt-4">
                                <span class="text-sm text-[#737373]">مجموع</span>
                                <strong class="text-xl lg:text-2xl font-bold text-[#171717]">
                                    <span data-total-price>{{ number_format($initialTotal) }}</span>
                                    <span class="text-xs font-normal text-[#737373]">تومان</span>
                                </strong>
                            </div>
                        </div>

                        <div class="hidden mt-5 rounded-2xl border px-5 py-4 text-sm font-medium" data-add-cart-message></div>

                        <button
                            type="button"
                            class="mt-5 w-full rounded-2xl bg-[#171717] px-6 py-4 text-sm font-semibold text-white hover:bg-[#2a2a2a] disabled:opacity-55 disabled:cursor-not-allowed transition-colors"
                            data-add-to-cart
                            @disabled(! $isAvailable)
                        >
                            {{ $isAvailable ? 'افزودن به سبد خرید' : 'ناموجود' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($description !== '')
        <section class="max-w-[1260px] mx-auto px-6 lg:px-8 pb-20">
            <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-6 lg:p-10 shadow-[0_24px_70px_rgba(23,23,23,0.05)]">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-10 h-10 rounded-xl bg-[#FAFAF9] border border-[#E5E5E5] flex items-center justify-center text-[#B88A2A]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5A3.375 3.375 0 0 0 10.125 2.25H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </span>
                    <h2 class="text-lg lg:text-xl font-bold">توضیحات محصول</h2>
                </div>

                <div class="space-y-5 text-sm lg:text-base text-[#525252] leading-8 lg:leading-9 [&_h1]:text-2xl [&_h1]:font-bold [&_h1]:text-[#171717] [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-[#171717] [&_h3]:text-lg [&_h3]:font-semibold [&_h3]:text-[#171717] [&_p]:leading-8 [&_a]:text-[#B88A2A] [&_a]:font-medium [&_ul]:list-disc [&_ul]:pr-6 [&_ol]:list-decimal [&_ol]:pr-6 [&_li]:mb-2">
                    {!! $description !!}
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var wrapper = document.querySelector('[data-product-purchase]');

            if (!wrapper) {
                return;
            }

            var decreaseButton = wrapper.querySelector('[data-quantity-decrease]');
            var increaseButton = wrapper.querySelector('[data-quantity-increase]');
            var quantityInput = wrapper.querySelector('[data-quantity-value]');
            var totalPrice = wrapper.querySelector('[data-total-price]');
            var addButton = document.querySelector('[data-add-to-cart]');
            var messageBox = document.querySelector('[data-add-cart-message]');
            var stock = Number(wrapper.dataset.stock || 0);
            var unitPrice = Number(wrapper.dataset.unitPrice || 0);
            var productId = Number(wrapper.dataset.productId || 0);
            var cartAddUrl = wrapper.dataset.cartAddUrl;
            var cartUrl = wrapper.dataset.cartUrl;
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            var formatter = new Intl.NumberFormat('fa-IR');
            var quantity = stock > 0 ? 1 : 0;
            var isInCart = false;

            function update() {
                quantity = Math.max(stock > 0 ? 1 : 0, Math.min(quantity, stock));
                quantityInput.value = formatter.format(quantity);
                totalPrice.textContent = formatter.format(quantity * unitPrice);

                if (decreaseButton) {
                    decreaseButton.disabled = stock <= 0 || quantity <= 1;
                }

                if (increaseButton) {
                    increaseButton.disabled = stock <= 0 || quantity >= stock;
                }

                if (addButton && !isInCart) {
                    addButton.disabled = stock <= 0 || quantity < 1;
                }
            }

            function showMessage(message, type) {
                if (!messageBox) {
                    return;
                }

                messageBox.textContent = message;
                messageBox.className = 'mt-5 rounded-2xl border px-5 py-4 text-sm font-medium ' + (type === 'success'
                    ? 'bg-emerald-50 border-emerald-100 text-emerald-700'
                    : 'bg-red-50 border-red-100 text-red-600');
                messageBox.classList.remove('hidden');
            }

            function setLoading(isLoading) {
                if (!addButton || isInCart) {
                    return;
                }

                addButton.disabled = isLoading || stock <= 0 || quantity < 1;
                addButton.textContent = isLoading ? 'در حال افزودن...' : 'افزودن به سبد خرید';
            }

            function markAsInCart() {
                if (!addButton) {
                    return;
                }

                isInCart = true;
                addButton.disabled = false;
                addButton.textContent = 'رفتن به سبد خرید';
            }

            if (decreaseButton) {
                decreaseButton.addEventListener('click', function () {
                    quantity -= 1;
                    update();
                });
            }

            if (increaseButton) {
                increaseButton.addEventListener('click', function () {
                    if (quantity >= stock) {
                        showMessage('موجودی کافی نیست. حداکثر موجودی: ' + formatter.format(stock), 'error');
                        return;
                    }

                    quantity += 1;
                    update();
                });
            }

            if (addButton) {
                addButton.addEventListener('click', function () {
                    if (isInCart) {
                        if (cartUrl) {
                            window.location.href = cartUrl;
                        }
                        return;
                    }

                    if (quantity > stock) {
                        showMessage('موجودی کافی نیست. حداکثر موجودی: ' + formatter.format(stock), 'error');
                        update();
                        return;
                    }

                    setLoading(true);

                    fetch(cartAddUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    })
                        .then(function (response) {
                            return response.json().then(function (data) {
                                if (!response.ok) {
                                    throw data;
                                }
                                return data;
                            });
                        })
                        .then(function (data) {
                            showMessage(data.message || 'محصول به سبد خرید اضافه شد.', 'success');
                            markAsInCart();

                            if (window.KhanCart && typeof window.KhanCart.setCount === 'function') {
                                window.KhanCart.setCount(data.cart ? data.cart.total_items : (data.total_items || 0));
                            }
                        })
                        .catch(function (error) {
                            showMessage(error.message || 'خطا در افزودن محصول به سبد خرید.', 'error');
                            setLoading(false);
                        });
                });
            }

            update();
        });
    </script>
@endpush
