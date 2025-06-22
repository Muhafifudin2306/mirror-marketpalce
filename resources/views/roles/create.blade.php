@extends('layouts.app')

@section('title_page', 'Tambah Role')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Tambah Role</h3>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Form Tambah Role</h5>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    {{-- Nama Role --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan Nama Role"
                            value="{{ old('name') }}" required>
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
                                            {{ in_array($permission->id, old('permissions', isset($role) ? $role->permissions->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
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
@endsection
