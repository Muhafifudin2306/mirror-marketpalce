@extends('adminpage.index')
@section('content')
@if(Auth::user()->role!='Customer')
<main>
  <div class="container-fluid px-4">
    <h2 class="mt-4">Tambah Pesanan</h2>
    <form action="{{ route('admin.orders.store') }}" method="POST">
      @csrf
      <div class="form-floating mb-3">
        <input type="text" name="spk" class="form-control @error('spk') is-invalid @enderror" value="{{ old('spk') }}" placeholder="SPK" />
        <label>SPK</label>
        @error('spk')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-floating mb-3">
        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
          <option value="">-- Pilih Pelanggan --</option>
          @foreach($users as $id=>$name)
          <option value="{{ $id }}" {{ old('user_id')==$id?'selected':'' }}>{{ $name }}</option>
          @endforeach
        </select>
        <label>Pelanggan</label>
        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      {{-- Tambahkan field lain mengikuti schema (transaction_type, method, status, subtotal, dsb.) --}}
      <button class="btn btn-primary" type="submit">Simpan</button>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">Batal</a>
    </form>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif
@endsection