{{-- resources/views/errors/404.blade.php --}}
@extends('landingpage.index')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
    <link rel="stylesheet" href="{{ asset('landingpage/css/homepage.css') }}">

    <div class="py-4 my-4"></div>

    <div class="container-fluid">
        <div class="slide w-100 p-xl-5 p-3 rounded"
            style="background-image: url({{ asset('landingpage/img/bg_404.png') }}); height: 550px; background-size: cover;">
            <div class="string-cover m-5">
                <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:600; color:#fff;">
                    Oops! Halamannya
                </h3>
                <h3 class="mb-4" style="margin-top:-5px !important; font-family: 'Poppins'; font-size:3.3rem; font-weight:600; color:#ffc74c;">
                    belum ketemu nih
                </h3>
                
                <p class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:350; font-size:0.9rem; color:#fff;">
                    Halaman ini mungkin sudah kedaluwarsa atau dihapus.
                </p>
                <p class="mb-0" style="font-family: 'Poppins', sans-serif; font-weight:350; font-size:0.9rem; color:#fff;">
                    Silahkan cek halaman lainnya ya!
                </p>
                
                <br>
                
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ url('/') }}" class="btn-schedule mt-3 fw-bold">
                        <span class="btn-text">KEMBALI KE BERANDA</span>
                    </a>
                    
                    <a href="{{ url('/products') }}" class="btn-schedule mt-3 fw-bold">
                        <span class="btn-text">SEMUA PRODUK</span>
                        <span class="btn-arrow">
                            <i class="bi bi-arrow-right-short arrow-out fs-2"></i>
                            <i class="bi bi-arrow-right-short arrow-in fs-2"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .string-cover h3 {
                font-size: 2.5rem !important;
            }
            
            .string-cover p {
                font-size: 0.8rem !important;
            }
            
            .d-flex.gap-3 {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .btn-schedule {
                width: auto;
            }
        }

        @media (max-width: 576px) {
            .string-cover h3 {
                font-size: 2rem !important;
            }
            
            .string-cover {
                margin: 2rem !important;
            }
            
            .slide {
                height: 450px !important;
            }
        }
    </style>
@endsection