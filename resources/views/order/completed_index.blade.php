@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
            @can('order-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                        Data Pesanan
                    </a>
                </li>
            @endcan
            @can('payment-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.payment') ? 'active' : '' }}" href="{{ route('orders.payment') }}">
                        Verifikasi Pembayaran
                    </a>
                </li>
            @endcan
            @can('orderVerif-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.orderVerif') ? 'active' : '' }}"
                        href="{{ route('orders.orderVerif') }}">Verifikasi Pesanan</a>
                </li>
            @endcan
            @can('production-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.production') ? 'active' : '' }}"
                        href="{{ route('orders.production') }}">Produksi Pesanan</a>
                </li>
            @endcan
            @can('shipping-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.shipping') ? 'active' : '' }}"
                        href="{{ route('orders.shipping') }}">Pengambilan / Pengiriman</a>
                </li>
            @endcan
            @can('finish-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.completed') ? 'active' : '' }}"
                        href="{{ route('orders.completed') }}">Selesai</a>
                </li>
            @endcan
            @can('cancel-management')
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ Route::is('orders.canceled') ? 'active' : '' }}"
                        href="{{ route('orders.canceled') }}">Cancel</a>
                </li>
            @endcan
        </ul>
        <div class="card" style="overflow-x: auto;">
            <div class="card-header border-bottom pb-2 mb-2">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0">Pesanan Selesai</h4>
                    @can('completed-manipulation')
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-file-earmark-excel"></i> Download Order
                        </button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <x-filter-form :action="route('orders.completed')" :reset-url="route('orders.completed')" :show-spk="false" :show-invoice="false" :show-invoice="true"
                    :show-payment-method="false" :show-status-pemesanan="false" form-id="filterForm" />
                <div class="mt-5">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Order</th>
                                <th>SPK</th>
                                <th>Jenis</th>
                                <th>Pelanggan</th>
                                <th>Nowor WA</th>
                                <th>Email</th>
                                <th>Total Transaksi</th>
                                <th>Deadline</th>
                                <th>Kebutuhan</th>
                                <th>Express</th>
                                <th>Status</th>
                                <th>Bukti Bayar</th>
                                <th>Bukti Lunas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ar_order as $i => $order)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d/m/Y') }} -
                                        {{ $order->waktu ? date('H:i', strtotime($order->waktu)) : '' }}</td>
                                    <td>{{ $order->spk }}</td>
                                    <td>
                                        @php
                                            $badgeStatus = [
                                                0 => ['label' => 'On The Spot', 'class' => 'bg-label-primary'],
                                                1 => ['label' => 'WA/Email/Phone', 'class' => 'bg-label-success'],
                                                2 => ['label' => 'Marketplace', 'class' => 'bg-label-primary'],
                                            ];
                                            $status = $badgeStatus[$order->jenis_transaksi] ?? [
                                                'label' => 'Unknown',
                                                'class' => 'bg-label-secondary',
                                            ];
                                        @endphp

                                        <span class="badge {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td>{{ $order->nama_pelanggan }}</td>
                                    <td>{{ $order->kontak_pelanggan }}</td>
                                    <td>{{ $order->email_pelanggan ? $order->email_pelanggan : '-' }}</td>
                                    <td>Rp{{ number_format($order->subtotal, 0, ',', ',') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }} -
                                        {{ $order->waktu_deadline ? date('H:i', strtotime($order->waktu_deadline)) : '' }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $order->kebutuhan_proofing == 0 ? 'bg-label-success' : 'bg-label-primary' }}">
                                            {{ $order->kebutuhan_proofing == 0 ? 'Proofing' : 'Cetak Jadi' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $order->express ? 'bg-label-success' : 'bg-label-primary' }}">
                                            {{ $order->express ? 'Express' : 'Reguler' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-label-success">
                                            {{ ucfirst($order->status_pengerjaan) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($order->bukti_bayar)
                                            <a href="#" data-url="{{ asset('storage/' . $order->bukti_bayar) }}"
                                                class="btn-preview-desain">
                                                @php
                                                    $badgeStatus = [
                                                        0 => ['label' => 'Cash', 'class' => 'bg-label-primary'],
                                                        1 => ['label' => 'Transafer', 'class' => 'bg-label-success'],
                                                        2 => ['label' => 'QRIS', 'class' => 'bg-label-primary'],
                                                    ];
                                                    $status = $badgeStatus[$order->metode_transaksi] ?? [
                                                        'label' => 'Unknown',
                                                        'class' => 'bg-label-secondary',
                                                    ];
                                                @endphp

                                                <span class="badge {{ $status['class'] }}">
                                                    Bukti {{ $status['label'] }}
                                                </span>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->bukti_lunas)
                                            <a href="#" data-url="{{ asset('storage/' . $order->bukti_lunas) }}"
                                                class="btn-preview-desain">
                                                @php
                                                    $badgeStatus = [
                                                        0 => ['label' => 'Cash', 'class' => 'bg-label-primary'],
                                                        1 => ['label' => 'Transafer', 'class' => 'bg-label-success'],
                                                        2 => ['label' => 'QRIS', 'class' => 'bg-label-primary'],
                                                    ];
                                                    $status = $badgeStatus[$order->metode_transaksi_paid] ?? [
                                                        'label' => 'Unknown',
                                                        'class' => 'bg-label-secondary',
                                                    ];
                                                @endphp

                                                <span class="badge {{ $status['class'] }}">
                                                    Bukti {{ $status['label'] }}
                                                </span>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @can('completed-manipulation')
                                                    @if ($order->status_pembayaran != 0)
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('orders.invoice', $order->id) }}">
                                                                <i class="bx bx-file me-1"></i> Invoice
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endcan
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('orders.completedShow', $order->id) }}">
                                                        <i class="bx bx-show-alt me-1"></i> Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="text-center">Belum ada data order</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <x-pagination :paginator="$ar_order" /> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="downloadForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Download Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" id="startDate" class="form-control" name="start_date">
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" id="endDate" class="form-control" name="end_date">
                        </div>

                        <div class="mb-3">
                            <label for="status_pengerjaan" class="form-label">Status Pengerjaan</label>
                            <select name="status_pengerjaan" id="statusPengerjaan" class="form-select">
                                <option value="semua" selected>Semua</option>
                                <option value="pending">Pending</option>
                                <option value="verif_pesanan">Verifikasi Pesanan</option>
                                <option value="verif_pembayaran">Verifikasi Pmebayaran</option>
                                <option value="produksi">Produksi</option>
                                <option value="pengambilan">Pengambilan</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>
                    </div>

                    <button id="downloadButton" class="btn btn-success m-3">
                        <span class="button-text">Download
                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    Notiflix.Confirm.show(
                        'Hapus Data',
                        'Yakin ingin menghapus data ini? Tindakan ini tidak bisa dibatalkan.',
                        'Ya, Hapus!',
                        'Batal',
                        function onOk() {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const token = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');
                            form.innerHTML = `
                <input type="hidden" name="_token" value="${token}">
                <input type="hidden" name="_method" value="DELETE">
            `;
                            document.body.appendChild(form);
                            form.submit();
                        },
                        function onCancel() {}, {
                            width: '320px',
                            borderRadius: '8px',
                            titleColor: '#e74c3c',
                            okButtonBackground: '#e74c3c',
                            cancelButtonBackground: '#95a5a6',
                        }
                    );
                });
            });
        });
    </script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.btn-preview-desain').forEach(a => {
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
@section('script')
    <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
    <script>
        $(function() {
            $('#datatable').DataTable();
        });
        $(function() {
            $('#downloadButton').on('click', function(e) {
                e.preventDefault();

                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();
                var status = $('#statusPengerjaan').val();

                if (startDate && endDate && startDate > endDate) {
                    alert('Tanggal Mulai tidak boleh lebih besar dari Tanggal Selesai!');
                    return;
                }

                var $button = $(this);
                $button.prop('disabled', true);
                $button.find('.button-text').text('Downloading...');
                $button.find('.spinner-border').removeClass('d-none');

                $.ajax({
                    url: '/orders/export',
                    type: 'GET',
                    data: {
                        start_date: startDate,
                        end_date: endDate,
                        status_pengerjaan: status
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(data, status, xhr) {
                        var filename = '';
                        var disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            var matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                disposition);
                            if (matches != null && matches[1]) filename = matches[1].replace(
                                /['"]/g, '');
                        }
                        var blob = new Blob([data], {
                            type: xhr.getResponseHeader('Content-Type')
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename || 'orders.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        $('#filterModal').modal('hide');

                        $('#startDate').val('');
                        $('#endDate').val('');
                        $('#statusPengerjaan').val('');
                    },
                    error: function() {
                        alert('Gagal mendownload file!');
                    },
                    complete: function() {
                        $button.prop('disabled', false);
                        $button.find('.button-text').text('Download');
                        $button.find('.spinner-border').addClass('d-none');
                    }
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
