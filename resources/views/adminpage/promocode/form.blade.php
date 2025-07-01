@extends('adminpage.index')
@section('content')

@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <div class="container px-5 my-5">
      <h2>Form Tambah Kode Promo</h2>
      <form method="POST" action="{{ route('admin.promocode.store') }}">
        @csrf

        {{-- Kode Promo --}}
        <div class="form-floating mb-3">
          <input
            type="text"
            name="code"
            id="code"
            class="form-control @error('code') is-invalid @enderror"
            value="{{ old('code') }}"
            placeholder="Kode Promo"
            required
          />
          <label for="code">Kode Promo <span class="text-danger">*</span></label>
          @error('code')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Jenis Diskon --}}
        <div class="mb-3">
          <label class="form-label">Jenis Diskon <span class="text-danger">*</span></label>
          <div>
            @php $type = old('discount_type', 'percent'); @endphp
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_type" id="type_percent" value="percent" {{ $type=='percent' ? 'checked' : '' }} required>
              <label class="form-check-label" for="type_percent">Persentase (%)</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="discount_type" id="type_fix" value="fix" {{ $type=='fix' ? 'checked' : '' }}>
              <label class="form-check-label" for="type_fix">Nominal Rp</label>
            </div>
          </div>
          @error('discount_type')
            <div class="text-danger small">{{ $message }}</div>
          @enderror
        </div>

        {{-- Diskon Persentase --}}
        <div class="form-floating mb-3" id="percent_group" style="display: {{ $type=='percent' ? 'block' : 'none' }};">
          <input
            type="number"
            name="discount_percent"
            id="discount_percent"
            class="form-control @error('discount_percent') is-invalid @enderror"
            value="{{ old('discount_percent') }}"
            placeholder="Persentase Diskon (0–100)"
            min="0" max="100"
            {{ $type=='percent' ? 'required' : '' }}
          />
          <label for="discount_percent">Persentase Diskon (%) <span class="text-danger">*</span></label>
          @error('discount_percent')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Diskon Nominal --}}
        <div class="form-floating mb-3" id="fix_group" style="display: {{ $type=='fix' ? 'block' : 'none' }};">
          <input
            type="number"
            name="discount_fix"
            id="discount_fix"
            class="form-control @error('discount_fix') is-invalid @enderror"
            value="{{ old('discount_fix') }}"
            placeholder="Diskon Rp"
            min="1"
            {{ $type=='fix' ? 'required' : '' }}
          />
          <label for="discount_fix">Diskon Rp <span class="text-danger">*</span></label>
          @error('discount_fix')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Tanggal Mulai --}}
        <div class="form-floating mb-3">
          <input
            type="date"
            name="start_at"
            id="start_at"
            class="form-control @error('start_at') is-invalid @enderror"
            value="{{ old('start_at') }}"
            placeholder="Tanggal Mulai"
            required
          />
          <label for="start_at">Tanggal Mulai <span class="text-danger">*</span></label>
          @error('start_at')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Tanggal Selesai --}}
        <div class="form-floating mb-3">
          <input
            type="date"
            name="end_at"
            id="end_at"
            class="form-control @error('end_at') is-invalid @enderror"
            value="{{ old('end_at') }}"
            placeholder="Tanggal Selesai"
            required
          />
          <label for="end_at">Tanggal Selesai <span class="text-danger">*</span></label>
          @error('end_at')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        {{-- Batas Penggunaan --}}
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
        <button class="btn btn-primary me-2" type="submit">Simpan</button>
        <a href="{{ route('admin.promocode.index') }}" class="btn btn-danger">Batal</a>
      </form>
    </div>
  </div>
</main>

@else
  @include('adminpage.access_denied')
@endif

@section('script')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const percentRadio    = document.getElementById('type_percent');
    const fixRadio        = document.getElementById('type_fix');
    const percentGroup    = document.getElementById('percent_group');
    const fixGroup        = document.getElementById('fix_group');
    const percentInput    = document.getElementById('discount_percent');
    const fixInput        = document.getElementById('discount_fix');
    const percentLabel    = percentGroup.querySelector('label[for="discount_percent"]');
    const fixLabel        = fixGroup.querySelector('label[for="discount_fix"]');

    function toggleFields() {
      if (percentRadio.checked) {
        // Tampilkan persentase, sembunyikan nominal
        percentGroup.style.display = 'block';
        fixGroup.style.display     = 'none';

        // Update placeholder & label sesuai persen
        percentInput.required      = true;
        fixInput.required          = false;
        percentInput.placeholder   = 'Persentase Diskon (0–100)';
        percentLabel.innerText     = 'Persentase Diskon (%) *';
      } else {
        // Tampilkan nominal, sembunyikan persentase
        percentGroup.style.display = 'none';
        fixGroup.style.display     = 'block';

        // Update placeholder & label sesuai nominal
        percentInput.required      = false;
        fixInput.required          = true;
        fixInput.placeholder       = 'Nominal Diskon (RP)';
        fixLabel.innerText         = 'Nominal Diskon (RP) *';
      }
    }

    percentRadio.addEventListener('change', toggleFields);
    fixRadio.addEventListener('change', toggleFields);

    // Jalankan sekali saat load untuk memastikan tampilan benar
    toggleFields();
  });
</script>
@endsection


@endsection
