@extends('landingpage.index')
@section('content')
    <style>
        .form-control {
            border-radius: 50px !important;
            height: 55px;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .form-control::placeholder {
            padding: 0 10px;
            color: #c3c3c3;
            opacity: 1;
        }

        .form-control:disabled {
            background-color: #fff !important;
            color: #c3c3c3;
            opacity: 1 !important;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        .edit-btn {
            border-radius: 0.25rem !important;
        }

        #editPasswordFields .eye-btn {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .sidebar-filter a {
            display: block !important;
            font-family: 'Poppins', sans-serif !important;
            background-color: #fff !important;
            color: #666 !important;
            border-radius: 50px !important;
            padding: 8px 20px !important;
            margin-bottom: 8px !important;
            position: relative !important;
            overflow: hidden !important;
            transition: all .3s !important;
            width: 100% !important;
            text-align: left !important;
            text-decoration: none !important;
            cursor: pointer !important;
        }

        .sidebar-filter a:hover {
            padding-right: 40px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            color: #000 !important;
        }

        .sidebar-filter a.active {
            background-color: #f1f7ff !important;
            color: #000 !important;
        }

        .sidebar-filter a.active::after {
            content: '' !important;
            position: absolute !important;
            width: 10px !important;
            height: 10px !important;
            background-color: #0439a0 !important;
            top: 50% !important;
            right: 12px !important;
            transform: translateY(-50%) rotate(45deg) !important;
        }

        .sidebar-filter .nav-link::before {
            display: none !important;
        }

        .section-pill {
            display: block;
            width: 100%;
            text-align: left;
            font-family: 'Poppins', sans-serif !important;
            background-color: #f1f7ff;
            color: #0439a0;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.6rem;
            margin-bottom: 16px;
        }

        .is-invalid {
            border-color: #fc2865 !important;
        }

        .invalid-feedback {
            display: block;
            color: #fc2865;
            font-size: 0.8rem;
            font-weight: 200;
        }

        .btn-edit-text {
            display: inline-block;
            padding: 6px 12px;
            font-size: 16px;
            font-weight: 550;
            color: #444444;
            background-color: #fff;
            font-family: 'Poppins', sans-serif !important;
            border: none;
            text-decoration: none !important;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-edit-text:hover {
            color: #0439a0;
        }

        .btn-save {
            background-color: #0258d3;
            color: white;
            padding: 13px 14px;
            font-size: 18px;
            margin-top: 24px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save:hover {
            background-color: #0258d3;
            color: white;
        }

        .btn-cancel {
            background: none;
            border: none;
            color: #888;
            font-size: 13px;
            margin-top: 18px;
            text-decoration: underline;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            padding: 0;
            display: inline;
            width: auto;
            cursor: pointer;
        }

        .btn-cancel:hover {
            color: #444;
            text-decoration: underline;
        }

        .input-edit {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .input-edit:focus {
            border-color: #80bdff;
            outline: none;
        }

        .field-label {
            font-weight: bold;
            margin-bottom: 4px;
            display: inline-block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input.form-control {
            padding-right: 45px !important;
        }

        .eye-btn {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #999;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .notification-badge {
            font-size: 0.9rem;
            padding: 4px 12px;
            border-radius: 4px;
            font-weight: 500;
            display: inline-block;
            text-transform: uppercase;
        }

        .badge-purchase {
            background-color: #03a7a7;
            color: #fff;
        }

        .badge-promo {
            background-color: #fc2965;
            color: #fff;
        }

        .badge-profil {
            background-color: #0258d3;
            color: #fff;
        }

        .notification-unread {
            background-color: #f1f7ff !important;
            border: none;
            cursor: pointer;
            transition: background-color 0.4s ease;
            font-family: 'Poppins', sans-serif;
        }

        .notification-read {
            background-color: #fff !important;
            border: none;
            cursor: pointer;
            transition: background-color 0.4s ease;
            font-family: 'Poppins', sans-serif;
        }

        .pagination {
            margin: 0;
            gap: 0.5rem;
        }

        .pagination .page-link {
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            padding: 0;
            line-height: 38px;
            text-align: center;
            font-weight: 500;
            color: #0258d3;
            border: 1px solid #ccc;
        }

        .pagination .page-item.active .page-link {
            background-color: #0258d3;
            color: white;
            border-color: #0258d3;
        }

        .pagination .page-item.disabled,
        .pagination .page-item:first-child,
        .pagination .page-item:last-child {
            display: none;
        }

        .logout-button {
            border: none;
            padding: 12px 65px;
            background-color: transparent;
            color: white;
            border-radius: 50px;
            border: 2px solid white;
            font-size: 1.1rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.2s ease;
        }

        .logout-button:hover {
            background-color: white;
            border: 2px solid white;
            color: black;
        }
    </style>

    <style>
        .chat-container {
            height: 700px;
            display: flex;
        }

        .chat-sidebar {
            width: 300px;
            background: white;
            border-right: 1px solid #dee2e6;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
            background: #f8f9fa;
        }

        .chat-header h5 {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }

        .chat-list {
            flex: 1;
            overflow-y: auto;
        }

        .chat-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f3f4;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
        }

        .chat-item:hover {
            background-color: #f8f9fa;
        }

        .chat-item.active {
            background-color: #e3f2fd;
            border-right: 3px solid #2196f3;
        }

        .chat-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .chat-info {
            flex: 1;
            min-width: 0;
        }

        .chat-name {
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .chat-preview {
            color: #6c757d;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-meta {
            text-align: right;
            flex-shrink: 0;
            margin-left: 10px;
        }

        .chat-time {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .chat-badge {
            background: #28a745;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 10px;
        }

        .chat-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-main-header {
            padding: 15px 20px;
            border-bottom: 1px solid #dee2e6;
            background: #f8f9fa;
            display: flex;
            align-items: center;
        }

        .chat-main-header h5 {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            word-wrap: break-word;
        }

        .message.received .message-bubble {
            background: white;
            border: 1px solid #e9ecef;
            margin-left: 45px;
        }

        .message.sent .message-bubble {
            background: #2196f3;
            color: white;
        }

        .message-time {
            font-size: 11px;
            margin-top: 5px;
            opacity: 0.7;
        }

        .message.received .message-time {
            color: #6c757d;
        }

        .message.sent .message-time {
            color: white;
            text-align: right;
        }

        .message-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(45deg, #2196f3, #21cbf3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 12px;
            position: absolute;
            /* left: 20px; */
        }

        .chat-input {
            padding: 15px 20px;
            border-top: 1px solid #dee2e6;
            background: white;
        }

        .input-group {
            position: relative;
        }


        .send-btn {
            /* position: absolute; */
            right: 8px;
            background: #2196f3;
            border: none;
            border-radius: 50%;
            width: 65px;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .send-btn:hover {
            background: #1976d2;
        }

        .file-attachment {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 8px 12px;
            margin: 5px 0;
            display: inline-flex;
            align-items: center;
            font-size: 13px;
            color: #1976d2;
        }

        .date-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .date-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #dee2e6;
        }

        .date-divider span {
            background: #f8f9fa;
            padding: 0 15px;
            color: #6c757d;
            font-size: 12px;
        }

        @media (max-width: 768px) {
            .chat-sidebar {
                width: 100%;
                position: absolute;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .chat-sidebar.show {
                transform: translateX(0);
            }

            .chat-main {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="position-relative mb-0">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
            <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%; width: 90%;">
                <!-- WRAPPER BARU untuk greeting + logout -->
                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                    <h3 class="mb-0" style="font-family:'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">
                        Halo, <span style="color:#ffc74c">{{ Auth::user()->name }}</span>
                    </h3>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="logout-button">LOGOUT</button>
                    </form>
                </div>

                <!-- Breadcrumb tetap di bawah -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-family:'Poppins'; font-size:1rem; font-weight:400;">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">BERANDA</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PROFIL</li>
                    </ol>
                </nav>
            </div>

        </div>
    </div>

    <main>
        <div class="container-fluid px-4">
            <div class="container product-card" style="margin-top:-180px;">
                <div class="row g-5" style="margin-top:40px;">

                    {{-- Sidebar Tabs --}}
                    <div class="col-lg-3">
                        <div class="sidebar-filter nav flex-column nav-pills me-3" id="sidebarTabs" role="tablist"
                            style="font-weight: 200 !important;">
                            <a class="nav-link" id="tab-orders" data-bs-toggle="pill" data-bs-target="#pane-orders">Pesanan
                                Saya</a>
                            <a class="nav-link active" id="tab-profile" data-bs-toggle="pill"
                                data-bs-target="#pane-profile">Profil Saya</a>
                            <a class="nav-link" id="tab-chat" data-bs-toggle="pill" data-bs-target="#pane-chat">Chat
                                Saya</a>
                            <a class="nav-link" id="tab-notif" data-bs-toggle="pill"
                                data-bs-target="#pane-notif">Notifikasi</a>
                        </div>
                    </div>

                    {{-- Content Panes --}}
                    <div class="col-lg-8">
                        <div class="tab-content" id="sidebarTabsContent">
                            {{-- Pesanan Saya --}}
                            <div class="tab-pane fade" id="pane-orders" role="tabpanel" aria-labelledby="tab-orders">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr class="border-bottom">
                                            <th>Invoice</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Estimasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="border-bottom">
                                                <td>{{ 'INV' . substr($order->spk, 3, strpos($order->spk, '-') - 3) }}</td>
                                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                                <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                                <td>
                                                    @php
                                                    switch 
                                                    ($order->order_status) {
                                                    case 0:
                                                        $badge = 'warning';
                                                        $label = 'Menunggu Pembayaran';
                                                        break;
                                                    case 1:
                                                        $badge = 'primary';
                                                        $label = 'Dalam Pengerjaan';
                                                        break;
                                                    case 2:
                                                        $badge = 'success';
                                                        $label = 'Dalam Pengiriman';
                                                        break;
                                                    case 3:
                                                        $badge = 'success';
                                                        $label = 'Pesanan Selesai';
                                                        break;
                                                        } @endphp ?>
                                                    <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                                                </td>
                                                <td>{{ $order->estimasi ?? '-' }}</td>
                                                <td>
                                                    @if ($order->order_status == 0)
                                                        <button
                                                            class="btn btn-sm btn-light rounded-pill mb-1">Bayar</button>
                                                        <button class="btn btn-sm btn-light rounded-pill mb-1">Lihat
                                                            Order</button>
                                                        <button class="btn btn-sm btn-danger rounded-pill">Batalkan</button>
                                                    @else
                                                        <button class="btn btn-sm btn-light rounded-pill">Lihat
                                                            Order</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Profil Saya --}}
                            <div class="tab-pane fade show active" id="pane-profile" role="tabpanel">
                                <form id="formProfile" method="POST" action="{{ route('profile.update') }}">
                                    @csrf

                                    {{-- Informasi Pribadi --}}
                                    <h4 class="section-pill">Informasi Pribadi</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NAMA DEPAN</label>
                                            <input name="first_name" type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name', Auth::user()->first_name) }}" disabled>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NAMA BELAKANG</label>
                                            <input name="last_name" type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name', Auth::user()->last_name) }}" disabled>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">EMAIL</label>
                                            <input name="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', Auth::user()->email) }}" disabled>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NO. TELP</label>
                                            <input name="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone', Auth::user()->phone) }}" disabled>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Alamat Tersimpan --}}
                                    <h4 class="section-pill">Alamat Tersimpan</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PROVINSI</label>
                                            <select name="province"
                                                class="form-control @error('province') is-invalid @enderror" disabled>
                                                <option value="{{ Auth::user()->province }}">{{ Auth::user()->province }}
                                                </option>
                                            </select>
                                            @error('province')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">KECAMATAN/KOTA</label>
                                            <select name="city"
                                                class="form-control @error('city') is-invalid @enderror" disabled>
                                                <option value="{{ Auth::user()->city }}">{{ Auth::user()->city }}
                                                </option>
                                            </select>
                                            @error('city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">DETAIL ALAMAT PENGIRIMAN</label>
                                            <input name="address" type="text"
                                                class="form-control @error('address') is-invalid @enderror"
                                                value="{{ old('address', Auth::user()->address) }}" disabled>
                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">KODE POS</label>
                                            <input name="postal_code" type="text"
                                                class="form-control @error('postal_code') is-invalid @enderror"
                                                value="{{ old('postal_code', Auth::user()->postal_code) }}" disabled>
                                            @error('postal_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- Sandi & Keamanan --}}
                                    <h4 class="section-pill">Sandi dan Keamanan</h4>

                                    {{-- View mode --}}
                                    <div id="viewPassword" class="mb-3">
                                        <label class="form-label">KATA SANDI ANDA</label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control" placeholder="********" disabled>
                                        </div>
                                    </div>

                                    {{-- Edit mode --}}
                                    <div id="editPasswordFields" class="row d-none">
                                        <div class="col-md-12 mb-3 position-relative">
                                            <label class="form-label">SANDI SAAT INI</label>
                                            <input id="currentPassword" name="current_password" type="password"
                                                class="form-control @error('current_password') is-invalid @enderror">
                                            <button type="button" class="eye-btn"
                                                onclick="toggleEye('currentPassword', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3 position-relative">
                                            <label class="form-label">SANDI BARU</label>
                                            <input id="newPassword" name="new_password" type="password"
                                                class="form-control @error('new_password') is-invalid @enderror">
                                            <button type="button" class="eye-btn"
                                                onclick="toggleEye('newPassword', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @error('new_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3 position-relative">
                                            <label class="form-label">KONFIRMASI SANDI BARU</label>
                                            <input id="confirmPassword" name="new_password_confirmation" type="password"
                                                class="form-control @error('new_password_confirmation') is-invalid @enderror">
                                            <button type="button" class="eye-btn"
                                                onclick="toggleEye('confirmPassword', this)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @error('new_password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mb-3 position-relative">
                                            <button id="btnSave" type="submit" class="btn btn-save w-100 mb-2">
                                                SIMPAN PERUBAHAN
                                            </button>
                                            <div class="text-center">
                                                <button id="btnCancel" type="button" class="btn-cancel d-none">
                                                    BATAL
                                                </button>
                                            </div>


                                        </div>
                                    </div>


                                    {{-- Tombol Edit / Save --}}
                                    <div class="d-flex flex-column align-items-end mt-4">
                                        {{-- Ubah Edit Profil menjadi teks klik dengan icon --}}
                                        <button id="btnEdit" type="button" class="btn-edit-text"
                                            aria-label="Edit Profil">
                                            <i class="fas fa-pen" style="margin-right: 10px;"></i> EDIT PROFIL
                                        </button> <!-- ubah disini -->

                                    </div>
                                </form>
                            </div>

                            {{-- Chat Saya --}}
                            <div class="tab-pane fade" id="pane-chat" role="tabpanel">
                                <div class="chat-container">
                                    <!-- Sidebar -->
                                    <div class="chat-sidebar" id="chatSidebar">
                                        <div class="chat-list" id="chatList">
                                            <div class="chat-item active" data-chat="sinau-admin">
                                                <div class="chat-avatar">SA</div>
                                                <div class="chat-info">
                                                    <div class="chat-name">SINAU ADMIN</div>
                                                    <div class="chat-preview">Halo kak! Terima kasih sudah menghubungi...
                                                    </div>
                                                </div>
                                                <div class="chat-meta">
                                                    <div class="chat-badge">PESAN BARU</div>
                                                </div>
                                            </div>

                                            <div class="chat-item" data-chat="sinau-promo">
                                                <div class="chat-avatar">SP</div>
                                                <div class="chat-info">
                                                    <div class="chat-name">SINAUPROMO</div>
                                                    <div class="chat-preview">Halo kak! Terima kasih sudah menghubungi...
                                                    </div>
                                                </div>
                                                <div class="chat-meta">
                                                    <div class="chat-time">25/2/2025</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Main Chat Area -->
                                    <div class="chat-main">
                                        <div class="chat-main-header">
                                            <button class="btn btn-link d-md-none me-2" onclick="toggleSidebar()">
                                                <i class="fas fa-bars"></i>
                                            </button>
                                            <h5 id="chatTitle">SINAU ADMIN</h5>
                                        </div>

                                        <div class="chat-messages" id="chatMessages">
                                            <div class="date-divider">
                                                <span>Rabu, 25 Februari 2025</span>
                                            </div>

                                            <div class="message received">
                                                <div class="message-bubble">
                                                    Halo kak terima kasih sudah menghubungi Admin Sinau. Untuk keperluan
                                                    detail order dan spesifikasi banner, kakak bisa pastikan desainnya
                                                    sesuaian dengan <strong>panduan kami</strong>.
                                                    <br><br>
                                                    Untuk detailnya nanti bisa dibicarakan😊
                                                    <div class="message-time">12:00 AM</div>
                                                </div>
                                            </div>

                                            {{-- <div class="message sent">
                                                <div class="message-bubble">
                                                    Apa bisa saya dateng ke store aja?
                                                    <div class="message-time">12:00 AM</div>
                                                </div>
                                            </div>

                                            <div class="message sent">
                                                <div class="message-bubble">
                                                    <div class="file-attachment">
                                                        <i class="fas fa-file-pdf me-2"></i>
                                                        design_print.pdf (12MB)
                                                    </div>
                                                    <div class="message-time">12:00 AM</div>
                                                </div>
                                            </div> --}}
                                        </div>

                                        <div class="chat-input">
                                            <div class="input-group">
                                                <div class="d-flex gap-2 w-100">
                                                    <button class="btn btn-link">
                                                        <i class="fas fa-paperclip"></i>
                                                    </button>
                                                    <input type="text" class="form-control"
                                                        placeholder="Tulis pesan di sini.." id="messageInput">
                                                    <button class="send-btn" onclick="sendMessage()">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
                                <script>
                                    // Data chat
                                    const chats = {
                                        'sinau-admin': {
                                            name: 'SINAU ADMIN',
                                            avatar: 'SA',
                                            messages: [{
                                                    type: 'received',
                                                    text: 'Halo kak terima kasih sudah menghubungi Admin Sinau. Untuk keperluan detail order dan spesifikasi banner, kakak bisa pastikan desainnya sesuaian dengan <strong>panduan kami</strong>.<br><br>Untuk detailnya nanti bisa dibicarakan😊',
                                                    time: '12:00 AM'
                                                },
                                            ]
                                        },
                                        'sinau-promo': {
                                            name: 'SINAUPROMO',
                                            avatar: 'SP',
                                            messages: [{
                                                    type: 'received',
                                                    text: 'Halo kak! Terima kasih sudah menghubungi tim promo kami.',
                                                    time: '10:30 AM'
                                                },
                                                {
                                                    type: 'received',
                                                    text: 'Ada promo menarik bulan ini lho!',
                                                    time: '10:31 AM'
                                                }
                                            ]
                                        }
                                    };

                                    let currentChat = 'sinau-admin';

                                    // Toggle sidebar untuk mobile
                                    function toggleSidebar() {
                                        const sidebar = document.getElementById('chatSidebar');
                                        sidebar.classList.toggle('show');
                                    }

                                    // Load chat messages
                                    function loadChat(chatId) {
                                        const chat = chats[chatId];
                                        if (!chat) return;

                                        currentChat = chatId;
                                        document.getElementById('chatTitle').textContent = chat.name;

                                        const messagesContainer = document.getElementById('chatMessages');
                                        messagesContainer.innerHTML = `
                                          <div class="date-divider">
                                              <span>Rabu, 25 Februari 2025</span>
                                          </div>
                                      `;

                                        chat.messages.forEach(message => {
                                            const messageDiv = document.createElement('div');
                                            messageDiv.className = `message ${message.type}`;

                                            let messageContent = '';
                                            if (message.type === 'received') {
                                                messageContent = `
                                                <div class="message-avatar">${chat.avatar}</div>
                                                <div class="message-bubble">
                                                    ${message.text}
                                                    <div class="message-time">${message.time}</div>
                                                </div>
                                            `;
                                            } else {
                                                messageContent = `
                                                <div class="message-bubble">
                                                    ${message.text}
                                                    <div class="message-time">${message.time}</div>
                                                </div>
                                            `;
                                            }

                                            messageDiv.innerHTML = messageContent;
                                            messagesContainer.appendChild(messageDiv);
                                        });

                                        // Scroll to bottom
                                        messagesContainer.scrollTop = messagesContainer.scrollHeight;

                                        // Update active chat item
                                        document.querySelectorAll('.chat-item').forEach(item => {
                                            item.classList.remove('active');
                                        });
                                        document.querySelector(`[data-chat="${chatId}"]`).classList.add('active');

                                        // Hide sidebar on mobile after selecting chat
                                        if (window.innerWidth <= 768) {
                                            document.getElementById('chatSidebar').classList.remove('show');
                                        }
                                    }

                                    // Send message
                                    function sendMessage() {
                                        const input = document.getElementById('messageInput');
                                        const messageText = input.value.trim();

                                        if (!messageText) return;

                                        // Add message to current chat data
                                        const currentTime = new Date().toLocaleTimeString('id-ID', {
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            hour12: true
                                        });

                                        if (!chats[currentChat].messages) {
                                            chats[currentChat].messages = [];
                                        }

                                        chats[currentChat].messages.push({
                                            type: 'sent',
                                            text: messageText,
                                            time: currentTime
                                        });

                                        // Add message to UI
                                        const messagesContainer = document.getElementById('chatMessages');
                                        const messageDiv = document.createElement('div');
                                        messageDiv.className = 'message sent';
                                        messageDiv.innerHTML = `
                <div class="message-bubble">
                    ${messageText}
                    <div class="message-time">${currentTime}</div>
                </div>
            `;

                                        messagesContainer.appendChild(messageDiv);
                                        messagesContainer.scrollTop = messagesContainer.scrollHeight;

                                        // Clear input
                                        input.value = '';

                                        // Simulate response after 1 second
                                        setTimeout(() => {
                                            const responseText = 'Terima kasih atas pesannya! Tim kami akan segera merespon.';

                                            chats[currentChat].messages.push({
                                                type: 'received',
                                                text: responseText,
                                                time: new Date().toLocaleTimeString('id-ID', {
                                                    hour: '2-digit',
                                                    minute: '2-digit',
                                                    hour12: true
                                                })
                                            });

                                            const responseDiv = document.createElement('div');
                                            responseDiv.className = 'message received';
                                            responseDiv.innerHTML = `
                    <div class="message-avatar">${chats[currentChat].avatar}</div>
                    <div class="message-bubble">
                        ${responseText}
                        <div class="message-time">${new Date().toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true
                        })}</div>
                    </div>
                `;

                                            messagesContainer.appendChild(responseDiv);
                                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                                        }, 1000);
                                    }

                                    // Event listeners
                                    document.addEventListener('DOMContentLoaded', function() {
                                        // Chat item click handlers
                                        document.querySelectorAll('.chat-item').forEach(item => {
                                            item.addEventListener('click', function() {
                                                const chatId = this.getAttribute('data-chat');
                                                loadChat(chatId);
                                            });
                                        });

                                        // Enter key to send message
                                        document.getElementById('messageInput').addEventListener('keypress', function(e) {
                                            if (e.key === 'Enter') {
                                                sendMessage();
                                            }
                                        });

                                        // Load initial chat
                                        loadChat('sinau-admin');
                                    });

                                    // Close sidebar when clicking outside on mobile
                                    document.addEventListener('click', function(e) {
                                        const sidebar = document.getElementById('chatSidebar');
                                        const toggleBtn = e.target.closest('.btn');

                                        if (window.innerWidth <= 768 &&
                                            !sidebar.contains(e.target) &&
                                            !toggleBtn) {
                                            sidebar.classList.remove('show');
                                        }
                                    });
                                </script>
                            </div>

                            {{-- Notifikasi --}}
                            <div class="tab-pane fade" id="pane-notif" role="tabpanel">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="section-pill"
                                        style="background-color: white; padding: 0 30px !important; margin-bottom:-20px !important">
                                        Semua Notifikasi</h4>
                                    <form method="GET" action="{{ url()->current() }}#pane-notif">
                                        <select name="sort" onchange="this.form.submit()" class="form-select w-auto"
                                            style="width:170px !important; height:40px !important; border-radius:70px; color:#888888; font-size:0.875rem; text-transform:uppercase; padding: 0 20px; appearance: none; background: url('data:image/svg+xml;charset=UTF-8,<svg fill=''%23333'' height=''<24>'' viewBox=''0 0 24 24'' width=''24'' xmlns=''http://www.w3.org/2000/svg''><path d=''M7 10l5 5 5-5z''/></svg>') no-repeat right 10px center; background-size: 16px;">
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Terbaru</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                                Terlama</option>
                                        </select>
                                    </form>
                                </div>
                                <p
                                    style="font-size: 0.8rem !important; margin-top:-10px; font-weight: 600; padding: 15px 30px !important; color: #888888">
                                    DATA PER HALAMAN 10</p>

                                @php
                                    $notifications = \App\Models\Notification::where('user_id', Auth::id())
                                        ->orderBy('notification_status', 'asc')
                                        ->orderBy('created_at', request('sort') == 'oldest' ? 'asc' : 'desc')
                                        ->paginate(10, ['*'], 'notif_page');
                                @endphp

                                <div class="list-group">
                                    @foreach ($notifications as $notif)
                                        @php
                                            $typeClass = match ($notif->notification_type) {
                                                'Pembelian' => 'badge-purchase',
                                                'Promo' => 'badge-promo',
                                                'Profil' => 'badge-profil',
                                                default => 'badge-profil',
                                            };
                                        @endphp

                                        <div class="list-group-item mb-2 p-3 {{ $notif->notification_status ? 'notification-read' : 'notification-unread' }}"
                                            style="border-radius: 10px; position: relative;"
                                            data-id="{{ $notif->id }}" onclick="markNotificationRead(this)">
                                            <div class="mb-1">
                                                @if ($notif->notification_type)
                                                    <span class="notification-badge {{ $typeClass }}">
                                                        {{ strtoupper($notif->notification_type) }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h6 class="mb-1"
                                                style="font-weight: 600; color:#000; font-family: 'Poppins', sans-serif; text-transform: uppercase; margin-bottom:16px !important; margin-top:16px !important;">
                                                {{ $notif->notification_head ?? 'Notifikasi' }}
                                            </h6>
                                            <p class="mb-2"
                                                style="font-weight: 500; font-size: 0.9rem; color:#444; font-family: 'Poppins', sans-serif;">
                                                {{ $notif->notification_body }}</p>
                                            <div class="text-end">
                                                <small class="text-muted"
                                                    style="font-weight: 600; font-size: 0.9rem; color:#888888 !important; font-family: 'Poppins', sans-serif;">{{ $notif->created_at->format('d M Y') }}</small>
                                            </div>
                                        </div>
                                    @endforeach

                                    @if ($notifications->isEmpty())
                                        <div class="text-center py-4 text-muted">Tidak ada notifikasi ditemukan.</div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $notifications->appends(request()->except('page'))->fragment('pane-notif')->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hash = window.location.hash;
            if (hash === '#pane-notif') {
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('show', 'active'));
                document.querySelectorAll('.nav-link').forEach(n => n.classList.remove('active'));
                document.getElementById('tab-notif')?.classList.add('active');
                document.getElementById('pane-notif')?.classList.add('show', 'active');
            }

            const btnEdit = document.getElementById('btnEdit');
            const btnSave = document.getElementById('btnSave');
            const btnCancel = document.getElementById('btnCancel');
            const form = document.getElementById('formProfile');
            const viewPass = document.getElementById('viewPassword');
            const editPassFields = document.getElementById('editPasswordFields');

            const formFields = form.querySelectorAll('input.form-control, select.form-control');

            const initialFormData = {};
            formFields.forEach(input => {
                if (input.name) {
                    initialFormData[input.name] = input.value;
                }
            });

            function setFormEditable(isEditable) {
                formFields.forEach(input => input.disabled = !isEditable);
                btnSave.classList.toggle('d-none', !isEditable);
                btnCancel.classList.toggle('d-none', !isEditable);
                btnEdit.classList.toggle('d-none', isEditable);
                viewPass.classList.toggle('d-none', isEditable);
                editPassFields.classList.toggle('d-none', !isEditable);
            }

            btnEdit?.addEventListener('click', () => setFormEditable(true));

            btnCancel?.addEventListener('click', () => {
                formFields.forEach(input => {
                    if (initialFormData.hasOwnProperty(input.name)) {
                        input.value = initialFormData[input.name];
                    }
                });
                ['currentPassword', 'newPassword', 'confirmPassword'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.value = '';
                });
                setFormEditable(false);
            });

            btnSave?.addEventListener('click', () => {
                // opsional: validasi manual di sini
            });

            @if ($errors->any())
                setFormEditable(true);
            @else
                setFormEditable(false);
            @endif
        });

        function toggleEye(fieldId, btn) {
            const inp = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            inp.type = inp.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>

    <script>
        async function markNotificationRead(el) {
            const notifId = el.getAttribute('data-id');
            const response = await fetch(`/readnotif/${notifId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });

            if (response.ok) {
                el.classList.add('notification-read');
                el.classList.remove('notification-unread');
            }
        }
    </script>
@endsection
