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
  .form-label {
    font-family: 'Poppins';
    font-size:0.64rem;
    font-weight:350 !important;
    color:#000000;
  }
  .order-status {
    padding: 6px 13px;
    border-radius: 16px;
    font-weight: 500;
    font-size: 0.64rem;
    text-align: center;
    display: inline-block;
  }
  .status-pending { background-color: #ffd782; color: #444444; }
  .status-paid { background-color: #4CAF50; color: #ffffff; }
  .status-processing { background-color: #5ee3e3; color: #444444; }
  .status-shipping { background-color: #abceff; color: #444444; }
  .status-completed { background-color: #0258d3; color: #ffffff; }
  .status-cancelled { background-color: #fc2865; color: #ffffff; }

  @media (max-width: 768px) {
      main .container.product-card {
          margin-top: -40px !important;
          padding: 0 15px !important;
          max-width: 100% !important;
      }

      main .cta-overlay {
          top: 50% !important;
      }
      
      main .cta-overlay h3 {
          font-size: 1.8rem !important;
          line-height: 1.2 !important;
          margin-bottom: 8px !important;
      }
      
      main .breadcrumb {
          display: none !important;
      }

      main .row.g-4 {
          margin: 0 !important;
          padding-top: 20px !important;
      }

      main .col-lg-7 {
          padding: 0 15px !important;
          margin-bottom: 30px !important;
      }

      main .sticky-left {
          position: relative !important;
          top: auto !important;
      }

      main #productCarousel {
          max-width: 100% !important;
          margin: 0 auto !important;
      }

      main #productCarousel .carousel-inner {
          border-radius: 12px !important;
          overflow: hidden !important;
      }

      main #productCarousel img {
          max-height: 280px !important;
          width: 100% !important;
          object-fit: contain !important;
      }

      main .thumb-container {
          padding-left: 0 !important;
          justify-content: center !important;
          margin-top: 15px !important;
      }

      main .thumb-img {
          width: 60px !important;
          height: 40px !important;
          margin: 0 4px !important;
      }

      main .thumb-img:first-child {
          margin-left: 4px !important;
      }

      main .col-lg-5 {
          padding: 0 15px !important;
      }

      main .card {
          margin-bottom: 20px !important;
          border-radius: 12px !important;
      }

      main .form-control {
          font-size: 0.75rem !important;
          height: 38px !important;
      }

      main .form-label {
          font-size: 0.6rem !important;
          margin-bottom: 4px !important;
      }
      main .btn {
          font-size: 0.75rem !important;
          height: 38px !important;
          width: 100px !important;
      }

      main div[style*="border:1px solid #ccc"] {
          padding: 12px 16px !important;
          margin: 15px 0 !important;
      }

      main div[style*="font-size:1.76rem"] {
          font-size: 1.4rem !important;
      }

      main .collapse {
          font-size: 0.65rem !important;
      }

      main .row.g-2 {
          margin: 0 !important;
      }

      main .row.g-2 .col {
          padding: 0 5px !important;
          margin-bottom: 10px !important;
      }
  }

  @media (max-width: 768px) {
      main .container-fluid.footer .container h3 {
          font-size: 1.4rem !important;
          margin-bottom: 20px !important;
          text-align: center !important;
      }

      main .container-fluid.footer .row.g-3 {
          margin: 0 !important;
          justify-content: center !important;
      }

      main .container-fluid.footer .col-lg-3:nth-child(n+3) {
          display: none !important;
      }

      main .container-fluid.footer .col-lg-3 {
          flex: 0 0 48% !important;
          max-width: 48% !important;
          padding: 0 6px !important;
          margin-bottom: 16px !important;
      }

      main .container-fluid.footer .product-item {
          transform: scale(1) !important;
          margin: 0 auto !important;
          height: 220px !important;
          overflow: hidden !important;
      }

      main .container-fluid.footer .product-item .position-relative {
          height: 120px !important;
          width: 100% !important;
          max-width: 100% !important;
          margin: 0 auto !important;
          flex-shrink: 0 !important;
      }

      main .container-fluid.footer .product-item .content {
          padding: 8px !important;
          min-height: 100px !important;
          max-height: 100px !important;
          overflow: hidden !important;
          display: flex !important;
          flex-direction: column !important;
          justify-content: space-between !important;
      }

      main .container-fluid.footer .product-item .title {
          font-size: 0.7rem !important;
          margin-bottom: 2px !important;
          line-height: 1.2 !important;
          overflow: hidden !important;
          text-overflow: ellipsis !important;
          white-space: nowrap !important;
      }

      main .container-fluid.footer .product-item .title:nth-of-type(2) {
          font-size: 0.6rem !important;
          margin-bottom: 4px !important;
          color: #ddd !important;
      }
      main .container-fluid.footer .product-item .price-container {
          gap: 3px !important;
          align-items: center !important;
          flex-wrap: wrap !important;
          margin-top: auto !important;
      }

      main .container-fluid.footer .product-item .price {
          font-size: 0.75rem !important;
          line-height: 1.1 !important;
      }

      main .container-fluid.footer .product-item .discount-price {
          font-size: 0.55rem !important;
          line-height: 1.1 !important;
      }

      main .container-fluid.footer .discount-logo {
          width: 10px !important;
          height: auto !important;
          flex-shrink: 0 !important;
      }
      main .container-fluid.footer .product-item div[style*="font-size:0.64rem"] {
          font-size: 0.55rem !important;
          margin-bottom: 2px !important;
          margin-top: 2px !important;
      }

      main .container-fluid.footer .product-item div[style*="font-size:0.72rem"] {
          font-size: 0.6rem !important;
          margin-bottom: 2px !important;
          margin-top: 2px !important;
      }
  }

  @media (max-width: 480px) {
      main .container.product-card {
          margin-top: -20px !important;
          padding: 0 10px !important;
      }

      main .cta-overlay h3 {
          font-size: 1.5rem !important;
      }

      main #productCarousel img {
          max-height: 240px !important;
      }

      main .thumb-img {
          width: 50px !important;
          height: 35px !important;
      }

      main .col-lg-7, main .col-lg-5 {
          padding: 0 10px !important;
      }

      main .container-fluid.footer .product-item {
          transform: scale(1) !important;
          height: 200px !important;
      }

      main .container-fluid.footer .product-item .position-relative {
          height: 100px !important;
      }

      main .container-fluid.footer .product-item .content {
          min-height: 90px !important;
          max-height: 90px !important;
          padding: 6px !important;
      }

      main .container-fluid.footer .product-item .title {
          font-size: 0.65rem !important;
      }

      main .container-fluid.footer .product-item .price {
          font-size: 0.7rem !important;
      }

      main .container-fluid.footer .product-item .discount-price {
          font-size: 0.5rem !important;
      }
  }

  @media (max-width: 768px) {
      main .container-fluid.footer:last-of-type {
          display: block !important;
      }
  }
</style>

<br><br>
<div class="container-fluid footer mt-4 pt-4 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%;">
      <h3 class="mb-2" style="font-family: 'Poppins'; font-size:2.8rem; font-weight:550; color:#fff;">
        Detail Order - {{ 'INV' . substr($order->spk, 3, strpos($order->spk, '-') - 3) }}
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-family: 'Poppins'; font-size:0.64rem; font-weight:500; text-transform: uppercase;">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('profile.index') }}">Profile</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            Detail Order
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<main>
  <div class="container-fluid px-3">
    <div class="container product-card" style="margin-top:-150px;">
      <div class="row g-4">
        <!-- Carousel and thumbnails -->
        @php $thumbs = $product->images->take(4); @endphp
        <div class="col-lg-7">
          <div class="sticky-left">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
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
            <div class="d-flex mt-2 thumb-container" style="justify-content: start; padding-left: 12px;">
              @if($thumbs->isEmpty())
                @for($i = 0; $i < 4; $i++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="thumb-img me-2 {{ $i === 0 ? 'active' : '' }}"
                      style="width:80px; height:48px; object-fit:contain; border-radius:6px; cursor:pointer;">
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
                      class="thumb-img me-2 {{ $i === 0 ? 'active' : '' }}"
                      style="width:80px; height:48px; object-fit:contain; border-radius:6px; cursor:pointer;">
                @endforeach

                @for($j = $thumbs->count(); $j < 4; $j++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $j }}"
                      class="thumb-img me-2"
                      style="width:80px; height:48px; object-fit:contain; border-radius:6px; cursor:pointer;">
                @endfor
              @endif
            </div>
          </div>
        </div>

        <!-- Order Details -->
        <div class="col-lg-5">
          <!-- Order Info Card -->
          <div class="card mb-3" style="border-radius: 12px; border: 1px solid #e0e0e0;">
            <div class="card-header" style="background-color: #f8f9fa; border-radius: 12px 12px 0 0;">
              <h5 class="mb-0" style="font-family: 'Poppins'; font-weight: 600; font-size: 1rem;">Informasi Order</h5>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-4" style="font-size: 0.8rem;"><strong>Invoice:</strong></div>
                <div class="col-8" style="font-size: 0.8rem;">{{ 'INV' . substr($order->spk, 3, strpos($order->spk, '-') - 3) }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-4" style="font-size: 0.8rem;"><strong>Status:</strong></div>
                <div class="col-8">
                  <span class="badge" style="display: inline-block; padding: 6px 13px; font-size: 0.6rem !important; background-color: {{ $badge }}; color: {{ $foncol }} !important; font-family: 'Poppins', sans-serif; border-radius: 3px; font-weight: 450 !important;">
                    {{ $firlabel }} <br> {{ $seclabel }}
                  </span>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-4" style="font-size: 0.8rem;"><strong>Tanggal:</strong></div>
                <div class="col-8" style="font-size: 0.8rem;">{{ $order->created_at->format('d M Y H:i') }}</div>
              </div>
              @if($order->waktu_deadline)
              <div class="row mb-2">
                <div class="col-4" style="font-size: 0.8rem;"><strong>Deadline:</strong></div>
                <div class="col-8" style="font-size: 0.8rem;">{{ $order->waktu_deadline }}</div>
              </div>
              @endif
            </div>
          </div>

          <!-- Product Details dari Order Data -->
          <div class="mb-2">
            <label class="form-label"><b>BAHAN</b></label>
            <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
              {{ Str::limit($orderProduct->material_type ?? $product->name, 30) }}
              @if($product->additional_size && $product->additional_unit)
              {{ $product->additional_size }} {{ $product->additional_unit }}
              @endif
            </div>
          </div>

          @if($variantCategories->isNotEmpty())
            <div class="mb-2">
              <label class="form-label"><b>VARIAN</b></label>
              @foreach($variantCategories as $category)
                @if($category['selected_variant'])
                  <div class="form-control mb-1" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                    <strong>{{ $category['display_name'] }}:</strong><span class="ms-2">{{ $category['selected_variant']->value }}</span>
                    {{-- @if($category['selected_variant']->price > 0)
                      <span class="ms-2 text-success">(+{{ number_format($category['selected_variant']->price, 0, ',', '.') }})</span>
                    @endif --}}
                  </div>
                @endif
              @endforeach
            </div>
          @endif
          
          @if($orderProduct->finishing_type)
          <div class="mb-2">
            <label class="form-label"><b>FINISHING</b></label>
            <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
              {{ $orderProduct->finishing_type }}
            </div>
          </div>
          @endif

          <div class="row g-2 mb-2">
            <div class="col">
              <label class="form-label"><b>KEBUTUHAN EXPRESS</b></label>
              <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $order->express ? 'Ya' : 'Tidak' }}
              </div>
            </div>
            @if($order->waktu_deadline)
            <div class="col">
              <label class="form-label"><b>DEADLINE JAM</b></label>
              <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $order->waktu_deadline }}
              </div>
            </div>
            @endif
          </div>

          <div class="row g-2 mb-2">
            <div class="col">
              <label class="form-label"><b>KEBUTUHAN PROOFING</b></label>
              <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $order->kebutuhan_proofing ? 'Ya' : 'Tidak' }}
              </div>
            </div>
            @if($order->proof_qty)
            <div class="col">
              <label class="form-label"><b>QTY PROOFING</b></label>
              <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $order->proof_qty }}
              </div>
            </div>
            @endif
          </div>

          <!-- Design Files -->
          @if($order->order_design || $order->preview_design)
          <div class="row g-2 mb-2">
            @if($order->order_design)
            <div class="col">
              <label class="form-label"><b>DESAIN CETAK</b></label>
              <div class="d-flex align-items-center" style="padding: 10px 16px; background-color:#f8f9fa; border-radius:12px;">
                <i class="bi bi-file-earmark" style="margin-right:8px; font-size:1rem;"></i>
                <a href="#" class="text-decoration-none" style="font-size: 0.8rem;"
                  onclick="showFilePreview('{{ asset('storage/landingpage/img/order_design/' . $order->order_design) }}', '{{ $order->order_design }}')">
                  {{ $order->order_design }}
                </a>
              </div>
            </div>
            @endif
            @if($order->preview_design)
            <div class="col">
              <label class="form-label"><b>DESAIN PREVIEW</b></label>
              <div class="d-flex align-items-center" style="padding: 10px 16px; background-color:#f8f9fa; border-radius:12px;">
                <i class="bi bi-file-earmark-image" style="margin-right:8px; font-size:1rem;"></i>
                <a href="#" class="text-decoration-none" style="font-size: 0.8rem;"
                  onclick="showFilePreview('{{ asset('storage/landingpage/img/order_design/' . $order->preview_design) }}', '{{ $order->preview_design }}')">
                  {{ $order->preview_design }}
                </a>
              </div>
            </div>
            @endif
          </div>
          @endif

          <!-- Dimensions -->
          @if($orderProduct->length && $orderProduct->width)
          <div class="row g-2 mb-2">
            <div class="col">
              <label class="form-label"><b>PANJANG ({{ strtoupper($product->additional_unit) }})</b></label>
              <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $orderProduct->length }} {{ $product->additional_unit }}
              </div>
            </div>
            <div class="col">
              <label class="form-label"><b>LEBAR ({{ strtoupper($product->additional_unit) }})</b></label>
              <div class="form-control" style="height:40px; border-radius:56px; display:flex; align-items:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $orderProduct->width }} {{ $product->additional_unit }}
              </div>
            </div>
          </div>
          @endif

          <!-- Notes -->
          @if($order->notes)
          <div class="mb-2">
            <label class="form-label"><b>CATATAN</b></label>
            <div class="form-control" style="min-height:80px; border-radius:12px; background-color:#f8f9fa; padding:12px; font-size: 0.8rem;">
              {{ $order->notes }}
            </div>
          </div>
          @endif

          <!-- Quantity -->
          <div class="row mb-2">
            <div class="col-auto">
              <label class="form-label"><b>QTY</b></label>
              <div class="form-control" style="width:120px; height:40px; border-radius:56px; display:flex; align-items:center; justify-content:center; background-color:#f8f9fa; font-size: 0.8rem;">
                {{ $orderProduct->qty }}
              </div>
            </div>
            <div class="col-auto d-flex align-items-end">
              @if($order->order_status == 0)
                <a href="{{ route('checkout.order', $order->id) }}" 
                   class="btn btn-primary me-2" 
                   style="border-radius:40px; width:120px; height:40px; font-weight:600; font-family:'Poppins', sans-serif; display:flex; align-items:center; justify-content:center; font-size: 0.8rem;">
                  BAYAR
                </a>
                <button type="button" 
                        class="btn btn-danger" 
                        style="border-radius:40px; width:120px; height:40px; font-weight:600; font-family:'Poppins', sans-serif; font-size: 0.8rem;"
                        onclick="cancelOrder({{ $order->id }})">
                  BATALKAN
                </button>
              @endif
            </div>
          </div>

          <!-- Total Price -->
          <div style="border:1px solid #ccc; border-radius:12px; padding:16px 24px; display:flex; justify-content:space-between; align-items:center;">
            <div>
              <div style="font-family:'Poppins'; font-size:0.72rem; color:#888; font-weight:500;">Total Harga</div>
              @if($order->express == 1)
                <small style="color: #ff6b6b; font-size: 0.6rem;">Termasuk express (+50%)</small>
              @endif
            </div>
            <div style="font-family:'Poppins'; font-size:1.76rem; font-weight:600; color:#0439a0;">
              Rp {{ number_format($order->subtotal, 0, ',', '.') }}
            </div>
          </div>

          <!-- Product Information -->
          <div class="mt-3">
            <div class="d-flex align-items-center justify-content-between w-100 border-0 bg-transparent pb-2 mb-2 border-bottom" 
                 style="font-family:'Poppins'; font-weight:500; font-size:0.8rem; cursor:pointer; border-color:#ccc !important;" 
                 data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
              <div class="d-flex align-items-center">
                <div style="width:16px;height:16px;border-radius:50%;background:#444444;color:#fff;display:flex;align-items:center;justify-content:center;margin-right:8px;font-size:0.64rem;font-weight:600;">i</div>
                INFORMASI PRODUK
              </div>
              <div id="iconChevron" style="transition: transform 0.3s;"><i class="bi bi-chevron-right"></i></div>
            </div>
            <div class="collapse show" id="collapseInfo">
              <div style="margin-top:16px; margin-bottom:8px; font-family:'Poppins'; font-size:0.75rem; color:#444444;font-weight:540;">
                Lama Pengerjaan
              </div>
              <div style="font-family:'Poppins'; font-size:0.68rem; color:#888; font-weight:500;">
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
              <div style="margin-top:16px; margin-bottom:8px; font-family:'Poppins'; font-size:0.75rem; color:#444444;font-weight:540;">
                Keterangan Produk
              </div>
              <div style="padding-right: 16px; font-family:'Poppins'; font-size:0.68rem; color:#888; font-weight:500;">
                {{ $product->description }}
              </div>
              <div style="margin-top:16px; margin-bottom:8px; font-family:'Poppins'; font-size:0.75rem; color:#444444;font-weight:540;">
                Spesifikasi
              </div>
              <div style="font-family:'Poppins'; font-size:0.68rem; color:#888; font-weight:500;">
                {!! nl2br(e(str_replace(';', "\n", $product->spesification_desc))) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Produk Lainnya -->
  <div class="container-fluid footer mt-4 pt-4 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative">
      <img class="w-100 rounded" style="max-height:480px" src="{{ asset('landingpage/img/login_register_bg.png') }}" alt="Background"/>
      <div class="position-absolute top-50 start-50 translate-middle w-100 px-3">
        <div class="container">
          <h3 class="mb-3" style="font-family: 'Poppins'; font-size:1.76rem; font-weight:600; color:#fff;">
            Produk Lainnya
          </h3>
          <div class="row g-3">
            @foreach($bestProducts as $prod)
              <div class="col-lg-3 col-md-6">
                <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                  <div class="product-item shadow-sm h-100" style="border-radius:8px; background: transparent;">
                    <div class="position-relative bg-light overflow-hidden" style="border-radius:8px; height:200px;width:240px;">
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
                    <div class="content p-2 d-flex flex-column" style="min-height:112px;">
                      <div class="title mb-0" style="font-family: 'Poppins'; font-size:0.96rem; font-weight:600; color:#fff;">
                        {{ $prod->name }}
                        @if($prod->additional_size && $prod->additional_unit)
                          {{ $prod->additional_size }} {{ $prod->additional_unit }}
                        @endif
                      </div>
                      <div class="title mb-3" style="font-family: 'Poppins'; font-size:0.64rem; font-weight:400; color:#fff;">
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
                        <div class="title mb-0 mt-1" style="font-size:0.64rem;font-weight:600;color:#fff">MULAI DARI</div>
                        <div class="price-container d-flex align-items-center" style="gap:6px;">
                          <span class="discount-price text-decoration-line-through text-white" style="font-size:0.7rem;">
                            {{ $prod->getFormattedPrice() }}
                          </span>
                          <img src="{{ asset('landingpage/img/discount_logo.png') }}" alt="Diskon" class="discount-logo" style="width:14px; height:auto;">
                          <span class="price fw-bold" style="font-family: 'Poppins'; font-size:1.04rem; font-weight:500; color:#fc2865;">
                            {{ $prod->getFormattedDiscountedPrice() }}
                          </span>
                        </div>
                      @else
                        <div class="title mb-0 mt-1" style="font-size:0.72rem;font-weight:400; color:#fff;">Mulai Dari</div>
                        <div class="price-container mt-0">
                          <span class="fw-bold text-white" style="font-size:1rem;">{{ $prod->getFormattedPrice() }}</span>
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
  <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filePreviewModalLabel">Preview File</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div id="filePreviewContent">
          </div>
        </div>
        <div class="modal-footer">
          <a id="downloadFileBtn" href="#" class="btn btn-success" download>
            <i class="bi bi-download"></i> Download
          </a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function showFilePreview(fileUrl, fileName) {
    const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
    const modalTitle = document.getElementById('filePreviewModalLabel');
    const previewContent = document.getElementById('filePreviewContent');
    const downloadBtn = document.getElementById('downloadFileBtn');
    
    modalTitle.textContent = `Preview: ${fileName}`;
    downloadBtn.href = fileUrl;
    downloadBtn.download = fileName;
    
    const extension = fileName.split('.').pop().toLowerCase();
    previewContent.innerHTML = '';
    
    if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
      previewContent.innerHTML = `
        <img src="${fileUrl}" class="img-fluid" style="max-height: 500px;" alt="Preview">
      `;
    } else if (extension === 'pdf') {
      previewContent.innerHTML = `
        <embed src="${fileUrl}" width="100%" height="500px" type="application/pdf">
        <p class="mt-2 text-muted">Jika PDF tidak tampil, <a href="${fileUrl}" target="_blank">klik di sini</a></p>
      `;
    } else if (['svg'].includes(extension)) {
      previewContent.innerHTML = `
        <img src="${fileUrl}" class="img-fluid" style="max-height: 500px;" alt="SVG Preview">
      `;
    } else {
      previewContent.innerHTML = `
        <div class="text-center py-5">
          <i class="bi bi-file-earmark-zip" style="font-size: 4rem; color: #6c757d;"></i>
          <h5 class="mt-3">${fileName}</h5>
          <p class="text-muted">File ini tidak dapat di-preview.<br>Silakan download untuk melihat isi file.</p>
        </div>
      `;
    }
    
    modal.show();
  }
