@extends('landingpage.index')
@section('content')
<style>
  .thumb-container {
    /* Lebar container sama dengan lebar carousel (opsional) */
    max-width: 100%;
    padding-left: 20px;
  }
  .thumb-img {
    border: 2px solid transparent;
    transition: border-color .2s;
    margin-left: 10px;
  }
  .thumb-img.active {
    border-color: #0d6efd; /* warna primary Bootstrap */
  }
/* kalau hanya thumb pertama yang mau diberi jarak ekstra */
.thumb-img:first-child {
  margin-left: 110px;
}
.sticky-left {
    position: sticky;
    top: 120px;
    z-index: 10;
  }
  .is-invalid {
      border-color: #fc2865 !important;
  }

  .invalid-feedback {
      display: block;
      color: #fc2865;
      font-size: 0.8rem;
      font-weight: 200;
  }
  .custom-file-input-fix {
    height: 50px;
    padding: 12px 20px;
    font-size: 0.875rem;
    border-radius: 15px;
    background-color: #f9f9f9;
    border: 1px solid #ced4da;
    color: #495057;
  }

  .custom-file-input-fix::file-selector-button {
    padding: 8px 16px;
    margin-right: 12px;
    border: none;
    border-radius: 8px;
    background-color: #0439a0;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
  }

  .custom-file-input-fix::file-selector-button:hover {
    background-color: #062f87;
  }
  .form-label {
    font-family: 'Poppins';
    font-size:0.8rem;
    font-weight:350 !important;
    color:#000000;"
  }
