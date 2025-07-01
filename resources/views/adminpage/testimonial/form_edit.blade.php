<!-- resources/views/adminpage/testimonial/form_edit.blade.php -->
@extends('adminpage.index')
@section('content')

@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <div class="container px-5 my-5">
      <h2>Edit Testimonial</h2>
      <form method="POST"
            action="{{ route('admin.testimonial.update', $testimonial->id) }}"
            enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-floating mb-3">
          <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $testimonial->name) }}"
            placeholder="Nama"
            required
          />
          <label for="name">Nama <span class="text-danger">*</span></label>
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-floating mb-3">
          <input
            type="text"
            name="location"
            id="location"
            class="form-control @error('location') is-invalid @enderror"
            value="{{ old('location', $testimonial->location) }}"
            placeholder="Lokasi"
            required
          />
          <label for="location">Lokasi <span class="text-danger">*</span></label>
          @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-floating mb-3">
          <textarea
            name="feedback"
            id="feedback"
            class="form-control @error('feedback') is-invalid @enderror"
            placeholder="Masukan / Saran"
            style="height: 150px;"
            required
          >{{ old('feedback', $testimonial->feedback) }}</textarea>
          <label for="feedback">Masukan / Saran <span class="text-danger">*</span></label>
          @error('feedback')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="photo" class="form-label">Foto (opsional)</label>
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
          @if($testimonial->photo)
            <div class="mt-2">
              <img src="{{ asset('storage/' . $testimonial->photo) }}"
                   alt="Preview Foto"
                   style="max-height: 150px;">
            </div>
          @endif
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.testimonial.index') }}" class="btn btn-danger">Batal</a>
      </form>
    </div>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif

@endsection
