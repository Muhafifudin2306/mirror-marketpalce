@extends('landingpage.index')
@section('content')
<br><br><br><br>

{{-- Header Section --}}
<div class="container-fluid px-3 mb-5">
  <div class="position-relative mb-5">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/cara_pesan.png') }}" alt="CTA Image">
    <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
      <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Informasi dan</h3>
      <h3 class="mb-8" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;">Promo Spesial</h3>
      <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">Dapatkan info seputar dunia percetakan dan berbagai</p>
      <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">promo menarik yang sayang untuk dilewatkan.</p>
    </div>
  </div>
</div>

{{-- Artikel Pilihan Section --}}
<div class="container-xl mb-5">
    <div class="row align-items-center">
        <div class="col-md-12 position-relative">
            <div class="step-content">
                <h4 style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#444444;">ARTIKEL PILIHAN</h4>
                <h3 class="mb-4" style="margin-top:-5px !important;">
                    <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#000;">Artikel</span>
                    <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#0258d3;"> Pilihan</span>
                </h3>
            </div>
        </div>
    </div>
    
    <div id="artikelPilihanCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @php
                $featuredBlogs = $blogs->take(6);
            @endphp
            @foreach ($featuredBlogs->chunk(2) as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $blog)
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <a href="{{ route('landingpage.article_show', $blog->slug) }}" class="text-decoration-none">
                                    <div class="featured-article-card h-100">
                                        <div class="featured-article-image-container position-relative">
                                            @if($blog->banner && file_exists(storage_path('app/public/' . $blog->banner)))
                                                <img src="{{ asset('storage/' . $blog->banner) }}" alt="{{ $blog->title }}" class="featured-article-image">
                                            @else
                                                <img src="{{ asset('landingpage/img/nophoto_blog.png') }}" alt="{{ $blog->title }}" class="featured-article-image">
                                            @endif
                                            
                                            {{-- Content Overlay - Always visible at bottom --}}
                                            <div class="featured-article-content-overlay">
                                                {{-- Category and Date --}}
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="featured-article-category">
                                                        {{ strtoupper($blog->blog_type) }}
                                                    </span>
                                                    <span class="featured-article-date ms-auto">{{ $blog->created_at->format('d M Y') }}</span>
                                                </div>
                                                
                                                {{-- Title --}}
                                                <h4 class="featured-article-title">{{ $blog->title }}</h4>
                                            </div>
                                            
                                            {{-- Hover Overlay --}}
                                            <div class="featured-article-hover-overlay">
                                                <div class="overlay-content">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="carousel-controls-container">
            <div class="carousel-controls">
                <!-- Prev tombol -->
                <button class="carousel-control-prev" type="button" data-bs-target="#artikelPilihanCarousel" data-bs-slide="prev">
                    <span class="btn-arrow-carousel">
                        <span class="arrow-out">&#8592;</span>
                        <span class="arrow-in">&#8592;</span>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <!-- Next tombol -->
                <button class="carousel-control-next" type="button" data-bs-target="#artikelPilihanCarousel" data-bs-slide="next">
                    <span class="btn-arrow-carousel">
                        <span class="arrow-out">&#8594;</span>
                        <span class="arrow-in">&#8594;</span>
                    </span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <div class="carousel-indicators-custom" id="artikelPilihanIndicators">
                @foreach ($featuredBlogs->chunk(2) as $index => $chunk)
                    <div class="indicator-line {{ $index == 0 ? 'active' : '' }}" 
                         data-bs-target="#artikelPilihanCarousel" 
                         data-bs-slide-to="{{ $index }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Filter and Sort Section --}}
<div class="container mb-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-12">
            <div class="d-flex align-items-center">
                {{-- Filter --}}
                <div class="d-flex align-items-center me-5">
                    <span class="me-3" style="font-family: 'Poppins'; font-weight: 500; color: #666;">FILTER</span>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle px-4 py-2" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 25px; min-width: 200px; text-align: left;">
                            @if($filter == 'semua') SEMUA ARTIKEL
                            @else {{ strtoupper($filter) }}
                            @endif
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['filter' => 'semua']) }}">SEMUA ARTIKEL</a></li>
                            @foreach(['Promo Sinau','Printips','Company','Printutor'] as $type)
                                <li>
                                    <a class="dropdown-item" 
                                    href="{{ request()->fullUrlWithQuery(['filter' => $type]) }}">
                                    {{ strtoupper($type) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <div class="d-flex align-items-center">
                    <span class="me-3" style="font-family: 'Poppins'; font-weight: 500; color: #666;">SORTIR</span>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle px-4 py-2" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 25px; min-width: 200px; text-align: left;">
                            @if($sort == 'terlama') ARTIKEL TERLAMA
                            @else ARTIKEL TERBARU
                            @endif
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}">ARTIKEL TERBARU</a></li>
                            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'terlama']) }}">ARTIKEL TERLAMA</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Articles Grid Section --}}
