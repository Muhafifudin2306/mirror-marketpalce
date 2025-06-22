@extends('layouts.app')

@section('content')
    <div class="container flex-grow-1 container-p-y">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="m-0">Detail Pesanan</h1>
            <a href="{{ route('orders.canceled') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        {{-- Informasi Pelanggan & Pesanan --}}
        <div class="card mb-4">
            <div class="card-body">
                <h3>Informasi Pelanggan & Pesanan</h3>
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
                        <div class="col-md-6 mb-2">
                        <label class="text-danger">Alasan Pembatalan</label>
                        <input type="text" class="form-control" value="{{ $order->cancel_reason }}" disabled>
                    </div>
                        @if ($order->preview)
                            @php
                                $url_preview = asset('storage/' . $order->preview);
                                $ext_preview = strtolower(pathinfo($order->preview, PATHINFO_EXTENSION));
                                $imgExt_preview = ['jpg', 'jpeg', 'png', 'svg', 'tif,tiff'];
                            @endphp
                            <div class="col-md-12 mb-3">
                                <label>Desain Preview</label>
                                @if (in_array($ext_preview, $imgExt_preview))
                                    <img src="{{ $url_preview }}" class="w-100" alt="Desain {{ $order->spk }}">
                                @elseif($ext_preview === 'pdf')
                                    <embed src="{{ $url_preview }}" type="application/pdf" width="100%" height="600px">
                                @else
                                    <p>
                                        Tidak ada preview untuk <strong>.{{ $ext_preview }}</strong>.<br>
                                        Anda bisa mengunduh filenya di bawah.
                                    </p>
                                    <a href="{{ $url_preview }}" download class="btn btn-primary">
                                        <i class="bx bx-download me-1"></i> Download File
                                    </a>
                                @endif
                            </div>
                        @endif
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
        @if($order->metode_pengiriman)
            <div class="card mb-4">
                <div class="card-body">
                    <h3>Informasi Pengiriman</h3>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label>Berat (gram)</label>
                            <input type="text" class="form-control" value="{{ $order->berat }}" disabled>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Kode Pos</label>
                            <input type="text" class="form-control" value="{{ $order->kode_pos }}" disabled>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Kurir</label>
                            <input type="text" class="form-control" value="{{ $order->kurir ?? '-' }}" disabled>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Biaya Ongkir</label>
                            <input type="text" class="form-control" value="Rp {{ number_format($order->ongkir, 0, ',', '.') }}" disabled>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label>Alamat Lengkap</label>
                            <textarea class="form-control" rows="2" disabled>{{ $order->alamat }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Detail Produk dalam Order --}}
        <div class="card mb-4">
        <div class="card-body">
            <h3>Detail Produk dalam Order</h3>
            @php
                $finishingTypes = [
                    0 => 'LPMA',
                    1 => 'PGMA',
                    2 => 'LOS',
                    3 => 'LA',
                    4 => 'KOLAB',
                    5 => 'KOLKAKI',
                    6 => 'KOLAB MA',
                    7 => 'KOLKAKI MA',
                ];
            @endphp
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
