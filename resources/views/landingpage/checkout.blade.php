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

        .btn-order {
            background-color: #0258d3;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
            width: 100%;
        }

        .btn-order:hover {
            background-color: #0439a0;
            color: white;
        }

        .btn-order:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0258d3;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .checkout-page .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .checkout-page .card h5 {
            margin-bottom: 1rem;
        }
        #promoCodeInput::placeholder {
            color: #999;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }
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

        .btn-order {
            background-color: #0258d3;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
            width: 100%;
        }

        .btn-order:hover {
            background-color: #0439a0;
            color: white;
        }

        .btn-order:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0258d3;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .checkout-page .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .checkout-page .card h5 {
            margin-bottom: 1rem;
        }

        #promoCodeInput::placeholder {
            color: #999;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .container.product-card {
                margin-top: -60px !important;
                padding: 0 15px !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .row.g-5 {
                margin: 0 !important;
                gap: 0 !important;
                flex-direction: column !important;
                width: 100% !important;
            }

            .col-lg-8 {
                margin-left: 0 !important;
                padding: 0 15px !important;
                margin-bottom: 20px;
                order: 1;
                max-width: 100% !important;
                width: 100% !important;
            }

            .col-lg-3 {
                padding: 0 15px !important;
                order: 2;
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 99999 !important;
                background: white !important;
                box-shadow: 0 -4px 20px rgba(0,0,0,0.15) !important;
                border-top: 2px solid #e9ecef !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .col-lg-3 .card {
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
                background: transparent !important;
                padding: 15px !important;
            }

            .section-pill {
                font-size: 1.2rem !important;
                padding: 12px 20px !important;
                margin-bottom: 12px !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .form-control {
                height: 50px !important;
                font-size: 14px !important;
                width: 100% !important;
            }

            .form-label {
                font-size: 0.75rem !important;
                margin-bottom: 5px !important;
            }
            .mobile-billing-summary {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 15px;
                margin-bottom: 12px;
                border: 1px solid #e9ecef;
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .mobile-product-info {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 12px;
                width: 100% !important;
            }

            .mobile-product-image {
                width: 60px;
                height: 60px;
                border-radius: 8px;
                object-fit: cover;
                flex-shrink: 0;
                border: 1px solid #e9ecef;
            }

            .mobile-product-details {
                flex: 1;
                min-width: 0;
            }

            .mobile-product-details h6 {
                font-size: 13px !important;
                font-weight: 600 !important;
                margin-bottom: 4px !important;
                line-height: 1.3;
                color: #333;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .mobile-product-details small {
                font-size: 11px !important;
                color: #666 !important;
                display: block;
                line-height: 1.2;
            }

            .mobile-product-price {
                font-size: 13px !important;
                font-weight: 600 !important;
                color: #0258d3 !important;
                text-align: right;
                white-space: nowrap;
            }

            .mobile-cost-breakdown {
                border-top: 1px solid #dee2e6;
                padding-top: 10px;
                width: 100% !important;
            }

            .mobile-cost-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 6px;
                font-size: 12px !important;
                font-family: 'Poppins', sans-serif;
                width: 100% !important;
            }

            .mobile-cost-item.total {
                font-weight: 600 !important;
                font-size: 14px !important;
                border-top: 1px solid #dee2e6;
                padding-top: 6px;
                margin-top: 6px;
                color: #0258d3;
            }

            .mobile-cost-item.discount {
                color: #dc3545 !important;
            }

            .btn-order {
                font-size: 14px !important;
                padding: 12px 20px !important;
                margin: 10px 0 5px 0 !important;
                border-radius: 8px !important;
                font-weight: 600;
                width: 100% !important;
            }
            .mobile-promo-section {
                margin-top: 20px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 12px;
                border: 1px solid #e9ecef;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100% !important;
                box-sizing: border-box;
            }

            .mobile-promo-section .form-label {
                font-size: 13px !important;
                margin-bottom: 8px !important;
                color: #333;
                font-weight: 600;
                display: block;
                width: 100%;
            }

            .mobile-promo-section .input-group {
                width: 100% !important;
                display: flex !important;
                flex-wrap: nowrap !important;
                align-items: stretch !important;
            }

            .mobile-promo-section .input-group input {
                font-size: 13px !important;
                height: 42px !important;
                border-radius: 8px 0 0 8px !important;
                flex: 1 !important;
                width: auto !important;
                min-width: 0 !important;
                border-right: 0 !important;
            }

            .mobile-promo-section .input-group button {
                font-size: 12px !important;
                padding: 8px 12px !important;
                border-radius: 0 8px 8px 0 !important;
                white-space: nowrap !important;
                flex-shrink: 0 !important;
                width: auto !important;
                border-left: 0 !important;
            }

            .mobile-promo-section small {
                font-size: 11px !important;
                margin-top: 5px !important;
                display: block;
                width: 100%;
            }

            main {
                padding-bottom: 160px !important;
                width: 100% !important;
                overflow-x: hidden !important;
            }

            .cta-overlay h3 {
                font-size: 2rem !important;
                margin-bottom: 10px !important;
            }

            .breadcrumb {
                font-size: 0.75rem !important;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                font-size: 0.75rem !important;
            }

            .col-md-6, .col-md-12 {
                margin-bottom: 15px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .row {
                margin-left: -15px !important;
                margin-right: -15px !important;
                width: calc(100% + 30px) !important;
            }

            .form-group {
                margin-bottom: 15px !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .whatsapp-float {
                bottom: 180px !important;
                z-index: 999 !important;
            }

            .container-fluid.copyright {
                display: none !important;
            }
            
            .container-fluid.footer .container.py-4 {
                display: none !important;
            }

            body {
                overflow-x: hidden !important;
            }

            .cta-overlay {
                top: 55% !important;
            }
        }

        @media (max-width: 480px) {
            .container.product-card {
                margin-top: -40px !important;
                padding: 0 10px !important;
            }

            .col-lg-8 {
                padding: 0 10px !important;
            }

            .col-lg-3 {
                padding: 0 10px !important;
            }

            .col-lg-3 .card {
                padding: 10px !important;
            }

            .section-pill {
                font-size: 1.1rem !important;
                padding: 10px 15px !important;
            }

            .form-control {
                height: 45px !important;
                font-size: 13px !important;
            }

            .cta-overlay h3 {
                font-size: 1.7rem !important;
            }

            .mobile-product-image {
                width: 50px;
                height: 50px;
            }

            .mobile-product-details h6 {
                font-size: 12px !important;
            }

            .mobile-cost-item {
                font-size: 11px !important;
            }

            .mobile-cost-item.total {
                font-size: 13px !important;
            }

            main {
                padding-bottom: 180px !important;
            }

            .whatsapp-float {
                bottom: 200px !important;
            }

            .col-md-6, .col-md-12 {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .row {
                margin-left: -10px !important;
                margin-right: -10px !important;
                width: calc(100% + 20px) !important;
            }
        }

        @media (min-width: 769px) {
            .container-fluid.footer .container.py-4,
            .container-fluid.copyright {
                display: block !important;
            }
        }
    </style>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="position-relative mb-0">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
            <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%; width: 90%;">
                <!-- WRAPPER BARU untuk greeting + logout -->
                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                    <h3 class="mb-0" style="font-family:'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">
                        Checkout Produk
                    </h3>
                </div>

                <!-- Breadcrumb tetap di bawah -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-family:'Poppins'; font-size:0.85rem; font-weight:500;">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">BERANDA</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/products') }}">SEMUA PRODUK</a></li>
                        <li class="breadcrumb-item active" aria-current="page">CHECKOUT</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <main>
        <div class="container-fluid px-4">
            <div class="container product-card" style="margin-top:-150px;">
                <div class="row g-5" style="margin-top:5px;">

                    <div class="col-lg-8" style="margin-left:40px;">
                        <div class="tab-content" id="sidebarTabsContent">
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
                                    <h4 class="section-pill">Pengiriman</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PROVINSI</label>
                                            <select name="province"
                                                class="form-control" disabled>
                                                <option value="{{ old('province', $provinceName ?? '-') }}">{{ old('province', $provinceName ?? '-') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">KOTA/KABUPATEN</label>
                                            <select name="province"
                                                class="form-control" disabled>
                                                <option value="{{ old('province', $districtName ?? '-') }}">{{ old('province', $districtName ?? '-') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">KECAMATAN</label>
                                            <select name="city"
                                                class="form-control" disabled>
                                                <option value="{{ old('city', $cityName ?? '-') }}">{{ old('city', $cityName ?? '-') }}
                                                </option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">KODE POS</label>
                                            <input name="postal_code" type="text"
                                                class="form-control"
                                                value="{{ old('postal_code', Auth::user()->postal_code) }}" disabled>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">DETAIL ALAMAT PENGIRIMAN</label>
                                            <textarea name="address" id="" style="height: 100px" class="form-control p-4" disabled>{{ old('address', Auth::user()->address) }}</textarea>
                                            
                                        </div>
                                       
                                        {{-- METODE PENGIRIMAN --}}
                                        <div class="mb-3">
                                            <label class="form-label"><b>METODE PENGIRIMAN</b></label>
                                            @if (!$isset)
                                                <div class="mb-3">
                                                    <select 
                                                        id="deliveryMethod" 
                                                        name="kurir" 
                                                        class="form-select @error('kurir') is-invalid @enderror"
                                                        style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;" 
                                                        disabled>
                                                        <option value="0" selected>
                                                            Lengkapi data alamat Anda di menu Profil
                                                        </option> 
                                                    </select>
                                                    <div class="mt-1">
                                                        <a href="{{ url('/profile?#pane-profile') }}" class="btn-cancel">
                                                            <i class="bi bi-geo-alt-fill"></i> Lengkapi Alamat Anda
                                                        </a>
                                                    </div>
                                                </div>
                                            @else

                                                <select 
                                                    id="deliveryMethod" 
                                                    name="kurir" 
                                                    class="form-select @error('kurir') is-invalid @enderror"
                                                    style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;" >
                                                    <option value="0" {{ old('kurir','0')=='0'?'selected':'' }}>
                                                        Memuat data ongkir...
                                                    </option> 
                                                </select>
                                            @endif

                                            @error('kurir')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Pembayaran --}}
                                    <h4 class="section-pill">Pembayaran</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PILIHAN PEMBAYARAN</label>
                                            <select name="transaction_method"
                                                class="form-control @error('transaction_method') is-invalid @enderror">
                                                <option value="midtrans">Midtrans (Semua Metode)</option>
                                            </select>
                                            @error('transaction_method')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Catatan Tambahan --}}
                                    <h4 class="section-pill">Catatan Tambahan</h4>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">CATATAN TAMBAHAN</label>
                                            <input id="notesInput" name="notes" type="text"
                                                class="form-control @error('notes') is-invalid @enderror"
                                                value="{{ old('notes', $order->notes) }}">
                                            @error('notes')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-block d-md-none mobile-promo-section">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Promo</label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    id="mobilePromoCodeInput"
                                                    name="promo_code_mobile"
                                                    class="form-control"
                                                    placeholder="Masukkan kode promo">
                                                <button
                                                    type="button"
                                                    id="mobileApplyPromoBtn"
                                                    class="btn btn-outline-primary">
                                                    Apply
                                                </button>
                                            </div>
                                            <small id="mobilePromoMessage" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Billing Information Sidebar --}}
                    <div class="col-lg-3">
                        <div class="card p-4" style="border-radius:15px; width: 300px;">
                            <!-- Mobile Version -->
                            <div class="d-block d-md-none">
                                <div class="mobile-billing-summary">
                                    <div class="mobile-product-info">
                                        @php
                                            $image = $item->product->images->first();
                                            $imageSrc = asset('landingpage/img/nophoto.png');

                                            if($image && $image->image_product) {
                                                $imagePath = storage_path('app/public/' . $image->image_product);
                                                if(file_exists($imagePath)) {
                                                    $imageSrc = asset('storage/' . $image->image_product);
                                                }
                                            }
                                        @endphp
                                        <img src="{{ $imageSrc }}" alt="Product" class="mobile-product-image">
                                        <div class="mobile-product-details">
                                            <h6>{{ $item->product->label->name }} – {{ $item->product->name }}</h6>
                                            <small>{{ intval($item->length) }} x {{ intval($item->width) }} {{ $item->product->additional_unit }}</small>
                                            <small>Bahan: {{ $item->product->name ?? '-' }}</small>
                                        </div>
                                        <div class="mobile-product-price">
                                            Rp {{ number_format($item->subtotal,0,',','.') }}
                                        </div>
                                    </div>
                                    
                                    <div class="mobile-cost-breakdown">
                                        <div class="mobile-cost-item">
                                            <span>Subtotal</span>
                                            <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                                        </div>
                                        @if($order->express == 1)
                                            <div class="mobile-cost-item" style="color: #000 !important;">
                                                <span>Express (+50%)</span>
                                                <span id="mobile-express-fee">Rp {{ number_format($expressFee,0,',','.') }}</span>
                                            </div>
                                        @endif
                                        <div class="mobile-cost-item">
                                            <span>Ongkir</span>
                                            <span id="mobile-shipping-cost">Rp 0</span>
                                        </div>
                                        <div class="mobile-cost-item discount" id="mobile-discount-line" style="display: none;">
                                            <span>Potongan Promo</span>
                                            <span id="mobile-discount-amount">-Rp 0</span>
                                        </div>
                                        <div class="mobile-cost-item total">
                                            <span>Total</span>
                                            <span id="mobile-total-amount">Rp {{ number_format($item->subtotal + ($expressFee ?? 0),0,',','.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button id="btnOrder" type="button" class="btn-order">Order Sekarang</button>
                            </div>

                            <!-- Desktop Version -->
                            <div class="d-none d-md-block">
                                <h5 class="mb-0" style="text-align:center; font-family:'Poppins'; font-size:1.2rem; font-weight:600;">Billing Information</h5>
                                <hr>
                                <div class="mb-3">
                                    <span style="font-family:'Poppins'; font-size:0.875rem; font-weight:600;">Produk</span>
                                </div>
                                <div class="mb-0">
                                    <small style="font-family:'Poppins'; font-size:0.875rem; font-weight:500;">{{ $item->product->label->name }} – {{ $item->product->name }}</small>
                                </div>
                                <hr>
                                <div class="mb-0">
                                    <small style="font-family:'Poppins'; font-size:0.875rem; font-weight:500; color:#888888">Detail</small>
                                </div>
                                <div class="mb-0" style="font-family:'Poppins'; font-size:0.8rem; font-weight:550; color:#c3c3c3">
                                    <small>Bahan: {{ $item->product->name ?? '-' }}</small><br>
                                    <small>Ukuran: {{ intval($item->length) }} x {{ intval($item->width) }} {{ $item->product->additional_unit }}</small><br>
                                    <small>File Desain: 
                                        @if($order->order_design) 
                                            <a href="{{ asset('landingpage/img/design/'.$order->order_design) }}" target="_blank" style="font-family:'Poppins'; font-size:0.7rem !important; font-weight:550; color:#c3c3c3">{{ $order->order_design }}</a>
                                        @else
                                            -
                                        @endif
                                    </small><br>
                                    <small>Catatan: {{ $order->notes ?? '-' }}</small><br>
                                </div><br>
                                <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                    <span>Biaya Ongkir</span>
                                    <span id="shippingCost">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                                </div>
                                @if($order->express == 1)
                                    <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                        <span>Express (+50%)</span>
                                        <span id="expressFee">Rp {{ number_format($expressFee,0,',','.') }}</span>
                                    </div>
                                @endif
                                {{-- <div id="discountLine" class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#fc2865 !important;">
                                    <span>Potongan Promo</span>
                                    <span id="discountAmount">-Rp 0</span>
                                </div> --}}
                                <hr>
                                <div class="d-flex justify-content-between mb-4" style="font-family:'Poppins'; font-size:1rem !important; font-weight:550 !important; color:#000 !important;">
                                    <strong>Total</strong>
                                    <strong id="totalAmount">Rp {{ number_format($item->subtotal + ($expressFee ?? 0),0,',','.') }}</strong>
                                </div>
                                <button id="btnOrderDesktop" type="button" class="btn-order">Order Sekarang</button>
                                <br><br>
                                <div class="mb-3">
                                    <span class="form-label">Kode Promo</span>
                                    <div class="input-group">
                                        <input
                                        type="text"
                                        id="promoCodeInput"
                                        name="promo_code"
                                        class="form-control"
                                        placeholder="Masukkan kode promo"
                                        style="
                                            border-top-left-radius: 1rem !important;
                                            border-bottom-left-radius: 1rem !important;
                                            border-top-right-radius: 0 !important;
                                            border-bottom-right-radius: 0 !important;">
                                        <button
                                        type="button"
                                        id="applyPromoBtn"
                                        class="btn btn-outline-primary"
                                        style="
                                            border-top-left-radius: 0 !important;
                                            border-bottom-left-radius: 0 !important;
                                            border-top-right-radius: 1rem !important;
                                            border-bottom-right-radius: 1rem !important;
                                            margin-left: -1px;
                                            font-size: 0.8rem !important;
                                            border-left: 0;">
                                        Apply
                                        </button>
                                    </div>
                                    <small id="promoMessage" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Hidden inputs -->
    <input type="hidden" id="subtotal" value="{{ $item->subtotal }}">
    <input type="hidden" id="orderId" value="{{ $order->id }}">

    <script>
        let baseSubtotal, expressAmount, baseWithExpress, ongkirCost, promoDiscount;
        let deliverySelect, shippingEl, totalEl, mobileShippingEl, mobileTotalEl;
        let orderId, btnOrder, btnOrderDesktop, loadingOverlay;
        let mobileDiscountLine, mobileDiscountAmtEl, discountLine, discountAmtEl;
        let promoInput, applyPromoBtn, promoMessage, mobilePromoInput, mobileApplyPromoBtn, mobilePromoMessage;
        let hiddenPromo, hiddenPromoDiscount;

        document.addEventListener('DOMContentLoaded', function() {
            const subtotalInput = document.getElementById('subtotal');
            if (!subtotalInput) {
                console.error('subtotal input not found!');
                return;
            }
            
            baseSubtotal = parseFloat(subtotalInput.value) || 0;
            expressAmount = {{ $expressFee ?? 0 }};
            baseWithExpress = baseSubtotal + expressAmount;
            ongkirCost = 0;
            promoDiscount = 0;
            
            deliverySelect = document.getElementById('deliveryMethod');
            shippingEl = document.getElementById('shippingCost');
            totalEl = document.getElementById('totalAmount');
            mobileShippingEl = document.getElementById('mobile-shipping-cost');
            mobileTotalEl = document.getElementById('mobile-total-amount');
            mobileDiscountLine = document.getElementById('mobile-discount-line');
            mobileDiscountAmtEl = document.getElementById('mobile-discount-amount');
            
            orderId = document.getElementById('orderId').value;
            btnOrder = document.getElementById('btnOrder');
            btnOrderDesktop = document.getElementById('btnOrderDesktop');
            loadingOverlay = document.getElementById('loading-overlay');
            
            promoInput = document.getElementById('promoCodeInput');
            applyPromoBtn = document.getElementById('applyPromoBtn');
            promoMessage = document.getElementById('promoMessage');
            mobilePromoInput = document.getElementById('mobilePromoCodeInput');
            mobileApplyPromoBtn = document.getElementById('mobileApplyPromoBtn');
            mobilePromoMessage = document.getElementById('mobilePromoMessage');

            hiddenPromo = document.createElement('input');
            hiddenPromo.type = 'hidden';
            hiddenPromo.name = 'promo_code';
            hiddenPromo.id = 'hiddenPromoCode';
            document.body.appendChild(hiddenPromo);

            hiddenPromoDiscount = document.createElement('input');
            hiddenPromoDiscount.type = 'hidden';
            hiddenPromoDiscount.name = 'promo_discount';
            hiddenPromoDiscount.id = 'hiddenPromoDiscount';
            document.body.appendChild(hiddenPromoDiscount);

            discountLine = null; // Akan dibuat secara dinamis di computeTotal()
            discountAmtEl = null;

            setupEventListeners();
            
            computeTotal();
        });

        function formatRp(x) {
            return 'Rp ' + Math.round(x).toLocaleString('id-ID');
        }

        function computeTotal() {            
            let discountAmount = promoDiscount;
            if (discountAmount > baseWithExpress) {
                discountAmount = baseWithExpress;
            }
            
            const afterDiscount = baseWithExpress - discountAmount;
            const finalTotal = afterDiscount + ongkirCost;
            
            const formattedShipping = formatRp(ongkirCost);
            if (shippingEl) shippingEl.textContent = formattedShipping;
            if (mobileShippingEl) mobileShippingEl.textContent = formattedShipping;
            
            const formattedTotal = formatRp(finalTotal);
            if (totalEl) totalEl.textContent = formattedTotal;
            if (mobileTotalEl) mobileTotalEl.textContent = formattedTotal;
            
            if (discountAmount > 0) {
                const formattedDiscount = '-' + formatRp(discountAmount);
                
                if (!discountLine) {
                    discountLine = document.createElement('div');
                    discountLine.id = 'discountLine';
                    discountLine.className = 'd-flex justify-content-between mb-2';
                    discountLine.style.fontFamily = "'Poppins'";
                    discountLine.style.fontSize = '0.9rem';
                    discountLine.style.fontWeight = '550';
                    discountLine.style.color = '#fc2865';
                    
                    const discountLabel = document.createElement('span');
                    discountLabel.textContent = 'Potongan Promo';
                    
                    discountAmtEl = document.createElement('span');
                    discountAmtEl.id = 'discountAmount';
                    
                    discountLine.appendChild(discountLabel);
                    discountLine.appendChild(discountAmtEl);
                    
                    if (totalEl) {
                        const totalDiv = totalEl.closest('.d-flex');
                        const hrBefore = totalDiv.previousElementSibling;
                        hrBefore.parentNode.insertBefore(discountLine, hrBefore);
                    }
                }
                
                discountLine.style.display = 'flex';
                if (discountAmtEl) discountAmtEl.textContent = formattedDiscount;
                
                if (mobileDiscountLine) {
                    mobileDiscountLine.style.display = 'flex';
                    if (mobileDiscountAmtEl) mobileDiscountAmtEl.textContent = formattedDiscount;
                }
            } else {
                if (discountLine) discountLine.style.display = 'none';
                if (mobileDiscountLine) mobileDiscountLine.style.display = 'none';
            }
            
            if (hiddenPromoDiscount) hiddenPromoDiscount.value = discountAmount;
            
            // console.log('Total updated to:', formattedTotal);
        }

        function setupEventListeners() {
            if (deliverySelect) {
                deliverySelect.addEventListener('change', function() {
                    const selectedOption = this.selectedOptions[0];
                    if (selectedOption && selectedOption.hasAttribute('data-cost')) {
                        ongkirCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;
                        computeTotal();
                    }
                });
            }

            if (applyPromoBtn && promoInput) {
                applyPromoBtn.addEventListener('click', function() {
                    handlePromoApplication(promoInput, promoMessage);
                });
                
                promoInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        handlePromoApplication(promoInput, promoMessage);
                    }
                });
            }

            if (mobileApplyPromoBtn && mobilePromoInput) {
                mobileApplyPromoBtn.addEventListener('click', function() {
                    handlePromoApplication(mobilePromoInput, mobilePromoMessage);
                });
                
                mobilePromoInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        handlePromoApplication(mobilePromoInput, mobilePromoMessage);
                    }
                });
            }

            if (btnOrder) {
                btnOrder.addEventListener('click', handleOrderClick);
            }
            if (btnOrderDesktop) {
                btnOrderDesktop.addEventListener('click', handleOrderClick);
            }
        }

        function handlePromoApplication(inputElement, messageElement) {
            const code = inputElement.value.trim();
            if (!code) {
                updatePromoMessage('Masukkan kode promo dulu.', 'error', messageElement);
                return;
            }

            fetch(`/promo/check?code=${encodeURIComponent(code)}&subtotal=${baseSubtotal}&express_fee=${expressAmount}`)
            .then(res => res.json())
            .then(json => {
                if (!json.valid) {
                    promoDiscount = 0;
                    hiddenPromo.value = '';
                    updatePromoMessage(json.message, 'error', messageElement);
                    
                    if (inputElement === mobilePromoInput && promoInput) {
                        promoInput.value = '';
                    } else if (inputElement === promoInput && mobilePromoInput) {
                        mobilePromoInput.value = '';
                    }
                } else {
                    promoDiscount = json.diskon;
                    hiddenPromo.value = code;
                    updatePromoMessage(json.message, 'success', messageElement);
                    
                    if (inputElement === mobilePromoInput && promoInput) {
                        promoInput.value = code;
                    } else if (inputElement === promoInput && mobilePromoInput) {
                        mobilePromoInput.value = code;
                    }
                }
                computeTotal();
            })
            .catch(() => {
                updatePromoMessage('Gagal cek promo. Coba lagi.', 'error', messageElement);
            });
        }

        function updatePromoMessage(message, type, messageElement) {
            if (!messageElement) return;
            
            messageElement.innerText = message;
            messageElement.classList.remove('text-success', 'text-danger');
            
            if (type === 'success') {
                messageElement.classList.add('text-success');
            } else {
                messageElement.classList.add('text-danger');
            }
            
            const otherMessageElement = messageElement === mobilePromoMessage ? promoMessage : mobilePromoMessage;
            if (otherMessageElement) {
                otherMessageElement.innerText = message;
                otherMessageElement.classList.remove('text-success', 'text-danger');
                if (type === 'success') {
                    otherMessageElement.classList.add('text-success');
                } else {
                    otherMessageElement.classList.add('text-danger');
                }
            }
        }

        function handleOrderClick() {
            if (!deliverySelect || deliverySelect.value === '0') {
                alert('Silakan pilih metode pengiriman terlebih dahulu!');
                return;
            }

            const payload = {
                kurir: deliverySelect.value,
                ongkir: ongkirCost,
                notes: document.getElementById('notesInput') ? document.getElementById('notesInput').value : '',
                promo_code: hiddenPromo.value,
                promo_discount: promoDiscount
            };

            if (loadingOverlay) loadingOverlay.style.display = 'flex';
            if (btnOrder) btnOrder.disabled = true;
            if (btnOrderDesktop) btnOrderDesktop.disabled = true;

            fetch(`/checkout/pay/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                if (loadingOverlay) loadingOverlay.style.display = 'none';
                if (btnOrder) btnOrder.disabled = false;
                if (btnOrderDesktop) btnOrderDesktop.disabled = false;

                if (!data.success) {
                    alert('Error: ' + data.message);
                    return;
                }

                // Snap Midtrans
                if (typeof snap !== 'undefined') {
                    snap.pay(data.snap_token, {
                        onSuccess: res => {
                            fetch(`/checkout/payment-success/${orderId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    transaction_id: res.transaction_id,
                                    notes: payload.notes,
                                    kurir: payload.kurir,
                                    ongkir: payload.ongkir,
                                    promo_discount: payload.promo_discount
                                })
                            })
                            .then(r => {
                                if (r.ok) {
                                    window.location.href = '/keranjang';
                                } else {
                                    alert('Gagal update order');
                                }
                            });
                        },
                        onPending: () => window.location.href = '/keranjang',
                        onError: err => alert('Pembayaran gagal: ' + err.status_message),
                        onClose: () => alert('Anda menutup popup tanpa membayar')
                    });
                }
            })
            .catch(err => {
                if (loadingOverlay) loadingOverlay.style.display = 'none';
                if (btnOrder) btnOrder.disabled = false;
                if (btnOrderDesktop) btnOrderDesktop.disabled = false;
                // console.error(err);
                alert('Kesalahan jaringan, coba ulang.');
            });
        }
    </script>

    @if ($isset)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const deliveryMethod = document.getElementById('deliveryMethod');

                fetch('/hitung-ongkir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    deliveryMethod.innerHTML = '';

                    const services = Array.isArray(data.details)
                        ? data.details
                        : (data.details && data.details.costs ? data.details.costs : []);

                    if (services.length) {
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '0';
                        defaultOption.textContent = 'Pilih Metode Pengiriman';
                        deliveryMethod.appendChild(defaultOption);

                        services.forEach(item => {
                            let costValue;
                            if (Array.isArray(item.cost)) {
                                costValue = item.cost[0]?.value ?? 0;
                            } else {
                                costValue = item.cost || 0;
                            }

                            const option = document.createElement('option');
                            option.value = `${item.code}:${item.service}`;
                            option.textContent = `${item.name || item.code} - ${item.service} (Rp ${costValue.toLocaleString('id-ID')})`;
                            option.setAttribute('data-cost', costValue);
                            deliveryMethod.appendChild(option);
                        });

                    } else {
                        const option = document.createElement('option');
                        option.value = '0';
                        option.textContent = 'Tidak ada layanan pengiriman';
                        deliveryMethod.appendChild(option);
                    }
                })
                .catch(error => {
                    // console.error('Error:', error);
                    deliveryMethod.innerHTML = '<option value="0">Gagal memuat ongkir</option>';
                });
            });
        </script>
    @endif
@endsection