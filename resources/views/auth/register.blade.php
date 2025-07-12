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
    
    /* Responsive adjustments */
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
        .form-control {
            height: 40px;
            font-size: 0.8rem;
        }
        .form-label {
            font-size: 0.75rem;
        }
    }
    
    .terms-text {
        font-size: 0.75rem;
        color: #888888;
        line-height: 1.4;
    }
    
    .terms-link {
        color: #888888 !important;
        text-decoration: underline;
        font-size: 0.75rem;
        padding: 0 !important;
    }
    
    .terms-link:hover {
        color: #0439a0 !important;
    }
</style>

<div class="container-fluid overlay-bg d-flex align-items-center">
    <div class="row w-100">
        <div class="col-md-6 d-flex align-items-center justify-content-center login-left px-4">
            <div>
                <h1>Jangan Lupa</h1>
                <h1 style="color:#ffc74c; text-align: left;">Daftar Akun, Ya!</h1>
                <p>Bikin akun dulu, lalu cetak kebutuhanmu <b>secara online!</b></p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card p-3 shadow" style="width: 100%; max-width: 480px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="first_name" class="form-label text-start w-100">NAMA DEPAN</label>
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" placeholder="masukkan nama depan"
                                    value="{{ old('first_name') }}" required autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last_name" class="form-label text-start w-100">NAMA BELAKANG</label>
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    name="last_name" placeholder="masukkan nama belakang"
                                    value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="phone" class="form-label text-start w-100">NOMOR TELEPON</label>
                                <input id="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" placeholder="contoh: 081234567890"
                                    value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label text-start w-100">EMAIL</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="masukkan email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label text-start w-100">PASSWORD</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="masukkan password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password-confirm" class="form-label text-start w-100">KONFIRMASI PASSWORD</label>
                                <input id="password-confirm" type="password"
                                    class="form-control"
                                    name="password_confirmation" placeholder="ulangi password" required>
                            </div>
                        </div>
                        <div class="d-grid mb-3" style="height: 48px;">
                            <button type="submit" class="btn btn-primary" style="background-color: #0258d3;">
                                BUAT AKUN
                            </button>
                        </div>
                    </form>
                    <div class="text-center">
                        <span style="font-size: 0.875rem;">Sudah punya akun?</span>
                        <a class="btn btn-link" href="{{ route('login') }}">Login Sekarang!</a>
                    </div>
                    <div class="text-center mt-2">
                        <span class="terms-text">Dengan mendaftar, kamu menyetujui segala bentuk
                            <a href="{{ url('/syarat-penggunaan') }}" class="terms-link">Syarat & Ketentuan</a>
                            serta
                            <a href="{{ url('/kebijakan-privasi') }}" class="terms-link">Kebijakan Privasi Kami</a>.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection