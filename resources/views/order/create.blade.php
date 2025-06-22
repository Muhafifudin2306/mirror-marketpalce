@extends('layouts.app')

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: calc(3rem + 2px);
            /* ini tinggi default Bootstrap 4/5 */
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: calc(2.375rem);
            /* agar teks vertikal tengah */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: calc(2.375rem);
            top: 0;
            right: 0.75rem;
        }
    </style>
@endsection

@section('content')
    <style>
        #preview {
            display: none;
            margin-top: 10px;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="container flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Tambah Pesanan</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
        </div>
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="m-0">Form Pemesanan</h3>
                        <div class="col-md-4">
                            <select id="kebutuhan_proofing" name="kebutuhan_proofing" class="form-control form-control-lg"
                                required>
                                <option value="">Pilih Kebutuhan</option>
                                <option value="0" {{ old('kebutuhan_proofing') == '0' ? 'selected' : '' }}>
                                    Proofing</option>
                                <option value="1" {{ old('kebutuhan_proofing') == '1' ? 'selected' : '' }}>
                                    Cetak Jadi</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-4">
                        <h6>Informasi Pelanggan</h6>
                        <div class="buyer-information">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="nama_pelanggan">
                                        Nama <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                                        placeholder="Nama Pelanggan"
                                        class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                        value="{{ old('nama_pelanggan') }}" required>
                                    @error('nama_pelanggan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="kontak_pelanggan">
                                        Kontak WA <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="kontak_pelanggan" name="kontak_pelanggan"
                                        placeholder="Kontak Pelanggan"
                                        class="form-control @error('kontak_pelanggan') is-invalid @enderror"
                                        value="{{ old('kontak_pelanggan') }}" required>
                                    @error('kontak_pelanggan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="email_pelanggan">
                                        Email
                                    </label>
                                    <input type="email" name="email_pelanggan" id="email_pelanggan"
                                        placeholder="Email Pelanggan"
                                        class="form-control @error('email_pelanggan') is-invalid @enderror"
                                        value="{{ old('email_pelanggan') }}">
                                    @error('email_pelanggan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-4">
                        <h6>Informasi Pesanan</h6>
                        <div class="order-info">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="tanggal">
                                        Tanggal Order<span class="text-danger">*</span>
                                    </label>
                                    <input type="date" id="tanggal" name="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal') }}" required>
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="waktu">
                                        Waktu Order <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" id="waktu" name="waktu"
                                        class="form-control @error('waktu') is-invalid @enderror"
                                        value="{{ old('waktu') }}" required>
                                    @error('waktu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="deadline">
                                        Deadline <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="deadline" id="deadline"
                                        class="form-control @error('deadline') is-invalid @enderror"
                                        value="{{ old('deadline') }}" required>
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="waktu_deadline">
                                        Waktu Deadline <span class="text-danger">*</span>
                                    </label>
                                    <input type="time" id="waktu_deadline" name="waktu_deadline"
                                        class="form-control @error('waktu_deadline') is-invalid @enderror"
                                        value="{{ old('waktu_deadline') }}" required>
                                    @error('waktu_deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="jenis_transaksi">
                                        Jenis Transaksi <span class="text-danger">*</span>
                                    </label>
                                    <select name="jenis_transaksi" id="jenis_transaksi"
                                        class="form-control @error('jenis_transaksi') is-invalid @enderror" required>
                                        <option value="" disabled
                                            {{ old('jenis_transaksi') == '' ? 'selected' : '' }}>Pilih</option>
                                        <option value="0" {{ old('jenis_transaksi') == '0' ? 'selected' : '' }}>On
                                            The
                                            Spot</option>
                                        <option value="1" {{ old('jenis_transaksi') == '1' ? 'selected' : '' }}>
                                            Whatsapp/Email/Phone</option>
                                    </select>
                                    @error('jenis_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="express">
                                        Kebutuhan Express <span class="text-danger">*</span>
                                    </label>
                                    <select name="express" id="express"
                                        class="form-control @error('express') is-invalid @enderror" required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="0" {{ old('express') == '0' ? 'selected' : '' }}>Tidak
                                        </option>
                                        <option value="1" {{ old('express') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    @error('express')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="tipe_pengambilan">
                                        Pengambilan <span class="text-danger">*</span>
                                    </label>
                                    <select name="tipe_pengambilan" id="tipe_pengambilan"
                                        class="form-control @error('tipe_pengambilan') is-invalid @enderror" required>
                                        <option value="" disabled
                                            {{ old('tipe_pengambilan') == '' ? 'selected' : '' }}>Pilih</option>
                                        <option value="0" {{ old('tipe_pengambilan') == '0' ? 'selected' : '' }}>
                                            Ditunggu</option>
                                        <option value="1" {{ old('tipe_pengambilan') == '1' ? 'selected' : '' }}>
                                            Ditinggal</option>
                                    </select>
                                    @error('tipe_pengambilan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="metode_pengiriman">Metode Pengambilan <span
                                            class="text-danger">*</span></label>
                                    <select name="metode_pengiriman" id="metode_pengiriman" class="form-control"
                                        required>
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="0">Diambil</option>
                                        <option value="1">Dikirim</option>
                                    </select>
                                    @error('metode_pengiriman')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-12 mb-3">
                                    <img id="preview" src="#" alt="Preview Gambar" />
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="ongkir-info" id="alamatForm" style="display: none;">
                            <hr>
                            <h6>Informasi Pengiriman</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Provinsi <span class="text-danger">*</span></label>
                                    <select id="provinsi" name="provinsi" class="form-control"></select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kota/Kabupaten <span class="text-danger">*</span></label>
                                    <select id="kota" name="kota" class="form-control">
                                        <option value="">Pilih Kota/Kabupaten</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kecamatan <span class="text-danger">*</span></label>
                                    <select id="kecamatan" name="kecamatan" class="form-control">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kode Pos</label> <span class="text-danger">*</span>
                                    <select id="kodepos" class="form-control" name="kode_pos" id="berat">
                                        <option value="">Pilih Kode Pos</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Berat (gram)</label> <span class="text-danger">*</span>
                                    <input type="number" name="berat" id="berat" class="form-control"
                                        placeholder="1000" value="{{ old('berat') }}">
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label>Ongkir <span class="text-danger">*</span></label>
                                    <select id="layanan" name="dikirim" class="form-control">
                                        {{-- <option value="">Pilih Layanan</option> --}}
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3" id="alamat-wrapper" style="display: none;">
                                    <label for="alamat">
                                        Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{ old('alamat') }}"></textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="product-form-wrapper">
                        <div class="product-form mb-4">
                            <h6>Produk Pesanan</h6>
                            <div class="product-info">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_cetakan_0">
                                            Produk <span class="text-danger">*</span>
                                        </label>
                                        <select name="jenis_cetakan[]" id="jenis_cetakan_0"
                                            class="form-control label-select @error('jenis_cetakan.*') is-invalid @enderror"
                                            required>
                                            <option value="" disabled selected>Pilih Produk</option>
                                            @foreach ($labels as $label)
                                                <option value="{{ $label->id }}">{{ $label->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('jenis_cetakan.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="jenis_bahan_0">
                                            Sub Produk <span class="text-danger">*</span>
                                        </label>
                                        <select name="jenis_bahan[]" id="jenis_bahan_0"
                                            class="form-control product-select @error('jenis_bahan.*') is-invalid @enderror"
                                            disabled required>
                                            <option value="" disabled selected>Pilih Sub Produk</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-label="{{ $product->label_id }}">
                                                    {{ $product->name }}
                                                    @php
                                                        $hasAdditionalInfo = false;
                                                        $productInfo = [];

                                                        if ($product->long_product && $product->width_product) {
                                                            $productInfo[] =
                                                                $product->long_product .
                                                                ' x ' .
                                                                $product->width_product;
                                                            $hasAdditionalInfo = true;
                                                        }

                                                        if ($product->additional_size || $product->additional_unit) {
                                                            $productInfo[] =
                                                                $product->additional_size .
                                                                ' ' .
                                                                $product->additional_unit;
                                                            $hasAdditionalInfo = true;
                                                        }

                                                        if ($product->min_qty && $product->max_qty && $product->label) {
                                                            $unitName = '';
                                                            switch ($product->label->unit) {
                                                                case 1:
                                                                    $unitName = 'Gram';
                                                                    break;
                                                                case 2:
                                                                    $unitName = 'Kilogram';
                                                                    break;
                                                                case 3:
                                                                    $unitName = 'cm';
                                                                    break;
                                                                case 4:
                                                                    $unitName = 'm';
                                                                    break;
                                                                case 5:
                                                                    $unitName = 'm2';
                                                                    break;
                                                                case 6:
                                                                    $unitName = 'Lembar';
                                                                    break;
                                                                case 7:
                                                                    $unitName = 'Rim';
                                                                    break;
                                                                case 8:
                                                                    $unitName = 'pcs';
                                                                    break;
                                                                default:
                                                                    $unitName = $product->label->unit;
                                                                    break;
                                                            }
                                                            $productInfo[] =
                                                                'Pembelian ' .
                                                                $product->min_qty .
                                                                ' - ' .
                                                                $product->max_qty .
                                                                ' ' .
                                                                $unitName;
                                                            $hasAdditionalInfo = true;
                                                        }
                                                    @endphp

                                                    @if ($hasAdditionalInfo)
                                                        ({{ implode(' ', $productInfo) }})
                                                    @endif
                                                    - Rp{{ number_format($product->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jenis_bahan.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="finishing_0">
                                            Finishing
                                        </label>
                                        <select name="jenis_finishing[]" id="finishing_0"
                                            class="form-control finishing-select @error('finishing.*') is-invalid @enderror"
                                            disabled>
                                            <option value="" disabled selected>Pilih Finishing</option>
                                            @foreach ($finishings as $item)
                                                <option value="{{ $item->id }}" data-label="{{ $item->label_id }}">
                                                    {{ $item->finishing_name }}
                                                    - Rp{{ number_format($item->finishing_price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('finishing.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="panjang_0">
                                            Panjang (cm)
                                        </label>
                                        <input type="number" name="panjang[]" id="panjang_0" placeholder="Panjang"
                                            class="form-control @error('panjang.*') is-invalid @enderror" min="0">
                                        @error('panjang.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="lebar_0">
                                            Lebar (cm)
                                        </label>
                                        <input type="number" name="lebar[]" id="lebar_0" placeholder="Lebar"
                                            class="form-control @error('lebar.*') is-invalid @enderror" min="0">
                                        @error('lebar.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="jumlah_pesanan_0">
                                            Jumlah Pesanan <span class="text-danger">*</span> <span
                                                class="selected-unit"></span>
                                        </label>
                                        <input type="number" name="jumlah_pesanan[]" id="jumlah_pesanan_0"
                                            placeholder="Jumlah"
                                            class="form-control jumlah-pesanan-input @error('jumlah_pesanan.*') is-invalid @enderror"
                                            min="1" required>
                                        @error('jumlah_pesanan.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 mb-3"></div>

                                    <div class="col-md-3 mb-3">
                                        <label for="desain_cetak_0">
                                            Desain Cetak
                                        </label>
                                        <input type="file" name="desain[]" id="desain_cetak_0"
                                            class="form-control @error('desain') is-invalid @enderror"
                                            accept=".jpeg,.jpg,.png,.pdf,.svg,.cdr,.psd,.ai,.tiff">
                                        @error('desain')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="desain_preview_0">
                                            Desain Preview
                                        </label>
                                        <input type="file" name="preview[]" id="desain_preview_0"
                                            class="form-control @error('preview') is-invalid @enderror"
                                            accept=".jpeg,.jpg,.png,.pdf,.svg,.cdr,.psd,.ai,.tiff">
                                    </div>
                                    @error('preview')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <!-- Tombol tambah field -->
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button type="button" id="addProductField" class="btn btn-outline-success w-100">
                                        <i class="bx bx-plus fs-6"></i> Tambah Field
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <button type="button" id="removeProductField" class="btn btn-outline-danger w-100">
                                        <i class="bx bx-trash"></i> Hapus Field
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <h5 class="me-3 fw-bold" style="font-size: 20px;">Subtotal:</h5>
                        <h5 id="subtotal-display" class="fw-bold" style="font-size: 24px;">Rp0</h5>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const metodePengiriman = document.getElementById('metode_pengiriman');
            const alamatWrapper = document.getElementById('alamat-wrapper');
            const alamatField = document.getElementById('alamat');
            const beratInput = document.getElementById('berat');
            const kodeposInput = document.getElementById('kodepos');

            function toggleAlamat() {
                if (metodePengiriman.value === '1') {
                    alamatWrapper.style.display = 'block';
                    alamatField.setAttribute('required', 'required');
                    beratInput.setAttribute('required', 'required');
                    kodeposInput.setAttribute('required', 'required');
                } else {
                    alamatWrapper.style.display = 'none';
                    alamatField.removeAttribute('required');
                    alamatField.value = '';
                    beratInput.removeAttribute('required');
                    kodeposInput.removeAttribute('required');
                }
            }

            metodePengiriman.addEventListener('change', toggleAlamat);
            toggleAlamat(); // inisialisasi saat load
        });
    </script>


    <script>
        const now = new Date();
        const today = now.toISOString().split('T')[0];
        document.getElementById('tanggal').value = today;
        const pad = num => String(num).padStart(2, '0');
        const localHours = pad(now.getHours());
        const localMinutes = pad(now.getMinutes());
        document.getElementById('waktu').value = `${localHours}:${localMinutes}`;
    </script>

@endsection

@section('script')
    @php
        $productSizes = $products
            ->mapWithKeys(function ($product) {
                return [
                    $product->id => [
                        'width' => $product->width_product ?? 0,
                        'length' => $product->long_product ?? 0,
                        'price' => $product->price ?? 0,
                    ],
                ];
            })
            ->toArray();
    @endphp

    <script>
        const productSizes = @json($productSizes);

        console.log(productSizes)
    </script>


    <script>
        $(document).ready(function() {
            // Data harga produk dari server
            const productPrices = {
                @foreach ($products as $p)
                    {{ $p->id }}: {{ $p->price }},
                @endforeach
            };

            const finishingPrices = {
                @foreach ($finishings as $item)
                    {{ $item->id }}: {{ $item->finishing_price }},
                @endforeach
            };

            function updateUnitAndQtyInfo(productSelectElement) {
                const selectedOption = $(productSelectElement).find('option:selected');
                const unit = selectedOption.data('unit');
                const minQty = selectedOption.data('min-qty');
                const maxQty = selectedOption.data('max-qty');

                const parentForm = $(productSelectElement).closest('.product-form');
                const unitSpan = parentForm.find('.selected-unit');
                const qtyInfoSpan = parentForm.find('.qty-range-info');

                unitSpan.text(unit ? '(' + unit + ')' : '');

                if (minQty && maxQty) {
                    qtyInfoSpan.text('Min: ' + minQty + ' - Max: ' + maxQty + ' ' + (unit || ''));
                } else if (minQty) {
                    qtyInfoSpan.text('Min: ' + minQty + ' ' + (unit || ''));
                } else if (maxQty) {
                    qtyInfoSpan.text('Max: ' + maxQty + ' ' + (unit || ''));
                } else {
                    qtyInfoSpan.text('');
                }
            }

            function recalculate() {
                let total = 0;
                const productForms = document.querySelectorAll('.product-form');

                productForms.forEach(function(form) {
                    try {
                        const jenisBarangSelect = form.querySelector('select[name="jenis_bahan[]"]');
                        const jenisFinishing = form.querySelector('select[name="jenis_finishing[]"]');
                        const panjangInput = form.querySelector('input[name="panjang[]"]');
                        const lebarInput = form.querySelector('input[name="lebar[]"]');
                        const qtyInput = form.querySelector('input[name="jumlah_pesanan[]"]');

                        if (!jenisBarangSelect || !qtyInput) {
                            console.log('Elemen tidak ditemukan dalam form');
                            return;
                        }

                        const prodId = parseInt(jenisBarangSelect.value) || 0;
                        const finishId = parseInt(jenisFinishing.value) || 0;
                        const panjang = parseFloat(panjangInput ? panjangInput.value : 0) || 0;
                        const lebar = parseFloat(lebarInput ? lebarInput.value : 0) || 0;
                        const qty = parseInt(qtyInput.value) || 0;

                        // const prodId = parseInt(select.value);

                        if (!prodId || !qty || !(prodId in productSizes)) return;

                        const master = productSizes[prodId];

                        console.log('master', master)

                        const defaultPanjang = master.length;
                        const defaultLebar = master.width;

                        console.log('Form data:', {
                            prodId,
                            finishId,
                            panjang,
                            lebar,
                            qty
                        });

                        if (prodId === 0 || qty <= 0) {
                            console.log('Skipping form - produk atau qty tidak valid');
                            return;
                        }

                        const hargaProduk = productPrices[prodId] || 0;
                        const hargaFinishing = finishingPrices[finishId] || 0;
                        let finalP = 0;
                        let finalL = 0;
                        if (panjang || lebar) {
                            finalP = panjang < defaultPanjang ? defaultPanjang : panjang;
                            finalL = lebar < defaultLebar ? defaultLebar : lebar;
                        }

                        console.log('finalP', finalP)
                        console.log('finalL', finalL)
                        let luas = 1;
                        if (finalP > 0 && finalL > 0) {
                            luas = (finalP / 100) * (finalL / 100);
                        }

                        const subtotalProduk = ((luas * hargaProduk) * qty) + hargaFinishing;
                        total += subtotalProduk;

                        console.log('Luas:', luas, 'Subtotal produk:', subtotalProduk);
                    } catch (error) {
                        console.error('Error dalam perhitungan form:', error);
                    }
                });

                // Biaya express
                const expressSelect = document.querySelector('select[name="express"]');
                if (expressSelect && parseInt(expressSelect.value) === 1) {
                    total *= 1.5; // Tambah 50%
                    console.log('Express charge applied');
                }

                // Biaya ongkir
                const ongkirSelect = document.getElementById('layanan');
                let ongkirCost = 0;

                if (ongkirSelect && ongkirSelect.value && !isNaN(parseFloat(ongkirSelect.value))) {
                    ongkirCost = parseFloat(ongkirSelect.value);
                    console.log('Biaya ongkir ditambahkan:', ongkirCost);
                } else {
                    console.log('Layanan kosong, ongkir 0');
                }

                total += ongkirCost;

                const subtotalDisplay = document.getElementById('subtotal-display');
                if (subtotalDisplay) {
                    subtotalDisplay.textContent = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(Math.round(total));
                }
            }

            // Event-event
            $(document).on('input change',
                'select[name="jenis_bahan[]"],select[name="jenis_finishing[]"], input[name="panjang[]"], input[name="lebar[]"], input[name="jumlah_pesanan[]"], select[name="jenis_finishing[]"], select[name="express"]',
                function() {
                    console.log('Input changed, recalculating...');
                    recalculate();
                }
            );

            $(document).on('change', 'select[name="jenis_cetakan[]"]', function() {
                console.log('Label changed, recalculating...');
                recalculate();
            });

            $(document).on('change', '.product-select', function() {
                updateUnitAndQtyInfo(this);
                recalculate();
            });

            $(document).on('change', '#layanan', function() {
                console.log('Layanan ongkir berubah, recalculating...');
                recalculate();
            });

            // Inisialisasi awal
            $('.product-select').each(function() {
                updateUnitAndQtyInfo(this);
            });

            $('#province, #city').on('change', function() {
                // $('#layanan').html('<option value="">Pilih Layanan</option>').val('');
                recalculate(); // Pastikan ongkir ikut direset
            });

            $(document).on('change', '#metode', function() {
                console.log('Layanan ongkir berubah, recalculating...');
                recalculate();
            });
            setTimeout(function() {
                console.log('Initial calculation...');
                recalculate();
            }, 100);
        });
    </script>

    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            const wrapper = $('#product-form-wrapper');

            // Simpan semua opsi sub-produk asli
            const allProductOptionsHTML = $('.product-select').first().html();
            const allFinishingOptionsHTML = $('.finishing-select').first().html();

            function initSelect2(form) {
                form.find('.label-select').select2({
                    placeholder: 'Pilih Produk',
                    width: '100%',
                    dropdownParent: form
                });

                form.find('.product-select').select2({
                    placeholder: 'Pilih Sub Produk',
                    width: '100%',
                    dropdownParent: form
                });

                form.find('.finishing-select').select2({
                    placeholder: 'Tanpa Finishing',
                    width: '100%',
                    dropdownParent: form
                });
            }

            function bindEvents(form) {
                form.find('.label-select').on('change', function() {
                    const selectedLabelId = $(this).val();
                    const productSelect = form.find('.product-select');
                    const finishingSelect = form.find('.finishing-select');

                    productSelect.prop('disabled', false).html(
                        '<option value="" disabled selected>Pilih Sub Produk</option>');

                    finishingSelect.prop('disabled', false).html(
                        '<option value="" disabled selected>Pilih Finishing</option>');

                    const $tempSelect = $('<select>' + allProductOptionsHTML + '</select>');
                    const $finihingSelect = $('<select>' + allFinishingOptionsHTML + '</select>');
                    $tempSelect.find('option').each(function() {
                        if ($(this).data('label') == selectedLabelId) {
                            productSelect.append($(this).clone());
                        }
                    });

                    $finihingSelect.find('option').each(function() {
                        if ($(this).data('label') == selectedLabelId) {
                            finishingSelect.append($(this).clone());
                        }
                    });

                    productSelect.val('').trigger('change');
                    finishingSelect.val('').trigger('change');
                });
            }


            // Inisialisasi pertama
            const firstForm = wrapper.find('.product-form').first();
            const firstFinishing = wrapper.find('.finishing-form').first();
            initSelect2(firstForm);
            bindEvents(firstForm);

            $('#addProductField').on('click', function() {
                const forms = $('#product-form-wrapper .product-form');
                const newIndex = forms.length;
                const firstForm = forms.first();

                // Hapus select2 agar tidak ter-clone dengan wrappernya
                firstForm.find('.label-select').select2('destroy');
                firstForm.find('.product-select').select2('destroy');
                firstForm.find('.finishing-select').select2('destroy');

                // Clone form bersih
                const newForm = firstForm.clone(false);

                // Kembalikan select2 form pertama
                initSelect2(firstForm);
                bindEvents(firstForm);

                // Reset field di form baru
                newForm.find('input').val('');
                newForm.find('select').val('').prop('disabled', false); // ⬅ UNDISABLE DI SINI
                newForm.find('.product-select').html(
                    '<option value="" disabled selected>Pilih Sub Produk</option>');
                newForm.find('.finishing-select').html(
                    '<option value="" disabled selected>Pilih Finishing</option>');

                // Update ID agar unik
                newForm.find('[id]').each(function() {
                    const oldId = $(this).attr('id');
                    const newId = oldId.replace(/\d+$/, newIndex);
                    $(this).attr('id', newId);
                });

                // Tambah ke DOM
                newForm.insertBefore($('#addProductField').closest('.row'));

                // Inisialisasi select2 dan event di form baru
                initSelect2(newForm);
                bindEvents(newForm);
            });


            $('#removeProductField').on('click', function() {
                const forms = wrapper.find('.product-form');
                if (forms.length > 1) {
                    forms.last().remove();
                } else {
                    alert('Minimal satu form harus ada.');
                }
            });
        });
    </script>

    <script>
        document.getElementById('metode_pengiriman').addEventListener('change', function() {
            if (this.value === '1') {
                document.getElementById('alamatForm').style.display = 'block';
                loadProvinsi();
            } else {
                document.getElementById('alamatForm').style.display = 'none';
                const inputs = alamatForm.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        input.checked = false;
                    } else {
                        input.value = '';
                    }
                });
                const dynamicSelects = ['provinsi', 'kota', 'layanan'];
                dynamicSelects.forEach(id => {
                    const el = document.getElementById(id);
                    if (el) el.innerHTML = '<option value="">Pilih</option>';
                });
            }
        });

        function loadProvinsi() {
            fetch('/api/provinsi')
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Pilih Provinsi</option>';
                    data.result.forEach(p => {
                        options += `<option value="${p.id}">${p.text}</option>`;
                    });
                    document.getElementById('provinsi').innerHTML = options;
                })
                .catch(error => console.error('Error saat memuat provinsi:', error));
        }

        document.getElementById('provinsi').addEventListener('change', function() {
            const idProv = this.value;
            fetch(`/api/kabkota?d_provinsi_id=${idProv}`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">Pilih Kota</option>';
                    data.result.forEach(k => {
                        options += `<option value="${k.id}">${k.text}</option>`;
                    });
                    document.getElementById('kota').innerHTML = options;
                });
        });

        document.getElementById('kota').addEventListener('change', function() {
            selectedKabkotaId = this.value;
            fetch(`/api/kecamatan?d_kabkota_id=${selectedKabkotaId}`)
                .then(res => res.json())
                .then(data => {
                    let opt = '<option value="">Pilih Kecamatan</option>';
                    data.result.forEach(kec => {
                        opt += `<option value="${kec.id}">${kec.text}</option>`;
                    });
                    document.getElementById('kecamatan').innerHTML = opt;
                });
        });

        document.getElementById('kecamatan').addEventListener('change', function() {
            selectedKecId = this.value;
            fetch(`/api/kodepos?d_kabkota_id=${selectedKabkotaId}&d_kecamatan_id=${selectedKecId}`)
                .then(res => res.json())
                .then(data => {
                    let opt = '<option value="">Pilih Kode Pos</option>';
                    data.result.forEach(pos => {
                        opt += `<option value="${pos.text}">${pos.text}</option>`;
                    });
                    document.getElementById('kodepos').innerHTML = opt;
                });
        });

        function tampilkanLayananOngkir(details) {
            const select = document.getElementById('layanan');
            let options;

            if (details.length > 0) {
                details.forEach((item) => {
                    const label =
                        `${item.name} - ${item.service} (${item.description}) - Rp${item.cost.toLocaleString()}`;
                    options += `<option value='${item.cost + '|'+item.name}'>${label}</option>`;
                });
            }

            select.innerHTML = options;
            select.value = '';
        }


        document.getElementById('berat').addEventListener('blur', function() {
            const berat = this.value || 1000;
            const kodePos = document.getElementById('kodepos').value;

            if (!kodePos || kodePos.length < 4) return;

            fetch('/api/hitung-ongkir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        destination: kodePos,
                        weight: berat
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.details) {
                        console.log(kodePos)
                        console.log(berat)
                        tampilkanLayananOngkir(data.details);
                    }
                });
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#desain-preview').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result).fadeIn();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#preview').fadeOut().attr('src', '#');
                }
            });
        });
    </script> --}}
@endsection
