@extends('adminpage.index')
@section('content')

@if (Auth::user()->role != 'Pelanggan')
    <main>
        <div class="container-fluid px-4">
            <div class="container px-5 my-5">
                <h2>Form Update User</h2>
                <form method="POST" action="{{ route('user.update', $row->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $row->name }}" id="name" type="text" placeholder="Nama User" />
                        <label for="name">Nama User</label>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $row->email }}" id="email" type="email" placeholder="Email" />
                        <label for="email">Email</label>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" id="password" type="password" placeholder="Password" value="********" disabled />
                        <label for="password">Password (tidak bisa diedit)</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select @error('role') is-invalid @enderror" name="role" aria-label="Role">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($enumOptions as $option)
                                <option value="{{ $option }}" {{ $row->role == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        <label for="role">Role</label>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $row->phone }}" id="phone" type="text" placeholder="No HP" />
                        <label for="phone">No. HP</label>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('province') is-invalid @enderror" name="province" value="{{ $row->province }}" id="province" type="text" placeholder="Provinsi" />
                        <label for="province">Provinsi</label>
                        @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('city') is-invalid @enderror" name="city" value="{{ $row->city }}" id="city" type="text" placeholder="Kota" />
                        <label for="city">Kota</label>
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Alamat" style="height: 100px;">{{ $row->address }}</textarea>
                        <label for="address">Alamat</label>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('postal_code') is-invalid @enderror" name="postal_code" value="{{ $row->postal_code }}" id="postal_code" type="number" placeholder="Kode Pos" />
                        <label for="postal_code">Kode Pos</label>
                        @error('postal_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                    <a href="{{ route('user.index') }}" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </main>
@else
    @include('adminpage.access_denied')
@endif

@endsection
