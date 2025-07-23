@extends('landingpage.index')
@section('content')
<style>
  .thumb-container {
    max-width: 100%;
    padding-left: 16px;
  }
  .thumb-img {
    border: 2px solid transparent;
    transition: border-color .2s;
    margin-left: 8px;
  }
  .thumb-img.active {
    border-color: #0d6efd;
  }
  .thumb-img:first-child {
    margin-left: 88px;
  }
  .sticky-left {
    position: sticky;
    top: 96px;
    z-index: 10;
  }
  .is-invalid {
    border-color: #fc2865 !important;
  }
  .invalid-feedback {
    display: block;
    color: #fc2865;
    font-size: 0.75rem;
    font-weight: 400;
    font-family: 'Poppins', sans-serif;
  }
  .required-asterisk {
    color: #fc2865;
    margin-left: 2px;
  }
  .field-error-message {
    color: #fc2865;
    font-size: 0.7rem;
    font-weight: 400;
    font-family: 'Poppins', sans-serif;
    margin-top: 4px;
    display: none;
  }
  .custom-file-input-fix {
    height: 40px;
    padding: 8px 16px;
    font-size: 0.8rem;
    border-radius: 12px;
    background-color: #f9f9f9;
    border: 1px solid #ced4da;
    color: #495057;
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
  }
  .custom-file-input-fix::file-selector-button {
    padding: 6px 12px;
    margin-right: 10px;
    border: none;
    border-radius: 6px;
    background-color: #0439a0;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    margin-top: 0;
    margin-bottom: 0;
    vertical-align: middle;
  }
  .custom-file-input-fix::file-selector-button:hover {
    background-color: #062f87;
  }
  .form-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    font-weight: 500;
    color: #000000;
    margin-bottom: 0.4rem;
  }
  
  .cta-overlay h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 2.8rem;
    font-weight: 550;
    color: #fff;
    margin-bottom: 0.8rem;
  }
  .breadcrumb {
    font-family: 'Poppins', sans-serif;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
  }
  .breadcrumb a {
    color: #fff;
    text-decoration: none;
  }
  .breadcrumb-item.active {
    color: #ffc74c;
  }
  
  .price-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    font-weight: 500;
    color: #888;
  }
  .price-main {
    font-family: 'Poppins', sans-serif;
    font-size: 1.6rem;
    font-weight: 600;
  }
  .price-discount {
    font-family: 'Poppins', sans-serif;
    color: #c3c3c3;
    font-size: 0.9rem;
  }
  
  .form-select, .form-control {
    height: 40px;
    border-radius: 50px;
    font-size: 0.8rem;
    padding: 0 24px;
    font-family: 'Poppins', sans-serif;
  }
  .input-group-text {
    border-radius: 0 50px 50px 0;
    font-size: 0.8rem;
    padding: 0 0.8rem;
    font-family: 'Poppins', sans-serif;
  }
  .form-control[type="number"] {
    padding: 0 48px;
  }
  .textarea-custom {
    font-family: 'Poppins', sans-serif;
    height: 80px;
    border-radius: 8px;
    font-size: 0.8rem;
    padding: 12px 16px;
    resize: vertical;
  }
  
  .btn-order {
    border-radius: 40px;
    width: 248px;
    height: 40px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    background-color: #0258d3;
    color: #fff;
  }
  .btn-order:hover {
    background-color: #5ee3e3;
    color: #fff;
  }
  
  .total-container {
    border: 1px solid #ccc;
    border-radius: 12px;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .total-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    color: #888;
    font-weight: 500;
  }
  .total-price {
    font-family: 'Poppins', sans-serif;
    font-size: 1.8rem;
    font-weight: 600;
    color: #0439a0;
  }
  
  .product-info-header {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    border-color: #ccc !important;
  }
  .info-icon {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #444444;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    font-size: 0.7rem;
    font-weight: 600;
  }
  .info-subtitle {
    margin-top: 16px;
    margin-bottom: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: #444444;
    font-weight: 540;
  }
  .info-content {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    color: #888;
    font-weight: 500;
    line-height: 1.4;
  }
  
  .carousel-container {
    max-height: 360px;
  }
  .thumbnail-img {
    width: 80px;
    height: 48px;
    object-fit: contain;
    border-radius: 6px;
    cursor: pointer;
  }
  
  .other-products-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.8rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 1.2rem;
  }
  .product-card-height {
    height: 200px;
    width: 240px;
  }
  .product-card-content {
    min-height: 112px;
    padding: 0.8rem;
  }
  .product-card-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 0;
  }
  .product-card-size {
    font-family: 'Poppins', sans-serif;
    font-size: 0.7rem;
    font-weight: 400;
    color: #fff;
    margin-bottom: 1rem;
  }
  .product-card-price-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: #fff;
    font-family: 'Poppins', sans-serif;
  }
  .product-card-price {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1rem;
    font-weight: 500;
    color: #fc2865;
  }
  .product-card-price-normal {
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    color: #fff;
  }
