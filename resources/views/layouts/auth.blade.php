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
                    <a href="{{ url('/add-item') }}" class="sidebar-link">
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
