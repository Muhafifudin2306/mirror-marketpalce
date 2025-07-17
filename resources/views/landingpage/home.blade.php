@extends('landingpage.index')
@section('content')
    <link rel="stylesheet" href="{{ asset('landingpage/css/homepage.css') }}">

    <style>
      .btn-about-sinau {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: transparent;
            border: 1px solid #000;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-about-sinau .btn-text {
            color: #000;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .btn-about-sinau .btn-arrow {
            width: 32px;
            height: 32px;
            background: #0258d3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease;
        }

        .btn-about-sinau .arrow-out,
        .btn-about-sinau .arrow-in {
            color: #fff;
            font-size: 20px;
            position: absolute;
            transition: all 0.3s ease;
        }

        .btn-about-sinau .arrow-in {
            transform: translateX(40px);
        }

        .btn-about-sinau:hover {
            background: #0258d3;
            border-color: transparent;
        }

        .btn-about-sinau:hover .btn-text {
            color: #fff;
        }

        .btn-about-sinau:hover .btn-arrow {
            background: #05d1d1;
        }

        .btn-about-sinau:hover .arrow-out {
            transform: translateX(-40px);
        }

        .btn-about-sinau:hover .arrow-in {
            transform: translateX(0);
        }
        .btn-semua-artikel {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: transparent;
            border: 1px solid #000;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-semua-artikel .btn-text {
            color: #000;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .btn-semua-artikel .btn-arrow {
            width: 32px;
            height: 32px;
            background: #0258d3;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease;
        }

        .btn-semua-artikel .arrow-out,
        .btn-semua-artikel .arrow-in {
            color: #fff;
            font-size: 20px;
            position: absolute;
            transition: all 0.3s ease;
        }

        .btn-semua-artikel .arrow-in {
            transform: translateX(40px);
        }

        .btn-semua-artikel:hover {
            background: #0258d3;
            border-color: transparent;
        }

        .btn-semua-artikel:hover .btn-text {
            color: #fff;
        }

        .btn-semua-artikel:hover .btn-arrow {
            background: #05d1d1;
        }

        .btn-semua-artikel:hover .arrow-out {
            transform: translateX(-40px);
        }

        .btn-semua-artikel:hover .arrow-in {
            transform: translateX(0);
        }

        /* Style untuk card artikel - mirip dengan card produk */
        .article-card-home {
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
            .string-cover {
                margin: 1rem !important;
                padding: 1rem !important;
            }
            
            .string-cover h3 {
                font-size: 2rem !important;
                line-height: 1.2 !important;
            }
            
            .slide {
                height: 400px !important;
                padding: 1rem !important;
            }
            .carousel-item .row {
                justify-content: center;
            }
            
            .carousel-item .col-12 {
                max-width: 90%;
                margin: 0 auto;
            }
            
            .product-item {
                max-width: 100%;
                margin: 0 auto;
            }
            
            .carousel-controls-container {
                margin-top: 1.5rem !important;
            }

            .carousel-inner .row .col-lg-3,
            .carousel-inner .row .col-md-6 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
            }
            
            .carousel-inner .row .col-lg-3:not(:first-child),
            .carousel-inner .row .col-md-6:not(:first-child) {
                display: none !important;
            }

            .cta-content {
                padding: 1rem !important;
                left: 1rem !important;
                right: 1rem !important;
                width: calc(100% - 2rem) !important;
            }
            
            .cta-content h3 {
                font-size: 1.8rem !important;
                line-height: 1.3 !important;
            }
            
            .cta-content h4 {
                font-size: 0.7rem !important;
            }
            
            .cta-content p {
                font-size: 0.75rem !important;
                line-height: 1.4 !important;
            }

            .step-content h4 {
                font-size: 2rem !important;
                line-height: 1.2 !important;
                margin-bottom: 1rem !important;
            }
            
            .step-desc {
                font-size: 0.85rem !important;
                line-height: 1.5 !important;
                margin-bottom: 1.5rem !important;
            }

            .container-xl.py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }
            
            .article-card-home {
                margin-bottom: 1.5rem !important;
            }

            .cta-content h3 {
                font-size: 1.6rem !important;
                line-height: 1.3 !important;
                margin-bottom: 1rem !important;
            }
            
            .btn-schedule .btn-text {
                font-size: 0.8rem !important;
            }

            .feedback-container h3 {
                font-size: 2rem !important;
                line-height: 0.3 !important;
                margin-bottom: 2rem !important;
            }

            .container-xl, .container-lg {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .py-5 {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }
            
            .mt-5 {
                margin-top: 2rem !important;
            }
            
            .pt-5 {
                padding-top: 2rem !important;
            }
            .discount-modal .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }
            
            .modal-content-section {
                padding: 2rem 1.5rem !important;
            }
            
            .modal-title {
                font-size: 1.5rem !important;
                line-height: 1.3 !important;
            }
            
            .modal-subtitle {
                font-size: 0.9rem !important;
            }
            
            .email-input {
                font-size: 1rem !important;
                padding: 0.75rem !important;
            }
            
            .submit-btn {
                font-size: 0.9rem !important;
                padding: 0.75rem 1.5rem !important;
            }
        }

        @media (max-width: 576px) {
            .string-cover h3 {
                font-size: 1.5rem !important;
            }
            
            .slide {
                height: 350px !important;
            }
            
            .cta-content h3 {
                font-size: 1.4rem !important;
            }
            
            .step-content h4 {
                font-size: 1.8rem !important;
            }
            
            .feedback-container h3 {
                font-size: 1.8rem !important;
            }
        }
    </style>

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
                                              <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:600; color:#fff;">{!! $line !!}</h1>
                                          @else
                                              <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:600; color:#fff;">{!! $line !!}</h1>
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
                                  <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3.3rem; font-weight:600; color:#fff;">Solusi Cetak Banner</h3>
                                  <h3 class="mb-4" style="margin-top:-5px !important; font-family: 'Poppins'; font-size:3.3rem; font-weight:600;">
                                      <span style="color:#fff;">Tanpa</span>
                                      <span style="color:#ffc74c;"> Keluar Rumah!</span>
                                  </h3>
                                  <p class="mb-0"
                                    style="font-family: 'Poppins', sans-serif; font-weight:350; font-size:0.9rem; color:#fff;">
                                      Cetak semua kebutuhanmu, dari indoor, outdoor, sampai perintilan kantor.
                                  </p>
                                  <p class="mb-0"
                                    style="font-family: 'Poppins', sans-serif; font-weight:350; font-size:0.9rem; color:#fff;">
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
        <h3 class="mb-0 mt-4" style="font-family: 'Poppins'; font-size:2.5rem; font-weight:600; color:#000;">Pilih Sendiri</h3>
        <h3 class="mb-4" style="font-family: 'Poppins'; font-size:2.5rem; font-weight:600; color:#0439a0;">Kebutuhanmu!</h3>
    </div>
    
    <!-- Labels Carousel -->
    <div id="labelsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($labels->chunk(4) as $index => $chunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row g-4">
                        @foreach ($chunk as $label)
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <a href="{{ route('landingpage.products', array_merge(request()->all(), ['filter' => $label->id, 'product' => null])) }}"
                                    class="text-decoration-none">
                                    <div class="product-item shadow-sm bg-white h-100"
                                        style="border-radius:10px;">
                                        <div class="position-relative bg-light overflow-hidden"
                                            style="border-radius:10px; height:290px;">
                                            @php
                                                $firstProduct = $label->products->first();
                                                $image = $firstProduct ? $firstProduct->images->first() : null;
                                            @endphp
                                            @if($image && $image->image_product && file_exists(storage_path('app/public/' . $image->image_product)))
                                                <img src="{{ asset('storage/' . $image->image_product) }}"
                                                    class="img-fluid w-100 h-100" style="object-fit:cover;" 
                                                    alt="{{ $label->name }}">
                                            @else
                                                <img src="{{ asset('landingpage/img/nophoto.png') }}"
                                                    class="img-fluid w-100 h-100" style="object-fit:cover;"
                                                    alt="No Image">
                                            @endif
                                            <div class="position-absolute bottom-0 start-0 w-100 p-3" 
                                                style="background: linear-gradient(transparent, rgba(0,0,0,0.7)); border-radius: 0 0 10px 10px;">
                                                <h5 class="text-white mb-0 fw-bold" style="font-family: 'Poppins'; font-size: 1.1rem; font-weight:550 !important;">
                                                    {{ Str::limit($label->name, 35) }}
                                                </h5>
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

        <!-- Controls for Labels Carousel -->
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

    <br>

    <!-- Roll Banner Section -->
    <div class="row align-items-center">
        <div class="col-md-12 position-relative">
            <div class="diamond-accent"></div>
            <div class="step-content">
                <h4 style="font-family: 'Poppins'; font-size:0.8rem; font-weight:600; color:#444444;">X DAN ROLL BANNER</h4>
                <h3 class="mb-4" style="margin-top:-5px !important; font-family: 'Poppins'; font-size:2.5rem; font-weight:600;">
                    <span class="mt-0" style="color:#000;">Cetak Roll Banner</span>
                    <span class="mt-0" style="color:#0258d3;"> Berkualitas</span>
                </h3>
            </div>
        </div>
    </div>

    <!-- Roll Banner Carousel -->
    <div id="rollBannerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if($hasRollBannerProducts)
                @foreach ($rollBannerProducts->chunk(4) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach ($chunk as $prod)
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="{{ route('landingpage.produk_detail', $prod->slug) }}"
                                        class="text-decoration-none">
                                        <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                                            <div class="position-relative bg-light overflow-hidden"
                                                style="border-radius:10px; height:200px;">
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
                                                    style="font-family: 'Poppins'; font-size:1.1rem; font-weight:600;">
                                                    {{ Str::limit($prod->name, 30) }}
                                                    @if($prod->additional_size && $prod->additional_unit)
                                                        {{ $prod->additional_size }} {{ $prod->additional_unit }}
                                                    @endif
                                                </div>
                                                <div class="title mb-4" style="font-family: 'Poppins'; font-size:0.7rem; font-weight:400;">
                                                    Ukuran
                                                    {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }}
                                                    {{ $prod->additional_unit }}
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
                    </div>
                @endforeach
            @else
                <div class="carousel-item active">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="text-center py-5">
                                <img src="{{ asset('landingpage/img/no-products.png') }}" 
                                    alt="Tidak ada produk" 
                                    class="img-fluid mb-3" 
                                    style="max-width: 200px; opacity: 0.6;"
                                    onerror="this.style.display='none'">
                                <h5 class="text-muted mb-2" style="font-family: 'Poppins'; font-weight: 500;">
                                    Belum Ada Produk Roll Banner
                                </h5>
                                <p class="text-muted" style="font-family: 'Poppins'; font-size: 0.9rem;">
                                    Produk Print Outdoor dan Print Indoor sedang dalam persiapan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Controls for Roll Banner Carousel -->
        @if($hasRollBannerProducts)
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
                    @foreach($rollBannerProducts->chunk(4) as $index => $chunk)
                        <div class="indicator-line {{ $index == 0 ? 'active' : '' }}"
                            data-bs-target="#rollBannerCarousel"
                            data-bs-slide-to="{{ $index }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <br>

    <!-- Promo Section -->
    <div class="row align-items-center">
        <div class="col-md-12 position-relative">
            <div class="diamond-accent"></div>
            <div class="step-content">
                <h4 style="font-family: 'Poppins'; font-size:0.8rem; font-weight:600; color:#444444;">PRODUK PROMO</h4>
                <h3 class="mb-4" style="margin-top:-5px !important; font-family: 'Poppins'; font-size:2.5rem; font-weight:600;">
                    <span class="mt-0" style="color:#000;">Lagi Promo Bulan Ini!</span>
                </h3>
            </div>
        </div>
    </div>

    <!-- Promo Carousel -->
    <div id="promoCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if($hasPromoProducts)
                @foreach($promoProducts->chunk(4) as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach($chunk as $prod)
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                                        <div class="product-item shadow-sm bg-white h-100" style="border-radius:10px;">
                                            <div class="position-relative bg-light overflow-hidden" style="border-radius:10px; height:200px;">
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
                                                    style="font-family: 'Poppins'; font-size:1.1rem; font-weight:600;">
                                                    {{ Str::limit($prod->name, 30) }}
                                                    @if($prod->additional_size && $prod->additional_unit)
                                                        {{ $prod->additional_size }} {{ $prod->additional_unit }}
                                                    @endif
                                                </div>
                                                <div class="title mb-4"
                                                    style="font-family: 'Poppins'; font-size:0.7rem;">
                                                    Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}
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
                    </div>
                @endforeach
            @else
                <div class="carousel-item active">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="text-center py-5">
                                <img src="{{ asset('landingpage/img/no-promo.png') }}" 
                                    alt="Tidak ada promo" 
                                    class="img-fluid mb-3" 
                                    style="max-width: 200px; opacity: 0.6;"
                                    onerror="this.style.display='none'">
                                <h5 class="text-muted mb-2" style="font-family: 'Poppins'; font-weight: 500;">
                                    Belum Ada Promo Aktif
                                </h5>
                                <p class="text-muted" style="font-family: 'Poppins'; font-size: 0.9rem;">
                                    Pantau terus untuk mendapatkan promo menarik bulan ini!
                                </p>
                                <a href="{{ url('/products') }}" class="btn btn-outline-primary mt-2" style="border-radius: 25px; padding: 8px 20px; font-size: 0.9rem;">
                                    Lihat Semua Produk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Controls for Promo Carousel -->
        @if($hasPromoProducts)
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
                    @foreach($promoProducts->chunk(4) as $index => $chunk)
                        <div class="indicator-line {{ $index == 0 ? 'active' : '' }}"
                            data-bs-target="#promoCarousel"
                            data-bs-slide-to="{{ $index }}">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

  <!-- PRODUK PILIHAN Vertical Carousel -->
  <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div id="produkPilihanCarousel" class="carousel slide carousel-vertical" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
          <img class="w-100 rounded" src="{{ asset('landingpage/img/home_choice.png') }}" alt="CTA Image 1">
          <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h4 class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:600; color:#fff;">PRODUK PILIHAN</h4>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">Mau Cetak Banner</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;">
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">Biar</span>
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#ffc74c;"> Keliatan di Jalan?</span>
            </h3>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">
              Cetak banner ukuran besar biar mencolok dari kejauhan.
            </p>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">
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
            <h4 class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:600; color:#fff;">PRODUK PILIHAN</h4>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">Cetak Stiker</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;">
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">Buat</span>
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#ffc74c;"> Branding Keren!</span>
            </h3>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">
              Stiker custom untuk promosi atau dekorasi.
            </p>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">
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
            <h4 class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:600; color:#fff;">PRODUK PILIHAN</h4>
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">Poster Besar</h3>
            <h3 class="mb-4" style="margin-top:-5px !important;">
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">Untuk</span>
              <span class="mt-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#ffc74c;"> Event Spesial!</span>
            </h3>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">
              Poster berkualitas tinggi untuk acara pentingmu.
            </p>
            <p class="mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">
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
    <button class="carousel-control-prev btn-vert" type="button" data-bs-target="#produkPilihanCarousel" data-bs-slide="prev">
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
    <button class="carousel-control-next btn-vert" type="button" data-bs-target="#produkPilihanCarousel" data-bs-slide="next">
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
          <h4 class="step-title" style="font-family: 'Poppins'; font-size:2.8rem; font-weight:600; color:#000;">Dari Semarang ke</h4>
          <h4 class="step-title" style="font-family: 'Poppins'; font-size:2.8rem; font-weight:600; color:#0258d3; margin-top: -20px">Seluruh Indonesia</h4>
          <p class="step-desc" style="font-size:0.8rem;">
              Sejak 2024, Sinau Print selalu berkomitmen untuk menjadi penyedia jasa
              printing terbaik di Semarang. Dengan berbekal pengalaman dan teknologi
              mesin paling mutakhir, kami siap cetak segala kebutuhanmu.
          </p>
          <a href="{{ url('/products') }}" class="btn-about-sinau">
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
            <h3 class="mb-5" style="font-family: 'Poppins'; font-size:3rem; font-weight:550; color:#fff;">
                Kata Mereka <span style="color:#ffc74c;">Tentang Sinau Print</span>
            </h3>

            {{-- Testimonial Container --}}
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

