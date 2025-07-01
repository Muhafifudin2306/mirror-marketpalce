@extends('adminpage.index')
@section('content')
@if(Auth::user()->role!='Customer')
<main>
  <div class="container-fluid px-4">
    <h2 class="mt-4">Edit Pesanan</h2>
    <form action="{{ route('admin.orders.update',$order->id) }}" method="POST">
      @csrf @method('PUT')
      <div class="form-floating mb-3">
        <input type="text" name="spk" class="form-control @error('spk') is-invalid @enderror" value="{{ old('spk',$order->spk) }}" placeholder="SPK" />
        <label>SPK</label>
        @error('spk')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-floating mb-3">
        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
          <option value="">-- Pilih Pelanggan --</option>
          @foreach($users as $id=>$name)
          <option value="{{ $id }}" {{ old('user_id',$order->user_id)==$id?'selected':'' }}>{{ $name }}</option>
          @endforeach
        </select>
        <label>Pelanggan</label>
        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      {{-- Tambahkan field lain mengikuti schema --}}
      <button class="btn btn-primary" type="submit">Update</button>
      <a href="{{ route('admin.orders.index') }}" class="btn btn-danger">Batal</a>
    </form>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif
@endsection