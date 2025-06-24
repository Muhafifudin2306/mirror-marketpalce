@extends('adminpage.index')
@section('content')
@if (Auth::user()->role != 'Customer')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Kelola Kode Promo</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelola Kode Promo</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="{{ route('admin.promocode.create') }}" class="btn btn-primary">Tambah</a>
                </div>    
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Promo</th>
                                <th>Disc Perc</th>
                                <th>Disc Rp</th>
                                <th>Max Potongan</th>
                                <th>Durasi</th>
                                <th>Batas Pemakaian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode Promo</th>
                                <th>Disc Perc</th>
                                <th>Disc Rp</th>
                                <th>Maks. Potongan</th>
                                <th>Durasi</th>
                                <th>Batas Pemakaian</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($ar_promocode as $promocode)
                            <tr>
                                <th>{{ $no }}</th>
                                <td>{{ $promocode->code }}</td>
                                <td>{{ $promocode->discount_percent ? $promocode->discount_percent : '-' }}%</td>
                                <td>{{ $promocode->discount_fix ? $promocode->discount_fix : '-' }}</td>
                                <td>{{ $promocode->max_discount ? $promocode->max_discount : '-' }}</td>
                                <td>{{ $promocode->start_at }} - <br>{{ $promocode->end_at }}</td>
                                <td>{{ $promocode->usage_limit }}</td>
                                <td>
                                    <div class="btn-group">
                                        {{-- <a class="btn btn-info btn-sm me-1" href="{{ route('admin.promocode.show', $promocode->id) }}" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a> --}}
                                        <a class="btn btn-warning btn-sm me-1" href="{{ route('admin.promocode.edit', $promocode->id) }}" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.promocode.destroy', $promocode->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit" title="Hapus" name="proses" value="hapus" onclick="return confirm('Anda Yakin Data Dihapus?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <input type="hidden" name="idx" value=""/>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php $no++ @endphp
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