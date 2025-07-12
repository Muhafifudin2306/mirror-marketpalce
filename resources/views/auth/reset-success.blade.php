@extends('layouts.app')
@section('content')
<style>
    .card {
        border-radius: 0.8rem !important;
        font-family: 'Poppins', sans-serif;
    }
    .btn-primary {
        border-radius: 40px;
        font-weight: 600;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
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
    .success-icon {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 1rem;
    }
    .success-message {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1rem;
        font-weight: 500;
        color: #333;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .countdown {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        color: #666;
        text-align: center;
        margin-bottom: 1rem;
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
                <h1>Password Berhasil</h1>
                <h1 style="color:#ffc74c; text-align: left;">Direset!</h1>
                <p>Sekarang Anda dapat login dengan password baru Anda.</p>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="card p-3 shadow" style="width: 100%; max-width: 440px;">
                <div class="card-body text-center">
                    <div class="success-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    
                    <div class="success-message">
                        Password Anda berhasil direset!<br>
                        Silakan login dengan password baru Anda.
                    </div>
                    
                    <div class="countdown" id="countdown">
                        Anda akan diarahkan ke halaman login dalam <span id="timer">5</span> detik...
                    </div>

                    <div class="d-grid mb-3" style="height: 48px;">
                        <a href="{{ route('login') }}" class="btn btn-primary" style="background-color: #0258d3; line-height: 32px;">
                            LOGIN SEKARANG
                        </a>
                    </div>
                    
                    <div class="text-center">
                        <a href="{{ url('/') }}" style="color: #0439a0; text-decoration: none; font-size: 0.875rem; font-family: 'Poppins', sans-serif;">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let timeLeft = 5;
const timerElement = document.getElementById('timer');
const countdownElement = document.getElementById('countdown');

const countdown = setInterval(function() {
    timeLeft--;
    timerElement.textContent = timeLeft;
    
    if (timeLeft <= 0) {
        clearInterval(countdown);
        window.location.href = "{{ route('login') }}";
    }
}, 1000);
</script>
@endsection