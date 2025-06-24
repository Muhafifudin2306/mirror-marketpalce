@extends('adminpage.index')
@section('content')

@if (Auth::user()->role != 'Pelanggan')
    <main>
        <div class="container-fluid px-4">
            <div class="container px-5 my-5">
                <h2>Form Update Newsletter</h2>
                <form method="POST" action="{{ route('admin.newsletter.update', $row->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $row->email }}" id="email" type="email" placeholder="Email" />
                        <label for="email">Email</label>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    <a href="{{ route('admin.newsletter.index') }}" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </main>
@else
    @include('adminpage.access_denied')
@endif

@endsection
