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
                    <h4 class="m-0">Verifikasi Pembayaran</h4>
                </div>
            </div>
            <div class="card-body">
                <x-filter-form :action="route('orders.payment')" :reset-url="route('orders.payment')" :show-spk="false" :show-invoice="true" :show-payment-method="true"
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
                                @can('payment-manipulation')
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
                                    @if ($order->potongan_rp)
                                        <td>Rp{{ number_format($order->subtotal - $order->potongan_rp, 0, ',', '.') }}</td>
                                    @elseif ($order->diskon_persen)
                                        <td>Rp{{ number_format($order->subtotal - ($order->diskon_persen / 100) * ($order->subtotal - $order->ongkir), 0, ',', '.') }}
                                        </td>
                                    @else
                                        <td>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }} -
                                        {{ $order->waktu_deadline ? date('H:i', strtotime($order->waktu_deadline)) : '' }}
                                    </td>
                                    
                                    <td>
                                        <span
                                            class="badge {{ $order->express ? 'bg-label-success' : 'bg-label-primary' }}">
                                            {{ $order->express ? 'Express' : 'Reguler' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $order->kebutuhan_proofing == 0 ? 'bg-label-success' : 'bg-label-primary' }}">
                                            {{ $order->kebutuhan_proofing == 0 ? 'Proofing' : 'Cetak Jadi' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeStatus = [
                                                0 => ['label' => 'Unpaid', 'class' => 'bg-label-danger'],
                                                1 => ['label' => 'Partial', 'class' => 'bg-label-primary'],
                                                2 => ['label' => 'Paid', 'class' => 'bg-label-success'],
                                            ];
                                            $status = $badgeStatus[$order->status_pembayaran] ?? [
                                                'label' => 'Unknown',
                                                'class' => 'bg-label-secondary',
                                            ];
                                        @endphp

                                        <span class="badge {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    @can('payment-manipulation')
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if ($order->status_pembayaran != 0)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('orders.invoice', $order->id) }}">
                                                        <i class="bx bx-file me-1"></i> Invoice
                                                    </a>
                                                </li>
                                                @endif
                                                @if ($order->status_pembayaran != 2)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('orders.paymentShow', $order->id) }}">
                                                        <i class="bx bx-show-alt me-1"></i> Verifikasi
                                                    </a>
                                                </li>
                                                @endif
                                                <li>
                                                    <button type="button" class="dropdown-item btn btn-cancel-verif"
                                                        data-url="{{ route('orders.cancel', $order->id) }}">
                                                        <i class="bx bx-x-circle me-1"></i> Batal Verif
                                                    </button>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item btn btn-cancel"
                                                        data-url="{{ route('orders.confirmCanceled', $order->id) }}">
                                                        <i class="bx bx-block"></i> Cancel
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">Belum ada data order</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- <x-pagination :paginator="$ar_order" /> --}}
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.btn-cancel-verif').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const url = this.dataset.url;
                        Notiflix.Confirm.show(
                            'Verifikasi Order',
                            'Yakin ingin mengembalikan/cancel verifikasi order ini?',
                            'Ya',
                            'Tidak',
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
        @section('script')
            <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
            <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
            <!-- Inisialisasi DataTables -->
            <script>
                $(function() {
                    $('#datatable').DataTable();
                });
            </script>
        @endsection
    @endsection
