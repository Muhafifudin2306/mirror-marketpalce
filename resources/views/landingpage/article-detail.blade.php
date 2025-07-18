@extends('landingpage.index')
@section('content')

@php
    $bannerExists = $blog->banner && file_exists(public_path('storage/' . $blog->banner));
    $bannerUrl = $bannerExists ? asset('storage/' . $blog->banner) : asset('landingpage/img/nophoto_blog.png');
@endphp
<br><br>
<div class="hero-banner-wrapper">
    <div class="hero-banner" style="background-image: url('{{ $bannerUrl }}');">
        <div class="hero-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10">
                        <h1 class="hero-title">{{ Str::limit($blog->title, 60) }}</h1>
                        <div class="hero-meta">
                            <span class="meta-text">{{ strtoupper($blog->blog_type) }} • {{ strtoupper($blog->created_at->format('d F Y')) }} • DITULIS OLEH {{ strtoupper($blog->user->name ?? 'ADMIN') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="mb-5 text-center">
                <img src="{{ $bannerUrl }}" alt="{{ $blog->title }}" class="article-banner">
            </div>

            <div class="article-content">
                {!! $blog->content !!}
            </div>

            @if(strtolower($blog->blog_type) == 'promo sinau')
            <div class="mt-5 pt-4 border-top">
                <div class="promo-section text-center">
                    <h4 style="font-family: 'Poppins'; font-size:2rem; font-weight:600; color:#444444;">Penasaran Sama Produknya?<br>Sini Kepoin Dulu!</h4>
                    <div class="mt-4">
                        <a href="/products" class="btn btn-promo-full">
                            LIHAT PRODUK DISKON
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-5 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('landingpage.article_index') }}" class="back-link">
                            < Kembali ke Semua Artikel
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="share-text">BAGIKAN ARTIKEL</span>
                        <button class="share-btn" onclick="copyToClipboard()">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="other-articles-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="other-articles-title">Baca Artikel Lainnya</h2>
            </div>
        </div>
        
        <!-- Carousel Container -->
        <div id="otherArticlesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @php
                    $otherArticles = App\Models\Blog::where('is_live', 1)
                        ->where('id', '!=', $blog->id)
                        ->latest()
                        ->limit(6)
                        ->get();
                @endphp
                
                @foreach($otherArticles as $index => $article)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8 col-sm-10">
                            <a href="{{ route('landingpage.article_show', $article->slug) }}" class="text-decoration-none">
                                <div class="article-card-carousel h-100">
                                    <div class="position-relative bg-light overflow-hidden article-image-container-carousel">
                                        @if($article->banner && file_exists(storage_path('app/public/' . $article->banner)))
                                            <img src="{{ asset('storage/' . $article->banner) }}"
                                                class="img-fluid w-100 h-100 article-image-carousel" 
                                                alt="{{ $article->title }}">
                                        @else
                                            <img src="{{ asset('landingpage/img/nophoto_blog.png') }}"
                                                class="img-fluid w-100 h-100 article-image-carousel"
                                                alt="No Image">
                                        @endif
                                        
                                        <div class="article-overlay-carousel">
                                            <div class="overlay-content-carousel">
                                                <span class="read-more-text-carousel">Baca Selengkapnya</span>
                                                <div class="arrow-circle-carousel">
                                                    <i class="bi bi-arrow-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-carousel">
                                        <div class="article-category-carousel">
                                            {{ strtoupper($article->type ?? $article->blog_type ?? 'ARTIKEL') }}
                                            <span class="article-date-carousel">{{ $article->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="title-carousel">
                                            {{ Str::limit($article->title, 80) }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            <div class="carousel-controls-wrapper">
                <button class="carousel-control-prev custom-carousel-btn" type="button" data-bs-target="#otherArticlesCarousel" data-bs-slide="prev">
                    <span class="custom-arrow-btn">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </button>
                
                <button class="carousel-control-next custom-carousel-btn" type="button" data-bs-target="#otherArticlesCarousel" data-bs-slide="next">
                    <span class="custom-arrow-btn">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Hero Banner Styles */
.hero-banner-wrapper {
    position: relative;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
    margin-top: 20px; /* Added margin top */
}

.hero-banner {
    height: 500px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: flex-end;
    justify-content: flex-start;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(59, 130, 246, 0.9) 0%, rgba(59, 130, 246, 0.6) 40%, transparent 100%);
    display: flex;
    align-items: flex-end;
    padding-bottom: 60px;
    padding-left: 20px;
    padding-right: 20px;
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 3rem;
    color: white;
    margin-bottom: 15px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    text-align: left;
    line-height: 1.2;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.hero-meta {
    text-align: left;
}

.meta-text {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: #FFC107; /* Yellow color */
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    letter-spacing: 0.5px;
}

/* Article Banner */
.article-banner {
    width: 70%;
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

/* Article Content */
.article-content {
    font-family: 'Poppins', sans-serif;
    line-height: 1.8;
    color: #555;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}

.article-content ul,
.article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

/* Promo Section */
.promo-section {
    padding: 40px 0;
}

.promo-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 30px;
    line-height: 1.2;
}

.btn-promo-full {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 15px 40px;
    border-radius: 50px;
    font-family: 'Poppins', sans-serif;
    font-size: 1.1rem;
    font-weight: 600;
    width: 100%;
    max-width: 400px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-promo-full:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

/* Navigation Section */
.back-link {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    color: #666;
    text-decoration: none;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #3b82f6;
}

.share-text {
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.share-btn {
    width: 48px;
    height: 48px;
    border: 1px solid #ddd;
    border-radius: 50%;
    background: white;
    color: #666;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.share-btn:hover {
    background: #ffc74c;
    border-color: #ffc74c;
}

.share-btn i {
    font-size: 18px;
}
.other-articles-section {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    padding: 80px 0;
    position: relative;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
}

.other-articles-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    text-align: center;
    margin-bottom: 50px;
}

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

.article-category-home {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.article-date-home {
    font-size: 0.7rem !important;
    font-weight: 400 !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-banner {
        height: 400px;
    }
    
    .article-banner {
        width: 90%;
    }
    
    .other-articles-title {
        font-size: 2rem;
    }
    
    .other-articles-section {
        padding: 60px 0;
    }
    
    .promo-title {
        font-size: 2rem;
    }
    
    .hero-overlay {
        padding-bottom: 40px;
    }
    
    .meta-text {
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 1.5rem;
    }
    
    .hero-banner {
        height: 300px;
    }
    
    .article-banner {
        width: 100%;
    }
    
    .promo-title {
        font-size: 1.5rem;
    }
    
    .hero-overlay {
        padding-bottom: 30px;
    }
    
    .meta-text {
        font-size: 0.8rem;
    }
    
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
    
    .container .d-flex.justify-content-between:has(.back-link) {
        flex-direction: column;
        gap: 20px;
        align-items: flex-start !important;
    }

    .container .d-flex.align-items-center.gap-3:has(.share-text) {
        align-self: flex-end;
        gap: 10px !important;
    }
}
@media (max-width: 768px) {
    .hero-banner-wrapper {
        margin-top: 0;
    }
    
    .hero-banner {
        height: 300px;
    }
    
    .hero-overlay {
        padding-bottom: 30px;
        padding-left: 15px;
        padding-right: 15px;
    }
    
    .hero-title {
        font-size: 1.8rem;
        line-height: 1.1;
        text-align: center;
        -webkit-line-clamp: 4;
    }
    
    .hero-meta {
        text-align: center;
    }
    
    .meta-text {
        font-size: 0.8rem;
        line-height: 1.4;
        word-break: break-word;
    }
}

@media (max-width: 576px) {
    .hero-banner {
        height: 250px;
    }
    
    .hero-title {
        font-size: 1.5rem;
    }
    
    .meta-text {
        font-size: 0.7rem;
    }
    
    .hero-overlay {
        padding-bottom: 20px;
        padding-left: 10px;
        padding-right: 10px;
    }
}

@media (max-width: 768px) {
    .container.py-5 {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }
    
    .article-banner {
        width: 100%;
        margin-bottom: 30px;
    }
    
    .article-content {
        font-size: 0.95rem;
        line-height: 1.7;
    }
    
    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4 {
        font-size: 1.3rem;
        margin-top: 1.5rem;
        margin-bottom: 0.8rem;
    }
    
    .article-content p {
        margin-bottom: 1.2rem;
    }
    
    .promo-section h4 {
        font-size: 1.5rem !important;
        line-height: 1.3;
        margin-bottom: 20px;
    }
    
    .btn-promo-full {
        font-size: 1rem;
        padding: 12px 30px;
    }
    
    .share-text {
        font-size: 0.8rem;
    }
    
    .share-btn {
        width: 40px;
        height: 40px;
    }
}

@media (max-width: 576px) {
    .container.py-5 {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
    
    .article-content {
        font-size: 0.9rem;
    }
    
    .promo-section h4 {
        font-size: 1.3rem !important;
    }
    
    .btn-promo-full {
        font-size: 0.9rem;
        padding: 10px 25px;
    }
}


.other-articles-section {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    padding: 80px 0;
    position: relative;
    width: 100vw;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
}

.other-articles-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    text-align: center;
    margin-bottom: 50px;
}

.article-card-carousel {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 0 20px;
}

.article-card-carousel:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.25);
}

.article-image-container-carousel {
    height: 250px;
    overflow: hidden;
    border-radius: 16px 16px 0 0;
}

.article-image-carousel {
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card-carousel:hover .article-image-carousel {
    transform: scale(1.05);
}

.article-overlay-carousel {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(59, 130, 246, 0) 0%, rgba(59, 130, 246, 0.9) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.article-card-carousel:hover .article-overlay-carousel {
    opacity: 1;
}

.overlay-content-carousel {
    text-align: center;
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.read-more-text-carousel {
    font-family: 'Poppins';
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
}

.arrow-circle-carousel {
    width: 40px;
    height: 40px;
    border: 2px solid #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.arrow-circle-carousel i {
    font-size: 16px;
    color: #fff;
}

.article-card-carousel:hover .arrow-circle-carousel {
    background: #fff;
}

.article-card-carousel:hover .arrow-circle-carousel i {
    color: #3b82f6;
}

.content-carousel {
    padding: 24px;
}

.article-category-carousel {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-family: 'Poppins';
    font-size: 0.75rem;
    font-weight: 600;
    color: #666;
}

.article-date-carousel {
    color: #999 !important;
    font-weight: 400 !important;
}

.title-carousel {
    font-family: 'Poppins';
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.carousel-controls-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 30px;
    margin-top: 40px;
}

.custom-carousel-btn {
    width: 50px;
    height: 50px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: static;
    opacity: 1;
}

.custom-carousel-btn:hover {
    background: rgba(255, 255, 255, 0.9);
    border-color: rgba(255, 255, 255, 0.9);
    transform: scale(1.1);
}

.custom-arrow-btn {
    color: white;
    font-size: 18px;
    transition: color 0.3s ease;
}

.custom-carousel-btn:hover .custom-arrow-btn {
    color: #3b82f6;
}


@media (max-width: 768px) {
    .other-articles-section {
        padding: 60px 0;
    }
    
    .other-articles-title {
        font-size: 2rem;
        margin-bottom: 30px;
    }
    
    .article-card-carousel {
        margin: 0 10px;
    }
    
    .article-image-container-carousel {
        height: 200px;
    }
    
    .content-carousel {
        padding: 20px;
    }
    
    .title-carousel {
        font-size: 1.1rem;
        -webkit-line-clamp: 2;
    }
    
    .carousel-controls-wrapper {
        gap: 20px;
        margin-top: 30px;
    }
    
    .custom-carousel-btn {
        width: 45px;
        height: 45px;
    }
    
    .custom-arrow-btn {
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    .other-articles-title {
        font-size: 1.5rem;
    }
    
    .article-card-carousel {
        margin: 0 5px;
    }
    
    .article-image-container-carousel {
        height: 180px;
    }
    
    .content-carousel {
        padding: 16px;
    }
    
    .title-carousel {
        font-size: 1rem;
    }
    
    .article-category-carousel {
        font-size: 0.7rem;
    }
    
    .read-more-text-carousel {
        font-size: 0.9rem;
    }
    
    .arrow-circle-carousel {
        width: 35px;
        height: 35px;
    }
    
    .arrow-circle-carousel i {
        font-size: 14px;
    }
}
</style>

<script>
function copyToClipboard() {
    const url = window.location.href;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(() => {
            showCopySuccess();
        }).catch(err => {
            console.error('Failed to copy: ', err);
            fallbackCopyTextToClipboard(url);
        });
    } else {
        fallbackCopyTextToClipboard(url);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        } else {
            console.error('Fallback: Could not copy text');
        }
    } catch (err) {
        console.error('Fallback: Could not copy text: ', err);
    }
    
    document.body.removeChild(textArea);
}

function showCopySuccess() {
    const notification = document.createElement('div');
    notification.textContent = 'Link berhasil disalin!';
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        z-index: 10000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>

@endsection