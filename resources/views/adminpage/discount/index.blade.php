@extends('adminpage.index')
@section('content')
@if (Auth::user()->role !== 'Customer')
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Kelola Diskon Produk</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="{{ url('/admin') }}" class="text-decoration-none text-dark">Dashboard</a></li>
      <li class="breadcrumb-item active">Kelola Diskon</li>
    </ol>
    <div class="card mb-4">
      <div class="card-header">
        <a href="{{ route('admin.discount.create') }}" class="btn btn-primary">Tambah Diskon</a>
      </div>
      <div class="card-body">
        <table id="datatablesSimple">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Diskon</th>
              <th>%</th>
              <th>Rp</th>
              <th>Durasi</th>
              <th>Produk</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>No</th>
              <th>Nama Diskon</th>
              <th>%</th>
              <th>Rp</th>
              <th>Durasi</th>
              <th>Produk</th>
              <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
            @php $no=1; @endphp
            @foreach($discounts as $disc)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $disc->name }}</td>
              <td>{{ $disc->discount_percent ?? '-' }}%</td>
              <td>{{ $disc->discount_fix ?? '-' }}</td>
              <td>{{ $disc->start_discount }} - {{ $disc->end_discount }}</td>
              <td>{{ $disc->products->pluck('name')->join(', ') }}</td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('admin.discount.edit',$disc->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                  <form method="POST" action="{{ route('admin.discount.destroy',$disc->id) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
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