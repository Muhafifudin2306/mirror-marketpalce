<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .email-header {
            background: linear-gradient(135deg, #0258d3 0%, #0439a0 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .email-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .email-body h2 {
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .email-body p {
            color: #666;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .welcome-button {
            display: inline-block;
            background: linear-gradient(135deg, #0258d3 0%, #0439a0 100%) !important;
            color: white !important;
            text-decoration: none !important;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
            border: none !important;
            -webkit-text-fill-color: white !important;
            mso-line-height-rule: exactly;
        }
        
        .welcome-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(2, 88, 211, 0.3);
            color: white !important;
            text-decoration: none !important;
        }

        .welcome-button:visited {
            color: white !important;
        }
        .welcome-button:active {
            color: white !important;
        }
        
        .welcome-button span {
            color: white !important;
        }
        
        .features-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ffc74c;
        }
        
        .features-info h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .features-info ul {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }
        
        .features-info li {
            margin-bottom: 8px;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }
        
        .email-footer p {
            margin: 5px 0;
        }
        
        .social-links {
            margin: 20px 0;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #0258d3;
            text-decoration: none;
            font-weight: 500;
        }
        
        .highlight-box {
            background: linear-gradient(135deg, #ffc74c 0%, #ffb347 100%);
            color: #333;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .highlight-box h3 {
            margin: 0 0 10px 0;
            font-size: 20px;
            font-weight: 600;
        }
        
        .highlight-box p {
            margin: 0;
            color: #333;
            font-weight: 500;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header, .email-body {
                padding: 30px 20px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .welcome-button {
                display: block;
                text-align: center;
                margin: 20px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎉 Selamat Datang!</h1>
            <p>Akun Anda telah berhasil dibuat</p>
        </div>
        
        <div class="email-body">
            <h2>Halo {{ $user->first_name ?? $user->name }},</h2>
            
            <p>Selamat datang di <strong>Sinau Print</strong>! Terima kasih telah bergabung dengan layanan percetakan terpercaya kami.</p>
            
            <div class="highlight-box">
                <h3>✨ Akun Anda Sudah Aktif!</h3>
                <p>Sekarang Anda dapat menikmati layanan cetak dengan mudah dan praktis.</p>
            </div>
            
            <p>Dengan akun Sinau Print, Anda dapat:</p>
            
            <div class="features-info">
                <h3>🚀 Fitur Unggulan</h3>
                <ul>
                    <li><strong>Upload & Cetak Online</strong> - Upload file dan pesan cetakan dari rumah</li>
                    <li><strong>Berbagai Pilihan Bahan</strong> - Pilihan bahan lengkap sesuai kebutuhan</li>
                    <li><strong>Tracking Pesanan</strong> - Pantau status pesanan secara real-time</li>
                    <li><strong>Harga Transparan</strong> - Tidak ada biaya tersembunyi</li>
                    <li><strong>Pengiriman Cepat</strong> - Layanan antar ke seluruh Indonesia</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="https://sinauprint.com" class="welcome-button">
                    Mulai Cetak Sekarang
                </a>
            </div>
            
            <p><strong>Butuh bantuan?</strong><br>
            Tim customer service kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami jika ada pertanyaan.</p>
            
            <div class="social-links">
                <a href="https://wa.me/6281952764747?text=Halo%20Sinau%20Print%2C%20saya%20ingin%20bertanya">📞 Hubungi Kami</a>
                <a href="https://sinauprint.com/faq">❓ FAQ</a>
            </div>
            
            <p>Terima kasih telah mempercayai Sinau Print untuk kebutuhan cetak Anda!</p>
            
            <p>Salam hangat,<br>
            <strong>Tim Sinau Print</strong></p>
        </div>
        
        <div class="email-footer">
            <p>Email ini dikirim secara otomatis, mohon jangan membalas email ini.</p>
            <p>© {{ date('Y') }} Sinau Print. All rights reserved.</p>
            <p>Jika Anda tidak mendaftar di Sinau Print, silakan abaikan email ini.</p>
        </div>
    </div>
</body>
</html>