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
                    <h4 class="m-0">Manage Order</h4>
                    @can('order-manipulation')
                        <a href="{{ route('orders.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Tambah Data
                        </a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                <x-filter-form :action="route('orders.index')" :reset-url="route('orders.index')" :show-spk="true" :show-invoice="false" :show-payment-method="false"
                    :show-status-pemesanan="false" form-id="filterForm" />
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
                                        <span class="badge bg-label-secondary">
                                            {{ ucfirst($order->status_pengerjaan) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @can('order-manipulation')
                                                    <li>
                                                        <button type="button" class="dropdown-item btn btn-verify"
                                                            data-url="{{ route('orders.verify', $order->id) }}">
                                                            <i class="bx bx-check-circle me-1"></i> Verifikasi
                                                        </button>
                                                    </li>
                                                @endcan
                                                @can('order-manipulation')
                                                    <li>
                                                        <button type="button" class="dropdown-item btn btn-production"
                                                            data-url="{{ route('orders.production-shortcut', $order->id) }}">
                                                            <i class="bx bx-cut me-1"></i> Produksi Dulu
                                                        </button>
                                                    </li>
                                                @endcan
                                                @can('order-management')
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('orders.show', $order->id) }}">
                                                            <i class="bx bx-show-alt me-1"></i> Detail
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('order-manipulation')
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                </li>
                                                @endcan
                                                @can('order-manipulation')
                                                <li>
                                                    <button type="button" class="dropdown-item btn btn-delete"
                                                        data-url="{{ route('orders.destroy', $order->id) }}">
                                                        <i class="bx bx-trash me-1"></i> Hapus
                                                    </button>
                                                </li>
                                                @endcan
                                                @can('order-manipulation')
                                                    <li>
                                                        <button type="button" class="dropdown-item btn btn-cancel"
                                                            data-url="{{ route('orders.confirmCanceled', $order->id) }}">
                                                            <i class="bx bx-block"></i> Cancel
                                                        </button>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">Belum ada data order</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @can('order-manipulation')
    <script>
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
            document.querySelectorAll('.btn-verify').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    Notiflix.Confirm.show(
                        'Verifikasi Order',
                        'Yakin ingin memverifikasi order ini?',
                        'Ya, Verifikasi',
                        'Batal',
                        () => {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;
                            form.innerHTML = `
                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
              `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    );
                });
            });
            document.querySelectorAll('.btn-production').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    Notiflix.Confirm.show(
                        'Verifikasi Order',
                        'Yakin ingin langsung memproduksi order ini?',
                        'Ya, Verifikasi',
                        'Batal',
                        () => {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;
                            form.innerHTML = `
                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
              `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    );
                });
            });
            document.querySelectorAll('.btn-cancel').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    console.log('url: ', url);
                    Notiflix.Confirm.show(
                        'Pembatalan Order',
                        'Yakin ingin Membatalkan order ini?',
                        'Ya, Batal',
                        'Batal',
                        () => {
                            const alasan = prompt("Masukkan alasan pembatalan:");

                            if (alasan === null || alasan.trim() === '') {
                                Notiflix.Notify.failure(
                                    'Pembatalan dibatalkan karena alasan tidak diisi.');
                                return;
                            }

                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                <input type="hidden" name="cancel_reason" value="${alasan}">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    );
                });
            });
        });
    </script>
    @endcan

    @section('script')
        <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
        <script>
            $(function() {
                $('#datatable').DataTable();
            });
        </script>
    @endsection

@endsection
