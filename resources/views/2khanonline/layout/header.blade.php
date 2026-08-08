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
            <button class="p-2 text-[#737373] hover:text-[#171717] transition-colors" aria-label="جستجو">
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
            <button class="p-2 text-[#737373] hover:text-[#171717] transition-colors relative" aria-label="سبد خرید">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span class="absolute -top-0.5 -left-0.5 w-4 h-4 bg-[#171717] text-white text-[10px] font-medium rounded-full flex items-center justify-center">۰</span>
            </button>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dropdown = document.querySelector('[data-user-dropdown]');

        if (!dropdown) {
            return;
        }

        var button = dropdown.querySelector('[data-user-dropdown-button]');
        var menu = dropdown.querySelector('[data-user-dropdown-menu]');

        if (!button || !menu) {
            return;
        }

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
    });
</script>
