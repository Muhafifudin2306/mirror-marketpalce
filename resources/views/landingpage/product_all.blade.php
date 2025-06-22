@extends('landingpage.index')
@section('content')
<style>
    /* ========== Category Pills Styles ========== */
    .sidebar-filter a {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        background-color: #fff !important;
        color: #666 !important;
        border-radius: 50px !important;
        padding: 8px 20px !important;
        margin-bottom: 8px !important;
        position: relative !important;
        overflow: hidden !important;
        transition: all .3s !important;
        width: 100% !important;
        text-align: left !important;
        text-decoration: none !important;
    }
    .sidebar-filter a:hover {
        padding-right: 40px !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
        color: #000 !important;
    }
    .sidebar-filter a.active {
        background-color: #e0f0ff !important;
        color: #000 !important;
    }
    .sidebar-filter a.active::after {
        content: '' !important;
        position: absolute !important;
        width: 10px !important;
        height: 10px !important;
        background-color: #0258d3 !important;
        top: 50% !important;
        right: 12px !important;
        transform: translateY(-50%) rotate(45deg) !important;
    }

    /* ========== Sub-List (Label Products) ========== */
    .sidebar-filter .sub-list a {
        display: block !important;
        font-family: 'Poppins', sans-serif !important;
        color: #666 !important;
        padding: 4px 12px 4px 32px !important;
        margin-bottom: 4px !important;
        position: relative !important;
        transition: all .3s !important;
        text-align: left !important;
        width: 100% !important;
        text-decoration: none !important;
    }
    .sidebar-filter .sub-list a:hover {
        padding-left: 40px !important;
        color: #000 !important;
    }
    .sidebar-filter .sub-list a::before {
        content: '' !important;
        position: absolute !important;
        left: 12px !important;
        top: 50% !important;
        width: 0 !important;
        height: 2px !important;
        background-color: #007bff !important;
        transition: width .4s !important;
        transform: translateY(-50%) !important;
    }
    .sidebar-filter .sub-list a:hover::before {
        width: 20px !important;
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
                <h5 class="mb-3" style="font-family: 'Poppins';font-size:1.6rem;font-weight:600;color:#0439a0">Kategori Produk</h5>

                <div class="sidebar-filter">
                    {{-- Semua Produk & Promo --}}
                    <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter'=>'all','product'=>null])) }}"
                       class="{{ $filter === 'all' ? 'active' : '' }}">
                        Semua Produk
                    </a>
                    <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter'=>'promo','product'=>null])) }}"
                       class="{{ $filter === 'promo' ? 'active' : '' }}">
                        Promo
                    </a>

                    {{-- Loop Labels dengan collapse untuk sub-produk --}}
                    @foreach($labels as $lbl)
                        @php $isOpen = (int)$filter === $lbl->id; @endphp
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
                <div>
                    @if ($products->total() > 0)
                        Menampilkan {{ $products->total() }} produk
                    @else
                        Belum ada produk.
                    @endif
                </div>
                {{-- Sort By --}}
                <form method="GET" class="d-flex align-items-center" style="gap:12px;">
                    @foreach(request()->except('sort','page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <select id="sort" name="sort" class="form-select" onchange="this.form.submit()" style="width:300px; height:60px; border-radius:70px; font-size:0.875rem; text-transform:uppercase; padding: 0 30px; appearance: none; background: url('data:image/svg+xml;charset=UTF-8,<svg fill=''%23333'' height=''<24>'' viewBox=''0 0 24 24'' width=''24'' xmlns=''http://www.w3.org/2000/svg''><path d=''M7 10l5 5 5-5z''/></svg>') no-repeat right 10px center; background-size: 16px;">
                        <option value="price-desc" {{ $sort==='price-desc' ? 'selected':'' }}>Barang Termahal</option>
                        <option value="price-asc"  {{ $sort==='price-asc'  ? 'selected':'' }}>Barang Termurah</option>
                        <option value="best-selling" {{ $sort==='best-selling' ? 'selected':'' }}>Barang Terlaris</option>
                        <option value="newest" {{ $sort==='newest' ? 'selected':'' }}>Barang Terbaru</option>
                    </select>
                </form>
            </div>
            <div class="row g-4">
                @foreach($products as $prod)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                            <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                                <div class="position-relative bg-light overflow-hidden" style="border-radius:10px; height:250px;">
                                    @php
                                        $image = $prod->images->first();
                                        $path = public_path('landingpage/img/product/' . ($image->image_product ?? ''));
                                    @endphp

                                    @if($image && file_exists($path))
                                        <img src="{{ asset('landingpage/img/product/'.$image->image_product) }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                                    @else
                                        <img src="{{ asset('landingpage/img/nophoto.png') }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                                    @endif
                                </div>
                                <div class="content p-3 d-flex flex-column" style="min-height:140px;">
                                    <div class="title text-dark mb-0" style="font-family: 'Poppins'; font-size:1.4rem; font-weight:600; color:#000;">{{ $prod->name }}</div>
                                    <div class="title mb-4" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#444444;">Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}</div>
                                    @php
                                        $base  = $prod->price;
                                        $final = $base;
                                        $disc = $prod->discounts->first();

                                        if ($disc) {
                                            if ($disc->discount_percent) {
                                            $amount = $base * ($disc->discount_percent / 100);
                                            } else {
                                            $amount = $disc->discount_fix;
                                            }
                                            $final = max(0, $base - $amount);
                                        }
                                    @endphp
                                    @if($final<$base)
                                        <div class="title mb-0 mt-1" style="font-size:0.8rem;font-weight:600;color:#888888">MULAI DARI</div>
                                        <div class="price-container d-flex align-items-center" style="gap:8px;">
                                            {{-- Harga asli, tercoret --}}
                                            <span class="discount-price text-decoration-line-through">
                                                Rp {{ number_format($base,0,',','.') }}
                                            </span>

                                            {{-- Logo diskon --}}
                                            <img 
                                                src="{{ asset('landingpage/img/discount_logo.png') }}" 
                                                alt="Diskon" 
                                                class="discount-logo" 
                                                style="width:18px; height:auto;"
                                            >

                                            {{-- Harga setelah diskon --}}
                                            <span class="price fw-bold" style="font-family: 'Poppins'; font-size:1.3rem; font-weight:500; color:#fc2865;">
                                                Rp {{ number_format($final,0,',','.') }}
                                            </span>
                                        </div>

                                    @else
                                        <div class="title mb-0 mt-1" style="font-size:0.8rem;font-weight:600;color:#888888">Mulai Dari</div>
                                        <div class="price-container mt-0">
                                            <span class="fw-bold" style="font-family: 'Poppins'; font-size:1.3rem; color:#444444;">Rp {{ number_format($base,0,',','.') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links('vendor.pagination.simple') }}
            </div>
        </div>
    </div>
</div>
{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#fff;">Masih Bingung Cari Apa?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#ffc74c;">Boleh Tanya Dulu!</h3>
            <a href="{{ url('/products') }}" class="btn-schedule">
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
