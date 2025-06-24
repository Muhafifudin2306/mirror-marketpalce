@extends('adminpage.index')
@section('content')

@if (Auth::user()->role != 'Customer')
<main>
    <div class="container-fluid px-4">
        <div class="container px-5 my-5">
            <h2>Form Tambah Newsletter</h2>
            <form method="POST" action="{{ route('admin.newsletter.store') }}" id="contactForm">
                @csrf

                {{-- Email --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" type="email" placeholder="Email" />
                    <label for="email">Email</label>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Tombol --}}
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ url('/admin/newsletter') }}" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</main>
@else
    @include('adminpage.access_denied')
@endif
@endsection
