@extends('landingpage.index')
@section('content')

{{-- Hero Banner Full Width --}}
@if($blog->banner)
<div class="hero-banner-wrapper">
    <div class="hero-banner" style="background-image: url('{{ asset('storage/' . $blog->banner) }}');">
        <div class="hero-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h1 class="hero-title">{{ $blog->title }}</h1>
                        <div class="hero-meta">
                            <i class="bi bi-calendar me-2"></i>
                            <span>{{ $blog->created_at->format('d F Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            {{-- Breadcrumb --}}
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('landingpage.article_index') }}">Artikel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $blog->title }}</li>
                    </ol>
                </nav>
            </div>

            {{-- Article Banner (70% width, no gradient) --}}
            @if($blog->banner)
            <div class="mb-5 text-center">
                <img src="{{ asset('storage/' . $blog->banner) }}" alt="{{ $blog->title }}" class="article-banner">
            </div>
            @endif

            {{-- Article Content --}}
            <div class="article-content">
                {!! $blog->content !!}
            </div>

            {{-- Back Button with Border --}}
            <div class="mt-5 pt-4 border-top">
                <a href="{{ route('landingpage.article_index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Semua Artikel
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Baca Artikel Lainnya Section --}}
<div class="other-articles-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="other-articles-title">Baca Artikel Lainnya</h2>
            </div>
        </div>
        <div class="row">
            @php
                $otherArticles = App\Models\Blog::where('id', '!=', $blog->id)->latest()->limit(4)->get();
            @endphp
            
            @foreach($otherArticles as $article)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="article-card">
                    @if($article->banner)
                    <div class="article-card-image">
                        <img src="{{ asset('storage/' . $article->banner) }}" alt="{{ $article->title }}">
                    </div>
                    @endif
                    
                    <div class="article-card-content">
                        <div class="article-card-meta">
                            <span class="badge">
                                @if(str_contains(strtolower($article->title), 'promo'))
                                    PROMO
                                @else
                                    ARTIKEL
                                @endif
                            </span>
                            <span class="date">{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                        
                        <h3 class="article-card-title">
                            <a href="{{ route('landingpage.article_show', $article->slug) }}">
                                {{ $article->title }}
                            </a>
                        </h3>
                    </div>
                </div>
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
}

.hero-banner {
    height: 500px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(59, 130, 246, 0.8) 0%, rgba(59, 130, 246, 0.4) 50%, transparent 100%);
    display: flex;
    align-items: flex-end;
    padding-bottom: 60px;
}

.hero-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 3rem;
    color: white;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-meta {
    color: white;
    font-size: 1.1rem;
    font-weight: 500;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

/* Article Banner Styles */
.article-banner {
    width: 70%;
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

/* Article Content Styles */
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

/* Breadcrumb Styles */
.breadcrumb-item a {
    color: #3b82f6;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

/* Other Articles Section */
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

.article-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

.article-card-image {
    height: 200px;
    overflow: hidden;
}

.article-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.article-card:hover .article-card-image img {
    transform: scale(1.05);
}

.article-card-content {
    padding: 20px;
}

.article-card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.article-card-meta .badge {
    background: #3b82f6;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.article-card-meta .date {
    color: #6b7280;
    font-size: 0.9rem;
}

.article-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4;
    margin: 0;
}

.article-card-title a {
    color: #1f2937;
    text-decoration: none;
    transition: color 0.3s ease;
}

.article-card-title a:hover {
    color: #3b82f6;
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
}
</style>

@endsection