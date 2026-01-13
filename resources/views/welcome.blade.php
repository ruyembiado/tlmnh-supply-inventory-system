@extends('layouts.public')

@section('content')
    <main class="{{ auth()->check() ? 'auth' : 'guest' }} content px-3 py-4 col-12 home-bg d-flex justify-content-start align-items-center" id="page-top">
        <div class="container-fluid col-md-10 col-12 m-auto p-0">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row justify-content-center align-items-center gap-3">
                <div class="title-container">
                    <h6 class="text-light welcome-text m-0">Welcome to</h6>
                    <h1 class="text-light home-title m-0">
                        Tario Lim National Memorial Highschool
                    </h1>
                </div>

                <div class="d-flex flex-column gap-5">
                    <div class="home-description text-light">
                        <h2>Supply Inventory System</h2>
                    </div>

                    @if (!auth()->check())
                        <div class="auth-buttons d-flex gap-3">
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <b>Login</b>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    {{-- LOGIN MODAL --}}
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark text-light w-75">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    {{-- <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button> --}}
                </div>

                <div class="modal-body">

                    <div class="text-center mb-3">
                        <img src="{{ asset('public/img/sis-icon.png') }}" alt="sis-logo" class="img-fluid" width="100">
                    </div>

                    <div class="text-center mb-3">
                        <h6 class="m-0">Tario-Lim Memorial National High School Supply Inventory System</h6>
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" placeholder="Username" required>
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Login
                        </button>
                        <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

{{-- AUTO OPEN MODAL ON ERROR --}}
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let loginModal = new bootstrap.Modal(
                document.getElementById('loginModal')
            );
            loginModal.show();
        });
    </script>
@endif
