@extends('layouts.app')
@section('content')
<style>
    .card {
        border-radius: 1rem !important;
        font-family: 'Poppins', sans-serif;
    }
    .form-control {
        border-radius: 50px !important;
        padding: 0.75rem 1.25rem;
        height: 55px;
        font-family: 'Poppins', sans-serif;
    }
    .form-control::placeholder {
        color: #c3c3c3;
        opacity: 1;     
        font-family: 'Poppins', sans-serif;
    }
    .form-label {
        font-weight: 500;
        font-family: 'Poppins', sans-serif;
        color: #444444;
    }
    .btn-primary {
        border-radius: 50px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
    }
    .btn-link {
        font-family: 'Poppins', sans-serif;
        color: #0439a0;
        font-weight: 600;
        text-decoration: none;
    }
    .login-left h1 {
        font-family: 'Poppins', sans-serif;
        font-size: 4rem;
        font-weight: 600;
        text-align: left;
    }
    .login-left p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.2rem;
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
        font-size: 0.6rem;
        font-weight: 200;
    }
</style>

<div class="container-fluid overlay-bg d-flex align-items-center">
    <div class="row w-100">
        <div class="col-md-6 d-flex align-items-center justify-content-center login-left px-5">
            <div>
                <h1>Jangan Lupa</h1>
                <h1 style="color:#ffc74c; text-align: left;">Daftar Akun, Ya!</h1>
                <p>Bikin akun dulu, lalu cetak kebutuhanmu <b>secara online!</b></p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="first_name" class="form-label text-start w-100">Nama Depan</label>
                                <input id="first_name" type="text"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" placeholder="Masukkan nama depan"
                                    value="{{ old('first_name') }}" required autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="last_name" class="form-label text-start w-100">Nama Belakang</label>
                                <input id="last_name" type="text"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    name="last_name" placeholder="Masukkan nama belakang"
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
                                <label for="hp" class="form-label text-start w-100">Nomor Telepon</label>
                                <input id="hp" type="text"
                                    class="form-control @error('hp') is-invalid @enderror"
                                    name="hp" placeholder="Contoh: 081234567890"
                                    value="{{ old('hp') }}" required>
                                @error('hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label for="email" class="form-label text-start w-100">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" placeholder="Masukkan email"
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
                                <label for="password" class="form-label text-start w-100">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" placeholder="Masukkan password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="password-confirm" class="form-label text-start w-100">Konfirmasi Password</label>
                                <input id="password-confirm" type="password"
                                    class="form-control"
                                    name="password_confirmation" placeholder="Ulangi password" required>
                            </div>
                        </div>
                        <div class="d-grid mb-3" style="height: 60px;">
                            <button type="submit" class="btn btn-primary" style="background-color: #0258d3;">
                                Buat Akun
                            </button>
                        </div>
                    </form>
                    <div class="text-center">
                        <span>Sudah punya akun?</span>
                        <a class="btn btn-link" href="{{ route('login') }}">Login Sekarang!</a>
                    </div>
                    <div class="text-center mt-3">
                        <span style="color:#888888">Dengan mendaftar, kamu menyetujui segala bentuk
                            <a href="#" class="btn btn-link p-0" style="text-decoration: underline; color:#888888;">Syarat & Ketentuan</a>
                            serta
                            <a href="#" class="btn btn-link p-0" style="text-decoration: underline; color:#888888;">Kebijakan Privasi Kami</a>.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
