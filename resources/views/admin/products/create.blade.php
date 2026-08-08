@extends('admin.layouts.app')

@section('title', 'افزودن محصول')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت محصولات / محصولات /</span> افزودن
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">افزودن محصول جدید</h5>
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
                          action="{{ route('admin.products.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- Category --}}
                            <div class="mb-3 col-md-6">
                                <label for="product_category_id" class="form-label">دسته‌بندی</label>
                                <select class="form-select @error('product_category_id') is-invalid @enderror"
                                        id="product_category_id" name="product_category_id" required>
                                    <option value="">انتخاب دسته‌بندی...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                                {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Brand --}}
                            <div class="mb-3 col-md-6">
                                <label for="product_brand_id" class="form-label">برند</label>
                                <select class="form-select @error('product_brand_id') is-invalid @enderror"
                                        id="product_brand_id" name="product_brand_id" required>
                                    <option value="">انتخاب برند...</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                                {{ old('product_brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">نام محصول</label>
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

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات (اختیاری)</label>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                name="description"
                                rows="3"
                            >{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Price --}}
                            <div class="mb-3 col-md-6">
                                <label for="price" class="form-label">قیمت (تومان)</label>
                                <input
                                    class="form-control @error('price') is-invalid @enderror"
                                    type="number"
                                    id="price"
                                    name="price"
                                    value="{{ old('price') }}"
                                    min="0"
                                    required
                                >
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Stock --}}
                            <div class="mb-3 col-md-6">
                                <label for="stock" class="form-label">موجودی</label>
                                <input
                                    class="form-control @error('stock') is-invalid @enderror"
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    value="{{ old('stock', 0) }}"
                                    min="0"
                                    required
                                >
                                @error('stock')
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
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">انصراف</a>
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
