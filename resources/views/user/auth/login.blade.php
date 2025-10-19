@extends("website.layout")


@section("title", "User Login")

@section("content")


    <!-- Main Content -->
    <main>
        <div class="login-gradient py-5">
            <div class="container">
                <div class="row justify-content-center align-items-center min-vh-100">
                    <div class="col-md-6 col-lg-5">
                        <div class="card login-card">
                            <div class="card-body p-5">
                                <!-- Header -->
                                <div class="text-center mb-4">
                                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3 p-4">
                                        <i class="fas fa-user text-white fa-2x"></i>
                                    </div>
                                    <h2 class="card-title fw-bold text-dark mb-2">
                                        Administration Login
                                    </h2>
                                    <p class="text-muted mb-4">
                                        Access your inventory management dashboard
                                    </p>
                                </div>

                                <!-- Login Form -->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-semibold">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <input id="email" name="email" type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" placeholder="Enter your email address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label fw-semibold">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-lock text-muted"></i>
                                            </span>
                                            <input id="password" name="password" type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="Enter your password" required autocomplete="current-password">
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label text-muted" for="remember">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>

                                    @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Error!</strong> {{ $errors->first() }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                    @endif

                                    <!-- Submit Button -->
                                    <div class="d-grid mb-4">
                                        <button type="submit" class="btn btn-success btn-lg fw-semibold py-3">
                                            <i class="fas fa-sign-in-alt me-2"></i>
                                            Sign in to Dashboard
                                        </button>
                                    </div>

                                    <!-- Registration Link -->
                                    <div class="text-center mb-4">
                                        <p class="text-muted mb-2">
                                            Don't have an account?
                                        </p>
                                        <a href="{{ route('register') }}" class="text-success text-decoration-none fw-semibold">
                                            <i class="fas fa-user-plus me-1"></i>
                                            Create new account
                                        </a>
                                    </div>
                                </form>

                                <!-- Demo Credentials -->
                                <div class="bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3 p-4 mt-4">
                                    <h6 class="fw-semibold text-warning mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Demo Credentials
                                    </h6>
                                    <div class="row">
                                        <div class="col-sm-6 mb-2">
                                            <small class="text-dark fw-semibold">Email:</small>
                                            <br>
                                            <small class="text-muted">user@example.com</small>
                                        </div>
                                        <div class="col-sm-6 mb-2">
                                            <small class="text-dark fw-semibold">Password:</small>
                                            <br>
                                            <small class="text-muted">password</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Back to Home -->
                                <div class="text-center mt-4">
                                    <a href="/" class="text-decoration-none text-muted">
                                        <i class="fas fa-arrow-left me-1"></i>
                                        Back to Homepage
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

 

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        console.log('Login page loaded');

        // Form submission handler
        $('form').on('submit', function() {
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin me-2"></i>Signing in...');
        });
    });

</script>
@endsection
