@extends('layouts.app')

@section('content')
    <div class="container flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Detail Pesanan</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
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
                            <input type="text" class="form-control" value="{{ $order->express ? 'Ya' : 'Tidak' }}"
                                disabled>
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


                @if ($order->metode_pengiriman == 1)
                    <div class="mb-3">
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
                @endif

                {{-- Detail Produk dalam Order --}}
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

                <div class="mb-3">
                    <h3 class="mb-3">Detail Pemesanan</h3>
                    <table class="table table-bordered">
                        <thead class="table-info">
                            <tr>
                                <th>Jenis Produk</th>
                                <th>Jenis Sub Produk</th>
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
                                    $biayaExpress = $order->express ? $totalHargaItem * 0.5 : 0;
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
                                <th class="fw-bold fs-5">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    @can('order-manipulation')
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                                Ubah
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>

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
                        <h5 class="modal-title">Preview Desain</h5>
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