</style>
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%;">
      <h3 class="mb-2" style="font-family: 'Poppins'; font-size:3.5rem; font-weight:550; color:#fff;">
        {{ $product->label->name }} - {{ $product->name }}
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:500; text-transform: uppercase;">
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
    <div class="container product-card">
      @php
        $base = $product->price;
        $final = $base;
        if($product->discount_percent) {
            $final -= $base * $product->discount_percent / 100;
        }
        if($product->discount_fix) {
            $final -= $product->discount_fix;
        }
      @endphp
      <div class="row g-5">
        <!-- Carousel and thumbnails -->
        @php $thumbs = $product->images->take(4); @endphp
        <div class="col-lg-7">
          <!-- Sticky wrapper -->
          <div class="sticky-left">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                @if($thumbs->isEmpty())
                  @for($i = 0; $i < 4; $i++)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                      <img src="{{ asset('landingpage/img/nophoto.png') }}"
                          class="d-block w-100"
                          style="max-height:450px; object-fit:contain;"
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
                          style="max-height:450px; object-fit:contain;"
                          alt="">
                    </div>
                  @endforeach

                  @for($j = $thumbs->count(); $j < 4; $j++)
                    <div class="carousel-item">
                      <img src="{{ asset('landingpage/img/nophoto.png') }}"
                          class="d-block w-100"
                          style="max-height:450px; object-fit:contain;"
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
                style="justify-content: start; padding-left: 15px;">
              @if($thumbs->isEmpty())
                @for($i = 0; $i < 4; $i++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="thumb-img me-2 {{ $i === 0 ? 'active' : '' }}"
                      style="width:100px; height:60px; object-fit:contain; border-radius:8px; cursor:pointer;">
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
                      style="width:100px; height:60px; object-fit:contain; border-radius:8px; cursor:pointer;">
                @endforeach

                @for($j = $thumbs->count(); $j < 4; $j++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $j }}"
                      class="thumb-img me-2"
                      style="width:100px; height:60px; object-fit:contain; border-radius:8px; cursor:pointer;">
                @endfor
              @endif
            </div>
          </div>
        </div>
        <!-- Form and details -->
        <div class="col-lg-5">
          <p style="font-family:'Poppins';font-size:0.8rem;font-weight:500;color:#888;">*Mulai dari</p>
          @if($finalBase < $product->price)
              <h4 style="font-family:'Poppins';font-size:2rem;color:#fc2865;">
                  Rp {{ number_format($finalBase, 0, ',', '.') }}
              </h4>
              <p style="font-family:'Poppins';color:#c3c3c3;">
                  <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del>
              </p>
          @else
              <h4 style="font-family:'Poppins';font-size:2rem;">
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
                    <li>{{ $msg }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <input type="hidden" id="basePrice"    value="{{ $finalBase }}">
            <input type="hidden" id="unit"         value="{{ $product->additional_unit }}">
            <input type="hidden" name="order_status" value="0">
            @if($disc && $disc->discount_percent)
              <input type="hidden" name="discount_percent" value="{{ $disc->discount_percent }}">
            @elseif($disc && $disc->discount_fix)
              <input type="hidden" name="discount_fix" value="{{ $disc->discount_fix }}">
            @endif

            {{-- BAHAN --}}
            <div class="mb-3">
              <label class="form-label"><b>BAHAN</b></label>
              <select 
                name="product_id" 
                class="form-select @error('product_id') is-invalid @enderror"
                style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;"
              >
                <option value="{{ $product->id }}" {{ old('product_id', $product->id)==$product->id?'selected':'' }}>
                  {{ $product->name }}
                </option>
              </select>
              @error('product_id')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            {{-- FINISHING --}}
            @if($product->label->finishings->isNotEmpty())
              <div class="mb-3">
                <label class="form-label"><b>FINISHING</b></label>
                <select 
                  name="finishing_id" 
                  id="finishingSelect"
                  class="form-select @error('finishing_id') is-invalid @enderror"
                  style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;"
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
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
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
                  class="form-select @error('express') is-invalid @enderror"
                  style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;">
                  <option value="0" {{ old('express', optional($order)->express ?? '0') == '0' ? 'selected' : '' }}>Tidak</option>
                  <option value="1" {{ old('express', optional($order)->express ?? '0') == '1' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('express')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>DEADLINE JAM</b></label>
                <input
                  type="time"
                  id="deadlineTime"
                  name="deadline_time"
                  class="form-control @error('deadline_time') is-invalid @enderror"
                  style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;"
                  {{ old('express', optional($order)->express ?? '0') == '1' ? '' : 'disabled' }}
                  value="{{ old('deadline_time', optional($order)->deadline_time ? substr($order->deadline_time,0,5) : '') }}">
                @error('deadline_time')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- PROOFING --}}
            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>KEBUTUHAN PROOFING</b></label>
                <select 
                  id="needProofing" 
                  name="needs_proofing" 
                  class="form-select @error('needs_proofing') is-invalid @enderror"
                  style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;">
                  <option value="0" {{ old('needs_proofing', optional($order)->needs_proofing ?? '0') == '0' ? 'selected' : '' }}>Tidak</option>
                  <option value="1" {{ old('needs_proofing', optional($order)->needs_proofing ?? '0') == '1' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('needs_proofing')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>QTY PROOFING</b></label>
                <input
                  type="number"
                  id="proofQty"
                  name="proof_qty"
                  class="form-control @error('proof_qty') is-invalid @enderror"
                  style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;"
                  value="{{ old('proof_qty', optional($order)->proof_qty ?? '') }}"
                  {{ old('needs_proofing', optional($order)->needs_proofing ?? '0') == '1' ? '' : 'disabled' }}>
                @error('proof_qty')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
            </div>

            {{-- UPLOAD DESAIN --}}
            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>UPLOAD DESAIN</b></label>
                <input 
                  type="file" 
                  name="order_design" 
                  accept=".jpeg,.jpg,.png,.pdf,.svg,.cdr,.psd,.ai,.tiff,.rar,.zip" 
                  class="form-control @error('order_design') is-invalid @enderror custom-file-input-fix"
                  id="order_design"
                >
                @error('order_design')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>PREVIEW DESAIN</b></label>
                <input 
                  type="file" 
                  name="preview_design" 
                  accept=".jpeg,.jpg,.png,.pdf" 
                  class="form-control @error('preview_design') is-invalid @enderror custom-file-input-fix"
                  id="preview_design"
                >
                @error('preview_design')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
              <small class="form-text text-muted mt-2">
                Format yang diterima: .jpeg, .jpg, .png, .pdf, .svg, .cdr, .psd, .ai, .tiff.<br>
                Untuk multiple file desain, unggah dalam arsip .rar atau .zip.
              </small>
            </div>

            {{-- DIMENSI (jika ada) --}}
            @if(in_array($product->additional_unit, ['cm','m']))
              <div class="row g-2 mb-3">
                <div class="col">
                  <label class="form-label"><b>PANJANG ({{ strtoupper($product->additional_unit) }})</b></label>
                  <div class="input-group flex-nowrap">
                    <input
                      type="number"
                      name="length"
                      id="panjang"
                      class="form-control @error('length') is-invalid @enderror"
                      placeholder="Panjang"
                      value="{{ old('length', $orderProduct->length ?? ($product->additional_unit === 'm' ? 1 : 100)) }}"
                      style="height:50px; border-radius:70px 0 0 70px; font-size:0.875rem; padding:0 2rem;">
                    <span class="input-group-text" style="border-radius:0 70px 70px 0; font-size:0.875rem; padding:0 1rem;">
                      {{ $product->additional_unit }}
                    </span>
                  </div>
                  @error('length')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
                <div class="col">
                  <label class="form-label"><b>LEBAR ({{ strtoupper($product->additional_unit) }})</b></label>
                  <div class="input-group flex-nowrap">
                    <input
                      type="number"
                      name="width"
                      id="lebar"
                      class="form-control @error('width') is-invalid @enderror"
                      placeholder="Lebar"
                      value="{{ old('width', $orderProduct->width ?? ($product->additional_unit === 'm' ? 1 : 100)) }}"
                      style="height:50px; border-radius:70px 0 0 70px; font-size:0.875rem; padding:0 2rem;">
                    <span class="input-group-text" style="border-radius:0 70px 70px 0; font-size:0.875rem; padding:0 1rem;">
                      {{ $product->additional_unit }}
                    </span>
                  </div>
                  @error('width')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>
            @endif

            {{-- CATATAN --}}
            <div class="mb-3">
              <label class="form-label"><b>CATATAN</b></label>
              <textarea
                name="notes"
                class="form-control @error('notes') is-invalid @enderror"
                style="font-family:'Poppins'; width:100%; height:100px; border-radius:10px; font-size:0.875rem; padding:15px 20px; resize:vertical;"
                placeholder="Masukkan catatan tambahan jika ada">{{ old('notes', optional($order)->notes ?? '') }}</textarea>
              @error('notes')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
              @enderror
            </div>

            {{-- QTY & SUBMIT --}}
            <div class="row mb-3">
              <div class="col-auto">
                <label class="form-label"><b>QTY</b></label>
                <input
                  type="number"
                  name="qty"
                  id="qty"
                  value="{{ old('qty', optional($orderProduct)->qty ?? 1) }}"
                  class="form-control @error('qty') is-invalid @enderror"
                  placeholder="1"
                  style="width:150px; height:50px; border-radius:70px; font-size:0.875rem; padding:0 60px;"
                >
                @error('qty')
                  <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
              </div>
              <div class="col-auto d-flex align-items-end">
                <button type="submit" class="btn btn-primary" style="border-radius:50px; width:310px; height:50px; font-weight:600; font-family:'Poppins', sans-serif;">
                  {{ $isEdit ? 'UBAH ORDER' : 'BELI PRODUK' }}
                </button>
              </div>
            </div>

            {{-- TOTAL HARGA --}}
            <div style="border:1px solid #ccc; border-radius:15px; padding:20px 30px; display:flex; justify-content:space-between; align-items:center;">
              <div style="font-family:'Poppins'; font-size:0.9rem; color:#888; font-weight:500;">Total Harga</div>
              <div style="font-family:'Poppins'; font-size:2.2rem; font-weight:600; color:#0439a0;">Rp <span id="totalHarga">0</span></div>
            </div>
          </form>

          <!-- Informasi Produk custom -->
          <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between w-100 border-0 bg-transparent pb-2 mb-2 border-bottom" style="font-family:'Poppins'; font-weight:500; font-size:1rem; cursor:pointer; border-color:#ccc !important;" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
              <div class="d-flex align-items-center">
                <div style="width:20px;height:20px;border-radius:50%;background:#444444;color:#fff;display:flex;align-items:center;justify-content:center;margin-right:10px;font-size:0.8rem;font-weight:600;">i</div>
                INFORMASI PRODUK
              </div>
              <div id="iconChevron" style="transition: transform 0.3s;"><i class="bi bi-chevron-right"></i></div>
            </div>
            <div class="collapse show" id="collapseInfo">
              <div style="margin-top:20px; margin-bottom:10px; font-family:'Poppins'; font-size:0.94rem; color:#444444;font-weight:540;">
                Lama Pengerjaan
              </div>
              <div style="font-family:'Poppins'; font-size:0.85rem; color:#888; font-weight:500;">
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
              <div style="margin-top:20px; margin-bottom:10px; font-family:'Poppins'; font-size:0.94rem; color:#444444;font-weight:540;">
                Keterangan Produk
              </div>
              <div style="padding-right: 20px; font-family:'Poppins'; font-size:0.85rem; color:#888; font-weight:500;">
                {{ $product->description }}
              </div>
              <div style="margin-top:20px; margin-bottom:10px; font-family:'Poppins'; font-size:0.94rem; color:#444444;font-weight:540;">
                Spesifikasi
              </div>
              <div style="font-family:'Poppins'; font-size:0.85rem; color:#888; font-weight:500;">
                {!! nl2br(e(str_replace(';', "\n", $product->spesification_desc))) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Produk Lainnya -->
  <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative">
      <img
        class="w-100 rounded" style="max-height:600px"
        src="{{ asset('landingpage/img/login_register_bg.png') }}"
        alt="Background"/>

      <div class="position-absolute top-50 start-50 translate-middle w-100 px-3">
        <div class="container">
          <h3 class="mb-4" style="font-family: 'Poppins'; font-size:2.2rem; font-weight:600; color:#fff;">
            Produk Lainnya
          </h3>
          <div class="row g-4">
            @foreach($bestProducts as $prod)
              <div class="col-lg-3 col-md-6">
                <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                  <div class="product-item shadow-sm h-100" style="border-radius:10px; background: transparent;">
                    <div class="position-relative bg-light overflow-hidden" style="border-radius:10px; height:250px;width:300px;">
                      @if($prod->images->first())
                        <img src="{{ asset('landingpage/img/product/'.$prod->images->first()->image_product) }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                      @else
                        <img src="{{ asset('landingpage/img/nophoto.jpg') }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                      @endif
                    </div>
                    <div class="content p-3 d-flex flex-column" style="min-height:140px;">
                      <div class="title mb-0" style="font-family: 'Poppins'; font-size:1.2rem; font-weight:600; color:#fff;">{{ $prod->name }}</div>
                      <div class="title mb-4" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#fff;">Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}</div>
                      @php
                        $base=$prod->price; $final=$base;
                        if($prod->discount_percent){ $final-=$base*$prod->discount_percent/100; }
                        if($prod->discount_fix){ $final-=$prod->discount_fix; }
                      @endphp
                      @if($final<$base)
                        <div class="title mb-0 mt-1" style="font-size:0.8rem;font-weight:600;color:#fff">MULAI DARI</div>
                        <div class="price-container d-flex align-items-center" style="gap:8px;">
                          <span class="discount-price text-decoration-line-through text-white">
                            Rp {{ number_format($base,0,',','.') }}
                          </span>
                          <img 
                            src="{{ asset('landingpage/img/discount_logo.png') }}" 
                            alt="Diskon" 
                            class="discount-logo" 
                            style="width:18px; height:auto;"
                          >
                          <span class="price fw-bold" style="font-family: 'Poppins'; font-size:1.3rem; font-weight:500; color:#fc2865;">
                            Rp {{ number_format($final,0,',','.') }}
                          </span>
                        </div>
                      @else
                        <div class="title mb-0 mt-1" style="font-size:0.9rem;font-weight:400; color:#fff;">Mulai Dari</div>
                        <div class="price-container mt-0">
                          <span class="fw-bold text-white">Rp {{ number_format($base,0,',','.') }}</span>
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

{{-- SweetAlert untuk feedback --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

  // Toggle chevron rotation
  const collapseEl   = document.getElementById('collapseInfo');
  const iconChevron  = document.getElementById('iconChevron');

  // 1) Atur icon berdasarkan state awal:
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

  // Klik thumbnail
  thumbs.forEach((img, idx) => {
    img.addEventListener('click', () => {
      thumbs.forEach(i => i.classList.remove('active'));
      img.classList.add('active');
    });
  });

  // Saat carousel selesai slide
  carousel.addEventListener('slid.bs.carousel', function(e) {
    const currentIndex = Array.from(
      e.currentTarget.querySelectorAll('.carousel-item')
    ).indexOf(e.relatedTarget);

    thumbs.forEach((img, idx) => {
      img.classList.toggle('active', idx === currentIndex);
    });
  });
  document.getElementById('needExpress').addEventListener('change', function() {
    const proofInput = document.getElementById('deadlineTime');
    proofInput.disabled = this.value === '0';
    if(proofInput.disabled) proofInput.value = '';
  });

  document.getElementById('needProofing').addEventListener('change', function() {
    const proofInput = document.getElementById('proofQty');
    proofInput.disabled = this.value === '0';
    if(proofInput.disabled) proofInput.value = '';
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const basePrice       = parseFloat(document.getElementById('basePrice').value) || 0;
    const unit            = document.getElementById('unit').value;
    const finishingSelect = document.getElementById('finishingSelect');
    const needExpress     = document.getElementById('needExpress');
    const panjangInput    = document.getElementById('panjang');
    const lebarInput      = document.getElementById('lebar');
    const qtyInput        = document.getElementById('qty');
    const totalEl         = document.getElementById('totalHarga');

    function computeTotal() {
      // 1) Hitung HPL (Harga per Luas)
      let hpl = basePrice;
      if ((unit === 'cm' || unit === 'm') && panjangInput && lebarInput) {
        const l = parseFloat(panjangInput.value) || 0;
        const w = parseFloat(lebarInput.value) || 0;
        if (l > 0 && w > 0) {
          const areaInM2 = unit === 'cm'
            ? (l / 100) * (w / 100)
            : l * w;
          hpl = basePrice * areaInM2;
        }
      }

      // 2) Kalikan dengan qty
      const qty = parseInt(qtyInput.value) || 1;
      const subtotalHpl = hpl * qty;

      // 3) Finishing per item × qty
      const finishingPrice = finishingSelect
        ? parseFloat(finishingSelect.selectedOptions[0].dataset.price) || 0
        : 0;
      const subtotalFinishing = finishingPrice * qty;

      // 4) Jumlah sebelum express
      let total = subtotalHpl + subtotalFinishing;

      // 5) Tambah 50% kalau express = 1
      if (needExpress.value === '1') {
        total += total * 0.5;
      }

      totalEl.innerText = Math.round(total).toLocaleString();
    }

    if (finishingSelect) finishingSelect.addEventListener('change', computeTotal);
    needExpress.addEventListener('change', computeTotal);
    if (panjangInput) panjangInput.addEventListener('input', computeTotal);
    if (lebarInput) lebarInput.addEventListener('input', computeTotal);
    qtyInput.addEventListener('input', computeTotal);

    computeTotal();
  });
</script>

@endsection
