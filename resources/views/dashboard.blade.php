@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Items</div>
                                <div class="h3 mb-0 font-weight-bold text-primary">{{ $items->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Out of Stock Item</div>
                                <div class="h3 mb-0 font-weight-bold text-primary">{{ $items->where('quantity', 0)->count(); }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-box fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->