</script>
<script>
  // Carousel thumbnail functionality
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

  // Toggle collapse
  const collapseEl = document.getElementById('collapseInfo');
  const iconChevron = document.getElementById('iconChevron');

  if (collapseEl.classList.contains('show')) {
    iconChevron.style.transform = 'rotate(90deg)';
  } else {
    iconChevron.style.transform = 'rotate(0deg)';
  }

  collapseEl.addEventListener('show.bs.collapse', function () {
    iconChevron.style.transform = 'rotate(90deg)';
  });
  collapseEl.addEventListener('hide.bs.collapse', function () {
    iconChevron.style.transform = 'rotate(0deg)';
  });

  // Cancel order function
  function cancelOrder(orderId) {
    swal({
      title: "Konfirmasi",
      text: "Apakah Anda yakin ingin membatalkan order ini?",
      icon: "warning",
      buttons: {
        cancel: "Tidak",
        confirm: "Ya, Batalkan"
      },
      dangerMode: true,
    }).then((willCancel) => {
      if (willCancel) {
        // Send AJAX request to cancel order
        fetch(`/order/${orderId}/cancel`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            swal({
              title: "Berhasil!",
              text: data.message,
              icon: "success",
            }).then(() => {
              location.reload(); // Refresh halaman untuk update status
            });
          } else {
            swal({
              title: "Gagal!",
              text: data.error || 'Terjadi kesalahan',
              icon: "error",
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
          swal({
            title: "Error!",
            text: "Terjadi kesalahan saat membatalkan order",
            icon: "error",
          });
        });
      }
    });
  }
</script>

@endsection