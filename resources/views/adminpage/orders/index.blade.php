<!-- resources/views/adminpage/orders/index.blade.php -->
@extends('adminpage.index')
@section('content')
@if (Auth::user()->role != 'Customer')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kelola Pesanan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Kelola Pesanan</li>
            </ol>

            <!-- Alert Messages -->
            <div id="alertContainer"></div>

            <!-- Filter Status Cards - FIXED -->
            <div class="row mb-4">
                <div class="col-xl-2 col-md-4">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Belum Bayar</div>
                                    <div class="h5 mb-0" id="count-0">{{ $orders->where('order_status', 0)->count() }}</div>
                                </div>
                                <i class="fas fa-clock fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Sudah Bayar</div>
                                    <div class="h5 mb-0" id="count-1">{{ $orders->where('order_status', 1)->count() }}</div>
                                </div>
                                <i class="fas fa-check-circle fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card bg-info text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Pengerjaan</div>
                                    <div class="h5 mb-0" id="count-2">{{ $orders->where('order_status', 2)->count() }}</div>
                                </div>
                                <i class="fas fa-cogs fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Pengiriman</div>
                                    <div class="h5 mb-0" id="count-3">{{ $orders->where('order_status', 3)->count() }}</div>
                                </div>
                                <i class="fas fa-truck fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Selesai</div>
                                    <div class="h5 mb-0" id="count-4">{{ $orders->where('order_status', 4)->count() }}</div>
                                </div>
                                <i class="fas fa-flag-checkered fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-white-75 small">Cancel</div>
                                    <div class="h5 mb-0" id="count-9">{{ $orders->where('order_status', 9)->count() }}</div>
                                </div>
                                <i class="fas fa-times-circle fa-2x text-white-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-table me-1"></i>
                            Data Pesanan
                            <span class="badge bg-secondary ms-2" id="totalCount">{{ $orders->count() }} total</span>
                        </div>
                        <div class="btn-group" role="group">
                            <input type="radio" class="btn-check" name="statusFilter" id="all" value="all" checked>
                            <label class="btn btn-outline-primary btn-sm" for="all">Semua</label>

                            <input type="radio" class="btn-check" name="statusFilter" id="unpaid" value="0">
                            <label class="btn btn-outline-secondary btn-sm" for="unpaid">Belum Bayar</label>

                            <input type="radio" class="btn-check" name="statusFilter" id="paid" value="1">
                            <label class="btn btn-outline-success btn-sm" for="paid">Sudah Bayar</label>

                            <input type="radio" class="btn-check" name="statusFilter" id="progress" value="2">
                            <label class="btn btn-outline-info btn-sm" for="progress">Pengerjaan</label>

                            <input type="radio" class="btn-check" name="statusFilter" id="shipping" value="3">
                            <label class="btn btn-outline-warning btn-sm" for="shipping">Pengiriman</label>

                            <input type="radio" class="btn-check" name="statusFilter" id="done" value="4">
                            <label class="btn btn-outline-primary btn-sm" for="done">Selesai</label>

                            <input type="radio" class="btn-check" name="statusFilter" id="cancelled" value="9">
                            <label class="btn btn-outline-danger btn-sm" for="cancelled">Cancel</label>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SPK</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status Bayar</th>
                                <th>Status Order</th>
                                <th>Deadline</th>
                                <th>Detail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($orders as $order)
                                <tr data-status="{{ $order->order_status }}" data-order-id="{{ $order->id }}">
                                    <td>{{ $no }}</td>
                                    <td>
                                        <strong>{{ $order->spk ?? 'SPK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $order->user->name }}</strong><br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>Rp {{ number_format($order->subtotal + ($order->ongkir ?? 0), 0, ',', '.') }}</strong>
                                        @if($order->express == 1)
                                            <span class="badge bg-warning text-dark ms-1">Express</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->payment_status == 0)
                                            <span class="badge bg-warning">Belum Bayar</span>
                                        @elseif($order->payment_status == 1)
                                            <span class="badge bg-success">Sudah Bayar</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="status-cell">
                                        @if($order->order_status == 0)
                                            <span class="badge bg-secondary">Belum Bayar</span>
                                        @elseif($order->order_status == 1)
                                            <span class="badge bg-success">Sudah Bayar</span>
                                        @elseif($order->order_status == 2)
                                            <span class="badge bg-info">Pengerjaan</span>
                                        @elseif($order->order_status == 3)
                                            <span class="badge bg-warning">Pengiriman</span>
                                        @elseif($order->order_status == 4)
                                            <span class="badge bg-primary">Selesai</span>
                                        @elseif($order->order_status == 9)
                                            <span class="badge bg-danger">Cancel</span>
                                        @else
                                            <span class="badge bg-dark">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($order->deadline)
                                            <div>
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }}
                                            </div>
                                            @if($order->waktu_deadline)
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($order->waktu_deadline)->format('H:i') }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-info btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $order->id }}">
                                            <i class="fa fa-eye"></i> Detail
                                        </button>
                                    </td>
                                    <td class="action-cell">
                                        <div class="btn-group">
                                            @if($order->order_status == 1 && $order->payment_status == 1)
                                                <!-- Tombol untuk mengubah status ke pengerjaan -->
                                                <button type="button"
                                                        class="btn btn-warning btn-sm me-1 status-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-new-status="2"
                                                        onclick="updateStatus({{ $order->id }}, 2)"
                                                        title="Mulai Pengerjaan">
                                                    <i class="fa fa-play"></i> Mulai
                                                </button>
                                            @endif

                                            @if($order->order_status == 2)
                                                <!-- Tombol untuk mengubah ke pengiriman -->
                                                <button type="button"
                                                        class="btn btn-warning btn-sm me-1 status-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-new-status="3"
                                                        onclick="updateStatus({{ $order->id }}, 3)"
                                                        title="Kirim">
                                                    <i class="fa fa-truck"></i> Kirim
                                                </button>
                                            @endif

                                            @if($order->order_status == 3)
                                                <!-- Tombol untuk menyelesaikan pesanan -->
                                                <button type="button"
                                                        class="btn btn-success btn-sm me-1 status-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-new-status="4"
                                                        onclick="updateStatus({{ $order->id }}, 4)"
                                                        title="Selesaikan">
                                                    <i class="fa fa-check"></i> Selesai
                                                </button>
                                            @endif

                                            @if($order->order_status != 9 && $order->order_status != 4)
                                                <!-- Tombol Cancel (kecuali sudah selesai atau sudah cancel) -->
                                                <button type="button"
                                                        class="btn btn-danger btn-sm me-1 status-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-new-status="9"
                                                        onclick="updateStatus({{ $order->id }}, 9)"
                                                        title="Cancel">
                                                    <i class="fa fa-times"></i> Cancel
                                                </button>
                                            @endif

                                            <!-- Tombol Edit -->
                                            <button type="button"
                                                    class="btn btn-primary btn-sm me-1 edit-btn"
                                                    data-order-id="{{ $order->id }}"
                                                    onclick="editOrder({{ $order->id }})"
                                                    title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Tombol Delete -->
                                            <button type="button"
                                                    class="btn btn-danger btn-sm delete-btn"
                                                    data-order-id="{{ $order->id }}"
                                                    onclick="deleteOrder({{ $order->id }})"
                                                    title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Detail Modals -->
    @foreach($orders as $order)
        <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $order->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $order->id }}">
                            Detail Pesanan - {{ $order->spk ?? 'SPK-' . str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Informasi Customer -->
                            <div class="col-md-6">
                                <h6 class="fw-bold">Informasi Customer</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="30%">Nama</td>
                                        <td>: {{ $order->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>: {{ $order->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Telepon</td>
                                        <td>: {{ $order->user->phone ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Informasi Pesanan -->
                            <div class="col-md-6">
                                <h6 class="fw-bold">Informasi Pesanan</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="30%">Tanggal Order</td>
                                        <td>: {{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Deadline</td>
                                        <td>: 
                                            @if($order->deadline)
                                                {{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }}
                                                @if($order->waktu_deadline)
                                                    {{ \Carbon\Carbon::parse($order->waktu_deadline)->format('H:i') }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td>: 
                                            @if($order->transaction_method == 0) Cash
                                            @elseif($order->transaction_method == 1) Transfer
                                            @elseif($order->transaction_method == 2) QRIS
                                            @else - @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Express</td>
                                        <td>: {{ $order->express == 1 ? 'Ya' : 'Tidak' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <!-- Detail Produk -->
                        <h6 class="fw-bold">Detail Produk</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Material</th>
                                        <th>Finishing</th>
                                        <th>Ukuran</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderProducts as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? '-' }}</td>
                                            <td>{{ $item->material_type ?? '-' }}</td>
                                            <td>{{ $item->finishing_type ?? '-' }}</td>
                                            <td>
                                                @if($item->length && $item->width)
                                                    {{ $item->length }} x {{ $item->width }} cm
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $item->qty ?? 0 }}</td>
                                            <td>Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <!-- Total & Catatan -->
                        <div class="row">
                            <div class="col-md-6">
                                @if($order->notes)
                                    <h6 class="fw-bold">Catatan</h6>
                                    <p class="text-muted">{{ $order->notes }}</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold">Ringkasan Biaya</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td>Subtotal Produk</td>
                                        <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @if($order->ongkir)
                                        <tr>
                                            <td>Biaya Kirim</td>
                                            <td class="text-end">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                    @if($order->potongan_rp)
                                        <tr>
                                            <td>Diskon</td>
                                            <td class="text-end text-success">- Rp {{ number_format($order->potongan_rp, 0, ',', '.') }}</td>
                                        </tr>
                                    @endif
                                    <tr class="fw-bold border-top">
                                        <td>Total</td>
                                        <td class="text-end">Rp {{ number_format($order->subtotal + ($order->ongkir ?? 0) - ($order->potongan_rp ?? 0), 0, ',', '.') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_spk" class="form-label">SPK</label>
                                    <input type="text" class="form-control" id="edit_spk" name="spk">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_customer" class="form-label">Customer</label>
                                    <input type="text" class="form-control" id="edit_customer_display" readonly 
                                        style="background-color: #f8f9fa; cursor: not-allowed;">
                                    <input type="hidden" id="edit_user_id" name="user_id">
                                    <small class="form-text text-muted">Customer tidak dapat diubah setelah pesanan dibuat</small>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_subtotal" class="form-label">Subtotal</label>
                                    <input type="number" class="form-control" id="edit_subtotal" name="subtotal" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_ongkir" class="form-label">Biaya Kirim</label>
                                    <input type="number" class="form-control" id="edit_ongkir" name="ongkir">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_payment_status" class="form-label">Status Pembayaran</label>
                                    <select class="form-select" id="edit_payment_status" name="payment_status" required>
                                        <option value="0">Belum Bayar</option>
                                        <option value="1">Sudah Bayar</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_order_status" class="form-label">Status Order</label>
                                    <select class="form-select" id="edit_order_status" name="order_status" required>
                                        <option value="0">Belum Bayar</option>
                                        <option value="1">Sudah Bayar</option>
                                        <option value="2">Pengerjaan</option>
                                        <option value="3">Pengiriman</option>
                                        <option value="4">Selesai</option>
                                        <option value="9">Cancel</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_deadline" class="form-label">Tanggal Deadline</label>
                                    <input type="date" class="form-control" id="edit_deadline" name="deadline">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_waktu_deadline" class="form-label">Waktu Deadline</label>
                                    <input type="time" class="form-control" id="edit_waktu_deadline" name="waktu_deadline">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="edit_notes" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="edit_notes" name="notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@else
    @include('adminpage.access_denied')
@endif
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('input[name="statusFilter"]');
    const tableRows = document.querySelectorAll('#datatablesSimple tbody tr');
    
    filterButtons.forEach(button => {
        button.addEventListener('change', function() {
            const filterValue = this.value;
            console.log('Filter selected:', filterValue);
            
            let visibleCount = 0;
            
            tableRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                
                if (filterValue === 'all') {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    if (rowStatus === filterValue) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
            
            document.getElementById('totalCount').textContent = visibleCount + ' ditampilkan';
            
            updateRowNumbers();
        });
    });
    
    function updateRowNumbers() {
        let visibleRowNumber = 1;
        tableRows.forEach(row => {
            if (row.style.display !== 'none') {
                row.querySelector('td:first-child').textContent = visibleRowNumber;
                visibleRowNumber++;
            }
        });
    }
    
    function showAlert(message, type = 'success') {
        const alertContainer = document.getElementById('alertContainer');
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        alertContainer.innerHTML = alertHtml;
        
        setTimeout(() => {
            const alert = alertContainer.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                setTimeout(() => alert.remove(), 150);
            }
        }, 5000);
    }
    
    window.updateStatus = function(orderId, newStatus) {
        const statusNames = {
            0: 'Belum Bayar',
            1: 'Sudah Bayar', 
            2: 'Pengerjaan',
            3: 'Pengiriman',
            4: 'Selesai',
            9: 'Cancel'
        };
        
        if (!confirm(`Ubah status pesanan menjadi "${statusNames[newStatus]}"?`)) {
            return;
        }
        
        const button = document.querySelector(`[data-order-id="${orderId}"][data-new-status="${newStatus}"]`);
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        button.disabled = true;
        
        fetch(`{{ url('admin/orders') }}/${orderId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                
                const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                const statusCell = row.querySelector('.status-cell');
                const actionCell = row.querySelector('.action-cell');
                
                const statusBadges = {
                    0: '<span class="badge bg-secondary">Belum Bayar</span>',
                    1: '<span class="badge bg-success">Sudah Bayar</span>',
                    2: '<span class="badge bg-info">Pengerjaan</span>',
                    3: '<span class="badge bg-warning">Pengiriman</span>',
                    4: '<span class="badge bg-primary">Selesai</span>',
                    9: '<span class="badge bg-danger">Cancel</span>'
                };
                statusCell.innerHTML = statusBadges[newStatus];
                
                row.setAttribute('data-status', newStatus);
                
                updateActionButtons(orderId, newStatus, actionCell);
                
                updateCounters();
                
            } else {
                showAlert(data.message || 'Gagal mengubah status', 'danger');
                button.innerHTML = originalHtml;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat mengubah status', 'danger');
            button.innerHTML = originalHtml;
            button.disabled = false;
        });
    };
    
    function updateActionButtons(orderId, newStatus, actionCell) {
        let buttonsHtml = '';
        
        if (newStatus == 1) {
            buttonsHtml += `
                <button type="button" class="btn btn-warning btn-sm me-1 status-btn"
                        data-order-id="${orderId}" data-new-status="2"
                        onclick="updateStatus(${orderId}, 2)" title="Mulai Pengerjaan">
                    <i class="fa fa-play"></i> Mulai
                </button>
            `;
        } else if (newStatus == 2) {
            buttonsHtml += `
                <button type="button" class="btn btn-warning btn-sm me-1 status-btn"
                        data-order-id="${orderId}" data-new-status="3"
                        onclick="updateStatus(${orderId}, 3)" title="Kirim">
                    <i class="fa fa-truck"></i> Kirim
                </button>
            `;
        } else if (newStatus == 3) {
            buttonsHtml += `
                <button type="button" class="btn btn-success btn-sm me-1 status-btn"
                        data-order-id="${orderId}" data-new-status="4"
                        onclick="updateStatus(${orderId}, 4)" title="Selesaikan">
                    <i class="fa fa-check"></i> Selesai
                </button>
            `;
        }
        
        if (newStatus != 9 && newStatus != 4) {
            buttonsHtml += `
                <button type="button" class="btn btn-danger btn-sm me-1 status-btn"
                        data-order-id="${orderId}" data-new-status="9"
                        onclick="updateStatus(${orderId}, 9)" title="Cancel">
                    <i class="fa fa-times"></i> Cancel
                </button>
            `;
        }
        
        buttonsHtml += `
            <button type="button" class="btn btn-primary btn-sm me-1 edit-btn"
                    data-order-id="${orderId}" onclick="editOrder(${orderId})" title="Edit">
                <i class="fa fa-edit"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm delete-btn"
                    data-order-id="${orderId}" onclick="deleteOrder(${orderId})" title="Hapus">
                <i class="fa fa-trash"></i>
            </button>
        `;
        
        actionCell.querySelector('.btn-group').innerHTML = buttonsHtml;
    }
    
    function updateCounters() {
        const counts = {0: 0, 1: 0, 2: 0, 3: 0, 4: 0, 9: 0};
        
        tableRows.forEach(row => {
            const status = parseInt(row.getAttribute('data-status'));
            if (counts.hasOwnProperty(status)) {
                counts[status]++;
            }
        });
        
        Object.keys(counts).forEach(status => {
            const countElement = document.getElementById(`count-${status}`);
            if (countElement) {
                countElement.textContent = counts[status];
            }
        });
    }
    
    window.editOrder = function(orderId) {
        fetch(`{{ url('admin/orders') }}/${orderId}/edit`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('edit_spk').value = data.order.spk || '';
                document.getElementById('edit_subtotal').value = data.order.subtotal || 0;
                document.getElementById('edit_ongkir').value = data.order.ongkir || '';
                document.getElementById('edit_payment_status').value = data.order.payment_status;
                document.getElementById('edit_order_status').value = data.order.order_status;
                document.getElementById('edit_deadline').value = data.order.deadline || '';
                document.getElementById('edit_waktu_deadline').value = data.order.waktu_deadline || '';
                document.getElementById('edit_notes').value = data.order.notes || '';
                
                const customerDisplay = `${data.order.user.name} (${data.order.user.email})`;
                document.getElementById('edit_customer_display').value = customerDisplay;
                
                document.getElementById('edit_user_id').value = data.order.user_id;
                
                document.getElementById('editForm').setAttribute('data-order-id', orderId);
                
                new bootstrap.Modal(document.getElementById('editModal')).show();
            } else {
                showAlert('Gagal memuat data pesanan', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat memuat data', 'danger');
        });
    };
    
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const orderId = this.getAttribute('data-order-id');
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        submitBtn.disabled = true;
        
        fetch(`{{ url('admin/orders') }}/${orderId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                
                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showAlert(data.message || 'Gagal memperbarui pesanan', 'danger');
            }
            
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat menyimpan', 'danger');
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    window.deleteOrder = function(orderId) {
        if (!confirm('Apakah Anda yakin ingin menghapus pesanan ini?')) {
            return;
        }
        
        const button = document.querySelector(`[data-order-id="${orderId}"].delete-btn`);
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        button.disabled = true;
        
        fetch(`{{ url('admin/orders') }}/${orderId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success');
                
                const row = document.querySelector(`tr[data-order-id="${orderId}"]`);
                row.remove();
                
                updateCounters();
                updateRowNumbers();
                
                const remainingRows = document.querySelectorAll('#datatablesSimple tbody tr').length;
                document.getElementById('totalCount').textContent = remainingRows + ' total';
                
            } else {
                showAlert(data.message || 'Gagal menghapus pesanan', 'danger');
                button.innerHTML = originalHtml;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat menghapus', 'danger');
            button.innerHTML = originalHtml;
            button.disabled = false;
        });
    };
});
</script>
@endsection