@extends('layouts.auth')

@section('title', 'Admin Registration')

@section('content')
    <!-- Left Section: Branding & Description -->
    <div class="auth-left">
        <h1>Akawnt</h1>
        <p>We help businesses stay organized, compliant, and financially confident so they can focus on what truly matters.</p>
    </div>

    <!-- Right Section: Register Form -->
    <div class="auth-right">
        <div class="auth-form-wrapper">
            <div class="auth-card">
                <h3>Admin Registration</h3>
                <p class="subtitle">Create your admin account</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.register.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" value="{{ old('email') }}" required>
                        <small class="text-muted">Must be a whitelisted admin email</small>
                        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 characters" required>
                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password" required>
                        @error('password_confirmation')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-submit">Register</button>
                </form>

                <div class="auth-divider">
                    <span>Already have an account?</span>
                </div>

                <div class="auth-footer">
                    <p class="mb-0"><a href="{{ route('admin.login') }}">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection