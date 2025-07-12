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

    .password-wrapper {
        position: relative;
    }

    .password-wrapper input.form-control {
        padding-right: 45px !important;
    }

    .eye-btn {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        background: none;
        border: none;
        font-size: 1rem;
        color: #999;
        cursor: pointer;
        padding: 0;
        line-height: 1;
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
                <h1>Reset Password</h1>
                <h1 style="color:#ffc74c; text-align: left;">Anda!</h1>
                <p>Masukkan password baru untuk akun Anda.</p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card p-3 shadow" style="width: 100%; max-width: 440px;">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                        
                        <div class="mb-3">
                            <label for="email_display" class="form-label text-start w-100">EMAIL ANDA</label>
                            <input id="email_display" type="email"
                                   class="form-control"
                                   placeholder="email anda"
                                   value="{{ $email ?? old('email') }}" disabled
                                   style="background-color: #f8f9fa !important; color: #6c757d !important;">
                            <small class="text-muted" style="font-size: 0.7rem; font-family: 'Poppins', sans-serif;">
                                Email tidak dapat diubah untuk keamanan
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-start w-100">PASSWORD BARU</label>
                            <div class="password-wrapper">
                                <input id="password" type="password"
                                       placeholder="masukkan password baru"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required>
                                <button type="button" class="eye-btn" onclick="togglePassword('password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-start w-100">KONFIRMASI PASSWORD</label>
                            <div class="password-wrapper">
                                <input id="password_confirmation" type="password"
                                       placeholder="konfirmasi password baru"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       name="password_confirmation" required>
                                <button type="button" class="eye-btn" onclick="togglePassword('password_confirmation', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid mb-3" style="height: 48px;">
                            <button type="submit" class="btn btn-primary" style="background-color: #0258d3;">
                                RESET PASSWORD
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center">
                        <a class="btn btn-link" href="{{ route('login') }}">Kembali ke Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon = btn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endsection