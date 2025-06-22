@extends('layouts.app')

@section('title_page', 'Manage Roles')

@section('content')
    <div class="container-fluid container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Manage Roles</h3>
            @can('role-manipulation')    
            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Role
            </a>
            @endcan
        </div>

        <div class="card">
            <h5 class="card-header">Tabel Roles</h5>
            <div class="table-responsive text-nowrap">
                <table id="datatables" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            @can('role-manipulation')  
                            <th>Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $i => $role)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="permissions-cell">
                                    <div class="d-flex flex-wrap">
                                        @forelse($role->permissions as $perm)
                                            <span class="badge bg-label-secondary me-1 mb-1">{{ $perm->name }}</span>
                                        @empty
                                            <span>-</span>
                                        @endforelse
                                    </div>
                                </td>
                                @can('role-manipulation')  
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">
                                                    <i class="bx bx-pencil me-1"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item btn btn-delete"
                                                    data-url="{{ route('roles.destroy', $role->id) }}">
                                                    <i class="bx bx-trash me-1"></i> Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data roles.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    @can('role-manipulation') 
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    Notiflix.Confirm.show(
                        'Hapus Data',
                        'Yakin ingin menghapus data ini? Tindakan ini tidak bisa dibatalkan.',
                        'Ya, Hapus!',
                        'Batal',
                        function onOk() {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = url;

                            const token = document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content');
                            form.innerHTML = `
                        <input type="hidden" name="_token" value="${token}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                            document.body.appendChild(form);
                            form.submit();
                        },
                        function onCancel() {}, {
                            width: '320px',
                            borderRadius: '8px',
                            titleColor: '#e74c3c',
                            okButtonBackground: '#e74c3c',
                            cancelButtonBackground: '#95a5a6',
                        }
                    );
                });
            });
        });
    </script>
    @endcan
@endsection
