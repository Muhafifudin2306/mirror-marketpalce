@extends('adminpage.index')
@section('content')

@if (Auth::user()->role != 'Customer')
<main>
    <div class="container-fluid px-4">
        <div class="container px-5 my-5">
            <h2>Form Tambah Customer</h2>
            <form method="POST" action="{{ route('admin.customer.store') }}" id="contactForm">
                @csrf

                {{-- Nama --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" type="text" placeholder="Nama User" />
                    <label for="name">Nama Customer</label>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" type="email" placeholder="Email" />
                    <label for="email">Email</label>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Password --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="Password" />
                    <label for="password">Password</label>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Role --}}
                <div class="form-floating mb-3">
                    <select class="form-select @error('role') is-invalid @enderror" name="role">
                        <option value="">-- Pilih Role --</option>
                        @foreach ($enumOptions as $option)
                            <option value="{{ $option }}" {{ old('role') == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <label for="role">Role</label>
                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- No HP --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" id="phone" type="text" placeholder="No HP" />
                    <label for="phone">No. HP</label>
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Provinsi --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}" id="province" type="text" placeholder="Provinsi" />
                    <label for="province">Provinsi</label>
                    @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Kota --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" id="city" type="text" placeholder="Kota" />
                    <label for="city">Kota</label>
                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Alamat --}}
                <div class="form-floating mb-3">
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" style="height: 100px" placeholder="Alamat">{{ old('address') }}</textarea>
                    <label for="address">Alamat</label>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Kode Pos --}}
                <div class="form-floating mb-3">
                    <input class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ old('postal_code') }}" id="postal_code" type="number" placeholder="Kode Pos" />
                    <label for="postal_code">Kode Pos</label>
                    @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Tombol --}}
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ url('/admin/customer') }}" class="btn btn-danger">Batal</a>
            </form>
        </div>
    </div>
</main>
@else
    @include('adminpage.access_denied')
@endif
@endsection
