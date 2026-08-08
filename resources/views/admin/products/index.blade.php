@extends('admin.layouts.app')

@section('title', 'محصولات')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت محصولات /</span> محصولات
    </h4>

    <div class="card">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center m-3">
            <h5 class="mb-0">لیست محصولات</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> افزودن محصول
            </a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>شناسه</th>
                    <th>تصویر</th>
                    <th>نام</th>
                    <th>دسته‌بندی</th>
                    <th>برند</th>
                    <th>قیمت</th>
                    <th>موجودی</th>
                    <th>عملیات</th>
                </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                     class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                            @else
                                <span class="badge bg-label-secondary">بدون تصویر</span>
                            @endif
                        </td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td><span class="badge bg-label-primary">{{ $product->category->name ?? '—' }}</span></td>
                        <td><span class="badge bg-label-info">{{ $product->brand->name ?? '—' }}</span></td>
                        <td>{{ number_format($product->price) }} تومان</td>
                        <td>
                            @if($product->stock > 0)
                                <span class="badge bg-label-success">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-label-danger">ناموجود</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.products.edit', $product) }}">
                                        <i class="bx bx-edit-alt me-1"></i> ویرایش
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('آیا از حذف این محصول اطمینان دارید؟')">
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
                        <td colspan="8" class="text-center">محصولی یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
