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

    <div class="card mb-4">
      <div class="card-body">
        <form method="POST" action="{{ route('admin.discount.store') }}">
          @csrf

          {{-- Nama Diskon --}}
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

          {{-- Diskon Persen --}}
          <div class="form-floating mb-3">
            <input
              type="number"
              name="discount_percent"
              id="discount_percent"
              class="form-control @error('discount_percent') is-invalid @enderror"
              value="{{ old('discount_percent') }}"
              min="0" max="100" step="0.01"
              placeholder="Diskon (%)"
            />
            <label for="discount_percent">Diskon (%)</label>
            @error('discount_percent')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Diskon Tetap --}}
          <div class="form-floating mb-3">
            <input
              type="number"
              name="discount_fix"
              id="discount_fix"
              class="form-control @error('discount_fix') is-invalid @enderror"
              value="{{ old('discount_fix') }}"
              min="0" step="0.01"
              placeholder="Diskon Tetap (Rp)"
            />
            <label for="discount_fix">Diskon Tetap (Rp)</label>
            @error('discount_fix')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Durasi --}}
          <div class="row g-2 mb-3">
            <div class="col">
              <label class="form-label">Mulai</label>
              <input
                type="date"
                name="start_discount"
                class="form-control @error('start_discount') is-invalid @enderror"
                value="{{ old('start_discount') }}"
              />
              @error('start_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col">
              <label class="form-label">Selesai</label>
              <input
                type="date"
                name="end_discount"
                class="form-control @error('end_discount') is-invalid @enderror"
                value="{{ old('end_discount') }}"
              />
              @error('end_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          {{-- Label --}}
          <div class="form-floating mb-3">
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
            <label for="labelSelect">Label</label>
            @error('label_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Produk --}}
          <div class="form-floating mb-3">
            <select
              id="productSelect"
              name="product_id"
              class="form-select @error('product_id') is-invalid @enderror"
              disabled
            >
              <option value="">— Pilih Label dahulu —</option>
            </select>
            <label for="productSelect">Produk</label>
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

  labelSel.addEventListener('change', () => {
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
});
</script>
@else
  @include('adminpage.access_denied')
@endif
@endsection
