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
        <div class="row g-4">
            @php
                $otherArticles = App\Models\Blog::where('is_live', 1)
                    ->where('id', '!=', $blog->id)
                    ->latest()
                    ->limit(4)
                    ->get();
            @endphp
            
            @foreach($otherArticles as $article)
            <div class="col-lg-3 col-md-6 col-sm-12">
                <a href="{{ route('landingpage.article_show', $article->slug) }}" class="text-decoration-none">
                    <div class="article-card-home h-100" style="border-radius:10px;">
                        <div class="position-relative bg-light overflow-hidden article-image-container-home" style="border-radius:10px; height:170px;">
                            @if($article->banner && file_exists(storage_path('app/public/' . $article->banner)))
                                <img src="{{ asset('storage/' . $article->banner) }}"
                                    class="img-fluid w-100 h-100 article-image-home" style="object-fit:cover;" 
                                    alt="{{ $article->title }}">
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
                                {{-- Updated: Use article type --}}
                                {{ strtoupper($article->type ?? $article->blog_type ?? 'ARTIKEL') }}
                                <span class="article-date-home ms-auto" style="color:#999;">{{ $article->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="title text-dark mb-0"
                                style="font-family: 'Poppins'; font-size:1.1rem; font-weight:600;">
                                {{ Str::limit($article->title, 50) }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
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
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start !important;
    }
    
    .d-flex.align-items-center.gap-3 {
        align-self: flex-end;
    }
}
</style>

<script>
function copyToClipboard() {
    const url = window.location.href;
    
    if (navigator.clipboard && window.isSecureContext) {
        // Use modern clipboard API
        navigator.clipboard.writeText(url).then(() => {
            showCopySuccess();
        }).catch(err => {
            console.error('Failed to copy: ', err);
            fallbackCopyTextToClipboard(url);
        });
    } else {
        // Fallback for older browsers
        fallbackCopyTextToClipboard(url);
    }
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    
    // Avoid scrolling to bottom
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
    // Create a temporary notification
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
    
    // Remove notification after 3 seconds
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