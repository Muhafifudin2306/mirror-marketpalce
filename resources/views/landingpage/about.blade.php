@extends('landingpage.index')
@section('content')
    <br><br><br><br>

    <div class="container-fluid px-3">
        <div class="position-relative mb-5">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/banner_comp4.png') }}" alt="CTA Image">
            <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
                <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Pertanyaan yang Sering</h3>
                <h3 class="mb-8" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;">Sinau Print
                </h3>
                <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">Pelajari
                    informasi perusahaan dan kenali lebih</p>
                <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">dekat
                    layanan dari Sinau Print</p>
            </div>
        </div>
    </div>

    <div class="container p-5">
        <div class="text-about">
            <div class="row">
                <div class="d-flex position-relative align-items-center mb-3">
                    <p class="additional-label"></p>
                    <div class="">
                        <span
                            style="font-family: 'Poppins'; font-size:1.1rem; font-weight:600; color:#444444;margin-left:1rem">VISI
                            KAMI
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <h1 class="mb-0" class="fs-1"
                        style="font-family: 'Poppins'; font-size:4.5rem; font-weight:600; color:#000;">Solusi
                        Cetak</h1>
                    <h1 class="mb-4" class="fs-1"
                        style="font-family: 'Poppins'; font-size:4.5rem; font-weight:600; color:#0439a0;">Tanpa
                        Batas</h1>
                </div>
                <div class="col-xl-6">
                    <p align="justify">Sejak 2024, Sinau Print selalu berkomitmen untuk menjadi penyedia jasa printing
                        terbaik di Semarang. Dengan berbekal pengalaman dan teknologi mesin paling mutakhir, kami siap cetak
                        segala kebutuhanmu.
                        <br><br>
                        Sinau Print mengedepankan aksesibilitas dan pelayanan utama untuk dapat menjangkau berbagai
                        pelanggan di mana saja dan kapan saja dengan #SolusiCetakTanpaBatas untuk pelanggannya.
                    </p>
                </div>
            </div>
            <img class="w-100 mt-4" src="{{ asset('landingpage/img/Pelatihan-Kerja.jpg') }}"
                style="border-radius:1rem;object-fit: cover" height="625">
        </div>
    </div>

    <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="position-relative">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/login_register_bg.png') }}" alt="Background" />

            <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3 feedback-container">
                {{-- Judul dinaikkan --}}
                <h3 class="mb-5" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">
                    Kata Mereka <span style="color:#ffc74c;">Tentang Sinau Print</span>
                </h3>

                {{-- Swiper --}}
                <div class="swiper feedback-swiper">
                    <div class="swiper-wrapper">
                        @php
                            $dummy = [
                                "Pelayanan yang sangat ramah\ndibantu sampai selesai",
                                'Cepat sekali pengerjaannya!',
                                "Mau online atau offline,\nmudah banget dan cepat!",
                                'Warna nya bagus!',
                                'Kualitas cetak juara!',
                            ];
                            $names = ['Andi', 'Budi', 'Citra', 'Dewi', 'Eka'];
                            $addrs = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan'];
                        @endphp

                        {{-- 5 slide asli + clone 10× --}}
                        @for ($clone = 0; $clone < 11; $clone++)
                            @foreach ($dummy as $i => $text)
                                <div class="swiper-slide">
                                    <div class="card mx-auto position-relative"
                                        style="max-width:400px; height:260px; border-radius:10px; background-color:#4a87dd;">

                                        <div class="card-body d-flex flex-column justify-content-start h-100">
                                            {{-- tanda kutip besar di atas --}}
                                            <div class="text-start">
                                                <span
                                                    style="font-size:4rem; line-height:1; color:rgba(255,255,255,0.3);">“</span>
                                            </div>

                                            {{-- teks quote dinaikkan --}}
                                            <h4 class="card-text text-white"
                                                style="font-family: 'Barlow', sans-serif;white-space:pre-line; margin-top:-1rem; margin-bottom:1rem;">
                                                {{ $text }}
                                            </h4>

                                            {{-- foto + nama + alamat absolute --}}
                                            <img src="{{ asset('landingpage/img/testimonial' . ($i + 1) . '.jpg') }}"
                                                alt="Foto testimonial {{ $i + 1 }}" class="rounded-circle"
                                                style="width:48px; height:48px; object-fit:cover;
                             position:absolute; bottom:10px; left:10px;" />
                                            <div style="position:absolute; bottom:12px; left:68px; text-align:left;">
                                                <div class="text-warning fw-bold" style="line-height:1;">
                                                    {{ $names[$i] }}
                                                </div>
                                                <div class="text-white small">
                                                    {{ $addrs[$i] }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endfor

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.feedback-swiper', {
                slidesPerView: 3,
                spaceBetween: 30,
                speed: 10000,
                freeMode: {
                    enabled: true,
                    momentum: false,
                    sticky: false,
                },
                autoplay: {
                    delay: 0,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: false,
                },
                allowTouchMove: false,
                loop: false,
            });
        });
    </script>
@endsection
