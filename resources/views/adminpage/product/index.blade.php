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
        
        /* Image Preview Styles */
        .image-preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            min-height: 60px;
            padding: 10px;
            border: 1px dashed #e0e0e0;
            border-radius: 8px;
            background-color: #fafafa;
        }

        .image-preview-container:empty::before {
            content: "Belum ada gambar dipilih";
            color: #999;
            font-style: italic;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            text-align: center;
        }

        .image-preview {
            position: relative;
            width: 80px;
            height: 80px;
            border: 2px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .image-preview:hover {
            transform: scale(1.05);
            border-color: #007bff;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .remove-image {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: background-color 0.2s ease;
        }

        .remove-image:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        /* Existing image styling */
        .existing-image {
            border-color: #28a745;
        }

        .existing-image::after {
            content: "✓";
            position: absolute;
            bottom: 2px;
            left: 2px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .new-image {
            border-color: #007bff;
        }

        /* Product row styling */
        .product-row {
            margin-bottom: 2rem;
            padding: 1.5rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .product-row:not(:last-of-type) {
            margin-bottom: 1.5rem;
        }

        /* Header actions styling */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: auto;
        }

        .header-actions a,
        .header-actions span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .header-actions a:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transform: scale(1.1);
        }

        .header-actions span:hover {
            background-color: rgba(220, 53, 69, 0.1);
            transform: scale(1.1);
            cursor: pointer;
        }

        /* Form styling improvements */
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Helper text styling */
        .helper-text {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 4px;
            padding: 4px 8px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border-left: 3px solid #007bff;
        }

        /* Card improvements */
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border: none;
        }

        .card-body {
            padding: 2rem;
        }

        /* Table improvements */
        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table thead th {
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* Alert improvements */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .image-preview {
                width: 60px;
                height: 60px;
            }
            
            .image-preview-container {
                gap: 5px;
                padding: 8px;
            }
            
            .remove-image {
                width: 20px;
                height: 20px;
                font-size: 12px;
                top: -6px;
                right: -6px;
            }

            .product-row {
                padding: 1rem;
            }

            .header-actions {
                gap: 10px;
            }

            .header-actions a,
            .header-actions span {
                width: 35px;
                height: 35px;
            }
        }
    </style>

    <!-- Content -->
    <div class="container flex-grow-1 container-p-y">
        <div class="">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">Product /</span> Manage Product
            </h5>
            
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="mb-4">
                <button class="btn btn-primary btn-lg" id="select-layout">
                    <i class="bx bx-plus me-2"></i>
                    Tambah Produk Baru
                </button>
            </div>

            <!-- Layout Form Card -->
            <div class="card mb-4" id="layout-form">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bx bx-layout me-2"></i>
                            Pilih Layout Form
                        </h5>
                        <button type="button" class="btn btn-light btn-sm" id="close-layout-form">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <button class="btn btn-outline-primary w-100" id="standar-form-button">
                                <i class="bx bx-package me-2"></i>
                                Standar
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-secondary w-100" id="categorize-form-button">
                                <i class="bx bx-category me-2"></i>
                                Categorize
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-info w-100" id="pricing-form-button">
                                <i class="bx bx-dollar me-2"></i>
                                Pricing
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Standar Form Card -->
            <div class="card mb-4" id="standar-form">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bx bx-edit me-2"></i>
                            Form Produk Standar
                        </h5>
                        <button class="btn btn-light btn-sm" id="close-standar-form">
                            <i class="bx bx-x me-1"></i>
                            Tutup
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $isEditing = isset($editingLabel);
                        $action = $isEditing ? route('admin.product.update', $editingLabel->id) : route('admin.product.store');
                    @endphp
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        @if ($isEditing)
                            @method('PUT')
                        @endif
                        <input type="hidden" name="type" value="standart">

                        <!-- Label Group -->
                        <div class="label-group mb-5">
                            <h6 class="fw-bold text-primary mb-3">
                                <i class="bx bx-info-circle me-2"></i>
                                Informasi Produk Utama
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="name_label" class="form-label fw-semibold">Nama Produk *</label>
                                    <input type="text" name="name_label" placeholder="Contoh: Banner Vinyl" 
                                           class="form-control" required
                                           value="{{ old('name_label', $editingLabel->name ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="size" class="form-label fw-semibold">Ukuran Standar</label>
                                    <input type="number" name="size" placeholder="Contoh: 80" 
                                           class="form-control"
                                           value="{{ old('size', $editingLabel->size ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="unit" class="form-label fw-semibold">Satuan Standar</label>
                                    <select class="form-control" name="unit" id="unit">
                                        <option value="0">Pilih Satuan</option>
                                        <option value="1" {{ isset($editingLabel->unit) && $editingLabel->unit == 1 ? 'selected' : '' }}>Gram</option>
                                        <option value="2" {{ isset($editingLabel->unit) && $editingLabel->unit == 2 ? 'selected' : '' }}>Kilogram</option>
                                        <option value="3" {{ isset($editingLabel->unit) && $editingLabel->unit == 3 ? 'selected' : '' }}>cm</option>
                                        <option value="4" {{ isset($editingLabel->unit) && $editingLabel->unit == 4 ? 'selected' : '' }}>m</option>
                                        <option value="5" {{ isset($editingLabel->unit) && $editingLabel->unit == 5 ? 'selected' : '' }}>m²</option>
                                        <option value="6" {{ isset($editingLabel->unit) && $editingLabel->unit == 6 ? 'selected' : '' }}>Lembar</option>
                                        <option value="7" {{ isset($editingLabel->unit) && $editingLabel->unit == 7 ? 'selected' : '' }}>Rim</option>
                                        <option value="8" {{ isset($editingLabel->unit) && $editingLabel->unit == 8 ? 'selected' : '' }}>pcs</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="desc" class="form-label fw-semibold">Deskripsi Produk</label>
                                    <textarea name="desc" class="form-control" rows="3" 
                                              placeholder="Jelaskan produk secara umum...">{{ old('desc', $editingLabel->desc ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="product-group">
                                    <h6 class="fw-bold text-success mb-3">
                                        <i class="bx bx-package me-2"></i>
                                        Sub Produk
                                    </h6>
                                    
                                    @if ($isEditing)
                                        @foreach ($editingLabel->products as $i => $prod)
                                            <div class="product-row" data-product-index="{{ $i }}">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="fw-bold text-secondary mb-0">
                                                        <i class="bx bx-cube me-2"></i>
                                                        Sub Produk #{{ $i + 1 }}
                                                    </h6>
                                                    @if($i > 0)
                                                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>

                                                <input type="hidden" name="product_id[]" value="{{ $prod->id }}">
                                                
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">Nama Sub Produk *</label>
                                                        <input type="text" name="name[]" class="form-control" required
                                                               placeholder="Contoh: Banner Indoor 80 gram"
                                                               value="{{ old("name.$i", $prod->name) }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-semibold">Panjang (cm)</label>
                                                        <input type="number" name="long_product[]" class="form-control" 
                                                               placeholder="100"
                                                               value="{{ old("long_product.$i", $prod->long_product) }}">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-semibold">Lebar (cm)</label>
                                                        <input type="number" name="width_product[]" class="form-control" 
                                                               placeholder="70"
                                                               value="{{ old("width_product.$i", $prod->width_product) }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">Spesifikasi</label>
                                                        <input type="text" name="additional_size[]" class="form-control" 
                                                               placeholder="Contoh: 80 gram"
                                                               value="{{ old("additional_size.$i", $prod->additional_size) }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-semibold">Unit</label>
                                                        <input type="text" name="additional_unit[]" class="form-control" 
                                                               placeholder="m²"
                                                               value="{{ old("additional_unit.$i", $prod->additional_unit) }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-semibold">Min Qty</label>
                                                        <input type="number" name="min_qty[]" class="form-control" 
                                                               placeholder="1"
                                                               value="{{ old("min_qty.$i", $prod->min_qty) }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-semibold">Max Qty</label>
                                                        <input type="number" name="max_qty[]" class="form-control" 
                                                               placeholder="100"
                                                               value="{{ old("max_qty.$i", $prod->max_qty) }}">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-semibold">Harga *</label>
                                                        <input type="number" name="price[]" class="form-control" required
                                                               placeholder="50000"
                                                               value="{{ old("price.$i", $prod->price) }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">Upload Gambar (Max 4)</label>
                                                        <input type="file" 
                                                               name="product_images[{{ $i }}][]" 
                                                               class="form-control image-input" 
                                                               multiple accept="image/*" data-index="{{ $i }}"
                                                               onchange="handleImagePreview(this, {{ $i }})">
                                                        <div class="image-preview-container" data-index="{{ $i }}">
                                                            @foreach($prod->images as $image)
                                                                <div class="image-preview existing-image">
                                                                    <img src="{{ asset('storage/' . $image->image_product) }}" alt="Product Image">
                                                                    <input type="hidden" name="existing_images[{{ $i }}][]" value="{{ $image->id }}">
                                                                    <button type="button" class="remove-image" onclick="removeExistingImage(this, {{ $i }}, {{ $image->id }})">×</button>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB per file.</small>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">Waktu Produksi</label>
                                                        <input type="text" name="production_time[]" class="form-control" 
                                                               placeholder="1-2 hari kerja"
                                                               value="{{ old("production_time.$i", $prod->production_time) }}">
                                                        <div class="helper-text">
                                                            <i class="bx bx-info-circle me-1"></i>
                                                            Gunakan ";" untuk enter, "*" untuk bullet points
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">Deskripsi Produk</label>
                                                        <textarea name="description[]" class="form-control" rows="2" 
                                                                  placeholder="Deskripsi detail produk">{{ old("description.$i", $prod->description) }}</textarea>
                                                        <div class="helper-text">
                                                            <i class="bx bx-info-circle me-1"></i>
                                                            Gunakan ";" untuk enter, "*" untuk bullet points
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">Spesifikasi Teknis</label>
                                                        <textarea name="spesification_desc[]" class="form-control" rows="2" 
                                                                  placeholder="Spesifikasi teknis detail">{{ old("spesification_desc.$i", $prod->spesification_desc) }}</textarea>
                                                        <div class="helper-text">
                                                            <i class="bx bx-info-circle me-1"></i>
                                                            Gunakan ";" untuk enter, "*" untuk bullet points
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="product-row" data-product-index="0">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="fw-bold text-secondary mb-0">
                                                    <i class="bx bx-cube me-2"></i>
                                                    Sub Produk #1
                                                </h6>
                                            </div>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">Nama Sub Produk *</label>
                                                    <input type="text" name="name[]" class="form-control" required
                                                           placeholder="Contoh: Banner Indoor 80 gram">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">Panjang (cm)</label>
                                                    <input type="number" name="long_product[]" class="form-control" 
                                                           placeholder="100">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label fw-semibold">Lebar (cm)</label>
                                                    <input type="number" name="width_product[]" class="form-control" 
                                                           placeholder="70">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Spesifikasi</label>
                                                    <input type="text" name="additional_size[]" class="form-control" 
                                                           placeholder="Contoh: 80 gram">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Unit</label>
                                                    <input type="text" name="additional_unit[]" class="form-control" 
                                                           placeholder="m²">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Min Qty</label>
                                                    <input type="number" name="min_qty[]" class="form-control" 
                                                           placeholder="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Max Qty</label>
                                                    <input type="number" name="max_qty[]" class="form-control" 
                                                           placeholder="100">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label fw-semibold">Harga *</label>
                                                    <input type="number" name="price[]" class="form-control" required
                                                           placeholder="50000">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Upload Gambar (Max 4)</label>
                                                    <input type="file" name="product_images[0][]" 
                                                           class="form-control image-input" 
                                                           multiple accept="image/*" data-index="0"
                                                           onchange="handleImagePreview(this, 0)">
                                                    <div class="image-preview-container" data-index="0"></div>
                                                    <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB per file.</small>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Waktu Produksi</label>
                                                    <input type="text" name="production_time[]" class="form-control" 
                                                           placeholder="1-2 hari kerja">
                                                    <div class="helper-text">
                                                        <i class="bx bx-info-circle me-1"></i>
                                                        Gunakan ";" untuk enter, "*" untuk bullet points
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Deskripsi Produk</label>
                                                    <textarea name="description[]" class="form-control" rows="2" 
                                                              placeholder="Deskripsi detail produk"></textarea>
                                                    <div class="helper-text">
                                                        <i class="bx bx-info-circle me-1"></i>
                                                        Gunakan ";" untuk enter, "*" untuk bullet points
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-semibold">Spesifikasi Teknis</label>
                                                    <textarea name="spesification_desc[]" class="form-control" rows="2" 
                                                              placeholder="Spesifikasi teknis detail"></textarea>
                                                    <div class="helper-text">
                                                        <i class="bx bx-info-circle me-1"></i>
                                                        Gunakan ";" untuk enter, "*" untuk bullet points
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-4">
                                        <button type="button" class="btn btn-outline-success w-100" id="add-field">
                                            <i class="bx bx-plus me-2"></i> Tambah Sub Produk
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="finishing-group">
                                    <h6 class="fw-bold text-warning mb-3">
                                        <i class="bx bx-palette me-2"></i>
                                        Finishing Options
                                    </h6>
                                    
                                    <div class="finishing-items">
                                        @if ($isEditing && isset($editingLabel) && $editingLabel->finishings->isNotEmpty())
                                            @foreach ($editingLabel->finishings as $i => $finish)
                                                <div class="finishing-row mb-3 p-3 border rounded">
                                                    <div class="row g-2">
                                                        <div class="col-8">
                                                            <label class="form-label fw-semibold">Nama Finishing</label>
                                                            <input type="text" name="finishing_name[]" class="form-control" 
                                                                   placeholder="Contoh: Laminating Glossy"
                                                                   value="{{ old("finishing_name.$i", $finish->finishing_name) }}">
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label fw-semibold">Harga</label>
                                                            <input type="number" name="finishing_price[]" class="form-control"
                                                                   placeholder="15000"
                                                                   value="{{ old("finishing_price.$i", $finish->finishing_price) }}">
                                                        </div>
                                                        @if($i > 0)
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-outline-danger btn-sm remove-finishing w-100">
                                                                    <i class="bx bx-trash me-1"></i> Hapus
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="finishing-row mb-3 p-3 border rounded">
                                                <div class="row g-2">
                                                    <div class="col-8">
                                                        <label class="form-label fw-semibold">Nama Finishing</label>
                                                        <input type="text" name="finishing_name[]" class="form-control" 
                                                               placeholder="Contoh: Laminating Glossy">
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label fw-semibold">Harga</label>
                                                        <input type="number" name="finishing_price[]" class="form-control" 
                                                               placeholder="15000">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-3">
                                        <button type="button" class="btn btn-outline-warning w-100" id="add-finishing">
                                            <i class="bx bx-plus me-2"></i> Tambah Finishing
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex justify-content-end gap-3">
                                <button type="button" class="btn btn-secondary" onclick="clearEditState()">
                                    <i class="bx bx-reset me-2"></i>
                                    Reset Form
                                </button>
                                <button class="btn btn-success btn-lg px-5" type="submit">
                                    <i class="bx {{ $isEditing ? 'bx-edit' : 'bx-save' }} me-2"></i>
                                    {{ $isEditing ? 'Update Produk' : 'Simpan Produk' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Other form cards (categorize, pricing) -->
            <div class="card mb-4" id="categorize-form">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Form Categorize (Coming Soon)</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Feature ini akan segera hadir...</p>
                </div>
            </div>
            
            <div class="card mb-4" id="pricing-form">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Form Pricing (Coming Soon)</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Feature ini akan segera hadir...</p>
                </div>
            </div>

            <!-- Product List -->
            @if ($labels->isEmpty())
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bx bx-info-circle fs-4 me-3"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Belum Ada Data</h6>
                        <p class="mb-0">Mulai dengan menambahkan produk pertama Anda menggunakan tombol di atas.</p>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($labels as $label)
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1 fw-bold">
                                            <i class="bx bx-package me-2"></i>
                                            {{ $label->name }}
                                        </h5>
                                        <p class="mb-0 text-light opacity-75">
                                            @if($label->size)
                                                {{ $label->size }}
                                                @switch($label->unit)
                                                    @case(1) Gram @break
                                                    @case(2) Kilogram @break
                                                    @case(3) cm @break
                                                    @case(4) m @break
                                                    @case(5) m² @break
                                                    @case(6) Lembar @break
                                                    @case(7) Rim @break
                                                    @case(8) pcs @break
                                                @endswitch
                                            @endif
                                        </p>
                                    </div>
                                    <div class="header-actions">
                                        <a href="{{ route('admin.product.index', ['edit' => $label->id]) }}" 
                                           class="text-white" title="Edit Produk">
                                            <i class="bx bx-edit fs-4"></i>
                                        </a>
                                        <span class="text-white btn-delete" 
                                              data-url="{{ route('admin.product.destroy', $label->id) }}"
                                              title="Hapus Produk">
                                            <i class="bx bx-trash fs-4"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Product Description -->
                                    @if($label->desc)
                                        <div class="mb-4 p-3 bg-light rounded">
                                            <h6 class="fw-bold text-primary mb-2">
                                                <i class="bx bx-file-blank me-2"></i>
                                                Deskripsi Produk
                                            </h6>
                                            <p class="mb-0 text-muted">{{ $label->desc }}</p>
                                        </div>
                                    @endif

                                    <!-- Sub Products Table -->
                                    <div class="table-responsive mb-4">
                                        <table class="table table-hover">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th><i class="bx bx-cube me-1"></i> Sub Produk</th>
                                                    <th><i class="bx bx-ruler me-1"></i> Spesifikasi</th>
                                                    <th><i class="bx bx-expand-horizontal me-1"></i> P×L (cm)</th>
                                                    <th><i class="bx bx-package me-1"></i> Unit</th>
                                                    <th><i class="bx bx-trending-down me-1"></i> Min</th>
                                                    <th><i class="bx bx-trending-up me-1"></i> Max</th>
                                                    <th><i class="bx bx-dollar me-1"></i> Harga</th>
                                                    <th><i class="bx bx-image me-1"></i> Gambar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($label->products as $product)
                                                    <tr>
                                                        <td class="fw-semibold">{{ $product->name }}</td>
                                                        <td>{{ $product->additional_size ?: '-' }}</td>
                                                        <td>
                                                            @if($product->long_product && $product->width_product)
                                                                {{ $product->long_product }} × {{ $product->width_product }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>{{ $product->additional_unit ?: '-' }}</td>
                                                        <td>
                                                            @if($product->min_qty)
                                                                <span class="badge bg-success">{{ $product->min_qty }}</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($product->max_qty)
                                                                <span class="badge bg-warning">{{ $product->max_qty }}</span>
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td class="fw-bold text-success">
                                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            @if($product->images->count() > 0)
                                                                <div class="d-flex gap-1">
                                                                    @foreach($product->images->take(4) as $image)
                                                                        <img src="{{ asset('storage/' . $image->image_product) }}" 
                                                                             class="rounded" 
                                                                             style="width: 30px; height: 30px; object-fit: cover;">
                                                                    @endforeach
                                                                    @if($product->images->count() > 4)
                                                                        <span class="badge bg-primary">+{{ $product->images->count() - 3 }}</span>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Finishing Options -->
                                    @if ($label->finishings->isNotEmpty())
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-warning mb-3">
                                                    <i class="bx bx-palette me-2"></i>
                                                    Opsi Finishing
                                                </h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead class="table-warning">
                                                            <tr>
                                                                <th>Nama Finishing</th>
                                                                <th>Harga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($label->finishings as $finishing)
                                                                <tr>
                                                                    <td>{{ $finishing->finishing_name }}</td>
                                                                    <td class="fw-semibold text-success">
                                                                        Rp {{ number_format($finishing->finishing_price, 0, ',', '.') }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/notiflix@3.2.6/dist/notiflix-aio-3.2.6.min.js"></script>


    <script>
        let productIndex = 0;

        // =============================================================================
        // 1. LAYOUT FORM HANDLERS
        // =============================================================================

        document.getElementById("select-layout").addEventListener("click", function() {
            document.getElementById("select-layout").classList.remove("btn-primary");
            document.getElementById("select-layout").classList.add("btn-secondary");
            document.getElementById("standar-form").style.display = "block";
        });

        // Layout button handlers
        document.getElementById("standar-form-button")?.addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("standar-form").style.display = "block";
        });

        document.getElementById("categorize-form-button")?.addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("categorize-form").style.display = "block";
        });

        document.getElementById("pricing-form-button")?.addEventListener("click", function() {
            document.getElementById("layout-form").style.display = "none";
            document.getElementById("pricing-form").style.display = "block";
        });

        document.getElementById("close-layout-form")?.addEventListener("click", function() {
            document.getElementById("select-layout").classList.remove("btn-secondary");
            document.getElementById("select-layout").classList.add("btn-primary");
            document.getElementById("layout-form").style.display = "none";
        });

        document.getElementById("close-standar-form").addEventListener("click", function() {
            document.getElementById("select-layout").classList.remove("btn-secondary");
            document.getElementById("select-layout").classList.add("btn-primary");
            clearEditState();
            document.getElementById("standar-form").style.display = "none";
        });

        // =============================================================================
        // 2. MAIN DOM CONTENT LOADED EVENT
        // =============================================================================

        document.addEventListener("DOMContentLoaded", function() {
            // Set initial state untuk editing
            @if ($isEditing)
                document.getElementById("standar-form").style.display = "block";
                productIndex = {{ count($editingLabel->products ?? []) }};
            @endif

            const productGroup = document.querySelector(".product-group");
            const finishingGroup = document.querySelector(".finishing-group");
            const addFinishing = document.getElementById("add-finishing");
            const addButton = document.getElementById("add-field");

            // =============================================================================
            // 3. FUNCTION UNTUK MEMBUAT ROW PRODUK BARU
            // =============================================================================

            function createRow() {
                const row = document.createElement("div");
                row.className = "product-row";
                row.setAttribute('data-product-index', productIndex);
                
                row.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-secondary mb-0">
                            <i class="bx bx-cube me-2"></i>
                            Sub Produk #${productIndex + 1}
                        </h6>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Sub Produk *</label>
                            <input type="text" name="name[]" class="form-control" required
                                placeholder="Contoh: Banner Indoor 80 gram">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Panjang (cm)</label>
                            <input type="number" name="long_product[]" class="form-control" 
                                placeholder="100">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Lebar (cm)</label>
                            <input type="number" name="width_product[]" class="form-control" 
                                placeholder="70">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Spesifikasi</label>
                            <input type="text" name="additional_size[]" class="form-control" 
                                placeholder="Contoh: 80 gram">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Unit</label>
                            <input type="text" name="additional_unit[]" class="form-control" 
                                placeholder="m²">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Min Qty</label>
                            <input type="number" name="min_qty[]" class="form-control" 
                                placeholder="1">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Max Qty</label>
                            <input type="number" name="max_qty[]" class="form-control" 
                                placeholder="100">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">Harga *</label>
                            <input type="number" name="price[]" class="form-control" required
                                placeholder="50000">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Upload Gambar (Max 4)</label>
                            <input type="file" 
                                name="product_images[${productIndex}][]" 
                                class="form-control image-input" 
                                multiple 
                                accept="image/jpeg,image/png,image/jpg,image/gif" 
                                data-index="${productIndex}"
                                onchange="handleImagePreview(this, ${productIndex})"
                                data-max-files="4">
                            <div class="image-preview-container" data-index="${productIndex}"></div>
                            <small class="text-muted">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB per file.</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Waktu Produksi</label>
                            <input type="text" name="production_time[]" class="form-control" 
                                placeholder="1-2 hari kerja">
                            <div class="helper-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Gunakan ";" untuk enter, "*" untuk bullet points
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Deskripsi Produk</label>
                            <textarea name="description[]" class="form-control" rows="2" 
                                    placeholder="Deskripsi detail produk"></textarea>
                            <div class="helper-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Gunakan ";" untuk enter, "*" untuk bullet points
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Spesifikasi Teknis</label>
                            <textarea name="spesification_desc[]" class="form-control" rows="2" 
                                    placeholder="Spesifikasi teknis detail"></textarea>
                            <div class="helper-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Gunakan ";" untuk enter, "*" untuk bullet points
                            </div>
                        </div>
                    </div>
                `;
                
                productIndex++;
                return row;
            }

            // =============================================================================
            // 4. FUNCTION UNTUK MEMBUAT FINISHING BARU
            // =============================================================================

            function createFinishing() {
                const row = document.createElement("div");
                row.className = "finishing-row mb-3 p-3 border rounded";
                row.innerHTML = `
                    <div class="row g-2">
                        <div class="col-8">
                            <label class="form-label fw-semibold">Nama Finishing</label>
                            <input type="text" name="finishing_name[]" class="form-control" 
                                placeholder="Contoh: Laminating Glossy">
                        </div>
                        <div class="col-4">
                            <label class="form-label fw-semibold">Harga</label>
                            <input type="number" name="finishing_price[]" class="form-control" 
                                placeholder="15000">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-finishing w-100">
                                <i class="bx bx-trash me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                `;
                return row;
            }

            // =============================================================================
            // 5. FUNCTION UNTUK UPDATE INDEKS PRODUK
            // =============================================================================

            function updateProductIndices() {
                const productRows = productGroup.querySelectorAll('.product-row');
                productRows.forEach((row, index) => {
                    // Update data-product-index
                    row.setAttribute('data-product-index', index);
                    
                    // Update name attribute untuk file input
                    const fileInput = row.querySelector('.image-input');
                    if (fileInput) {
                        const currentName = fileInput.getAttribute('name');
                        if (currentName) {
                            const newName = currentName.replace(/\[\d+\]/, `[${index}]`);
                            fileInput.setAttribute('name', newName);
                            fileInput.setAttribute('data-index', index);
                            fileInput.setAttribute('onchange', `handleImagePreview(this, ${index})`);
                        }
                    }
                    
                    // Update preview container
                    const previewContainer = row.querySelector('.image-preview-container');
                    if (previewContainer) {
                        previewContainer.setAttribute('data-index', index);
                    }
                    
                    // Update header
                    const header = row.querySelector('h6');
                    if (header && header.textContent.includes('Sub Produk')) {
                        header.innerHTML = `
                            <i class="bx bx-cube me-2"></i>
                            Sub Produk #${index + 1}
                        `;
                    }
                });
                
                // Update productIndex ke jumlah row yang ada
                productIndex = productRows.length;
            }

            // =============================================================================
            // 6. EVENT LISTENERS
            // =============================================================================

            // Event listener untuk tombol tambah produk
            if (addButton) {
                addButton.addEventListener("click", function() {
                    const newRow = createRow();
                    const finishingItems = document.querySelector('.finishing-items');
                    productGroup.insertBefore(newRow, addButton.closest(".mt-4"));
                });
            }

            // Event listener untuk tombol tambah finishing
            if (addFinishing) {
                addFinishing.addEventListener("click", function() {
                    const newFinishing = createFinishing();
                    const finishingItems = document.querySelector('.finishing-items');
                    finishingItems.appendChild(newFinishing);
                });
            }

            // Event listener untuk hapus produk
            if (productGroup) {
                productGroup.addEventListener("click", function(e) {
                    if (e.target && (e.target.classList.contains("remove-row") || e.target.closest('.remove-row'))) {
                        const row = e.target.closest(".product-row");
                        if (row) {
                            // Konfirmasi sebelum hapus
                            Notiflix.Confirm.show(
                                'Hapus Sub Produk',
                                'Yakin ingin menghapus sub produk ini?',
                                'Ya, Hapus',
                                'Batal',
                                function onOk() {
                                    row.remove();
                                    updateProductIndices();
                                },
                                function onCancel() {},
                                {
                                    width: '320px',
                                    borderRadius: '8px',
                                    titleColor: '#e74c3c',
                                    okButtonBackground: '#e74c3c',
                                }
                            );
                        }
                    }
                });
            }

            // Event listener untuk hapus finishing
            if (finishingGroup) {
                finishingGroup.addEventListener("click", function(e) {
                    if (e.target && (e.target.classList.contains("remove-finishing") || e.target.closest('.remove-finishing'))) {
                        const rowFinishing = e.target.closest(".finishing-row");
                        if (rowFinishing) {
                            Notiflix.Confirm.show(
                                'Hapus Finishing',
                                'Yakin ingin menghapus finishing ini?',
                                'Ya, Hapus',
                                'Batal',
                                function onOk() {
                                    rowFinishing.remove();
                                },
                                function onCancel() {},
                                {
                                    width: '320px',
                                    borderRadius: '8px',
                                    titleColor: '#e74c3c',
                                    okButtonBackground: '#e74c3c',
                                }
                            );
                        }
                    }
                });
            }

            // =============================================================================
            // 7. FORM VALIDATION
            // =============================================================================

            const form = document.querySelector('#standar-form form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const names = form.querySelectorAll('input[name="name[]"]');
                    const prices = form.querySelectorAll('input[name="price[]"]');
                    const nameLabel = form.querySelector('input[name="name_label"]');
                    
                    let isValid = true;
                    let errorMessages = [];
                    
                    // Validasi nama label
                    if (!nameLabel.value.trim()) {
                        isValid = false;
                        errorMessages.push('Nama produk utama wajib diisi.');
                    }
                    
                    // Validasi sub produk
                    names.forEach((nameInput, index) => {
                        if (!nameInput.value.trim()) {
                            isValid = false;
                            errorMessages.push(`Sub Produk #${index + 1}: Nama produk wajib diisi.`);
                        }
                    });
                    
                    prices.forEach((priceInput, index) => {
                        if (!priceInput.value || priceInput.value <= 0) {
                            isValid = false;
                            errorMessages.push(`Sub Produk #${index + 1}: Harga produk wajib diisi dan harus lebih dari 0.`);
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        Notiflix.Report.failure(
                            'Validasi Gagal',
                            errorMessages.join('\n'),
                            'Tutup',
                            {
                                width: '400px',
                                svgSize: '120px',
                            }
                        );
                        return false;
                    }
                });
            }
        });

        // =============================================================================
        // 8. GLOBAL FUNCTIONS UNTUK IMAGE HANDLING
        // =============================================================================

        // Function untuk handle image preview
        function handleImagePreview(input, index) {
            const files = input.files;
            const previewContainer = document.querySelector(`.image-preview-container[data-index="${index}"]`);
            
            if (!previewContainer) {
                console.error('Preview container not found for index:', index);
                return;
            }
            
            // Clear existing new previews (keep existing images)
            const newPreviews = previewContainer.querySelectorAll('.image-preview:not(.existing-image)');
            newPreviews.forEach(preview => preview.remove());
            
            // Validasi maksimal 4 file total
            const existingImages = previewContainer.querySelectorAll('.existing-image').length;
            const totalImages = existingImages + files.length;
            
            if (totalImages > 4) {
                Notiflix.Notify.failure(`Maksimal 4 gambar total. Anda sudah memiliki ${existingImages} gambar, hanya bisa menambah ${4 - existingImages} gambar lagi.`);
                input.value = '';
                return;
            }
            
            // Validasi ukuran file
            for (let file of files) {
                if (file.size > 2 * 1024 * 1024) {
                    Notiflix.Notify.failure(`File ${file.name} terlalu besar. Maksimal 2MB per file.`);
                    input.value = '';
                    return;
                }
            }
            
            // Create preview untuk setiap file
            Array.from(files).forEach((file, fileIndex) => {
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('div');
                        preview.className = 'image-preview new-image';
                        preview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview ${fileIndex + 1}">
                            <button type="button" class="remove-image" onclick="removeImagePreview(this, ${index}, ${fileIndex})">×</button>
                        `;
                        previewContainer.appendChild(preview);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Function untuk remove new image preview
        function removeImagePreview(button, productIndex, fileIndex) {
            const preview = button.closest('.image-preview');
            const input = document.querySelector(`.image-input[data-index="${productIndex}"]`);
            
            if (preview) {
                preview.remove();
            }
            
            // Reset input file jika semua new preview dihapus
            const previewContainer = document.querySelector(`.image-preview-container[data-index="${productIndex}"]`);
            const newImages = previewContainer.querySelectorAll('.new-image');
            if (newImages.length === 0) {
                input.value = '';
            }
        }

        // Function untuk remove existing image pada edit mode
        function removeExistingImage(button, productIndex, imageId) {
            const preview = button.closest('.image-preview');
            const hiddenInput = preview.querySelector('input[type="hidden"]');
            
            if (preview && hiddenInput) {
                Notiflix.Confirm.show(
                    'Hapus Gambar',
                    'Yakin ingin menghapus gambar ini?',
                    'Ya, Hapus',
                    'Batal',
                    function onOk() {
                        // Remove dari tampilan
                        preview.remove();
                        // Hidden input sudah terhapus bersama preview
                    },
                    function onCancel() {},
                    {
                        width: '320px',
                        borderRadius: '8px',
                        titleColor: '#e74c3c',
                        okButtonBackground: '#e74c3c',
                    }
                );
            }
        }

        // =============================================================================
        // 9. CLEAR EDIT STATE FUNCTION
        // =============================================================================

        function clearEditState() {
            const baseUrl = '{{ route('admin.product.index') }}';
            history.replaceState(null, '', baseUrl);
            const form = document.querySelector("#standar-form form");
            if (!form) return;

            const m = form.querySelector('input[name="_method"]');
            if (m) m.remove();

            form.action = '{{ route('admin.product.store') }}';

            form.querySelectorAll('input, textarea, select').forEach(el => {
                if (el.type != 'hidden' && el.name != '_token') {
                    el.value = '';
                }
            });
            
            // Clear all image previews
            form.querySelectorAll('.image-preview-container').forEach(container => {
                container.innerHTML = '';
            });
            
            // Reset productIndex
            productIndex = 1;
            
            Notiflix.Notify.success('Form telah direset');
        }

        // =============================================================================
        // 10. DELETE FUNCTIONALITY
        // =============================================================================

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    Notiflix.Confirm.show(
                        'Hapus Produk',
                        'Yakin ingin menghapus produk ini? Semua data termasuk sub produk dan gambar akan dihapus permanen.',
                        'Ya, Hapus!',
                        'Batal',
                        function onOk() {
                            // Show loading
                            Notiflix.Loading.pulse('Menghapus produk...');
                            
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
                        function onCancel() {
                            Notiflix.Notify.info('Penghapusan dibatalkan');
                        }, 
                        {
                            width: '400px',
                            borderRadius: '8px',
                            titleColor: '#e74c3c',
                            okButtonBackground: '#e74c3c',
                            cancelButtonBackground: '#95a5a6',
                        }
                    );
                });
            });
        });

        // =============================================================================
        // 11. ENHANCED UI INTERACTIONS
        // =============================================================================

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert:not(.alert-info)');
                alerts.forEach(alert => {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                });
            }, 5000);
            
            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Add form field focus animations
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.col-md-12, .col-md-6, .col-md-4, .col-md-3, .col-md-2, .col-8, .col-4, .col-12')
                        ?.style.setProperty('transform', 'scale(1.02)');
                });
                
                input.addEventListener('blur', function() {
                    this.closest('.col-md-12, .col-md-6, .col-md-4, .col-md-3, .col-md-2, .col-8, .col-4, .col-12')
                        ?.style.setProperty('transform', 'scale(1)');
                });
            });
            
            // Add loading state to submit button
            const form = document.querySelector('#standar-form form');
            if (form) {
                form.addEventListener('submit', function() {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Menyimpan...';
                        
                        // Show loading overlay
                        Notiflix.Loading.pulse('Menyimpan produk...');
                    }
                });
            }
        });

        // =============================================================================
        // 12. UTILITY FUNCTIONS
        // =============================================================================

        // Function untuk format angka dengan separator
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Function untuk format input harga real-time
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('input', function(e) {
                if (e.target.name === 'price[]' || e.target.name === 'finishing_price[]') {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value) {
                        e.target.setAttribute('data-raw-value', value);
                    }
                }
            });
        });

        // Function untuk validasi file upload
        function validateImageFile(file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            if (!allowedTypes.includes(file.type)) {
                return { valid: false, message: `File ${file.name} bukan format gambar yang diizinkan.` };
            }
            
            if (file.size > maxSize) {
                return { valid: false, message: `File ${file.name} terlalu besar. Maksimal 2MB.` };
            }
            
            return { valid: true };
        }

        // Initialize tooltips if Bootstrap is loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

        // =============================================================================
        // 13. KEYBOARD SHORTCUTS
        // =============================================================================

        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S untuk save form
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                const submitBtn = document.querySelector('#standar-form button[type="submit"]');
                if (submitBtn && document.getElementById('standar-form').style.display !== 'none') {
                    submitBtn.click();
                }
            }
            
            // Escape untuk close form
            if (e.key === 'Escape') {
                const standarForm = document.getElementById('standar-form');
                if (standarForm && standarForm.style.display !== 'none') {
                    document.getElementById('close-standar-form').click();
                }
            }
        });

        console.log('✅ Product Management System loaded successfully!');
        </script>
@endsection
