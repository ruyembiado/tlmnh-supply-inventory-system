<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TLNMHS</title>

    <!-- Bootstrap Style -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Fontawesome Style -->
    <link href="{{ asset('public/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('public/css/datatables.min.css') }}" rel="stylesheet">
    <!-- Select2 Style -->
    <link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
    <!-- Select2 Bootstrap Styles -->
    <link href="{{ asset('public/css/select2-bootstrap5.min.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('public/css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="bg-primary expand">
            <div class="d-flex gap-1 justify-content-center pt-4">
                <div class="site-log">
                    <a href="{{ url('/dashboard') }}">
                        <img src="{{ asset('public/img/sis-icon.png') }}" width="60" alt="sis-logo">
                    </a>
                </div>
                <div class="sidebar-logo">
                    <a href="{{ url('/dashboard') }}">TLNMHS</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ url('/dashboard') }}" class="sidebar-link">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="fas fa-cart-plus"></i>
                        <span>Add Item</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/items') }}" class="sidebar-link">
                        <i class="fas fa-boxes"></i>
                        <span>List of Items</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/release-item') }}" class="sidebar-link">
                        <i class="fas fa-dolly"></i>
                        <span>Release Item</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/released-items') }}" class="sidebar-link">
                        <i class="fas fa-list-alt"></i>
                        <span>Released Items</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a href="{{ url('/released-items') }}" class="sidebar-link">
                        <i class="fas fa-truck-loading"></i>
                        <span>List of Released Items</span>
                    </a>
                </li> --}}
                <li class="sidebar-item">
                    <a href="{{ url('/stock-cards') }}" class="sidebar-link">
                        <i class="fas fa-clipboard-list"></i>
                        <span>Stock Cards</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/report?year=' . now()->year . '&month=' . now()->month) }}" class="sidebar-link">
                        <i class="fas fa-file-invoice"></i>
                        <span>Report</span>
                    </a>
                </li>
            </ul>
        </aside>
        <div class="main bg-gradient">
            <nav class="navbar navbar-expand px-4 py-3 bg-theme-secondary">
                <div class="navbar-collapse collapse">
                    <button class="toggle-btn" type="button">
                        <i class="fa-solid text-dark fa fa-bars fs-5"></i>
                    </button>
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <span class="m-auto me-1">
                                @auth
                                    {{ auth()->user()->name }}
                                @endauth
                            </span>
                        @endauth
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-stat-icon pe-md-0">
                                <i class="text-dark fas fa-user-circle avatar"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded animated--fade-in">
                                {{-- <a class="dropdown-item" href="">
                                    <i class="text-primary fas fa-user fa-sm fa-fw mr-2"></i>
                                    Profile
                                </a> --}}
                                <a class="dropdown-item" href="{{ url('/logout') }}">
                                    <i class="text-primary fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4 bg-theme-secondary" id="page-top">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="container-fluid">
                    @yield('content')
                </div>
                <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('store.item') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="item_name" class="form-label">Item Name</label>
                                                <input type="text" name="item_name" id="item_name"
                                                    class="form-control @error('item_name') is-invalid @enderror"
                                                    value="{{ old('item_name') }}">
                                                @error('item_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="supplier_name" class="form-label">Supplier Name</label>
                                                <input type="text" name="supplier_name" id="supplier_name"
                                                    class="form-control @error('supplier_name') is-invalid @enderror"
                                                    value="{{ old('supplier_name') }}">
                                                @error('supplier_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <input type="text" name="category" id="category"
                                                    class="form-control @error('category') is-invalid @enderror"
                                                    value="{{ old('category') }}">
                                                @error('category')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="stock_no" class="form-label">Stock No.</label>
                                                <input type="text" name="stock_no" id="stock_no"
                                                    class="form-control @error('stock_no') is-invalid @enderror"
                                                    value="{{ old('stock_no') }}">
                                                @error('stock_no')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="restock_point" class="form-label">Restock Point
                                                    (optional)</label>
                                                <input type="number" name="restock_point" id="restock_point"
                                                    class="form-control @error('restock_point') is-invalid @enderror"
                                                    min="0" value="{{ old('restock_point') }}">
                                                @error('restock_point')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="unit_cost" class="form-label">Unit Cost</label>
                                                <input type="number" name="unit_cost" id="unit_cost"
                                                    class="form-control @error('unit_cost') is-invalid @enderror"
                                                    step="0.01" min="0" value="{{ old('unit_cost') }}">
                                                @error('unit_cost')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" name="quantity" id="quantity"
                                                    class="form-control @error('quantity') is-invalid @enderror"
                                                    min="0" value="{{ old('quantity', 0) }}">
                                                @error('quantity')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="unit" class="form-label">Unit of Measurement</label>
                                                <input type="text" name="unit" id="unit"
                                                    class="form-control @error('unit') is-invalid @enderror"
                                                    placeholder="e.g. pcs, box" value="{{ old('unit') }}">
                                                @error('unit')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description
                                                    (optional)</label>
                                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                                    rows="3">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="remarks" class="form-label">Remarks (optional)</label>
                                                <textarea name="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks') }}</textarea>
                                                @error('remarks')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary float-end">Add Item</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </main>
            <footer class="footer py-3 shadow text-center">
                <div class="d-flex justify-content-center px-3">
                    <div class="">© 2025 TLNMHS. All rights reserved.</div>
                </div>
            </footer>
        </div>
    </div>

    <!-- jQuery Script -->
    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <!-- Bootstrap Script -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('public/js/datatables.min.js') }}"></script>
    <!-- Fontawesome Script -->
    <script src="{{ asset('public/js/all.min.js') }}"></script>
    {{-- <script src="{{ asset('public/js/fontawesome.min.js') }}"></script> --}}
    <!-- Select2 Script -->
    <script src="{{ asset('public/js/select2.min.js') }}"></script>

    <!-- Print.js JS -->
    <script src="{{ asset('public/js/print.min.js') }}"></script>

    <!--Custom Script -->
    <script src="{{ asset('public/js/script.js') }}"></script>
    @stack('scripts')
    <script>
        function hideAlerts(delay = 3000) {
            console.log('Hiding alerts');
            if ($('.alert-success, .alert-danger').length) {
                setTimeout(function() {
                    $('.alert-success, .alert-danger').fadeOut('slow');
                }, delay);
            }
        }
        hideAlerts();
    </script>
</body>

</html>
