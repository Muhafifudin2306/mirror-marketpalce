@extends('layouts.app')

@section('title_page', 'Edit Role')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('modules/select2/dist/css/select2.min.css') }}">
    @endpush

    <div class="container-fluid flex-grow-1 container-p-y">
        {{-- Header halaman dengan tombol Kembali --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Edit Role</h1>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Form Edit Role</h5>
            <form method="POST" action="{{ route('roles.update', $role->id) }}">
                @csrf
                @method('PUT')
                <div class="card-body">
                    {{-- Nama Role --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name) }}"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Permissions --}}
                    <div class="mb-3">
                        <label for="permissions" class="form-label d-block">Permissions</label>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4 col-sm-6 col-12 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input @error('permissions') is-invalid @enderror"
                                            type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            id="permission_{{ $permission->id }}"
                                            {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bx bx-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
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
                $('#permissions').select2({
                    placeholder: "-- Pilih Permissions --",
                    width: '100%'
                });
            });
        </script>
    @endpush
@endsection
