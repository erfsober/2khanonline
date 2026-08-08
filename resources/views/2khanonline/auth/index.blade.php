<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ورود به حساب کاربری | دو خان</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Vazirmatn', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#FAFAF9] text-[#171717]">
@php
    $enteredPhone = old('phone', $phone ?? session('phone') ?? session('auth_phone') ?? '');
    $requestedStep = old('step', $step ?? session('auth_step') ?? null);
    $otpError = $errors->first('otp') ?: $errors->first('code');
    $resendSeconds = (int) session('otp_resend_seconds', 0);
    $showOtpStep = $requestedStep === 'otp' || $errors->has('otp') || $errors->has('code') || $errors->has('resend');
@endphp

<main class="min-h-screen flex items-center justify-center px-5 py-8 sm:px-6">
    <section class="w-full max-w-[460px]">
        <div class="mb-7 text-center">
            <a href="/" class="inline-flex items-center justify-center gap-2 mb-5">
                <span class="text-2xl font-bold tracking-tight">دو خان</span>
                <span class="w-2.5 h-2.5 rounded-full bg-[#B88A2A]"></span>
            </a>
            <h1 class="text-2xl font-bold mb-2">ورود به حساب کاربری</h1>
            <p class="text-sm leading-7 text-[#737373]">شماره موبایل خود را وارد کنید و با کد یکبارمصرف وارد شوید.</p>
        </div>

        <div class="rounded-[24px] border border-[#E5E5E5] bg-white shadow-[0_24px_70px_rgba(23,23,23,0.07)]">
            <div class="p-6 sm:p-8 border-b border-[#E5E5E5]">
                <div class="flex items-center gap-3" aria-hidden="true">
                    <span data-step-indicator="phone" class="h-1.5 flex-1 rounded-full bg-[#171717]"></span>
                    <span data-step-indicator="otp" class="h-1.5 flex-1 rounded-full {{ $showOtpStep ? 'bg-[#171717]' : 'bg-[#E5E5E5]' }}"></span>
                </div>
            </div>

            @if (session('status'))
                <div class="mx-6 sm:mx-8 mt-6 rounded-xl border border-[#B88A2A]/25 bg-[#B88A2A]/10 px-4 py-3 text-sm leading-6 text-[#7A5B18]">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any() && ! $errors->has('phone') && ! $otpError && ! $errors->has('resend'))
                <div class="mx-6 sm:mx-8 mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm leading-6 text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="p-6 sm:p-8">
                <form
                    id="phone-form"
                    action="{{ route('auth.phone') }}"
                    method="POST"
                    class="space-y-5 {{ $showOtpStep ? 'hidden' : '' }}"
                    novalidate
                >
                    @csrf
                    <input type="hidden" name="step" value="phone">

                    <div>
                        <label for="phone" class="block text-sm font-semibold mb-2">شماره موبایل</label>
                        <div class="relative">
                            <input
                                id="phone"
                                name="phone"
                                type="tel"
                                inputmode="numeric"
                                autocomplete="tel"
                                value="{{ $enteredPhone }}"
                                placeholder="مثلاً ۰۹۳۸۷۵۱۱۷۴۸"
                                aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                                aria-describedby="phone-help {{ $errors->has('phone') ? 'phone-error' : '' }}"
                                class="w-full h-12 rounded-xl border {{ $errors->has('phone') ? 'border-red-300 bg-red-50/50' : 'border-[#E5E5E5] bg-white' }} px-4 text-sm text-[#171717] placeholder:text-[#a3a3a3] focus:outline-none focus:border-[#171717] focus:ring-4 focus:ring-[#171717]/5 transition-all"
                                dir="ltr"
                            >
                        </div>
                        @error('phone')
                            <p id="phone-error" class="mt-2 text-xs leading-6 text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl bg-[#171717] px-5 text-sm font-semibold text-white hover:bg-[#2a2a2a] disabled:cursor-not-allowed disabled:opacity-70 transition-colors"
                        data-loading-button
                        data-loading-text="در حال ارسال کد..."
                    >
                        <svg data-loading-spinner class="hidden w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                        </svg>
                        <span data-button-label>ادامه / دریافت کد</span>
                    </button>
                </form>

                <form
                    id="otp-form"
                    action="{{ route('auth.verify') }}"
                    method="POST"
                    class="space-y-5 {{ $showOtpStep ? '' : 'hidden' }}"
                    novalidate
                >
                    @csrf
                    <input type="hidden" name="step" value="otp">
                    <input id="otp-phone" type="hidden" name="phone" value="{{ $enteredPhone }}">
                    <input id="otp-value" type="hidden" name="otp" value="{{ old('otp', old('code', '')) }}">
                    <input id="code-value" type="hidden" name="code" value="{{ old('code', old('otp', '')) }}">

                    <div class="rounded-2xl bg-[#FAFAF9] border border-[#E5E5E5] p-4">
                        <span class="block text-xs text-[#737373] mb-1">کد تأیید برای این شماره ارسال شد</span>
                        <strong id="shown-phone" class="block text-sm font-semibold text-[#171717]" dir="ltr">{{ $enteredPhone ?: '۰۹xxxxxxxxx' }}</strong>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-3">کد ۵ رقمی</label>
                        <div class="grid grid-cols-5 gap-2 sm:gap-3" dir="ltr" data-otp-wrapper>
                            @for ($i = 0; $i < 5; $i++)
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    maxlength="1"
                                    aria-label="رقم {{ $i + 1 }} کد تأیید"
                                    class="otp-input h-12 sm:h-14 rounded-xl border {{ $otpError ? 'border-red-300 bg-red-50/50' : 'border-[#E5E5E5] bg-white' }} text-center text-lg font-bold text-[#171717] focus:outline-none focus:border-[#171717] focus:ring-4 focus:ring-[#171717]/5 transition-all"
                                >
                            @endfor
                        </div>
                        @if ($otpError)
                            <p class="mt-2 text-xs leading-6 text-red-600">{{ $otpError }}</p>
                        @else
                            <p class="mt-2 text-xs leading-6 text-[#737373]">کد ارسال‌شده را بدون فاصله وارد کنید.</p>
                        @endif
                    </div>

                    <button
                        type="submit"
                        class="w-full h-12 inline-flex items-center justify-center gap-2 rounded-xl bg-[#171717] px-5 text-sm font-semibold text-white hover:bg-[#2a2a2a] disabled:cursor-not-allowed disabled:opacity-70 transition-colors"
                        data-loading-button
                        data-loading-text="در حال بررسی کد..."
                    >
                        <svg data-loading-spinner class="hidden w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                        </svg>
                        <span data-button-label>تأیید کد</span>
                    </button>
                </form>

                <form
                    id="resend-form"
                    action="{{ route('auth.resend') }}"
                    method="POST"
                    class="{{ $showOtpStep ? 'mt-5' : 'hidden' }}"
                    novalidate
                >
                    @csrf
                    <input id="resend-phone" type="hidden" name="phone" value="{{ $enteredPhone }}">

                    @error('resend')
                        <p class="mb-3 text-center text-xs leading-6 text-red-600">{{ $message }}</p>
                    @enderror

                    <button
                        type="submit"
                        id="resend-button"
                        class="w-full h-11 inline-flex items-center justify-center gap-2 rounded-xl border border-[#E5E5E5] bg-white px-5 text-sm font-semibold text-[#171717] hover:border-[#171717] disabled:cursor-not-allowed disabled:bg-[#FAFAF9] disabled:text-[#a3a3a3] disabled:hover:border-[#E5E5E5] transition-colors"
                        data-loading-button
                        data-loading-text="در حال ارسال مجدد..."
                        data-resend-seconds="{{ $resendSeconds }}"
                    >
                        <svg data-loading-spinner class="hidden w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z"></path>
                        </svg>
                        <span data-button-label>ارسال مجدد کد</span>
                    </button>
                </form>

                <button
                    type="button"
                    id="change-phone"
                    class="{{ $showOtpStep ? 'mt-5' : 'hidden' }} w-full text-sm font-medium text-[#737373] hover:text-[#171717] transition-colors"
                >
                    تغییر شماره موبایل
                </button>
            </div>
        </div>

        <p class="mt-5 text-center text-xs leading-6 text-[#737373]">
            ورود شما به معنای پذیرش قوانین و حریم خصوصی دو خان است.
        </p>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var phoneForm = document.getElementById('phone-form');
        var otpForm = document.getElementById('otp-form');
        var phoneInput = document.getElementById('phone');
        var otpPhoneInput = document.getElementById('otp-phone');
        var resendPhoneInput = document.getElementById('resend-phone');
        var shownPhone = document.getElementById('shown-phone');
        var changePhoneButton = document.getElementById('change-phone');
        var resendForm = document.getElementById('resend-form');
        var resendButton = document.getElementById('resend-button');
        var otpValueInput = document.getElementById('otp-value');
        var codeValueInput = document.getElementById('code-value');
        var otpInputs = Array.prototype.slice.call(document.querySelectorAll('.otp-input'));
        var stepIndicators = document.querySelectorAll('[data-step-indicator]');

        function normalizeDigits(value) {
            var persian = '۰۱۲۳۴۵۶۷۸۹';
            var arabic = '٠١٢٣٤٥٦٧٨٩';

            return String(value || '').replace(/[۰-۹٠-٩]/g, function (digit) {
                var persianIndex = persian.indexOf(digit);
                if (persianIndex > -1) {
                    return persianIndex;
                }

                return arabic.indexOf(digit);
            }).replace(/\D/g, '');
        }

        function toPersianDigits(value) {
            return String(value).replace(/\d/g, function (digit) {
                return '۰۱۲۳۴۵۶۷۸۹'[digit];
            });
        }

        function formatSeconds(seconds) {
            var minutes = Math.floor(seconds / 60);
            var remainingSeconds = seconds % 60;
            var formatted = String(minutes).padStart(2, '0') + ':' + String(remainingSeconds).padStart(2, '0');

            return toPersianDigits(formatted);
        }

        function setLoading(form) {
            var button = form.querySelector('[data-loading-button]');
            if (!button) {
                return;
            }

            var label = button.querySelector('[data-button-label]');
            var spinner = button.querySelector('[data-loading-spinner]');
            var loadingText = button.getAttribute('data-loading-text');

            button.disabled = true;
            if (spinner) {
                spinner.classList.remove('hidden');
            }
            if (label && loadingText) {
                label.textContent = loadingText;
            }
        }

        function setStep(step) {
            var isOtp = step === 'otp';

            phoneForm.classList.toggle('hidden', isOtp);
            otpForm.classList.toggle('hidden', !isOtp);
            if (resendForm) {
                resendForm.classList.toggle('hidden', !isOtp);
            }
            if (changePhoneButton) {
                changePhoneButton.classList.toggle('hidden', !isOtp);
            }

            stepIndicators.forEach(function (indicator) {
                var active = indicator.getAttribute('data-step-indicator') === 'phone' || isOtp;
                indicator.classList.toggle('bg-[#171717]', active);
                indicator.classList.toggle('bg-[#E5E5E5]', !active);
            });

            if (isOtp && otpInputs.length) {
                otpInputs[0].focus();
            } else if (phoneInput) {
                phoneInput.focus();
            }
        }

        function startResendCountdown() {
            if (!resendButton) {
                return;
            }

            var seconds = Number(resendButton.getAttribute('data-resend-seconds') || 0);
            var label = resendButton.querySelector('[data-button-label]');

            function render() {
                if (!label) {
                    return;
                }

                if (seconds > 0) {
                    resendButton.disabled = true;
                    label.textContent = 'ارسال مجدد تا ' + formatSeconds(seconds);
                    seconds -= 1;
                    window.setTimeout(render, 1000);
                    return;
                }

                resendButton.disabled = false;
                label.textContent = 'ارسال مجدد کد';
            }

            render();
        }

        function syncOtpValue() {
            var value = otpInputs.map(function (input) {
                return normalizeDigits(input.value).slice(0, 1);
            }).join('');

            otpValueInput.value = value;
            codeValueInput.value = value;
        }

        if (phoneInput) {
            phoneInput.addEventListener('input', function () {
                phoneInput.value = normalizeDigits(phoneInput.value).slice(0, 11);
            });
        }

        otpInputs.forEach(function (input, index) {
            input.addEventListener('input', function () {
                var value = normalizeDigits(input.value);
                input.value = value.slice(-1);
                syncOtpValue();

                if (input.value && otpInputs[index + 1]) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function (event) {
                if (event.key === 'Backspace' && !input.value && otpInputs[index - 1]) {
                    otpInputs[index - 1].focus();
                }

                if (event.key.length === 1 && !/[0-9۰-۹٠-٩]/.test(event.key)) {
                    event.preventDefault();
                }
            });

            input.addEventListener('paste', function (event) {
                event.preventDefault();
                var clipboard = event.clipboardData || window.clipboardData;
                var pasted = normalizeDigits(clipboard.getData('text')).slice(0, 5);

                pasted.split('').forEach(function (digit, digitIndex) {
                    if (otpInputs[digitIndex]) {
                        otpInputs[digitIndex].value = digit;
                    }
                });

                syncOtpValue();
                var nextIndex = Math.min(pasted.length, otpInputs.length) - 1;
                if (otpInputs[nextIndex]) {
                    otpInputs[nextIndex].focus();
                }
            });
        });

        if (otpForm) {
            otpForm.addEventListener('submit', function () {
                syncOtpValue();
                setLoading(otpForm);
            });
        }

        if (phoneForm) {
            phoneForm.addEventListener('submit', function () {
                if (otpPhoneInput && phoneInput) {
                    otpPhoneInput.value = phoneInput.value;
                }
                if (resendPhoneInput && phoneInput) {
                    resendPhoneInput.value = phoneInput.value;
                }
                if (shownPhone && phoneInput && phoneInput.value) {
                    shownPhone.textContent = phoneInput.value;
                }
                setLoading(phoneForm);
            });
        }

        if (resendForm) {
            resendForm.addEventListener('submit', function () {
                if (resendPhoneInput && otpPhoneInput) {
                    resendPhoneInput.value = otpPhoneInput.value;
                }
                setLoading(resendForm);
            });
        }

        if (changePhoneButton) {
            changePhoneButton.addEventListener('click', function () {
                otpInputs.forEach(function (input) {
                    input.value = '';
                });
                syncOtpValue();
                setStep('phone');
            });
        }

        var initialOtp = normalizeDigits(otpValueInput ? otpValueInput.value : '').slice(0, 5);
        if (initialOtp) {
            initialOtp.split('').forEach(function (digit, index) {
                if (otpInputs[index]) {
                    otpInputs[index].value = digit;
                }
            });
            syncOtpValue();
        }

        startResendCountdown();
    });
</script>
</body>
</html>
