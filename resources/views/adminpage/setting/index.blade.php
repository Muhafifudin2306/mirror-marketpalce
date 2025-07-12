@extends('adminpage.index')

@section('content')
@if (Auth::user()->role != 'Customer')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Kelola Setting</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Kelola Setting</li>
        </ol>

        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa fa-newspaper-o me-2"></i>Daftar Setting</span>
                <a href="{{ route('admin.setting.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus me-1"></i> Tambah Setting
                </a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Tipe</th>
                            <th style="width: 15%">Terakhir Diubah</th>
                            <th style="width: 70%">Konten</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($settings as $item)
                        <tr>
                            <td>{{ $no }}</td>
                            <td class="align-middle">{{ $item->type }}</td>
                            <td class="align-middle">{{ $item->updated_at->format('d F Y') }}</td>
                            <td class="align-middle">
                                {!! Str::limit(strip_tags($item->content), 100, '...') !!}
                            </td>
                            <td class="align-middle">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.setting.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="POST"
                                          action="{{ route('admin.setting.destroy', $item->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?');"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @php $no++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@else
    @include('adminpage.access_denied')
@endif
@endsection