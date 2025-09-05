@extends('layouts.userapp')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4 mx-auto" style="max-width: 500px;" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-center py-5">
        <div class="form-card rounded-4 p-3 p-md-5 shadow-lg bg-white mx-3" style="max-width: 500px; width: 100%;">
            <h2 class="text-center mb-4 text-primary fw-bold">Login to Symmetric Hub</h2>
            <p class="text-center text-muted mb-4">Enter your email and password to access your account</p>

            <form id="login-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="reg-email" class="form-label">Email</label>
                    <input type="email" id="reg-email"
                           class="form-control rounded-pill custom-input @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}"
                           placeholder="Enter your email" autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 password-field-wrapper">
                    <label for="password" class="form-label">Password</label>
                    <div class="position-relative">
                        <input type="password" id="password"
                               class="form-control rounded-pill custom-input"
                               name="password" placeholder="Enter your password" autocomplete="current-password">
                        <span class="password-toggle" onclick="togglePasswordVisibility(this)">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">Login</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            window.togglePasswordVisibility = function(el) {
                const input = el.closest(".password-field-wrapper").querySelector("input");
                const icon = el.querySelector("i");

                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                }
            };
        </script>
    @endpush

@endsection
