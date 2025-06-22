@extends('layouts.app')

@section('title_page', 'Tambah Pengguna')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('modules/select2/dist/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid container-p-y">
        {{-- Header halaman dengan tombol Kembali --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Tambah Pengguna</h1>
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        {{-- Card form --}}
        <div class="card">
            <h5 class="card-header">Form Tambah Pengguna</h5>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Nama User"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input
                            type="email"
                            id="email"
                            placeholder="Email User"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="********"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input
                                type="password"
                                id="password_confirmation"
                                placeholder="********"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >
                        </div>
                    </div>

                    {{-- Roles --}}
                    <div class="mb-3">
                        <label for="roles" class="form-label">Role</label>
                        <select
                            id="roles"
                            name="roles"
                            class="form-control select2 @error('roles') is-invalid @enderror"
                            required
                        >
                            <option value="" disabled selected>-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('roles') === $role ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bx bx-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bx bx-x me-1"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('modules/select2/dist/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('#roles').select2({
                    placeholder: "-- Pilih Role --",
                    width: '100%'
                });
            });
        </script>
    @endpush
@endsection
