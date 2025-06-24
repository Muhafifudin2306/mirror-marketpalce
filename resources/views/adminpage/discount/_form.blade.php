@php
  $d = $discount ?? null;
@endphp
<div class="form-floating mb-3">
  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $d->name ?? '') }}" placeholder="Nama Diskon">
  <label for="name">Nama Diskon</label>
  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-floating mb-3">
  <input type="number" name="discount_percent" id="discount_percent" class="form-control @error('discount_percent') is-invalid @enderror" value="{{ old('discount_percent', $d->discount_percent ?? '') }}" min="0" max="100" step="0.01" placeholder="Diskon (%)">
  <label for="discount_percent">Diskon (%)</label>
  @error('discount_percent')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-floating mb-3">
  <input type="number" name="discount_fix" id="discount_fix" class="form-control @error('discount_fix') is-invalid @enderror" value="{{ old('discount_fix', $d->discount_fix ?? '') }}" min="0" step="0.01" placeholder="Diskon Tetap (Rp)">
  <label for="discount_fix">Diskon Tetap (Rp)</label>
  @error('discount_fix')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row g-2 mb-3">
  <div class="col">
    <label class="form-label">Mulai</label>
    <input type="date" name="start_discount" class="form-control @error('start_discount') is-invalid @enderror" value="{{ old('start_discount', optional(optional($d)->start_discount)->format('Y-m-d') ?? '') }}">
    @error('start_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col">
    <label class="form-label">Selesai</label>
    <input type="date" name="end_discount" class="form-control @error('end_discount') is-invalid @enderror" value="{{ old('end_discount', optional(optional($d)->end_discount)->format('Y-m-d') ?? '') }}">
    @error('end_discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
<div class="form-floating mb-3">
  <select id="labelSelect" name="label_id" class="form-select @error('label_id') is-invalid @enderror">
    <option value="">— Pilih Label —</option>
    @foreach($labels as $lbl)
      <option value="{{ $lbl->id }}" {{ old('label_id', $d->label_id ?? '') == $lbl->id ? 'selected' : '' }}>{{ $lbl->name }}</option>
    @endforeach
  </select>
  <label for="labelSelect">Label</label>
  @error('label_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-floating mb-3">
  <select id="productSelect" name="product_id" class="form-select @error('product_id') is-invalid @enderror" {{ $d ? '' : 'disabled' }}>
    <option value="">— Pilih Produk —</option>
    @foreach($products as $prd)
      <option value="{{ $prd->id }}" {{ old('product_id', $d->product_id ?? '') == $prd->id ? 'selected' : '' }}>{{ $prd->name }}</option>
    @endforeach
  </select>
  <label for="productSelect">Produk</label>
  @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<button class="btn btn-primary" type="submit">{{ $d ? 'Update' : 'Simpan' }}</button>
<a href="{{ route('admin.discount.index') }}" class="btn btn-danger ms-2">Batal</a>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const labelSel = document.getElementById('labelSelect');
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
        .then(r => r.json()).then(list => {
          productSel.disabled = false;
          productSel.innerHTML = '<option value="">— Pilih Produk —</option>';
          list.forEach(prd => {
            const opt = document.createElement('option');
            opt.value = prd.id;
            opt.text = prd.name;
            productSel.append(opt);
          });
        }).catch(() => productSel.innerHTML = '<option>Error loading</option>');
    });
  });
</script>
