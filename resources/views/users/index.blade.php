@extends('layouts.app')

@section('title_page', 'Data Pengguna')

@section('style')
    <link rel="stylesheet" href="{{ asset('modules/datatables/datatables.min.css') }}">
@endsection

@section('content')

    <div class="container-fluid container-p-y">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="m-0">Data Pengguna</h3>
            @can('user-manipulation')
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah Pengguna
                </a>
            @endcan
        </div>

        <div class="card p-3">
            <h5 class="card-header">Tabel Pengguna</h5>
            <div class="mt-5">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Roles</th>
                            @can('user-manipulation')
                                <th>Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $user)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse($user->getRoleNames() as $role)
                                        <span class="badge bg-label-secondary me-1">{{ $role }}</span>
                                    @empty
                                        <span>-</span>
                                    @endforelse
                                </td>
                                @can('user-manipulation')
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" data-bs-boundary="viewport" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                </li>
                                                @if (Auth::user()->id != $user->id)
                                                    <li>
                                                        <button type="button" class="dropdown-item btn btn-delete"
                                                            data-url="{{ route('users.destroy', $user->id) }}">
                                                            <i class="bx bx-trash me-1"></i> Hapus
                                                        </button>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @can('user-manipulation')
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
    @section('script')
        <script src="{{ asset('modules/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/modules-datatables.js') }}"></script>
        <!-- Inisialisasi DataTables -->
        <script>
            $(function() {
                $('#datatable').DataTable();
            });
        </script>
    @endsection
@endsection
