@extends('layouts.app')

@section('title_page', 'Detail Verifikasi Pesanan')

@section('content')
    <div class="container flex-grow-1 container-p-y">
        {{-- Header & Back --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Detail Produksi Pesanan</h1>
                <a href="{{ route('orders.production') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
        </div>

        {{-- Informasi Pelanggan & Pesanan --}}
        <div class="card mb-4">
            <div class="card-body">
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
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="card mb-4">
            <div class="card-body">
                <h3>Detail Produk dalam Order</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Jenis Produk</th>
                            <th>Jenis Sub Produk</th>
                            <th>Jenis Finishing</th>
                            <th>Panjang (cm)</th>
                            <th>Lebar (cm)</th>
                            <th>Jumlah</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
@endsection

@push('modals')
    @php
        $url = asset('storage/' . $order->desain);
        $ext = strtolower(pathinfo($order->desain, PATHINFO_EXTENSION));
        $imgExt = ['jpg', 'jpeg', 'png', 'svg', 'tif,tiff'];
    @endphp

    <div class="modal fade" id="desainModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Preview Desain — {{ $order->spk }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    @if (in_array($ext, $imgExt))
                        {{-- Tampilkan gambar --}}
                        <img src="{{ $url }}" class="img-fluid" alt="Desain {{ $order->spk }}">
                    @elseif($ext === 'pdf')
                        {{-- Embed PDF --}}
                        <embed src="{{ $url }}" type="application/pdf" width="100%" height="600px">
                    @else
                        {{-- Fallback untuk CDR, PSD, AI, DLL --}}
                        <p>
                            Tidak ada preview untuk <strong>.{{ $ext }}</strong>.<br>
                            Anda bisa mengunduh filenya di bawah.
                        </p>
                    @endif
                </div>

                <div class="modal-footer justify-content-between">
                    <a href="{{ $url }}" download class="btn btn-primary">
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
