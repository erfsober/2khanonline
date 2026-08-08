@extends('admin.layouts.app')

@section('title', 'ویرایش تماس با ما')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor-fa.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #locationMap { height: 350px; border-radius: 0.375rem; z-index: 1; }
        .leaflet-container { direction: ltr; }
    </style>
@endpush

@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت ارتباط با ما /</span> تماس با ما
    </h4>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ویرایش تماس با ما</h5>
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
                          action="{{ route('admin.contact-us.update') }}">
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
                                value="{{ old('title', $contactUs->title) }}"
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
                                   value="{{ old('description', $contactUs->description) }}">

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

                        {{-- Location --}}
                        <div class="mb-3">
                            <label class="form-label">موقعیت مکانی</label>
                            <p class="text-muted small mb-2">روی نقشه کلیک کنید یا نشانگر را جابجا کنید.</p>

                            <input type="hidden" name="location" id="location"
                                   value="{{ old('location', $contactUs->location) }}">

                            <div id="locationMap" class="border @error('location') border-danger @enderror"></div>

                            <div class="d-flex gap-3 mt-2">
                                <div>
                                    <small class="text-muted">عرض جغرافیایی:</small>
                                    <span id="latDisplay" class="fw-bold">—</span>
                                </div>
                                <div>
                                    <small class="text-muted">طول جغرافیایی:</small>
                                    <span id="lngDisplay" class="fw-bold">—</span>
                                </div>
                            </div>

                            @error('location')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Telegram --}}
                        <div class="mb-3">
                            <label for="telegram" class="form-label">تلگرام</label>
                            <input
                                class="form-control @error('telegram') is-invalid @enderror"
                                type="text"
                                id="telegram"
                                name="telegram"
                                value="{{ old('telegram', $contactUs->telegram) }}"
                                placeholder="https://t.me/username"
                            >
                            @error('telegram')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- WhatsApp --}}
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">واتساپ</label>
                            <input
                                class="form-control @error('whatsapp') is-invalid @enderror"
                                type="text"
                                id="whatsapp"
                                name="whatsapp"
                                value="{{ old('whatsapp', $contactUs->whatsapp) }}"
                                placeholder="https://wa.me/989121234567"
                            >
                            @error('whatsapp')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">آدرس</label>
                            <textarea
                                class="form-control @error('address') is-invalid @enderror"
                                id="address"
                                name="address"
                                rows="3"
                            >{{ old('address', $contactUs->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Quill Editor
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

            // Leaflet Map
            const locationInput = document.getElementById('location');
            const latDisplay = document.getElementById('latDisplay');
            const lngDisplay = document.getElementById('lngDisplay');

            // Default: Tehran
            let defaultLat = 35.6892;
            let defaultLng = 51.3890;
            let defaultZoom = 12;

            // Parse existing location
            if (locationInput.value && locationInput.value.includes(',')) {
                const parts = locationInput.value.split(',');
                const parsedLat = parseFloat(parts[0]);
                const parsedLng = parseFloat(parts[1]);
                if (!isNaN(parsedLat) && !isNaN(parsedLng)) {
                    defaultLat = parsedLat;
                    defaultLng = parsedLng;
                    defaultZoom = 15;
                }
            }

            const map = L.map('locationMap').setView([defaultLat, defaultLng], defaultZoom);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19,
            }).addTo(map);

            const marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

            function updateLocation(lat, lng) {
                const latFixed = lat.toFixed(6);
                const lngFixed = lng.toFixed(6);
                locationInput.value = latFixed + ',' + lngFixed;
                latDisplay.textContent = latFixed;
                lngDisplay.textContent = lngFixed;
            }

            updateLocation(defaultLat, defaultLng);

            marker.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                updateLocation(pos.lat, pos.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateLocation(e.latlng.lat, e.latlng.lng);
            });

            // Fix map tiles not loading properly
            setTimeout(function () { map.invalidateSize(); }, 300);
        });
    </script>
@endpush
