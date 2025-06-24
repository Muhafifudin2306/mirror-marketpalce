@extends('adminpage.index')
@section('content')

@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <div class="container px-5 my-5">
      <h2>Form Tambah Kode Promo</h2>
      <form method="POST" action="{{ route('admin.promocode.store') }}">
        @csrf

        {{-- Code --}}
        <div class="form-floating mb-3">
          <input
            type="text"
            name="code"
            id="code"
            class="form-control @error('code') is-invalid @enderror"
            value="{{ old('code') }}"
            placeholder="Kode Promo"
          />
          <label for="code">Kode Promo</label>
          @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Discount Percent --}}
        <div class="form-floating mb-3">
          <input
            type="number"
            name="discount_percent"
            id="discount_percent"
            class="form-control @error('discount_percent') is-invalid @enderror"
            value="{{ old('discount_percent') }}"
            placeholder="Persentase Diskon (0–100)"
            min="0" max="100"
          />
          <label for="discount_percent">Persentase Diskon (%)</label>
          @error('discount_percent')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Discount RP --}}
        <div class="form-floating mb-3">
          <input
            type="number"
            name="discount_fix"
            id="discount_fix"
            class="form-control @error('discount_fix') is-invalid @enderror"
            value="{{ old('discount_fix') }}"
            placeholder="Diskon Rp"
            min="1"
          />
          <label for="discount_fix">Diskon Rp</label>
          @error('discount_fix')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Max Discount --}}
        <div class="form-floating mb-3">
          <input
            type="number"
            name="max_discount"
            id="max_discount"
            class="form-control @error('max_discount') is-invalid @enderror"
            value="{{ old('max_discount') }}"
            placeholder="Maksimum Diskon (Rp)"
            min="0"
          />
          <label for="max_discount">Maksimum Diskon (Rp)</label>
          @error('max_discount')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Start At --}}
        <div class="form-floating mb-3">
          <input
            type="date"
            name="start_at"
            id="start_at"
            class="form-control @error('start_at') is-invalid @enderror"
            value="{{ old('start_at') }}"
            placeholder="Tanggal Mulai"
          />
          <label for="start_at">Tanggal Mulai</label>
          @error('start_at')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- End At --}}
        <div class="form-floating mb-3">
          <input
            type="date"
            name="end_at"
            id="end_at"
            class="form-control @error('end_at') is-invalid @enderror"
            value="{{ old('end_at') }}"
            placeholder="Tanggal Selesai"
          />
          <label for="end_at">Tanggal Selesai</label>
          @error('end_at')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Usage Limit --}}
        <div class="form-floating mb-3">
          <input
            type="number"
            name="usage_limit"
            id="usage_limit"
            class="form-control @error('usage_limit') is-invalid @enderror"
            value="{{ old('usage_limit') }}"
            placeholder="Batas Penggunaan"
            min="1"
          />
          <label for="usage_limit">Batas Penggunaan</label>
          @error('usage_limit')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Tombol --}}
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.promocode.index') }}" class="btn btn-danger">Batal</a>
      </form>
    </div>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif

@endsection
