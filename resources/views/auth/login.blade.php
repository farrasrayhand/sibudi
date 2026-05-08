@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center" style="min-height: 80vh; display: flex; align-items: center;">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="text-primary mb-2">
                        <i class="bi bi-shield-check" style="font-size: 2.5rem;"></i>
                    </h2>
                    <h3 class="fw-bold">Buku Tamu Pemerintahan</h3>
                    <p class="text-muted">Login Administrator</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ $errors->first('credentials') }}
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" 
                                   placeholder="Masukkan username" required autofocus value="{{ old('username') }}">
                        </div>
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Masukkan password" required>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold py-2 btn-custom">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                <hr class="my-4">

                <div class="alert alert-info small" role="alert">
                    <strong>Demo Credentials:</strong>
                    <br>Username: <code>admin</code>
                    <br>Password: <code>admin123</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
