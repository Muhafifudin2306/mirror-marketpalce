@extends('landingpage.index')
@section('content')
<br><br><br><br>

<div class="container-fluid px-3">
  <div class="position-relative mb-5">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/cara_pesan.png') }}" alt="CTA Image">
    <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
      <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Cara Pesan Online</h3>
      <h3 class="mb-8" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;">di Sinau Print</h3>
      <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">Pesan dan cetak kebutuhanmu dari jauh secara online</p>
      <p class="mb-0" style="font-family: 'Poppins'; font-size:1.1rem; font-weight:350; color:#fff;">tinggal kirim langsung jadi!</p>
    </div>
  </div>
</div>

<div class="container-lg py-5">
  <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="{{ asset('landingpage/img/cara_pesan1.png') }}"
           alt="Step 1"
           class="img-fluid rounded-3">
    </div>
    <div class="col-md-6 position-relative">
      <div class="step-content">
        <div class="step-number start-0" style="color:#dbdbdb; font-weight:500;">01</div>
        <h4 class="step-title" style="color:black; margin-bottom: 0 !important;">Pilih produk</h4>
        <h4 class="step-title" style="color:black; margin-top: 0 !important; margin-bottom: 0 !important;">&amp; sesuaikan</h4>
        <h4 class="step-title" style="color:#0258d3; margin-top: 0 !important;">kebutuhanmu</h4>
        <p class="step-desc">
          Jelajahi katalog kami dan pilih jenis cetakan yang kamu butuhkan; mulai dari brosur, banner, hingga kartu nama. Atur spesifikasi seperti ukuran, bahan, dan jumlah sesuai keinginanmu.
        </p>
      </div>
    </div>
  </div>
</div>
<div class="container-lg py-5">
  <div class="row align-items-center flex-md-row-reverse">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="{{ asset('landingpage/img/cara_pesan2.png') }}"
           alt="Step 2"
           class="img-fluid rounded-3">
    </div>
    <div class="col-md-6 position-relative">
      <div class="step-content">
        <div class="step-number start-0" style="color:#dbdbdb;">02</div>
        <h4 class="step-title" style="color:black; margin-bottom:0;">Upload Desain atau</h4>
        <h4 class="step-title" style="color:#0258d3; margin:0;">Konsultasi Dulu sama</h4>
        <h4 class="step-title" style="color:#0258d3; margin-top:0;">Admin</h4>
        <p class="step-desc">
          Sudah punya desain sendiri? Ikuti panduan upload kami agar hasil cetak tetap optimal. Gak sempat bikin desain? Tenang, langsung chat admin kami aja untuk konsultasi gratis!
        </p>
      </div>
    </div>
  </div>
</div>
<div class="container-lg py-5">
  <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="{{ asset('landingpage/img/cara_pesan3.png') }}"
           alt="Step 3"
           class="img-fluid rounded-3">
    </div>
    <div class="col-md-6 position-relative">
      <div class="step-content">
        <div class="step-number start-0" style="color:#dbdbdb; font-weight:500;">03</div>
        <h4 class="step-title" style="color:black; margin-bottom: 0 !important;">Tambah ke Keranjang</h4>
        <h4 class="step-title" style="color:#0258d3; margin-top: 0 !important;">&amp; Lanjut Checkout</h4>
        <p class="step-desc">
          Setelah semuanya sesuai, klik "<b>Tambah ke Keranjang</b>", lalu lanjut ke halaman <b>Checkout</b>. Di sini, kamu tinggal isi data pengiriman dan metode pembayaran.
        </p>
      </div>
    </div>
  </div>
</div>
<div class="container-lg py-5">
  <div class="row align-items-center flex-md-row-reverse">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="{{ asset('landingpage/img/cara_pesan4.png') }}"
           alt="Step 4"
           class="img-fluid rounded-3">
    </div>
    <div class="col-md-6 position-relative">
      <div class="step-content">
        <div class="step-number start-0" style="color:#dbdbdb;">04</div>
        <h4 class="step-title" style="color:black; margin-bottom:0;">Tunggu Konfirmasi</h4>
        <h4 class="step-title" style="color:#0258d3; margin:0;">dan Pesanan Diproses</h4>
        <p class="step-desc">
          Setelah pembayaran berhasil, tim kami akan mengonfirmasi pesananmu dan mulai proses cetak. Kamu akan menerima notifikasi saat barangmu dikirim
        </p>
      </div>
    </div>
  </div>
</div>
{{-- CTA Section --}}
<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#fff;">Udah Paham Cara Pesan?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:3rem; font-weight:600; color:#ffc74c;">Gas Order Sekarang!</h3>
            <a href="{{ url('/products') }}" class="btn-schedule">
            <span class="btn-text">KONSULTASI DULU</span>
            <a href="{{ url('/products') }}" class="btn-schedule">
            <span class="btn-text">SEMUA PRODUK</span>
            <span class="btn-arrow">
                <i class="bi bi-arrow-right arrow-out"></i>
                <i class="bi bi-arrow-right arrow-in"></i>
            </span>
            </a>
        </div>
    </div>
</div>
@endsection
