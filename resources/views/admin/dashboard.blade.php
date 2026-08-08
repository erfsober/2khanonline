@extends('admin.layouts.app')

@section('title', 'داشبورد')

@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">داشبورد مدیریت</h4>
    <p>
        به پنل مدیریت خوش آمدید.<br>

    </p>

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">مبلغ کل </p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="mb-0 me-2"> 100000 تومان</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                        <span class="badge bg-label-warning rounded p-2">
                            <i class="bx bx-dollar bx-sm"></i>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">تعداد</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="mb-0 me-2">6</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                        <span class="badge bg-label-info rounded p-2">
                            <i class="bx bx-donate-heart bx-sm"></i>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="card-info">
                            <p class="card-text">کاربران</p>
                            <div class="d-flex align-items-end mb-2">
                                <h4 class="mb-0 me-2">135</h4>
                            </div>
                        </div>
                        <div class="card-icon">
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bx-group bx-sm"></i>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
