@extends('admin.layouts.app')

@section('title', 'ویرایش برند')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت محصولات / برندها /</span> ویرایش
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ویرایش برند</h5>
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

                    <form method="POST"
                          action="{{ route('admin.product-brands.update', $productBrand) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Name --}}
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">نام برند</label>
                                <input
                                    class="form-control @error('name') is-invalid @enderror"
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $productBrand->name) }}"
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
                                    value="{{ old('slug', $productBrand->slug) }}"
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
                            >{{ old('description', $productBrand->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                                @php($imgUrl = $productBrand->getFirstMediaUrl('image'))
                                @if($imgUrl)
                                    <div class="form-check mt-3">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               id="remove_image" name="remove_image"
                                               {{ old('remove_image') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remove_image">حذف تصویر فعلی</label>
                                    </div>
                                @endif
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-center align-items-center" style="min-height: 120px;">
                                    <div id="imagePreviewWrapper" style="display:none;">
                                        <img id="imagePreview" class="img-fluid rounded-3 shadow-sm border"
                                             style="max-height: 120px; object-fit: cover; display:none;" alt="">
                                    </div>
                                    @if($imgUrl)
                                        <img id="existingImage" src="{{ $imgUrl }}"
                                             class="img-fluid rounded-3 shadow-sm border"
                                             style="max-height: 120px; object-fit: cover;" alt="">
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.product-brands.index') }}" class="btn btn-outline-secondary">انصراف</a>
                            <button type="submit" class="btn btn-primary">بروزرسانی</button>
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
            const existingImg = document.getElementById('existingImage');
            const removeImgInput = document.getElementById('remove_image');

            if (!imgInput || !previewWrapper || !previewImg) return;

            const showPreview = (src) => {
                if (removeImgInput) removeImgInput.checked = false;
                if (existingImg) existingImg.style.display = 'none';
                previewImg.src = src;
                previewImg.style.display = 'block';
                previewWrapper.style.display = 'block';
            };

            const resetToExisting = () => {
                previewImg.removeAttribute('src');
                previewImg.style.display = 'none';
                previewWrapper.style.display = 'none';
                if (existingImg) existingImg.style.display = 'block';
            };

            const hideExisting = () => {
                previewImg.removeAttribute('src');
                previewImg.style.display = 'none';
                previewWrapper.style.display = 'none';
                if (existingImg) existingImg.style.display = 'none';
            };

            imgInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file || !file.type || !file.type.startsWith('image/')) { resetToExisting(); return; }
                showPreview(URL.createObjectURL(file));
            });

            if (removeImgInput) {
                removeImgInput.addEventListener('change', function () {
                    if (this.checked) { imgInput.value = ''; hideExisting(); } else { resetToExisting(); }
                });
            }
        });
    </script>
@endpush