<div class="container-xl py-5">
    <div class="row align-items-center mb-2">
        <div class="col-md-6">
            <div class="step-content">
                <h3 style="margin-top:-5px !important; font-family: 'Poppins'; font-size:2.5rem; font-weight:600;"><span class="mt-0"
                            style="color:#000;">Ikuti Artikel</span><span class="mt-0" style="color:#0258d3;"> Terbaru</span></h3>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('landingpage.article_index') }}" class="btn-semua-artikel">
                <span class="btn-text">SEMUA ARTIKEL</span>
                <span class="btn-arrow">
                    <i class="bi bi-arrow-right-short arrow-out"></i>
                    <i class="bi bi-arrow-right-short arrow-in"></i>
                </span>
            </a>
        </div>
    </div>
    
    <div class="row g-4">
        @if($latestBlogs->count() > 0)
            @foreach($latestBlogs as $blog)
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
            @endforeach
        @else
            <div class="col-12 text-center py-4">
                <p style="font-family: 'Poppins'; color: #666;">Belum ada artikel yang tersedia.</p>
            </div>
        @endif
    </div>
</div>

{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:2.6rem !important; font-weight:550; color:#fff;">Mau Cetak Keperluan Kantor?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:2.6rem !important; font-weight:550; color:#ffc74c; margin-top:-4px;">Boleh Tanya Dulu!</h3>
            <a href="https://wa.me/6281952764747?text=Halo%20Admin%20Sinau%20Print%21%20Saya%20ingin%20mengajukan%20pertanyaan%20terkait%20produk%20yang%20ada%20di%20sinau%20print" target="_blank" class="btn-schedule">
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
    
    .quote-mark {
        font-size: 3rem;
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const testimonialCount = {{ $testimonials->count() > 0 ? $testimonials->count() : 5 }};
    const baseSpeed = 3;
    const totalDuration = testimonialCount * baseSpeed;
    
    document.documentElement.style.setProperty('--scroll-duration', `${totalDuration}s`);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function restructureCarouselForMobile() {
        if (window.innerWidth <= 768) {
            restructureCarousel('#labelsCarousel', '#labelsIndicators');
            
            restructureCarousel('#rollBannerCarousel', '#rollBannerIndicators');
            
            restructureCarousel('#promoCarousel', '#promoIndicators');
        }
    }
    
    function restructureCarousel(carouselSelector, indicatorsSelector) {
        const carousel = document.querySelector(carouselSelector);
        if (!carousel) return;
        
        const carouselInner = carousel.querySelector('.carousel-inner');
        const indicatorsContainer = document.querySelector(indicatorsSelector);
        
        if (!carouselInner) return;
        
        const allItems = [];
        const slides = carouselInner.querySelectorAll('.carousel-item');
        
        slides.forEach(slide => {
            const items = slide.querySelectorAll('.col-lg-3, .col-md-6');
            items.forEach(item => {
                const clonedItem = item.cloneNode(true);
                clonedItem.className = 'col-12';
                allItems.push(clonedItem);
            });
        });
        
        carouselInner.innerHTML = '';
        
        allItems.forEach((item, index) => {
            const newSlide = document.createElement('div');
            newSlide.className = `carousel-item ${index === 0 ? 'active' : ''}`;
            newSlide.innerHTML = `<div class="row g-4"></div>`;
            newSlide.querySelector('.row').appendChild(item);
            carouselInner.appendChild(newSlide);
        });
        
        if (indicatorsContainer) {
            indicatorsContainer.innerHTML = '';
            allItems.forEach((_, index) => {
                const indicator = document.createElement('div');
                indicator.className = `indicator-line ${index === 0 ? 'active' : ''}`;
                indicator.setAttribute('data-bs-target', carouselSelector);
                indicator.setAttribute('data-bs-slide-to', index.toString());
                indicatorsContainer.appendChild(indicator);
            });
        }
        
        const bsCarousel = new bootstrap.Carousel(carousel);
        
        updateCustomIndicators(carouselSelector, indicatorsSelector.replace('#', ''));
    }
    
    restructureCarouselForMobile();
    
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            location.reload();
        }, 250);
    });
});
</script>
@endsection