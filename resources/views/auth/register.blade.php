<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Book Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f0f1;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
        .register-card {
            max-width: 420px;
            width: 100%;
            margin: 0 auto;
        }
        .register-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .register-logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1d2327;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="register-card">
            <div class="register-logo">
                <h1>Book Reviews</h1>
                <p class="text-muted">Create a new account</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('auth.register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium">Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
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

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-medium">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>

                        @if ($redirect_to)
                            <input type="hidden" name="redirect_to" value="{{ $redirect_to }}">
                        @endif

                        <button type="submit" class="btn btn-dark w-100">Register</button>
                    </form>
                </div>
            </div>

            <p class="text-center mt-3">
                <a href="{{ route('auth.login', $redirect_to ? ['redirect_to' => $redirect_to] : []) }}" class="text-decoration-none">Already have an account? Sign in</a>
            </p>
            <p class="text-center mt-2">
                <a href="{{ route('books.index') }}" class="text-decoration-none text-muted small">&larr; Back to Books</a>
            </p>
        </div>
    </div>
</body>
</html>