@media (max-width: 768px) {
  .container-fluid.px-4 {
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
  
  .container.product-card {
    margin-top: -120px !important;
    padding: 0 16px !important;
  }
  
  .cta-overlay {
    left: -10% !important;
    /* padding: 0 16px; */
    top: 50% !important;
  }
  
  .cta-overlay h3 {
    font-size: 1.6rem !important;
    line-height: 1.3;
    margin-bottom: 0.6rem !important;
    display: block !important;
    visibility: visible !important;
  }
  
  .row.g-5 {
    gap: 2rem !important;
    --bs-gutter-x: 1rem !important;
    --bs-gutter-y: 2rem !important;
  }
  
  .col-lg-7 {
    order: 1;
  }
  
  .sticky-left {
    position: static !important;
    top: auto !important;
  }
  
  .carousel-container {
    max-height: 240px !important;
    margin-bottom: 12px;
  }
  
  .thumb-container {
    padding-left: 8px !important;
    justify-content: center !important;
  }
  
  .thumbnail-img {
    width: 56px !important;
    height: 36px !important;
  }
  
  .thumb-img {
    margin-left: 4px !important;
  }
  
  .thumb-img:first-child {
    margin-left: 0 !important;
  }
  
  .col-lg-5 {
    order: 2;
    padding: 0 !important;
  }
  
  .price-main {
    font-size: 1.2rem !important;
  }
  
  .price-discount {
    font-size: 0.8rem !important;
  }
  .form-select, .form-control {
    height: 44px !important;
    font-size: 0.85rem !important;
    padding: 0 16px !important;
    border-radius: 8px !important;
  }
  
  .form-label {
    font-size: 0.8rem !important;
    margin-bottom: 0.5rem !important;
  }
  
  .input-group-text {
    border-radius: 0 8px 8px 0 !important;
    font-size: 0.8rem !important;
    padding: 0 12px !important;
  }
  
  .form-control[type="number"] {
    padding: 0 16px !important;
    border-radius: 8px 0 0 8px !important;
  }
  
  .custom-file-input-fix {
    height: 44px !important;
    padding: 8px 12px !important;
    font-size: 0.8rem !important;
    border-radius: 8px !important;
  }
  
  .custom-file-input-fix::file-selector-button {
    padding: 8px 12px !important;
    font-size: 0.75rem !important;
    margin-right: 8px !important;
  }
  
  .textarea-custom {
    height: 60px !important;
    padding: 10px 12px !important;
    font-size: 0.8rem !important;
  }
  
  .row.g-2 {
    gap: 0.75rem !important;
  }
  
  .row.g-2 .col {
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }
  
  .row.mb-3:last-of-type .col-auto:first-child,
  .row.mb-3:last-of-type .col-12:first-child {
    flex: 0 0 100% !important;
    max-width: 100% !important;
    margin-bottom: 1rem;
  }
  
  .row.mb-3:last-of-type .col-auto:last-child,
  .row.mb-3:last-of-type .col-12:last-child {
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }
  
  #qty {
    width: 100% !important;
    padding: 0 16px !important;
  }
  
  .btn-order {
    width: 100% !important;
    height: 48px !important;
    font-size: 0.9rem !important;
    border-radius: 8px !important;
  }
  
  .total-container {
    padding: 16px !important;
    border-radius: 8px !important;
    flex-direction: column !important;
    text-align: center !important;
    gap: 8px;
  }
  
  .total-label {
    font-size: 0.85rem !important;
  }
  
  .total-price {
    font-size: 1.6rem !important;
  }
  
  .product-info-header {
    font-size: 0.85rem !important;
    padding: 12px 0 !important;
  }
  
  .info-icon {
    width: 14px !important;
    height: 14px !important;
    font-size: 0.65rem !important;
    margin-right: 6px !important;
  }
  
  .info-subtitle {
    font-size: 0.8rem !important;
    margin-top: 12px !important;
    margin-bottom: 6px !important;
  }
  
  .info-content {
    font-size: 0.75rem !important;
    line-height: 1.5 !important;
    padding-right: 0 !important;
  }
  
  .content {
    overflow: visible !important;
  }
  
  .col-6 {
    padding-left: 6px !important;
    padding-right: 6px !important;
  }
  .other-products-section {
    display: none !important;
  }
  .breadcrumb {
    display: none !important;
  }
  
  .field-error-message {
    font-size: 0.7rem !important;
    margin-top: 3px !important;
  }
  
  .invalid-feedback {
    font-size: 0.7rem !important;
  }
  
  .alert {
    font-size: 0.75rem !important;
    padding: 8px 12px !important;
    margin-bottom: 1rem !important;
  }
  
  .form-text {
    font-size: 0.65rem !important;
    line-height: 1.4 !important;
  }
  
  .mb-3 {
    margin-bottom: 1rem !important;
  }
  
  .mt-4 {
    margin-top: 1.5rem !important;
  }
  
  .mt-5 {
    margin-top: 2rem !important;
  }
  
  .pt-5 {
    padding-top: 2rem !important;
  }
  
  .container-fluid.footer.mt-5.pt-5 {
    margin-top: 3rem !important;
    padding-top: 2rem !important;
  }
  
  .row.g-4 {
    gap: 1rem !important;
  }
.container-fluid.footer.mt-5.pt-5 .position-relative img {
  height: 200px !important;
  object-fit: cover !important;
}

.container-fluid.footer .position-absolute.cta-overlay {
  top: 30% !important;
  transform: translateY(-50%) !important;
}
}