<div class="container mb-5">
    <div class="row g-4">
        @forelse($blogs as $blog)
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="{{ route('landingpage.article_show', $blog->slug) }}" class="text-decoration-none">
                <div class="article-card-home h-100" style="border-radius:10px;">
                    <div class="position-relative bg-light overflow-hidden article-image-container-home" style="border-radius:10px; height:170px;">
                        @if($blog->banner && file_exists(storage_path('app/public/' . $blog->banner)))
                            <img src="{{ asset('storage/' . $blog->banner) }}"
                                class="img-fluid w-100 h-100 article-image-home" style="object-fit:cover;" 
                                alt="{{ $blog->title }}">
                        @else
                            <img src="{{ asset('landingpage/img/nophoto_blog.png') }}"
                                class="img-fluid w-100 h-100 article-image-home" style="object-fit:cover;"
                                alt="No Image">
                        @endif
                        
                        {{-- Overlay yang muncul saat hover --}}
                        <div class="article-overlay-home">
                            <div class="overlay-content-home">
                                <span class="read-more-text-home">Baca Selengkapnya</span>
                                <div class="arrow-circle-home">
                                    <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content p-3 d-flex flex-column" style="min-height:140px;">
                        <div class="article-category-home mb-2" style="font-family: 'Poppins'; font-size:0.7rem; font-weight:600; color:#666;">
                            {{-- Updated: Use blog type instead of hardcoded categories --}}
                            {{ strtoupper($blog->blog_type ?? 'ARTIKEL') }}
                            <span class="article-date-home ms-auto" style="color:#999;">{{ $blog->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="title text-dark mb-0"
                            style="font-family: 'Poppins'; font-size:1.1rem; font-weight:600;">
                            {{ Str::limit($blog->title, 50) }}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p style="font-family: 'Poppins'; color: #666;">Belum ada artikel yang tersedia.</p>
        </div>
        @endforelse
    </div>
    
    {{-- Pagination --}}
    @if($blogs->hasPages())
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $blogs->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#fff;">Kantormu Lagi Ada Acara?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#ffc74c;">Cetak Banner Sekarang!</h3>
            <a href="{{ url('/products') }}" class="btn-schedule">
            <span class="btn-text">SEMUA PRODUK</span>
            <span class="btn-arrow">
                <i class="bi bi-arrow-right arrow-out"></i>
                <i class="bi bi-arrow-right arrow-in"></i>
            </span>
            </a>
        </div>
    </div>
</div>

<style>
/* Style untuk card artikel - mirip dengan card produk (dari home) */
.article-card-home {
    background: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.article-card-home:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.article-image-container-home {
    position: relative;
    overflow: hidden;
}

.article-image-home {
    transition: transform 0.3s ease;
}

.article-card-home:hover .article-image-home {
    transform: scale(1.05);
}

/* Overlay yang muncul saat hover */
.article-overlay-home {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(59, 130, 246, 0) 0%, rgba(59, 130, 246, 0.8) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: 10px;
}

.article-card-home:hover .article-overlay-home {
    opacity: 1;
}

.overlay-content-home {
    text-align: center;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.read-more-text-home {
    font-family: 'Poppins';
    font-size: 0.9rem;
    font-weight: 600;
    color: #fff;
}

.arrow-circle-home {
    width: 30px;
    height: 30px;
    border: 2px solid #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.arrow-circle-home i {
    font-size: 14px;
    color: #fff;
}

.article-card-home:hover .arrow-circle-home {
    background: #fff;
}

.article-card-home:hover .arrow-circle-home i {
    color: #3b82f6;
}

/* Style untuk kategori dan tanggal */
.article-category-home {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.article-date-home {
    font-size: 0.7rem !important;
    font-weight: 400 !important;
}

/* Responsive */
@media (max-width: 768px) {
    .article-card-home {
        margin-bottom: 20px;
    }
}

@media (max-width: 576px) {
    .read-more-text-home {
        font-size: 0.8rem;
    }
    
    .arrow-circle-home {
        width: 25px;
        height: 25px;
    }
    
    .arrow-circle-home i {
        font-size: 12px;
    }
}
.featured-article-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 100%;
    aspect-ratio: 2/1; /* Lebar : Tinggi = 2:1 (tinggi = setengah lebar) */
    height: auto; /* Let aspect-ratio control the height */
}

.featured-article-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.2);
}

.featured-article-image-container {
    height: 100%;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.featured-article-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.featured-article-card:hover .featured-article-image {
    transform: scale(1.05);
}

/* Content Overlay - Always visible at bottom with blue gradient */
.featured-article-content-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(180deg, rgba(59, 130, 246, 0) 0%, rgba(59, 130, 246, 0.6) 100%);
    color: white;
    padding: 24px;
    z-index: 2;
    transition: all 0.3s ease;
}

/* Hover effect - gradient expands upward */
.featured-article-card:hover .featured-article-content-overlay {
    background: linear-gradient(180deg, rgba(59, 130, 246, 0) 20%, rgba(59, 130, 246, 0.7) 100%);
    padding-top: 40px; /* Expand the overlay area upward */
}

.featured-article-category {
    font-family: 'Poppins';
    font-size: 0.8rem;
    font-weight: 700;
    color: #ffc74c;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: rgba(255, 199, 76, 0.2);
    padding: 4px 12px;
    border-radius: 20px;
    border: 1px solid rgba(255, 199, 76, 0.4);
}

.featured-article-date {
    font-family: 'Poppins';
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
}

.featured-article-title {
    font-family: 'Poppins';
    font-size: 1.4rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

/* Carousel Column Adjustments for Equal Width with Margins */
.carousel-item .row .col-lg-6 {
    flex: 0 0 50%; /* Each card takes exactly 50% width */
    max-width: 50%;
    padding: 0 15px; /* Increased padding for more spacing */
}

/* Container adjustments for side margins */
.container-xl {
    max-width: 90%; /* Set max width instead of 100% */
    padding-left: 10px; /* Side margins */
    padding-right: 10px; /* Side margins */
    margin: 0 auto; /* Center the container */
}

/* Remove default Bootstrap gaps for perfect equal sizing */
.carousel-item .row {
    margin-left: 0;
    margin-right: 0;
    --bs-gutter-x: 30px; /* Increased gap between cards */
}

.carousel-item .row > * {
    padding-left: calc(var(--bs-gutter-x) * 0.5);
    padding-right: calc(var(--bs-gutter-x) * 0.5);
}

/* Carousel Controls Style dengan animasi seperti btn-schedule */
.carousel-controls-container {
    position: relative;
    margin-top: 2rem;
}

.carousel-controls {
    display: flex;
    justify-content: flex-start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.carousel-control-prev,
.carousel-control-next {
    position: static;
    width: auto;
    height: auto;
    opacity: 1;
    margin: 0;
    background: none;
    border: none;
}

.btn-arrow-carousel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: #fff;
    border: 2px solid #e5e5e5;
    border-radius: 50%;
    color: #666;
    font-size: 1.2rem;
    font-weight: bold;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-arrow-carousel .arrow-out {
    transition: transform 0.3s ease;
    opacity: 1;
}

.btn-arrow-carousel .arrow-in {
    position: absolute;
    transition: transform 0.3s ease;
    opacity: 0;
}

/* Initial positions - hanya arrow-out yang terlihat */
.carousel-control-prev .btn-arrow-carousel .arrow-in {
    transform: translateX(-100%);
}

.carousel-control-next .btn-arrow-carousel .arrow-in {
    transform: translateX(100%);
}

/* Hover animations */
.btn-arrow-carousel:hover {
    background: #3b82f6;
    border-color: #3b82f6;
    color: #fff;
    transform: scale(1.1);
}

.btn-arrow-carousel:hover .arrow-out {
    opacity: 0;
}

.btn-arrow-carousel:hover .arrow-in {
    opacity: 1;
}

.carousel-control-prev .btn-arrow-carousel:hover .arrow-out {
    transform: translateX(-100%);
}

.carousel-control-prev .btn-arrow-carousel:hover .arrow-in {
    transform: translateX(0);
}

.carousel-control-next .btn-arrow-carousel:hover .arrow-out {
    transform: translateX(100%);
}

.carousel-control-next .btn-arrow-carousel:hover .arrow-in {
    transform: translateX(0);
}

/* Indicators tanpa gap */
.carousel-indicators-custom {
    display: flex;
    width: 100%;
    justify-content: flex-start;
    padding-left: 130px; /* Space for arrows */
    padding-right: 0;
}

.indicator-line {
    flex: 1;
    height: 2px;
    background: #e5e5e5;
    transition: all 0.3s ease;
    cursor: pointer;
    min-width: 40px;
}

.indicator-line.active {
    background: #92bcff;
    height: 4px;
}

.indicator-line:hover {
    background: #93c5fd;
}

/* Regular Article Card Styles */
.article-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.article-image-container {
    height: 250px;
    overflow: hidden;
}

.article-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    border-radius: 12px 12px 12px 12px;
}

.article-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(180deg, rgba(59, 130, 246, 0) 0%, rgba(59, 130, 246, 0.9) 100%);
    color: white;
    padding: 20px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
    border-radius: 0 0 12px 12px;
}

.article-card:hover .article-overlay {
    transform: translateY(0);
}

.article-card:hover .article-image {
    transform: scale(1.05);
}

.article-content {
    background: #fff;
    min-height: 120px;
}

.article-category {
    font-family: 'Poppins';
    font-size: 0.75rem;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.article-date {
    font-family: 'Poppins';
    font-size: 0.75rem;
    color: #999;
}

.article-title {
    font-family: 'Poppins';
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    line-height: 1.4;
    margin-bottom: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 60px;
}

.article-card a:hover .article-title {
    color: #3b82f6;
}

/* Dropdown Styles */
.dropdown-toggle::after {
    margin-left: auto;
}

.dropdown-menu {
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border: none;
}

.dropdown-item {
    font-family: 'Poppins';
    font-weight: 500;
    padding: 10px 20px;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #3b82f6;
}

/* CTA Section Styles */
.cta-content {
    padding-left: 50px;
}

.btn-schedule {
    display: inline-flex;
    align-items: center;
    background: none;
    color: #fff;
    text-decoration: none;
    padding: 12px 24px;
    border-radius: 30px;
    font-family: 'Poppins';
    font-weight: 600;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
    margin-top: 20px;
}

.btn-schedule:hover {
    background: #fff;
    color: #333;
    transform: translateY(-2px);
}

.btn-text {
    transition: transform 0.3s ease;
}

.btn-arrow {
    margin-left: 10px;
    transition: transform 0.3s ease;
    position: relative;
    width: 20px;
    height: 20px;
    overflow: hidden;
}

.btn-arrow .arrow-out {
    transition: transform 0.3s ease;
    position: absolute;
    top: 0;
    left: 0;
}

.btn-arrow .arrow-in {
    transition: transform 0.3s ease;
    position: absolute;
    top: 0;
    left: 20px;
}

.btn-schedule:hover .btn-arrow .arrow-out {
    transform: translateX(-20px);
}

.btn-schedule:hover .btn-arrow .arrow-in {
    transform: translateX(-20px);
}

/* Responsive adjustments for equal sizing */
@media (max-width: 992px) {
    .carousel-item .row .col-lg-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    
    .featured-article-card {
        aspect-ratio: 1.8/1; /* Slightly taller on tablet */
    }
    
    .featured-article-title {
        font-size: 1.2rem;
    }
    
    .featured-article-content-overlay {
        padding: 20px;
    }
    
    .container-xl {
        padding-left: 30px;
        padding-right: 30px;
    }
}

@media (max-width: 768px) {
    .cta-content h3 {
        font-size: 2.5rem !important;
    }
    
    .carousel-item .row .col-lg-6 {
        flex: 0 0 100%; /* Stack cards vertically on mobile */
        max-width: 100%;
        margin-bottom: 20px;
    }
    
    .featured-article-card {
        aspect-ratio: 2/1; /* Maintain 2:1 ratio on mobile */
    }
    
    .featured-article-title {
        font-size: 1.1rem;
        -webkit-line-clamp: 2;
    }
    
    .featured-article-category {
        font-size: 0.7rem;
        padding: 3px 10px;
    }
    
    .featured-article-date {
        font-size: 0.7rem;
    }
    
    .featured-article-content-overlay {
        padding: 16px;
    }
    
    .featured-article-card:hover .featured-article-content-overlay {
        padding-top: 30px;
    }
    
    .article-card {
        margin-bottom: 20px;
    }
    
    .container-fluid.px-3 {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    
    .d-flex.align-items-center {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }
    
    .d-flex.align-items-center .me-5 {
        margin-right: 0 !important;
        margin-bottom: 1rem;
    }
    
    .carousel-indicators-custom {
        padding-left: 0;
        flex-wrap: wrap;
    }
    
    .indicator-line {
        min-width: 30px;
        flex: none;
        width: 30px;
    }
    
    .cta-content {
        padding-left: 20px;
    }
    
    .container-xl {
        padding-left: 20px;
        padding-right: 20px;
    }
}

@media (max-width: 576px) {
    .featured-article-card {
        aspect-ratio: 1.6/1; /* Slightly different ratio for very small screens */
    }
    
    .featured-article-title {
        font-size: 1rem;
        -webkit-line-clamp: 3;
    }
    
    .featured-article-content-overlay {
        padding: 12px;
    }
    
    .featured-article-card:hover .featured-article-content-overlay {
        padding-top: 24px;
    }
    
    .cta-content h3 {
        font-size: 2rem !important;
    }
    
    .btn-schedule {
        padding: 10px 20px;
        font-size: 0.8rem;
    }
    
    .container-xl {
        padding-left: 15px;
        padding-right: 15px;
    }
}

/* Additional utility styles */
.position-relative {
    position: relative;
}

.position-absolute {
    position: absolute;
}

.top-50 {
    top: 50%;
}

.start-0 {
    left: 0;
}

.translate-middle-y {
    transform: translateY(-50%);
}

.w-100 {
    width: 100%;
}

.h-100 {
    height: 100%;
}

.rounded {
    border-radius: 0.375rem;
}

.text-decoration-none {
    text-decoration: none;
}

.d-flex {
    display: flex;
}

.align-items-center {
    align-items: center;
}

.justify-content-center {
    justify-content: center;
}

.ms-auto {
    margin-left: auto;
}

.ms-2 {
    margin-left: 0.5rem;
}

.mb-0 {
    margin-bottom: 0;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

.mb-3 {
    margin-bottom: 1rem;
}

.mb-4 {
    margin-bottom: 1.5rem;
}

.mb-5 {
    margin-bottom: 3rem;
}

.mb-8 {
    margin-bottom: 2rem;
}

.mt-0 {
    margin-top: 0;
}

.mt-5 {
    margin-top: 3rem;
}

.pt-5 {
    padding-top: 3rem;
}

.p-3 {
    padding: 1rem;
}

.p-4 {
    padding: 1.5rem;
}

.px-3 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.px-4 {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.py-5 {
    padding-top: 3rem;
    padding-bottom: 3rem;
}

.me-3 {
    margin-right: 1rem;
}

.me-5 {
    margin-right: 3rem;
}

.g-4 > * {
    padding: 1.5rem;
}

.text-center {
    text-align: center;
}

.visually-hidden {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0, 0, 0, 0) !important;
    white-space: nowrap !important;
    border: 0 !important;
}

/* Container styles */
.container,
.container-fluid {
    width: 100%;
    padding-right: var(--bs-gutter-x, 0.75rem);
    padding-left: var(--bs-gutter-x, 0.75rem);
    margin-right: auto;
    margin-left: auto;
}

/* Row and column styles */
.row {
    --bs-gutter-x: 1.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-right: calc(-0.5 * var(--bs-gutter-x));
    margin-left: calc(-0.5 * var(--bs-gutter-x));
}

.col-12,
.col-lg-3,
.col-lg-6,
.col-md-6,
.col-md-12,
.col-sm-12 {
    flex: 0 0 auto;
    padding-right: calc(var(--bs-gutter-x) * 0.5);
    padding-left: calc(var(--bs-gutter-x) * 0.5);
    margin-top: var(--bs-gutter-y);
}

.col-12 {
    width: 100%;
}

@media (min-width: 576px) {
    .col-sm-12 {
        width: 100%;
    }
}

@media (min-width: 768px) {
    .col-md-6 {
        width: 50%;
    }
    .col-md-12 {
        width: 100%;
    }
}

@media (min-width: 992px) {
    .col-lg-3 {
        width: 25%;
    }
    .col-lg-6 {
        width: 50%;
    }
}
</style>

<script>
// Update custom indicators function
function updateCustomIndicators(carouselId, indicatorsId) {
    const carousel = document.querySelector(carouselId);
    const indicators = document.querySelectorAll(`#${indicatorsId} .indicator-line`);
    
    if (carousel && indicators.length > 0) {
        carousel.addEventListener('slide.bs.carousel', function (event) {
            indicators.forEach((indicator, index) => {
                if (index === event.to) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        });
    }
}

// Initialize custom indicators
document.addEventListener('DOMContentLoaded', function() {
    updateCustomIndicators('#artikelPilihanCarousel', 'artikelPilihanIndicators');
    
    // Add click handlers for custom indicators
    const indicators = document.querySelectorAll('#artikelPilihanIndicators .indicator-line');
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            const carousel = bootstrap.Carousel.getInstance(document.querySelector('#artikelPilihanCarousel'));
            if (carousel) {
                carousel.to(index);
            }
        });
    });
});
</script>

@endsection