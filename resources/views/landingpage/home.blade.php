@extends('landingpage.index')
@section('content')
<style>
/* Hero Carousel Overrides */
/* ===== Hero Carousel Overrides ===== */
#heroCarousel {
  position: relative;
}

/* IMAGE */
#heroCarousel .carousel-inner img {
  width: 100%;
  border-radius: 10px;
}

/* BULLETS (indikator) di dalam hero, bawah tengah */
#heroCarousel .carousel-indicators {
  position: absolute;
  bottom: 15px;
  left: 35%;
  transform: translateX(-50%);
  display: flex;
  gap: 8px;
  z-index: 5;
  margin-bottom: 3rem;
}
#heroCarousel .carousel-indicators button {
  width: 10px; height: 10px;
  border: none; border-radius: 50%;
  background: #c3c3c3;
}
#heroCarousel .carousel-indicators .active {
  width: 30px;
  background: #05d1d1;
  border-radius: 10px;
}

/* POSISI PANAH di dalam hero, bawah kiri & bawah kanan */
#heroCarousel .carousel-control-prev,
#heroCarousel .carousel-control-next {
  position: absolute; /* penting! */
  bottom: 15px;
  top: auto;          /* override vertical centering */
  transform: none;    /* hilangkan translateY */
  width: 50px !important;
  height: 50px !important;
  background: none;
  border: none;
  z-index: 5;
}

/* sisi kiri/kanan */
#heroCarousel .carousel-control-prev { left: 15px; }
#heroCarousel .carousel-control-next { right: 15px; }

/* sembunyikan ikon bawaan */
#heroCarousel .carousel-control-prev-icon,
#heroCarousel .carousel-control-next-icon {
  display: none;
}

/* custom panah (← dan →) */
#heroCarousel .carousel-control-prev::after,
#heroCarousel .carousel-control-next::after {
  content: '';
  font-size: 2rem;
  color: #fff;
  display: inline-block;
  transition: transform 0.3s ease;
}
#heroCarousel .carousel-control-prev::after { content: '\2190'; }
#heroCarousel .carousel-control-next::after { content: '\2192'; }

/* hover animasi: sedikit membesar */
#heroCarousel .carousel-control-prev:hover::after,
#heroCarousel .carousel-control-next:hover::after {
  transform: scale(1.2);
}


/* Product Carousels (Pilih Sendiri Kebutuhanmu, Cetak Roll Banner, Promo) */
.carousel-controls-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  margin-top: 20px;
}

.carousel-controls {
  display: flex;
  gap: 10px;
}

.carousel-control-prev,
.carousel-control-next {
  position: relative;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.5);
}

.carousel-indicators-custom {
  display: flex;
  /* gap: 5px; */
  flex-grow: 1;
  margin-left: 10px;
}

.indicator-line {
  flex: 1;
  height: 2px;
  background-color: #ccc;
  cursor: pointer;
  transition: height 0.7s, background-color 0.3s;
}

.indicator-line.active {
  height: 2px;
  background-color: #05d1d1;
}

/* === Carousel Button Animated Arrow === */
.btn-arrow-carousel {
  position: relative;
  width: 40px;         /* cocokkan ukuran tombol */
  height: 40px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  border-radius: 50%;
  background-color: #fff;
}

.btn-arrow-carousel .arrow-out,
.btn-arrow-carousel .arrow-in {
  position: absolute;
  font-size: 1.8rem;
  color: #0439a0;
  transition: transform 0.7s, opacity 0.3s;
}

/* default posisi */
.btn-arrow-carousel .arrow-out {
  transform: translateX(0);
  opacity: 1;
}
.btn-arrow-carousel .arrow-in {
  transform: translateX(-100%);
  opacity: 0;
}

/* hover efek persis btn-schedule */
.carousel-control-prev:hover .btn-arrow-carousel,
.carousel-control-next:hover .btn-arrow-carousel {
  background-color: #fff;    /* kalau mau ganti warna circle waktu hover */
}
.carousel-control-prev:hover .arrow-out,
.carousel-control-next:hover .arrow-out {
  transform: translateX(100%);
  opacity: 0;
}
.carousel-control-prev:hover .arrow-in,
.carousel-control-next:hover .arrow-in {
  transform: translateX(0);
  opacity: 1;
}


