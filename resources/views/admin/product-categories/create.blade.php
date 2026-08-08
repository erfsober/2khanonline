@extends('admin.layouts.app')

@section('title', 'افزودن دسته‌بندی')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت محصولات / دسته‌بندی‌ها /</span> افزودن
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">افزودن دسته‌بندی جدید</h5>
                </div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('admin.product-categories.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">نام دسته‌بندی</label>
                                <input
                                    class="form-control @error('name') is-invalid @enderror"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                >
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Slug --}}
                            <div class="mb-3 col-md-6">
                                <label for="slug" class="form-label">اسلاگ</label>
                                <input
                                    class="form-control @error('slug') is-invalid @enderror"
                                    type="text"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug') }}"
                                    required
                                >
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Image --}}
                        <div class="row align-items-start">
                            <div class="mb-3 col-12 col-md-6">
                                <label for="image" class="form-label">تصویر (اختیاری)</label>
                                <input
                                    class="form-control @error('image') is-invalid @enderror"
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept="image/png,image/jpeg,image/jpg,image/gif,image/webp"
                                >
                                @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">فرمت‌های مجاز: jpg، png، gif، webp</small>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-center align-items-center" style="min-height: 120px;">
                                    <div id="imagePreviewWrapper" style="display:none;">
                                        <img id="imagePreview" class="img-fluid rounded-3 shadow-sm border"
                                             style="max-height: 120px; object-fit: cover; display:none;" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.product-categories.index') }}" class="btn btn-outline-secondary">انصراف</a>
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imgInput = document.getElementById('image');
            const previewWrapper = document.getElementById('imagePreviewWrapper');
            const previewImg = document.getElementById('imagePreview');

            if (!imgInput || !previewWrapper || !previewImg) return;

            imgInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file || !file.type || !file.type.startsWith('image/')) {
                    previewImg.style.display = 'none';
                    previewWrapper.style.display = 'none';
                    return;
                }
                const url = URL.createObjectURL(file);
                previewImg.src = url;
                previewImg.style.display = 'block';
                previewWrapper.style.display = 'block';
                previewImg.onload = () => URL.revokeObjectURL(url);
            });
        });
    </script>
@endpush
