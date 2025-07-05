@extends('landingpage.index')
@section('content')
<style>
  .thumb-container {
    max-width: 100%;
    padding-left: 20px;
  }
  .thumb-img {
    border: 2px solid transparent;
    transition: border-color .2s;
    margin-left: 10px;
  }
  .thumb-img.active {
    border-color: #0d6efd;
  }
  .thumb-img:first-child {
    margin-left: 110px;
  }
  .sticky-left {
    position: sticky;
    top: 120px;
    z-index: 10;
  }
  .form-label {
    font-family: 'Poppins';
    font-size:0.8rem;
    font-weight:350 !important;
    color:#000000;
  }
  .order-status {
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.8rem;
    text-align: center;
    display: inline-block;
  }
  .status-pending { background-color: #fff3cd; color: #856404; }
  .status-paid { background-color: #d1ecf1; color: #0c5460; }
  .status-processing { background-color: #d4edda; color: #155724; }
  .status-completed { background-color: #d1ecf1; color: #0c5460; }
  .status-cancelled { background-color: #f8d7da; color: #721c24; }
</style>

<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%;">
      <h3 class="mb-2" style="font-family: 'Poppins'; font-size:3.5rem; font-weight:550; color:#fff;">
        Detail Order - {{ 'INV' . substr($order->spk, 3, strpos($order->spk, '-') - 3) }}
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:500; text-transform: uppercase;">
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
  <div class="container-fluid px-4">
    <div class="container product-card">
      <div class="row g-5">
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
            <div class="d-flex mt-3 thumb-container" style="justify-content: start; padding-left: 15px;">
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

        <!-- Order Details -->
        <div class="col-lg-5">
          <!-- Order Info Card -->
          <div class="card mb-4" style="border-radius: 15px; border: 1px solid #e0e0e0;">
            <div class="card-header" style="background-color: #f8f9fa; border-radius: 15px 15px 0 0;">
              <h5 class="mb-0" style="font-family: 'Poppins'; font-weight: 600;">Informasi Order</h5>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-4"><strong>Invoice:</strong></div>
                <div class="col-8">{{ 'INV' . substr($order->spk, 3, strpos($order->spk, '-') - 3) }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-4"><strong>Status:</strong></div>
                <div class="col-8">
                  <span class="badge" style="display: inline-block; padding: 8px 16px; font-size: 0.75rem !important; background-color: {{ $badge }}; color: {{ $foncol }} !important; font-family: 'Poppins', sans-serif; border-radius: 4px; font-weight: 450 !important;">
                    {{ $firlabel }} <br> {{ $seclabel }}
                  </span>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-4"><strong>Tanggal:</strong></div>
                <div class="col-8">{{ $order->created_at->format('d M Y H:i') }}</div>
              </div>
              @if($order->waktu_deadline)
              <div class="row mb-2">
                <div class="col-4"><strong>Deadline:</strong></div>
                <div class="col-8">{{ $order->waktu_deadline }}</div>
              </div>
              @endif
            </div>
          </div>

          <!-- Product Details dari Order Data -->
          <div class="mb-3">
            <label class="form-label"><b>BAHAN</b></label>
            <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
              {{ $orderProduct->material_type ?? $product->name }}
            </div>
          </div>

          @if($orderProduct->finishing_type)
          <div class="mb-3">
            <label class="form-label"><b>FINISHING</b></label>
            <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
              {{ $orderProduct->finishing_type }}
            </div>
          </div>
          @endif

          <div class="row g-2 mb-3">
            <div class="col">
              <label class="form-label"><b>KEBUTUHAN EXPRESS</b></label>
              <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
                {{ $order->express ? 'Ya' : 'Tidak' }}
              </div>
            </div>
            @if($order->waktu_deadline)
            <div class="col">
              <label class="form-label"><b>DEADLINE JAM</b></label>
              <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
                {{ $order->waktu_deadline }}
              </div>
            </div>
            @endif
          </div>

          <div class="row g-2 mb-3">
            <div class="col">
              <label class="form-label"><b>KEBUTUHAN PROOFING</b></label>
              <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
                {{ $order->kebutuhan_proofing ? 'Ya' : 'Tidak' }}
              </div>
            </div>
            @if($order->proof_qty)
            <div class="col">
              <label class="form-label"><b>QTY PROOFING</b></label>
              <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
                {{ $order->proof_qty }}
              </div>
            </div>
            @endif
          </div>

          <!-- Design Files -->
          @if($order->order_design || $order->preview_design)
          <div class="row g-2 mb-3">
            @if($order->order_design)
            <div class="col">
              <label class="form-label"><b>FILE DESAIN</b></label>
              <div class="d-flex align-items-center" style="padding: 12px 20px; background-color:#f8f9fa; border-radius:15px;">
                <i class="bi bi-file-earmark" style="margin-right:10px; font-size:1.2rem;"></i>
                <a href="{{ asset('storage/landingpage/img/order_design/' . $order->order_design) }}" 
                   target="_blank" class="text-decoration-none">
                  {{ $order->order_design }}
                </a>
              </div>
            </div>
            @endif
            @if($order->preview_design)
            <div class="col">
              <label class="form-label"><b>PREVIEW DESAIN</b></label>
              <div class="d-flex align-items-center" style="padding: 12px 20px; background-color:#f8f9fa; border-radius:15px;">
                <i class="bi bi-file-earmark-image" style="margin-right:10px; font-size:1.2rem;"></i>
                <a href="{{ asset('storage/landingpage/img/order_design/' . $order->preview_design) }}" 
                   target="_blank" class="text-decoration-none">
                  {{ $order->preview_design }}
                </a>
              </div>
            </div>
            @endif
          </div>
          @endif

          <!-- Dimensions -->
          @if($orderProduct->length && $orderProduct->width)
          <div class="row g-2 mb-3">
            <div class="col">
              <label class="form-label"><b>PANJANG ({{ strtoupper($product->additional_unit) }})</b></label>
              <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
                {{ $orderProduct->length }} {{ $product->additional_unit }}
              </div>
            </div>
            <div class="col">
              <label class="form-label"><b>LEBAR ({{ strtoupper($product->additional_unit) }})</b></label>
              <div class="form-control" style="height:50px; border-radius:70px; display:flex; align-items:center; background-color:#f8f9fa;">
                {{ $orderProduct->width }} {{ $product->additional_unit }}
              </div>
            </div>
          </div>
          @endif

          <!-- Notes -->
          @if($order->notes)
          <div class="mb-3">
            <label class="form-label"><b>CATATAN</b></label>
            <div class="form-control" style="min-height:100px; border-radius:15px; background-color:#f8f9fa; padding:15px;">
              {{ $order->notes }}
            </div>
          </div>
          @endif

          <!-- Quantity -->
          <div class="row mb-3">
            <div class="col-auto">
              <label class="form-label"><b>QTY</b></label>
              <div class="form-control" style="width:150px; height:50px; border-radius:70px; display:flex; align-items:center; justify-content:center; background-color:#f8f9fa;">
                {{ $orderProduct->qty }}
              </div>
            </div>
            <div class="col-auto d-flex align-items-end">
              @if($order->order_status == 0)
                <a href="{{ route('checkout.order', $order->id) }}" 
                   class="btn btn-primary me-2" 
                   style="border-radius:50px; width:150px; height:50px; font-weight:600; font-family:'Poppins', sans-serif; display:flex; align-items:center; justify-content:center;">
                  BAYAR
                </a>
                <button type="button" 
                        class="btn btn-danger" 
                        style="border-radius:50px; width:150px; height:50px; font-weight:600; font-family:'Poppins', sans-serif;"
                        onclick="cancelOrder({{ $order->id }})">
                  BATALKAN
                </button>
              @endif
            </div>
          </div>

          <!-- Total Price -->
          <div style="border:1px solid #ccc; border-radius:15px; padding:20px 30px; display:flex; justify-content:space-between; align-items:center;">
            <div style="font-family:'Poppins'; font-size:0.9rem; color:#888; font-weight:500;">Total Harga</div>
            <div style="font-family:'Poppins'; font-size:2.2rem; font-weight:600; color:#0439a0;">
              Rp {{ number_format($order->subtotal, 0, ',', '.') }}
            </div>
          </div>

          <!-- Product Information -->
          <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between w-100 border-0 bg-transparent pb-2 mb-2 border-bottom" 
                 style="font-family:'Poppins'; font-weight:500; font-size:1rem; cursor:pointer; border-color:#ccc !important;" 
                 data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
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
      <img class="w-100 rounded" style="max-height:600px" src="{{ asset('landingpage/img/login_register_bg.png') }}" alt="Background"/>
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
                          <img src="{{ asset('landingpage/img/discount_logo.png') }}" alt="Diskon" class="discount-logo" style="width:18px; height:auto;">
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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