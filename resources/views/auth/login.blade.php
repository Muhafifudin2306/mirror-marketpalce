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
                <h1>Yuk Login Dulu</h1>
                <h1 style="color:#ffc74c; text-align: left;">untuk Checkout!</h1>
                <p>Butuh bantuan? <a href="#">Baca FAQ</a> atau <a href="#">Hubungi Kami</a></p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card p-4 shadow" style="width: 100%; max-width: 550px;">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
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

                        <div class="mb-4">
                            <label for="password" class="form-label text-start w-100">PASSWORD</label>
                            <input id="password" type="password"
                                   placeholder="masukkan password anda"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3" style="height: 60px;">
                            <button type="submit" class="btn btn-primary" style="background-color: #0258d3;">
                                MASUK
                            </button>
                        </div>
                    </form>
                    <div class="text-center">
                        <span>Belum punya akun?</span>
                        <a class="btn btn-link" href="{{ route('register') }}">Buat dulu sekarang!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
