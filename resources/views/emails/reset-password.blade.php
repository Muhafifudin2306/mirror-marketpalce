<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        
        .reset-button {
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
        
        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(2, 88, 211, 0.3);
            color: white !important;
            text-decoration: none !important;
        }

        .reset-button:visited {
            color: white !important;
        }
        .reset-button:active {
            color: white !important;
        }
        
        .reset-button span {
            color: white !important;
        }
        
        .security-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0258d3;
        }
        
        .security-info h3 {
            color: #333;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .security-info ul {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }
        
        .security-info li {
            margin-bottom: 5px;
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
        
        .link-alternative {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            word-break: break-all;
            font-size: 14px;
            color: #666;
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
            
            .reset-button {
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
            <h1>🔑 Reset Password</h1>
            <p>Permintaan reset password untuk akun Anda</p>
        </div>
        
        <div class="email-body">
            <h2>Halo {{ $user->name ?? 'User' }},</h2>
            
            <p>Kami menerima permintaan untuk reset password akun Anda. Jika Anda yang membuat permintaan ini, silakan klik tombol di bawah untuk melanjutkan proses reset password.</p>
            
            <div style="text-align: center;">
                <a href="{{ $actionUrl }}" class="reset-button">
                    Reset Password Sekarang
                </a>
            </div>
            
            <div class="security-info">
                <h3>⚠️ Informasi Keamanan</h3>
                <ul>
                    <li>Link ini akan <strong>kedaluwarsa dalam 60 menit</strong></li>
                    <li>Link hanya dapat digunakan <strong>satu kali</strong></li>
                    <li>Jika Anda tidak meminta reset password, abaikan email ini</li>
                    <li>Password lama Anda masih berlaku sampai Anda menyelesaikan proses reset</li>
                </ul>
            </div>
            
            <p><strong>Tidak bisa klik tombol di atas?</strong><br>
            Salin dan tempel link berikut ke browser Anda:</p>
            
            <div class="link-alternative">
                {{ $actionUrl }}
            </div>
            
            <p>Jika Anda mengalami masalah atau tidak meminta reset password ini, segera hubungi tim support kami.</p>
            
            <p>Terima kasih,<br>
            <strong>Tim Support</strong></p>
        </div>
        
        <div class="email-footer">
            <p>Email ini dikirim secara otomatis, mohon jangan membalas email ini.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>