/* PRODUK PILIHAN Vertical Carousel */
#produkPilihanCarousel .carousel-control-prev,
#produkPilihanCarousel .carousel-control-next {
  left: auto;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.5);
}

#produkPilihanCarousel .carousel-control-prev {
  top: 40%;
}

#produkPilihanCarousel .carousel-control-next {
  top: 60%;
}

#produkPilihanCarousel .carousel-inner {
  height: 500px;
  overflow: hidden;
}

#produkPilihanCarousel .carousel-item {
  height: 100%;
}
/* WRAPPER untuk animated arrows */
#animatedCarousels .carousel {
  position: relative;
}

/* Override tombol Bootstrap jadi container relatif + overflow hidden */
#animatedCarousels .carousel-control-prev,
#animatedCarousels .carousel-control-next {
  position: absolute;
  bottom: 15px;
  top: auto;
  transform: none;
  width: 40px;
  height: 40px;
  background-color: rgb(20, 16, 16);
  opacity: 30%;
  font-size: 2rem;
  overflow: hidden;
  z-index: 5;
}

/* Posisi per sisi */
#animatedCarousels .carousel-control-prev { left: 15px; }
#animatedCarousels .carousel-control-next { right: 15px; }

/* sembunyikan icon bawaan */
#animatedCarousels .carousel-control-prev-icon,
#animatedCarousels .carousel-control-next-icon {
  display: none;
}

/* Pseudo-elements: 
   - ::after = arrow-out (in place)
   - ::before = arrow-in (off-screen left)
*/
#animatedCarousels .carousel-control-prev::after,
#animatedCarousels .carousel-control-next::after,
#animatedCarousels .carousel-control-prev::before,
#animatedCarousels .carousel-control-next::before {
  position: absolute;
  font-size: 2.8rem;
  color: #ffffff;
  opacity: 1;
}

/* arrow-out = default */
#animatedCarousels .carousel-control-prev::after { content: '\2190'; /* ← */ transform: translateX(0); font-size: 2rem;}
#animatedCarousels .carousel-control-next::after { content: '\2192'; /* → */ transform: translateX(0); font-size: 2rem;}

/* arrow-in (hidden off-screen left) */
#animatedCarousels .carousel-control-prev::before { content: '\2190'; transform: translateX(-100%); opacity: 0;font-size: 2rem; }
#animatedCarousels .carousel-control-next::before { content: '\2192'; transform: translateX(-100%); opacity: 0;font-size: 2rem; }

/* Hover: slide arrow-out ke kanan dan fade, arrow-in slide ke posisi */
#animatedCarousels .carousel-control-prev:hover::after {
  animation: slideOut 0.7s forwards;
}
#animatedCarousels .carousel-control-prev:hover::before {
  animation: slideIn 0.7s forwards;
}
#animatedCarousels .carousel-control-next:hover::after {
  animation: slideOut 0.7s forwards;
}
#animatedCarousels .carousel-control-next:hover::before {
  animation: slideIn 0.7s forwards;
}

/* Keyframes (ambil dari CSS-mu) */
@keyframes slideOut {
  to {
    transform: translateX(100%);
    opacity: 0;
  }
}
@keyframes slideIn {
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
#produkPilihanCarousel { position: relative; }

#produkPilihanCarousel .vertical-controls {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
  z-index: 5;
}

#produkPilihanCarousel .btn-vert {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: rgba(0,0,0,0.5);
  border: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

#produkPilihanCarousel .arrow-vert {
  font-size: 1.5rem;
  color: #fff;
  transition: transform 0.3s, opacity 0.3s;
}

#produkPilihanCarousel .indicators-vert {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

#produkPilihanCarousel .indicators-vert button {
  width: 8px;
  height: 8px;
  border: none;
  border-radius: 50%;
  background: #ccc;
  transition: background 0.3s, transform 0.3s;
}

