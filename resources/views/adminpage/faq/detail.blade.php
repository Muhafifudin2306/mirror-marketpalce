@extends('adminpage.index')
@section('content')
@if(Auth::user()->role!='Customer')
<main>
  <div class="container-fluid px-4">
    <h2 class="mt-4">Detail FAQ</h2>
    <div class="card mb-4">
      <div class="card-body">
        <h5>Pertanyaan</h5>
        <p>{{ $row->question }}</p>
        <h5>Jawaban</h5>
        <p>{!! nl2br(e($row->answer)) !!}</p>
        <h5>Tipe</h5>
        <p>{{ $row->type }}</p>
        <h5>Status</h5>
        <p>{{ $row->is_active ? 'Aktif' : 'Tidak Aktif' }}</p>
        <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">Kembali</a>
      </div>
    </div>
  </div>
</main>
@else
  @include('adminpage.access_denied')
@endif
@endsection
