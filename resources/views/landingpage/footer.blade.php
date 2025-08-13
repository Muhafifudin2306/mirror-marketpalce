<style>
@media (max-width: 768px) {
    .container-fluid.footer {
        padding-top: 2rem !important;
        margin-top: 2rem !important;
    }
    
    .container.py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .footer .col-lg-6.col-md-6 {
        margin-bottom: 2rem !important;
        text-align: center !important;
    }
    
    .footer .col-lg-6.col-md-6 img {
        max-width: 70% !important;
        margin-bottom: 1rem !important;
    }
    
    .footer .d-flex.mt-3 {
        margin-top: 1rem !important;
        justify-content: center !important;
        gap: 1rem !important;
    }
    
    .footer .d-flex.mt-3 a {
        width: 40px !important;
        height: 40px !important;
    }
    
    .footer .d-flex.mt-3 a i {
        font-size: 16px !important;
    }
    
    .footer .col-lg-3.col-md-6 {
        margin-bottom: 1.5rem !important;
        text-align: center !important;
    }
    
    .footer .col-lg-3.col-md-6 br {
        display: none !important;
    }
    
    .footer h6 {
        font-size: 1rem !important;
        margin-bottom: 1rem !important;
        margin-top: 0 !important;
        text-align: center !important;
    }
    
    .footer ul.list-unstyled {
        text-align: center !important;
        margin-bottom: 1.5rem !important;
    }
    
    .footer ul.list-unstyled li {
        margin-bottom: 0.5rem !important;
    }
    
    .footer ul.list-unstyled li a {
        font-size: 0.9rem !important;
        display: inline-block !important;
        padding: 0.25rem 0 !important;
    }
    
    .footer .col-lg-3.col-md-6:last-child p {
        text-align: center !important;
        font-size: 0.9rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .footer .col-lg-3.col-md-6:last-child a h6 {
        text-align: center !important;
        margin-top: 1rem !important;
        margin-bottom: 0 !important;
    }
    
    .footer .col-lg-3.col-md-6:last-child {
        text-align: center !important;
    }
}

@media (max-width: 576px) {
    .container.py-4 {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
    
    .footer .col-lg-6.col-md-6 img {
        max-width: 80% !important;
    }
    
    .footer h6 {
        font-size: 0.95rem !important;
    }
    
    .footer ul.list-unstyled li a {
        font-size: 0.85rem !important;
    }
    
    .footer .col-lg-3.col-md-6:last-child p {
        font-size: 0.85rem !important;
    }
}

@media (max-width: 768px) {
    .container-fluid.copyright .container .row {
        flex-direction: column !important;
        text-align: center !important;
        gap: 0.5rem !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .container-fluid.copyright .col-md-auto {
        margin-bottom: 0.5rem !important;
        text-align: center !important;
        width: 100% !important;
        max-width: none !important;
    }
    
    .container-fluid.copyright .col-md-auto a {
        font-size: 0.8rem !important;
        margin-right: 1rem !important;
    }
    
    .container-fluid.copyright .col-md-auto:last-child {
        margin-bottom: 0 !important;
        text-align: center !important;
    }
    
    .container-fluid.copyright .col-md-auto:last-child span {
        font-size: 0.8rem !important;
    }
}
</style>

<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-4">

        <div class="mb-4"></div>

        <div class="row g-4">
            <div class="col-lg-6 col-md-6 text-center text-md-start">
                <img src="{{ asset('landingpage/img/footer_logo.png') }}" alt="Logo" style="max-width:85%;">
                @php
                    $socials = [
                        'instagram'  => 'https://www.instagram.com/sinauprint?igsh=a3d5aWVtczRiejc=',
                        'facebook-f' => 'https://www.facebook.com/profile.php?id=61569943126701',
                        'tiktok'     => 'https://www.tiktok.com/@sinauprint?_t=ZS-8xmeE1lRULC&_r=1',
                        // 'linkedin'   => '#',
                    ];
                @endphp

                <div class="d-flex mt-3 gap-2 justify-content-center justify-content-md-start">
                    @foreach($socials as $social => $url)
                        <a href="{{ $url }}" target="_blank"
                        class="d-inline-flex align-items-center justify-content-center text-decoration-none"
                        style="width:48px; height:48px; border:1px solid #ddd; border-radius:50%; color:#666; transition: all 0.3s ease;">
                            <i class="fab fa-{{ $social }}" style="font-size: 18px;"></i>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <br><br><br>
                <h6 class="mb-3 text-uppercase" style="letter-spacing:0.5px; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 600; color: #000;">Company</h6>
                <ul class="list-unstyled">
                    <li class="mb-1"><a href="/about" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;">Tentang Sinau</a></li>
                    <li class="mb-1"><a href="/contact" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;">Hubungi Kami</a></li>
                </ul>

                <br>
                <h6 class="text-uppercase" style="letter-spacing:0.5px; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 600; margin: 10px 0 3px 0; color: #000;">Bisnis</h6>
                <ul class="list-unstyled" style="line-height: 1.2; margin-bottom: 0;">
                    <li style="margin-bottom: 1px; padding: 0;"><a href="/products" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.7rem; color: #666; display: block; padding: 1px 0;">Semua Produk</a></li>
                    <li style="margin-bottom: 1px; padding: 0;"><a href="/order-guide" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.7rem; color: #666; display: block; padding: 1px 0;">Cara Pesan</a></li>
                    <li style="margin-bottom: 1px; padding: 0;"><a href="/consultation" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.7rem; color: #666; display: block; padding: 1px 0;">Konsultasi</a></li>
                    <li style="margin-bottom: 1px; padding: 0;"><a href="/articles" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.7rem; color: #666; display: block; padding: 1px 0;">Artikel</a></li>
                    <li style="margin-bottom: 1px; padding: 0;"><a href="/faq" class="text-decoration-none" style="font-family: 'Poppins'; font-size: 0.7rem; color: #666; display: block; padding: 1px 0;">FAQ</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <br><br><br>
                <h6 class="mb-3 text-uppercase" style="letter-spacing:0.5px; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 600; color: #000;">Kontak</h6>
                <p class="mb-2" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;"><i class="fa fa-phone-alt me-2" style="font-size: 0.8rem;"></i>0819 5276 4747</p>
                <p class="mb-3" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;"><i class="fa fa-envelope me-2" style="font-size: 0.8rem;"></i>sinauprint@gmail.com</p>

                <br>
                <h6 class="mb-3 text-uppercase" style="letter-spacing:0.5px; font-family: 'Poppins', sans-serif; font-size: 0.9rem; font-weight: 600; color: #000;">Toko Offline</h6>
                <p class="mb-1" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;">Jalan Jatibarang Timur 16</p>
                <p class="mb-1" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;">No. 184, Kedungpane, Kec. Mijen</p>
                <p class="mb-3" style="font-family: 'Poppins'; font-size: 0.85rem; color: #666;">Kota Semarang, Jawa Tengah</p>

                <a target="_blank" href="https://maps.app.goo.gl/L3w6Lavt19JZL9219" class="text-decoration-none">
                    <h6 class="mb-3" style="letter-spacing:0.5px; font-family: 'Poppins', sans-serif; font-size: 0.8rem; font-weight: 600; color: #000;">
                        Lihat Maps <i class="bi bi-arrow-right" style="font-size: 0.8rem;"></i>
                    </h6>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid copyright py-3" style="background-color:#0258d3;">
    <div class="container">
        <div class="row align-items-center justify-content-between text-white">
            <div class="col-md-auto">
                <a href="{{ url('/kebijakan-privasi') }}" class="text-white text-decoration-none me-4" style="font-size: 0.85rem;">Kebijakan Privasi</a>
                <a href="{{ url('/syarat-penggunaan') }}" class="text-white text-decoration-none" style="font-size: 0.85rem;">Syarat Penggunaan</a>
            </div>
            <div class="col-md-auto text-end">
                <span style="font-size: 0.85rem;">&copy; 2025 PT Sinau Grafika</span>
            </div>
        </div>
    </div>
</div>