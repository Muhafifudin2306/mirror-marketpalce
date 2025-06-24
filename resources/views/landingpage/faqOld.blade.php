@extends('landingpage.index')
@section('content')
    <br><br><br><br>

     <div class="container-fluid px-3">
        <div class="position-relative mb-5">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/search-modals.png') }}" alt="CTA Image">
            <div class="position-absolute top-50 start-0 translate-middle-y cta-content">
                <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Pertanyaan yang Sering</h3>
                <h3 class="mb-0" style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#fff;">Diajukan <span style="font-family: 'Poppins'; font-size:4rem; font-weight:600; color:#ffc74c;">(FaQ)</span> </h3>
            </div>
        </div>
    </div>

    <div class="container p-5">
    <style>
        .sidebar {
            /* background-color: white; */
            /* box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 20px; */
            height: fit-content;
            position: sticky;
            top: 20px;
        }
        
        .sidebar h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .sidebar-item-faq {
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            background: transparent;
            text-align: left;
            width: 100%;
            color: #666;
        }
        
        .sidebar-item-faq:hover {
            background-color: #e3f2fd;
            color: #1976d2;
        }
        
        .sidebar-item-faq.active {
            background-color: #1976d2;
            color: white;
            font-weight: 500;
        }
        
        .content-area {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .content-section {
            display: none;
        }
        
        .content-section.active {
            display: block;
        }
        
        .content-section h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .content-section p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .payment-methods {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }
        
        .payment-badge {
            background-color: #e8f5e8;
            color: #2e7d32;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
        }
        
        .alert-info-custom {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }
        
        .process-steps {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .step {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .step-number {
            background-color: #1976d2;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: 600;
            font-size: 0.9em;
        }
        
        .step-text {
            color: #333;
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
            }
        }
    </style>
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-4">
                <div class="sidebar">
                    
                    <div class="mb-3">
                        <button class="sidebar-item-faq active" onclick="showSection('pembelian')">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Pembelian & Pembayaran
                        </button>
                        <div class="ms-3">
                            <button class="sidebar-item-faq ms-3" onclick="showSection('cara-pesan')" style="font-size: 0.9em;">
                                Bagaimana cara memesan produk di Sinau Print?
                            </button>
                            <button class="sidebar-item-faq ms-3 active" onclick="showSection('metode-bayar')" style="font-size: 0.9em;">
                                Metode pembayaran apa saja yang tersedia?
                            </button>
                            <button class="sidebar-item-faq ms-3" onclick="showSection('batal-pesanan')" style="font-size: 0.9em;">
                                Bagaimana jika saya ingin membatalkan pesanan?
                            </button>
                            <button class="sidebar-item-faq ms-3" onclick="showSection('refund')" style="font-size: 0.9em;">
                                Bagaimana cara mengajukan refund atau komplain?
                            </button>
                        </div>
                    </div>
                    
                    <button class="sidebar-item-faq" onclick="showSection('akun')">
                        <i class="fas fa-user me-2"></i>
                        Akun & Profil
                    </button>
                    
                    <button class="sidebar-item-faq" onclick="showSection('desain')">
                        <i class="fas fa-paint-brush me-2"></i>
                        Panduan Desain & File
                    </button>
                    
                    <button class="sidebar-item-faq" onclick="showSection('keamanan')">
                        <i class="fas fa-shield-alt me-2"></i>
                        Keamanan & Privasi Data
                    </button>
                    
                    <button class="sidebar-item-faq" onclick="showSection('kontak')">
                        <i class="fas fa-phone me-2"></i>
                        Kontak & Bantuan Lainnya
                    </button>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="col-lg-9 col-md-8">
                <div class="content-area">
                    <!-- Header Section -->
                    <div class="content-section active" id="pembelian">
                        <h2>Bagaimana Caranya Memesan Produk di Sinau Print?</h2>
                        <p>Kamu bisa memilih produk, sesuaikan spesifikasi, upload desain (atau konsultasi dulu), lalu checkout dan isi data. Setelah pembayaran dikonfirmasi, pesanan akan segera diproses.</p>
                        
                        <div class="process-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-text">Pilih produk yang diinginkan dari katalog kami</div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-text">Sesuaikan spesifikasi produk (ukuran, bahan, jumlah)</div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-text">Upload desain atau konsultasi dengan tim kami</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-text">Lakukan checkout dan isi data pengiriman</div>
                            </div>
                            <div class="step">
                                <div class="step-number">5</div>
                                <div class="step-text">Konfirmasi pembayaran</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Metode Pembayaran -->
                    <div class="content-section" id="metode-bayar">
                        <h2>Metode pembayaran apa saja yang tersedia?</h2>
                        <p>Kami menerima pembayaran melalui transfer bank, e-wallet (OVO, GoPay, Dana), dan kartu kredit. Info detail akan muncul saat checkout.</p>
                        
                        <div class="payment-methods">
                            <span class="payment-badge"><i class="fas fa-university me-1"></i> Transfer Bank</span>
                            <span class="payment-badge"><i class="fas fa-mobile-alt me-1"></i> OVO</span>
                            <span class="payment-badge"><i class="fas fa-mobile-alt me-1"></i> GoPay</span>
                            <span class="payment-badge"><i class="fas fa-mobile-alt me-1"></i> Dana</span>
                            <span class="payment-badge"><i class="fas fa-credit-card me-1"></i> Kartu Kredit</span>
                        </div>
                        
                        <div class="alert-info-custom">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Catatan:</strong> Semua metode pembayaran aman dan terenkripsi untuk melindungi data pribadi Anda.
                        </div>
                    </div>
                    
                    <!-- Membatalkan Pesanan -->
                    <div class="content-section" id="batal-pesanan">
                        <h2>Bagaimana jika saya ingin membatalkan pesanan?</h2>
                        <p>Pembatalan hanya bisa dilakukan sebelum proses cetak dimulai. Hubungi admin kami secepatnya untuk pembatalan pesanan.</p>
                        
                        <div class="alert-info-custom">
                            <i class="fas fa-clock me-2"></i>
                            <strong>Waktu Pembatalan:</strong> Maksimal 2 jam setelah konfirmasi pembayaran untuk produk reguler, atau sebelum proses produksi dimulai.
                        </div>
                        
                        <p class="mt-3"><strong>Cara pembatalan:</strong></p>
                        <ul>
                            <li>Hubungi customer service melalui WhatsApp atau email</li>
                            <li>Sertakan nomor pesanan dan alasan pembatalan</li>
                            <li>Tunggu konfirmasi dari tim kami</li>
                        </ul>
                    </div>
                    
                    <!-- Refund -->
                    <div class="content-section" id="refund">
                        <h2>Bagaimana cara mengajukan refund atau komplain?</h2>
                        <p>Untuk refund atau komplain, silakan hubungi customer service kami dengan menyertakan foto produk dan nomor pesanan. Kami akan memproses sesuai dengan kebijakan yang berlaku.</p>
                        
                        <div class="process-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-text">Foto produk yang bermasalah</div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-text">Siapkan nomor pesanan</div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-text">Hubungi customer service via WhatsApp</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-text">Tunggu proses verifikasi maksimal 1x24 jam</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cara Pesan -->
                    <div class="content-section" id="cara-pesan">
                        <h2>Bagaimana cara memesan produk di Sinau Print?</h2>
                        <p>Proses pemesanan di Sinau Print sangat mudah dan user-friendly. Ikuti langkah-langkah berikut:</p>
                        
                        <div class="process-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-text"><strong>Kunjungi Website:</strong> Buka sinauprint.com</div>
                            </div>
                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-text"><strong>Pilih Kategori:</strong> Pilih jenis produk yang ingin dicetak</div>
                            </div>
                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-text"><strong>Atur Spesifikasi:</strong> Tentukan ukuran, bahan, dan jumlah</div>
                            </div>
                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-text"><strong>Upload File:</strong> Upload desain atau gunakan template kami</div>
                            </div>
                            <div class="step">
                                <div class="step-number">5</div>
                                <div class="step-text"><strong>Review & Checkout:</strong> Periksa pesanan dan lakukan pembayaran</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Section lainnya -->
                    <div class="content-section" id="akun">
                        <h2>Akun & Profil</h2>
                        <p>Informasi mengenai pengelolaan akun dan profil pengguna akan ditampilkan di sini.</p>
                    </div>
                    
                    <div class="content-section" id="desain">
                        <h2>Panduan Desain & File</h2>
                        <p>Panduan lengkap tentang format file, resolusi, dan tips desain yang baik untuk hasil cetak optimal.</p>
                    </div>
                    
                    <div class="content-section" id="keamanan">
                        <h2>Keamanan & Privasi Data</h2>
                        <p>Informasi tentang bagaimana kami melindungi data pribadi dan transaksi Anda.</p>
                    </div>
                    
                    <div class="content-section" id="kontak">
                        <h2>Kontak & Bantuan Lainnya</h2>
                        <p>Hubungi tim customer service kami melalui berbagai channel yang tersedia.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center">
                                        <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                                        <h6>WhatsApp</h6>
                                        <p class="text-muted">+62 812-3456-7890</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                                        <h6>Email</h6>
                                        <p class="text-muted">cs@sinauprint.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function showSection(sectionId) {
            // Hide all content sections
            const sections = document.querySelectorAll('.content-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all sidebar items
            const sidebarItems = document.querySelectorAll('.sidebar-item-faq');
            sidebarItems.forEach(item => {
                item.classList.remove('active');
            });
            
            // Show selected section
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.add('active');
            }
            
            // Add active class to clicked sidebar item
            event.target.classList.add('active');
        }
        
        // Initialize with first section active
        document.addEventListener('DOMContentLoaded', function() {
            showSection('metode-bayar');
            // Set the corresponding sidebar item as active
            const activeBtn = document.querySelector('[onclick="showSection(\'metode-bayar\')"]');
            if (activeBtn) {
                activeBtn.classList.add('active');
            }
        });
        
        // Add smooth scroll behavior
        document.querySelectorAll('.sidebar-item-faq').forEach(item => {
            item.addEventListener('click', function() {
                // Smooth scroll to top of content area on mobile
                if (window.innerWidth <= 768) {
                    document.querySelector('.content-area').scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    </div>

    
@endsection
