@extends('adminpage.index')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <style>
        #layout-form,
        #standar-form,
        #categorize-form,
        #pricing-form {
            display: none;
        }
    </style>
    <!-- Content -->
    <div class="container flex-grow-1 container-p-y">
        <div class="">
            <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product/</span> Manage Product</h5>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <div class="mb-2">
                <button class="btn btn-primary" id="select-layout">
                    <i class="bx bx-plus fs-6"></i>
                    Tambah data
                </button>
            </div>
            <div class="card mb-2" id="layout-form">
                <div class="card-header bg-grey-50">
                    <div class="title-form">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="title-form">
                                <h5 class="fw-bold">Layout Form</h5>
                            </div>
                            <div class="close">
                                <button type="button" class="btn btn-danger" id="close-layout-form">
                                    <i class="bx bx-x fs-6"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" id="standar-form-button">Standar</button>
                    <button class="btn btn-primary" id="categorize-form-button">Categorize</button>
                    <button class="btn btn-primary" id="pricing-form-button">Pricing</button>
                </div>
            </div>

            <div class="card mb-2" id="standar-form">
                <div class="card-header">
                    <div class="title-form">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="title-form">
                                <h5 class="fw-bold">Form Produk</h5>
                            </div>
                            <div class="close">
                                <button class="btn btn-danger" id="close-standar-form">
                                    <i class="bx bx-x fs-6"></i>
                                    Close
                                </button>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $isEditing = isset($editingLabel);
                        $action = $isEditing ? route('adminProduct.update', $editingLabel->id) : route('adminProduct.store');
                    @endphp
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @if ($isEditing)
                            @method('PUT')
                        @endif
                        <input type="hidden" name="type" value="standart">

                        <div class="label-group mb-4">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label for="name_label">Produk</label>
                                    <input type="text" name="name_label" placeholder="Nama" class="form-control"
                                        value="{{ old('name_label', $editingLabel->name ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="size">Ukuran Standar</label>
                                    <input type="number" name="size" placeholder="Ukuran" class="form-control"
                                        value="{{ old('size', $editingLabel->size ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="unit">Satuan Standar</label>
                                    <select class="form-control" name="unit" id="unit">
                                        <option value="0" selected>Pilih Satuan</option>
                                        <option value="1"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 1 ? 'selected' : '' }}>
                                            Gram</option>
                                        <option value="2"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 2 ? 'selected' : '' }}>
                                            Kilogram</option>
                                        <option value="3"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 3 ? 'selected' : '' }}>
                                            cm</option>
                                        <option value="4"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 4 ? 'selected' : '' }}>
                                            m</option>
                                        <option value="5"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 5 ? 'selected' : '' }}>
                                            m2</option>
                                        <option value="6"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 6 ? 'selected' : '' }}>
                                            Lembar</option>
                                        <option value="7"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 7 ? 'selected' : '' }}>
                                            Rim</option>
                                        <option value="8"
                                            {{ isset($editingLabel->unit) && $editingLabel->unit == 8 ? 'selected' : '' }}>
                                            pcs</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="desc">Deskripsi Produk</label>
                                    <textarea name="desc" class="form-control" placeholder="Masukkan deskripsi label">{{ old('desc', $editingLabel->desc ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-xl-9">
                                <div class="product-group">
                                    <div class="row mb-2">
                                        @if ($isEditing)
                                            @foreach ($editingLabel->products as $i => $prod)
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h6>Informasi Sub Produk</h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-2">
                                                            <input type="text" name="name[]" class="form-control"
                                                                placeholder="Nama Product"
                                                                value="{{ old("name.$i", $prod->name) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2"><input type="number" name="long_product[]"
                                                                number class="form-control" placeholder="Panjang (cm)"
                                                                value="{{ old("long_product.$i", $prod->long_product) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2"><input type="number" name="width_product[]"
                                                                class="form-control" placeholder="Lebar (cm)"
                                                                value="{{ old("width_product.$i", $prod->width_product) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <input type="text" name="additional_size[]"
                                                                class="form-control" placeholder="Spesifik"
                                                                value="{{ old("additional_size.$i", $prod->additional_size) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2">
                                                            <input type="text" name="additional_unit[]"
                                                                class="form-control" placeholder="Unit"
                                                                value="{{ old("additional_unit.$i", $prod->additional_unit) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2"><input type="number" name="min_qty[]"
                                                                class="form-control" placeholder="Min qty"
                                                                value="{{ old("min_qty.$i", $prod->min_qty) }}"></div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="mb-2"><input type="number" name="max_qty[]"
                                                                class="form-control" placeholder="Max qty"
                                                                value="{{ old("max_qty.$i", $prod->max_qty) }}"></div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-2">
                                                            <input type="number" name="price[]" class="form-control"
                                                                placeholder="Harga"
                                                                value="{{ old("price.$i", $prod->price) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <button type="button"
                                                                class="btn btn-outline-danger remove-row w-100">
                                                                <i class="bx bx-trash-alt fs-6"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6>Informasi Sub Produk</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-2"><input type="text" name="name[]"
                                                            class="form-control" placeholder="Nama Product*" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2"><input type="number" name="long_product[]"
                                                            number class="form-control" placeholder="Panjang (cm)"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2"><input type="number" name="width_product[]"
                                                            class="form-control" placeholder="Lebar (cm)"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2"><input type="text" name="additional_size[]"
                                                            class="form-control" placeholder="Spesifik"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-2"><input type="text" name="additional_unit[]"
                                                            class="form-control" placeholder="Unit"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-2"><input type="number" name="min_qty[]"
                                                            class="form-control" placeholder="Min qty"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="mb-2"><input type="number" name="max_qty[]"
                                                            class="form-control" placeholder="Max qty"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2"><input type="number" name="price[]"
                                                            class="form-control" placeholder="Harga*" required></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-outline-success w-100" id="add-field">
                                                <i class="bx bx-plus fs-6"></i> Tambah Produk
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="finishing-group">
                                    <div class="row mb-2 finishing">
                                        @if ($isEditing)
                                            {{-- Memeriksa jika $editingLabel dan finishings ada, dan finishings TIDAK kosong --}}
                                            @if (isset($editingLabel) && $editingLabel->finishings->isNotEmpty())
                                                @foreach ($editingLabel->finishings as $i => $finish)
                                                    <div class="col-md-12">
                                                        <h6>Informasi Finishing</h6>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="mb-2">
                                                            <input type="text" name="finishing_name[]"
                                                                class="form-control" placeholder="Nama Finishing"
                                                                value="{{ old("finishing_name.$i", $finish->finishing_name) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="mb-2">
                                                            <input type="number" name="finishing_price[]"
                                                                class="form-control"
                                                                value="{{ old("finishing_price.$i", $finish->finishing_price) }}"
                                                                placeholder="Harga">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-2">
                                                            <button type="button"
                                                                class="btn btn-outline-danger remove-finishing w-100">
                                                                <i class="bx bx-trash-alt fs-6"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                {{-- Jika $editingLabel->finishings kosong atau tidak ada, tampilkan satu set input kosong --}}
                                                <div class="col-md-12">
                                                    <h6>Informasi Finishing</h6>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="mb-2">
                                                        <input type="text" name="finishing_name[]"
                                                            class="form-control" placeholder="Nama Finishing">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="mb-2">
                                                        <input type="number" name="finishing_price[]"
                                                            class="form-control" placeholder="Harga">
                                                    </div>
                                                </div>
                                                {{-- Tombol hapus tidak perlu ada di sini karena ini adalah input default pertama --}}
                                            @endif
                                        @else
                                            {{-- Ini adalah blok jika $isEditing bernilai false (mode create/tambah baru) --}}
                                            <div class="col-md-12">
                                                <h6>Informasi Finishing</h6>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="mb-2">
                                                    <input type="text" name="finishing_name[]" class="form-control"
                                                        placeholder="Nama Finishing">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="mb-2">
                                                    <input type="number" name="finishing_price[]" class="form-control"
                                                        placeholder="Harga">
                                                </div>
                                            </div>
                                            {{-- Tombol hapus tidak perlu ada di sini --}}
                                        @endif
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-outline-success w-100"
                                                id="add-finishing">
                                                <i class="bx bx-plus fs-6"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <button class="btn btn-primary px-5" type="submit">
                                    {{ $isEditing ? 'Update' : 'Submit' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-2" id="categorize-form">
            </div>
            <div class="card mb-2" id="pricing-form">
            </div>
            @if ($labels->isEmpty())
                <div class="alert alert-info">
                    Data kosong
                </div>
            @else
                <div class="row">
                    @foreach ($labels as $label)
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="header-title">
                                        {{ Str::limit($label->name, 50, '...') }}
                                        {{ Str::limit($label->size, 50, '...') }}
                                        @if ($label->unit == 1)
                                            Gram
                                        @elseif($label->unit == 2)
                                            Kilogram
                                        @elseif($label->unit == 3)
                                            cm
                                        @elseif($label->unit == 4)
                                            m
                                        @elseif($label->unit == 5)
                                            m2
                                        @elseif($label->unit == 6)
                                            Lembar
                                        @elseif($label->unit == 7)
                                            Rim
                                        @elseif($label->unit == 8)
                                            pcs
                                        @endif
                                    </h5>
                                    <div class="header-actions">
                                        <a href="{{ route('adminProduct.index', ['edit' => $label->id]) }}"
                                            class="text-primary cursor-pointer">
                                            <i class="bx bx-edit fs-3" title="Edit Data Produk"></i>
                                        </a>
                                        <span class="text-danger btn-delete cursor-pointer"
                                            data-url="{{ route('adminProduct.destroy', $label->id) }}">
                                            <i class="bx bx-trash-alt fs-3"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="mb-2 table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Sub Produk</th>
                                                    <th>Spesifikasi</th>
                                                    <th>Panjang (cm)</th>
                                                    <th>Lebar (cm)</th>
                                                    <th>Unit</th>
                                                    <th>MIN</th>
                                                    <th>MAX</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($label->products as $product)
                                                    <tr>
                                                        <td>
                                                            {{-- {{ Str::limit($product->name, 25, '...') }}
                                                            {{ Str::limit($product->additional_size, 13, '...') . ' ' . Str::limit($product->additional_unit, 15, '...') }} --}}
                                                            {{ $product->name }}
                                                        </td>
                                                        <td>{{ $product->additional_size ? $product->additional_size : '-' }}
                                                        </td>
                                                        <td>{{ $product->long_product ? $product->long_product : '-' }}
                                                        </td>
                                                        <td>{{ $product->width_product ? $product->width_product : '-' }}
                                                        </td>
                                                        <td>{{ $product->additional_unit ? $product->additional_unit : '-' }}
                                                        </td>
                                                        <td>{{ $product->min_qty ? $product->min_qty : '-' }}</td>
                                                        <td>{{ $product->max_qty ? $product->max_qty : '-' }}</td>
                                                        <td>Rp
                                                            {{ Str::limit(number_format($product->price, 0, ',', '.'), 10, '...') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($label->finishings->isNotEmpty())
                                        <div class="mb-2 table-responsive w-50">
                                            <h6 class="mb-2 mt-4">Data Finishing</h6>
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr class="table-primary">
                                                        <th>Nama Finishing</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($label->finishings as $item)
                                                        <tr>
                                                            <td>
                                                                {{ $item->finishing_name }}
                                                            </td>
                                                            <td>Rp
                                                                {{ Str::limit(number_format($item->finishing_price, 0, ',', '.'), 10, '...') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    <hr>
                                    <div class="mb-0">
                                        {{ $label->desc }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>


    <script>
        document.getElementById("select-layout").addEventListener("click", function() {
            document.getElementById("select-layout").classList.remove("btn-primary");
            document.getElementById("select-layout").classList.add("btn-secondary");
            document.getElementById("standar-form").style.display = "block";
        });

        document.getElementById("close-standar-form").addEventListener("click", function() {
            document.getElementById("select-layout").classList.remove("btn-secondary");
            document.getElementById("select-layout").classList.add("btn-primary");
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if ($isEditing)
                document.getElementById("standar-form").style.display = "block";
                // const form = document.querySelector("#standar-form form");
                // const rows = form.querySelectorAll('.product-group .row.mb-2');
                // rows.forEach((r, i) => {
                //     if (i > 0) r.remove();
                // });
            @endif

            const productGroup = document.querySelector(".product-group");
            const finishingGroup = document.querySelector(".finishing-group");
            const addFinishing = document.getElementById("add-finishing");
            const addButton = document.getElementById("add-field");

            function createRow() {
                const row = document.createElement("div");
                row.className = "row mb-2";
                row.innerHTML = `
                <div class="row">
                    <div class="col-md-12">
                                           <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <h6>Informasi Sub Produk</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2"><input type="text" name="name[]"
                                                    class="form-control" placeholder="Nama Product" required></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-2"><input type="number" name="long_product[]" number
                                                    class="form-control" placeholder="Panjang (cm)"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-2"><input type="number" name="width_product[]"
                                                    class="form-control" placeholder="Lebar (cm)"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-2"><input type="text" name="additional_size[]"
                                                    class="form-control" placeholder="Spesifik"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2"><input type="text" name="additional_unit[]"
                                                    class="form-control" placeholder="Unit"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2"><input type="number" name="min_qty[]"
                                                    class="form-control" placeholder="Min qty"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-2"><input type="number" name="max_qty[]"
                                                    class="form-control" placeholder="Max qty"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-2"><input type="number" name="price[]"
                                                    class="form-control" placeholder="Harga"></div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-2"><button type="button" class="btn btn-outline-danger remove-row w-100"><i class="bx bx-trash-alt fs-6"></i></button></div></div></div>
                                        </div>
                                    </div>
                `;
                return row;
            }

            function createFinishing() {
                const row = document.createElement("div");
                row.className = "row mb-2 finishing";
                row.innerHTML = `
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-7">
                        <div class="mb-2"><input type="text" name="finishing_name[]"
                                class="form-control" placeholder="Nama Finishing">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-2"><input type="number" name="finishing_price[]"
                                class="form-control" placeholder="Harga"></div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-2"><button type="button"
                                class="btn btn-outline-danger remove-finishing w-100"><i
                                    class="bx bx-trash-alt fs-6"></i></button></div>
                    </div>
                `;
                return row;
            }

            addButton.addEventListener("click", function() {
                const newRow = createRow();
                productGroup.insertBefore(newRow, addButton.closest(".row"));
            });

            addFinishing.addEventListener("click", function() {
                const newFinishing = createFinishing();
                finishingGroup.insertBefore(newFinishing, addFinishing.closest(".row"));
            });

            productGroup.addEventListener("click", function(e) {
                if (e.target && e.target.classList.contains("remove-row")) {
                    const row = e.target.closest(".row");
                    row.remove();
                }
            });

            finishingGroup.addEventListener("click", function(e) {
                if (e.target && e.target.classList.contains("remove-finishing")) {
                    const rowFihishing = e.target.closest(".row");
                    rowFihishing.remove();
                }
            });
        });

        // Delete Function
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

        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = '{{ route('adminProduct.index') }}';
            const closeStandar = document.getElementById("close-standar-form");

            function clearEditState() {
                history.replaceState(null, '', baseUrl);
                const form = document.querySelector("#standar-form form");
                if (!form) return;

                const m = form.querySelector('input[name="_method"]');
                if (m) m.remove();

                form.action = '{{ route('adminProduct.store') }}';

                form.querySelectorAll('input, textarea').forEach(el => {
                    if (el.type !== 'hidden') el.value = '';
                });
            }

            closeStandar.addEventListener('click', () => {
                clearEditState();
                document.getElementById("standar-form").style.display = "none";
            });
        });
    </script>
@endsection
