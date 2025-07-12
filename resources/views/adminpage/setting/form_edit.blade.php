@extends('adminpage.index')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">
    @if (Auth::user()->role != 'Customer')
        <main>
            <div class="container-fluid px-4">
                <h2 class="my-4">Edit Setting</h2>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.setting.update', $setting->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3 form-floating">
                        <input type="text"
                               name="type"
                               id="type"
                               value="{{ old('type', $setting->type) }}"
                               class="form-control @error('type') is-invalid @enderror">
                        <label for="type">Tipe</label>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konten --}}
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten</label>
                        <textarea id="summernote"
                                  name="content"
                                  class="form-control @error('content') is-invalid @enderror"
                                  style="height: 500px">{{ old('content', $setting->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="mb-5">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </main>

        {{-- Summernote JS --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
        <script>
            $('#summernote').summernote({
                height: 500,
                focus: false
            });
        </script>
    @else
        @include('adminpage.access_denied')
    @endif
@endsection
