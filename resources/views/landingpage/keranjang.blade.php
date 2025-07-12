@extends('landingpage.index')
@section('content')
<style>
  .btn-primary {
    background-color: #0258d3;
    color: #fff;
    padding: 10px 16px;
    font-size: 0.85rem;
    border: none;
    border-radius: 40px;
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
    font-size: 0.75rem;
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
    padding: 8px 12px;
    font-size: 0.75rem;
    border-radius: 40px;
    font-family: 'Poppins', sans-serif;
  }
  .btn-outline-danger:hover {
    background: #fc2865;
    color: #fff;
  }

  .btn-outline-primary {
    border: 1px solid #0258d3;
    color: #0258d3;
    background: transparent;
    padding: 8px 12px;
    font-size: 0.75rem;
    border-radius: 40px;
    font-family: 'Poppins', sans-serif;
  }
  .btn-outline-primary:hover {
    background: #0258d3;
    color: #fff;
  }

  .cart-item {
    display: flex;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    margin-bottom: 1.2rem;
    overflow: hidden;
    position: relative;
  }
  main .cart-item img {
    margin-top: 8px;
    margin-left: 12px;
    width: 168px;
    height: 168px;
    object-fit: cover;
    border-radius: 6px;
  }
  .cart-item-body {
    flex: 1;
    padding: 0.8rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .cart-item-body h5 {
    font-family: 'Poppins', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.4rem;
    line-height: 1.3;
  }
  .cart-item-body .details {
    font-size: 0.75rem;
    color: #555;
    margin-bottom: 0.8rem;
    list-style: none;
    padding: 0;
    font-family: 'Poppins', sans-serif;
  }
  .cart-item-body .details li {
    margin-bottom: 0.2rem;
    color: #777;
    line-height: 1.4;
  }
  .cart-item-actions {
    display: flex;
    gap: 0.4rem;
    margin-top: 0.4rem;
    flex-wrap: wrap;
  }
  .cart-item-actions .btn {
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    border-radius: 40px;
    padding: 0.3rem 0.6rem;
    display: inline-flex;
    align-items: center;
    gap: 0.2rem;
  }
  .qty-input {
    width: 50px;
    padding: 0.25rem;
    font-size: 0.75rem;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-family: 'Poppins', sans-serif;
  }

  .summary-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    padding: 0.8rem;
    position: sticky;
    top: 120px;
  }

  .cart-header {
    font-family: 'Poppins', sans-serif;
    font-size: 2.8rem;
    font-weight: 550;
    color: #fff;
    margin-bottom: 0.8rem;
  }

  .subtotal-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    color: #888;
  }
  .subtotal-amount {
    font-family: 'Poppins', sans-serif;
    font-size: 1.9rem;
    font-weight: 600;
    color: #000;
  }
  .subtotal-item {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    color: #555;
  }
  .subtotal-item strong {
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
  }

  .cta-title {
    font-family: 'Poppins', sans-serif;
    font-size: 2.4rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 0;
  }
  .cta-subtitle {
    font-family: 'Poppins', sans-serif;
    font-size: 2.4rem;
    font-weight: 600;
    color: #ffc74c;
    margin-bottom: 1.5rem;
  }

  .file-link {
    font-family: 'Poppins', sans-serif;
    font-size: 0.7rem;
    font-weight: 400;
    color: #0258d3;
    text-decoration: none;
  }
  .file-link:hover {
    text-decoration: underline;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .cart-item {
      flex-direction: column;
    }
    .cart-item img {
      width: 100%;
      height: 200px;
      margin: 0;
      border-radius: 10px 10px 0 0;
    }
    .cart-item-body {
      padding: 1rem;
    }
    .cart-header {
      font-size: 2.2rem;
    }
    .subtotal-amount {
      font-size: 1.6rem;
    }
    .cta-title, .cta-subtitle {
      font-size: 2rem;
    }
    .cart-item-actions {
      justify-content: center;
    }
    .summary-card {
      position: static;
      margin-top: 1rem;
    }
  }

  @media (max-width: 576px) {
    .cart-item img {
      width: calc(100% - 24px);
      margin: 12px;
      height: 180px;
    }
    .cart-item-body h5 {
      font-size: 0.9rem;
    }
    .cart-item-actions .btn {
      font-size: 0.7rem;
      padding: 0.25rem 0.5rem;
    }
  }
</style>

<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%;">
      <h3 class="cart-header">
        Keranjang <span style="color:#ffc74c;">Belanjamu</span>
      </h3>
    </div>
  </div>
</div>

<main class="container-fluid px-4">
  <div class="container product-card" style="margin-top:-144px;">
    <div class="row g-4">
      <div class="col-lg-8">
        @if($items->isEmpty())
          <div class="alert alert-info" style="font-family: 'Poppins', sans-serif; font-size: 0.85rem;">
            Keranjang kamu masih kosong. <a href="{{ url('/products') }}" style="color: #0258d3;">Belanja sekarang!</a>
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
                  <h5>
                    {{ Str::limit($item->product->name, 30) }}
                    @if($item->product->additional_size && $item->product->additional_unit)
                        {{ $item->product->additional_size }} {{ $item->product->additional_unit }}
                    @endif
                  </h5>
                  <ul class="details">
                    @if(in_array($item->product->additional_unit, ['cm','m']))
                      <li>Ukuran: {{ intval($item->length) }}x{{ intval($item->width) }} {{ $item->product->additional_unit }}</li>
                    @else
                      <li>Ukuran: {{ intval($item->product->additional_size) }} {{ $item->product->additional_unit }}</li>
                    @endif
                    <li>File desain: 
                      @if($item->order->order_design)
                        <a href="{{ asset('landingpage/img/design/'.$item->order->order_design) }}" target="_blank" class="file-link">{{ $item->order->order_design }}</a>
                      @else
                        -
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
                    <form action="{{ route('checkout.item', $item->id) }}" method="POST" style="display:inline">
                      @csrf
                      <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-bag-check"></i> Checkout
                      </button>
                    </form>
                  </div>
                  <div>
                    <span class="subtotal-item">Subtotal:</span>
                    <strong class="subtotal-item">Rp {{ number_format($item->subtotal,0,',','.') }}</strong>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>

      <div class="col-lg-4">
        <div class="summary-card text-center" style="border-radius:12px;">
          <div class="mb-3">
            <span class="subtotal-label">Subtotal Keranjang</span>
            <div>
              <strong class="subtotal-amount" id="cart-summary">
                Rp {{ number_format($subtotal,0,',','.') }}
              </strong>
            </div>
          </div>
          <small style="color:#555; font-size:0.75rem; font-family: 'Poppins', sans-serif;">Gunakan tombol Checkout di setiap produk</small>
        </div>
      </div>

    </div>
  </div>
</main>

{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
    <div class="position-absolute top-50 start-0 translate-middle-y cta-content" style="padding-left: 2.4rem;">
      <h3 class="cta-title">
        Masih Bingung Cari Apa?
      </h3>
      <h3 class="cta-subtitle">
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