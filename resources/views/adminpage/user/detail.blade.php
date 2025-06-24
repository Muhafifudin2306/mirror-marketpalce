@extends('adminpage.index')
@section('content')

@if (Auth::user()->role != 'Customer')
<main class="py-5">
  <div class="container">
    <h2 class="mb-4">Detail User</h2>

    <div class="card shadow-sm">
      <div class="card-body">
        <div class="row gx-5">
          {{-- Left: Icon/avatar --}}
          <div class="col-md-3 d-flex align-items-center justify-content-center">
            <div class="avatar-placeholder">
              <i class="fa fa-user fa-5x text-secondary"></i>
            </div>
          </div>

          {{-- Right: Detail info --}}
          <div class="col-md-9">
            <h4 class="mb-3">{{ $rs->name }}</h4>

            <dl class="row mb-0">
              <dt class="col-sm-4">Role</dt>
              <dd class="col-sm-8">{{ $rs->role }}</dd>

              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8">{{ $rs->email }}</dd>

              <dt class="col-sm-4">No. HP</dt>
              <dd class="col-sm-8">{{ $rs->phone }}</dd>

              <dt class="col-sm-4">Provinsi</dt>
              <dd class="col-sm-8">{{ $rs->province ?? '-' }}</dd>

              <dt class="col-sm-4">Kota</dt>
              <dd class="col-sm-8">{{ $rs->city ?? '-' }}</dd>

              <dt class="col-sm-4">Alamat</dt>
              <dd class="col-sm-8">{{ $rs->address ?? '-' }}</dd>

              <dt class="col-sm-4">Kode Pos</dt>
              <dd class="col-sm-8">{{ $rs->postal_code ?? '-' }}</dd>

              <dt class="col-sm-4">Dibuat</dt>
              <dd class="col-sm-8">{{ $rs->created_at->translatedFormat('d F Y, H:i') }}</dd>

              <dt class="col-sm-4">Terakhir Update</dt>
              <dd class="col-sm-8">{{ $rs->updated_at->translatedFormat('d F Y, H:i') }}</dd>
            </dl>

            <div class="mt-4">
              <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary me-2">Kembali</a>
              <a href="{{ route('admin.user.edit', $rs->id) }}" class="btn btn-primary">Edit User</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

{{-- Tambahkan CSS spesifik --}}
@push('styles')
<style>
  .avatar-placeholder {
    width: 150px;
    height: 150px;
    background: #f1f3f5;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  dt {
    font-weight: 500;
    color: #495057;
  }
  dd {
    margin-bottom: 1rem;
    color: #212529;
  }
</style>
@endpush

@else
  @include('adminpage.access_denied')
@endif
@endsection
