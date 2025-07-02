@extends('landingpage.index')
@section('content')
    <link rel="stylesheet" href="{{ asset('landingpage/css/homepage.css') }}">

    <div class="py-4 my-4"></div>

    <div id="animatedCarousels">
      <!-- Hero Carousel -->
      <div class="container-fluid">
          <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
              @if($banners->count() > 0)
                  <div class="carousel-indicators">
                      @foreach($banners as $index => $banner)
                          <button type="button"
                                  data-bs-target="#heroCarousel"
                                  data-bs-slide-to="{{ $index }}"
                                  class="{{ $index == 0 ? 'active' : '' }}"
                                  aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                  aria-label="Slide {{ $index + 1 }}">
                          </button>
                      @endforeach
                  </div>

                  <div class="carousel-inner">
                      @foreach($banners as $index => $banner)
                          @php
                              $headingParts = explode(';', $banner->heading);
                              $processedHeading = [];
                              foreach($headingParts as $part) {
                                  $part = trim($part);
                                  $part = preg_replace('/\*(.*?)\*/', '<span style="color:#ffc74c;">$1</span>', $part);
                                  $processedHeading[] = $part;
                              }

                              $backgroundImage = $banner->photo
                                  ? asset('storage/' . $banner->photo)
                                  : asset('landingpage/img/banner_comp1.png');
                          @endphp

                          <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                              <div class="slide w-100 p-xl-5 p-3 rounded"
                                  style="background-image: url({{ $backgroundImage }}); height: 550px; background-size: cover;">
                                  <div class="string-cover m-5">
                                      @foreach($processedHeading as $i => $line)
                                          @if($i == 0)
                                              <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.6rem; font-weight:600; color:#fff;">{!! $line !!}</h1>
                                          @else
                                              <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.6rem; font-weight:600; color:#fff;">{!! $line !!}</h1>
                                          @endif
                                      @endforeach

                                      @php
                                          $contentLines = preg_split('/(?<=[.!?])\s+/', $banner->content);
                                      @endphp

                                      @foreach($contentLines as $line)
                                          @if(trim($line))
                                              <p class="mb-0"
                                                style="font-family: 'Poppins', sans-serif; font-weight:350; color:#fff;">
                                                  {{ trim($line) }}
                                              </p>
                                          @endif
                                      @endforeach

                                      <br>
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
                      @endforeach
                  </div>
              @else
                  <!-- default carousel -->
                  <div class="carousel-indicators">
                      <button type="button"
                              data-bs-target="#heroCarousel"
                              data-bs-slide-to="0"
                              class="active"
                              aria-current="true"
                              aria-label="Slide 1">
                      </button>
                  </div>
                  <div class="carousel-inner">
                      <div class="carousel-item active">
                          <div class="slide w-100 p-xl-5 p-3 rounded"
                              style="background-image: url({{ asset('landingpage/img/banner_comp1.png') }}); height: 550px; background-size: cover;">
                              <div class="string-cover m-5">
                                  <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.6rem; font-weight:600; color:#fff;">Solusi Cetak Banner</h3>
                                  <h3 class="mb-4" style="margin-top:-5px !important;">
                                      <span style="color:#fff;">Tanpa</span>
                                      <span style="color:#ffc74c;"> Keluar Rumah!</span>
                                  </h3>
                                  <p class="mb-0"
                                    style="font-family: 'Poppins', sans-serif; font-weight:350; color:#fff;">
                                      Cetak semua kebutuhanmu, dari indoor, outdoor, sampai perintilan kantor.
                                  </p>
                                  <p class="mb-0"
                                    style="font-family: 'Poppins', sans-serif; font-weight:350; color:#fff;">
                                      Tinggal kirim, langsung jadi!
                                  </p>
                                  <br>
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
              @endif

              @if($banners->count() > 1)
                  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                      <i class="bi bi-arrow-left-short arrow-out fs-3 py-2 px-3 ms-5 bg-dark text-white rounded-circle"></i>
                      <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                      <i class="bi bi-arrow-right-short arrow-out fs-3 py-2 px-3 me-5 bg-dark text-white rounded-circle"></i>
                      <span class="visually-hidden">Next</span>
                  </button>
              @endif
          </div>
      </div>
    </div>

    <div class="container-xl">
        <div class="title-up pt-4">
            <h3 class="mb-0 mt-4" style="color:#000;">Pilih Sendiri</h3>
            <h3 class="mb-4" style="color:#0439a0;">Kebutuhanmu!</h3>
        </div>
        <div id="labelsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($labels->chunk(4) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach ($chunk as $lbl)
                                @foreach ($lbl->products as $product)
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <a href="{{ route('landingpage.produk_detail', $product->slug) }}"
                                            class="text-decoration-none">
                                            <div class="product-item shadow-sm bg-white h-100"
                                                style="border-radius:10px;">
                                                <div class="position-relative bg-light overflow-hidden"
                                                    style="border-radius:10px; height:290px;">
                                                    <img src="{{ asset('landingpage/img/product/product-1.png') }}"
                                                        class="img-fluid w-100 h-100" style="object-fit:cover;">
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
                    <button class="carousel-control-prev" type="button" data-bs-target="#labelsCarousel"
                        data-bs-slide="prev">
                        <span class="btn-arrow-carousel">
                            <span class="arrow-out">&#8592;</span>
                            <span class="arrow-in">&#8592;</span>
                        </span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <!-- Next tombol -->
                    <button class="carousel-control-next" type="button" data-bs-target="#labelsCarousel"
                        data-bs-slide="next">
                        <span class="btn-arrow-carousel">
                            <span class="arrow-out">&#8594;</span>
                            <span class="arrow-in">&#8594;</span>
                        </span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <div class="carousel-indicators-custom" id="labelsIndicators">
                    @foreach ($labels->chunk(4) as $index => $chunk)
                        <div class="indicator-line {{ $index == 0 ? 'active' : '' }}" data-bs-target="#labelsCarousel"
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
                    <h4 style="font-family: 'Poppins'; font-size:1rem; font-weight:600; color:#444444;">X DAN ROLL BANNER
                    </h4>
                    <h3 class="mb-4" style="margin-top:-5px !important;"><span class="mt-0"
                            style="color:#000;">Cetak Roll Banner</span><span class="mt-0" style="color:#0258d3;">
                            Berkualitas</span></h3>
                </div>
            </div>
        </div>
        <div id="rollBannerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($products->chunk(4) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach ($chunk as $prod)
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="{{ route('landingpage.produk_detail', $prod->slug) }}"
                                        class="text-decoration-none">
                                        <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                                            <div class="position-relative bg-light overflow-hidden"
                                                style="border-radius:10px; height:290px;">
                                                @php
                                                    $image = $prod->images->first();
                                                @endphp
                                                @if($image && $image->image_product && file_exists(storage_path('app/public/' . $image->image_product)))
                                                    <img src="{{ asset('storage/' . $image->image_product) }}"
                                                        class="img-fluid w-100 h-100" style="object-fit:cover;" 
                                                        alt="{{ $prod->name }}">
                                                @else
                                                    <img src="{{ asset('landingpage/img/nophoto.png') }}"
                                                        class="img-fluid w-100 h-100" style="object-fit:cover;"
                                                        alt="No Image">
                                                @endif
                                            </div>
                                            <div class="content p-3 d-flex flex-column" style="min-height:140px;">
                                                <div class="title text-dark mb-0"
                                                    style="font-family: 'Poppins'; font-size:1.4rem; font-weight:600;">
                                                    {{ $prod->name }}
                                                </div>
                                                <div class="title mb-4" style="font-family: 'Poppins'; font-size:0.8rem;">
                                                    Ukuran
                                                    {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }}
                                                    {{ $prod->additional_unit }}
                                                </div>
                                                @php
                                                    $base = $prod->price;
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
                          <div class="title mb-0 mt-1" style="font-size:0.8rem; font-weight:600; color:#888;">
                            Mulai Dari
                          </div>
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
                        @php
                            $image = $prod->images->first();
                        @endphp
                        @if($image && $image->image_product && file_exists(storage_path('app/public/' . $image->image_product)))
                            <img src="{{ asset('storage/' . $image->image_product) }}"
                                class="img-fluid w-100 h-100" style="object-fit:cover;" 
                                alt="{{ $prod->name }}">
                        @else
                            <img src="{{ asset('landingpage/img/nophoto.png') }}"
                                class="img-fluid w-100 h-100" style="object-fit:cover;"
                                alt="No Image">
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
                          <div class="title mb-0 mt-1" style="font-size:0.8rem; font-weight:600; color:#888;">
                            Mulai Dari
                          </div>
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

        <div class="position-absolute top-50 start-50 translate-middle text-center w-100 px-3 feedback-container">
            <h3 class="mb-5" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">
                Kata Mereka <span style="color:#ffc74c;">Tentang Sinau Print</span>
            </h3>

            {{-- Swiper Container --}}
            <div class="swiper feedback-swiper">
                <div class="swiper-wrapper">
                    @if($testimonials->count() > 0)
                        {{-- Duplicate testimonials untuk seamless loop --}}
                        @php
                            $totalSlides = $testimonials->count();
                            $duplicateCount = max(15, ceil(15 / $totalSlides) * $totalSlides);
                        @endphp
                        
                        @for($i = 0; $i < $duplicateCount; $i++)
                            @php
                                $testimonial = $testimonials[$i % $totalSlides];
                                // Check if photo exists in storage
                                $photoPath = $testimonial->photo 
                                    ? 'storage/' . $testimonial->photo 
                                    : null;
                                $photoExists = $photoPath && file_exists(public_path($photoPath));
                                $photoUrl = $photoExists 
                                    ? asset($photoPath) 
                                    : asset('landingpage/img/no-photo-icon.jpg');
                            @endphp
                            
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <div class="quote-mark">"</div>
                                    <div class="testimonial-text">
                                        {{ $testimonial->feedback }}
                                    </div>
                                    <div class="testimonial-author">
                                        <img
                                            src="{{ $photoUrl }}"
                                            alt="{{ $testimonial->name }}"
                                            class="author-photo"
                                            onerror="this.src='{{ asset('landingpage/img/no-photo-icon.jpg') }}'"
                                        />
                                        <div class="author-info">
                                            <div class="author-name">{{ $testimonial->name }}</div>
                                            <div class="author-location">{{ $testimonial->location }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @else
                        {{-- Fallback testimonials --}}
                        @php
                            $dummyTestimonials = [
                                ['text' => "Pelayanan yang sangat ramah\ndibantu sampai selesai", 'name' => 'Andi', 'location' => 'Jakarta'],
                                ['text' => "Cepat sekali pengerjaannya!", 'name' => 'Budi', 'location' => 'Bandung'],
                                ['text' => "Mau online atau offline,\nmudah banget dan cepat!", 'name' => 'Citra', 'location' => 'Surabaya'],
                                ['text' => "Warna nya bagus banget!", 'name' => 'Dewi', 'location' => 'Yogyakarta'],
                                ['text' => "Kualitas cetak juara!", 'name' => 'Eka', 'location' => 'Medan'],
                            ];
                        @endphp
                        
                        @for($i = 0; $i < 15; $i++)
                            @php
                                $dummy = $dummyTestimonials[$i % count($dummyTestimonials)];
                                $photoIndex = ($i % 5) + 1;
                                $photoPath = 'landingpage/img/testimonial' . $photoIndex . '.jpg';
                                $photoExists = file_exists(public_path($photoPath));
                                $photoUrl = $photoExists 
                                    ? asset($photoPath) 
                                    : asset('landingpage/img/no-photo-icon.jpg');
                            @endphp
                            
                            <div class="swiper-slide">
                                <div class="testimonial-card">
                                    <div class="quote-mark">"</div>
                                    <div class="testimonial-text">
                                        {{ $dummy['text'] }}
                                    </div>
                                    <div class="testimonial-author">
                                        <img
                                            src="{{ $photoUrl }}"
                                            alt="{{ $dummy['name'] }}"
                                            class="author-photo"
                                            onerror="this.src='{{ asset('landingpage/img/no-photo-icon.jpg') }}'"
                                        />
                                        <div class="author-info">
                                            <div class="author-name">{{ $dummy['name'] }}</div>
                                            <div class="author-location">{{ $dummy['location'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endif
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
<!-- Sticky Discount Tab -->
<div class="discount-tab" data-bs-toggle="modal" data-bs-target="#discountModal">
    <div class="discount-tab-text">AMBIL DISKON</div>
</div>

<!-- Discount Modal -->
<div class="modal fade discount-modal" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <button type="button" class="modal-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="bi bi-x"></i>
            </button>
            
            <div class="modal-body">
                <div class="row g-0 h-100">
                    <!-- Image Section - 5/12 -->
                    <div class="col-md-5 modal-image-section d-flex align-items-center justify-content-center">
                        <img src="{{ asset('landingpage/img/disc-modals.png') }}" alt="Discount Offer" />
                    </div>
                    
                    <!-- Content Section - 7/12 -->
                    <div class="col-md-7 modal-content-section">
                        <h2 class="modal-title">Langganan website bisa dapat diskon!</h2>
                        <p class="modal-subtitle">
                            Subscribe sekarang dan dapatkan kabar terbaru berbagai promo
                            menarik dari Sinau Print!
                        </p>
                        
                        <form id="discountForm" class="email-form-container" action="{{ route('newsletter.subscribe') }}" method="POST">
                            @csrf
                            <input 
                                type="email" 
                                name="email"
                                class="email-input" 
                                placeholder="masukkan email Anda"
                                required
                                id="emailInput"
                            />
                            <button type="submit" class="submit-btn">
                                SUBMIT
                            </button>
                        </form>
                        
                        <div class="mt-3 text-muted small">
                            * Dengan mendaftar, Anda setuju untuk menerima email promosi dari kami
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.feedback-swiper {
    width: 100%;
    height: auto;
    overflow: hidden;
}

.swiper-wrapper {
    transition-timing-function: linear !important;
}

.testimonial-card {
    position: relative;
    max-width: 400px;
    height: 260px;
    margin: 0 auto;
    padding: 30px;
    border-radius: 10px;
    background-color: #4a87dd;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.quote-mark {
    position: absolute;
    top: 10px;
    left: 20px;
    font-size: 4rem;
    line-height: 1;
    color: rgba(255, 255, 255, 0.3);
}

.testimonial-text {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px 10px;
    font-family: 'Barlow', sans-serif;
    font-size: 1.25rem;
    color: white;
    white-space: pre-line;
    text-align: center;
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
}

.author-info {
    text-align: left;
}

.author-name {
    color: #ffc74c;
    font-weight: bold;
    line-height: 1.2;
}

.author-location {
    color: white;
    font-size: 0.875rem;
    line-height: 1.2;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .testimonial-card {
        max-width: 350px;
        height: 240px;
        padding: 25px;
    }
    
    .testimonial-text {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .testimonial-card {
        max-width: 300px;
        height: 220px;
        padding: 20px;
    }
    
    .testimonial-text {
        font-size: 1rem;
    }
    
    .quote-mark {
        font-size: 3rem;
    }
}
</style>

<script>
// Form submission handler untuk newsletter
document.getElementById('discountForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('.submit-btn');
    const originalText = submitBtn.innerHTML;
    
    // Loading state
    submitBtn.innerHTML = 'MEMPROSES...';
    submitBtn.disabled = true;
    
    // Submit via fetch
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Terima kasih! Email Anda telah terdaftar untuk mendapatkan diskon.');
            form.reset();
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('discountModal'));
            modal.hide();
        } else {
            alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Add animation to tab on scroll
document.addEventListener('scroll', function() {
    const tab = document.querySelector('.discount-tab');
    if (tab) {
        const scrolled = window.pageYOffset;
        const movement = Math.sin(scrolled * 0.001) * 2;
        tab.style.transform = `translateY(-50%) translateX(${movement}px)`;
    }
});
</script>

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
document.addEventListener('DOMContentLoaded', function() {
    let swiper = new Swiper('.feedback-swiper', {
        slidesPerView: 'auto',
        spaceBetween: 30,
        speed: 5000,
        autoplay: {
            delay: 0,
            disableOnInteraction: false,
            pauseOnMouseEnter: false,
        },
        loop: true,
        loopAdditionalSlides: 10,
        allowTouchMove: false,
        freeMode: {
            enabled: true,
            sticky: false,
            momentum: false,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        },
        on: {
            init: function() {
                // Ensure continuous animation
                this.el.addEventListener('mouseenter', () => {
                    this.autoplay.stop();
                });
                
                this.el.addEventListener('mouseleave', () => {
                    this.autoplay.start();
                });
            }
        }
    });

    // Restart animation if it stops
    setInterval(() => {
        if (swiper && swiper.autoplay && !swiper.autoplay.running) {
            swiper.autoplay.start();
        }
    }, 1000);
});
</script>

@endsection