@extends('layouts.app')

@section('content')
    <div class="container flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Header & Back --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">
                Detail Verifikasi {{ $order->metode_pengiriman ? 'Pengiriman' : 'Pengambilan' }}
                </h1>
                <a href="{{ route('orders.shipping') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
        </div>

        {{-- Informasi Pelanggan & Pesanan --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <h3>Informasi Pelanggan & Pesanan</h3>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label>Tanggal</label>
                        <input type="date" class="form-control"
                            value="{{ \Carbon\Carbon::parse($order->tanggal)->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Waktu</label>
                        <input type="time" class="form-control"
                            value="{{ \Carbon\Carbon::parse($order->waktu)->format('H:i') }}" disabled>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Nama Pelanggan</label>
                        <input type="text" class="form-control" value="{{ $order->nama_pelanggan }}" disabled>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Kontak WA</label>
                        <input type="text" class="form-control" value="{{ $order->kontak_pelanggan }}" disabled>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Email Pelanggan</label>
                        <input type="email" placeholder="-" class="form-control" value="{{ $order->email_pelanggan }}"
                            disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Jenis Transaksi</label>
                        <input type="text" class="form-control"
                            value="{{ ['On The Spot', 'WA/Email/Phone', 'Marketplace'][$order->jenis_transaksi] }}"
                            disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Express</label>
                        <input type="text" class="form-control" value="{{ $order->express ? 'Ya' : 'Tidak' }}" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Deadline</label>
                        <input type="date" class="form-control"
                            value="{{ \Carbon\Carbon::parse($order->deadline)->format('Y-m-d') }}" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Waktu Deadline</label>
                        <input type="time" class="form-control"
                            value="{{ \Carbon\Carbon::parse($order->waktu_deadline)->format('H:i') }}" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Kebutuhan Proofing</label>
                        <input type="text" class="form-control"
                            value="{{ $order->kebutuhan_proofing ? 'Cetak Jadi' : 'Proofing' }}" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tipe Pengambilan</label>
                        <input type="text" class="form-control"
                            value="{{ $order->tipe_pengambilan ? 'Ditinggal' : 'Ditunggu' }}" disabled>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Metode Pengiriman</label>
                        <input type="text" class="form-control"
                            value="{{ $order->metode_pengiriman ? 'Dikirim' : 'Diambil' }}" disabled>
                    </div>
                </div>
                </div>

                <div class="mb-3">
                    <h3 class="mb-3">Desain Pemesanan</h3>
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>Jenis Produk</th>
                                <th>Jenis Sub Produk</th>
                                <th>Desain Cetak</th>
                                <th>Desain Preview</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->label_name }}</td>
                                    <td>
                                        {{ $item->name }}
                                        @php
                                            $parts = [];
                                            if ($item->long_item && $item->width_item) {
                                                $parts[] = "{$item->long_item} x {$item->width_item}";
                                            }
                                            if ($item->additional_size && $item->additional_unit) {
                                                $parts[] = "{$item->additional_size} {$item->additional_unit}";
                                            }
                                            if ($item->min_qty && $item->max_qty) {
                                                $unitNames = [
                                                    1 => 'Gram',
                                                    2 => 'Kilogram',
                                                    3 => 'cm',
                                                    4 => 'm',
                                                    5 => 'm2',
                                                    6 => 'Lembar',
                                                    7 => 'Rim',
                                                    8 => 'pcs',
                                                ];
                                                $unit = $unitNames[$item->unit_name] ?? '';
                                                $parts[] = "Pembelian {$item->min_qty}-{$item->max_qty} {$unit}";
                                            }
                                        @endphp
                                        @if ($parts)
                                            ({{ implode(' | ', $parts) }})
                                        @endif
                                        - Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @if ($item->desain)
                                            <a href="#" data-url="{{ asset('storage/' . $item->desain) }}"
                                                class="btn btn-sm btn-outline-primary preview-desain">
                                                <i class="bx bx-show-alt me-1"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->desain)
                                            <a href="#" data-url="{{ asset('storage/' . $item->preview) }}"
                                                class="btn btn-sm btn-outline-primary preview-desain">
                                                <i class="bx bx-show-alt me-1"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- Verifikasi Pembayaran (hanya status 1 atau 2) --}}
        {{-- @if ($order->status_pembayaran == 1 || $order->status_pembayaran == 2) --}}
        <div class="card mb-4">
            <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="col">
                        <h3>Verifikasi Pembayaran</h3>
                    </div>
                </div>

                @if ($order->status_pembayaran == 0)
                    {{-- FORM UNTUK BELUM BAYAR --}}
                    <form id="confirm-payment-form" method="POST"
                        action="{{ route('orders.confirmPaymentShipping', $order->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-2">
                                <label>Subtotal</label>
                                <input type="text" id="subtotal" class="form-control"
                                    value="Rp{{ number_format($order->subtotal, 0, ',', ',') }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>Metode Potongan</label>
                                <select id="metode_potongan" class="form-control">
                                    <option selected>Pilih Metode</option>
                                    <option value="persen">Diskon (%)</option>
                                    <option value="nominal">Potongan (Rp)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Diskon (%)</label>
                                <input type="number" id="diskon_persen" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>Potongan (Rp)</label>
                                <input type="text" id="potongan_rp_manual" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>Potongan (Rp) Calc</label>
                                <input type="text" id="potongan_rp_calc" class="form-control" disabled>
                            </div>
                            <div class="col-md-2">
                                <label>Validator</label>
                                @if ($order->status_pembayaran == 0)
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                        disabled>
                                @else
                                    <input type="text" class="form-control" value="{{ $validatorName ?? '-' }}"
                                        disabled>
                                @endif
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-2">
                                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                <select id="metode_transaksi" name="metode_transaksi" class="form-control" required>
                                    <option value="">Pilih Metode</option>
                                    <option value="0">Cash</option>
                                    <option value="1">Transfer</option>
                                    <option value="2">QRIS</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label>Bayar <span class="text-danger">*</span></label>
                                <input type="text" name="jumlah_bayar" id="jumlah_bayar" class="form-control"
                                    placeholder="Rp0">
                            </div>

                            <div class="col-md-2">
                                <label>Termin (Sisa)</label>
                                <input type="text" id="termin" class="form-control" disabled>
                            </div>

                            <div class="col-md-2">
                                <label>Total Bayar</label>
                                <input type="text" id="total_bayar" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Bukti Bayar <span class="text-danger">*</span></label>
                                <input type="file" name="bukti_bayar" id="bukti_bayar" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" id="btn-verify" class="btn btn-success">
                                <i class="bx bx-check-circle me-1"></i> Verifikasi Pembayaran
                            </button>
                        </div>
                    </form>
                @elseif($order->status_pembayaran == 1)
                    <form id="finish-payment-form" method="POST"
                        action="{{ route('orders.finishPelunasanShipping', $order->id) }}" enctype="multipart/form-data">
                        @csrf
                        {{-- PARTIAL --}}
                        @php
                            $order->subtotal = $order->subtotal;
                            if ($order->potongan_rp) {
                                $dibayar = $order->subtotal - $order->potongan_rp - $order->termin;
                            } elseif ($order->diskon_persen) {
                                $dibayar =
                                    $order->subtotal -
                                    ($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir) -
                                    $order->termin;
                            } else {
                                $dibayar = $order->subtotal - $order->termin;
                            }
                        @endphp
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label>Subtotal</label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($order->subtotal, 0, ',', '.') }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Potongan</label>
                                @if ($order->potongan_rp)
                                    <input type="text" class="form-control"
                                        value="- {{ number_format($order->potongan_rp, 0, ',', '.') }}" disabled>
                                @elseif ($order->diskon_persen)
                                    <input type="text" class="form-control"
                                        value="- {{ number_format(($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir)) }}"
                                        disabled>
                                @else
                                    <input type="text" class="form-control" value="0" disabled>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label>Dibayar</label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($dibayar, 0, ',', '.') }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Sisa Termin</label>
                                <input type="text" class="form-control"
                                    value="{{ number_format($order->termin, 0, ',', '.') }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Metode Pelunasan <span class="text-danger">*</span></label>
                                <select name="metode_transaksi_paid" id="metode_transaksi_paid" class="form-control"
                                    required>
                                    <option value="">Pilih Metode</option>
                                    <option value="0">Cash</option>
                                    <option value="1">Transfer</option>
                                    <option value="2">QRIS</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Pelunasan</label>
                                <input type="date" class="form-control" name="paid_at" id="paid_at">
                            </div>
                            <div class="col-md-3">
                                <label>Bukti Pelunasan <span class="text-danger">*</span></label>
                                <input type="file" name="bukti_lunas" id="bukti_lunas" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label>Validator</label>
                                @if ($order->status_pembayaran == 0)
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                        disabled>
                                @else
                                    <input type="text" class="form-control" value="{{ $validatorName ?? '-' }}"
                                        disabled>
                                @endif
                            </div>
                        </div>
                        <div class="mt-3">
                            {{-- <input type="hidden" name="termin" value="0">
                                <input type="hidden" name="metode_transaksi" value="{{ $order->metode_transaksi }}"> --}}
                            <button type="button" id="btn-lunas" class="btn btn-primary">
                                Selesaikan Pelunasan
                            </button>
                        </div>
                    </form>
                @else
                    {{-- status_pembayaran == 2 --}}
                    <div class="alert alert-success">
                        <h4 class="alert-heading">LUNAS</h4>
                        @if ($order->potongan_rp)
                            <p>Subtotal: <strong>Rp
                                    {{ number_format($order->subtotal - $order->potongan_rp, 0, ',', '.') }}
                                    (Potongan {{ number_format($order->potongan_rp, 0, ',', '.') }})</strong></p>
                            <p>Terbayar: <strong>Rp
                                    {{ number_format($order->subtotal - $order->potongan_rp, 0, ',', '.') }}</strong></p>
                        @elseif ($order->diskon_persen)
                            <p>Subtotal: <strong>Rp
                                    {{ number_format($order->subtotal - ($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir), 0, ',', '.') }}
                                    (Potongan
                                    {{ number_format(($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir), 0, ',', '.') }})</strong>
                            </p>
                            <p>Terbayar: <strong>Rp
                                    {{ number_format($order->subtotal - ($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir), 0, ',', '.') }}</strong>
                            </p>
                        @else
                            <p>Subtotal: <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></p>
                            <p>Terbayar: <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        {{-- @endif --}}
        @if ($order->metode_pengiriman)
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Informasi Pengiriman</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Provinsi <span class="text-danger">*</span></label>
                            <select id="provinsi" name="provinsi" class="form-control" disabled>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->id ?? '' }}"
                                        {{ $item->id == $order->provinsi ? 'selected' : '' }}>{{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Kota/Kabupaten <span class="text-danger">*</span></label>
                            <select id="kota" name="kota" class="form-control" disabled>
                                @foreach ($kota as $item)
                                    <option value="{{ $item->id ?? '' }}"
                                        {{ $item->id == $order->kota ? 'selected' : '' }}>{{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Kecamatan <span class="text-danger">*</span></label>
                            <select id="kecamatan" name="kecamatan" class="form-control" disabled>
                                @foreach ($kecamatan as $item)
                                    <option value="{{ $item->id ?? '' }}"
                                        {{ $item->id == $order->kecamatan ? 'selected' : '' }}>{{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Kode Pos</label> <span class="text-danger">*</span>
                            <select id="kodepos" class="form-control" name="kode_pos" id="berat" disabled>
                                @foreach ($kodepos as $item)
                                    <option value="{{ $item->nama ?? '' }}"
                                        {{ $item->nama == $order->kode_pos ? 'selected' : '' }}>
                                        {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Berat (gram) <span class="text-danger">*</span></label>
                            <input type="number" name="berat" id="berat"
                                class="form-control @error('berat') is-invalid @enderror"
                                value="{{ old('berat', $order->berat) }}" disabled>
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5 mb-3">
                            <label>Ongkir <span class="text-danger">*</span></label>
                            <select id="layanan" name="dikirim" class="form-control" disabled>
                                <option value="{{ $order->ongkir . '|' . $order->kurir }}"
                                    {{ $order->ongkir ? 'selected' : '' }}>
                                    {{ $order->kurir ? $order->kurir . ' - Rp' . number_format($order->ongkir, 0, ',', '.') : 'Pilih Layanan' }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="alamat-wrapper"
                            style="display: {{ $order->metode_pengiriman == 1 ? 'block' : 'none' }};">
                            <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                                disabled>{{ old('alamat', $order->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- Tombol Verifikasi Pengiriman/Pengambilan --}}
        <div class="d-flex justify-content-start gap-2 mb-3">
            <form id="confirm-verif-form" method="POST" action="{{ route('orders.confirmShipping', $order->id) }}">
                @csrf
                @if ($order->status_pengambilan == 0)
                    <button id="btn-verify-2" type="button" class="btn btn-success"
                        {{ $order->status_pembayaran < 2 ? 'disabled' : '' }}>
                        <i class="bx bx-check-circle me-1"></i>
                        Verifikasi {{ $order->metode_pengiriman ? 'Pengiriman' : 'Pengambilan' }}
                    </button>
                @else
                    <button id="btn-verify" type="button" class="btn btn-success" disabled>
                        <i class="bx bx-check-circle me-1"></i>
                        Sudah {{ $order->metode_pengiriman ? 'Dikirim' : 'Diambil' }}
                    </button>
                @endif
            </form>
        </div>

        {{-- Detail Produk --}}
        <div class="card mb-4">
            <div class="card-body">
                <h3>Detail Produk dalam Order</h3>
                <table class="table table-bordered">
                <thead class="table-info">
                    <tr>
                        <th>Product</th>
                        <th>Sub Product</th>
                        <th>Finishing</th>
                        <th>Panjang (cm)</th>
                        <th>Lebar (cm)</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->label_name }}</td>
                            <td>
                                {{ $item->name }}
                                @php
                                    $parts = [];
                                    if ($item->long_item && $item->width_item) {
                                        $parts[] = "{$item->long_item} x {$item->width_item}";
                                    }
                                    if ($item->additional_size && $item->additional_unit) {
                                        $parts[] = "{$item->additional_size} {$item->additional_unit}";
                                    }
                                    if ($item->min_qty && $item->max_qty) {
                                        $unitNames = [
                                            1 => 'Gram',
                                            2 => 'Kilogram',
                                            3 => 'cm',
                                            4 => 'm',
                                            5 => 'm2',
                                            6 => 'Lembar',
                                            7 => 'Rim',
                                            8 => 'pcs'
                                        ];
                                        $unit = $unitNames[$item->unit_name] ?? '';
                                        $parts[] = "Pembelian {$item->min_qty}-{$item->max_qty} {$unit}";
                                    }
                                @endphp
                                @if ($parts)
                                    ({{ implode(' | ', $parts) }})
                                @endif
                                - Rp{{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td>
                                    {{ $item->finishing_name ?? '-' }}
                                        @if ($item->finishing_name)
                                            - Rp{{ number_format($item->finishing_price, 0, ',', '.') }}
                                        @endif
                                </td>
                            <td>{{ $item->panjang ?: '-' }}</td>
                            <td>{{ $item->lebar ?: '-' }}</td>
                            <td>{{ $item->jumlah_pesanan ?: '-' }}</td>
                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @if ($order->express)
                    @php
                        $totalHargaItem = 0;
                        foreach ($items as $item) {
                            $totalHargaItem += $item->subtotal;
                        }
                        $biayaExpress = $order->express ? ($totalHargaItem * 0.5) : 0;
                    @endphp
                    <tr>
                        <td>-</td>
                        <td>Kebutuhan Express</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>50%</td>
                        <td>Rp{{ number_format($biayaExpress) }}</td>
                        <td>Rp{{ number_format($biayaExpress) }}</td>
                    </tr>
                @endif
                @if ($order->potongan_rp)
                    </tr>
                        <td>-</td>
                        <td>Potongan Harga</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>1</td>
                        <td>Rp{{ number_format($order->potongan_rp) }}</td>
                        <td>- Rp{{ number_format($order->potongan_rp) }}</td>
                    </tr>
                @elseif ($order->diskon_persen)
                    </tr>
                        <td>-</td>
                        <td>Diskon Persen</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>{{ $order->diskon_persen }}%</td>
                        <td>Rp{{ number_format(($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir)) }}</td>
                        <td>- Rp{{ number_format(($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir)) }}</td>
                    </tr>
                @endif
                @if ($order->metode_pengiriman)
                    <tr>
                        <td>-</td>
                        <td>Pengiriman {{ $order->kurir }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>1</td>
                        <td>Rp{{ number_format($order->ongkir) }}</td>
                        <td>Rp{{ number_format($order->ongkir) }}</td>
                    </tr>
                @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="7" class="text-end fw-bold fs-5">Total Subtotal</th>
                        @if ($order->potongan_rp)
                            <th class="fw-bold fs-5">Rp{{ number_format($order->subtotal - $order->potongan_rp,0,',','.') }}</th>
                        @elseif ($order->diskon_persen)
                            <th class="fw-bold fs-5">Rp{{ number_format($order->subtotal - (($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir)),0,',','.') }}</th>
                        @else
                            <th class="fw-bold fs-5">Rp{{ number_format($order->subtotal,0,',','.') }}</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
@if ($order->status_pembayaran == 0)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sub = parseFloat({{ $order->subtotal }});
            const okr = parseFloat({{ $order->ongkir }});
            const fmt = n => n.toLocaleString('id-ID');
            const parseID = s => parseFloat(String(s).replace(/\./g, '').replace(',', '.')) || 0;
            const getEl = id => document.getElementById(id);

            getEl('metode_potongan').addEventListener('change', e => {
                const metode = e.target.value;

                if (metode == 'persen') {
                    getEl('diskon_persen').disabled = false;
                    getEl('potongan_rp_manual').disabled = true;

                    getEl('potongan_rp_manual').value = '';
                } else {
                    getEl('diskon_persen').disabled = true;
                    getEl('potongan_rp_manual').disabled = false;

                    getEl('diskon_persen').value = '';
                }

                hitung();
            });


            function hitung() {
                const metode = getEl('metode_potongan').value;

                let pot = (metode == 'persen') ?
                    (sub - okr) * (parseID(getEl('diskon_persen').value) || 0) / 100 :
                    parseID(getEl('potongan_rp_manual').value);

                const total = sub - pot;

                // Ambil dan bersihkan input "jumlah_bayar" dari format uang
                const bayar = parseID(getEl('jumlah_bayar').value);

                const sisa = bayar < total ? total - bayar : 0;

                getEl('potongan_rp_calc').value = fmt(pot);
                getEl('total_bayar').value = fmt(total);
                getEl('termin').value = fmt(sisa);
            }


            ['diskon_persen', 'potongan_rp_manual', 'jumlah_bayar']
            .forEach(id => {
                getEl(id).addEventListener('input', hitung);
                getEl(id).addEventListener('change', hitung);
            });

            hitung();

            Notiflix.Confirm.init({
                plainText: false,
            });

            getEl('btn-verify').addEventListener('click', () => {
                const metode = getEl('metode_transaksi').value;
                const bayarInput = getEl('jumlah_bayar').value;
                const bukti = getEl('bukti_bayar').files[0]; // <input type="file" name="bukti_bayar">

                // Validasi awal
                if (!metode) {
                    Notiflix.Report.failure('Gagal', 'Silakan pilih metode pembayaran.', 'Tutup');
                    return;
                }

                if (!bayarInput || parseID(bayarInput) <= 0) {
                    Notiflix.Report.failure('Gagal', 'Silakan masukkan nominal bayar yang valid.', 'Tutup');
                    return;
                }

                if (!bukti) {
                    Notiflix.Report.failure('Gagal', 'Silakan lampirkan bukti bayar.', 'Tutup');
                    return;
                }
                const total = getEl('total_bayar').value;

                const bayarRaw = parseID(getEl('jumlah_bayar').value);
                const totalRaw = parseID(getEl('total_bayar').value); // bersihkan titik dan ubah jadi angka

                const bayar = fmt(bayarRaw);

                // if (bayarRaw < (0.5 * totalRaw)) {
                //     Notiflix.Report.failure('Gagal', 'Minimal pembayaran adalah 50% dari total tagihan.',
                //         'Tutup');
                //     return;
                // }

                Notiflix.Confirm.show(
                    'Konfirmasi Pembayaran',
                    `Total tagihan: Rp ${total}<br>Bayar: Rp ${bayar}`,
                    'Ya, Verifikasi',
                    'Batal',
                    () => {
                        const form = getEl('confirm-payment-form');

                        if (getEl('metode_potongan').value == 'persen') {
                            form.appendChild(Object.assign(document.createElement('input'), {
                                type: 'hidden',
                                name: 'diskon_persen',
                                value: parseID(getEl('diskon_persen').value)
                            }));
                        } else {
                            form.appendChild(Object.assign(document.createElement('input'), {
                                type: 'hidden',
                                name: 'potongan_rp',
                                value: parseID(getEl('potongan_rp_manual').value)
                            }));
                        }

                        form.appendChild(Object.assign(document.createElement('input'), {
                            type: 'hidden',
                            name: 'termin',
                            value: parseID(getEl('termin').value)
                        }));

                        form.appendChild(Object.assign(document.createElement('input'), {
                            type: 'hidden',
                            name: 'metode_transaksi',
                            value: getEl('metode_transaksi').value
                        }));

                        form.submit();
                    }
                );
            });

        });
    </script>
@endif
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Confirm Shipping/Pickup
            document.getElementById('btn-verify-2').addEventListener('click', () => {
                Notiflix.Confirm.show(
                    'Konfirmasi Pesanan',
                    'Yakin verifikasi {{ $order->metode_pengiriman ? 'pengiriman' : 'pengambilan' }} ini?',
                    'Ya',
                    'Batal',
                    () => document.getElementById('confirm-verif-form').submit()
                );
            });

            // Confirm Pelunasan (status 1)
            const btnLunas = document.getElementById('btn-lunas');
            if (btnLunas) {
                btnLunas.addEventListener('click', () => {
                    const metode = document.getElementById('metode_transaksi_paid').value;
                    const bukti = document.getElementById('bukti_lunas').files[
                    0]; // <input type="file" name="bukti_bayar">

                    // Validasi awal
                    if (!metode) {
                        Notiflix.Report.failure('Gagal', 'Silakan pilih metode pelunasan.', 'Tutup');
                        return;
                    }
                    if (!bukti) {
                        Notiflix.Report.failure('Gagal', 'Silakan lampirkan bukti lunas.', 'Tutup');
                        return;
                    }
                    Notiflix.Confirm.show(
                        'Konfirmasi Pelunasan',
                        'Yakin ingin menandai pembayaran ini sebagai LUNAS?',
                        'Ya, Lunasi',
                        'Batal',
                        () => document.getElementById('finish-payment-form').submit()
                    );
                });
            }
            // **Preview Desain**
            document.querySelectorAll('.btn-preview-desain').forEach(a => {
                a.addEventListener('click', e => {
                    e.preventDefault();
                    const url = a.dataset.url;
                    document.getElementById('desainPreview').src = url;
                    document.getElementById('downloadDesain').href = url;
                    new bootstrap.Modal(document.getElementById('desainModal')).show();
                });
            });
        });
    </script>
    @if($order->status_pembayaran == 1)
    <script>
        const now = new Date();
        const today = now.toISOString().split('T')[0];
        document.getElementById('paid_at').value = today;
        const pad = num => String(num).padStart(2, '0');
        const localHours = pad(now.getHours());
        const localMinutes = pad(now.getMinutes());
    </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.preview-desain').forEach(a => {
                a.addEventListener('click', e => {
                    e.preventDefault();

                    // Ambil URL & ekstensi
                    const url = a.dataset.url;
                    const ext = url.split('.').pop().toLowerCase();

                    // Kosongkan container
                    const container = document.getElementById('previewContainer');
                    container.innerHTML = '';

                    // Set link download
                    const downloadLink = document.getElementById('downloadDesain');
                    downloadLink.href = url;

                    // Tentukan preview sesuai ekstensi
                    const imgExt = ['jpg', 'jpeg', 'png', 'svg', 'tif,tiff'];
                    if (imgExt.includes(ext)) {
                        // Tampilkan gambar
                        const img = document.createElement('img');
                        img.src = url;
                        img.classList.add('img-fluid');
                        img.alt = 'Desain Preview';
                        container.appendChild(img);

                    } else if (ext === 'pdf') {
                        // Tampilkan PDF
                        const embed = document.createElement('embed');
                        embed.src = url;
                        embed.type = 'application/pdf';
                        embed.width = '100%';
                        embed.height = '600px';
                        container.appendChild(embed);

                    } else {
                        // Fallback (cdr, psd, ai, dll)
                        const p = document.createElement('p');
                        p.innerHTML =
                            `Tidak ada preview untuk <strong>.${ext}</strong>.<br>Anda bisa mengunduh filenya di bawah.`;
                        container.appendChild(p);
                    }

                    // **Tutup modal sebelum membuka yang baru** (jika masih terbuka)
                    // Ini berguna jika user menekan tombol preview berulang kali.
                    const existingModal = bootstrap.Modal.getInstance(document.getElementById(
                        'desainModal'));
                    if (existingModal) {
                        existingModal.hide();
                    }

                    // Buka modal
                    new bootstrap.Modal(document.getElementById('desainModal')).show();
                });
            });
        });
    </script>
@endsection

@push('modals')
    <div class="modal fade" id="desainModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Desain — {{ $order->spk }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    {{-- Container kosong untuk men‐inject preview --}}
                    <div id="previewContainer"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <a href="#" id="downloadDesain" class="btn btn-primary" download>
                        <i class="bx bx-download me-1"></i> Download File
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-preview-desain').forEach(a => {
                a.addEventListener('click', e => {
                    e.preventDefault();
                    const url = a.dataset.url;
                    document.getElementById('desainPreview').src = url;
                    document.getElementById('downloadDesain').href = url;
                    new bootstrap.Modal(document.getElementById('desainModal')).show();
                });
            });
        });
    </script>
@endsection
