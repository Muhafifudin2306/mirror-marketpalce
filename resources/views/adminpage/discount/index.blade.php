@extends('adminpage.index')
@section('content')
@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">
      <i class="fas fa-tags me-2"></i>Kelola Diskon Produk
    </h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a></li>
      <li class="breadcrumb-item active">Kelola Diskon</li>
    </ol>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="fas fa-list me-2"></i>Daftar Diskon Produk
        </h5>
        <a href="{{ route('admin.discount.create') }}" class="btn btn-light btn-sm">
          <i class="fas fa-plus me-1"></i>Tambah Diskon
        </a>
      </div>
      <div class="card-body">
        @if($discounts->count() > 0)
          <div class="table-responsive">
            <table id="datatablesSimple" class="table table-striped table-hover">
              <thead class="table-dark">
                <tr>
                  <th width="5%">No</th>
                  <th width="15%">Nama Diskon</th>
                  <th width="8%">Diskon %</th>
                  <th width="12%">Diskon Tetap</th>
                  <th width="10%">Status</th>
                  <th width="20%">Durasi</th>
                  <th width="20%">Produk</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
                @php $no = 1; @endphp
                @foreach($discounts as $disc)
                  @php
                    $totalProducts = \App\Models\Product::count();
                    $discountProductsCount = $disc->products->count();
                    $isAllProducts = ($discountProductsCount == $totalProducts && $totalProducts > 0);
                    
                    // Check if discount is currently active - FIXED: Include time comparison
                    $now = now();
                    $startDiscount = \Carbon\Carbon::parse($disc->start_discount)->startOfDay();
                    $endDiscount = \Carbon\Carbon::parse($disc->end_discount)->endOfDay();
                    
                    $isActive = $now->between($startDiscount, $endDiscount);
                    $isExpired = $now->gt($endDiscount);
                    $isUpcoming = $now->lt($startDiscount);
                  @endphp
                  <tr>
                    <td>{{ $no }}</td>
                    <td>
                      <div class="fw-bold">{{ $disc->name ?: 'Diskon Tanpa Nama' }}</div>
                    </td>
                    <td>
                      @if($disc->discount_percent)
                        <span class="badge bg-success">{{ number_format($disc->discount_percent, 0) }}%</span>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      @if($disc->discount_fix)
                        <span class="badge bg-info text-dark">Rp {{ number_format($disc->discount_fix, 0, ',', '.') }}</span>
                      @else
                        <span class="text-muted">-</span>
                      @endif
                    </td>
                    <td>
                      @if($isActive)
                        <span class="badge bg-success">
                          <i class="fas fa-play me-1"></i>Aktif
                        </span>
                      @elseif($isExpired)
                        <span class="badge bg-danger">
                          <i class="fas fa-stop me-1"></i>Berakhir
                        </span>
                      @elseif($isUpcoming)
                        <span class="badge bg-warning text-dark">
                          <i class="fas fa-clock me-1"></i>Menunggu
                        </span>
                      @endif
                    </td>
                    <td>
                      <div class="small">
                        <div><strong>Mulai:</strong> {{ \Carbon\Carbon::parse($disc->start_discount)->format('d M Y') }}</div>
                        <div><strong>Selesai:</strong> {{ \Carbon\Carbon::parse($disc->end_discount)->format('d M Y') }}</div>
                      </div>
                    </td>
                    <td>
                      @if($isAllProducts)
                        <span class="badge bg-primary fs-6">
                          <i class="fas fa-globe me-1"></i>All Products
                        </span>
                        <div class="small text-muted mt-1">
                          {{ number_format($totalProducts) }} produk
                        </div>
                      @else
                        @if($disc->products->count() > 0)
                          <div class="small">
                            @if($disc->products->count() == 1)
                              <div class="fw-bold">{{ $disc->products->first()->name }}</div>
                            @else
                              <div class="fw-bold">{{ $disc->products->count() }} Produk:</div>
                              <div class="text-muted" style="max-height: 60px; overflow-y: auto;">
                                {{ $disc->products->pluck('name')->join(', ') }}
                              </div>
                            @endif
                          </div>
                        @else
                          <span class="text-muted">Tidak ada produk</span>
                        @endif
                      @endif
                    </td>
                    <td>
                      <div class="btn-group" role="group">
                        <a href="{{ route('admin.discount.edit', $disc->id) }}" 
                           class="btn btn-warning btn-sm" 
                           data-bs-toggle="tooltip" 
                           title="Edit Diskon">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" 
                              action="{{ route('admin.discount.destroy', $disc->id) }}" 
                              style="display:inline" 
                              onsubmit="return confirmDelete('{{ $disc->name ?: 'diskon ini' }}')">
                          @csrf @method('DELETE')
                          <button class="btn btn-danger btn-sm" 
                                  type="submit"
                                  data-bs-toggle="tooltip" 
                                  title="Hapus Diskon">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @php $no++; @endphp
                @endforeach
              </tbody>
            </table>
          </div>
        @else
          <div class="text-center py-5">
            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Belum Ada Diskon</h5>
            <p class="text-muted">Mulai buat diskon untuk produk Anda</p>
            <a href="{{ route('admin.discount.create') }}" class="btn btn-primary">
              <i class="fas fa-plus me-1"></i>Tambah Diskon Pertama
            </a>
          </div>
        @endif
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
      <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <div class="small">Total Diskon</div>
                <div class="h5">{{ $discounts->count() }}</div>
              </div>
              <i class="fas fa-tags fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <div class="small">Diskon Aktif</div>
                <div class="h5">
                  @php
                    $activeDiscounts = $discounts->filter(function($disc) {
                      $now = now();
                      $startDiscount = \Carbon\Carbon::parse($disc->start_discount)->startOfDay();
                      $endDiscount = \Carbon\Carbon::parse($disc->end_discount)->endOfDay();
                      return $now->between($startDiscount, $endDiscount);
                    });
                  @endphp
                  {{ $activeDiscounts->count() }}
                </div>
              </div>
              <i class="fas fa-play fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-dark mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <div class="small">Diskon Menunggu</div>
                <div class="h5">
                  @php
                    $upcomingDiscounts = $discounts->filter(function($disc) {
                      $now = now();
                      $startDiscount = \Carbon\Carbon::parse($disc->start_discount)->startOfDay();
                      return $now->lt($startDiscount);
                    });
                  @endphp
                  {{ $upcomingDiscounts->count() }}
                </div>
              </div>
              <i class="fas fa-clock fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <div class="small">Diskon Berakhir</div>
                <div class="h5">
                  @php
                    $expiredDiscounts = $discounts->filter(function($disc) {
                      $now = now();
                      $endDiscount = \Carbon\Carbon::parse($disc->end_discount)->endOfDay();
                      return $now->gt($endDiscount);
                    });
                  @endphp
                  {{ $expiredDiscounts->count() }}
                </div>
              </div>
              <i class="fas fa-stop fa-2x opacity-50"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
function confirmDelete(discountName) {
  return confirm(`Apakah Anda yakin ingin menghapus diskon "${discountName}"?\n\nTindakan ini tidak dapat dibatalkan.`);
}

// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
});
</script>

<style>
.table th {
  font-weight: 600;
  font-size: 0.9rem;
}

.table td {
  vertical-align: middle;
}

.btn-group .btn {
  border-radius: 0.25rem;
  margin-right: 2px;
}

.card {
  border: none;
  border-radius: 0.5rem;
}

.badge {
  font-size: 0.75rem;
}

.table-responsive {
  border-radius: 0.5rem;
}

.alert {
  border-radius: 0.5rem;
  border: none;
}

.opacity-50 {
  opacity: 0.5;
}
</style>
@else
  @include('adminpage.access_denied')
@endif
@endsection