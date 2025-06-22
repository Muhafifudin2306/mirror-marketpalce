@extends('layouts.app')

@section('title_page', 'Proses Produksi')

@section('style')
        <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
    @endsection

@section('content')

    <div class="container-fluid container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Tabs --}}
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

        {{-- Table --}}
       <div class="card" style="overflow-x: auto;">
            <div class="card-header border-bottom pb-2 mb-2">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0">Proses Produksi</h4>
                </div>
            </div>  
            <div class="card-body">
                <x-filter-form 
                    :action="route('orders.production')" 
                    :reset-url="route('orders.production')" 
                    :show-spk="true"
                    :show-invoice="false"
                    :show-payment-method="false" 
                    :show-status-pemesanan="false"
                form-id="filterForm" />
                <div class="mt-5">
                    <table id="datatable" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Order</th>
                                <th>SPK</th>
                                <th>Pelanggan</th>
                                <th>Deadline</th>
                                <th>Kebutuhan</th>
                                <th>Express</th>
                                <th>Status</th>
                                {{-- <th>File Cetak</th>
                                <th>File Preview</th> --}}
                                @can('production-manipulation')
                                <th>Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ar_order as $i => $order)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->tanggal)->format('d/m/Y') }} -
                                        {{ $order->waktu ? date('H:i', strtotime($order->waktu)) : '' }}</td>
                                    <td>{{ $order->spk }}</td>
                                    <td>{{ $order->nama_pelanggan }}</td>
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
                                        <span class="badge bg-label-primary">
                                            {{ ucfirst($order->status_pengerjaan) }}
                                        </span>
                                    </td>
                                    {{-- <td>
                                        @if ($order->desain)
                                            <a href="#"
                                            data-url="{{ asset('storage/'.$order->desain) }}"
                                            class="btn btn-sm btn-outline-primary btn-preview-desain"
                                            >
                                                <i class="bx bx-show-alt me-1"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                     <td>
                                        @if ($order->desain)
                                            <a href="#"
                                            data-url="{{ asset('storage/'.$order->preview) }}"
                                            class="btn btn-sm btn-outline-primary btn-preview-desain"
                                            >
                                                <i class="bx bx-show-alt me-1"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td> --}}
                                    @can('production-manipulation')
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" data-bs-boundary="viewport">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a href="{{ route('orders.confirmProduction', $order->id) }}"
                                                        class="dropdown-item btn-production">
                                                        <i class="bx bx-check-circle me-1"></i> Tandai Selesai
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('orders.productionShow', $order->id) }}"
                                                        class="dropdown-item">
                                                        <i class="bx bx-show-alt me-1"></i> Detail
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">Belum ada data order</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- <x-pagination :paginator="$ar_order" /> --}}
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        {{-- <div class="mt-3">
            {{ $ar_order->links() }}
        </div> --}}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirm produksi selesai (POST saja)
            document.querySelectorAll('.btn-production').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Notiflix.Confirm.show(
                        'Verifikasi Produksi',
                        'Yakin produksi untuk order ini sudah selesai?',
                        'Ya',
                        'Batal',
                        () => {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = this.href;
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=\"csrf-token\"]').content}">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    );
                });
            });
        });
    </script>
        @section('script')
            <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
            <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
            <!-- Inisialisasi DataTables -->
            <script>
                $(function() {
                    $('#datatable').DataTable();
                });
            </script>
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
                        const imgExt = ['jpg','jpeg','png','svg','tif,tiff'];
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
                        p.innerHTML = `Tidak ada preview untuk <strong>.${ext}</strong>.<br>Anda bisa mengunduh filenya di bawah.`;
                        container.appendChild(p);
                        }

                        // **Tutup modal sebelum membuka yang baru** (jika masih terbuka)
                        // Ini berguna jika user menekan tombol preview berulang kali.
                        const existingModal = bootstrap.Modal.getInstance(document.getElementById('desainModal'));
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