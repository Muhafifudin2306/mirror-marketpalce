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
            <div class="container product-card" style="margin-top:-180px;">
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
                                                value="{{ old('first_name', Auth::user()->first_name) }}">
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
                                                value="{{ old('last_name', Auth::user()->last_name) }}">
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
                                                value="{{ old('email', Auth::user()->email) }}">
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
                                                value="{{ old('phone', Auth::user()->phone) }}">
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
                                                class="form-control @error('province') is-invalid @enderror">
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
                                                class="form-control @error('city') is-invalid @enderror">
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
                                                value="{{ old('address', Auth::user()->address) }}">
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
                                                value="{{ old('postal_code', Auth::user()->postal_code) }}">
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
                                                    name="delivery_method" 
                                                    class="form-select @error('delivery_method') is-invalid @enderror"
                                                    style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;" 
                                                    disabled
                                                >
                                                    <option value="0" {{ old('delivery_method','0')=='0'?'selected':'' }}>
                                                        LENGKAPI DATA ALAMAT ANDA DI MENU PROFIL!!!
                                                    </option> 
                                                </select>
                                            @else
                                                <select 
                                                    id="deliveryMethod" 
                                                    name="delivery_method" 
                                                    class="form-select @error('delivery_method') is-invalid @enderror"
                                                    style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;" 
                                                >
                                                    <option value="0" {{ old('delivery_method','0')=='0'?'selected':'' }}>
                                                        Memuat data ongkir...
                                                    </option> 
                                                </select>
                                            @endif

                                            @error('delivery_method')
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
                        <div class="card p-4 sticky-top">
                            <h5 class="mb-4" style="font-family:'Poppins'; font-size:1.2rem; font-weight:600;">Billing Information</h5>
                            <hr>
                            {{-- Produk Detail --}}
                            <div class="mb-3">
                                <span style="font-family:'Poppins'; font-weight:500;">Produk:</span><br>
                                <small style="font-family:'Poppins';">{{ $item->product->label->name }} – {{ $item->product->name }}</small>
                            </div>
                            {{-- Detail Produk --}}
                            <div class="mb-3">
                                <span class="form-label">Bahan:</span><br>
                                <small>{{ $item->product->name ?? '-' }}</small><br>
                                <span class="form-label">Ukuran:</span><br>
                                <small>{{ intval($item->length) }} x {{ intval($item->width) }} {{ $item->product->additional_unit }}</small><br>
                                <span class="form-label">File Desain:</span><br>
                                @if($order->order_design)
                                    <a href="{{ asset('landingpage/img/design/'.$order->order_design) }}" target="_blank">{{ $order->order_design }}</a>
                                @else
                                    <small>-</small>
                                @endif
                            </div>
                            {{-- Biaya Ongkir --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span style="font-family:'Poppins';">Biaya Ongkir</span>
                                <span id="shippingCost" style="font-family:'Poppins';">Rp 0</span>
                            </div>
                            {{-- Subtotal --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span style="font-family:'Poppins';">Subtotal</span>
                                <span style="font-family:'Poppins';">Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong style="font-family:'Poppins';">Total</strong>
                                <strong id="totalAmount" style="font-family:'Poppins';">Rp {{ number_format($item->subtotal,0,',','.') }}</strong>
                            </div>
                            <button id="btnOrder" type="button" class="btn-order">Order Sekarang</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Hidden inputs -->
    <input type="hidden" id="subtotal" value="{{ $item->subtotal }}">
    <input type="hidden" id="orderId" value="{{ $order->id }}">

    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const deliveryMethod = document.getElementById('deliveryMethod');
            const shippingCostEl = document.getElementById('shippingCost');
            const totalAmountEl = document.getElementById('totalAmount');
            const btnOrder = document.getElementById('btnOrder');
            const notesInput = document.getElementById('notesInput');
            const loadingOverlay = document.getElementById('loading-overlay');

            let ongkirCost = 0;

            function formatRupiah(amount) {
                return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
            }

            function computeTotal() {
                const total = subtotal + ongkirCost;
                totalAmountEl.innerText = formatRupiah(total);
                shippingCostEl.innerText = formatRupiah(ongkirCost);
            }

            deliveryMethod.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const rawCost = selectedOption.getAttribute('data-cost');

                ongkirCost = parseInt(rawCost) || 0;
                computeTotal();
            });

            btnOrder.addEventListener('click', function() {
                if (deliveryMethod.value === '0') {
                    alert('Silakan pilih metode pengiriman terlebih dahulu!');
                    return;
                }

                loadingOverlay.style.display = 'flex';
                btnOrder.disabled = true;

                const formData = {
                    delivery_method: deliveryMethod.value,
                    delivery_cost: ongkirCost,
                    notes: notesInput.value,
                    _token: '{{ csrf_token() }}'
                };

                const tempPaymentData = {
                    notes: notesInput.value,
                    delivery_method: deliveryMethod.options[deliveryMethod.selectedIndex].text.split(' - ')[0] + ' - ' + deliveryMethod.options[deliveryMethod.selectedIndex].text.split(' - ')[1].split(' (')[0],
                    delivery_cost: ongkirCost
                };

                fetch(`/checkout/pay/{{ $order->id }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    loadingOverlay.style.display = 'none';
                    btnOrder.disabled = false;

                    if (data.success) {
                        // Open Midtrans Snap
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert('Pembayaran berhasil!');
                                
                                fetch(`/checkout/payment-success/{{ $order->id }}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        transaction_id: result.transaction_id,
                                        notes: tempPaymentData.notes,
                                        delivery_method: tempPaymentData.delivery_method,
                                        delivery_cost: tempPaymentData.delivery_cost
                                    })
                                })
                                .then(response => response.json())
                                .then(successData => {
                                    if (successData.success) {
                                        alert('Pembayaran berhasil!');
                                        window.location.href = '/keranjang';
                                    } else {
                                        alert('Error updating order: ' + successData.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error updating order:', error);
                                    alert('Pembayaran berhasil, tapi gagal update order. Silakan hubungi admin.');
                                });
                            },
                            onPending: function(result) {
                                alert('Menunggu pembayaran...');
                                window.location.href = '/keranjang';
                            },
                            onError: function(result) {
                                alert('Pembayaran gagal: ' + result.status_message);
                            },
                            onClose: function() {
                                alert('Anda menutup popup pembayaran tanpa menyelesaikan pembayaran');
                            }
                        });
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    loadingOverlay.style.display = 'none';
                    btnOrder.disabled = false;
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses pembayaran');
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