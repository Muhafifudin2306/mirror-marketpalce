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
            <a href="https://wa.me/6281952764747?text=Halo%20Admin%20Sinau%20Print%21%20Saya%20ingin%20mengajukan%20pertanyaan%20terkait%20produk%20yang%20ada%20di%20sinau%20print" target="_blank" class="btn-schedule">
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

<style>
  @media (max-width: 768px) {
      .cta-content {
          text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
          padding-left: 20px;
          padding-right: 20px;
      }
      
      .cta-content h3 {
          font-size: 2rem !important;
          line-height: 1.2;
      }
      
      .cta-content p {
          font-size: 0.9rem !important;
          line-height: 1.4;
      }
      
      .position-relative img {
          min-height: 250px;
          max-height: 350px;
          object-fit: cover;
      }
  }

  @media (max-width: 576px) {
      .cta-content {
          padding-left: 15px;
          padding-right: 15px;
      }
      
      .cta-content h3 {
          font-size: 1.5rem !important;
          line-height: 1.1;
      }
      
      .cta-content p {
          font-size: 0.8rem !important;
          line-height: 1.3;
      }
      
      .position-relative img {
          min-height: 200px;
          max-height: 280px;
      }
  }

  @media (max-width: 768px) {
      .container-lg {
          padding-left: 20px;
          padding-right: 20px;
      }
      
      .step-content {
          text-align: center;
          margin-top: 20px;
      }
      
      .step-number {
          font-size: 4rem !important;
          text-align: center;
          margin-bottom: 10px;
          position: static !important;
      }
      
      .step-title {
          font-size: 1.5rem !important;
          text-align: center;
          line-height: 1.2;
      }
      
      .step-desc {
          font-size: 0.9rem;
          text-align: center;
          line-height: 1.5;
          margin-top: 15px;
          color: #666;
      }
      
      .py-5 {
          padding-top: 2.5rem !important;
          padding-bottom: 2.5rem !important;
      }
      
      .mb-4 {
          margin-bottom: 1rem !important;
      }
  }

  @media (max-width: 576px) {
      .container-lg {
          padding-left: 15px;
          padding-right: 15px;
      }
      
      .step-number {
          font-size: 3rem !important;
      }
      
      .step-title {
          font-size: 1.2rem !important;
      }
      
      .step-desc {
          font-size: 0.85rem;
      }
      
      .py-5 {
          padding-top: 2rem !important;
          padding-bottom: 2rem !important;
      }
  }

  @media (max-width: 768px) {
      .btn-schedule {
          display: inline-flex;
          align-items: center;
          background: none;
          color: #fff;
          text-decoration: none;
          padding: 10px 20px;
          border-radius: 25px;
          font-family: 'Poppins';
          font-weight: 600;
          font-size: 0.8rem;
          letter-spacing: 0.5px;
          transition: all 0.3s ease;
          overflow: hidden;
          position: relative;
          margin: 5px;
          border: 2px solid rgba(255, 255, 255, 0.3);
      }
      
      .btn-schedule:hover {
          background: #fff;
          color: #333;
          transform: translateY(-2px);
          text-decoration: none;
      }
  }

  @media (max-width: 576px) {
      .btn-schedule {
          padding: 8px 16px;
          font-size: 0.75rem;
          margin: 3px;
      }
      
      .btn-schedule .btn-text {
          font-size: 0.7rem;
      }
  }

  @media (min-width: 769px) {
      .step-number {
          position: absolute;
          font-size: 8rem;
          font-weight: 900;
          z-index: -1;
          top: -20px;
      }
      
      .step-title {
          font-family: 'Poppins';
          font-size: 2.5rem;
          font-weight: 600;
          line-height: 1.1;
          margin-bottom: 20px;
      }
      
      .step-desc {
          font-family: 'Poppins';
          font-size: 1rem;
          color: #666;
          line-height: 1.6;
      }
      
      .btn-schedule {
          display: inline-flex;
          align-items: center;
          background: none;
          color: #fff;
          text-decoration: none;
          padding: 12px 24px;
          border-radius: 30px;
          font-family: 'Poppins';
          font-weight: 600;
          font-size: 0.9rem;
          letter-spacing: 0.5px;
          transition: all 0.3s ease;
          overflow: hidden;
          position: relative;
          margin: 10px;
          border: 2px solid rgba(255, 255, 255, 0.3);
      }
      
      .btn-schedule:hover {
          background: #fff;
          color: #333;
          transform: translateY(-2px);
          text-decoration: none;
      }
  }

  .btn-text {
      transition: transform 0.3s ease;
  }

  .btn-arrow {
      margin-left: 10px;
      transition: transform 0.3s ease;
      position: relative;
      width: 20px;
      height: 20px;
      overflow: hidden;
  }

  .btn-arrow .arrow-out {
      transition: transform 0.3s ease;
      position: absolute;
      top: 0;
      left: 0;
  }

  .btn-arrow .arrow-in {
      transition: transform 0.3s ease;
      position: absolute;
      top: 0;
      left: 20px;
  }

  .btn-schedule:hover .btn-arrow .arrow-out {
      transform: translateX(-20px);
  }

  .btn-schedule:hover .btn-arrow .arrow-in {
      transform: translateX(-20px);
  }
</style>
@endsection
