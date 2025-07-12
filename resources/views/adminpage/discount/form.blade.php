@extends('adminpage.index')
@section('content')
@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Diskon Produk</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Tambah Diskon Produk</li>
    </ol>

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="card mb-4">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.discount.store') }}">
          @csrf

          <div class="form-floating mb-3">
            <input
              type="text"
              name="name"
              id="name"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name') }}"
              placeholder="Nama Diskon"
            />
            <label for="name">Nama Diskon</label>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

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

          <div class="form-floating mb-3" id="percent_group" style="display: {{ $type=='percent' ? 'block' : 'none' }};">
            <input
              type="number"
              name="discount_percent"
              id="discount_percent"
              class="form-control @error('discount_percent') is-invalid @enderror"
              value="{{ old('discount_percent') }}"
              min="0" max="100" step="0.01"
              placeholder="Persentase Diskon (0–100)"
              {{ $type=='percent' ? 'required' : '' }}
            />
            <label for="discount_percent">Persentase Diskon (%) <span class="text-danger">*</span></label>
            @error('discount_percent')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-floating mb-3" id="fix_group" style="display: {{ $type=='fix' ? 'block' : 'none' }};">
            <input
              type="number"
              name="discount_fix"
              id="discount_fix"
              class="form-control @error('discount_fix') is-invalid @enderror"
              value="{{ old('discount_fix') }}"
              min="1" step="0.01"
              placeholder="Diskon Rp"
              {{ $type=='fix' ? 'required' : '' }}
            />
            <label for="discount_fix">Diskon Rp <span class="text-danger">*</span></label>
            @error('discount_fix')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="row g-2 mb-3">
            <div class="col">
              <label class="form-label">Mulai <span class="text-danger">*</span></label>
              <input
                type="date"
                name="start_discount"
                id="start_discount"
                class="form-control @error('start_discount') is-invalid @enderror"
                value="{{ old('start_discount') }}"
                required
              />
              @error('start_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col">
              <label class="form-label">Selesai <span class="text-danger">*</span></label>
              <input
                type="date"
                name="end_discount"
                id="end_discount"
                class="form-control @error('end_discount') is-invalid @enderror"
                value="{{ old('end_discount') }}"
                required
              />
              @error('end_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="form-check mb-3">
            <input
              class="form-check-input"
              type="checkbox"
              id="apply_to_all"
              name="apply_to_all"
              value="1"
              {{ old('apply_to_all') ? 'checked' : '' }}
            />
            <label class="form-check-label" for="apply_to_all">
              <strong>Terapkan ke Semua Produk</strong>
            </label>
            <div id="allProductsWarning" class="alert alert-warning mt-2" style="display: none;">
              <i class="fas fa-exclamation-triangle me-2"></i>
              <strong>Perhatian:</strong> Hanya boleh ada satu diskon "Semua Produk" yang aktif dalam periode yang sama.
            </div>
          </div>

          <div class="form-floating mb-3" id="labelGroup">
            <select
              id="labelSelect"
              name="label_id"
              class="form-select @error('label_id') is-invalid @enderror"
            >
              <option value="">— Pilih Label —</option>
              @foreach($labels as $lbl)
                <option
                  value="{{ $lbl->id }}"
                  {{ old('label_id') == $lbl->id ? 'selected' : '' }}
                >
                  {{ $lbl->name }}
                </option>
              @endforeach
            </select>
            <label for="labelSelect">Label <span class="text-danger required-star">*</span></label>
            @error('label_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-floating mb-3" id="productGroup">
            <select
              id="productSelect"
              name="product_id"
              class="form-select @error('product_id') is-invalid @enderror"
              disabled
            >
              <option value="">— Pilih Label dahulu —</option>
            </select>
            <label for="productSelect">Produk <span class="text-danger required-star">*</span></label>
            @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <button class="btn btn-primary" type="submit">Simpan</button>
          <a href="{{ route('admin.discount.index') }}" class="btn btn-danger ms-2">Batal</a>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const labelSel   = document.getElementById('labelSelect');
  const productSel = document.getElementById('productSelect');
  const applyToAll = document.getElementById('apply_to_all');
  const labelGroup = document.getElementById('labelGroup');
  const productGroup = document.getElementById('productGroup');
  const requiredStars = document.querySelectorAll('.required-star');
  const allProductsWarning = document.getElementById('allProductsWarning');

  const percentRadio    = document.getElementById('type_percent');
  const fixRadio        = document.getElementById('type_fix');
  const percentGroup    = document.getElementById('percent_group');
  const fixGroup        = document.getElementById('fix_group');
  const percentInput    = document.getElementById('discount_percent');
  const fixInput        = document.getElementById('discount_fix');
  const percentLabel    = percentGroup.querySelector('label[for="discount_percent"]');
  const fixLabel        = fixGroup.querySelector('label[for="discount_fix"]');

  function toggleDiscountFields() {
    if (percentRadio.checked) {
      percentGroup.style.display = 'block';
      fixGroup.style.display     = 'none';

      percentInput.required      = true;
      fixInput.required          = false;
      percentInput.placeholder   = 'Persentase Diskon (0–100)';
      percentLabel.innerText     = 'Persentase Diskon (%) *';
    } else {
      percentGroup.style.display = 'none';
      fixGroup.style.display     = 'block';

      percentInput.required      = false;
      fixInput.required          = true;
      fixInput.placeholder       = 'Nominal Diskon (Rp)';
      fixLabel.innerText         = 'Nominal Diskon (Rp) *';
    }
  }

  function toggleFields() {
    if (applyToAll.checked) {
      allProductsWarning.style.display = 'block';
      
      labelSel.disabled = true;
      productSel.disabled = true;
      labelSel.required = false;
      productSel.required = false;
      
      requiredStars.forEach(star => star.style.display = 'none');
      
      labelSel.value = '';
      productSel.innerHTML = '<option value="">— Pilih Label dahulu —</option>';
      
      labelGroup.style.opacity = '0.6';
      productGroup.style.opacity = '0.6';
    } else {
      allProductsWarning.style.display = 'none';
      
      labelSel.disabled = false;
      labelSel.required = true;
      productSel.required = true;
      
      requiredStars.forEach(star => star.style.display = 'inline');
      
      labelGroup.style.opacity = '1';
      productGroup.style.opacity = '1';
    }
  }

  labelSel.addEventListener('change', () => {
    if (applyToAll.checked) return;
    
    const id = labelSel.value;
    productSel.innerHTML = '<option>Loading…</option>';
    productSel.disabled = true;

    if (!id) {
      productSel.innerHTML = '<option>— Pilih Label dahulu —</option>';
      return;
    }

    fetch(`{{ url('admin/discount/products') }}/${id}`)
      .then(res => res.json())
      .then(list => {
        productSel.disabled = false;
        productSel.innerHTML = '<option value="">— Pilih Produk —</option>';
        list.forEach(prd => {
          const opt = document.createElement('option');
          opt.value = prd.id;
          opt.text  = prd.name;
          productSel.append(opt);
        });
      })
      .catch(() => {
        productSel.innerHTML = '<option>Error loading</option>';
      });
  });

  percentRadio.addEventListener('change', toggleDiscountFields);
  fixRadio.addEventListener('change', toggleDiscountFields);
  applyToAll.addEventListener('change', toggleFields);

  toggleDiscountFields();
  toggleFields();
  
  const alertElements = document.querySelectorAll('.alert-dismissible');
  alertElements.forEach(alert => {
    setTimeout(() => {
      const bsAlert = new bootstrap.Alert(alert);
      bsAlert.close();
    }, 10000);
  });
});
</script>

<style>
.alert-warning {
  font-size: 0.875rem;
  padding: 0.75rem;
  margin-bottom: 0;
}
</style>
@else
  @include('adminpage.access_denied')
@endif
@endsection