@media (max-width: 480px) {
  .container.product-card {
    margin-top: -100px !important;
  }
  
  .cta-overlay h3 {
    font-size: 1.4rem !important;
  }
  
  .carousel-container {
    max-height: 200px !important;
  }
  
  .thumbnail-img {
    width: 48px !important;
    height: 32px !important;
  }
  
  .price-main {
    font-size: 1.1rem !important;
  }
  
  .total-price {
    font-size: 1.4rem !important;
  }
  
  .other-products-title {
    font-size: 1.1rem !important;
  }
  
  .product-card-height {
    height: 80px !important;
  }
  
  .product-card-content {
    min-height: 50px !important;
    padding: 0.3rem !important;
  }
  
  .product-card-title {
    font-size: 0.65rem !important;
    line-height: 1.0 !important;
  }
  
  .product-card-size {
    font-size: 0.5rem !important;
    margin-bottom: 0.2rem !important;
  }
  
  .product-card-price {
    font-size: 0.7rem !important;
  }
  
  .product-card-price-normal {
    font-size: 0.7rem !important;
  }
}
</style>

<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay d-none d-md-block" style="left: 5%;">
      <h3 class="mb-2">
        {{ $product->label->name }} - {{ $product->name }}
        @if($product->additional_size && $product->additional_unit)
          {{ $product->additional_size }} {{ $product->additional_unit }}
        @endif
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('landingpage.products') }}">Semua Produk</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ $product->name }}
          </li>
        </ol>
      </nav>
    </div>
    <div class="position-absolute start-0 translate-middle-y cta-overlay d-block d-md-none" style="left: 3%; top: 20%;">
      <h3 class="mb-2">
        {{ $product->label->name }} - {{ $product->name }}
        @if($product->additional_size && $product->additional_unit)
          {{ $product->additional_size }} {{ $product->additional_unit }}
        @endif
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('landingpage.products') }}">Semua Produk</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ $product->name }}
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<main>
  <div class="container-fluid px-4">
    <div class="container product-card mobile-spacing" style="margin-top:-150px;">
      @php
        $base = $product->price;
        $final = $product->getDiscountedPrice(); // Gunakan method dari model
        $bestDiscount = $product->getBestDiscount();
      @endphp
      <div class="row g-5 g-md-5 g-2">
        <!-- Carousel and thumbnails -->
        @php $thumbs = $product->images->take(4); @endphp
        <div class="col-lg-7">
          <!-- Sticky wrapper -->
          <div class="sticky-left">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner carousel-container">
                @if($thumbs->isEmpty())
                  @for($i = 0; $i < 4; $i++)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                      <img src="{{ asset('landingpage/img/nophoto.png') }}"
                          class="d-block w-100"
                          style="max-height:360px; object-fit:contain;"
                          alt="">
                    </div>
                  @endfor
                @else
                  @foreach($thumbs as $i => $img)
                    @php
                      $imgPath = storage_path('app/public/' . $img->image_product);
                      $src = file_exists($imgPath)
                        ? asset('storage/' . $img->image_product)
                        : asset('landingpage/img/nophoto.png');
                    @endphp
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                      <img src="{{ $src }}"
                          class="d-block w-100"
                          style="max-height:360px; object-fit:contain;"
                          alt="">
                    </div>
                  @endforeach

                  @for($j = $thumbs->count(); $j < 4; $j++)
                    <div class="carousel-item">
                      <img src="{{ asset('landingpage/img/nophoto.png') }}"
                          class="d-block w-100"
                          style="max-height:360px; object-fit:contain;"
                          alt="">
                    </div>
                  @endfor
                @endif
              </div>

              <button class="carousel-control-prev" type="button"
                      data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button"
                      data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>

            {{-- Container thumbnail --}}
            <div class="d-flex mt-3 thumb-container"
                style="justify-content: start; padding-left: 12px;">
              @if($thumbs->isEmpty())
                @for($i = 0; $i < 4; $i++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="thumb-img me-2 thumbnail-img {{ $i === 0 ? 'active' : '' }}">
                @endfor
              @else
                @foreach($thumbs as $i => $img)
                  @php
                    $imgPath = storage_path('app/public/' . $img->image_product);
                    $src = file_exists($imgPath)
                      ? asset('storage/' . $img->image_product)
                      : asset('landingpage/img/nophoto.png');
                  @endphp
                  <img src="{{ $src }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="thumb-img me-2 thumbnail-img {{ $i === 0 ? 'active' : '' }}">
                @endforeach

                @for($j = $thumbs->count(); $j < 4; $j++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $j }}"
                      class="thumb-img me-2 thumbnail-img">
                @endfor
              @endif
            </div>
          </div>
        </div>
        <!-- Form and details -->
        <div class="col-lg-5">
          <p class="price-label">*Mulai dari</p>
          @if($finalBase < $product->price)
              <h4 class="price-main" style="color:#fc2865;">
                  Rp {{ number_format($finalBase, 0, ',', '.') }}
              </h4>
              <p class="price-discount">
                  <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del>
              </p>
          @else
              <h4 class="price-main">
                  Rp {{ number_format($product->price, 0, ',', '.') }}
              </h4>
          @endif
          @php
            $base  = $product->price;
            $final = $base;
            $disc = $product->discounts->first();

            if ($disc) {
                if ($disc->discount_percent) {
                $amount = $base * ($disc->discount_percent / 100);
                } else {
                $amount = $disc->discount_fix;
                }
                $final = max(0, $base - $amount);
            }

            $user = auth()->user();

            $currentFinishingId = optional(
              $product->label->finishings
                      ->firstWhere('finishing_name', optional($orderProduct)->finishing_type)
            )->id;

            $isEdit = isset($orderProduct);
            $order = optional($orderProduct)->order;
          @endphp
          <form id="orderForm" method="POST" action="{{ $isEdit ? route('order-product.update', $orderProduct) : route('orders.store') }}" enctype="multipart/form-data">
            @csrf

            @if($isEdit)
              @method('PUT')
            @endif

            {{-- Global alert error --}}
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $msg)
                    <li style="font-family: 'Poppins', sans-serif; font-size: 0.8rem;">{{ $msg }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <input type="hidden" id="basePrice" value="{{ $product->price }}">
            <input type="hidden" id="discountedPrice" value="{{ $final }}">
            <input type="hidden" id="unit" value="{{ $product->additional_unit }}">
            <input type="hidden" name="order_status" value="0">

            @if($bestDiscount)
                @if($bestDiscount->discount_percent)
                    <input type="hidden" id="discountPercent" value="{{ $bestDiscount->discount_percent }}">
                    <input type="hidden" id="discountType" value="percent">
                @else
                    <input type="hidden" id="discountAmount" value="{{ $bestDiscount->discount_fix }}">
                    <input type="hidden" id="discountType" value="fix">
                @endif
            @else
                <input type="hidden" id="discountType" value="none">
            @endif

            @if($bestDiscount)
                @if($bestDiscount->discount_percent)
                    <input type="hidden" name="diskon_persen" value="{{ $bestDiscount->discount_percent }}">
                @else
                    <input type="hidden" name="potongan_rp" value="{{ $bestDiscount->discount_fix }}">
                @endif
            @endif

            {{-- BAHAN --}}
            <div class="mb-3">
              <label class="form-label"><b>BAHAN</b><span class="required-asterisk">*</span></label>
              <select 
                name="product_id" 
                id="product_id"
                class="form-select @error('product_id') is-invalid @enderror"
                required
              >
                <option value="{{ $product->id }}" {{ old('product_id', $product->id)==$product->id?'selected':'' }}>
                  {{ $product->name }}
                  @if($product->additional_size && $product->additional_unit)
                    {{ $product->additional_size }} {{ $product->additional_unit }}
                  @endif
                </option>
              </select>
              @error('product_id')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
              @enderror
              <div class="field-error-message" id="product_id_error">Pilih bahan produk</div>
            </div>

            {{-- FINISHING --}}
            @if($product->label->finishings->isNotEmpty())
              <div class="mb-3">
                <label class="form-label"><b>FINISHING</b></label>
                <select 
                  name="finishing_id" 
                  id="finishingSelect"
                  class="form-select @error('finishing_id') is-invalid @enderror"
                >
                  <option value="" data-price="0">Pilih Finishing</option>
                  @foreach($product->label->finishings as $fin)
                    <option 
                      value="{{ $fin->id }}" 
                      data-price="{{ $fin->finishing_price }}"
                      {{ old('finishing_id', $currentFinishingId) == $fin->id ? 'selected':'' }} data-price="{{ $fin->finishing_price }}">
                      {{ $fin->finishing_name }} (Rp {{ number_format($fin->finishing_price,0,',','.') }})
                    </option>
                  @endforeach
                </select>
                @error('finishing_id')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
            @endif

            {{-- EXPRESS & DEADLINE --}}
            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>KEBUTUHAN EXPRESS</b></label>
                <select 
                  id="needExpress" 
                  name="express" 
                  class="form-select @error('express') is-invalid @enderror">
                  <option value="0" {{ old('express', optional($order)->express ?? '0') == '0' ? 'selected' : '' }}>Tidak</option>
                  <option value="1" {{ old('express', optional($order)->express ?? '0') == '1' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('express')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>DEADLINE JAM</b><span class="required-asterisk" id="deadline_asterisk" style="display: none;">*</span></label>
                <input
                  type="time"
                  id="deadlineTime"
                  name="waktu_deadline"
                  class="form-control @error('waktu_deadline') is-invalid @enderror"
                  {{ old('express', optional($order)->express ?? '0') == '1' ? '' : 'disabled' }}
                  value="{{ old('waktu_deadline', optional($order)->waktu_deadline ? substr($order->waktu_deadline,0,5) : '') }}">
                @error('waktu_deadline')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="deadline_error">Deadline jam wajib diisi jika memilih express</div>
              </div>
            </div>

            {{-- PROOFING --}}
            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>KEBUTUHAN PROOFING</b></label>
                <select 
                  id="needProofing" 
                  name="kebutuhan_proofing" 
                  class="form-select @error('kebutuhan_proofing') is-invalid @enderror">
                  <option value="0" {{ old('kebutuhan_proofing', optional($order)->kebutuhan_proofing ?? '0') == '0' ? 'selected' : '' }}>Tidak</option>
                  <option value="1" {{ old('kebutuhan_proofing', optional($order)->kebutuhan_proofing ?? '0') == '1' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('kebutuhan_proofing')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>QTY PROOFING</b><span class="required-asterisk" id="proof_asterisk" style="display: none;">*</span></label>
                <input
                  type="number"
                  id="proofQty"
                  name="proof_qty"
                  class="form-control @error('proof_qty') is-invalid @enderror"
                  value="{{ old('proof_qty', optional($order)->proof_qty ?? '') }}"
                  {{ old('kebutuhan_proofing', optional($order)->kebutuhan_proofing ?? '0') == '1' ? '' : 'disabled' }}>
                @error('proof_qty')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="proof_qty_error">Qty proofing wajib diisi jika memilih proofing</div>
              </div>
            </div>

            {{-- UPLOAD DESAIN --}}
            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>DESAIN CETAK</b><span class="required-asterisk">*</span></label>
                <input 
                  type="file" 
                  name="order_design" 
                  accept=".jpeg,.jpg,.png,.pdf,.svg,.cdr,.psd,.ai,.tiff,.rar,.zip" 
                  class="form-control @error('order_design') is-invalid @enderror custom-file-input-fix"
                  id="order_design"
                  required
                >
                @error('order_design')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="order_design_error">File desain cetak wajib diupload</div>
              </div>
              <div class="col">
                <label class="form-label"><b>DESAIN PREVIEW</b></label>
                <input 
                  type="file" 
                  name="preview_design" 
                  accept=".jpeg,.jpg,.png,.pdf" 
                  class="form-control @error('preview_design') is-invalid @enderror custom-file-input-fix"
                  id="preview_design"
                >
                @error('preview_design')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <small class="form-text text-muted mt-2" style="font-family: 'Poppins', sans-serif; font-size: 0.7rem;">
                Format yang diterima: .jpeg, .jpg, .png, .pdf, .svg, .cdr, .psd, .ai, .tiff.<br>
                Untuk multiple file desain, unggah dalam arsip .rar atau .zip.
              </small>
            </div>

            {{-- DIMENSI (jika ada) --}}
            @if($product->width_product && $product->long_product)
              <div class="row g-2 mb-3">
                <div class="col">
                  <label class="form-label"><b>PANJANG (cm)</b><span class="required-asterisk">*</span></label>
                  <div class="input-group flex-nowrap">
                    <input
                      type="number"
                      name="length"
                      id="panjang"
                      class="form-control @error('length') is-invalid @enderror"
                      placeholder="Panjang"
                      value="{{ old('length', intval($product->long_product)) }}"
                      style="height:40px; border-radius:50px 0 0 50px; font-size:0.8rem; padding:0 1.6rem;"
                      @if ($product->type != 'khusus')
                      readonly
                      @endif
                      required
                    >
                    <span class="input-group-text">
                      {{-- {{ $product->additional_unit }} --}}
                      cm
                    </span>
                  </div>
                  @error('length')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="field-error-message" id="length_error">Panjang wajib diisi</div>
                </div>
                <div class="col">
                  <label class="form-label"><b>LEBAR (cm)</b><span class="required-asterisk">*</span></label>
                  <div class="input-group flex-nowrap">
                    <input
                      type="number"
                      name="width"
                      id="lebar"
                      class="form-control @error('width') is-invalid @enderror"
                      placeholder="Lebar"
                      value="{{ old('width', intval($product->width_product) ) }}"
                      style="height:40px; border-radius:50px 0 0 50px; font-size:0.8rem; padding:0 1.6rem;"
                      @if ($product->type != 'khusus')
                      readonly
                      @endif
                      required
                    >
                    <span class="input-group-text">
                      {{-- {{ $product->additional_unit }} --}}
                      cm
                    </span>
                  </div>
                  @error('width')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="field-error-message" id="width_error">Lebar wajib diisi</div>
                </div>
              </div>
            @endif

            {{-- CATATAN --}}
            <div class="mb-3">
              <label class="form-label"><b>CATATAN</b></label>
              <textarea
                name="notes"
                class="form-control textarea-custom @error('notes') is-invalid @enderror"
                placeholder="Masukkan catatan tambahan jika ada">{{ old('notes', optional($order)->notes ?? '') }}</textarea>
              @error('notes')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
              @enderror
            </div>

            {{-- QTY & SUBMIT --}}
            <div class="row mb-3">
              <div class="col-12 col-md-auto mb-2 mb-md-0">
                <label class="form-label"><b>QTY</b><span class="required-asterisk">*</span></label>
                <input
                  type="number"
                  name="qty"
                  id="qty"
                  value="{{ old('qty', optional($orderProduct)->qty ?? 1) }}"
                  class="form-control @error('qty') is-invalid @enderror"
                  placeholder="1"
                  style="width:120px; height:40px; border-radius:50px; font-size:0.8rem; padding:0 48px;"
                  required
                  min="1"
                >
                @error('qty')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="qty_error">Qty minimal 1</div>
              </div>
              <div class="col-12 col-md-auto d-flex align-items-end">
                <button type="submit" class="btn btn-order">
                  {{ $isEdit ? 'UBAH ORDER' : 'BELI PRODUK' }}
                </button>
              </div>
            </div>

            {{-- TOTAL HARGA --}}
            <div class="total-container">
              <div class="total-label">Total Harga</div>
              <div class="total-price">Rp <span id="totalHarga">0</span></div>
            </div>
          </form>

          <!-- Informasi Produk custom -->
          <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between w-100 border-0 bg-transparent pb-2 mb-2 border-bottom product-info-header" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
              <div class="d-flex align-items-center">
                <div class="info-icon">i</div>
                INFORMASI PRODUK
              </div>
              <div id="iconChevron" style="transition: transform 0.3s;"><i class="bi bi-chevron-right"></i></div>
            </div>
            <div class="collapse show" id="collapseInfo">
              <div class="info-subtitle">
                Lama Pengerjaan
              </div>
              <div class="info-content">
                {!! nl2br(e(str_replace(';', "\n", 
                  $product->production_time ?: 'Order 1 - 50 pcs : 1 Hari; Order > 50 pcs : 2 Hari'
                ))) !!}
                <p>Catatan : <br>
                  * File Sudah Ready to Print <br>
                  * Lama Pengerjaan tidak termasuk lama delivery <br>
                  * Tidak Berlaku untuk Hari Libur/Tanggal Merah <br>
                  * Order Urgent / Jumlah Besar Deadline Konfirmasi CS <br>
                </p>
              </div>
              <div class="info-subtitle">
                Keterangan Produk
              </div>
              <div class="info-content" style="padding-right: 16px;">
                {{ $product->description }}
              </div>
              <div class="info-subtitle">
                Spesifikasi
              </div>
              <div class="info-content">
                {!! nl2br(e(str_replace(';', "\n", $product->spesification_desc))) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Produk Lainnya -->
  <div class="container-fluid footer mt-5 pt-5 wow fadeIn other-products-section" data-wow-delay="0.1s">
    <div class="position-relative">
      <img
        class="w-100 rounded" style="max-height:480px"
        src="{{ asset('landingpage/img/login_register_bg.png') }}"
        alt="Background"/>

      <div class="position-absolute top-50 start-50 translate-middle w-100 px-3">
        <div class="container">
          <h3 class="other-products-title">
            Produk Lainnya
          </h3>
          <div class="row g-4">
            @foreach($bestProducts as $prod)
              <div class="col-lg-3 col-md-6 col-6">
                <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                  <div class="product-item shadow-sm h-100" style="border-radius:8px; background: transparent;">
                    <div class="position-relative bg-light overflow-hidden product-card-height" style="border-radius:8px;">
                      @php
                        $image = $prod->images->first();
                        $imageSrc = asset('landingpage/img/nophoto.png');

                        if($image && $image->image_product) {
                          $imagePath = storage_path('app/public/' . $image->image_product);
                          if(file_exists($imagePath)) {
                            $imageSrc = asset('storage/' . $image->image_product);
                          }
                        }
                      @endphp
                      <img src="{{ $imageSrc }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                    </div>
                    <div class="content product-card-content d-flex flex-column">
                      <div class="product-card-title">
                        {{ $prod->name }}
                        @if($prod->additional_size && $prod->additional_unit)
                          {{ $prod->additional_size }} {{ $prod->additional_unit }}
                        @endif
                      </div>
                      <div class="product-card-size">
                        @if($prod->long_product && $prod->width_product)
                          Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}
                        @else
                          {{ $prod->additional_size }} {{ $prod->additional_unit }}
                        @endif
                      </div>
                      @php
                          $base = $prod->price; 
                          $final = $prod->getDiscountedPrice();
                          $prodBestDiscount = $prod->getBestDiscount();
                      @endphp

                      @if($final < $base)
                          <div class="product-card-price-label mb-0 mt-1">MULAI DARI</div>
                          <div class="price-container d-flex align-items-center" style="gap:6px;">
                              <span class="discount-price text-decoration-line-through text-white" style="font-size: 0.7rem;">
                                  {{ $prod->getFormattedPrice() }}
                              </span>
                              <img 
                                  src="{{ asset('landingpage/img/discount_logo.png') }}" 
                                  alt="Diskon" 
                                  class="discount-logo" 
                                  style="width:14px; height:auto;"
                              >
                              <span class="product-card-price">
                                  {{ $prod->getFormattedDiscountedPrice() }}
                              </span>
                          </div>
                      @else
                          <div class="product-card-price-label mb-0 mt-1">Mulai Dari</div>
                          <div class="price-container mt-0">
                              <span class="product-card-price-normal">{{ $prod->getFormattedPrice() }}</span>
                          </div>
                      @endif
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @php
        $productSizes = $product->toArray();
    @endphp

<script>
  document.getElementById('add-to-cart')?.addEventListener('submit', function(e) {
    e.preventDefault();
    @if(Auth::check())
      swal({
        title: "Berhasil!",
        text: "Produk telah ditambahkan ke keranjang.",
        icon: "success",
      }).then(() => this.submit());
    @else
      swal({
        title: "Gagal!",
        text: "Anda harus login terlebih dahulu.",
        icon: "error",
      }).then(() => location.href = "{{ route('login') }}");
    @endif
  });

  document.querySelectorAll('.thumb img').forEach(img => img.addEventListener('click', function(){
    document.querySelectorAll('.thumb img').forEach(i=>i.classList.remove('active'));
    this.classList.add('active');
  }));

  const collapseEl   = document.getElementById('collapseInfo');
  const iconChevron  = document.getElementById('iconChevron');

  if (collapseEl.classList.contains('show')) {
    iconChevron.style.transform = 'rotate(90deg)';
  } else {
    iconChevron.style.transform = 'rotate(0deg)';
  }

  collapseEl.addEventListener('show.bs.collapse', function () {
    document.getElementById('iconChevron').style.transform = 'rotate(90deg)';
  });
  collapseEl.addEventListener('hide.bs.collapse', function () {
    document.getElementById('iconChevron').style.transform = 'rotate(0deg)';
  });
</script>
<script>
  const carousel = document.getElementById('productCarousel');
  const thumbs = document.querySelectorAll('.thumb-img');

  thumbs.forEach((img, idx) => {
    img.addEventListener('click', () => {
      thumbs.forEach(i => i.classList.remove('active'));
      img.classList.add('active');
    });
  });

  carousel.addEventListener('slid.bs.carousel', function(e) {
    const currentIndex = Array.from(
      e.currentTarget.querySelectorAll('.carousel-item')
    ).indexOf(e.relatedTarget);

    thumbs.forEach((img, idx) => {
      img.classList.toggle('active', idx === currentIndex);
    });
  });
  
  document.getElementById('needExpress').addEventListener('change', function() {
    const deadlineInput = document.getElementById('deadlineTime');
    const asterisk = document.getElementById('deadline_asterisk');
    const errorMsg = document.getElementById('deadline_error');
    
    if(this.value === '1') {
      deadlineInput.disabled = false;
      deadlineInput.required = true;
      asterisk.style.display = 'inline';
    } else {
      deadlineInput.disabled = true;
      deadlineInput.required = false;
      deadlineInput.value = '';
      asterisk.style.display = 'none';
      errorMsg.style.display = 'none';
    }
  });

  document.getElementById('needProofing').addEventListener('change', function() {
    const proofInput = document.getElementById('proofQty');
    const asterisk = document.getElementById('proof_asterisk');
    const errorMsg = document.getElementById('proof_qty_error');
    
    if(this.value === '1') {
      proofInput.disabled = false;
      proofInput.required = true;
      asterisk.style.display = 'inline';
    } else {
      proofInput.disabled = true;
      proofInput.required = false;
      proofInput.value = '';
      asterisk.style.display = 'none';
      errorMsg.style.display = 'none';
    }
  });

  // Form validation
  document.getElementById('orderForm').addEventListener('submit', function(e) {
    let hasError = false;
    
    // Reset all error messages
    document.querySelectorAll('.field-error-message').forEach(msg => {
      msg.style.display = 'none';
    });
    
    // Check required fields
    const productId = document.getElementById('product_id');
    if(!productId.value) {
      document.getElementById('product_id_error').style.display = 'block';
      hasError = true;
    }
    
    const deadlineTime = document.getElementById('deadlineTime');
    const needExpress = document.getElementById('needExpress');
    if(needExpress.value === '1' && !deadlineTime.value) {
      document.getElementById('deadline_error').style.display = 'block';
      hasError = true;
    }
    
    const proofQty = document.getElementById('proofQty');
    const needProofing = document.getElementById('needProofing');
    if(needProofing.value === '1' && (!proofQty.value || proofQty.value < 1)) {
      document.getElementById('proof_qty_error').style.display = 'block';
      hasError = true;
    }
    
    const orderDesign = document.getElementById('order_design');
    if(!orderDesign.files.length) {
      document.getElementById('order_design_error').style.display = 'block';
      hasError = true;
    }
    
    const panjang = document.getElementById('panjang');
    const lebar = document.getElementById('lebar');
    const unit = document.getElementById('unit').value;
    
    if((panjang || lebar)) {
      if(panjang && (!panjang.value || panjang.value <= 0)) {
        document.getElementById('length_error').style.display = 'block';
        hasError = true;
      }
      if(lebar && (!lebar.value || lebar.value <= 0)) {
        document.getElementById('width_error').style.display = 'block';
        hasError = true;
      }
    }
    
    const qty = document.getElementById('qty');
    if(!qty.value || qty.value < 1) {
      document.getElementById('qty_error').style.display = 'block';
      hasError = true;
    }
    
    if(hasError) {
      e.preventDefault();
    }
  });

  // Real-time validation
  document.getElementById('deadlineTime').addEventListener('blur', function() {
    const needExpress = document.getElementById('needExpress');
    const errorMsg = document.getElementById('deadline_error');
    if(needExpress.value === '1' && !this.value) {
      errorMsg.style.display = 'block';
    } else {
      errorMsg.style.display = 'none';
    }
  });

  document.getElementById('proofQty').addEventListener('blur', function() {
    const needProofing = document.getElementById('needProofing');
    const errorMsg = document.getElementById('proof_qty_error');
    if(needProofing.value === '1' && (!this.value || this.value < 1)) {
      errorMsg.style.display = 'block';
    } else {
      errorMsg.style.display = 'none';
    }
  });

  document.getElementById('order_design').addEventListener('change', function() {
    const errorMsg = document.getElementById('order_design_error');
    if(!this.files.length) {
      errorMsg.style.display = 'block';
    } else {
      errorMsg.style.display = 'none';
    }
  });

  const panjangInput = document.getElementById('panjang');
  const lebarInput = document.getElementById('lebar');
  
  if(panjangInput) {
    panjangInput.addEventListener('blur', function() {
      const errorMsg = document.getElementById('length_error');
      if(!this.value || this.value <= 0) {
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });
  }
  
  if(lebarInput) {
    lebarInput.addEventListener('blur', function() {
      const errorMsg = document.getElementById('width_error');
      if(!this.value || this.value <= 0) {
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });
  }

  document.getElementById('qty').addEventListener('blur', function() {
    const errorMsg = document.getElementById('qty_error');
    if(!this.value || this.value < 1) {
      errorMsg.style.display = 'block';
    } else {
      errorMsg.style.display = 'none';
    }
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
      const originalPrice   = parseFloat(document.getElementById('basePrice').value) || 0;
      const unit            = document.getElementById('unit').value;
      const finishingSelect = document.getElementById('finishingSelect');
      const needExpress     = document.getElementById('needExpress');
      const panjangInput    = document.getElementById('panjang');
      const lebarInput      = document.getElementById('lebar');
      const qtyInput        = document.getElementById('qty');
      const totalEl         = document.getElementById('totalHarga');
      
      // Ambil info diskon
      const discountType = document.getElementById('discountType').value;
      const discountPercent = discountType === 'percent' ? 
          (parseFloat(document.getElementById('discountPercent').value) || 0) : 0;
      const discountAmount = discountType === 'fix' ? 
          (parseFloat(document.getElementById('discountAmount').value) || 0) : 0;

      function applyDiscount(price) {
          if (discountType === 'percent') {
              return price - (price * (discountPercent / 100));
          } else if (discountType === 'fix') {
              return Math.max(0, price - discountAmount);
          }
          return price;
      }

      function computeTotal() {
          // 1) Hitung harga per unit (sudah termasuk diskon)
          let pricePerUnit = applyDiscount(originalPrice);
          
          // 2) Hitung HPL (Harga per Luas) jika ada dimensi
          let hpl = pricePerUnit;

          const productSizes = @json($productSizes);

          const master = productSizes;

          console.log(master)

          const defaultPanjang = master.long_product;
          const defaultLebar = master.width_product;

          if (panjangInput && lebarInput) {
              const l = parseFloat(panjangInput.value) || 0;
              const w = parseFloat(lebarInput.value) || 0;

              
              let finalP = 0;
              let finalL = 0;

              if (l > 0 && w > 0) {
                  finalP = l <= defaultPanjang ? 100 : l;
                  finalL = w <= defaultLebar ? 100 : w;

                  console.log(defaultPanjang)
                  console.log(defaultLebar)

                  const areaInM2 = (finalP / 100) * (finalL / 100)
                  hpl = pricePerUnit * areaInM2;
              }
          }

          // 3) Kalikan dengan qty
          const qty = parseInt(qtyInput.value) || 1;
          const subtotalHpl = hpl * qty;

          // 4) Finishing per item × qty (finishing tidak kena diskon)
          const finishingPrice = finishingSelect
              ? parseFloat(finishingSelect.selectedOptions[0].dataset.price) || 0
              : 0;
          const subtotalFinishing = finishingPrice * qty;

          // 5) Jumlah sebelum express
          let total = subtotalHpl + subtotalFinishing;

          // 6) Tambah 50% kalau express = 1
          if (needExpress.value === '1') {
              total += total * 0.5;
          }

          totalEl.innerText = Math.round(total).toLocaleString();
      }

      // Event listeners
      if (finishingSelect) finishingSelect.addEventListener('change', computeTotal);
      needExpress.addEventListener('change', computeTotal);
      if (panjangInput) panjangInput.addEventListener('input', computeTotal);
      if (lebarInput) lebarInput.addEventListener('input', computeTotal);
      qtyInput.addEventListener('input', computeTotal);

      computeTotal();
      
      // Initialize asterisk visibility
      const needExpressVal = document.getElementById('needExpress').value;
      const needProofingVal = document.getElementById('needProofing').value;
      
      if(needExpressVal === '1') {
          document.getElementById('deadline_asterisk').style.display = 'inline';
      }
      
      if(needProofingVal === '1') {
          document.getElementById('proof_asterisk').style.display = 'inline';
      }
  });
</script>

@endsection