@extends('adminpage.index')

@section('content')
@if (Auth::user()->role != 'Customer')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Kelola FAQ</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item">
                <a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Kelola FAQ</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <a href="{{ route('admin.faq.create') }}" class="btn btn-primary">Tambah FAQ</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($ar_faqs as $faq)
                        <tr>
                            <th>{{ $no }}</th>
                            <td>{{ $faq->question }}</td>
                            <td>{{ Str::limit(strip_tags($faq->answer), 100, '...') }}</td>
                            <td>{{ $faq->type }}</td>
                            <td>
                                @if($faq->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-warning btn-sm me-1" title="Ubah">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.faq.destroy', $faq->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Anda yakin ingin menghapus FAQ ini?')" title="Hapus">
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