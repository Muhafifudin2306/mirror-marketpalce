@extends('landingpage.index')
@section('content')
<style>
  .btn-primary {
  background-color: #0258d3;
  color: #fff;
  padding: 13px 20px;
  font-size: 1rem;
  border: none;
  border-radius: 50px;
  font-weight: 500;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  transition: background-color 0.2s ease;
}
.btn-primary:hover {
  background-color: #0041a8;
  color: #fff;
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

.btn-outline-danger {
  border: 1px solid #fc2865;
  color: #fc2865;
  background: transparent;
}
.btn-outline-danger:hover {
  background: #fc2865;
  color: #fff;
}

.btn-outline-primary {
  border: 1px solid #0258d3;
  color: #0258d3;
  background: transparent;
}
.btn-outline-primary:hover {
  background: #0258d3;
  color: #fff;
}

/* Cart Item Listing Styles */
.cart-item {
  display: flex;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-bottom: 1.5rem;
  overflow: hidden;
  position: relative;
}
.cart-item img {
  margin-top: 10px;
  margin-left: 15px;
  width: 210px;
  height: 210px;
  object-fit: cover;
  border-radius: 8px;
}
.cart-item-body {
  flex: 1;
  padding: 1rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.cart-item-body h5 {
  font-family: 'Poppins';
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}
.cart-item-body .details {
  font-size: 0.85rem;
  color: #555;
  margin-bottom: 1rem;
  list-style: none;
  padding: 0;
}
.cart-item-body .details li {
  margin-bottom: 0.25rem;
  color: #777;
}
.cart-item-actions {
  display: flex;
  gap: 0.5rem;
  margin-top: 0.5rem;
}
.cart-item-actions .btn {
  font-family: 'Poppins', sans-serif;
  font-size: 0.85rem;
  border-radius: 50px;
  padding: 0.4rem 0.8rem;
  display: inline-flex;
  align-items: center;
  gap: 0.25rem;
}
.qty-input {
  width: 60px;
  padding: 0.3rem;
  font-size: 0.85rem;
  border-radius: 8px;
  border: 1px solid #ccc;
}

/* Summary Card */
.summary-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  padding: 1rem;
  border-left: 4px solid #0258d3;
  position: sticky;
  top: 150px;
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

      {{-- Items --}}
      <div class="col-lg-8">
        @if($items->isEmpty())
          <div class="alert alert-info">
            Keranjang kamu masih kosong. <a href="{{ url('/products') }}">Belanja sekarang!</a>
          </div>
        @else
          @foreach($items as $item)
            <div class="cart-item">
              <div class="flex-shrink-0">
                  @php
                      $image = $item->product->images->first();
                  @endphp
                  @if($image && $image->image_product && file_exists(storage_path('app/public/' . $image->image_product)))
                      <img src="{{ asset('storage/' . $image->image_product) }}" alt="Produk">
                  @else
                      <img src="{{ asset('landingpage/img/nophoto.png') }}" alt="Produk">
                  @endif
              </div>
              <div class="cart-item-body">
                <div>
                  <h5>{{ $item->product->label->name }} - {{ $item->product->name }}</h5>
                  <ul class="details">
                    @if(in_array($item->product->additional_unit, ['cm','m']))
                      <li>Ukuran: {{ intval($item->length) }}x{{ intval($item->width) }} {{ $item->product->additional_unit }}</li>
                    @else
                      <li>Ukuran: {{ intval($item->product->additional_size) }} {{ $item->product->additional_unit }}</li>
                    @endif
                    <li>File desain: 
                      @if($item->order->order_design)
                        <a href="{{ asset('landingpage/img/design/'.$item->order->order_design) }}" target="_blank" style="font-family: 'Poppins'; font-size:0.8rem; font-weight:400; color:#0258d3;">{{ $item->order->order_design }}</a>
                      @else-
                      @endif
                    </li>
                    <li>Catatan: {{ $item->order->notes ?? '-' }}</li>
                    <li>Jumlah: <input type="number" class="qty-input" data-id="{{ $item->id }}" value="{{ $item->qty }}" min="1"></li>
                  </ul>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="cart-item-actions">
                    <a href="{{ route('order-product.edit', $item) }}" class="btn btn-outline-primary btn-sm">
                      <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('cart.remove', $item) }}" method="POST" style="display:inline">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-trash"></i> Hapus
                      </button>
                    </form>
                    <form action="{{ route('checkout.item', $item->id) }}" method="POST">
                      @csrf
                      <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-bag-check"></i> Checkout
                      </button>
                    </form>
                  </div>
                  <div>
                    <span style="font-family:'Poppins'; font-size:0.9rem; color:#555;">Subtotal:</span>
                    <strong style="font-family:'Poppins'; font-size:1rem;">Rp {{ number_format($item->subtotal,0,',','.') }}</strong>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

      {{-- Summary --}}
      <div class="col-lg-4">
        <div class="p-4 border shadow-sm bg-white text-center summary-card" style="border-radius:16px;">
          <div class="mb-3">
            <span style="font-family:'Poppins'; font-size:1rem; font-weight:500; color:#888;">Subtotal Keranjang</span>
            <div>
              <strong style="font-family:'Poppins'; font-size:2.4rem; font-weight:600; color:#000;">
                Rp {{ number_format($subtotal,0,',','.') }}
              </strong>
            </div>
          </div>
          <small style="color:#555; font-size:0.85rem;">Gunakan tombol Checkout di setiap produk</small>
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
      <h3 class="mb-0" style="font-family:'Poppins'; font-size:3rem; font-weight:600; color:#fff;">
        Masih Bingung Cari Apa?
      </h3>
      <h3 class="mb-8" style="font-family:'Poppins'; font-size:3rem; font-weight:600; color:#ffc74c;">
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
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.qty-input').forEach(input => {
      if (!input.dataset.origQty) {
        input.dataset.origQty = input.defaultValue;
        const subtotalEl = input.closest('.cart-item').querySelector('strong');
        input.dataset.origSubtotal = subtotalEl.innerText.replace(/[^\d]/g, '');
      }

      input.addEventListener('change', function () {
        const itemId       = this.dataset.id;
        const newQty       = parseInt(this.value, 10);
        const origQty      = parseInt(this.dataset.origQty, 10);
        const origSubtotal = parseInt(this.dataset.origSubtotal, 10);

        const pricePerUnit = origSubtotal / origQty;
        const newSubtotal  = Math.round(pricePerUnit * newQty);

        const subtotalEl = this.closest('.cart-item').querySelector('strong');
        subtotalEl.innerText = 'Rp ' + newSubtotal.toLocaleString();

        fetch(`/keranjang/itemqty/${itemId}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          body: JSON.stringify({ qty: newQty })
        })
        .then(res => res.json())
        .then(data => {
          if (!data.success) {
            alert('Gagal update qty');
            return;
          }
          document.getElementById('cart-summary').innerText =
            'Rp ' + parseInt(data.newCartSubtotal,10).toLocaleString();
        });
      });
    });
  });
</script>
@endsection
