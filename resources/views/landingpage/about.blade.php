@extends('landingpage.index')
@section('content')
<style>
    .hero-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0;
    }
    .hero-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 3.2rem;
        font-weight: 600;
        color: #ffc74c;
        margin-bottom: 1.5rem;
    }
    .hero-description {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 350;
        color: #fff;
        margin-bottom: 0;
        line-height: 1.4;
    }

    .additional-label {
        width: 4px;
        height: 20px;
        background-color: #0439a0;
        border-radius: 2px;
    }
    .section-label {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: #444444;
        margin-left: 0.8rem;
    }
    .vision-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3.6rem;
        font-weight: 600;
        color: #000;
        margin-bottom: 0;
        line-height: 1.1;
    }
    .vision-title-highlight {
        font-family: 'Poppins', sans-serif;
        font-size: 3.6rem;
        font-weight: 600;
        color: #0439a0;
        margin-bottom: 1.2rem;
        line-height: 1.1;
    }
    .vision-description {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #333;
        text-align: justify;
    }

    .company-image {
        width: 100%;
        margin-top: 1.2rem;
        border-radius: 0.8rem;
        object-fit: cover;
        height: 500px;
    }

    .testimonial-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3rem;
        font-weight: 550;
        color: #fff;
        margin-bottom: 5rem;
    }
    .testimonial-highlight {
        color: #ffc74c;
    }
    .testimonial-infinite-scroll {
        width: 100%;
        overflow: hidden;
        position: relative;
        mask: linear-gradient(90deg, transparent, white 5%, white 95%, transparent);
        -webkit-mask: linear-gradient(90deg, transparent, white 5%, white 95%, transparent);
    }

    .testimonial-track {
        display: flex;
        gap: 30px;
        animation: scroll-testimonial var(--scroll-duration, 60s) linear infinite;
        width: max-content;
    }

    @keyframes scroll-testimonial {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(calc((430px * {{ $testimonials->count() > 0 ? $testimonials->count() : 5 }}) * -1));
        }
    }

    .testimonial-item {
        flex: 0 0 400px;
        user-select: none;
    }

    .feedback-container {
        position: relative;
    }

    .testimonial-card {
        position: relative;
        height: 230px;
        padding: 30px;
        border-radius: 10px;
        background-color: #4a87dd;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
        user-select: none;
        transition: transform 0.3s ease;
    }

    .quote-mark {
        position: absolute;
        top: 10px;
        left: 20px;
        font-size: 4rem;
        line-height: 1;
        color: rgba(255, 255, 255, 0.3);
        font-family: serif;
    }

    .testimonial-text {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 10px;
        font-family: 'Barlow', sans-serif;
        font-size: 1.1rem;
        color: white;
        text-align: center;
        line-height: 1.4;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: auto;
    }

    .author-photo {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .author-info {
        text-align: left;
    }

    .author-name {
        color: #ffc74c;
        font-weight: bold;
        line-height: 1.2;
        font-size: 0.95rem;
    }

    .author-location {
        color: white;
        font-size: 0.875rem;
        line-height: 1.2;
        opacity: 0.9;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .testimonial-item {
            flex: 0 0 350px;
        }
        
        @keyframes scroll-testimonial {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc((380px * {{ $testimonials->count() > 0 ? $testimonials->count() : 5 }}) * -1));
            }
        }
    }

    @media (max-width: 768px) {
        .hero-title, .hero-subtitle {
            font-size: 2.4rem;
        }
        .hero-description {
            font-size: 0.8rem;
        }
        .vision-title, .vision-title-highlight {
            font-size: 2.8rem;
        }
        .vision-description {
            font-size: 0.85rem;
        }
        .company-image {
            height: 300px;
            margin-top: 1rem;
        }
        .testimonial-title {
            font-size: 2rem;
        }
        .section-label {
            font-size: 0.8rem;
        }

        .testimonial-item {
            flex: 0 0 320px;
        }
        
        .testimonial-card {
            height: 200px;
            padding: 25px;
        }
        
        .testimonial-text {
            font-size: 1rem;
            padding: 15px 8px;
        }
        
        @keyframes scroll-testimonial {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc((350px * {{ $testimonials->count() > 0 ? $testimonials->count() : 5 }}) * -1));
            }
        }
    }

    @media (max-width: 576px) {
        .hero-title, .hero-subtitle {
            font-size: 2rem;
        }
        .vision-title, .vision-title-highlight {
            font-size: 2.2rem;
        }
        .company-image {
            height: 250px;
        }
        .quote-mark {
            font-size: 3rem;
        }

        .testimonial-item {
            flex: 0 0 280px;
        }
        
        .testimonial-card {
            height: 220px;
            padding: 20px;
        }
        
        .testimonial-text {
            font-size: 0.95rem;
            padding: 15px 5px;
        }
        
        @keyframes scroll-testimonial {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(calc((310px * {{ $testimonials->count() > 0 ? $testimonials->count() : 5 }}) * -1));
            }
        }
    }
</style>

<br><br><br><br>

<div class="container-fluid px-3">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/banner_comp4.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content" style="padding-left: 3rem;">
            <h3 class="hero-title">Tentang</h3>
            <h3 class="hero-subtitle">Sinau Print</h3>
            <p class="hero-description">Pelajari informasi perusahaan dan kenali lebih</p>
            <p class="hero-description">dekat layanan dari Sinau Print</p>
        </div>
    </div>
</div>

