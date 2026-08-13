@extends('2khanonline.layout.main')

@section('title', 'پرداخت سفارش | Smokify | اسموکیفای')
@section('seo_robots', 'noindex,nofollow,noarchive')

@section('content')
    <section class="pt-6 lg:pt-8 pb-16 lg:pb-20">
        <div class="max-w-[720px] mx-auto px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-[#737373] mb-6" aria-label="breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-[#171717] transition-colors">خانه</a>
                <span class="text-[#D4D4D4]">/</span>
                <a href="{{ route('cart.index') }}" class="hover:text-[#171717] transition-colors">سبد خرید</a>
                <span class="text-[#D4D4D4]">/</span>
                <span class="text-[#171717] font-medium">پرداخت</span>
            </nav>

            @if ($errors->any())
                <div class="rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-medium text-red-600 mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Order Summary --}}
            <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-6 lg:p-8 shadow-[0_24px_70px_rgba(23,23,23,0.06)] mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-11 h-11 rounded-2xl bg-[#B88A2A]/10 flex items-center justify-center text-[#B88A2A]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                        </svg>
                    </span>
                    <div>
                        <h2 class="text-lg font-bold text-[#171717]">پرداخت سفارش #{{ $order->id }}</h2>
                        <p class="text-xs text-[#737373] mt-1">مبلغ قابل پرداخت</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-5 mb-6">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm text-[#737373]">مبلغ قابل پرداخت</span>
                        <strong class="text-2xl font-bold text-[#171717]">
                            {{ number_format($order->amount) }}
                            <span class="text-sm font-normal text-[#737373]">تومان</span>
                        </strong>
                    </div>
                </div>

                {{-- Card Info --}}
                @if ($card)
                    <div class="rounded-2xl border-2 border-dashed border-[#B88A2A]/30 bg-[#B88A2A]/5 p-6 mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-10 h-10 rounded-xl bg-[#B88A2A]/10 flex items-center justify-center text-[#B88A2A]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                                </svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-[#171717]">اطلاعات کارت بانکی</p>
                                <p class="text-xs text-[#737373]">لطفاً مبلغ را به کارت زیر واریز کنید</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-4 p-3 rounded-xl bg-white border border-[#E5E5E5]">
                                <span class="text-xs text-[#737373]">شماره کارت</span>
                                <strong class="text-base font-bold text-[#171717] tracking-wider" dir="ltr">{{ $card->card_number }}</strong>
                            </div>
                            <div class="flex items-center justify-between gap-4 p-3 rounded-xl bg-white border border-[#E5E5E5]">
                                <span class="text-xs text-[#737373]">به نام</span>
                                <strong class="text-sm font-bold text-[#171717]">{{ $card->card_holder_name }}</strong>
                            </div>
                        </div>
                    </div>

                    <p class="text-sm text-[#737373] leading-7 mb-6">
                        پس از واریز مبلغ <strong class="text-[#171717]">{{ number_format($order->amount) }} تومان</strong> به کارت فوق، تصویر فیش پرداخت خود را در زیر آپلود کنید.
                    </p>
                @else
                    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5 mb-6">
                        <p class="text-sm text-amber-700 font-medium">اطلاعات کارت بانکی ثبت نشده است. لطفاً با مدیر تماس بگیرید.</p>
                    </div>
                @endif
            </div>

            {{-- Receipt Upload --}}
            @if ($card)
                <div class="bg-white border border-[#E5E5E5] rounded-[24px] p-6 lg:p-8 shadow-[0_24px_70px_rgba(23,23,23,0.06)]">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-11 h-11 rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] flex items-center justify-center text-[#B88A2A]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-[#171717]">آپلود فیش پرداخت</h2>
                            <p class="text-xs text-[#737373] mt-1">تصویر فیش واریزی خود را ارسال کنید</p>
                        </div>
                    </div>

                    <form method="POST"
                          action="{{ route('payment.receipt', $order) }}"
                          enctype="multipart/form-data"
                          id="receipt-form">
                        @csrf

                        {{-- Upload Box --}}
                        <div class="mb-6">
                            <div
                                id="upload-box"
                                class="relative rounded-2xl border-2 border-dashed border-[#E5E5E5] bg-[#FAFAF9] p-8 text-center cursor-pointer hover:border-[#B88A2A] hover:bg-[#B88A2A]/5 transition-all duration-200"
                            >
                                <div id="upload-content">
                                    <div class="w-16 h-16 mx-auto rounded-2xl bg-white border border-[#E5E5E5] flex items-center justify-center text-[#A3A3A3] mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-[#171717] mb-1">فیش پرداخت را آپلود کنید</p>
                                    <p class="text-xs text-[#737373]">فرمت‌های مجاز: JPG، PNG، WebP — حداکثر ۵ مگابایت</p>
                                    <p class="text-xs text-[#A3A3A3] mt-2">کلیک کنید یا فایل را بکشید و رها کنید</p>
                                </div>

                                <div id="upload-preview" class="hidden">
                                    <div class="relative inline-block">
                                        <img id="preview-image" class="max-h-48 rounded-xl shadow-sm border border-[#E5E5E5]" alt="پیش‌نمایش فیش">
                                        <button
                                            type="button"
                                            id="remove-preview"
                                            class="absolute -top-2 -left-2 w-7 h-7 rounded-full bg-red-500 text-white flex items-center justify-center shadow-md hover:bg-red-600 transition-colors"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p id="file-name" class="text-xs text-[#737373] mt-3 font-medium"></p>
                                </div>

                                <input
                                    type="file"
                                    name="receipt"
                                    id="receipt-input"
                                    accept="image/jpeg,image/jpg,image/png,image/webp"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                >
                            </div>
                            @error('receipt')
                            <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            id="submit-btn"
                            disabled
                            class="w-full rounded-2xl bg-[#171717] px-6 py-4 text-sm font-semibold text-white hover:bg-[#2a2a2a] disabled:opacity-45 disabled:cursor-not-allowed transition-colors"
                        >
                            ارسال فیش و ثبت سفارش
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var uploadBox = document.getElementById('upload-box');
            var uploadContent = document.getElementById('upload-content');
            var uploadPreview = document.getElementById('upload-preview');
            var previewImage = document.getElementById('preview-image');
            var removeButton = document.getElementById('remove-preview');
            var fileName = document.getElementById('file-name');
            var receiptInput = document.getElementById('receipt-input');
            var submitBtn = document.getElementById('submit-btn');

            if (!uploadBox || !receiptInput) return;

            function showPreview(file) {
                if (!file || !file.type || !file.type.startsWith('image/')) return;

                var url = URL.createObjectURL(file);
                previewImage.src = url;
                previewImage.onload = function () { URL.revokeObjectURL(url); };
                fileName.textContent = file.name;
                uploadContent.classList.add('hidden');
                uploadPreview.classList.remove('hidden');
                submitBtn.disabled = false;
            }

            function resetUpload() {
                receiptInput.value = '';
                previewImage.src = '';
                fileName.textContent = '';
                uploadContent.classList.remove('hidden');
                uploadPreview.classList.add('hidden');
                submitBtn.disabled = true;
            }

            receiptInput.addEventListener('change', function () {
                var file = this.files && this.files[0];
                if (file) {
                    showPreview(file);
                } else {
                    resetUpload();
                }
            });

            if (removeButton) {
                removeButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    resetUpload();
                });
            }

            uploadBox.addEventListener('dragover', function (e) {
                e.preventDefault();
                uploadBox.classList.add('border-[#B88A2A]', 'bg-[#B88A2A]/5');
            });

            uploadBox.addEventListener('dragleave', function (e) {
                e.preventDefault();
                uploadBox.classList.remove('border-[#B88A2A]', 'bg-[#B88A2A]/5');
            });

            uploadBox.addEventListener('drop', function (e) {
                e.preventDefault();
                uploadBox.classList.remove('border-[#B88A2A]', 'bg-[#B88A2A]/5');
                var files = e.dataTransfer && e.dataTransfer.files;
                if (files && files[0]) {
                    var dt = new DataTransfer();
                    dt.items.add(files[0]);
                    receiptInput.files = dt.files;
                    showPreview(files[0]);
                }
            });
        });
    </script>
@endpush
