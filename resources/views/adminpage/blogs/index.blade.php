@extends('adminpage.index')

@section('content')
@if (Auth::user()->role != 'Customer')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Kelola Artikel</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Kelola Artikel</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Tambah Artikel</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Terakhir diubah</th>
                            <th>Deskripsi</th>
                            <th>Pembuat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($blogs as $item)
                        <tr>
                            <th>{{ $no }}</th>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->updated_at->format('d F Y') }}</td>
                            <td>{!! Str::limit(strip_tags($item->content), 100, '...') !!}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.blog.edit', $item->id) }}" class="btn btn-warning btn-sm me-1" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.blog.destroy', $item->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Anda yakin ingin menghapus blog ini?')" title="Hapus">
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