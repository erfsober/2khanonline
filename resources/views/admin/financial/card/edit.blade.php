@extends('admin.layouts.app')

@section('title', 'مدیریت مالی - کارت بانکی')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت مالی /</span> کارت بانکی
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">اطلاعات کارت بانکی</h5>
                </div>

                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($card)
                        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                            <i class="bx bx-info-circle me-2"></i>
                            <span>اطلاعات کارت فعلی ثبت شده است. می‌توانید آن را ویرایش کنید.</span>
                        </div>
                    @else
                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                            <i class="bx bx-error-circle me-2"></i>
                            <span>هنوز اطلاعات کارت ثبت نشده است.</span>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('admin.financial.card.update') }}">
                        @csrf
                        @method('PUT')

                        {{-- Card Number --}}
                        <div class="mb-3">
                            <label for="card_number" class="form-label">شماره کارت</label>
                            <input
                                class="form-control @error('card_number') is-invalid @enderror"
                                type="text"
                                id="card_number"
                                name="card_number"
                                value="{{ old('card_number', $card->card_number ?? '') }}"
                                placeholder="مثال: 6037997512345678"
                                maxlength="19"
                                required
                            >
                            @error('card_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">شماره ۱۶ رقمی کارت بانکی</small>
                        </div>

                        {{-- Card Holder Name --}}
                        <div class="mb-3">
                            <label for="card_holder_name" class="form-label">نام و نام خانوادگی صاحب کارت</label>
                            <input
                                class="form-control @error('card_holder_name') is-invalid @enderror"
                                type="text"
                                id="card_holder_name"
                                name="card_holder_name"
                                value="{{ old('card_holder_name', $card->card_holder_name ?? '') }}"
                                placeholder="مثال: علی رضایی"
                                required
                            >
                            @error('card_holder_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>
                                {{ $card ? 'بروزرسانی' : 'ذخیره' }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
