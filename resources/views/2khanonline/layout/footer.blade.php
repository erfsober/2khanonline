<footer class="bg-white border-t border-[#E5E5E5]">
    <div class="max-w-[1260px] mx-auto px-6 lg:px-8">

        {{-- Footer Top --}}
        <div class="py-12 flex flex-col lg:flex-row items-start justify-between gap-10">
            {{-- Brand --}}
            <div class="max-w-xs">
                <a href="/" class="flex items-center gap-2 mb-3">
                    <span class="text-lg font-bold">دو خان</span>
                    <span class="w-2 h-2 rounded-full bg-[#B88A2A]"></span>
                </a>
                <p class="text-sm text-[#737373] leading-7">فروشگاه آنلاین محصولات تنباکو با بهترین کیفیت و ارسال سریع به سراسر کشور.</p>
            </div>

            {{-- Links --}}
            <div class="flex gap-16 lg:gap-24">
                <div>
                    <h4 class="text-sm font-semibold mb-4">فروشگاه</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">سیگار</a></li>
                        <li><a href="#" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">سیگار برگ</a></li>
                        <li><a href="#" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">ویپ</a></li>
                        <li><a href="#" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">لوازم جانبی</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-semibold mb-4">دسترسی</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">برندها</a></li>
                        <li><a href="{{ route('pages.about-us') }}" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">درباره ما</a></li>
                        <li><a href="{{ route('pages.contact-us') }}" class="text-sm text-[#737373] hover:text-[#171717] transition-colors">تماس با ما</a></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Footer Bottom --}}
        <div class="py-6 border-t border-[#E5E5E5] flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-xs text-[#737373]">© ۲۰۲۶ دو خان. تمامی حقوق محفوظ است.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="text-xs text-[#737373] hover:text-[#171717] transition-colors">حریم خصوصی</a>
                <span class="text-[#E5E5E5]">|</span>
                <a href="#" class="text-xs text-[#737373] hover:text-[#171717] transition-colors">قوانین</a>
            </div>
        </div>
    </div>
</footer>
