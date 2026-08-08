<header class="bg-white border-b border-[#E5E5E5] sticky top-0 z-50">
    <div class="max-w-[1260px] mx-auto px-6 lg:px-8 flex items-center justify-between h-[72px]">

        {{-- Mobile Hamburger --}}
        <div class="lg:hidden">
            <button class="p-2 -mr-2" aria-label="منو">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        {{-- Logo (right side in RTL) --}}
        <a href="/" class="flex items-center gap-2 shrink-0">
            <span class="text-xl font-bold tracking-tight">دو خان</span>
            <span class="w-2 h-2 rounded-full bg-[#B88A2A] mt-0.5"></span>
        </a>

        {{-- Center Navigation --}}
        <nav class="hidden lg:flex items-center gap-8">
            <a href="/" class="text-sm font-medium text-black border-b-2 border-[#B88A2A] pb-1">خانه</a>
            <a href="#" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">فروشگاه</a>
            <a href="#" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">برندها</a>
            <a href="#" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">سیگار</a>
            <a href="#" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">سیگار برگ</a>
            <a href="#" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">ویپ</a>
            <a href="{{ route('pages.about-us') }}" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">درباره ما</a>
            <a href="{{ route('pages.contact-us') }}" class="text-sm font-medium text-black hover:text-[#171717] transition-colors pb-1 border-b-2 border-transparent">تماس با ما</a>
        </nav>

        {{-- Icons (left side in RTL) --}}
        <div class="flex items-center gap-4">
            {{-- Search --}}
            <button class="p-2 text-[#737373] hover:text-[#171717] transition-colors" aria-label="جستجو" data-search-open>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
            {{-- User --}}
            <div class="relative hidden sm:block" data-user-dropdown>
                <button
                    type="button"
                    class="p-2 text-[#737373] hover:text-[#171717] transition-colors"
                    aria-label="حساب کاربری"
                    aria-expanded="false"
                    data-user-dropdown-button
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </button>

                <div
                    class="absolute left-0 top-full mt-3 hidden w-56 rounded-2xl border border-[#E5E5E5] bg-white p-3 shadow-[0_18px_45px_rgba(23,23,23,0.10)]"
                    data-user-dropdown-menu
                >
                    @auth
                        <div class="mb-3 rounded-xl bg-[#FAFAF9] px-4 py-3">
                            <span class="block text-xs text-[#737373] mb-1">شماره موبایل</span>
                            <strong class="block text-sm font-semibold text-[#171717]" dir="ltr">{{ auth()->user()->phone }}</strong>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full rounded-xl border border-red-100 bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-100 transition-colors">
                                خروج
                            </button>
                        </form>
                    @else
                        <a href="{{ route('auth.show') }}" class="flex w-full items-center justify-center rounded-xl bg-[#171717] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#2a2a2a] transition-colors">
                            ورود
                        </a>
                    @endauth
                </div>
            </div>
            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="p-2 text-[#737373] hover:text-[#171717] transition-colors relative" aria-label="سبد خرید">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span class="absolute -top-0.5 -left-0.5 min-w-4 h-4 px-1 bg-[#171717] text-white text-[10px] font-medium rounded-full flex items-center justify-center" data-cart-count>۰</span>
            </a>
        </div>
    </div>
</header>

