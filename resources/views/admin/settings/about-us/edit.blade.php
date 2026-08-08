@extends('admin.layouts.app')

@section('title', 'ویرایش درباره ما')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor-fa.css') }}">
@endpush

@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت ارتباط با ما /</span> درباره ما
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ویرایش درباره ما</h5>
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
                          action="{{ route('admin.about-us.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان</label>
                            <input
                                class="form-control @error('title') is-invalid @enderror"
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title', $aboutUs->title) }}"
                                required
                            >
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description (Quill) --}}
                        <div class="mb-3">
                            <label class="form-label">توضیحات</label>

                            <input type="hidden" name="description" id="description"
                                   value="{{ old('description', $aboutUs->description) }}">

                            {{-- Toolbar --}}
                            <div id="full-toolbar" class="border border-bottom-0 rounded-top p-2">
                                <span class="ql-formats">
                                    <select class="ql-font"></select>
                                    <select class="ql-size"></select>
                                </span>

                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>

                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>

                                <span class="ql-formats">
                                    <button class="ql-script" value="sub"></button>
                                    <button class="ql-script" value="super"></button>
                                </span>

                                <span class="ql-formats">
                                    <button class="ql-header" value="1"></button>
                                    <button class="ql-header" value="2"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                </span>

                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                </span>

                                <span class="ql-formats">
                                    <select class="ql-align"></select>
                                </span>

                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                </span>

                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>

                            {{-- Editor --}}
                            <div id="full-editor"
                                 class="rounded-bottom @error('description') border border-danger @else border @enderror"
                                 style="min-height: 220px;"></div>

                            @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="row align-items-start">
                            {{-- Left: file input --}}
                            <div class="mb-3 col-12 col-md-6">
                                <label for="img" class="form-label">تصویر (اختیاری)</label>

                                <input
                                    class="form-control @error('img') is-invalid @enderror"
                                    type="file"
                                    id="img"
                                    name="img"
                                    accept="image/png,image/jpeg,image/jpg,image/gif,image/webp"
                                >

                                @error('img')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <small class="text-muted d-block mt-1">
                                    فرمت‌های مجاز: jpg، png، gif، webp
                                </small>

                                @php($imgUrl = $aboutUs->getFirstMediaUrl('img'))
                                @if($imgUrl)
                                    <div class="form-check mt-3">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            value="1"
                                            id="remove_img"
                                            name="remove_img"
                                            {{ old('remove_img') ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="remove_img">
                                            حذف تصویر فعلی
                                        </label>
                                    </div>
                                @endif
                            </div>

                            {{-- Right: preview/current --}}
                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-center align-items-center" style="min-height: 220px;">
                                    {{-- Preview for NEW selected image --}}
                                    <div id="imgPreviewWrapper" style="display:none;">
                                        <img
                                            id="imgPreview"
                                            class="img-fluid rounded-3 shadow-sm border"
                                            style="max-height: 220px; object-fit: cover; display:none;"
                                            alt=""
                                        >
                                    </div>

                                    {{-- Current image --}}
                                    @if($imgUrl)
                                        <img
                                            id="existingImg"
                                            src="{{ $imgUrl }}"
                                            class="img-fluid rounded-3 shadow-sm border"
                                            style="max-height: 220px; object-fit: cover;"
                                            alt=""
                                        >
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                بروزرسانی
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const hidden = document.getElementById('description');
            const editorEl = document.getElementById('full-editor');
            const toolbarEl = document.getElementById('full-toolbar');

            if (hidden && editorEl && toolbarEl) {
                const quill = new Quill('#full-editor', {
                    theme: 'snow',
                    modules: { toolbar: '#full-toolbar' }
                });

                if (hidden.value) {
                    quill.clipboard.dangerouslyPasteHTML(hidden.value);
                }

                const sync = () => { hidden.value = quill.root.innerHTML; };
                quill.on('text-change', sync);

                const form = hidden.closest('form');
                if (form) form.addEventListener('submit', sync);
            }

            const imgInput = document.getElementById('img');
            const previewWrapper = document.getElementById('imgPreviewWrapper');
            const previewImg = document.getElementById('imgPreview');
            const existingImg = document.getElementById('existingImg');
            const removeImgInput = document.getElementById('remove_img');

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

            const hideExistingImg = () => {
                previewImg.removeAttribute('src');
                previewImg.style.display = 'none';
                previewWrapper.style.display = 'none';

                if (existingImg) existingImg.style.display = 'none';
            };

            imgInput.addEventListener('change', function () {
                const file = this.files && this.files[0];

                if (!file) {
                    resetToExisting();
                    return;
                }

                if (!file.type || !file.type.startsWith('image/')) {
                    resetToExisting();
                    return;
                }

                const url = URL.createObjectURL(file);
                showPreview(url);

                previewImg.onload = () => URL.revokeObjectURL(url);
            });

            if (removeImgInput) {
                if (removeImgInput.checked) {
                    hideExistingImg();
                }

                removeImgInput.addEventListener('change', function () {
                    if (this.checked) {
                        imgInput.value = '';
                        hideExistingImg();
                        return;
                    }

                    resetToExisting();
                });
            }
        });
    </script>
@endpush
