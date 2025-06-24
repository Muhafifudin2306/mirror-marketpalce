@extends('adminpage.index')
@section('content')
@if(Auth::user()->role!='Customer')
<main>
  <div class="container-fluid px-4">
    <h2 class="mt-4">Detail Pesanan</h2>
    <div class="card mb-4">
      <div class="card-body">
        <h5>SPK</h5>
        <p>{{ $order->spk }}</p>
        <h5>Pelanggan</h5>
        <p>{{ $order->user_name }}</p>
        <h5>Status Pesanan</h5>
        <p>{{ $order->order_status }}</p>
        <h5>Status Bayar</h5>
        <p>{{ $order->payment_status }}</p>
        <h5>Subtotal</h5>
        <p>{{ number_format($order->subtotal,0,',','.') }}</p>
        <h5>Items</h5>
        <ul>
          @foreach($items as $item)
          <li>Produk ID: {{ $item->product_id }} | Qty: {{ $item->qty }} | Subtotal: {{ number_format($item->subtotal,0,',','.') }}</li>
          @endforeach
        </ul>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif
@endsection
