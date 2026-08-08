@extends('admin.layouts.app')

@section('title', 'دسته‌بندی محصولات')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت محصولات /</span> دسته‌بندی‌ها
    </h4>

    <div class="card">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center m-3">
            <h5 class="mb-0">لیست دسته‌بندی‌ها</h5>
            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> افزودن دسته‌بندی
            </a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>شناسه</th>
                    <th>تصویر</th>
                    <th>نام</th>
                    <th>اسلاگ</th>
                    <th>تاریخ ایجاد</th>
                    <th>عملیات</th>
                </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                @forelse ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                                     class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <span class="badge bg-label-secondary">بدون تصویر</span>
                            @endif
                        </td>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ verta(optional($category->created_at)->format('Y/m/d')) }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.product-categories.edit', $category) }}">
                                        <i class="bx bx-edit-alt me-1"></i> ویرایش
                                    </a>
                                    <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST"
                                          onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bx bx-trash me-1"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">دسته‌بندی‌ای یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
