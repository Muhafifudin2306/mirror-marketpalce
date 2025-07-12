@extends('adminpage.index')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">
    @if (Auth::user()->role != 'Customer')
        <main>
            <div class="container-fluid px-4">
                <h2 class="my-4">Tambah Setting</h2>
                <form method="POST" enctype="multipart/form-data" action="{{ route('admin.setting.store') }}">
                    @csrf
                    <div class="mb-3 form-floating">
                        <input type="text" name="type" id="type"
                            class="form-control @error('type') is-invalid @enderror">
                        <label for="type">Tipe</label>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-floating">
                        <label for="content">Konten</label>
                        <textarea id="summernote" name="content" class="form-control">{{ old('content', $blog->content ?? '') }}</textarea>
                    </div>
                    <div class="mb-5">
                        <button class="btn btn-primary" type="submit">Simpan</button>
                        <a href="{{ route('admin.blog.index') }}" class="btn btn-danger">Batal</a>
                    </div>
                </form>
            </div>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
        <script>
            $('#summernote').summernote({
                height: 500,
            });
        </script>
    @else
        @include('adminpage.access_denied')
    @endif
@endsection
