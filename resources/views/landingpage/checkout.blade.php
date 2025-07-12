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
                                        {{-- METODE PENGIRIMAN --}}
                                        <div class="mb-3">
                                            <label class="form-label"><b>METODE PENGIRIMAN</b></label>
                                            @if (!$isset)
                                                <select 
                                                    id="deliveryMethod" 
                                                    name="kurir" 
                                                    class="form-select @error('kurir') is-invalid @enderror"
                                                    style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;" 
                                                    disabled>
                                                    <option value="0" {{ old('kurir','0')=='0'?'selected':'' }}>
                                                        LENGKAPI DATA ALAMAT ANDA DI MENU PROFIL!!!
                                                    </option> 
                                                </select>
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
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Billing Information Sidebar --}}
                    <div class="col-lg-3">
                        <div class="card p-4" style="border-radius:15px; width: 300px;">
                            <h5 class="mb-0" style="text-align:center; font-family:'Poppins'; font-size:1.2rem; font-weight:600;">Billing Information</h5>
                            <hr>
                            {{-- Produk Detail --}}
                            <div class="mb-3">
                                <span style="font-family:'Poppins'; font-size:0.875rem; font-weight:600;">Produk</span>
                            </div>
                            <div class="mb-0">
                                <small style="font-family:'Poppins'; font-size:0.875rem; font-weight:500;">{{ $item->product->label->name }} – {{ $item->product->name }}</small>
                            </div>
                            <hr>
                            {{-- Detail Produk --}}
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
                            {{-- Biaya Ongkir --}}
                            <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                <span>Biaya Ongkir</span>
                                <span id="shippingCost">Rp 0</span>
                            </div>
                            {{-- Subtotal --}}
                            <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                            </div>
                            {{-- Potongan Promo --}}
                            <div id="discountLine" class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#fc2865 !important;">
                                <span>Potongan Promo</span>
                                <span id="discountAmount">-Rp 0</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4" style="font-family:'Poppins'; font-size:1rem !important; font-weight:550 !important; color:#000 !important;">
                                <strong>Total</strong>
                                <strong id="totalAmount">Rp {{ number_format($item->subtotal,0,',','.') }}</strong>
                            </div>
                            <button id="btnOrder" type="button" class="btn-order">Order Sekarang</button>
                            <br><br>
                            {{-- Kode Promo --}}
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
    </main>

    <!-- Hidden inputs -->
    <input type="hidden" id="subtotal" value="{{ $item->subtotal }}">
    <input type="hidden" id="orderId" value="{{ $order->id }}">

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const baseSubtotal   = parseFloat(document.getElementById('subtotal').value) || 0;
            const deliverySelect = document.getElementById('deliveryMethod');
            const shippingEl     = document.getElementById('shippingCost');
            const totalEl        = document.getElementById('totalAmount');
            const promoInput     = document.getElementById('promoCodeInput');
            const applyPromoBtn  = document.getElementById('applyPromoBtn');
            const promoMessage   = document.getElementById('promoMessage');
            const orderId        = document.getElementById('orderId').value;
            const btnOrder       = document.getElementById('btnOrder');
            const loadingOverlay = document.getElementById('loading-overlay');

            const hiddenPromo    = document.createElement('input');
            hiddenPromo.type     = 'hidden';
            hiddenPromo.name     = 'promo_code';
            hiddenPromo.id       = 'hiddenPromoCode';
            btnOrder.closest('.card').appendChild(hiddenPromo);

            const hiddenPromoDiscount = document.createElement('input');
            hiddenPromoDiscount.type = 'hidden';
            hiddenPromoDiscount.name = 'promo_discount';
            hiddenPromoDiscount.id = 'hiddenPromoDiscount';
            btnOrder.closest('.card').appendChild(hiddenPromoDiscount);

            let discountLine = document.getElementById('discountLine');
            let discountAmtEl = document.getElementById('discountAmount');
            
            if (!discountLine) {
                discountLine = document.createElement('div');
                discountLine.id = 'discountLine';
                discountLine.className = 'd-flex justify-content-between mb-2';
                discountLine.style.color = '#fc2865';
                discountLine.style.fontWeight = '600';
                discountLine.style.display = 'none';
                
                const discountLabel = document.createElement('span');
                discountLabel.style.fontFamily = "'Poppins'";
                discountLabel.textContent = 'Potongan Promo';
                
                discountAmtEl = document.createElement('span');
                discountAmtEl.id = 'discountAmount';
                discountAmtEl.style.fontFamily = "'Poppins'";
                
                discountLine.appendChild(discountLabel);
                discountLine.appendChild(discountAmtEl);
                
                const totalDiv = totalEl.closest('.d-flex');
                const hrBefore = totalDiv.previousElementSibling;
                hrBefore.parentNode.insertBefore(discountLine, hrBefore);
            }

            let ongkirCost    = 0;
            let promoDiscount = 0;

            function formatRp(x) {
                return 'Rp ' + Math.round(x).toLocaleString('id-ID');
            }

            function computeTotal() {
                const afterDiscount = baseSubtotal - promoDiscount;
                if (afterDiscount < 0) promoDiscount = baseSubtotal;
                
                if (promoDiscount > 0) {
                    discountLine.style.display = 'flex';
                    discountAmtEl.innerText = '-' + formatRp(promoDiscount);
                } else {
                    discountLine.style.display = 'none';
                }

                const total = afterDiscount + ongkirCost;
                shippingEl.innerText = formatRp(ongkirCost);
                totalEl.innerText    = formatRp(total);
                
                hiddenPromoDiscount.value = promoDiscount;
            }

            // 1) Listener ongkir
            deliverySelect.addEventListener('change', () => {
                ongkirCost = parseInt(deliverySelect.selectedOptions[0].dataset.cost) || 0;
                computeTotal();
            });

            // 2) Handler Apply Promo
            applyPromoBtn.addEventListener('click', () => {
                const code = promoInput.value.trim();
                if (!code) {
                    promoMessage.innerText = 'Masukkan kode promo dulu.';
                    promoMessage.classList.remove('text-success');
                    promoMessage.classList.add('text-danger');
                    return;
                }

                fetch(`/promo/check?code=${encodeURIComponent(code)}&subtotal=${baseSubtotal}`)
                .then(res => res.json())
                .then(json => {
                    if (!json.valid) {
                        promoDiscount = 0;
                        hiddenPromo.value = '';
                        promoMessage.innerText = json.message;
                        promoMessage.classList.remove('text-success');
                        promoMessage.classList.add('text-danger');
                    } else {
                        promoDiscount = json.diskon;
                        hiddenPromo.value = code;
                        promoMessage.innerText = json.message;
                        promoMessage.classList.remove('text-danger');
                        promoMessage.classList.add('text-success');
                    }
                    computeTotal();
                })
                .catch(() => {
                    promoMessage.innerText = 'Gagal cek promo. Coba lagi.';
                    promoMessage.classList.add('text-danger');
                });
            });

            // 3) Handler tombol Order
            btnOrder.addEventListener('click', () => {
                if (deliverySelect.value === '0') {
                    alert('Silakan pilih metode pengiriman terlebih dahulu!');
                    return;
                }

                const payload = {
                    kurir: deliverySelect.value,
                    ongkir: ongkirCost,
                    notes: document.getElementById('notesInput').value,
                    promo_code: hiddenPromo.value,
                    promo_discount: promoDiscount
                };

                loadingOverlay.style.display = 'flex';
                btnOrder.disabled = true;

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
                    loadingOverlay.style.display = 'none';
                    btnOrder.disabled = false;

                    if (!data.success) {
                        alert('Error: ' + data.message);
                        return;
                    }

                    // Snap Midtrans
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
                })
                .catch(err => {
                    loadingOverlay.style.display = 'none';
                    btnOrder.disabled = false;
                    console.error(err);
                    alert('Kesalahan jaringan, coba ulang.');
                });
            });

            computeTotal();
        });
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
                console.log('Ongkir response', data);
                deliveryMethod.innerHTML = '';

                const services = Array.isArray(data.details)
                    ? data.details
                    : (data.details.costs || []);

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
                            costValue = item.cost;
                        }

                        const option = document.createElement('option');
                        option.value = `${item.code}:${item.service}`;
                        option.textContent =
                            `${item.name} - ${item.service} (Rp ${costValue.toLocaleString('id-ID')})`;
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
                console.error('Error:', error);
                deliveryMethod.innerHTML = '<option value="0">Gagal memuat ongkir</option>';
            });
        });
    </script>
    @endif
@endsection