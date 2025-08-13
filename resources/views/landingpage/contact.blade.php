@extends('landingpage.index')
@section('content')
<style>
    .hero-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3rem;
        font-weight: 600;
        color: #fff;
        margin-bottom: 0;
    }
    .hero-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 3.2rem;
        font-weight: 600;
        color: #ffc74c;
        margin-bottom: 1.5rem;
    }
    .hero-description {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 350;
        color: #fff;
        margin-bottom: 0;
        line-height: 1.4;
    }

    .additional-label {
        width: 4px;
        height: 20px;
        background-color: #0439a0;
        border-radius: 2px;
    }
    .section-label {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: #444444;
        margin-left: 0.8rem;
    }
    .vision-title {
        font-family: 'Poppins', sans-serif;
        font-size: 3.6rem;
        font-weight: 600;
        color: #000;
        margin-bottom: 0;
        line-height: 1.1;
    }
    .vision-title-highlight {
        font-family: 'Poppins', sans-serif;
        font-size: 3.6rem;
        font-weight: 600;
        color: #0439a0;
        margin-bottom: 1.2rem;
        line-height: 1.1;
    }
    .vision-description {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        line-height: 1.6;
        color: #333;
        text-align: justify;
    }

    .company-image {
        width: 100%;
        margin-top: 1.2rem;
        border-radius: 0.8rem;
        object-fit: cover;
        height: 500px;
    }

    .author-photo {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .author-info {
        text-align: left;
    }

    .author-name {
        color: #ffc74c;
        font-weight: bold;
        line-height: 1.2;
        font-size: 0.95rem;
    }

    .author-location {
        color: white;
        font-size: 0.875rem;
        line-height: 1.2;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .hero-title, .hero-subtitle {
            font-size: 2.4rem;
        }
        .hero-description {
            font-size: 0.8rem;
        }
        .vision-title, .vision-title-highlight {
            font-size: 2.8rem;
        }
        .vision-description {
            font-size: 0.85rem;
        }
        .company-image {
            height: 300px;
            margin-top: 1rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title, .hero-subtitle {
            font-size: 2rem;
        }
        .vision-title, .vision-title-highlight {
            font-size: 2.2rem;
        }
        .company-image {
            height: 250px;
        }
        .quote-mark {
            font-size: 3rem;
        }
    }
    @media (max-width: 768px) {
        .cta-section {
            display: none !important;
        }
    }
    @media (max-width: 576px) {
        .cta-section {
            display: none !important;
        }
    }
</style>

<br><br><br><br>

<div class="container-fluid px-3">
    <div class="position-relative mb-5">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/banner_contact.jpeg') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y cta-content" style="padding-left: 3rem;">
            <h3 class="hero-title">Kontak</h3>
            <h3 class="hero-subtitle">Sinau Print</h3>
            <p class="hero-description">Punya pertanyaan atau butuh bantuan?</p>
            <p class="hero-description">Tim kami siap menjawab 24 jam!</p>
        </div>
    </div>
</div>

{{-- Contact Information Section --}}
<div class="container-xl py-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="contact-info-container">
                <div class="contact-info-item mb-4">
                    <h4 class="contact-section-title mb-3">Toko Offline</h4>
                    <div class="d-flex align-items-start mb-2">
                        <i class="fa fa-map-marker-alt me-3 contact-icon"></i>
                        <div>
                            <p class="contact-detail mb-1">Jalan Jatibarang Timur 16 No.184,</p>
                            <p class="contact-detail mb-1">Kedungpane, Kec. Mijen, Kota</p>
                            <p class="contact-detail mb-0">Semarang, Jawa Tengah</p>
                        </div>
                    </div>
                </div>

                <div class="contact-info-item mb-4">
                    <h4 class="contact-section-title mb-3">Jam Kerja</h4>
                    <div class="d-flex align-items-start mb-2">
                        <i class="fa fa-clock me-3 contact-icon"></i>
                        <div>
                            <p class="contact-detail mb-1">Senin - Jumat: 08.00 - 17.00 WIB</p>
                            <p class="contact-detail mb-2">Sabtu - Minggu: 08.00 - 15.00 WIB</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fa fa-clock me-3 contact-icon"></i>
                        <div>
                            <p class="contact-detail mb-0">Online: Sesuai jam kerja</p>
                        </div>
                    </div>
                </div>

                <div class="contact-info-item mb-4">
                    <h4 class="contact-section-title mb-3">Kontak</h4>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-envelope me-3 contact-icon"></i>
                        <p class="contact-detail mb-0">sinauprint@gmail.com</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-phone me-3 contact-icon"></i>
                        <p class="contact-detail mb-0">081952764747</p>
                    </div>
                </div>

                <div class="contact-info-item">
                    <h4 class="contact-section-title mb-3">Customer Care</h4>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-headset me-3 contact-icon"></i>
                        <p class="contact-detail mb-0">adminsinau@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="maps-container">
                <div class="d-flex align-items-start mb-3">
                    <div class="additional-label me-3" style="margin-top: 0.3rem;"></div>
                </div>
                <div class="maps-wrapper mt-4">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18836.346968865244!2d110.33658498005055!3d-7.026423112135047!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b00632e0b53%3A0xbf3e39d0446365e8!2sSinau%20Print!5e0!3m2!1sid!2sid!4v1754492538011!5m2!1sid!2sid"
                        width="100%" 
                        height="500" 
                        style="border:0; border-radius: 0.8rem;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    {{-- <div class="mt-3 text-center">
                        <a href="https://maps.app.goo.gl/L3w6Lavt19JZL9219" 
                           target="_blank" 
                           class="btn-map-link">
                            <i class="fa fa-map-marker-alt me-2"></i>
                            Buka di Google Maps
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CTA Section --}}
<div class="container-fluid px-3 cta-section">
    <div class="position-relative">
        <img class="w-100 rounded" src="{{ asset('landingpage/img/CTA.png') }}" alt="CTA Image">
        <div class="position-absolute top-50 start-0 translate-middle-y p-3">
            <h3 class="mb-0" style="font-family: 'Poppins'; font-size:2.5rem !important; font-weight:550; color:#fff;">Mau Cetak Keperluan Kantor?</h3>
            <h3 class="mb-8" style="font-family: 'Poppins'; font-size:2.5rem !important; font-weight:550; color:#ffc74c; margin-top:-4px;">Boleh Tanya Dulu!</h3>
            <a href="https://wa.me/6281952764747?text=Halo%20Admin%20Sinau%20Print%21%20Saya%20ingin%20mengajukan%20pertanyaan%20terkait%20produk%20yang%20ada%20di%20sinau%20print" target="_blank" class="btn-schedule">
            <span class="btn-text">JADWALKAN KONSULTASI</span>
            <span class="btn-arrow">
                <i class="bi bi-arrow-right-short arrow-out"></i>
                <i class="bi bi-arrow-right-short arrow-in"></i>
            </span>
            </a>
        </div>
    </div>