{{-- Search Modal --}}
<div class="fixed inset-0 z-[60] hidden" data-search-modal>
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black/50" data-search-overlay></div>

    {{-- Modal Content --}}
    <div class="relative w-full max-w-[640px] mx-auto mt-20 px-4">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            {{-- Search Input --}}
            <div class="flex items-center gap-3 px-5 py-4 border-b border-[#E5E5E5]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#737373] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input
                    type="text"
                    placeholder="جستجوی محصول..."
                    class="flex-1 text-sm outline-none placeholder:text-[#a3a3a3]"
                    data-search-input
                    autocomplete="off"
                >
                <button class="text-[#737373] hover:text-[#171717] transition-colors" data-search-close>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Search Results --}}
            <div class="max-h-[400px] overflow-y-auto" data-search-results>
                {{-- Default state --}}
                <div class="p-6 text-center text-sm text-[#737373]" data-search-default>
                    عبارت مورد نظر خود را تایپ کنید
                </div>

                {{-- Loading --}}
                <div class="p-6 text-center hidden" data-search-loading>
                    <div class="inline-block w-5 h-5 border-2 border-[#E5E5E5] border-t-[#171717] rounded-full animate-spin"></div>
                </div>

                {{-- Results container --}}
                <div class="hidden" data-search-results-list></div>

                {{-- No results --}}
                <div class="p-6 text-center text-sm text-[#737373] hidden" data-search-noresults>
                    محصولی یافت نشد
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ===== Cart Count =====
        var cartCount = document.querySelector('[data-cart-count]');
        var cartFormatter = new Intl.NumberFormat('fa-IR');

        window.KhanCart = {
            setCount: function (count) {
                if (cartCount) {
                    cartCount.textContent = cartFormatter.format(Math.max(0, Number(count || 0)));
                }
            },
            refresh: function () {
                return fetch('{{ route('cart.items') }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        window.KhanCart.setCount(data.total_items || 0);
                        return data;
                    })
                    .catch(function () {
                        window.KhanCart.setCount(0);
                    });
            }
        };

        window.KhanCart.refresh();

        // ===== User Dropdown =====
        var dropdown = document.querySelector('[data-user-dropdown]');

        if (dropdown) {
            var button = dropdown.querySelector('[data-user-dropdown-button]');
            var menu = dropdown.querySelector('[data-user-dropdown-menu]');

            if (button && menu) {
                function closeMenu() {
                    menu.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                }

                button.addEventListener('click', function (event) {
                    event.stopPropagation();
                    var isOpen = !menu.classList.contains('hidden');

                    menu.classList.toggle('hidden', isOpen);
                    button.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
                });

                menu.addEventListener('click', function (event) {
                    event.stopPropagation();
                });

                document.addEventListener('click', closeMenu);
                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeMenu();
                    }
                });
            }
        }

        // ===== Search Modal =====
        var searchModal = document.querySelector('[data-search-modal]');
        var searchOverlay = document.querySelector('[data-search-overlay]');
        var searchOpenBtn = document.querySelector('[data-search-open]');
        var searchCloseBtn = document.querySelector('[data-search-close]');
        var searchInput = document.querySelector('[data-search-input]');
        var searchDefault = document.querySelector('[data-search-default]');
        var searchLoading = document.querySelector('[data-search-loading]');
        var searchResultsList = document.querySelector('[data-search-results-list]');
        var searchNoResults = document.querySelector('[data-search-noresults]');

        var searchTimeout = null;

        function openSearch() {
            searchModal.classList.remove('hidden');
            setTimeout(function() {
                searchInput.focus();
            }, 100);
        }

        function closeSearch() {
            searchModal.classList.add('hidden');
            searchInput.value = '';
            resetSearchResults();
        }

        function resetSearchResults() {
            searchDefault.classList.remove('hidden');
            searchLoading.classList.add('hidden');
            searchResultsList.classList.add('hidden');
            searchResultsList.innerHTML = '';
            searchNoResults.classList.add('hidden');
        }

        function showLoading() {
            searchDefault.classList.add('hidden');
            searchLoading.classList.remove('hidden');
            searchResultsList.classList.add('hidden');
            searchNoResults.classList.add('hidden');
        }

        function showNoResults() {
            searchDefault.classList.add('hidden');
            searchLoading.classList.add('hidden');
            searchResultsList.classList.add('hidden');
            searchNoResults.classList.remove('hidden');
        }

        function showResults(products) {
            searchDefault.classList.add('hidden');
            searchLoading.classList.add('hidden');
            searchNoResults.classList.add('hidden');
            searchResultsList.classList.remove('hidden');
            searchResultsList.innerHTML = '';

            products.forEach(function(product) {
                var item = document.createElement('a');
                item.href = product.url;
                item.className = 'flex items-center gap-4 px-5 py-3 hover:bg-[#FAFAF9] transition-colors border-b border-[#F5F5F5] last:border-0';

                var imageHtml = product.image
                    ? '<img src="' + product.image + '" alt="' + product.name + '" class="w-14 h-14 rounded-lg object-cover bg-[#FAFAF9]">'
                    : '<div class="w-14 h-14 rounded-lg bg-[#FAFAF9] flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#a3a3a3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" /></svg></div>';

                item.innerHTML =
                    imageHtml +
                    '<div class="flex-1 min-w-0">' +
                        '<h4 class="text-sm font-medium truncate">' + product.name + '</h4>' +
                        '<p class="text-xs text-[#737373] mt-1">' + product.price + ' تومان</p>' +
                    '</div>' +
                    '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#a3a3a3] shrink-0 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>';

                searchResultsList.appendChild(item);
            });
        }

        function performSearch(query) {
            if (query.length < 2) {
                resetSearchResults();
                return;
            }

            showLoading();

            fetch('/api/search?q=' + encodeURIComponent(query), {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.length === 0) {
                    showNoResults();
                } else {
                    showResults(data);
                }
            })
            .catch(function() {
                showNoResults();
            });
        }

        // Event listeners
        if (searchOpenBtn) {
            searchOpenBtn.addEventListener('click', openSearch);
        }

        if (searchCloseBtn) {
            searchCloseBtn.addEventListener('click', closeSearch);
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', closeSearch);
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                var query = this.value.trim();

                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }

                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 300);
            });
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !searchModal.classList.contains('hidden')) {
                closeSearch();
            }
            // Ctrl+K or Cmd+K to open search
            if ((event.ctrlKey || event.metaKey) && event.key === 'k') {
                event.preventDefault();
                openSearch();
            }
        });
    });
</script>
