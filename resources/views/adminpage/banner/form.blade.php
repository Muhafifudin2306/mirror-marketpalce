<!-- resources/views/adminpage/testimonial/create.blade.php -->
@extends('adminpage.index')
@section('content')

@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <div class="container px-5 my-5">
      <h2>Tambah Banner</h2>
      <form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-floating mb-3">
          <input
            type="text"
            name="heading"
            id="heading"
            class="form-control @error('heading') is-invalid @enderror"
            value="{{ old('heading') }}"
            placeholder="Heading"
            required
          />
          <label for="heading">Heading <span class="text-danger">*</span></label>
          <small class="form-text text-muted">Gunakan <code>;</code> untuk enter, dan <code>*teks*</code> untuk warna kuning.</small>
          @error('heading')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-floating mb-3">
          <input
            type="text"
            name="content"
            id="content"
            class="form-control @error('content') is-invalid @enderror"
            value="{{ old('content') }}"
            placeholder="Konten"
          />
          <label for="content">Konten</label>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="photo" class="form-label">Banner</label>
          <input
            class="form-control @error('photo') is-invalid @enderror"
            type="file"
            id="photo"
            name="photo"
            accept="image/*"
          />
          @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.banner.index') }}" class="btn btn-danger">Batal</a>
      </form>
    </div>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif

@endsection
