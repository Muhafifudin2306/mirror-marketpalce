@extends('landingpage.index')
@section('content')
<style>
    .sidebar-filter a {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        background-color: #fff !important;
        color: #666 !important;
        border-radius: 50px !important;
        padding: 6px 16px !important;
        margin-bottom: 6px !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all .3s !important;
        width: 100% !important;
        text-align: left !important;
        text-decoration: none !important;
        font-size: 0.9rem !important;
    }
    .sidebar-filter a:hover {
        padding-right: 32px !important;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1) !important;
        color: #000 !important;
    }
    .sidebar-filter a.active {
        background-color: #e0f0ff !important;
        color: #000 !important;
    }
    .sidebar-filter a.active::after {
        content: '' !important;
        position: absolute !important;
        width: 8px !important;
        height: 8px !important;
        background-color: #0258d3 !important;
        top: 50% !important;
        right: 10px !important;
        transform: translateY(-50%) rotate(45deg) !important;
    }

    .sidebar-filter .sub-list a {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        color: #666 !important;
        padding: 3px 10px 3px 26px !important;
        margin-bottom: 3px !important;
        position: relative !important;
        transition: all .3s !important;
        text-align: left !important;
        width: 100% !important;
        text-decoration: none !important;
        font-size: 0.85rem !important;
    }
    .sidebar-filter .sub-list a:hover {
        padding-left: 32px !important;
        color: #000 !important;
    }
    .sidebar-filter .sub-list a::before {
        content: '' !important;
        position: absolute !important;
        left: 10px !important;
        top: 50% !important;
        width: 0 !important;
        height: 2px !important;
        background-color: #007bff !important;
        transition: width .4s !important;
        transform: translateY(-50%) !important;
    }
    .sidebar-filter .sub-list a:hover::before {
        width: 16px !important;
    }

    .custom-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .pagination-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 2px solid #e0e6ed;
        background: #fff;
        color: #6c757d;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .pagination-btn:hover {
        border-color: #0258d3;
        color: #0258d3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(2, 88, 211, 0.15);
    }

    .pagination-btn.active {
        background: linear-gradient(135deg, #0258d3, #0ea5e9);
        border-color: #0258d3;
        color: #fff;
        box-shadow: 0 4px 12px rgba(2, 88, 211, 0.3);
    }

    .pagination-btn.disabled {
        background: #f8f9fa;
        color: #adb5bd;
        border-color: #e9ecef;
        cursor: not-allowed;
        pointer-events: none;
    }

    .pagination-arrow {
        width: 44px;
        font-size: 1rem;
    }

    .pagination-dots {
        color: #6c757d;
        font-weight: bold;
        padding: 0 8px;
    }

    .pagination-info {
        color: #6c757d;
        font-size: 0.85rem;
        margin: 0 12px;
        white-space: nowrap;
    }

    /* ======= Responsive Design Adjustments ======= */
    .product-title {
        font-family: 'Poppins' !important;
        font-size: 1.1rem !important;
        font-weight: 600 !important;
        color: #000 !important;
        line-height: 1.3 !important;
    }

    .product-size {
        font-family: 'Poppins' !important;
        font-size: 0.75rem !important;
        font-weight: 400 !important;
        color: #444444 !important;
        margin-bottom: 0.8rem !important;
    }

    .product-price-label {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: #888888 !important;
        margin-bottom: 0.2rem !important;
    }

    .product-price {
        font-family: 'Poppins' !important;
        font-size: 1.1rem !important;
        font-weight: 500 !important;
        color: #444444 !important;
    }

    .product-price-discount {
        font-family: 'Poppins' !important;
        font-size: 1.1rem !important;
        font-weight: 500 !important;
        color: #fc2865 !important;
    }

    .product-image-container {
        border-radius: 8px !important;
        height: 200px !important;
    }

    .product-content {
        min-height: 120px !important;
        padding: 1rem !important;
    }

    .category-title {
        font-family: 'Poppins' !important;
        font-size: 1.3rem !important;
        font-weight: 600 !important;
        color: #0439a0 !important;
        margin-bottom: 1rem !important;
    }

    .sort-select {
        width: 250px !important;
        height: 50px !important;
        border-radius: 50px !important;
        font-size: 0.8rem !important;
        text-transform: uppercase !important;
        padding: 0 24px !important;
    }

    .results-info {
        font-size: 0.9rem !important;
        color: #666 !important;
    }

    .cta-title {
        font-family: 'Poppins' !important;
        font-size: 2.2rem !important;
        font-weight: 600 !important;
        color: #fff !important;
    }

    .cta-subtitle {
        font-family: 'Poppins' !important;
        font-size: 2.2rem !important;
        font-weight: 600 !important;
        color: #ffc74c !important;
        margin-bottom: 1.5rem !important;
    }

    @media (max-width: 768px) {
        .custom-pagination {
            gap: 4px;
        }
        
        .pagination-btn {
            width: 36px;
            height: 36px;
            font-size: 0.8rem;
        }
        
        .pagination-arrow {
            width: 40px;
        }
        
        .pagination-info {
            font-size: 0.8rem;
            margin: 0 8px;
        }

        .cta-title, .cta-subtitle {
            font-size: 1.8rem !important;
        }

        .sort-select {
            width: 200px !important;
            height: 45px !important;
        }
    }
</style>
<br><br><br><br>
<div class="container-fluid px-3">
    <img class="w-100" src="{{ asset('landingpage/img/products_hero.png') }}" alt="Image Produk">
</div>
<div class="container-lg py-5">
    <div class="row g-5 justify-content-center">
        <div class="col-lg-3 col-md-12 wow fadeInUp text-dark p-0" data-wow-delay="0.1s">
            <div class="bg-white p-4" style="border-radius: 15px;">
                <h5 class="category-title">Kategori Produk</h5>

                <div class="sidebar-filter">
                    <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter'=>'all','product'=>null])) }}"
                       class="{{ $filter == 'all' ? 'active' : '' }}">
                        Semua Produk
                    </a>
                    <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter'=>'promo','product'=>null])) }}"
                       class="{{ $filter == 'promo' ? 'active' : '' }}">
                        Promo
                    </a>

                    @foreach($labels as $lbl)
                        @php $isOpen = (int)$filter == $lbl->id; @endphp
                        <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter' => $lbl->id, 'product' => null])) }}"
                        class="{{ $isOpen ? 'active' : '' }}">
                            {{ $lbl->name }}
                        </a>
                        <div id="label-{{ $lbl->id }}" class="collapse sub-list {{ $isOpen ? 'show' : '' }}">
                            @foreach($lbl->products as $prod)
                                <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter' => $lbl->id, 'product' => $prod->id])) }}"
                                class="{{ request()->product == $prod->id ? 'active' : '' }}">
                                    {{ $prod->name }}
                                </a>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-12 wow fadeInUp" data-wow-delay="0.5s">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="results-info">
                    @if ($products->total() > 0)
                        Menampilkan {{ $products->total() }} produk
                    @else
                        Belum ada produk.
                    @endif
                </div>
                <form method="GET" class="d-flex align-items-center" style="gap:12px;">
                    @foreach(request()->except('sort','page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <select id="sort" name="sort" class="form-select sort-select" onchange="this.form.submit()" style="appearance: none; background: url('data:image/svg+xml;charset=UTF-8,<svg fill=''%23333'' height=''24'' viewBox=''0 0 24 24'' width=''24'' xmlns=''http://www.w3.org/2000/svg''><path d=''M7 10l5 5 5-5z''/></svg>') no-repeat right 10px center; background-size: 16px;">
                        <option value="price-desc" {{ $sort=='price-desc' ? 'selected':'' }}>Barang Termahal</option>
                        <option value="price-asc"  {{ $sort=='price-asc'  ? 'selected':'' }}>Barang Termurah</option>
                        <option value="best-selling" {{ $sort=='best-selling' ? 'selected':'' }}>Barang Terlaris</option>
                        <option value="newest" {{ $sort=='newest' ? 'selected':'' }}>Barang Terbaru</option>
                    </select>
                </form>
            </div>
            <div class="row g-4">
                @foreach($products as $prod)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                            <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                                <div class="position-relative bg-light overflow-hidden product-image-container">
                                    @php
                                        $image = $prod->images->first();
                                    @endphp

                                    @if($image && $image->image_product)
                                        @if(file_exists(storage_path('app/public/' . $image->image_product)))
                                            <img src="{{ asset('storage/' . $image->image_product) }}" 
                                                class="img-fluid w-100 h-100" 
                                                style="object-fit:cover;"
                                                alt="{{ $prod->name }}">
                                        @else
                                            <img src="{{ asset('landingpage/img/nophoto.png') }}" 
                                                class="img-fluid w-100 h-100" 
                                                style="object-fit:cover;"
                                                alt="No Image">
                                        @endif
                                    @else
                                        <img src="{{ asset('landingpage/img/nophoto.png') }}" 
                                            class="img-fluid w-100 h-100" 
                                            style="object-fit:cover;"
                                            alt="No Image">
                                    @endif
                                </div>
                                <div class="content product-content d-flex flex-column">
                                    <div class="product-title">
                                        {{ Str::limit($prod->name, 30) }}
                                        @if($prod->additional_size && $prod->additional_unit)
                                            {{ $prod->additional_size }} {{ $prod->additional_unit }}
                                        @endif
                                    </div>
                                    <div class="product-size">
                                        @if($prod->long_product && $prod->width_product)
                                            Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}
                                        @else
                                            {{ $prod->additional_size }} {{ $prod->additional_unit }}
                                        @endif
                                    </div>
                                    @php
                                        $base = $prod->price;
                                        $final = $prod->getDiscountedPrice();
                                        $bestDiscount = $prod->getBestDiscount();
                                    @endphp

                                    @if($final < $base)
                                        <div class="title mb-0 mt-1" style="font-size:0.6rem; font-weight:600; color:#888;">
                                            MULAI DARI
                                        </div>
                                        <div class="price-container d-flex align-items-center" style="gap:8px;">
                                            <span class="discount-price text-decoration-line-through">
                                                Rp {{ number_format($base,0,',','.') }}
                                            </span>
                                            <img src="{{ asset('landingpage/img/discount_logo.png') }}" alt="Diskon" style="width:14px;">
                                            <span class="price fw-bold" style="font-family: 'Poppins'; font-size:1.1rem; color:#fc2865;">
                                                Rp {{ number_format($final,0,',','.') }}
                                            </span>
                                        </div>
                                    @else
                                        <div class="title mb-0 mt-1" style="font-size:0.6rem; font-weight:600; color:#888;">
                                            MULAI DARI
                                        </div>
                                        <div class="price-container mt-0">
                                            <span class="fw-bold" style="font-family: 'Poppins'; font-size:1.1rem; color:#444444;">
                                                Rp {{ number_format($base,0,',','.') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if ($products->hasPages())
                <div class="custom-pagination">
                    @if ($products->onFirstPage())
                        <span class="pagination-btn pagination-arrow disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pagination-btn pagination-arrow">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    @php
                        $start = max(1, $products->currentPage() - 2);
                        $end = min($products->lastPage(), $products->currentPage() + 2);
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $products->url(1) }}" class="pagination-btn">1</a>
                        @if ($start > 2)
                            <span class="pagination-dots">...</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $products->currentPage())
                            <span class="pagination-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $products->url($page) }}" class="pagination-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    @if ($end < $products->lastPage())
                        @if ($end < $products->lastPage() - 1)
                            <span class="pagination-dots">...</span>
                        @endif
                        <a href="{{ $products->url($products->lastPage()) }}" class="pagination-btn">{{ $products->lastPage() }}</a>
                    @endif

                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="pagination-btn pagination-arrow">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="pagination-btn pagination-arrow disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content" style="padding-left: 3rem;">
            <h3 class="cta-title">Masih Bingung Cari Apa?</h3>
            <h3 class="cta-subtitle">Boleh Tanya Dulu!</h3>
            <a href="https://wa.me/6281952764747?text=Halo%20Admin%20Sinau%20Print%21%20Saya%20ingin%20mengajukan%20pertanyaan%20terkait%20produk%20yang%20ada%20di%20sinau%20print" target="_blank" class="btn-schedule">
            <span class="btn-text">JADWALKAN KONSULTASI</span>
            <span class="btn-arrow">
                <i class="bi bi-arrow-right arrow-out"></i>
                <i class="bi bi-arrow-right arrow-in"></i>
            </span>
            </a>
        </div>
    </div>
</div>
@endsection