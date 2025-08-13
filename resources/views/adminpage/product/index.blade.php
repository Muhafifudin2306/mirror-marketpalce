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
        .badge {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
        }

        .table-secondary {
            opacity: 0.7;
        }

        .header-actions {
            gap: 8px;
        }

        .header-actions .btn {
            width: 36px;
            height: 36px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }

        .header-actions .btn:hover {
            transform: scale(1.1);
        }
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .form-check-input:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
        }

        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }

        .toggle-icon {
            transition: all 0.3s ease;
        }

        .variant-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .variant-category {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .variant-category-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .variant-value-row {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .variant-controls {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-add-variant {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
        }

        .btn-add-variant:hover {
            background: linear-gradient(135deg, #218838, #1abc9c);
            color: white;
        }

        .has-variants-section {
            background: #e8f5e8;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .variant-toggle {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .variant-empty-state {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
            background: #f8f9fa;
            border: 1px dashed #dee2e6;
            border-radius: 8px;
        }

        .availability-toggle {
            transform: scale(0.8);
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
                                {{-- <div class="col-12">
                                    <div class="form-check form-switch" style="background-color: #e8f5e8; padding: 15px; border-radius: 8px; border: 1px solid #c3e6cb;">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                            id="is_live_label" name="is_live_label" value="1" 
                                            {{ old('is_live_label', $editingLabel->is_live ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="is_live_label">
                                            <i class="bx bx-show me-2 text-success toggle-icon"></i>
                                            Tampilkan Kategori Produk di Website
                                        </label>
                                        <small class="text-muted d-block mt-1">
                                            Jika dinonaktifkan, seluruh kategori produk ini tidak akan tampil di website
                                        </small>
                                    </div>
                                </div> --}}
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
                                                        <input type="number" name="price[]" class="form-control product-price" required
                                                               placeholder="50000"
                                                               value="{{ old("price.$i", $prod->price) }}"
                                                               data-product-index="{{ $i }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="has-variants-section">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input variant-toggle-switch" 
                                                                       type="checkbox" role="switch" 
                                                                       id="has_variants_{{ $i }}" 
                                                                       name="has_variants[{{ $i }}]" value="1"
                                                                       data-product-index="{{ $i }}"
                                                                       {{ old("has_variants.{$i}", $prod->has_category ?? 0) ? 'checked' : '' }}>
                                                                <label class="form-check-label variant-toggle" for="has_variants_{{ $i }}">
                                                                    <i class="bx bx-category me-2"></i>
                                                                    Produk ini memiliki varian (ukuran, warna, dll)
                                                                </label>
                                                                <small class="text-muted d-block mt-1">
                                                                    Aktifkan jika produk memiliki pilihan varian seperti ukuran, warna, atau tipe
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="variant-management-container" 
                                                             id="variant_container_{{ $i }}" 
                                                             data-product-index="{{ $i }}"
                                                             style="display: {{ old("has_variants.{$i}", $prod->has_category ?? 0) ? 'block' : 'none' }};">
                                                            
                                                            <div class="variant-section">
                                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                                    <h6 class="fw-bold text-info mb-0">
                                                                        <i class="bx bx-palette me-2"></i>
                                                                        Manajemen Varian
                                                                    </h6>
                                                                    <button type="button" class="btn btn-sm btn-add-variant add-variant-category" 
                                                                            data-product-index="{{ $i }}">
                                                                        <i class="bx bx-plus me-1"></i>
                                                                        Tambah Kategori
                                                                    </button>
                                                                </div>

                                                                <div class="variant-categories-container" data-product-index="{{ $i }}">
                                                                    @if($isEditing && $prod->variants->isNotEmpty())
                                                                        @php
                                                                            $groupedVariants = $prod->variants->groupBy('category');
                                                                        @endphp
                                                                        @foreach($groupedVariants as $category => $variants)
                                                                            <div class="variant-category" data-category="{{ $category }}">
                                                                                <div class="variant-category-header">
                                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                                        <h6 class="fw-semibold mb-0 text-capitalize">
                                                                                            <i class="bx bx-tag me-1"></i>
                                                                                            {{ ucfirst($category) }}
                                                                                        </h6>
                                                                                        <div class="variant-controls">
                                                                                            <button type="button" class="btn btn-sm btn-outline-success add-variant-value" 
                                                                                                    data-product-index="{{ $i }}" data-category="{{ $category }}">
                                                                                                <i class="bx bx-plus"></i>
                                                                                            </button>
                                                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-variant-category">
                                                                                                <i class="bx bx-trash"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="variant-values-container">
                                                                                    @foreach($variants as $variantIndex => $variant)
                                                                                        <div class="variant-value-row">
                                                                                            <div class="row g-2 align-items-center">
                                                                                                <div class="col-md-4">
                                                                                                    <input type="hidden" name="variant_ids[{{ $i }}][]" value="{{ $variant->id }}">
                                                                                                    <input type="hidden" name="variant_categories[{{ $i }}][]" value="{{ $category }}">
                                                                                                    <label class="form-label fw-semibold">Nilai</label>
                                                                                                    <input type="text" 
                                                                                                           name="variant_values[{{ $i }}][]" 
                                                                                                           class="form-control" 
                                                                                                           placeholder="Contoh: Besar, Biru, dll"
                                                                                                           value="{{ old("variant_values.{$i}.{$variantIndex}", $variant->value) }}"
                                                                                                           required>
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label class="form-label fw-semibold">Harga Tambahan</label>
                                                                                                    <input type="number" 
                                                                                                           name="variant_prices[{{ $i }}][]" 
                                                                                                           class="form-control" 
                                                                                                           placeholder="0"
                                                                                                           value="{{ old("variant_prices.{$i}.{$variantIndex}", $variant->price) }}"
                                                                                                           min="0">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label class="form-label fw-semibold">Ketersediaan</label>
                                                                                                    <div class="form-check form-switch availability-toggle">
                                                                                                        <input class="form-check-input variant-availability-checkbox" 
                                                                                                               type="checkbox" role="switch" 
                                                                                                               {{ old("variant_availability.{$i}.{$variantIndex}", $variant->is_available ?? 1) ? 'checked' : '' }}>
                                                                                                        <input type="hidden" 
                                                                                                               name="variant_availability[{{ $i }}][]" 
                                                                                                               value="{{ old("variant_availability.{$i}.{$variantIndex}", $variant->is_available ?? 1) ? '1' : '0' }}"
                                                                                                               class="availability-hidden-input">
                                                                                                        <label class="form-check-label">
                                                                                                            <small>Tersedia</small>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-md-2">
                                                                                                    <label class="form-label fw-semibold">&nbsp;</label>
                                                                                                    <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-variant-value">
                                                                                                        <i class="bx bx-trash"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                        <div class="variant-empty-state">
                                                                            <i class="bx bx-package bx-lg text-muted mb-2"></i>
                                                                            <p class="mb-2">Belum ada kategori varian</p>
                                                                            <small class="text-muted">Klik "Tambah Kategori" untuk menambah varian produk</small>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">Upload Gambar (Max 4)</label>
                                                        <input type="file" 
                                                               name="product_images[{{ $i }}][]" 
                                                               class="form-control image-input" 
                                                               multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" data-index="{{ $i }}"
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
                                                    <div class="col-12">
                                                        <div class="form-check form-switch" style="background-color: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                                            <input type="hidden" name="is_live_product[{{ $i }}]" value="0">
                                                            <input class="form-check-input" type="checkbox" role="switch" 
                                                                id="is_live_product_{{ $i }}" 
                                                                name="is_live_product[{{ $i }}]" value="1" 
                                                                {{ old("is_live_product.{$i}", $prod->is_live ?? true) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-semibold" for="is_live_product_{{ $i }}">
                                                                <i class="bx bx-show me-2 text-success toggle-icon"></i>
                                                                Tampilkan Sub Produk di Website
                                                            </label>
                                                            <small class="text-muted d-block mt-1">
                                                                Nonaktifkan untuk menyembunyikan sub produk ini dari website
                                                            </small>
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
                                                    <input type="number" name="price[]" class="form-control product-price" required
                                                           placeholder="50000" data-product-index="0">
                                                </div>

                                                <div class="col-12">
                                                    <div class="has-variants-section">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input variant-toggle-switch" 
                                                                   type="checkbox" role="switch" 
                                                                   id="has_variants_0" 
                                                                   name="has_variants[0]" value="1"
                                                                   data-product-index="0">
                                                            <label class="form-check-label variant-toggle" for="has_variants_0">
                                                                <i class="bx bx-category me-2"></i>
                                                                Produk ini memiliki varian (ukuran, warna, dll)
                                                            </label>
                                                            <small class="text-muted d-block mt-1">
                                                                Aktifkan jika produk memiliki pilihan varian seperti ukuran, warna, atau tipe
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="variant-management-container" 
                                                         id="variant_container_0" 
                                                         data-product-index="0"
                                                         style="display: none;">
                                                        
                                                        <div class="variant-section">
                                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                                <h6 class="fw-bold text-info mb-0">
                                                                    <i class="bx bx-palette me-2"></i>
                                                                    Manajemen Varian
                                                                </h6>
                                                                <button type="button" class="btn btn-sm btn-add-variant add-variant-category" 
                                                                        data-product-index="0">
                                                                    <i class="bx bx-plus me-1"></i>
                                                                    Tambah Kategori
                                                                </button>
                                                            </div>

                                                            <div class="variant-categories-container" data-product-index="0">
                                                                <div class="variant-empty-state">
                                                                    <i class="bx bx-package bx-lg text-muted mb-2"></i>
                                                                    <p class="mb-2">Belum ada kategori varian</p>
                                                                    <small class="text-muted">Klik "Tambah Kategori" untuk menambah varian produk</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">Upload Gambar (Max 4)</label>
                                                    <input type="file" name="product_images[0][]" 
                                                           class="form-control image-input" 
                                                           multiple accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" data-index="0"
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
                                                <div class="col-12">
                                                    <div class="form-check form-switch" style="background-color: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                                        <input class="form-check-input" type="checkbox" role="switch" 
                                                            id="is_live_product_0" 
                                                            name="is_live_product[0]" value="1" checked>
                                                        <label class="form-check-label fw-semibold" for="is_live_product_0">
                                                            <i class="bx bx-show me-2 text-success toggle-icon"></i>
                                                            Tampilkan Sub Produk di Website
                                                        </label>
                                                        <small class="text-muted d-block mt-1">
                                                            Nonaktifkan untuk menyembunyikan sub produk ini dari website
                                                        </small>
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

                                            @if($label->is_live)
                                                <span class="badge bg-success ms-2">
                                                    <i class="bx bx-show me-1"></i>Live
                                                </span>
                                            @else
                                                <span class="badge bg-danger ms-2">
                                                    <i class="bx bx-hide me-1"></i>Hidden
                                                </span>
                                            @endif
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
                                            <span class="ms-3">
                                                <i class="bx bx-info-circle me-1"></i>
                                                {{ $label->products->where('is_live', true)->count() }}/{{ $label->products->count() }} produk aktif
                                            </span>
                                        </p>
                                    </div>
                                    <div class="header-actions">
                                        <form method="POST" action="{{ route('admin.product.toggle-live', $label->id) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $label->is_live ? 'btn-warning' : 'btn-success' }}" 
                                                    title="{{ $label->is_live ? 'Sembunyikan' : 'Tampilkan' }}">
                                                <i class="bx {{ $label->is_live ? 'bx-hide' : 'bx-show' }}"></i>
                                            </button>
                                        </form>
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
                                                    <th><i class="bx bx-show me-1"></i> Status</th>
                                                    <th><i class="bx bx-category me-1"></i> Varian</th>
                                                    <th><i class="bx bx-ruler me-1"></i> Spesifikasi</th>
                                                    <th><i class="bx bx-expand-horizontal me-1"></i> P×L (cm)</th>
                                                    <th><i class="bx bx-package me-1"></i> Unit</th>
                                                    <th><i class="bx bx-trending-down me-1"></i> Min</th>
                                                    <th><i class="bx bx-trending-up me-1"></i> Max</th>
                                                    <th><i class="bx bx-dollar me-1"></i> Harga</th>
                                                    <th><i class="bx bx-image me-1"></i> Gambar</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($label->products as $product)
                                                    <tr class="{{ !$product->is_live ? 'table-secondary' : '' }}">
                                                        <td class="fw-semibold">
                                                            {{ $product->name }}
                                                            @if(!$product->is_live)
                                                                <span class="badge bg-secondary ms-1">Hidden</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($product->is_live)
                                                                <span class="badge bg-success">
                                                                    <i class="bx bx-show me-1"></i>Live
                                                                </span>
                                                            @else
                                                                <span class="badge bg-danger">
                                                                    <i class="bx bx-hide me-1"></i>Hidden
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($product->has_category && $product->variants->isNotEmpty())
                                                                @php
                                                                    $categories = $product->variants->groupBy('category');
                                                                @endphp
                                                                <div class="d-flex flex-wrap gap-1">
                                                                    @foreach($categories as $category => $variants)
                                                                        <span class="badge bg-info">
                                                                            {{ ucfirst($category) }} ({{ $variants->count() }})
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                                <small class="text-muted d-block mt-1">
                                                                    Total: {{ $product->variants->count() }} varian
                                                                </small>
                                                            @else
                                                                <span class="badge bg-light text-dark">Single Product</span>
                                                            @endif
                                                        </td>
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
                                                        <td class="fw-bold">
                                                            @if($product->has_category && $product->variants->isNotEmpty())
                                                                @php
                                                                    $minVariantPrice = $product->variants->min('price');
                                                                    $maxVariantPrice = $product->variants->max('price');
                                                                    $basePrice = $product->price;
                                                                @endphp
                                                                <span class="text-success">
                                                                    Rp {{ number_format($basePrice + $minVariantPrice, 0, ',', '.') }}
                                                                    @if($minVariantPrice != $maxVariantPrice)
                                                                        - {{ number_format($basePrice + $maxVariantPrice, 0, ',', '.') }}
                                                                    @endif
                                                                </span>
                                                                <small class="d-block text-muted">Base: Rp {{ number_format($basePrice, 0, ',', '.') }}</small>
                                                            @else
                                                                <span class="text-success">
                                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                                </span>
                                                            @endif
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
                                                        <td>
                                                            <!-- Quick Toggle untuk Product -->
                                                            <form method="POST" action="{{ route('admin.product.toggle-product-live', $product->id) }}" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm {{ $product->is_live ? 'btn-warning' : 'btn-success' }}" 
                                                                        title="{{ $product->is_live ? 'Sembunyikan dari Website' : 'Tampilkan di Website' }}">
                                                                    <i class="bx {{ $product->is_live ? 'bx-hide' : 'bx-show' }}"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    
                                                    @if($product->has_category && $product->variants->isNotEmpty())
                                                        <tr class="table-light">
                                                            <td colspan="11">
                                                                <div class="p-2">
                                                                    <small class="fw-semibold text-muted mb-2 d-block">Detail Varian:</small>
                                                                    @php
                                                                        $groupedVariants = $product->variants->groupBy('category');
                                                                    @endphp
                                                                    @foreach($groupedVariants as $category => $variants)
                                                                        <div class="mb-2">
                                                                            <span class="badge bg-secondary me-2">{{ ucfirst($category) }}</span>
                                                                            @foreach($variants as $variant)
                                                                                <span class="badge {{ $variant->is_available ? 'bg-success' : 'bg-danger' }} me-1">
                                                                                    {{ $variant->value }} 
                                                                                    @if($variant->price > 0)
                                                                                        (+{{ number_format($variant->price, 0, ',', '.') }})
                                                                                    @endif
                                                                                    @if(!$variant->is_available)
                                                                                        (Kosong)
                                                                                    @endif
                                                                                </span>
                                                                            @endforeach
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
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
        let variantCounters = {};

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
        // 2. VARIANT MANAGEMENT FUNCTIONS
        // =============================================================================

        function createVariantCategory(productIndex, categoryType = '') {
            const container = document.querySelector(`.variant-categories-container[data-product-index="${productIndex}"]`);
            const emptyState = container.querySelector('.variant-empty-state');
            
            if (emptyState) {
                emptyState.remove();
            }

            const categoryHtml = `
                <div class="variant-category" data-category="${categoryType}">
                    <div class="variant-category-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <h6 class="fw-semibold mb-0 text-capitalize me-3">
                                    <i class="bx bx-tag me-1"></i>
                                    <span class="category-name">${categoryType ? ucfirst(categoryType) : ''}</span>
                                </h6>
                                ${!categoryType ? `
                                    <select class="form-select form-select-sm category-selector" style="width: auto;">
                                        <option value="">Pilih Kategori</option>
                                        <option value="ukuran">Ukuran</option>
                                        <option value="warna">Warna</option>
                                        <option value="varian">Varian</option>
                                    </select>
                                ` : ''}
                            </div>
                            <div class="variant-controls">
                                <button type="button" class="btn btn-sm btn-outline-success add-variant-value" 
                                        data-product-index="${productIndex}" data-category="${categoryType}">
                                    <i class="bx bx-plus"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-variant-category">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="variant-values-container">
                        ${categoryType ? createVariantValue(productIndex, categoryType) : ''}
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', categoryHtml);
            
            const newCategory = container.lastElementChild;
            const categorySelector = newCategory.querySelector('.category-selector');
            if (categorySelector) {
                categorySelector.addEventListener('change', function() {
                    const selectedCategory = this.value;
                    const categoryDiv = this.closest('.variant-category');
                    categoryDiv.setAttribute('data-category', selectedCategory);
                    categoryDiv.querySelector('.category-name').textContent = ucfirst(selectedCategory);
                    
                    const addButton = categoryDiv.querySelector('.add-variant-value');
                    addButton.setAttribute('data-category', selectedCategory);
                    
                    const valuesContainer = categoryDiv.querySelector('.variant-values-container');
                    if (valuesContainer.children.length === 0) {
                        valuesContainer.innerHTML = createVariantValue(productIndex, selectedCategory);
                    }
                    
                    this.style.display = 'none';
                });
            }
        }

        function createVariantValue(productIndex, category) {
            if (!variantCounters[productIndex]) {
                variantCounters[productIndex] = {};
            }
            if (!variantCounters[productIndex][category]) {
                variantCounters[productIndex][category] = 0;
            }
            
            const categoryDiv = document.querySelector(`.variant-category[data-category="${category}"]`);
            const existingValues = categoryDiv.querySelectorAll('.variant-value-row');
            const valueIndex = existingValues.length;
            
            return `
                <div class="variant-value-row">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="hidden" name="variant_categories[${productIndex}][]" value="${category}">
                            <label class="form-label fw-semibold">Nilai</label>
                            <input type="text" 
                                   name="variant_values[${productIndex}][]" 
                                   class="form-control" 
                                   placeholder="Contoh: Besar, Biru, dll"
                                   required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Harga Tambahan</label>
                            <input type="number" 
                                   name="variant_prices[${productIndex}][]" 
                                   class="form-control" 
                                   placeholder="0"
                                   min="0" value="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Ketersediaan</label>
                            <div class="form-check form-switch availability-toggle">
                                <input class="form-check-input variant-availability-checkbox" 
                                       type="checkbox" role="switch" 
                                       checked>
                                <input type="hidden" 
                                       name="variant_availability[${productIndex}][]" 
                                       value="1"
                                       class="availability-hidden-input">
                                <label class="form-check-label">
                                    <small>Tersedia</small>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">&nbsp;</label>
                            <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-variant-value">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function ucfirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // =============================================================================
        // 3. MAIN DOM CONTENT LOADED EVENT
        // =============================================================================

        document.addEventListener("DOMContentLoaded", function() {
            @if ($isEditing)
                document.getElementById("standar-form").style.display = "block";
                productIndex = {{ count($editingLabel->products ?? []) }};
                
                @foreach($editingLabel->products as $i => $prod)
                    variantCounters[{{ $i }}] = {};
                    @if($prod->variants->isNotEmpty())
                        @php $groupedVariants = $prod->variants->groupBy('category'); @endphp
                        @foreach($groupedVariants as $category => $variants)
                            variantCounters[{{ $i }}]['{{ $category }}'] = {{ $variants->count() }};
                        @endforeach
                    @endif
                @endforeach
            @endif

            const productGroup = document.querySelector(".product-group");
            const finishingGroup = document.querySelector(".finishing-group");
            const addFinishing = document.getElementById("add-finishing");
            const addButton = document.getElementById("add-field");

            // =============================================================================
            // 4. VARIANT EVENT LISTENERS
            // =============================================================================

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('variant-availability-checkbox')) {
                    const hiddenInput = e.target.closest('.availability-toggle').querySelector('.availability-hidden-input');
                    if (hiddenInput) {
                        hiddenInput.value = e.target.checked ? '1' : '0';
                    }
                }
            });

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('variant-toggle-switch')) {
                    const productIndex = e.target.dataset.productIndex;
                    const variantContainer = document.getElementById(`variant_container_${productIndex}`);
                    const priceInput = document.querySelector(`input[name="price[]"][data-product-index="${productIndex}"]`);
                    
                    if (e.target.checked) {
                        variantContainer.style.display = 'block';
                        const priceLabel = priceInput.closest('.col-md-2').querySelector('label');
                        priceLabel.innerHTML = 'Harga Base *<small class="d-block text-muted">Harga termurah</small>';
                    } else {
                        variantContainer.style.display = 'none';
                        const priceLabel = priceInput.closest('.col-md-2').querySelector('label');
                        priceLabel.innerHTML = 'Harga *';
                        
                        variantContainer.querySelector('.variant-categories-container').innerHTML = `
                            <div class="variant-empty-state">
                                <i class="bx bx-package bx-lg text-muted mb-2"></i>
                                <p class="mb-2">Belum ada kategori varian</p>
                                <small class="text-muted">Klik "Tambah Kategori" untuk menambah varian produk</small>
                            </div>
                        `;
                    }
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-variant-category') || e.target.closest('.add-variant-category')) {
                    const button = e.target.classList.contains('add-variant-category') ? e.target : e.target.closest('.add-variant-category');
                    const productIndex = button.dataset.productIndex;
                    createVariantCategory(productIndex);
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('add-variant-value') || e.target.closest('.add-variant-value')) {
                    const button = e.target.classList.contains('add-variant-value') ? e.target : e.target.closest('.add-variant-value');
                    const productIndex = button.dataset.productIndex;
                    const category = button.dataset.category;
                    
                    if (!category) {
                        Notiflix.Notify.warning('Pilih kategori terlebih dahulu');
                        return;
                    }
                    
                    const categoryDiv = button.closest('.variant-category');
                    const valuesContainer = categoryDiv.querySelector('.variant-values-container');
                    valuesContainer.insertAdjacentHTML('beforeend', createVariantValue(productIndex, category));
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant-category') || e.target.closest('.remove-variant-category')) {
                    const button = e.target.classList.contains('remove-variant-category') ? e.target : e.target.closest('.remove-variant-category');
                    const categoryDiv = button.closest('.variant-category');
                    
                    Notiflix.Confirm.show(
                        'Hapus Kategori Varian',
                        'Yakin ingin menghapus kategori varian ini beserta semua nilainya?',
                        'Ya, Hapus',
                        'Batal',
                        function onOk() {
                            categoryDiv.remove();
                            
                            const container = categoryDiv.closest('.variant-categories-container');
                            if (container.children.length === 0) {
                                container.innerHTML = `
                                    <div class="variant-empty-state">
                                        <i class="bx bx-package bx-lg text-muted mb-2"></i>
                                        <p class="mb-2">Belum ada kategori varian</p>
                                        <small class="text-muted">Klik "Tambah Kategori" untuk menambah varian produk</small>
                                    </div>
                                `;
                            }
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
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variant-value') || e.target.closest('.remove-variant-value')) {
                    const button = e.target.classList.contains('remove-variant-value') ? e.target : e.target.closest('.remove-variant-value');
                    const valueRow = button.closest('.variant-value-row');
                    
                    Notiflix.Confirm.show(
                        'Hapus Nilai Varian',
                        'Yakin ingin menghapus nilai varian ini?',
                        'Ya, Hapus',
                        'Batal',
                        function onOk() {
                            valueRow.remove();
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
            });

            // =============================================================================
            // 5. EXISTING FUNCTIONS (MODIFIED)
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
                            <input type="number" name="price[]" class="form-control product-price" required
                                placeholder="50000" data-product-index="${productIndex}">
                        </div>

                        <!-- Variant Management Section -->
                        <div class="col-12">
                            <div class="has-variants-section">
                                <div class="form-check form-switch">
                                    <input class="form-check-input variant-toggle-switch" 
                                           type="checkbox" role="switch" 
                                           id="has_variants_${productIndex}" 
                                           name="has_variants[${productIndex}]" value="1"
                                           data-product-index="${productIndex}">
                                    <label class="form-check-label variant-toggle" for="has_variants_${productIndex}">
                                        <i class="bx bx-category me-2"></i>
                                        Produk ini memiliki varian (ukuran, warna, dll)
                                    </label>
                                    <small class="text-muted d-block mt-1">
                                        Aktifkan jika produk memiliki pilihan varian seperti ukuran, warna, atau tipe
                                    </small>
                                </div>
                            </div>

                            <!-- Variant Management Container -->
                            <div class="variant-management-container" 
                                 id="variant_container_${productIndex}" 
                                 data-product-index="${productIndex}"
                                 style="display: none;">
                                
                                <div class="variant-section">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-info mb-0">
                                            <i class="bx bx-palette me-2"></i>
                                            Manajemen Varian
                                        </h6>
                                        <button type="button" class="btn btn-sm btn-add-variant add-variant-category" 
                                                data-product-index="${productIndex}">
                                            <i class="bx bx-plus me-1"></i>
                                            Tambah Kategori
                                        </button>
                                    </div>

                                    <div class="variant-categories-container" data-product-index="${productIndex}">
                                        <div class="variant-empty-state">
                                            <i class="bx bx-package bx-lg text-muted mb-2"></i>
                                            <p class="mb-2">Belum ada kategori varian</p>
                                            <small class="text-muted">Klik "Tambah Kategori" untuk menambah varian produk</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Upload Gambar (Max 4)</label>
                            <input type="file" 
                                name="product_images[${productIndex}][]" 
                                class="form-control image-input" 
                                multiple 
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" 
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
                        <div class="col-12">
                            <div class="form-check form-switch" style="background-color: #f8f9fa; padding: 12px; border-radius: 6px; border: 1px solid #e9ecef;">
                                <input class="form-check-input" type="checkbox" role="switch" 
                                    id="is_live_product_${productIndex}" 
                                    name="is_live_product[${productIndex}]" value="1" checked>
                                <label class="form-check-label fw-semibold" for="is_live_product_${productIndex}">
                                    <i class="bx bx-show me-2 text-success toggle-icon"></i>
                                    Tampilkan Sub Produk di Website
                                </label>
                                <small class="text-muted d-block mt-1">
                                    Nonaktifkan untuk menyembunyikan sub produk ini dari website
                                </small>
                            </div>
                        </div>
                    </div>
                `;
                
                variantCounters[productIndex] = {};
                productIndex++;
                return row;
            }

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
            // 6. FUNCTION UNTUK UPDATE INDEKS PRODUK
            // =============================================================================

            function updateProductIndices() {
                const productRows = productGroup.querySelectorAll('.product-row');
                productRows.forEach((row, index) => {
                    row.setAttribute('data-product-index', index);
                    
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
                    
                    const previewContainer = row.querySelector('.image-preview-container');
                    if (previewContainer) {
                        previewContainer.setAttribute('data-index', index);
                    }
                    
                    const header = row.querySelector('h6');
                    if (header && header.textContent.includes('Sub Produk')) {
                        header.innerHTML = `
                            <i class="bx bx-cube me-2"></i>
                            Sub Produk #${index + 1}
                        `;
                    }

                    const variantToggle = row.querySelector('.variant-toggle-switch');
                    if (variantToggle) {
                        variantToggle.setAttribute('id', `has_variants_${index}`);
                        variantToggle.setAttribute('name', `has_variants[${index}]`);
                        variantToggle.setAttribute('data-product-index', index);
                        
                        const label = row.querySelector(`label[for^="has_variants_"]`);
                        if (label) {
                            label.setAttribute('for', `has_variants_${index}`);
                        }
                    }

                    const variantContainer = row.querySelector('.variant-management-container');
                    if (variantContainer) {
                        variantContainer.setAttribute('id', `variant_container_${index}`);
                        variantContainer.setAttribute('data-product-index', index);
                    }

                    const addCategoryBtn = row.querySelector('.add-variant-category');
                    if (addCategoryBtn) {
                        addCategoryBtn.setAttribute('data-product-index', index);
                    }

                    const categoriesContainer = row.querySelector('.variant-categories-container');
                    if (categoriesContainer) {
                        categoriesContainer.setAttribute('data-product-index', index);
                    }

                    const priceInput = row.querySelector('.product-price');
                    if (priceInput) {
                        priceInput.setAttribute('data-product-index', index);
                    }

                    const liveToggle = row.querySelector(`input[id^="is_live_product_"]`);
                    if (liveToggle) {
                        liveToggle.setAttribute('id', `is_live_product_${index}`);
                        liveToggle.setAttribute('name', `is_live_product[${index}]`);
                        
                        const liveLabel = row.querySelector(`label[for^="is_live_product_"]`);
                        if (liveLabel) {
                            liveLabel.setAttribute('for', `is_live_product_${index}`);
                        }
                    }
                });
                
                productIndex = productRows.length;
            }

            // =============================================================================
            // 7. EVENT LISTENERS
            // =============================================================================

            if (addButton) {
                addButton.addEventListener("click", function() {
                    const newRow = createRow();
                    const finishingItems = document.querySelector('.finishing-items');
                    productGroup.insertBefore(newRow, addButton.closest(".mt-4"));
                });
            }

            if (addFinishing) {
                addFinishing.addEventListener("click", function() {
                    const newFinishing = createFinishing();
                    const finishingItems = document.querySelector('.finishing-items');
                    finishingItems.appendChild(newFinishing);
                });
            }

            if (productGroup) {
                productGroup.addEventListener("click", function(e) {
                    if (e.target && (e.target.classList.contains("remove-row") || e.target.closest('.remove-row'))) {
                        const row = e.target.closest(".product-row");
                        if (row) {
                            Notiflix.Confirm.show(
                                'Hapus Sub Produk',
                                'Yakin ingin menghapus sub produk ini beserta semua variannya?',
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
            // 8. FORM VALIDATION
            // =============================================================================

            const form = document.querySelector('#standar-form form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const names = form.querySelectorAll('input[name="name[]"]');
                    const prices = form.querySelectorAll('input[name="price[]"]');
                    const nameLabel = form.querySelector('input[name="name_label"]');
                    
                    let isValid = true;
                    let errorMessages = [];
                    
                    if (!nameLabel.value.trim()) {
                        isValid = false;
                        errorMessages.push('Nama produk utama wajib diisi.');
                    }
                    
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

                    const variantToggles = form.querySelectorAll('.variant-toggle-switch:checked');
                    variantToggles.forEach((toggle, toggleIndex) => {
                        const productIndex = toggle.dataset.productIndex;
                        const container = document.querySelector(`.variant-categories-container[data-product-index="${productIndex}"]`);
                        const categories = container.querySelectorAll('.variant-category');
                        
                        if (categories.length === 0) {
                            isValid = false;
                            errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Jika menggunakan varian, minimal harus ada 1 kategori varian.`);
                        } else {
                            categories.forEach((categoryDiv, catIndex) => {
                                const category = categoryDiv.dataset.category;
                                const values = categoryDiv.querySelectorAll('.variant-value-row');
                                
                                if (!category) {
                                    isValid = false;
                                    errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Pilih kategori untuk semua varian.`);
                                }
                                
                                if (values.length === 0) {
                                    isValid = false;
                                    errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Kategori ${category} harus memiliki minimal 1 nilai.`);
                                } else {
                                    values.forEach((valueRow, valueIndex) => {
                                        const valueInput = valueRow.querySelector('input[name^="variant_values"]');
                                        if (!valueInput.value.trim()) {
                                            isValid = false;
                                            errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Nilai varian ${category} tidak boleh kosong.`);
                                        }
                                    });
                                }
                            });
                        }
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                        
                        // Reset loading state
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="bx bx-save me-2"></i>Simpan Produk';
                        }
                        Notiflix.Loading.remove(); // Hapus loading overlay
                        
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
        // 9. GLOBAL FUNCTIONS UNTUK IMAGE HANDLING
        // =============================================================================

        function handleImagePreview(input, index) {
            const files = input.files;
            const previewContainer = document.querySelector(`.image-preview-container[data-index="${index}"]`);
            
            if (!previewContainer) {
                console.error('Preview container not found for index:', index);
                return;
            }
            
            const newPreviews = previewContainer.querySelectorAll('.image-preview:not(.existing-image)');
            newPreviews.forEach(preview => preview.remove());
            
            const existingImages = previewContainer.querySelectorAll('.existing-image').length;
            const totalImages = existingImages + files.length;
            
            if (totalImages > 4) {
                Notiflix.Notify.failure(`Maksimal 4 gambar total. Anda sudah memiliki ${existingImages} gambar, hanya bisa menambah ${4 - existingImages} gambar lagi.`);
                input.value = '';
                return;
            }
            
            for (let file of files) {
                if (file.size > 2 * 1024 * 1024) {
                    Notiflix.Notify.failure(`File ${file.name} terlalu besar. Maksimal 2MB per file.`);
                    input.value = '';
                    return;
                }
            }
            
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

        function removeImagePreview(button, productIndex, fileIndex) {
            const preview = button.closest('.image-preview');
            const input = document.querySelector(`.image-input[data-index="${productIndex}"]`);
            
            if (preview) {
                preview.remove();
            }
            
            const previewContainer = document.querySelector(`.image-preview-container[data-index="${productIndex}"]`);
            const newImages = previewContainer.querySelectorAll('.new-image');
            if (newImages.length === 0) {
                input.value = '';
            }
        }

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
                        preview.remove();
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
        // 10. CLEAR EDIT STATE FUNCTION
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
                    if (el.type === 'checkbox') {
                        el.checked = el.name.includes('is_live') ? true : false;
                    } else {
                        el.value = '';
                    }
                }
            });
            
            form.querySelectorAll('.image-preview-container').forEach(container => {
                container.innerHTML = '';
            });

            form.querySelectorAll('.variant-categories-container').forEach(container => {
                container.innerHTML = `
                    <div class="variant-empty-state">
                        <i class="bx bx-package bx-lg text-muted mb-2"></i>
                        <p class="mb-2">Belum ada kategori varian</p>
                        <small class="text-muted">Klik "Tambah Kategori" untuk menambah varian produk</small>
                    </div>
                `;
            });

            form.querySelectorAll('.variant-management-container').forEach(container => {
                container.style.display = 'none';
            });
            
            productIndex = 1;
            variantCounters = {};
            
            Notiflix.Notify.success('Form telah direset');
        }

        // =============================================================================
        // 11. DELETE FUNCTIONALITY
        // =============================================================================

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    const url = this.dataset.url;
                    Notiflix.Confirm.show(
                        'Hapus Produk',
                        'Yakin ingin menghapus produk ini? Semua data termasuk sub produk, varian, dan gambar akan dihapus permanen.',
                        'Ya, Hapus!',
                        'Batal',
                        function onOk() {
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
        // 12. ENHANCED UI INTERACTIONS
        // =============================================================================

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert:not(.alert-info)');
                alerts.forEach(alert => {
                    if (alert.querySelector('.btn-close')) {
                        alert.querySelector('.btn-close').click();
                    }
                });
            }, 5000);
            
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
        
            const form = document.querySelector('#standar-form form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        const names = form.querySelectorAll('input[name="name[]"]');
                        const prices = form.querySelectorAll('input[name="price[]"]');
                        const nameLabel = form.querySelector('input[name="name_label"]');
                        
                        let isValid = true;
                        let errorMessages = [];
                        
                        if (!nameLabel.value.trim()) {
                            isValid = false;
                            errorMessages.push('Nama produk utama wajib diisi.');
                        }
                        
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

                        const variantToggles = form.querySelectorAll('.variant-toggle-switch:checked');
                        variantToggles.forEach((toggle, toggleIndex) => {
                            const productIndex = toggle.dataset.productIndex;
                            const container = document.querySelector(`.variant-categories-container[data-product-index="${productIndex}"]`);
                            const categories = container.querySelectorAll('.variant-category');
                            
                            if (categories.length === 0) {
                                isValid = false;
                                errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Jika menggunakan varian, minimal harus ada 1 kategori varian.`);
                            } else {
                                categories.forEach((categoryDiv, catIndex) => {
                                    const category = categoryDiv.dataset.category;
                                    const values = categoryDiv.querySelectorAll('.variant-value-row');
                                    
                                    if (!category) {
                                        isValid = false;
                                        errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Pilih kategori untuk semua varian.`);
                                    }
                                    
                                    if (values.length === 0) {
                                        isValid = false;
                                        errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Kategori ${category} harus memiliki minimal 1 nilai.`);
                                    } else {
                                        values.forEach((valueRow, valueIndex) => {
                                            const valueInput = valueRow.querySelector('input[name^="variant_values"]');
                                            if (!valueInput.value.trim()) {
                                                isValid = false;
                                                errorMessages.push(`Sub Produk #${parseInt(productIndex) + 1}: Nilai varian ${category} tidak boleh kosong.`);
                                            }
                                        });
                                    }
                                });
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
                        
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Menyimpan...';
                            
                            Notiflix.Loading.pulse('Menyimpan produk...');
                        }
                    });
                }
        });

        // =============================================================================
        // 13. UTILITY FUNCTIONS
        // =============================================================================

        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('input', function(e) {
                if (e.target.name === 'price[]' || e.target.name === 'finishing_price[]' || e.target.name && e.target.name.includes('variant_prices')) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value) {
                        e.target.setAttribute('data-raw-value', value);
                    }
                }
            });
        });

        function validateImageFile(file) {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;
            
            if (!allowedTypes.includes(file.type)) {
                return { valid: false, message: `File ${file.name} bukan format gambar yang diizinkan.` };
            }
            
            if (file.size > maxSize) {
                return { valid: false, message: `File ${file.name} terlalu besar. Maksimal 2MB.` };
            }
            
            return { valid: true };
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap !== 'undefined') {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });

        // =============================================================================
        // 14. KEYBOARD SHORTCUTS
        // =============================================================================

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                const submitBtn = document.querySelector('#standar-form button[type="submit"]');
                if (submitBtn && document.getElementById('standar-form').style.display !== 'none') {
                    submitBtn.click();
                }
            }
            
            if (e.key === 'Escape') {
                const standarForm = document.getElementById('standar-form');
                if (standarForm && standarForm.style.display !== 'none') {
                    document.getElementById('close-standar-form').click();
                }
            }
        });

        console.log('✅ Product Management System with Variants loaded successfully!');
        
        document.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox' && e.target.name && 
                (e.target.name === 'is_live_label' || e.target.name.includes('is_live_product'))) {
                
                const icon = e.target.closest('.form-check').querySelector('.toggle-icon');
                if (e.target.checked) {
                    icon.className = 'bx bx-show me-2 text-success toggle-icon';
                } else {
                    icon.className = 'bx bx-hide me-2 text-danger toggle-icon';
                }
            }
        });
    </script>
@endsection