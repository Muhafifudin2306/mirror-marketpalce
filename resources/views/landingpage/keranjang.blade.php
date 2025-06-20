@extends('landingpage.index')
@section('content')
<style>
  .btn-primary {
      background-color: #0258d3;
      color: white;
      padding: 13px 14px;
      font-size: 16px;
      margin-top: 24px;
      border: none;
      border-radius: 50px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.2s ease;
      font-family: 'Poppins', sans-serif;
  }

  .btn-primary:hover {
      background-color: #0258d3;
      color: white;
  }

  .card-action {
  position: absolute;
  bottom: 12px;
  right: 16px;
  display: flex;
  gap: 10px;
}

.card-relative {
  position: relative;
}

.card-action {
  position: absolute;
  bottom: 12px;
  right: 16px;
  display: flex;
  gap: 10px;
}

.btn-link-style {
  border: none;
  background: none;
  padding: 0;
  font-size: 0.85rem;
  font-family: 'Poppins', sans-serif;
  font-weight: 550;
  color: #444444;
  text-decoration: none;
  cursor: pointer;
}

.btn-link-style.danger {
  color: #fc2865;
}

</style>
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%;">
      <h3 class="mb-2" style="font-family: 'Poppins'; font-size:3.5rem; font-weight:550; color:#fff;">
        Keranjang <span style="color:#ffc74c;">Belanjamu</span>
      </h3>
    </div>
  </div>
</div>

<main class="container-fluid px-4">
  <div class="container product-card" style="margin-top:-180px;">
    <div class="row g-5">

      {{-- Left: Cart Items --}}
      <div class="col-lg-7" style="margin-right: 20px;">
        @if($items->isEmpty())
          <div class="alert alert-info">
            Keranjang kamu masih kosong. <a href="{{ url('/products') }}">Belanja sekarang!</a>
          </div>
        @else
          @foreach($items as $item)
            <div class="d-flex mb-4 p-3 bg-white align-items-start card-relative" style="gap: 20px;">
              {{-- Gambar Produk (30%) --}}
              <div style="flex: 0 0 28%;">
                <img src="{{ $item->product->images->first()
                          ? asset('landingpage/img/product/'.$item->product->images->first()->image_product)
                          : asset('landingpage/img/nophoto.png') }}"
                    alt="Produk"
                    class="rounded"
                    style="width:100%; aspect-ratio: 1/1; object-fit:cover; border-radius:10px !important;">
              </div>

              {{-- Deskripsi Produk (70%) --}}
              <div class="d-flex flex-column justify-content-between" style="flex: 1;">
                <div>
                  <h5 style="font-family:'Poppins'; font-size:1.2rem; font-weight:600; margin-bottom:10px;">
                    {{ $item->product->label->name }} - {{ $item->product->name }}
                  </h5>

                  {{-- Ukuran, File, Catatan --}}
                  <ul class="list-unstyled mb-2" style="font-size: 0.85rem; color:#555;">
                    <li class="title" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:500; color:#888888;">Ukuran: {{ intval($item->product->long_product) }}x{{ intval($item->product->width_product) }} {{ $item->product->additional_unit }}</li>
                    <li class="title" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:500; color:#888888;">File desain: 
                      @if($item->order->order_design)
                        <a style="font-size: 0.8rem; color:#0258d3;" href="{{ asset('landingpage/img/design/'.$item->order->order_design) }}" target="_blank">{{ $item->order->order_design }}</a>
                      @else
                        Tidak ada
                      @endif
                    </li>
                    <li style="font-family: 'Poppins'; font-size:0.8rem; font-weight:500; color:#888888;">Catatan: {{ $item->order->notes ?? '-' }}</li>
                    <li style="font-family: 'Poppins'; font-size:0.8rem; font-weight:500; color:#888888;margin-top:15px !important;">
                      <label class="mb-0">Jumlah</label>
                    </li>
                    <li>
                      <input type="number"
                          class="form-control qty-input"
                          data-id="{{ $item->id }}"
                          value="{{ $item->qty }}"
                          min="1"
                          style="width:80px;height:30px;font-family: 'Poppins'; font-size:0.8rem; font-weight:500; color:#000;">
                    </li>
                  </ul>
                  <div class="card-action">
                    <a href="{{ route('landingpage.produk_detail', $item->product->slug) }}" class="btn-link-style">
                      <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('cart.remove', $item) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-link-style danger">
                        <i class="bi bi-trash"></i> Hapus
                      </button>
                    </form>
                  </div>

                </div>
              </div>
            </div>
          @endforeach

        @endif
      </div>

      {{-- Right: Summary --}}
      <div class="col-lg-4">
        <div class="p-4 border shadow-sm bg-white text-center" style="border-radius: 16px;">
          <div class="mb-3">
            <span style="font-family: 'Poppins'; font-size:1rem; font-weight:500; color:#888888;">Subtotal</span>
            <div>
              <strong style="font-family: 'Poppins'; font-size:2.4rem; font-weight:600; color:#000;">
                Rp {{ number_format($subtotal,0,',','.') }}
              </strong>
            </div>
          </div>

          <a href="{{ route('checkout') }}"
             class="btn btn-primary w-100"
             style="height:50px; border-radius:50px; font-family:'Poppins'; font-weight:600;">
            CHECKOUT
          </a>
        </div>
      </div>

    </div>
  </div>
</main>

{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
    <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
      <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#fff;">
        Masih Bingung Cari Apa?
      </h3>
      <h3 class="mb-8" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#ffc74c;">
        Boleh Tanya Dulu!
      </h3>
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
<script>
document.querySelectorAll('.qty-input').forEach(input => {
  input.addEventListener('change', function () {
    const itemId = this.dataset.id;
    const newQty = this.value;

    fetch(`/cart/${itemId}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({ qty: newQty })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload(); // reload halaman agar subtotal ikut update
      } else {
        alert('Gagal update qty');
      }
    });
  });
});
</script>

@endsection
