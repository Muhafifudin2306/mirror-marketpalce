<!-- resources/views/adminpage/testimonials/index.blade.php -->
@extends('adminpage.index')
@section('content')
@if (Auth::user()->role != 'Customer')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kelola Testimonial</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Kelola Testimonial</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="{{ route('admin.testimonial.create') }}" class="btn btn-primary">Tambah Testimonial</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Masukan / Saran</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Masukan / Saran</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($testimonials as $item)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->location }}</td>
                                    <td>{{ Str::limit($item->feedback, 50) }}</td>
                                    <td>
                                        @if($item->photo)
                                            <button type="button" 
                                                    class="btn btn-info btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#photoModal{{ $item->id }}">
                                                <i class="fa fa-eye"></i> Lihat
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.testimonial.edit', $item->id) }}"
                                               class="btn btn-warning btn-sm me-1" title="Ubah">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.testimonial.destroy', $item->id) }}"
                                                  method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Anda yakin akan menghapus testimonial ini?')"
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

    <!-- Photo Modals -->
    @foreach($testimonials as $item)
        @if($item->photo)
            <div class="modal fade" id="photoModal{{ $item->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="photoModalLabel{{ $item->id }}">
                                Foto Testimonial - {{ $item->name }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ asset('storage/' . $item->photo) }}" 
                                 alt="Foto {{ $item->name }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 500px;">
                            <div class="mt-3">
                                <p><strong>Nama:</strong> {{ $item->name }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

@else
    @include('adminpage.access_denied')
@endif
@endsection