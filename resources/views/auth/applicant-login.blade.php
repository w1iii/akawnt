@extends('layouts.auth')

@section('title', 'Applicant Login')

@section('content')
    <!-- Left Section: Branding & Description -->
    <div class="auth-left">
        <h1>Akawnt</h1>
        <p>We help businesses stay organized, compliant, and financially confident so they can focus on what truly matters.</p>
    </div>

    <!-- Right Section: Login Form -->
    <div class="auth-right">
        <div class="auth-form-wrapper">
            <div class="auth-card">
                <h3>Welcome Back</h3>
                <p class="subtitle">Sign in to your applicant account</p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" value="{{ old('email') }}" required autofocus>
                        @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-submit">Login</button>
                </form>

                <div class="auth-divider">
                    <span>New to Akawnt?</span>
                </div>

                <div class="auth-footer">
                    <p class="mb-0"><a href="{{ route('home') }}#contact">Apply for an account</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
