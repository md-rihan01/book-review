<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Book Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f0f1;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .login-logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1d2327;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="login-logo">
                <h1>Book Reviews</h1>
                <p class="text-muted">Sign in to your account</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($redirect_to)
                            <input type="hidden" name="redirect_to" value="{{ $redirect_to }}">
                        @endif

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Remember me</label>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Sign In</button>
                    </form>
                </div>
            </div>

            <p class="text-center mt-3">
                <a href="{{ route('auth.register', $redirect_to ? ['redirect_to' => $redirect_to] : []) }}" class="text-decoration-none">Don't have an account? Register</a>
            </p>
            <p class="text-center mt-2">
                <a href="{{ route('books.index') }}" class="text-decoration-none text-muted small">&larr; Back to Books</a>
            </p>
        </div>
    </div>
</body>
</html>
