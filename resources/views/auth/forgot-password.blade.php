@extends('layouts.app')
@section('content')
<style>
    .card {
        border-radius: 0.8rem !important;
        font-family: 'Poppins', sans-serif;
    }
    .form-control {
        border-radius: 40px !important;
        padding: 0.6rem 1rem;
        height: 44px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
    }
    .form-control::placeholder {
        color: #c3c3c3;
        opacity: 1;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
    }
    .form-label {
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        color: #444444;
        font-size: 0.8rem;
    }
    .btn-primary {
        border-radius: 40px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    .btn-link {
        font-family: 'Poppins', sans-serif;
        color: #0439a0;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.875rem;
    }
    .login-left h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 3.2rem;
        font-weight: 600;
        text-align: left;
    }
    .login-left p {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 500;
        color: #fff;
        text-align: left;
    }
    .login-left a {
        color: #fff;
    }
    .is-invalid {
        border-color: #fc2865 !important;
    }

    .invalid-feedback {
        display: block;
        color: #fc2865;
        font-size: 0.7rem;
        font-weight: 200;
    }

    .alert {
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.875rem;
    }

    .back-link {
        color: #0439a0;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        margin-bottom: 15px;
        display: inline-block;
    }

    .back-link:hover {
        color: #0258d3;
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .login-left h1 {
            font-size: 2.5rem;
        }
        .login-left p {
            font-size: 0.9rem;
        }
        .card {
            max-width: 90% !important;
        }
    }
</style>
<div class="container-fluid overlay-bg d-flex align-items-center">
    <div class="row w-100">
        <div class="col-md-6 d-flex align-items-center justify-content-center login-left px-4">
            <div>
                <h1>Lupa Password?</h1>
                <h1 style="color:#ffc74c; text-align: left;">Jangan Khawatir!</h1>
                <p>Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card p-3 shadow" style="width: 100%; max-width: 440px;">
                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label text-start w-100">EMAIL ANDA</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="masukkan email anda"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3" style="height: 48px;">
                            <button type="submit" class="btn btn-primary" style="background-color: #0258d3;">
                                KIRIM LINK RESET
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center">
                        <span style="font-size: 0.875rem;">Ingat password Anda?</span>
                        <a class="btn btn-link" href="{{ route('login') }}">Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection