@extends('layouts.app')

@php
  use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- Content -->
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product/</span> Manage Product</h5>


            <div class="mb-3">
                <button class="btn btn-primary" id="select-layout">
                    <i class="bx bx-plus fs-6"></i>
                    Tambah data
                </button>
            </div>
            <div class="card mb-3" id="layout-form">
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

            <div class="card mb-3" id="standar-form">
                <div class="card-header">
                    <div class="title-form">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="title-form">
                                <h5 class="fw-bold">Form Standar</h5>
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
                        $action = $isEditing
                            ? route('product.update', $editingLabel->id)
                            : route('product.store');
                    @endphp
                    <form action="{{ $action }}" method="POST">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @if($isEditing) @method('PUT') @endif
                        <input type="hidden" name="type" value="standart">
    
                        <div class="label-group mb-4">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label for="name_label">Nama Label</label>
                                    <input type="text" name="name_label" class="form-control"
                                        value="{{ old('name_label', $editingLabel->name ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="size">Ukuran Standar</label>
                                    <input type="text" name="size" class="form-control"
                                        value="{{ old('size', $editingLabel->size ?? '') }}">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <label for="unit">Satuan Standar</label>
                                    <input type="text" name="unit" class="form-control"
                                        value="{{ old('unit', $editingLabel->unit ?? '') }}">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="desc">Deskripsi Label</label>
                                    <textarea name="desc" class="form-control">{{ old('desc', $editingLabel->desc ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
    
                        <div class="product-group">
                            @if($isEditing)
                                @foreach($editingLabel->products as $i => $prod)
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <input type="text" name="name[]" class="form-control"
                                                placeholder="Nama Product"
                                                value="{{ old("name.$i", $prod->name) }}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="additional_size[]" class="form-control"
                                                placeholder="Spesifik"
                                                value="{{ old("additional_size.$i", $prod->additional_size) }}">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="additional_unit[]" class="form-control"
                                                placeholder="Unit"
                                                value="{{ old("additional_unit.$i", $prod->additional_unit) }}">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="price[]" class="form-control"
                                                placeholder="Harga"
                                                value="{{ old("price.$i", $prod->price) }}">
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger remove-row">
                                                <i class="bx bx-trash-alt fs-6"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <input type="text" name="name[]" class="form-control" placeholder="Nama Product">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="additional_size[]" class="form-control" placeholder="Spesifik">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="additional_unit[]" class="form-control" placeholder="Unit">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="price[]" class="form-control" placeholder="Harga">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-danger remove-row">
                                            <i class="bx bx-trash-alt fs-6"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-md-11">
                                    <button type="button" class="btn btn-outline-success w-100" id="add-field">
                                        <i class="bx bx-plus fs-6"></i> Tambah Field
                                    </button>
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
            <div class="card mb-3" id="categorize-form">
            </div>
            <div class="card mb-3" id="pricing-form">
            </div>
            @if ($labels->isEmpty())
                <div class="alert alert-info">
                    Data kosong
                </div>
            @else
            <div class="row">
                @foreach ($labels as $label)
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header d-flex align-items-center">
                                <h2 class="header-title">
                                    {{ Str::limit($label->name, 14, '...') }}
                                    / {{ Str::limit($label->size, 5, '...') }}
                                    {{ Str::limit($label->unit, 3, '...') }}
                                </h2>
                                    <div class="header-actions">
                                        <a href="{{ route('product.index', ['edit' => $label->id]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="bx bx-edit fs-6"></i>
                                        </a>
                                        <button type="button"
                                        class="btn btn-sm btn-danger btn-delete"
                                        data-url="{{ route('product.destroy', $label->id) }}">
                                            <i class="bx bx-trash-alt fs-6"></i>
                                        </button>
                                    </div>
                                </div>

                            <div class="card-body">
                                <div class="product-group mb-3">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>Nama Produk</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($label->products as $product)
                                                <tr>
                                                    <td>
                                                        {{ Str::limit($product->name, 15, '...') }}
                                                        {{ Str::limit($product->additional_size, 3, '...') }}{{ Str::limit($product->additional_unit, 3, '...') }}
                                                    </td>
                                                    <td>Rp {{ Str::limit(number_format($product->price, 0, ',', '.'), 10, '...') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
            document.getElementById("layout-form").style.display = "block";
            document.getElementById("standar-form").style.display = "none";
            document.getElementById("categorize-form").style.display = "none";
            document.getElementById("pricing-form").style.display = "none";
        });

        document.getElementById("standar-form-button").addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("standar-form").style.display = "block";
        });

        document.getElementById("categorize-form-button").addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("categorize-form").style.display = "block";
            document.getElementById("standar-form").style.display = "none";
            document.getElementById("pricing-form").style.display = "none";
        });

        document.getElementById("pricing-form-button").addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("pricing-form").style.display = "block";
            document.getElementById("standar-form").style.display = "none";
            document.getElementById("categorize-form").style.display = "none";
        });

        document.getElementById("close-standar-form").addEventListener("click", function() {
            document.getElementById("standar-form").style.display = "none";
            document.getElementById("layout-form").style.display = "block";
        });

        document.getElementById("close-layout-form").addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("select-layout").classList.remove("btn-secondary");
            document.getElementById("select-layout").classList.add("btn-primary");
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if($isEditing)
                document.getElementById("select-layout").classList.remove("btn-primary");
                document.getElementById("select-layout").classList.add("btn-secondary");
                document.getElementById("layout-form").style.display = "none";
                document.getElementById("standar-form").style.display = "block";
            @endif

            const productGroup = document.querySelector(".product-group");
            const addButton = document.getElementById("add-field");

            function createRow() {
                const row = document.createElement("div");
                row.className = "row mb-2";
                row.innerHTML = `
                    <div class="col-md-4"><input type="text" name="name[]" class="form-control" placeholder="Nama Product"></div>
                    <div class="col-md-2"><input type="text" name="additional_size[]" class="form-control" placeholder="Spesifik"></div>
                    <div class="col-md-2"><input type="text" name="additional_unit[]" class="form-control" placeholder="Unit"></div>
                    <div class="col-md-3"><input type="number" name="price[]" class="form-control" placeholder="Harga"></div>
                    <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger remove-row">
                        <i class="bx bx-trash-alt fs-6"></i>
                    </button>
                    </div>
                `;
                return row;
            }

            addButton.addEventListener("click", function() {
                const newRow = createRow();
                productGroup.insertBefore(newRow, addButton.closest(".row"));
            });

            productGroup.addEventListener("click", function(e) {
                if (e.target && e.target.classList.contains("remove-row")) {
                    const row = e.target.closest(".row");
                    row.remove();
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function () {
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

                            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="${token}">
                                <input type="hidden" name="_method" value="DELETE">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        },
                        function onCancel() {
                        },
                        {
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
            const baseUrl = '{{ route("product.index") }}';
            const selectLayout = document.getElementById("select-layout");
            const closeLayout = document.getElementById("close-layout-form");
            const closeStandar = document.getElementById("close-standar-form");

            function clearEditState() {
                history.replaceState(null, '', baseUrl);
                const form = document.querySelector("#standar-form form");
                if (!form) return;

                const m = form.querySelector('input[name="_method"]');
                if (m) m.remove();

                form.action = '{{ route("product.store") }}';

                form.querySelectorAll('input, textarea').forEach(el => {
                    if (el.type !== 'hidden') el.value = '';
                });

                const rows = form.querySelectorAll('.product-group .row.mb-2');
                rows.forEach((r, i) => { if (i > 0) r.remove(); });
            }

            selectLayout.addEventListener('click', () => {
                clearEditState();
                selectLayout.classList.replace('btn-primary','btn-secondary');
                document.getElementById("layout-form").style.display = "block";
                document.getElementById("standar-form").style.display = "none";
            });

            closeLayout.addEventListener('click', () => {
                clearEditState();
                document.getElementById("layout-form").style.display = "none";
                selectLayout.classList.replace('btn-secondary','btn-primary');
            });

            closeStandar.addEventListener('click', () => {
                clearEditState();
                document.getElementById("standar-form").style.display = "none";
                document.getElementById("layout-form").style.display = "block";
            });
        });
    </script>
@endsection