#produkPilihanCarousel .indicators-vert button.active {
  width: 12px;
  height: 12px;
  background: #05d1d1;
}
#produkPilihanCarousel .btn-vert {
  width: 48px;
  height: 48px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  border-radius: 50%;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.3s ease;
}

#produkPilihanCarousel .btn-vert:hover {
  background-color: #fff;
}

#produkPilihanCarousel .arrow-vert {
  color: #fff;
  font-size: 1.4rem;
  transition: color 0.3s ease;
}

#produkPilihanCarousel .btn-vert:hover .arrow-vert {
  color: #0258d3;
}

#produkPilihanCarousel .vertical-controls {
  position: absolute;
  right: 15px;
  top: 50%;
  transform: translateY(-50%);
  display: flex;
  flex-direction: column;
  gap: 1rem;
  z-index: 5;
}

#produkPilihanCarousel .indicators-vert {
  display: flex;
  flex-direction: column;
  gap: 8px;
  align-items: center;
}

</style>
<br><br><br><br>
<div id="animatedCarousels">
  <!-- Hero Carousel -->
  <div class="container-fluid px-2">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/banner_comp1.png') }}" alt="CTA Image 1">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Solusi Cetak Banner</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;"><span class="mt-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Tanpa</span><span class="mt-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;"> Keluar Rumah!</span></h3>
            <p class="mb-0" style="font-family: 'Barlow', sans-serif; font-size:1.2rem; font-weight:350; color:#fff;">Cetak semua kebutuhanmu, dari indoor, outdoor, sampai perintilan kantor.</p>
            <p class="mb-0" style="font-family: 'Barlow', sans-serif; font-size:1.2rem; font-weight:350; color:#fff;">Tinggal kirim, langsung jadi!</p>
            <a href="{{ url('/products') }}" class="btn-schedule">
              <span class="btn-text">SEMUA PRODUK</span>
              <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out fs-2"></i>
                <i class="bi bi-arrow-right-short arrow-in fs-2"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="carousel-item">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/banner_comp2.jpg') }}" alt="CTA Image 2">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Cetak Umbul-umbul</h3>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Buat Promosi</h3>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;">Bisnismu</h3>
            <a href="{{ url('/products') }}" class="btn-schedule">
              <span class="btn-text">LIHAT PRODUK</span>
              <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out fs-2"></i>
                <i class="bi bi-arrow-right-short arrow-in fs-2"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="carousel-item">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/banner_comp3.jpg') }}" alt="CTA Image 3">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Berkah Ramadhan </h3>
            <h3 class="mb-4" style="margin-top:-5px !important;"><span class="mt-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Kustom</span><span class="mt-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;"> Sekarang!</span></h3>
            <p class="mb-0" style="font-family: 'Barlow', sans-serif; font-size:1.2rem; font-weight:350; color:#fff;">Temukan produk-produk diskon #Paling Ramadhan di halaman promo,</p>
            <p class="mb-0" style="font-family: 'Barlow', sans-serif; font-size:1.2rem; font-weight:350; color:#fff;">bebas kustom dan Konsultasi gratis Coba sekarang!</p>
              <a href="{{ url('/products') }}" class="btn-schedule">
              <span class="btn-text">LIHAT PRODUK</span>
              <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out fs-2"></i>
                <i class="bi bi-arrow-right-short arrow-in fs-2"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev mb-4" type="button" data-bs-target="#heroCarousel" style="margin-left: 3rem;" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next mb-4" type="button" data-bs-target="#heroCarousel" style="margin-right: 3rem" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="bi bi-arrow-right-short arrow-out fs-2"></i></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</div>

  <div class="container-xl">
    <div class="title-up pt-4">
      <h3 class="mb-0 mt-4" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#000;">Pilih Sendiri</h3>
      <h3 class="mb-4" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#0439a0;">Kebutuhanmu!</h3>
    </div>
    <div id="labelsCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @foreach($labels->chunk(4) as $index => $chunk)
          <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            <div class="row g-4">
              @foreach($chunk as $lbl)
                @foreach($lbl->products as $product)
                  <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{ route('landingpage.produk_detail', $product->slug) }}" class="text-decoration-none">
                      <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                        <div class="position-relative bg-light overflow-hidden" style="border-radius:10px; height:290px;">
                          <img src="{{ asset('landingpage/img/product/product-1.png') }}"
                              class="img-fluid w-100 h-100"
                              style="object-fit:cover;">
                        </div>
                      </div>
                    </a>
                  </div>
                  @endforeach
              @endforeach
            </div>
          </div>
        @endforeach
      </div>

      <div class="carousel-controls-container">
        <div class="carousel-controls">
          <!-- Prev tombol -->
          <button class="carousel-control-prev" type="button"
                  data-bs-target="#labelsCarousel" data-bs-slide="prev">
            <span class="btn-arrow-carousel">
              <span class="arrow-out">&#8592;</span>
              <span class="arrow-in">&#8592;</span>
            </span>
            <span class="visually-hidden">Previous</span>
          </button>

          <!-- Next tombol -->
          <button class="carousel-control-next" type="button"
                  data-bs-target="#labelsCarousel" data-bs-slide="next">
            <span class="btn-arrow-carousel">
              <span class="arrow-out">&#8594;</span>
              <span class="arrow-in">&#8594;</span>
            </span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <div class="carousel-indicators-custom" id="labelsIndicators">
          @foreach($labels->chunk(4) as $index => $chunk)
            <div class="indicator-line {{ $index == 0 ? 'active' : '' }}"
                data-bs-target="#labelsCarousel"
                data-bs-slide-to="{{ $index }}">
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <br><br><br>
    <div class="row align-items-center">
      <div class="col-md-12 position-relative">
        <div class="step-content">
          <h4 style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#444444;">X DAN ROLL BANNER</h4>
          <h3 class="mb-4" style="margin-top:-5px !important;"><span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#000;">Cetak Roll Banner</span><span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#0258d3;"> Berkualitas</span></h3>
        </div>
      </div>
    </div>
    <div id="rollBannerCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @foreach($products->chunk(4) as $index => $chunk)
          <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            <div class="row g-4">
              @foreach($chunk as $prod)
                <div class="col-lg-3 col-md-6 col-sm-12">
                  <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                    <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                      <div class="position-relative bg-light overflow-hidden" style="border-radius:10px; height:290px;">
                        @if($prod->images->first())
                          <img src="{{ asset('landingpage/img/product/'.$prod->images->first()->image_product) }}"
                              class="img-fluid w-100 h-100" style="object-fit:cover;">
                        @else
                          <img src="{{ asset('landingpage/img/nophoto.jpg') }}"
                              class="img-fluid w-100 h-100" style="object-fit:cover;">
                        @endif
                      </div>
                      <div class="content p-3 d-flex flex-column" style="min-height:140px;">
                        <div class="title text-dark mb-0"
                            style="font-family: 'Poppins'; font-size:1.4rem; font-weight:600;">
                          {{ $prod->name }}
                        </div>
                        <div class="title mb-4"
                            style="font-family: 'Poppins'; font-size:0.8rem;">
                          Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}
                        </div>
                        @php
                          $base = $prod->price; $final = $base;
                          if($prod->discount_percent) $final -= $base * $prod->discount_percent / 100;
                          if($prod->discount_fix)     $final -= $prod->discount_fix;
                        @endphp
                        @if($final < $base)
                          <div class="title mb-0 mt-1" style="font-size:0.8rem; font-weight:600; color:#888;">
                            MULAI DARI
                          </div>
                          <div class="price-container d-flex align-items-center" style="gap:8px;">
                            <span class="discount-price text-decoration-line-through">
                              Rp {{ number_format($base,0,',','.') }}
                            </span>
                            <img src="{{ asset('landingpage/img/discount_logo.png') }}" alt="Diskon" style="width:18px;">
                            <span class="price fw-bold"
                                  style="font-family: 'Poppins'; font-size:1.3rem; color:#fc2865;">
                              Rp {{ number_format($final,0,',','.') }}
                            </span>
                          </div>
                        @else
                          <div class="title mb-0 mt-1" style="font-size:0.9rem; font-weight:400;">
                            Mulai Dari
                          </div>
                          <div class="price-container mt-0">
                            <span class="fw-bold">Rp {{ number_format($base,0,',','.') }}</span>
                          </div>
                        @endif
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
          <button class="carousel-control-prev" type="button"
                  data-bs-target="#rollBannerCarousel" data-bs-slide="prev">
            <span class="btn-arrow-carousel">
              <span class="arrow-out">&#8592;</span>
              <span class="arrow-in">&#8592;</span>
            </span>
            <span class="visually-hidden">Previous</span>
          </button>

          <!-- Next tombol -->
          <button class="carousel-control-next" type="button"
                  data-bs-target="#rollBannerCarousel" data-bs-slide="next">
            <span class="btn-arrow-carousel">
              <span class="arrow-out">&#8594;</span>
              <span class="arrow-in">&#8594;</span>
            </span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <div class="carousel-indicators-custom" id="rollBannerIndicators">
          @foreach($products->chunk(4) as $index => $chunk)
            <div class="indicator-line {{ $index == 0 ? 'active' : '' }}"
                data-bs-target="#rollBannerCarousel"
                data-bs-slide-to="{{ $index }}">
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <br><br><br>
    <div class="row align-items-center">
      <div class="col-md-12 position-relative">
        <div class="step-content">
          <h4 style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#444444;">PRODUK PROMO</h4>
          <h3 class="mb-4" style="margin-top:-5px !important;"><span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#000;">Lagi Promo Bulan Ini!</span></h3>
        </div>
      </div>
    </div>
    <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        @foreach($products->chunk(4) as $index => $chunk)
          <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
            <div class="row g-4">
              @foreach($chunk as $prod)
                <div class="col-lg-3 col-md-6 col-sm-12">
                  <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                    <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                      <div class="position-relative bg-light overflow-hidden" style="border-radius:10px; height:290px;">
                        @if($prod->images->first())
                          <img src="{{ asset('landingpage/img/product/'.$prod->images->first()->image_product) }}"
                              class="img-fluid w-100 h-100" style="object-fit:cover;">
                        @else
                          <img src="{{ asset('landingpage/img/nophoto.jpg') }}"
                              class="img-fluid w-100 h-100" style="object-fit:cover;">
                        @endif
                      </div>
                      <div class="content p-3 d-flex flex-column" style="min-height:140px;">
                        <div class="title text-dark mb-0"
                            style="font-family: 'Poppins'; font-size:1.4rem; font-weight:600;">
                          {{ $prod->name }}
                        </div>
                        <div class="title mb-4"
                            style="font-family: 'Poppins'; font-size:0.8rem;">
                          Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}
                        </div>
                        @php
                          $base = $prod->price; $final = $base;
                          if($prod->discount_percent) $final -= $base * $prod->discount_percent / 100;
                          if($prod->discount_fix)     $final -= $prod->discount_fix;
                        @endphp
                        @if($final < $base)
                          <div class="title mb-0 mt-1" style="font-size:0.8rem; font-weight:600; color:#888;">
                            MULAI DARI
                          </div>
                          <div class="price-container d-flex align-items-center" style="gap:8px;">
                            <span class="discount-price text-decoration-line-through">
                              Rp {{ number_format($base,0,',','.') }}
                            </span>
                            <img src="{{ asset('landingpage/img/discount_logo.png') }}" alt="Diskon" style="width:18px;">
                            <span class="price fw-bold"
                                  style="font-family: 'Poppins'; font-size:1.3rem; color:#fc2865;">
                              Rp {{ number_format($final,0,',','.') }}
                            </span>
                          </div>
                        @else
                          <div class="title mb-0 mt-1" style="font-size:0.9rem; font-weight:400;">
                            Mulai Dari
                          </div>
                          <div class="price-container mt-0">
                            <span class="fw-bold">Rp {{ number_format($base,0,',','.') }}</span>
                          </div>
                        @endif
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
          <!-- Prev -->
          <button class="carousel-control-prev" type="button"
                  data-bs-target="#promoCarousel" data-bs-slide="prev">
            <span class="btn-arrow-carousel">
              <span class="arrow-out">&#8592;</span>
              <span class="arrow-in">&#8592;</span>
            </span>
            <span class="visually-hidden">Previous</span>
          </button>

          <!-- Next -->
          <button class="carousel-control-next" type="button"
                  data-bs-target="#promoCarousel" data-bs-slide="next">
            <span class="btn-arrow-carousel">
              <span class="arrow-out">&#8594;</span>
              <span class="arrow-in">&#8594;</span>
            </span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

        <div class="carousel-indicators-custom" id="promoIndicators">
          @foreach($products->chunk(4) as $index => $chunk)
            <div class="indicator-line {{ $index == 0 ? 'active' : '' }}"
                data-bs-target="#promoCarousel"
                data-bs-slide-to="{{ $index }}">
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- PRODUK PILIHAN Vertical Carousel -->
  <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div id="produkPilihanCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/home_choice.png') }}" alt="CTA Image 1">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h4 class="mb-0" style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#fff;">PRODUK PILIHAN</h4>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Mau Cetak Banner</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;">
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Biar</span>
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#ffc74c;"> Keliatan di Jalan?</span>
            </h3>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">
              Cetak banner ukuran besar biar mencolok dari kejauhan.
            </p>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">
              Tipis-tipis curi perhatian pelanggan, mau coba lihat dulu?
            </p>
            <a href="{{ url('/products') }}" class="btn-schedule">
              <span class="btn-text">RINCIAN PRODUK</span>
              <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out"></i>
                <i class="bi bi-arrow-right-short arrow-in"></i>
              </span>
            </a>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/home_choice.png') }}" alt="CTA Image 2">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h4 class="mb-0" style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#fff;">PRODUK PILIHAN</h4>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Cetak Stiker</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;">
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Buat</span>
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#ffc74c;"> Branding Keren!</span>
            </h3>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">
              Stiker custom untuk promosi atau dekorasi.
            </p>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">
              Tahan lama dan eye-catching, cek sekarang!
            </p>
            <a href="{{ url('/products') }}" class="btn-schedule">
              <span class="btn-text">RINCIAN PRODUK</span>
              <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out"></i>
                <i class="bi bi-arrow-right-short arrow-in"></i>
              </span>
            </a>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/home_choice.png') }}" alt="CTA Image 3">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h4 class="mb-0" style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#fff;">PRODUK PILIHAN</h4>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Poster Besar</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;">
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Untuk</span>
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#ffc74c;"> Event Spesial!</span>
            </h3>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">
              Poster berkualitas tinggi untuk acara pentingmu.
            </p>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">
              Desain menarik, pesan sekarang!
            </p>
            <a href="{{ url('/products') }}" class="btn-schedule">
              <span class="btn-text">RINCIAN PRODUK</span>
              <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out"></i>
                <i class="bi bi-arrow-right-short arrow-in"></i>
              </span>
            </a>
          </div>
        </div>
      </div>

      <div class="vertical-controls">
        <!-- Prev ↑ -->
        <button class="carousel-control-prev btn-vert" type="button"
                data-bs-target="#produkPilihanCarousel" data-bs-slide="prev">
          <span class="arrow-vert up">&#8593;</span>
          <span class="visually-hidden">Previous</span>
        </button>

        <!-- Indicators Vertikal -->
        <div class="indicators-vert" id="produkPilihanIndicators">
          <button type="button" data-bs-target="#produkPilihanCarousel" data-bs-slide-to="0" class="active"></button>
          <button type="button" data-bs-target="#produkPilihanCarousel" data-bs-slide-to="1"></button>
          <button type="button" data-bs-target="#produkPilihanCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Next ↓ -->
        <button class="carousel-control-next btn-vert" type="button"
                data-bs-target="#produkPilihanCarousel" data-bs-slide="next">
          <span class="arrow-vert down">&#8595;</span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>

  <div class="container-lg py-5">
    <div class="row align-items-center flex-md-row-reverse">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="{{ asset('landingpage/img/sinau_holder.png') }}"
            alt="Step 2"
            class="img-fluid rounded-3">
      </div>
      <div class="col-md-6 position-relative">
        <div class="step-content">
          <h4 class="step-title" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#000;">Dari Semarang ke</h4>
          <h4 class="step-title" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#0258d3; margin-top: -20px">Seluruh Indonesia</h4>
          <p class="step-desc">
              Sejak 2024, Sinau Print selalu berkomitmen untuk menjadi penyedia jasa
              printing terbaik di Semarang. Dengan berbekal pengalaman dan teknologi
              mesin paling mutakhir, kami siap cetak segala kebutuhanmu.
          </p>
          <a href="{{ url('/products') }}" class="btn-schedule">
          <span class="btn-text">TENTANG SINAU</span>
          <span class="btn-arrow">
              <i class="bi bi-arrow-right-short arrow-out"></i>
              <i class="bi bi-arrow-right-short arrow-in"></i>
          </span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative">
      <img
        class="w-100 rounded"
        src="{{ asset('landingpage/img/login_register_bg.png') }}"
        alt="Background"
      />

      <div
        class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3 feedback-container"
      >
        {{-- Judul dinaikkan --}}
        <h3
          class="mb-5"
          style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;"
        >
          Kata Mereka <span style="color:#ffc74c;">Tentang Sinau Print</span>
        </h3>

        {{-- Swiper --}}
        <div class="swiper feedback-swiper">
          <div class="swiper-wrapper">
            @php
              $dummy = [
                "Pelayanan yang sangat ramah\ndibantu sampai selesai",
                "Cepat sekali pengerjaannya!",
                "Mau online atau offline,\nmudah banget dan cepat!",
                "Warna nya bagus!",
                "Kualitas cetak juara!"
              ];
              $names = ["Andi","Budi","Citra","Dewi","Eka"];
              $addrs = ["Jakarta","Bandung","Surabaya","Yogyakarta","Medan"];
            @endphp

            {{-- 5 slide asli + clone 10× --}}
            @for($clone=0; $clone<11; $clone++)
              @foreach($dummy as $i => $text)
                <div class="swiper-slide">
                  <div class="card mx-auto position-relative"
                      style="max-width:400px; height:260px; border-radius:10px; background-color:#4a87dd;">
                    
                    <div class="card-body d-flex flex-column justify-content-start h-100">
                      {{-- tanda kutip besar di atas --}}
                      <div class="text-start">
                        <span style="font-size:4rem; line-height:1; color:rgba(255,255,255,0.3);">“</span>
                      </div>

                      {{-- teks quote dinaikkan --}}
                      <h4 class="card-text text-white" style="font-family: 'Barlow', sans-serif;white-space:pre-line; margin-top:-1rem; margin-bottom:1rem;">
                        {{ $text }}
                      </h4>

                      {{-- foto + nama + alamat absolute --}}
                      <img
                        src="{{ asset('landingpage/img/testimonial'.($i+1).'.jpg') }}"
                        alt="Foto testimonial {{ $i+1 }}"
                        class="rounded-circle"
                        style="width:48px; height:48px; object-fit:cover;
                              position:absolute; bottom:10px; left:10px;"
                      />
                      <div
                        style="position:absolute; bottom:12px; left:68px; text-align:left;"
                      >
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

{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">Mau Cetak Keperluan Kantor?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#ffc74c; margin-top:-4px;">Boleh Tanya Dulu!</h3>
            <a href="{{ url('/products') }}" class="btn-schedule">
            <span class="btn-text">JADWALKAN KONSULTASI</span>
            <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out"></i>
                <i class="bi bi-arrow-right-short arrow-in"></i>
            </span>
            </a>
        </div>
    </div>
</div>

<script>
function updateCustomIndicators(carouselId, indicatorsId) {
    const carousel = document.querySelector(carouselId);
    const indicators = document.querySelectorAll(`#${indicatorsId} .indicator-line`);
    
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

// Initialize for each carousel with custom indicators
updateCustomIndicators('#labelsCarousel', 'labelsIndicators');
updateCustomIndicators('#rollBannerCarousel', 'rollBannerIndicators');
updateCustomIndicators('#promoCarousel', 'promoIndicators');
updateCustomIndicators('#produkPilihanCarousel', 'produkPilihanIndicators');

</script>
{{-- Include Swiper JS/CSS di <head> atau sebelum </body> seperti ini: --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

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