<div class="container p-4">
    <div class="text-about">
        <div class="row">
            <div class="d-flex position-relative align-items-center mb-3">
                <p class="additional-label"></p>
                <div class="">
                    <span class="section-label">VISI KAMI</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <h1 class="vision-title">Solusi Cetak</h1>
                <h1 class="vision-title-highlight">Tanpa Batas</h1>
            </div>
            <div class="col-xl-6">
                <p class="vision-description">Sejak 2024, Sinau Print selalu berkomitmen untuk menjadi penyedia jasa printing
                    terbaik di Semarang. Dengan berbekal pengalaman dan teknologi mesin paling mutakhir, kami siap cetak
                    segala kebutuhanmu.
                    <br><br>
                    Sinau Print mengedepankan aksesibilitas dan pelayanan utama untuk dapat menjangkau berbagai
                    pelanggan di mana saja dan kapan saja dengan #SolusiCetakTanpaBatas untuk pelanggannya.
                </p>
            </div>
        </div>
        <img class="company-image" src="{{ asset('landingpage/img/Pelatihan-Kerja.jpg') }}">
    </div>
</div>

<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/login_register_bg.png') }}" alt="Background" />

        <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3 feedback-container">
            <h3 class="testimonial-title">
                Kata Mereka <span class="testimonial-highlight">Tentang Sinau Print</span>
            </h3>

            {{-- TESTIMONIAL --}}
            <div class="testimonial-infinite-scroll" id="testimonialScroll">
                <div class="testimonial-track" id="testimonialTrack">
                    @if($testimonials->count() > 0)
                        @foreach($testimonials as $testimonial)
                            @php
                                $photoPath = $testimonial->photo ? 'storage/' . $testimonial->photo : null;
                                $photoExists = $photoPath && file_exists(public_path($photoPath));
                                $photoUrl = $photoExists ? asset($photoPath) : asset('landingpage/img/no-photo-icon.jpg');
                            @endphp
                            
                            <div class="testimonial-item">
                                <div class="testimonial-card">
                                    <div class="quote-mark">"</div>
                                    <div class="testimonial-text">
                                        {{ $testimonial->feedback }}
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ $photoUrl }}" alt="{{ $testimonial->name }}" class="author-photo"
                                            onerror="this.src='{{ asset('landingpage/img/no-photo-icon.jpg') }}'">
                                        <div class="author-info">
                                            <div class="author-name">{{ $testimonial->name }}</div>
                                            <div class="author-location">{{ $testimonial->location }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach($testimonials as $testimonial)
                            @php
                                $photoPath = $testimonial->photo ? 'storage/' . $testimonial->photo : null;
                                $photoExists = $photoPath && file_exists(public_path($photoPath));
                                $photoUrl = $photoExists ? asset($photoPath) : asset('landingpage/img/no-photo-icon.jpg');
                            @endphp
                            
                            <div class="testimonial-item">
                                <div class="testimonial-card">
                                    <div class="quote-mark">"</div>
                                    <div class="testimonial-text">
                                        {{ $testimonial->feedback }}
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ $photoUrl }}" alt="{{ $testimonial->name }}" class="author-photo"
                                            onerror="this.src='{{ asset('landingpage/img/no-photo-icon.jpg') }}'">
                                        <div class="author-info">
                                            <div class="author-name">{{ $testimonial->name }}</div>
                                            <div class="author-location">{{ $testimonial->location }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        @php
                            $dummyTestimonials = [
                                ['text' => "Pelayanan yang sangat ramah dibantu sampai selesai", 'name' => 'Andi', 'location' => 'Jakarta'],
                                ['text' => "Cepat sekali pengerjaannya!", 'name' => 'Budi', 'location' => 'Bandung'],
                                ['text' => "Mau online atau offline, mudah banget dan cepat!", 'name' => 'Citra', 'location' => 'Surabaya'],
                                ['text' => "Warna nya bagus banget!", 'name' => 'Dewi', 'location' => 'Yogyakarta'],
                                ['text' => "Kualitas cetak juara!", 'name' => 'Eka', 'location' => 'Medan'],
                            ];
                        @endphp
                        
                        @foreach($dummyTestimonials as $dummy)
                            <div class="testimonial-item">
                                <div class="testimonial-card">
                                    <div class="quote-mark">"</div>
                                    <div class="testimonial-text">
                                        {{ $dummy['text'] }}
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('landingpage/img/no-photo-icon.jpg') }}" 
                                            alt="{{ $dummy['name'] }}" class="author-photo">
                                        <div class="author-info">
                                            <div class="author-name">{{ $dummy['name'] }}</div>
                                            <div class="author-location">{{ $dummy['location'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @foreach($dummyTestimonials as $dummy)
                            <div class="testimonial-item">
                                <div class="testimonial-card">
                                    <div class="quote-mark">"</div>
                                    <div class="testimonial-text">
                                        {{ $dummy['text'] }}
                                    </div>
                                    <div class="testimonial-author">
                                        <img src="{{ asset('landingpage/img/no-photo-icon.jpg') }}" 
                                            alt="{{ $dummy['name'] }}" class="author-photo">
                                        <div class="author-info">
                                            <div class="author-name">{{ $dummy['name'] }}</div>
                                            <div class="author-location">{{ $dummy['location'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const testimonialCount = {{ $testimonials->count() > 0 ? $testimonials->count() : 5 }};
    const baseSpeed = 3;
    const totalDuration = testimonialCount * baseSpeed;
    
    document.documentElement.style.setProperty('--scroll-duration', `${totalDuration}s`);
});
</script>

@endsection