@extends('2khanonline.layout.main')

@section('title', 'سبد خرید | دو خان')

@section('content')
    <section class="pt-6 lg:pt-8 pb-16 lg:pb-20">
        <div class="max-w-[1260px] mx-auto px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-[#737373] mb-6" aria-label="breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#171717] transition-colors">خانه</a>
                <span class="text-[#D4D4D4]">/</span>
                <span class="text-[#171717] font-medium">سبد خرید</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-8">
                <div>
                    <span class="inline-flex text-xs font-medium text-[#B88A2A] bg-[#B88A2A]/10 px-3 py-1 rounded-full mb-3">سبد خرید شما</span>
                    <h1 class="text-2xl lg:text-[36px] font-bold leading-tight text-[#171717]">مرور و تکمیل سفارش</h1>
                    <p class="text-sm text-[#737373] mt-3">تعداد محصولات را تغییر دهید، آیتم‌ها را حذف کنید یا سبد خرید را خالی کنید.</p>
                </div>

                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-[#E5E5E5] bg-white px-5 py-3 text-sm font-semibold text-[#171717] hover:border-[#d4d4d4] hover:-translate-y-0.5 transition-all shadow-sm">
                    بازگشت به محصولات
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            @if (session('payment_error') || $errors->any())
                <div class="rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-medium text-red-600 mb-6">
                    {{ session('payment_error') ?: $errors->first() }}
                </div>
            @endif

            <div class="hidden rounded-2xl border px-5 py-4 text-sm font-medium mb-6" data-cart-alert></div>

            <div class="grid lg:grid-cols-[minmax(0,1fr)_360px] gap-6 lg:gap-8 items-start" data-cart-page
                data-items-url="{{ route('cart.items') }}"
                data-update-base="{{ url('/cart/update') }}"
                data-remove-base="{{ url('/cart/remove') }}"
                data-clear-url="{{ route('cart.clear') }}"
                data-checkout-url="{{ route('checkout.start') }}"
                data-checkout-continue-url="{{ route('checkout.continue') }}"
                data-is-authenticated="{{ auth()->check() ? '1' : '0' }}"
                data-user-address="{{ auth()->user()?->address ?? '' }}"
            >
                <div class="space-y-4" data-cart-items>
                    <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-8 text-center shadow-[0_24px_70px_rgba(23,23,23,0.05)]" data-cart-loading>
                        <div class="inline-block w-7 h-7 border-2 border-[#E5E5E5] border-t-[#171717] rounded-full animate-spin"></div>
                        <p class="text-sm text-[#737373] mt-4">در حال دریافت سبد خرید...</p>
                    </div>
                </div>

                <aside class="lg:sticky lg:top-24">
                    <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-6 shadow-[0_24px_70px_rgba(23,23,23,0.06)]">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="w-11 h-11 rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] flex items-center justify-center text-[#B88A2A]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                                </svg>
                            </span>
                            <div>
                                <h2 class="text-lg font-bold">خلاصه سبد خرید</h2>
                                <p class="text-xs text-[#737373] mt-1"><span data-cart-summary-count>۰</span> کالا در سبد شما</p>
                            </div>
                        </div>

                        <div class="space-y-4 rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-5">
                            <div class="flex items-center justify-between gap-4">
                                <span class="text-sm text-[#737373]">جمع کل</span>
                                <strong class="text-xl font-bold text-[#171717]"><span data-cart-summary-total>۰</span> <span class="text-xs font-normal text-[#737373]">تومان</span></strong>
                            </div>
                        </div>

                        <button type="button" class="mt-5 w-full rounded-2xl bg-[#171717] px-6 py-4 text-sm font-semibold text-white hover:bg-[#2a2a2a] disabled:opacity-45 disabled:cursor-not-allowed transition-colors" disabled data-checkout-button>
                            ادامه فرایند خرید
                        </button>

                        <button type="button" class="mt-3 w-full rounded-2xl border border-red-100 bg-red-50 px-6 py-3 text-sm font-semibold text-red-600 hover:bg-red-100 disabled:opacity-45 disabled:cursor-not-allowed transition-colors" disabled data-clear-cart>
                            خالی کردن سبد خرید
                        </button>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <div class="fixed inset-0 z-50 hidden items-center justify-center p-4" data-address-modal aria-hidden="true">
        <div class="absolute inset-0 bg-[#171717]/45 backdrop-blur-[2px]" data-address-modal-overlay></div>
        <div class="relative w-full max-w-lg rounded-[24px] border border-[#E5E5E5] bg-white p-6 shadow-[0_24px_70px_rgba(23,23,23,0.18)]" role="dialog" aria-modal="true" aria-labelledby="checkout-address-title">
            <div class="flex items-start justify-between gap-4 mb-5">
                <div>
                    <h2 id="checkout-address-title" class="text-lg font-bold text-[#171717]">آدرس تحویل</h2>
                    <p class="text-sm text-[#737373] mt-2 leading-7">آدرس کامل تحویل سفارش را وارد کنید. این آدرس برای دفعات بعد در همین مرورگر ذخیره می‌شود.</p>
                </div>
                <button type="button" class="shrink-0 w-10 h-10 rounded-xl border border-[#E5E5E5] text-[#737373] hover:bg-[#FAFAF9] transition-colors" data-address-modal-close aria-label="بستن">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('checkout.start') }}" data-checkout-form>
                @csrf
                <label for="checkout-address" class="block text-sm font-semibold text-[#171717] mb-2">آدرس</label>
                <textarea
                    id="checkout-address"
                    name="address"
                    rows="5"
                    required
                    minlength="10"
                    maxlength="2000"
                    placeholder="مثال: تهران، خیابان ...، پلاک ...، واحد ..."
                    class="w-full rounded-2xl border border-[#E5E5E5] bg-[#FAFAF9] px-4 py-3 text-sm text-[#171717] leading-7 placeholder:text-[#A3A3A3] focus:outline-none focus:border-[#B88A2A] focus:ring-2 focus:ring-[#B88A2A]/15 resize-y"
                    data-checkout-address
                ></textarea>
                <p class="hidden text-xs text-red-600 mt-2" data-address-error></p>

                <div class="flex flex-col-reverse sm:flex-row gap-3 mt-5">
                    <button type="button" class="w-full sm:w-auto rounded-2xl border border-[#E5E5E5] px-5 py-3 text-sm font-semibold text-[#171717] hover:bg-[#FAFAF9] transition-colors" data-address-modal-close>
                        انصراف
                    </button>
                    <button type="submit" class="w-full sm:flex-1 rounded-2xl bg-[#171717] px-5 py-3 text-sm font-semibold text-white hover:bg-[#2a2a2a] transition-colors" data-address-submit>
                        تأیید و ادامه پرداخت
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var page = document.querySelector('[data-cart-page]');

            if (!page) {
                return;
            }

            var itemsContainer = page.querySelector('[data-cart-items]');
            var alertBox = document.querySelector('[data-cart-alert]');
            var summaryCount = document.querySelector('[data-cart-summary-count]');
            var summaryTotal = document.querySelector('[data-cart-summary-total]');
            var clearButton = document.querySelector('[data-clear-cart]');
            var checkoutButton = document.querySelector('[data-checkout-button]');
            var addressModal = document.querySelector('[data-address-modal]');
            var addressInput = document.querySelector('[data-checkout-address]');
            var addressError = document.querySelector('[data-address-error]');
            var checkoutForm = document.querySelector('[data-checkout-form]');
            var formatter = new Intl.NumberFormat('fa-IR');
            var csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            var cartState = { items: [], total: 0, total_items: 0 };
            var ADDRESS_STORAGE_KEY = 'khan_checkout_address';
            var isAuthenticated = page.dataset.isAuthenticated === '1';

            function getSavedAddress() {
                var userAddress = (page.dataset.userAddress || '').trim();
                if (userAddress) {
                    return userAddress;
                }

                try {
                    return localStorage.getItem(ADDRESS_STORAGE_KEY) || '';
                } catch (error) {
                    return '';
                }
            }

            function saveAddress(address) {
                try {
                    localStorage.setItem(ADDRESS_STORAGE_KEY, address);
                } catch (error) {
                    // Ignore storage failures (private mode, quota, etc).
                }
            }

            function openAddressModal() {
                if (!addressModal || !addressInput) {
                    return;
                }

                addressInput.value = getSavedAddress();
                if (addressError) {
                    addressError.classList.add('hidden');
                    addressError.textContent = '';
                }

                addressModal.classList.remove('hidden');
                addressModal.classList.add('flex');
                addressModal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
                window.setTimeout(function () {
                    addressInput.focus();
                }, 40);
            }

            function closeAddressModal() {
                if (!addressModal) {
                    return;
                }

                addressModal.classList.add('hidden');
                addressModal.classList.remove('flex');
                addressModal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            }

            function request(url, options) {
                return fetch(url, Object.assign({
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }, options || {})).then(function (response) {
                    return response.json().then(function (data) {
                        if (!response.ok) {
                            throw data;
                        }

                        return data;
                    });
                });
            }

            function showAlert(message, type) {
                if (!alertBox) {
                    return;
                }

                alertBox.textContent = message;
                alertBox.className = 'rounded-2xl border px-5 py-4 text-sm font-medium mb-6 ' + (type === 'success'
                    ? 'bg-emerald-50 border-emerald-100 text-emerald-700'
                    : 'bg-red-50 border-red-100 text-red-600');
                alertBox.classList.remove('hidden');

                window.clearTimeout(showAlert.timeout);
                showAlert.timeout = window.setTimeout(function () {
                    alertBox.classList.add('hidden');
                }, 4200);
            }

            function placeholderImage() {
                return '<div class="absolute inset-0 flex items-center justify-center text-[#A3A3A3]"><svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Z" /></svg></div>';
            }

            function emptyState() {
                return '<div class="bg-white border border-[#E5E5E5] rounded-[24px] p-8 lg:p-12 text-center shadow-[0_24px_70px_rgba(23,23,23,0.05)]">' +
                    '<div class="w-20 h-20 mx-auto rounded-3xl bg-[#FAFAF9] border border-[#E5E5E5] flex items-center justify-center text-[#B88A2A] mb-5"><svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" /></svg></div>' +
                    '<h2 class="text-xl font-bold mb-2">سبد خرید شما خالی است</h2>' +
                    '<p class="text-sm text-[#737373] leading-7 mb-6">محصولات مورد علاقه‌تان را انتخاب کنید و از صفحه محصول به سبد خرید اضافه کنید.</p>' +
                    '<a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-2xl bg-[#171717] px-6 py-3 text-sm font-semibold text-white hover:bg-[#2a2a2a] transition-colors">مشاهده محصولات</a>' +
                    '</div>';
            }

            function itemCard(item) {
                var image = item.image
                    ? '<img src="' + item.image + '" alt="' + item.name + '" class="absolute inset-0 w-full h-full object-contain p-3">'
                    : placeholderImage();
                var decreaseDisabled = item.quantity <= 1 ? 'disabled' : '';
                var increaseDisabled = item.quantity >= item.stock ? 'disabled' : '';

                return '<article class="group bg-white border border-[#E5E5E5] rounded-[24px] p-4 lg:p-5 shadow-[0_24px_70px_rgba(23,23,23,0.05)] hover:border-[#d4d4d4] hover:-translate-y-0.5 transition-all" data-cart-item="' + item.id + '">' +
                    '<div class="grid sm:grid-cols-[112px_minmax(0,1fr)] lg:grid-cols-[128px_minmax(0,1fr)] gap-4 lg:gap-5">' +
                        '<a href="' + item.url + '" class="relative block w-full aspect-square rounded-2xl overflow-hidden bg-[#FAFAF9] border border-[#E5E5E5] shrink-0">' + image + '</a>' +
                        '<div class="min-w-0 flex flex-col gap-4">' +
                            '<div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">' +
                                '<div class="min-w-0">' +
                                    '<span class="text-xs text-[#737373]">محصول:</span>' +
                                    '<a href="' + item.url + '" class="block text-lg font-bold text-[#171717] mt-1 hover:text-[#B88A2A] transition-colors truncate">' + item.name + '</a>' +
                                    '<div class="flex flex-wrap gap-2 mt-3">' +
                                        '<span class="inline-flex text-xs font-medium text-[#B88A2A] bg-[#B88A2A]/10 px-3 py-1 rounded-full">دسته‌بندی: ' + (item.category || 'نامشخص') + '</span>' +
                                        '<span class="inline-flex text-xs font-medium text-[#525252] bg-[#FAFAF9] border border-[#E5E5E5] px-3 py-1 rounded-full">برند: ' + (item.brand || 'نامشخص') + '</span>' +
                                    '</div>' +
                                '</div>' +
                                '<button type="button" class="inline-flex items-center justify-center gap-1 rounded-xl border border-red-100 bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100 transition-colors" data-remove-item="' + item.id + '">حذف</button>' +
                            '</div>' +
                            '<div class="grid md:grid-cols-3 gap-4 rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-4">' +
                                '<div><span class="block text-xs text-[#737373] mb-1">قیمت واحد:</span><strong class="text-sm lg:text-base font-bold">' + formatter.format(item.price) + ' <span class="text-[11px] font-normal text-[#737373]">تومان</span></strong></div>' +
                                '<div><span class="block text-xs text-[#737373] mb-1">تعداد:</span><div class="inline-flex items-center rounded-2xl border border-[#E5E5E5] bg-white p-1 shadow-sm"><button type="button" class="w-9 h-9 rounded-xl flex items-center justify-center text-lg font-semibold hover:bg-[#FAFAF9] disabled:opacity-35 disabled:cursor-not-allowed transition-colors" data-update-quantity="' + item.id + '" data-quantity="' + (item.quantity - 1) + '" ' + decreaseDisabled + '>−</button><span class="w-11 h-9 flex items-center justify-center text-sm font-bold">' + formatter.format(item.quantity) + '</span><button type="button" class="w-9 h-9 rounded-xl flex items-center justify-center text-lg font-semibold hover:bg-[#FAFAF9] disabled:opacity-35 disabled:cursor-not-allowed transition-colors" data-update-quantity="' + item.id + '" data-quantity="' + (item.quantity + 1) + '" ' + increaseDisabled + '>+</button></div><span class="block text-[11px] text-[#737373] mt-2">موجودی: ' + formatter.format(item.stock) + '</span></div>' +
                                '<div><span class="block text-xs text-[#737373] mb-1">جمع:</span><strong class="text-base lg:text-lg font-bold text-[#171717]">' + formatter.format(item.subtotal) + ' <span class="text-[11px] font-normal text-[#737373]">تومان</span></strong></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</article>';
            }

            function applyCart(data) {
                cartState = data.cart || data;
                renderCart();

                if (window.KhanCart && typeof window.KhanCart.setCount === 'function') {
                    window.KhanCart.setCount(cartState.total_items || 0);
                }
            }

            function renderCart() {
                var items = cartState.items || [];
                itemsContainer.innerHTML = items.length ? items.map(itemCard).join('') : emptyState();

                summaryCount.textContent = formatter.format(cartState.total_items || 0);
                summaryTotal.textContent = formatter.format(cartState.total || 0);
                clearButton.disabled = items.length === 0;
                checkoutButton.disabled = items.length === 0;
            }

            function loadCart() {
                request(page.dataset.itemsUrl).then(applyCart).catch(function () {
                    itemsContainer.innerHTML = emptyState();
                    showAlert('خطا در دریافت سبد خرید. لطفاً دوباره تلاش کنید.', 'error');
                });
            }

            itemsContainer.addEventListener('click', function (event) {
                var quantityButton = event.target.closest('[data-update-quantity]');
                var removeButton = event.target.closest('[data-remove-item]');

                if (quantityButton) {
                    var quantity = Number(quantityButton.dataset.quantity || 1);
                    var itemId = quantityButton.dataset.updateQuantity;
                    quantityButton.disabled = true;

                    request(page.dataset.updateBase + '/' + itemId, {
                        method: 'PATCH',
                        body: JSON.stringify({ quantity: quantity })
                    }).then(function (data) {
                        applyCart(data);
                    }).catch(function (error) {
                        showAlert(error.message || 'امکان بروزرسانی تعداد وجود ندارد.', 'error');
                        renderCart();
                    });
                }

                if (removeButton) {
                    var removeId = removeButton.dataset.removeItem;
                    removeButton.disabled = true;

                    request(page.dataset.removeBase + '/' + removeId, {
                        method: 'DELETE'
                    }).then(function (data) {
                        applyCart(data);
                        showAlert(data.message || 'محصول حذف شد.', 'success');
                    }).catch(function (error) {
                        showAlert(error.message || 'امکان حذف محصول وجود ندارد.', 'error');
                        renderCart();
                    });
                }
            });

            clearButton.addEventListener('click', function () {
                clearButton.disabled = true;

                request(page.dataset.clearUrl, {
                    method: 'DELETE'
                }).then(function (data) {
                    applyCart(data);
                    showAlert(data.message || 'سبد خرید خالی شد.', 'success');
                }).catch(function (error) {
                    showAlert(error.message || 'امکان خالی کردن سبد خرید وجود ندارد.', 'error');
                    renderCart();
                });
            });

            checkoutButton.addEventListener('click', function () {
                if (checkoutButton.disabled) {
                    return;
                }

                if (!isAuthenticated) {
                    window.location.href = page.dataset.checkoutContinueUrl || '/checkout';
                    return;
                }

                openAddressModal();
            });

            if (addressModal) {
                addressModal.querySelectorAll('[data-address-modal-close], [data-address-modal-overlay]').forEach(function (element) {
                    element.addEventListener('click', closeAddressModal);
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && !addressModal.classList.contains('hidden')) {
                        closeAddressModal();
                    }
                });
            }

            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function (event) {
                    var address = (addressInput?.value || '').trim();

                    if (address.length < 10) {
                        event.preventDefault();
                        if (addressError) {
                            addressError.textContent = 'لطفاً آدرس تحویل را کامل‌تر وارد کنید.';
                            addressError.classList.remove('hidden');
                        }
                        addressInput?.focus();
                        return;
                    }

                    if (addressInput) {
                        addressInput.value = address;
                    }

                    saveAddress(address);

                    var submitButton = checkoutForm.querySelector('[data-address-submit]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'در حال انتقال به درگاه...';
                    }
                });
            }

            loadCart();
        });
    </script>
@endpush
