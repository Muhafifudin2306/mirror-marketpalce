<!-- resources/views/adminpage/testimonial/edit.blade.php -->
@extends('adminpage.index')
@section('content')

@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <div class="container px-5 my-5">
      <h2>Form Edit Banner</h2>
      <form 
        method="POST" 
        action="{{ route('admin.banner.update', $banner->id) }}" 
        enctype="multipart/form-data"
      >
        @csrf
        @method('PUT')

        <div class="form-floating mb-3">
          <input
            type="text"
            name="heading"
            id="heading"
            class="form-control @error('heading') is-invalid @enderror"
            value="{{ old('heading', $banner->heading) }}"
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
            value="{{ old('content', $banner->content) }}"
            placeholder="Konten"
          />
          <label for="content">Konten</label>
          @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        @if($banner->photo)
          <div class="mb-3">
            <label class="form-label">Banner Saat Ini</label><br>
            <img 
              src="{{ asset('storage/' . $banner->photo) }}" 
              alt="Banner {{ $banner->heading }}" 
              class="img-fluid mb-2" 
              style="max-height:200px;"
            >
          </div>
        @endif

        <div class="mb-3">
          <label for="photo" class="form-label">
            Ganti Banner (ideal: 1920×771 px)
          </label>
          <input
            class="form-control @error('photo') is-invalid @enderror"
            type="file"
            id="photo"
            name="photo"
            accept="image/*"
          />
          <div class="form-text text-muted">
            * Biarkan kosong jika tidak ingin mengganti banner.
          </div>
          @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button class="btn btn-primary" type="submit">
          Simpan Perubahan
        </button>
        <a href="{{ route('admin.banner.index') }}" class="btn btn-danger">
          Batal
        </a>
      </form>
    </div>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif

@endsection