</div>

<style>
.contact-info-container {
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 0.8rem;
    height: fit-content;
}

.contact-info-item {
    position: relative;
}

.contact-detail {
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 0;
}

.contact-time {
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: #0439a0;
    font-weight: 600;
}

.contact-link {
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-link:hover {
    color: #0439a0;
}

.maps-container {
    height: 100%;
}

.maps-wrapper {
    position: relative;
    height: 450px;
}

.btn-map-link {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    background: #0439a0;
    color: white;
    text-decoration: none;
    border-radius: 0.5rem;
    font-family: 'Poppins', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
}

.contact-section-title {
    color: #0439a0;
    font-weight: 600;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
}

.btn-map-link:hover {
    background: #032d70;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(4, 57, 160, 0.3);
}

@media (max-width: 991px) {
    .contact-info-container {
        margin-bottom: 2rem;
    }
    
    .maps-wrapper {
        height: 350px;
    }
    
    .maps-wrapper iframe {
        height: 300px !important;
    }
}

@media (max-width: 768px) {
    .contact-info-container {
        padding: 1rem;
    }
    
    .contact-detail, .contact-link {
        font-size: 0.85rem;
    }
    
    .contact-time {
        font-size: 0.8rem;
    }
    
    .maps-wrapper {
        height: 300px;
    }
    
    .maps-wrapper iframe {
        height: 250px !important;
    }
    
    .btn-map-link {
        font-size: 0.8rem;
        padding: 0.6rem 1.2rem;
    }
}
</style>
@endsection