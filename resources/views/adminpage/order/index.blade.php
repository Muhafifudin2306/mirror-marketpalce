@extends('adminpage.index')
@section('content')
@if(Auth::user()->role!='Customer')
<main>
  <div class="container-fluid px-4">
    <h1 class="mt-4">Daftar Pesanan</h1>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Pesanan</li>
    </ol>
    <div class="card mb-4">
      <div class="card-header">
        <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Tambah Pesanan</a>
      </div>
      <div class="card-body">
        <table id="datatablesSimple">
          <thead>
            <tr>
              <th>No</th>
              <th>SPK</th>
              <th>Pelanggan</th>
              <th>Status Pesanan</th>
              <th>Status Bayar</th>
              <th>Subtotal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php $no=1; @endphp
            @foreach($orders as $o)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $o->spk }}</td>
              <td>{{ $o->user_name }}</td>
              <td>{{ $o->order_status }}</td>
              <td>{{ $o->payment_status }}</td>
              <td>{{ number_format($o->subtotal,0,',','.') }}</td>
              <td>
                <div class="btn-group">
                  <a href="{{ route('admin.orders.show',$o->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                  <a href="{{ route('admin.orders.edit',$o->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                  <form action="{{ route('admin.orders.destroy',$o->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                  </form>
                </div>
              </td>
            </tr>
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