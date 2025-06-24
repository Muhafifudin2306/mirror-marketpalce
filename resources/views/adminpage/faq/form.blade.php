@extends('adminpage.index')
@section('content')
@if(Auth::user()->role!='Customer')
<main>
  <div class="container-fluid px-4">
    <h2 class="mt-4">Tambah FAQ</h2>
    <form action="{{ route('admin.faq.store') }}" method="POST">
      @csrf
      <div class="mb-3 form-floating">
        <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question') }}" placeholder="Pertanyaan">
        <label for="question">Pertanyaan</label>
        @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3 form-floating">
        <textarea name="answer" id="answer" class="form-control @error('answer') is-invalid @enderror" placeholder="Jawaban" style="height:120px;">{{ old('answer') }}</textarea>
        <label for="answer">Jawaban</label>
        @error('answer')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3 form-floating">
        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror">
          <option value="">-- Pilih Tipe --</option>
          @foreach(['Pembelian','Akun','Desain','Keamanan','Kontak'] as $t)
            <option value="{{ $t }}" {{ old('type')==$t?'selected':'' }}>{{ $t }}</option>
          @endforeach
        </select>
        <label for="type">Tipe</label>
        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active')?'checked':'' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
      </div>
      <button class="btn btn-primary" type="submit">Simpan</button>
      <a href="{{ route('admin.faq.index') }}" class="btn btn-danger">Batal</a>
    </form>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif
@endsection