<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">

        <div class="mb-5"></div>

        <div class="row g-5">
            <div class="col-lg-6 col-md-6 text-center text-md-start">
                <img src="{{ asset('landingpage/img/footer_logo.png') }}" alt="Logo" style="max-width:100%;">
                <div class="d-flex mt-3 gap-3">
                    @foreach(['instagram','facebook-f','tiktok','linkedin'] as $social)
                        <a href="#" class="d-inline-flex align-items-center justify-content-center"
                           style="width:60px; height:60px; border:1px solid; border-radius:50%;">
                            <i class="fab fa-{{ $social }}"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <br><br><br><br><br>
                <h5 class="mb-3 text-uppercase" style="letter-spacing:1px; font-family: 'Poppins', sans-serif;">Company</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none">Tentang Sinau</a></li>
                    <li><a href="#" class="text-decoration-none">Hubungi Kami</a></li>
                </ul>

                <br><br>
                <h5 class="mt-4 mb-3 text-uppercase" style="letter-spacing:1px; font-family: 'Poppins', sans-serif;">Bisnis</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-decoration-none">Semua Produk</a></li>
                    <li><a href="#" class="text-decoration-none">Cara Pesan</a></li>
                    <li><a href="#" class="text-decoration-none">Konsultasi</a></li>
                    <li><a href="#" class="text-decoration-none">Artikel</a></li>
                    <li><a href="#" class="text-decoration-none">FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <br><br><br><br><br>
                <h5 class="mb-3 text-uppercase" style="letter-spacing:1px; font-family: 'Poppins', sans-serif;">Kontak</h5>
                <p class="mb-1"><i class="fa fa-phone-alt me-2"></i>0819 5276 4747</p>
                <p class="mb-4"><i class="fa fa-envelope me-2"></i>sinauprint@gmail.com</p>

                <br><br>
                <h5 class="mb-3 text-uppercase" style="letter-spacing:1px; font-family: 'Poppins', sans-serif;">Toko Offline</h5>
                <p class="mb-1">Jalan Jatibarang Timur 16</p>
                <p class="mb-1">No. 184, Kedungpane, Kec. Mijen</p>
                <p class="mb-4">Kota Semarang, Jawa Tengah</p>

                <a href="#" class="text-decoration-none"><h5 class="mb-3" style="letter-spacing:1px; font-family: 'Poppins', sans-serif;">Lihat Maps <i class="bi bi-arrow-right"></i></h5></a>
            </div>
        </div>
    </div>

</div>
<div class="container-fluid copyright py-4" style="background-color:#0258d3;">
    <div class="container">
        <div class="row align-items-center justify-content-between text-white">
            <div class="col-md-auto">
                <a href="#" class="text-white text-decoration-none me-4">Kebijakan Privasi</a>
                <a href="#" class="text-white text-decoration-none">Syarat Penggunaan</a>
            </div>
            <div class="col-md-auto text-end">
                &copy; 2025 PT Sinau Grafika
            </div>
        </div>
    </div>
</div>