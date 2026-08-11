@extends('admin.layouts.app')

@section('title', 'کاربران')

@section('content')

    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">مدیریت کاربران /</span> کاربران
    </h4>

    <div class="card">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center m-3">
            <h5 class="mb-0">لیست کاربران</h5>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 mx-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="جستجو با شماره تلفن"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>جدیدترین</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>قدیمی‌ترین</option>
                </select>
            </div>
            <div class="col-md-5">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bx bx-search me-1"></i> جستجو
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-reset me-1"></i> بازنشانی
                </a>
            </div>
        </form>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>شناسه</th>
                    <th>شماره تلفن</th>
                    <th>تعداد سفارشات</th>
                    <th>تاریخ عضویت</th>
                    <th>عملیات</th>
                </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                @forelse ($users as $user)
                    <tr>
                        <td><strong>{{ $user->id }}</strong></td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            <span class="badge bg-label-primary">{{ $user->orders_count }}</span>
                        </td>
                        <td>{{ verta(optional($user->created_at)->format('Y/m/d')) }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-show me-1"></i> مشاهده
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">کاربری یافت نشد.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        @endif
    </div>

@endsection
