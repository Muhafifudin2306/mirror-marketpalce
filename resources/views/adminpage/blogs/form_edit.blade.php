@extends('adminpage.index')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">
    @if (Auth::user()->role != 'Customer')
        <main>
            <div class="container-fluid px-4">
                <h2 class="my-4">Edit Artikel</h2>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.blog.update', $blog->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3 form-floating">
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $blog->title) }}"
                               class="form-control @error('title') is-invalid @enderror">
                        <label for="title">Judul</label>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Banner --}}
                    <div class="mb-3">
                        <label for="banner" class="form-label">Sampul Baru</label>
                        <input type="file"
                               name="banner"
                               id="banner"
                               class="form-control @error('banner') is-invalid @enderror">
                        @error('banner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($blog->banner)
                            <small class="text-muted">
                                <a href="{{ asset('storage/' . $blog->banner) }}" target="_blank">
                                    Lihat sampul sebelumnya
                                </a>
                            </small>
                        @endif
                    </div>

                    {{-- Tipe Artikel --}}
                    <div class="mb-3 form-floating">
                        <select name="blog_type"
                                id="blog_type"
                                class="form-select @error('blog_type') is-invalid @enderror">
                            <option value="" disabled>-- Pilih Tipe Artikel --</option>
                            @foreach(['Promo Sinau','Printips','Company','Printutor'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('blog_type', $blog->blog_type) === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <label for="blog_type">Tipe Artikel</label>
                        @error('blog_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tampilkan (Live)? --}}
                    <div class="mb-3 form-check">
                        <input type="hidden" name="is_live" value="0">
                        <input type="checkbox"
                               name="is_live"
                               id="is_live"
                               value="1"
                               class="form-check-input @error('is_live') is-invalid @enderror"
                               {{ old('is_live', $blog->is_live) ? 'checked' : '' }}>
                        <label for="is_live" class="form-check-label">Tampilkan (Live)?</label>
                        @error('is_live')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konten --}}
                    <div class="mb-3">
                        <label for="content" class="form-label">Konten Artikel</label>
                        <textarea id="summernote"
                                  name="content"
                                  class="form-control @error('content') is-invalid @enderror"
                                  style="height: 500px">{{ old('content', $blog->content) }}</textarea>
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
