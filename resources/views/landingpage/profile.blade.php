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
            color: #8888 !important;
            font-weight: 500;
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
                            <a class="nav-link" href="{{ route('landingpage.chats') }}">Chat
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
                                            <th style="font-weight: 450 !important; width:130px; font-size: 0.9rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Pesanan Saya</th>
                                            <th style="font-weight: 450 !important; width:130px; font-size: 0.9rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Tanggal</th>
                                            <th style="font-weight: 450 !important; width:130px; font-size: 0.9rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Total</th>
                                            <th style="font-weight: 450 !important; width:130px; font-size: 0.9rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Status</th>
                                            <th style="font-weight: 450 !important; width:130px; font-size: 0.9rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Estimasi</th>
                                            <th style="font-weight: 450 !important; width:130px; font-size: 0.9rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr class="border-bottom">
                                                <td style="font-weight: 400 !important; padding: 20px 10px; font-size: 0.8rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">{{ 'INV' . substr($order->spk, 3, strpos($order->spk, '-') - 3) }}</td>
                                                <td style="font-weight: 400 !important; padding: 20px 10px; font-size: 0.8rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">{!! $order->created_at->locale('id')->translatedFormat('l, d M') . '<br>' . $order->created_at->translatedFormat('Y') !!}</td>
                                                <td style="font-weight: 400 !important; padding: 20px 10px; font-size: 0.8rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                                <td style="font-weight: 400 !important; padding: 20px 10px; font-size: 0.8rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">
                                                    @php
                                                    switch 
                                                    ($order->order_status) {
                                                    case 0:
                                                        $badge = '#ffd782';
                                                        $foncol= '#444444';
                                                        $firlabel = 'Menunggu';
                                                        $seclabel = 'Pembayaran';
                                                        break;
                                                    case 1:
                                                        $badge = '#5ee3e3';
                                                        $foncol= '#444444';
                                                        $firlabel = 'Dalam';
                                                        $seclabel = 'Pengerjaan';
                                                        break;
                                                    case 2:
                                                        $badge = '#abceff';
                                                        $foncol= '#444444';
                                                        $firlabel = 'Dalam';
                                                        $seclabel = 'Pengiriman';
                                                        break;
                                                    case 3:
                                                        $badge = '#0258d3';
                                                        $foncol= '#fff';
                                                        $firlabel = 'Pesanan';
                                                        $seclabel = 'Selesai';
                                                        break;
                                                        } @endphp
                                                    <span class="badge" style="display: block;width: 100%;text-align: left;font-weight: 450 !important; padding: 10px 25px 10px 10px; font-size: 0.75rem !important; background-color: {{ $badge }}; color:{{ $foncol }} !important; font-family: 'Poppins', sans-serif; border-radius:4px;">{{ $firlabel }} <br> {{ $seclabel }}</span>
                                                </td>
                                                <td style="font-weight: 400 !important; padding: 20px 10px; font-size: 0.8rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">{{ $order->estimasi ?? '-' }}</td>
                                                <td style="font-weight: 400 !important; padding: 20px 10px; font-size: 0.8rem !important; color:#000 !important; font-family: 'Poppins', sans-serif;">
                                                    @if ($order->order_status == 0)
                                                        <a href="{{ route('checkout.order', $order->id) }}"
                                                        class="btn btn-sm rounded-pill mb-1"
                                                        style="display:block; width:100%; text-align:center;
                                                                font-weight:450!important; padding:3px 10px;
                                                                font-size:0.77rem!important; background-color:#0258d3;
                                                                color:#fff!important; font-family:'Poppins',sans-serif;">
                                                            BAYAR
                                                        </a>

                                                        <button class="btn btn-sm rounded-pill mb-1" style="border-color:#8888;display: block;width: 100%;text-align: center;font-weight: 450 !important; padding: 3px 10px; font-size: 0.77rem !important; background-color:none; color:#000 !important; font-family: 'Poppins', sans-serif;">LIHAT ORDER</button>
                                                        <button class="btn btn-sm rounded-pill" style="display: block;width: 100%;text-align: center;font-weight: 450 !important; padding: 3px 10px; font-size: 0.77rem !important; background-color:#fc2865; color:#fff !important; font-family: 'Poppins', sans-serif;">BATALKAN</button>
                                                    @else
                                                        <button class="btn btn-sm rounded-pill" style="border-color:#8888;display: block;width: 100%;text-align: center;font-weight: 450 !important; padding: 3px 10px; font-size: 0.77rem !important; background-color:none; color:#000 !important; font-family: 'Poppins', sans-serif;">LIHAT ORDER</button>
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
