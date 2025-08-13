@extends('landingpage.index')
@section('add-link')
<script type="text/javascript" 
  src="https://app.midtrans.com/snap/snap.js"
  data-client-key="{{ config('midtrans.client_key') }}">
</script> 

     {{--<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>--}}
        
@endsection
@section('content')
    <style>
        .form-control {
            border-radius: 50px !important;
            height: 55px;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .form-control::placeholder {
            padding: 0 10px;
            color: #c3c3c3;
            opacity: 1;
        }

        .form-control:disabled {
            background-color: #fff !important;
            color: #c3c3c3;
            opacity: 1 !important;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        .edit-btn {
            border-radius: 0.25rem !important;
        }

        .sidebar-filter a {
            display: block !important;
            font-family: 'Poppins', sans-serif !important;
            background-color: #fff !important;
            color: #666 !important;
            border-radius: 50px !important;
            padding: 8px 20px !important;
            margin-bottom: 8px !important;
            position: relative !important;
            overflow: hidden !important;
            transition: all .3s !important;
            width: 100% !important;
            text-align: left !important;
            text-decoration: none !important;
            cursor: pointer !important;
        }

        .sidebar-filter a:hover {
            padding-right: 40px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            color: #000 !important;
        }

        .sidebar-filter a.active {
            background-color: #f1f7ff !important;
            color: #000 !important;
        }

        .sidebar-filter a.active::after {
            content: '' !important;
            position: absolute !important;
            width: 10px !important;
            height: 10px !important;
            background-color: #0439a0 !important;
            top: 50% !important;
            right: 12px !important;
            transform: translateY(-50%) rotate(45deg) !important;
        }

        .sidebar-filter .nav-link::before {
            display: none !important;
        }

        .section-pill {
            display: block;
            width: 100%;
            text-align: left;
            font-family: 'Poppins', sans-serif !important;
            background-color: #f1f7ff;
            color: #0439a0;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.6rem;
            margin-bottom: 16px;
        }

        .is-invalid {
            border-color: #fc2865 !important;
        }

        .invalid-feedback {
            display: block;
            color: #fc2865;
            font-size: 0.8rem;
            font-weight: 200;
        }

        .btn-edit-text {
            display: inline-block;
            padding: 6px 12px;
            font-size: 16px;
            font-weight: 550;
            color: #444444;
            background-color: #fff;
            font-family: 'Poppins', sans-serif !important;
            border: none;
            text-decoration: none !important;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-edit-text:hover {
            color: #0439a0;
        }

        .btn-save {
            background-color: #0258d3;
            color: white;
            padding: 13px 14px;
            font-size: 18px;
            margin-top: 24px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save:hover {
            background-color: #0258d3;
            color: white;
        }

        .btn-cancel {
            background: none;
            border: none;
            color: #888;
            font-size: 13px;
            margin-top: 18px;
            text-decoration: underline;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            padding: 0;
            display: inline;
            width: auto;
            cursor: pointer;
        }

        .btn-cancel:hover {
            color: #444;
            text-decoration: underline;
        }

        .input-edit {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .input-edit:focus {
            border-color: #80bdff;
            outline: none;
        }

        .field-label {
            font-weight: bold;
            margin-bottom: 4px;
            display: inline-block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-order {
            background-color: #0258d3;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
            width: 100%;
        }

        .btn-order:hover {
            background-color: #0439a0;
            color: white;
        }

        .btn-order:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0258d3;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .checkout-page .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .checkout-page .card h5 {
            margin-bottom: 1rem;
        }
        #promoCodeInput::placeholder {
            color: #999;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }
        .form-control {
            border-radius: 50px !important;
            height: 55px;
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .form-control::placeholder {
            padding: 0 10px;
            color: #c3c3c3;
            opacity: 1;
        }

        .form-control:disabled {
            background-color: #fff !important;
            color: #c3c3c3;
            opacity: 1 !important;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
            color: #444;
        }

        .edit-btn {
            border-radius: 0.25rem !important;
        }

        .sidebar-filter a {
            display: block !important;
            font-family: 'Poppins', sans-serif !important;
            background-color: #fff !important;
            color: #666 !important;
            border-radius: 50px !important;
            padding: 8px 20px !important;
            margin-bottom: 8px !important;
            position: relative !important;
            overflow: hidden !important;
            transition: all .3s !important;
            width: 100% !important;
            text-align: left !important;
            text-decoration: none !important;
            cursor: pointer !important;
        }

        .sidebar-filter a:hover {
            padding-right: 40px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            color: #000 !important;
        }

        .sidebar-filter a.active {
            background-color: #f1f7ff !important;
            color: #000 !important;
        }

        .sidebar-filter a.active::after {
            content: '' !important;
            position: absolute !important;
            width: 10px !important;
            height: 10px !important;
            background-color: #0439a0 !important;
            top: 50% !important;
            right: 12px !important;
            transform: translateY(-50%) rotate(45deg) !important;
        }

        .sidebar-filter .nav-link::before {
            display: none !important;
        }

        .section-pill {
            display: block;
            width: 100%;
            text-align: left;
            font-family: 'Poppins', sans-serif !important;
            background-color: #f1f7ff;
            color: #0439a0;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 1.6rem;
            margin-bottom: 16px;
        }

        .is-invalid {
            border-color: #fc2865 !important;
        }

        .invalid-feedback {
            display: block;
            color: #fc2865;
            font-size: 0.8rem;
            font-weight: 200;
        }

        .btn-edit-text {
            display: inline-block;
            padding: 6px 12px;
            font-size: 16px;
            font-weight: 550;
            color: #444444;
            background-color: #fff;
            font-family: 'Poppins', sans-serif !important;
            border: none;
            text-decoration: none !important;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-edit-text:hover {
            color: #0439a0;
        }

        .btn-save {
            background-color: #0258d3;
            color: white;
            padding: 13px 14px;
            font-size: 18px;
            margin-top: 24px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn-save:hover {
            background-color: #0258d3;
            color: white;
        }

        .btn-cancel {
            background: none;
            border: none;
            color: #888;
            font-size: 13px;
            margin-top: 18px;
            text-decoration: underline;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            padding: 0;
            display: inline;
            width: auto;
            cursor: pointer;
        }

        .btn-cancel:hover {
            color: #444;
            text-decoration: underline;
        }

        .input-edit {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        .input-edit:focus {
            border-color: #80bdff;
            outline: none;
        }

        .field-label {
            font-weight: bold;
            margin-bottom: 4px;
            display: inline-block;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-order {
            background-color: #0258d3;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            font-family: 'Poppins', sans-serif;
            width: 100%;
        }

        .btn-order:hover {
            background-color: #0439a0;
            color: white;
        }

        .btn-order:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #0258d3;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .checkout-page .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .checkout-page .card h5 {
            margin-bottom: 1rem;
        }

        #promoCodeInput::placeholder {
            color: #999;
            font-size: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }

        select option:disabled {
            color: #999 !important;
            background-color: #f8f9fa !important;
            font-style: italic;
        }

        .address-link {
            color: #0258d3;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .address-link:hover {
            color: #0041a8;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .whatsapp-float {
                display: none !important;
            }

            .container.product-card {
                margin-top: -60px !important;
                padding: 0 15px !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .row.g-5 {
                margin: 0 !important;
                gap: 0 !important;
                flex-direction: column !important;
                width: 100% !important;
            }

            .col-lg-8 {
                margin-left: 0 !important;
                padding: 0 15px !important;
                margin-bottom: 20px;
                order: 1;
                max-width: 100% !important;
                width: 100% !important;
            }

            .col-lg-3 {
                padding: 0 15px !important;
                order: 2;
                position: fixed !important;
                bottom: 0 !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 99999 !important;
                background: white !important;
                box-shadow: 0 -4px 20px rgba(0,0,0,0.15) !important;
                border-top: 2px solid #e9ecef !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .col-lg-3 .card {
                width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
                background: transparent !important;
                padding: 15px !important;
            }

            .section-pill {
                font-size: 1.2rem !important;
                padding: 12px 20px !important;
                margin-bottom: 12px !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .form-control {
                height: 50px !important;
                font-size: 14px !important;
                width: 100% !important;
            }

            .form-label {
                font-size: 0.75rem !important;
                margin-bottom: 5px !important;
            }
            .mobile-billing-summary {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 15px;
                margin-bottom: 12px;
                border: 1px solid #e9ecef;
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .mobile-product-info {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 12px;
                width: 100% !important;
            }

            .mobile-product-image {
                width: 60px;
                height: 60px;
                border-radius: 8px;
                object-fit: cover;
                flex-shrink: 0;
                border: 1px solid #e9ecef;
            }

            .mobile-product-details {
                flex: 1;
                min-width: 0;
            }

            .mobile-product-details h6 {
                font-size: 13px !important;
                font-weight: 600 !important;
                margin-bottom: 4px !important;
                line-height: 1.3;
                color: #333;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .mobile-product-details small {
                font-size: 11px !important;
                color: #666 !important;
                display: block;
                line-height: 1.2;
            }

            .mobile-product-price {
                font-size: 13px !important;
                font-weight: 600 !important;
                color: #0258d3 !important;
                text-align: right;
                white-space: nowrap;
            }

            .mobile-cost-breakdown {
                border-top: 1px solid #dee2e6;
                padding-top: 10px;
                width: 100% !important;
            }

            .mobile-cost-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 6px;
                font-size: 12px !important;
                font-family: 'Poppins', sans-serif;
                width: 100% !important;
            }

            .mobile-cost-item.total {
                font-weight: 600 !important;
                font-size: 14px !important;
                border-top: 1px solid #dee2e6;
                padding-top: 6px;
                margin-top: 6px;
                color: #0258d3;
            }

            .mobile-cost-item.discount {
                color: #dc3545 !important;
            }

            .btn-order {
                font-size: 14px !important;
                padding: 12px 20px !important;
                margin: 10px 0 5px 0 !important;
                border-radius: 8px !important;
                font-weight: 600;
                width: 100% !important;
            }
            .mobile-promo-section {
                margin-top: 20px;
                padding: 15px;
                background: #f8f9fa;
                border-radius: 12px;
                border: 1px solid #e9ecef;
                margin-left: 0 !important;
                margin-right: 0 !important;
                width: 100% !important;
                box-sizing: border-box;
            }

            .mobile-promo-section .form-label {
                font-size: 13px !important;
                margin-bottom: 8px !important;
                color: #333;
                font-weight: 600;
                display: block;
                width: 100%;
            }

            .mobile-promo-section .input-group {
                width: 100% !important;
                display: flex !important;
                flex-wrap: nowrap !important;
                align-items: stretch !important;
            }

            .mobile-promo-section .input-group input {
                font-size: 13px !important;
                height: 42px !important;
                border-radius: 8px 0 0 8px !important;
                flex: 1 !important;
                width: auto !important;
                min-width: 0 !important;
                border-right: 0 !important;
            }

            .mobile-promo-section .input-group button {
                font-size: 12px !important;
                padding: 8px 12px !important;
                border-radius: 0 8px 8px 0 !important;
                white-space: nowrap !important;
                flex-shrink: 0 !important;
                width: auto !important;
                border-left: 0 !important;
            }

            .mobile-promo-section small {
                font-size: 11px !important;
                margin-top: 5px !important;
                display: block;
                width: 100%;
            }

            main {
                padding-bottom: 160px !important;
                width: 100% !important;
                overflow-x: hidden !important;
            }

            .cta-overlay h3 {
                font-size: 2rem !important;
                margin-bottom: 10px !important;
            }

            .breadcrumb {
                font-size: 0.75rem !important;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                font-size: 0.75rem !important;
            }

            .col-md-6, .col-md-12 {
                margin-bottom: 15px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                max-width: 100% !important;
                width: 100% !important;
            }

            .row {
                margin-left: -15px !important;
                margin-right: -15px !important;
                width: calc(100% + 30px) !important;
            }

            .form-group {
                margin-bottom: 15px !important;
                width: 100% !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .whatsapp-float {
                bottom: 180px !important;
                z-index: 999 !important;
            }

            .container-fluid.copyright {
                display: none !important;
            }
            
            .container-fluid.footer .container.py-4 {
                display: none !important;
            }

            body {
                overflow-x: hidden !important;
            }

            .cta-overlay {
                top: 55% !important;
            }
        }

        @media (max-width: 480px) {
            .whatsapp-float {
                display: none !important;
            }
            .container.product-card {
                margin-top: -40px !important;
                padding: 0 10px !important;
            }

            .col-lg-8 {
                padding: 0 10px !important;
            }

            .col-lg-3 {
                padding: 0 10px !important;
            }

            .col-lg-3 .card {
                padding: 10px !important;
            }

            .section-pill {
                font-size: 1.1rem !important;
                padding: 10px 15px !important;
            }

            .form-control {
                height: 45px !important;
                font-size: 13px !important;
            }

            .cta-overlay h3 {
                font-size: 1.7rem !important;
            }

            .mobile-product-image {
                width: 50px;
                height: 50px;
            }

            .mobile-product-details h6 {
                font-size: 12px !important;
            }

            .mobile-cost-item {
                font-size: 11px !important;
            }

            .mobile-cost-item.total {
                font-size: 13px !important;
            }

            main {
                padding-bottom: 180px !important;
            }

            .whatsapp-float {
                bottom: 200px !important;
            }

            .col-md-6, .col-md-12 {
                padding-left: 10px !important;
                padding-right: 10px !important;
            }

            .row {
                margin-left: -10px !important;
                margin-right: -10px !important;
                width: calc(100% + 20px) !important;
            }
        }

        @media (min-width: 769px) {
            .container-fluid.footer .container.py-4,
            .container-fluid.copyright {
                display: block !important;
            }
        }
        .form-check-input:checked {
            background-color: #0258d3;
            border-color: #0258d3;
        }

        .form-check-label {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            font-weight: 500;
            color: #444;
            cursor: pointer;
        }

        #custom-address-section .form-control,
        #custom-address-section .form-select {
            border: 1px solid #ddd;
            transition: border-color 0.2s ease;
        }

        #custom-address-section .form-control:focus,
        #custom-address-section .form-select:focus {
            border-color: #0258d3;
            box-shadow: 0 0 0 0.2rem rgba(2, 88, 211, 0.25);
        }
        textarea.form-control {
            border-radius: 20px !important;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }
        .address-option-container {
            margin-bottom: 24px;
        }

        .address-radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }

        .modern-radio {
            position: relative;
            display: flex;
            align-items: center;
            padding: 16px 20px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 200px;
        }

        .modern-radio:hover {
            background: #e3f2fd;
            border-color: #0258d3;
            box-shadow: 0 4px 12px rgba(2, 88, 211, 0.15);
        }

        .modern-radio.active {
            background: linear-gradient(135deg, #0258d3 0%, #0439a0 100%);
            border-color: #0258d3;
            color: white;
            box-shadow: 0 6px 20px rgba(2, 88, 211, 0.25);
        }

        .modern-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .radio-indicator {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            margin-right: 12px;
            position: relative;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .modern-radio:hover .radio-indicator {
            border-color: #0258d3;
        }

        .modern-radio.active .radio-indicator {
            border-color: white;
            background: white;
        }

        .radio-indicator::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            width: 8px;
            height: 8px;
            background: #0258d3;
            border-radius: 50%;
            transition: transform 0.2s ease;
        }

        .modern-radio.active .radio-indicator::after {
            transform: translate(-50%, -50%) scale(1);
        }

        .radio-content {
            flex: 1;
        }

        .radio-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 4px;
            color: #444;
            transition: color 0.3s ease;
        }

        .modern-radio.active .radio-title {
            color: white;
        }

        .radio-description {
            font-family: 'Poppins', sans-serif;
            font-size: 0.75rem;
            color: #666;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .modern-radio.active .radio-description {
            color: rgba(255, 255, 255, 0.9);
        }

        .radio-icon {
            width: 24px;
            height: 24px;
            margin-left: 12px;
            opacity: 0.6;
            transition: opacity 0.3s ease;
            flex-shrink: 0;
        }

        .modern-radio.active .radio-icon {
            opacity: 1;
            filter: brightness(0) invert(1);
        }

        /* Address Fields Animation */
        .address-fields-container {
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: top;
        }

        .address-fields-container.hidden {
            max-height: 0;
            opacity: 0;
            transform: translateY(-20px);
            margin-bottom: 0;
        }

        .address-fields-container.visible {
            max-height: 1000px;
            opacity: 1;
            transform: translateY(0);
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .address-radio-group {
                flex-direction: column;
                gap: 12px;
            }
            
            .modern-radio {
                min-width: unset;
                padding: 14px 16px;
            }
            
            .radio-title {
                font-size: 0.85rem;
            }
            
            .radio-description {
                font-size: 0.7rem;
            }
            
            .radio-icon {
                width: 20px;
                height: 20px;
            }
        }

        /* Profile incomplete notice styling */
        .profile-incomplete-notice {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 16px;
            margin: 16px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile-incomplete-notice .icon {
            color: #856404;
            font-size: 1.2rem;
        }

        .profile-incomplete-notice .content {
            flex: 1;
        }

        .profile-incomplete-notice .title {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            color: #856404;
            margin-bottom: 4px;
        }

        .profile-incomplete-notice .description {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            color: #856404;
            margin-bottom: 8px;
        }

        .profile-incomplete-notice .link {
            color: #0258d3;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.8rem;
            transition: color 0.2s ease;
        }

        .profile-incomplete-notice .link:hover {
            color: #0439a0;
            text-decoration: underline;
        }
    </style>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

    <div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="position-relative mb-0">
            <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
            <div class="position-absolute start-0 translate-middle-y cta-overlay" style="left: 5%; width: 90%;">
                <!-- WRAPPER BARU untuk greeting + logout -->
                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                    <h3 class="mb-0" style="font-family:'Poppins'; font-size:3.3rem; font-weight:550; color:#fff;">
                        Checkout Produk
                    </h3>
                </div>

                <!-- Breadcrumb tetap di bawah -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0" style="font-family:'Poppins'; font-size:0.85rem; font-weight:500;">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">BERANDA</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/products') }}">SEMUA PRODUK</a></li>
                        <li class="breadcrumb-item active" aria-current="page">CHECKOUT</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <main>
        <div class="container-fluid px-4">
            <div class="container product-card" style="margin-top:-150px;">
                <div class="row g-5" style="margin-top:5px;">

                    <div class="col-lg-8" style="margin-left:40px;">
                        <div class="tab-content" id="sidebarTabsContent">
                            {{-- Profil Saya --}}
                            <div class="tab-pane fade show active" id="pane-profile" role="tabpanel">
                                <form id="formProfile" method="POST" action="{{ route('profile.update') }}">
                                    @csrf

                                    {{-- Informasi Pribadi --}}
                                    <h4 class="section-pill">Informasi Pribadi</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NAMA DEPAN</label>
                                            <input name="first_name" type="text"
                                                class="form-control @error('first_name') is-invalid @enderror"
                                                value="{{ old('first_name', Auth::user()->first_name) }}" disabled>
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NAMA BELAKANG</label>
                                            <input name="last_name" type="text"
                                                class="form-control @error('last_name') is-invalid @enderror"
                                                value="{{ old('last_name', Auth::user()->last_name) }}" disabled>
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">EMAIL</label>
                                            <input name="email" type="text"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', Auth::user()->email) }}" disabled>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">NO. TELP</label>
                                            <input name="phone" type="text"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone', Auth::user()->phone) }}" disabled>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Alamat Pengiriman --}}
                                    <h4 class="section-pill">Pengiriman</h4>
                                    <div class="row">
                                        <div class="address-option-container">
                                            <div class="address-radio-group">
                                                <label class="modern-radio {{ $isset ? 'active' : '' }}" for="use_profile_address">
                                                    <input type="radio" 
                                                        name="address_option" 
                                                        id="use_profile_address" 
                                                        value="profile" 
                                                        {{ $isset ? 'checked' : '' }}>
                                                    <div class="radio-indicator"></div>
                                                    <div class="radio-content">
                                                        <div class="radio-title">Alamat Profile</div>
                                                        <div class="radio-description">Gunakan alamat yang tersimpan di profile Anda</div>
                                                    </div>
                                                    <svg class="radio-icon" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                </label>

                                                <!-- Custom Address Option -->
                                                <label class="modern-radio {{ !$isset && !request('pickup', false) ? 'active' : '' }}" for="use_custom_address">
                                                    <input type="radio" 
                                                        name="address_option" 
                                                        id="use_custom_address" 
                                                        value="custom" 
                                                        {{ !$isset && !request('pickup', false) ? 'checked' : '' }}>
                                                    <div class="radio-indicator"></div>
                                                    <div class="radio-content">
                                                        <div class="radio-title">Alamat Baru</div>
                                                        <div class="radio-description">Masukkan alamat khusus untuk pesanan ini</div>
                                                    </div>
                                                    <svg class="radio-icon" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                </label>

                                                <!-- Pickup Option -->
                                                <label class="modern-radio {{ request('pickup', false) ? 'active' : '' }}" for="use_pickup">
                                                    <input type="radio" 
                                                        name="address_option" 
                                                        id="use_pickup" 
                                                        value="pickup" 
                                                        {{ request('pickup', false) ? 'checked' : '' }}>
                                                    <div class="radio-indicator"></div>
                                                    <div class="radio-content">
                                                        <div class="radio-title">Ambil Sendiri</div>
                                                        <div class="radio-description">Ambil pesanan langsung di toko kami</div>
                                                    </div>
                                                    <svg class="radio-icon" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.84L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                    </svg>
                                                </label>
                                            </div>

                                            @if (!$isset)
                                            <div class="profile-incomplete-notice" id="profile-incomplete-notice" style="display: none;">
                                                <div class="icon">
                                                    <i class="bi bi-exclamation-triangle"></i>
                                                </div>
                                                <div class="content">
                                                    <div class="title">Alamat Profile Belum Lengkap</div>
                                                    <div class="description">Silakan lengkapi alamat di profile Anda terlebih dahulu untuk menggunakan opsi ini</div>
                                                    <a href="/profile#pane-profile" class="link">Lengkapi Profile →</a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="address-fields-container" id="address-fields-container">
                                            <div id="profile-address-section" class="{{ !$isset ? 'd-none' : '' }}">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">PROVINSI</label>
                                                        <select name="profile_province" class="form-control" disabled>
                                                            <option value="{{ old('profile_province', $provinceName ?? '-') }}">{{ old('profile_province', $provinceName ?? '-') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">KOTA/KABUPATEN</label>
                                                        <select name="profile_district" class="form-control" disabled>
                                                            <option value="{{ old('profile_district', $districtName ?? '-') }}">{{ old('profile_district', $districtName ?? '-') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">KECAMATAN</label>
                                                        <select name="profile_city" class="form-control" disabled>
                                                            <option value="{{ old('profile_city', $cityName ?? '-') }}">{{ old('profile_city', $cityName ?? '-') }}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">KODE POS</label>
                                                        <input name="profile_postal_code" type="text" class="form-control" value="{{ old('profile_postal_code', Auth::user()->postal_code) }}" disabled>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">DETAIL ALAMAT PENGIRIMAN</label>
                                                        <textarea name="profile_address" style="height: 100px" class="form-control p-4" disabled>{{ old('profile_address', Auth::user()->address) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="custom-address-section" class="{{ $isset ? 'd-none' : '' }}">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">PROVINSI</label>
                                                        <select id="custom_provinsi" name="custom_province" class="form-control @error('custom_province') is-invalid @enderror">
                                                            <option value="">PILIH PROVINSI</option>
                                                        </select>
                                                        @error('custom_province')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">KOTA/KABUPATEN</label>
                                                        <select id="custom_kota" name="custom_district" class="form-control @error('custom_district') is-invalid @enderror">
                                                            <option value="">PILIH KOTA/KABUPATEN</option>
                                                        </select>
                                                        @error('custom_district')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">KECAMATAN</label>
                                                        <select id="custom_kecamatan" name="custom_city" class="form-control @error('custom_city') is-invalid @enderror">
                                                            <option value="">PILIH KECAMATAN</option>
                                                        </select>
                                                        @error('custom_city')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">KODE POS</label>
                                                        <select id="custom_kodepos" name="custom_postal_code" class="form-control @error('custom_postal_code') is-invalid @enderror">
                                                            <option value="">PILIH KODE POS</option>
                                                        </select>
                                                        @error('custom_postal_code')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 mb-3">
                                                        <label class="form-label">DETAIL ALAMAT PENGIRIMAN</label>
                                                        <textarea name="custom_address" style="height: 100px" class="form-control p-4 @error('custom_address') is-invalid @enderror" placeholder="Masukkan detail alamat lengkap">{{ old('custom_address') }}</textarea>
                                                        @error('custom_address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="shipping-method-section">
                                            <div class="mb-3">
                                                <label class="form-label"><b>METODE PENGIRIMAN</b></label>
                                                @if (!$isset)
                                                    <div class="mb-3">
                                                        <select 
                                                            id="deliveryMethod" 
                                                            name="kurir" 
                                                            class="form-select @error('kurir') is-invalid @enderror"
                                                            style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;">
                                                            <option value="0" selected>Pilih metode pengiriman</option>
                                                            <option value="" disabled style="color: #999; font-style: italic; background-color: #f8f9fa;">
                                                                Kirim ke alamat - Lengkapi alamat terlebih dahulu
                                                            </option>
                                                        </select>
                                                        <div class="mt-2">
                                                            <small class="text-muted">
                                                                <i class="bi bi-info-circle"></i> 
                                                                Lengkapi alamat di atas untuk opsi pengiriman lainnya
                                                            </small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <select 
                                                        id="deliveryMethod" 
                                                        name="kurir" 
                                                        class="form-select @error('kurir') is-invalid @enderror"
                                                        style="width:100%; height:50px; border-radius:70px; font-size:0.875rem; padding: 0 30px;" >
                                                        <option value="0" {{ old('kurir','0')=='0'?'selected':'' }}>
                                                            Memuat data ongkir...
                                                        </option>
                                                    </select>
                                                @endif

                                                @error('kurir')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Pembayaran --}}
                                    {{-- <h4 class="section-pill">Pembayaran</h4>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PILIHAN PEMBAYARAN</label>
                                            <select name="transaction_method"
                                                class="form-control @error('transaction_method') is-invalid @enderror">
                                                <option value="midtrans">Midtrans (Semua Metode)</option>
                                            </select>
                                            @error('transaction_method')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    {{-- Catatan Tambahan --}}
                                    <h4 class="section-pill">Catatan Tambahan</h4>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">CATATAN TAMBAHAN</label>
                                            <input id="notesInput" name="notes" type="text"
                                                class="form-control @error('notes') is-invalid @enderror"
                                                value="{{ old('notes', $order->notes) }}">
                                            @error('notes')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-block d-md-none mobile-promo-section">
                                        <div class="mb-3">
                                            <label class="form-label">Kode Promo</label>
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    id="mobilePromoCodeInput"
                                                    name="promo_code_mobile"
                                                    class="form-control"
                                                    placeholder="Masukkan kode promo">
                                                <button
                                                    type="button"
                                                    id="mobileApplyPromoBtn"
                                                    class="btn btn-outline-primary">
                                                    Apply
                                                </button>
                                            </div>
                                            <small id="mobilePromoMessage" class="form-text text-danger"></small>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Billing Information Sidebar --}}
                    <div class="col-lg-3">
                        <div class="card p-4" style="border-radius:15px; width: 300px;">
                            <!-- Mobile Version -->
                            <div class="d-block d-md-none">
                                <div class="mobile-billing-summary">
                                    <div class="mobile-product-info">
                                        @php
                                            $image = $item->product->images->first();
                                            $imageSrc = asset('landingpage/img/nophoto.png');

                                            if($image && $image->image_product) {
                                                $imagePath = storage_path('app/public/' . $image->image_product);
                                                if(file_exists($imagePath)) {
                                                    $imageSrc = asset('storage/' . $image->image_product);
                                                }
                                            }
                                        @endphp
                                        <img src="{{ $imageSrc }}" alt="Product" class="mobile-product-image">
                                        <div class="mobile-product-details">
                                            <h6>{{ $item->product->label->name }} – {{ $item->product->name }}</h6>
                                            <small>{{ intval($item->length) }} x {{ intval($item->width) }} {{ $item->product->additional_unit }}</small>
                                            <small>Bahan: {{ $item->product->name ?? '-' }}</small>
                                        </div>
                                        <div class="mobile-product-price">
                                            Rp {{ number_format($item->subtotal,0,',','.') }}
                                        </div>
                                    </div>
                                    
                                    <div class="mobile-cost-breakdown">
                                        <div class="mobile-cost-item">
                                            <span>Subtotal</span>
                                            <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                                        </div>
                                        @if($order->express == 1)
                                            <div class="mobile-cost-item" style="color: #000 !important;">
                                                <span>Express (+50%)</span>
                                                <span id="mobile-express-fee">Rp {{ number_format($expressFee,0,',','.') }}</span>
                                            </div>
                                        @endif
                                        <div class="mobile-cost-item">
                                            <span>Ongkir</span>
                                            <span id="mobile-shipping-cost">Rp 0</span>
                                        </div>
                                        <div class="mobile-cost-item discount" id="mobile-discount-line" style="display: none;">
                                            <span>Potongan Promo</span>
                                            <span id="mobile-discount-amount">-Rp 0</span>
                                        </div>
                                        <div class="mobile-cost-item total">
                                            <span>Total</span>
                                            <span id="mobile-total-amount">Rp {{ number_format($item->subtotal + ($expressFee ?? 0),0,',','.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button id="btnOrder" type="button" class="btn-order">Order Sekarang</button>
                            </div>

                            <!-- Desktop Version -->
                            <div class="d-none d-md-block">
                                <h5 class="mb-0" style="text-align:center; font-family:'Poppins'; font-size:1.2rem; font-weight:600;">Billing Information</h5>
                                <hr>
                                <div class="mb-3">
                                    <span style="font-family:'Poppins'; font-size:0.875rem; font-weight:600;">Produk</span>
                                </div>
                                <div class="mb-0">
                                    <small style="font-family:'Poppins'; font-size:0.875rem; font-weight:500;">{{ $item->product->label->name }} – {{ $item->product->name }}</small>
                                </div>
                                <hr>
                                <div class="mb-0">
                                    <small style="font-family:'Poppins'; font-size:0.875rem; font-weight:500; color:#888888">Detail</small>
                                </div>
                                <div class="mb-0" style="font-family:'Poppins'; font-size:0.8rem; font-weight:550; color:#c3c3c3">
                                    <small>Bahan: {{ $item->product->name ?? '-' }}</small><br>
                                    <small>Ukuran: {{ intval($item->length) }} x {{ intval($item->width) }} {{ $item->product->additional_unit }}</small><br>
                                    <small>File Desain: 
                                        @if($order->order_design) 
                                            <a href="{{ asset('landingpage/img/design/'.$order->order_design) }}" target="_blank" style="font-family:'Poppins'; font-size:0.7rem !important; font-weight:550; color:#c3c3c3">{{ $order->order_design }}</a>
                                        @else
                                            -
                                        @endif
                                    </small><br>
                                    <small>Catatan: {{ $order->notes ?? '-' }}</small><br>
                                </div><br>
                                <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                    <span>Biaya Ongkir</span>
                                    <span id="shippingCost">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                    <span>Subtotal</span>
                                    <span>Rp {{ number_format($item->subtotal,0,',','.') }}</span>
                                </div>
                                @if($order->express == 1)
                                    <div class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#000 !important;">
                                        <span>Express (+50%)</span>
                                        <span id="expressFee">Rp {{ number_format($expressFee,0,',','.') }}</span>
                                    </div>
                                @endif
                                {{-- <div id="discountLine" class="d-flex justify-content-between mb-2" style="font-family:'Poppins'; font-size:0.9rem !important; font-weight:550 !important; color:#fc2865 !important;">
                                    <span>Potongan Promo</span>
                                    <span id="discountAmount">-Rp 0</span>
                                </div> --}}
                                <hr>
                                <div class="d-flex justify-content-between mb-4" style="font-family:'Poppins'; font-size:1rem !important; font-weight:550 !important; color:#000 !important;">
                                    <strong>Total</strong>
                                    <strong id="totalAmount">Rp {{ number_format($item->subtotal + ($expressFee ?? 0),0,',','.') }}</strong>
                                </div>
                                <button id="btnOrderDesktop" type="button" class="btn-order">Order Sekarang</button>
                                <br><br>
                                <div class="mb-3">
                                    <span class="form-label">Kode Promo</span>
                                    <div class="input-group">
                                        <input
                                        type="text"
                                        id="promoCodeInput"
                                        name="promo_code"
                                        class="form-control"
                                        placeholder="Masukkan kode promo"
                                        style="
                                            border-top-left-radius: 1rem !important;
                                            border-bottom-left-radius: 1rem !important;
                                            border-top-right-radius: 0 !important;
                                            border-bottom-right-radius: 0 !important;">
                                        <button
                                        type="button"
                                        id="applyPromoBtn"
                                        class="btn btn-outline-primary"
                                        style="
                                            border-top-left-radius: 0 !important;
                                            border-bottom-left-radius: 0 !important;
                                            border-top-right-radius: 1rem !important;
                                            border-bottom-right-radius: 1rem !important;
                                            margin-left: -1px;
                                            font-size: 0.8rem !important;
                                            border-left: 0;">
                                        Apply
                                        </button>
                                    </div>
                                    <small id="promoMessage" class="form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Hidden inputs -->
    <input type="hidden" id="subtotal" value="{{ $item->subtotal }}">
    <input type="hidden" id="orderId" value="{{ $order->id }}">

    <script>
        let baseSubtotal, expressAmount, baseWithExpress, ongkirCost, promoDiscount;
        let deliverySelect, shippingEl, totalEl, mobileShippingEl, mobileTotalEl;
        let orderId, btnOrder, btnOrderDesktop, loadingOverlay;
        let mobileDiscountLine, mobileDiscountAmtEl, discountLine, discountAmtEl;
        let promoInput, applyPromoBtn, promoMessage, mobilePromoInput, mobileApplyPromoBtn, mobilePromoMessage;
        let hiddenPromo, hiddenPromoDiscount;

        document.addEventListener('DOMContentLoaded', function() {
            const subtotalInput = document.getElementById('subtotal');
            if (!subtotalInput) {
                console.error('subtotal input not found!');
                return;
            }
            
            baseSubtotal = parseFloat(subtotalInput.value) || 0;
            expressAmount = {{ $expressFee ?? 0 }};
            baseWithExpress = baseSubtotal + expressAmount;
            ongkirCost = 0;
            promoDiscount = 0;
            
            deliverySelect = document.getElementById('deliveryMethod');
            shippingEl = document.getElementById('shippingCost');
            totalEl = document.getElementById('totalAmount');
            mobileShippingEl = document.getElementById('mobile-shipping-cost');
            mobileTotalEl = document.getElementById('mobile-total-amount');
            mobileDiscountLine = document.getElementById('mobile-discount-line');
            mobileDiscountAmtEl = document.getElementById('mobile-discount-amount');
            
            orderId = document.getElementById('orderId').value;
            btnOrder = document.getElementById('btnOrder');
            btnOrderDesktop = document.getElementById('btnOrderDesktop');
            loadingOverlay = document.getElementById('loading-overlay');
            
            promoInput = document.getElementById('promoCodeInput');
            applyPromoBtn = document.getElementById('applyPromoBtn');
            promoMessage = document.getElementById('promoMessage');
            mobilePromoInput = document.getElementById('mobilePromoCodeInput');
            mobileApplyPromoBtn = document.getElementById('mobileApplyPromoBtn');
            mobilePromoMessage = document.getElementById('mobilePromoMessage');

            hiddenPromo = document.createElement('input');
            hiddenPromo.type = 'hidden';
            hiddenPromo.name = 'promo_code';
            hiddenPromo.id = 'hiddenPromoCode';
            document.body.appendChild(hiddenPromo);

            hiddenPromoDiscount = document.createElement('input');
            hiddenPromoDiscount.type = 'hidden';
            hiddenPromoDiscount.name = 'promo_discount';
            hiddenPromoDiscount.id = 'hiddenPromoDiscount';
            document.body.appendChild(hiddenPromoDiscount);

            discountLine = null;
            discountAmtEl = null;

            setupEventListeners();
            
            computeTotal();
        });

        function formatRp(x) {
            return 'Rp ' + Math.round(x).toLocaleString('id-ID');
        }

        function computeTotal() {            
            let discountAmount = promoDiscount;
            if (discountAmount > baseWithExpress) {
                discountAmount = baseWithExpress;
            }
            
            const afterDiscount = baseWithExpress - discountAmount;
            const finalTotal = afterDiscount + ongkirCost;
            
            const formattedShipping = formatRp(ongkirCost);
            if (shippingEl) shippingEl.textContent = formattedShipping;
            if (mobileShippingEl) mobileShippingEl.textContent = formattedShipping;
            
            const formattedTotal = formatRp(finalTotal);
            if (totalEl) totalEl.textContent = formattedTotal;
            if (mobileTotalEl) mobileTotalEl.textContent = formattedTotal;
            
            if (discountAmount > 0) {
                const formattedDiscount = '-' + formatRp(discountAmount);
                
                if (!discountLine) {
                    discountLine = document.createElement('div');
                    discountLine.id = 'discountLine';
                    discountLine.className = 'd-flex justify-content-between mb-2';
                    discountLine.style.fontFamily = "'Poppins'";
                    discountLine.style.fontSize = '0.9rem';
                    discountLine.style.fontWeight = '550';
                    discountLine.style.color = '#fc2865';
                    
                    const discountLabel = document.createElement('span');
                    discountLabel.textContent = 'Potongan Promo';
                    
                    discountAmtEl = document.createElement('span');
                    discountAmtEl.id = 'discountAmount';
                    
                    discountLine.appendChild(discountLabel);
                    discountLine.appendChild(discountAmtEl);
                    
                    if (totalEl) {
                        const totalDiv = totalEl.closest('.d-flex');
                        const hrBefore = totalDiv.previousElementSibling;
                        hrBefore.parentNode.insertBefore(discountLine, hrBefore);
                    }
                }
                
                discountLine.style.display = 'flex';
                if (discountAmtEl) discountAmtEl.textContent = formattedDiscount;
                
                if (mobileDiscountLine) {
                    mobileDiscountLine.style.display = 'flex';
                    if (mobileDiscountAmtEl) mobileDiscountAmtEl.textContent = formattedDiscount;
                }
            } else {
                if (discountLine) discountLine.style.display = 'none';
                if (mobileDiscountLine) mobileDiscountLine.style.display = 'none';
            }
            
            if (hiddenPromoDiscount) hiddenPromoDiscount.value = discountAmount;
            
            // console.log('Total updated to:', formattedTotal);
        }

        function setupEventListeners() {
            if (deliverySelect) {
                deliverySelect.addEventListener('change', function() {
                    const selectedOption = this.selectedOptions[0];
                    if (selectedOption) {
                        if (selectedOption.value === 'pickup:ambil_sendiri') {
                            ongkirCost = 0;
                        } else if (selectedOption.hasAttribute('data-cost')) {
                            ongkirCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;
                        }
                        computeTotal();
                    }
                });
            }

            if (applyPromoBtn && promoInput) {
                applyPromoBtn.addEventListener('click', function() {
                    handlePromoApplication(promoInput, promoMessage);
                });
                
                promoInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        handlePromoApplication(promoInput, promoMessage);
                    }
                });
            }

            if (mobileApplyPromoBtn && mobilePromoInput) {
                mobileApplyPromoBtn.addEventListener('click', function() {
                    handlePromoApplication(mobilePromoInput, mobilePromoMessage);
                });
                
                mobilePromoInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        handlePromoApplication(mobilePromoInput, mobilePromoMessage);
                    }
                });
            }

            if (btnOrder) {
                btnOrder.addEventListener('click', handleOrderClick);
            }
            if (btnOrderDesktop) {
                btnOrderDesktop.addEventListener('click', handleOrderClick);
            }
        }

        function handlePromoApplication(inputElement, messageElement) {
            const code = inputElement.value.trim();
            if (!code) {
                updatePromoMessage('Masukkan kode promo dulu.', 'error', messageElement);
                return;
            }

            fetch(`/promo/check?code=${encodeURIComponent(code)}&subtotal=${baseSubtotal}&express_fee=${expressAmount}`)
            .then(res => res.json())
            .then(json => {
                if (!json.valid) {
                    promoDiscount = 0;
                    hiddenPromo.value = '';
                    updatePromoMessage(json.message, 'error', messageElement);
                    
                    if (inputElement === mobilePromoInput && promoInput) {
                        promoInput.value = '';
                    } else if (inputElement === promoInput && mobilePromoInput) {
                        mobilePromoInput.value = '';
                    }
                } else {
                    promoDiscount = json.diskon;
                    hiddenPromo.value = code;
                    updatePromoMessage(json.message, 'success', messageElement);
                    
                    if (inputElement === mobilePromoInput && promoInput) {
                        promoInput.value = code;
                    } else if (inputElement === promoInput && mobilePromoInput) {
                        mobilePromoInput.value = code;
                    }
                }
                computeTotal();
            })
            .catch(() => {
                updatePromoMessage('Gagal cek promo. Coba lagi.', 'error', messageElement);
            });
        }

        function updatePromoMessage(message, type, messageElement) {
            if (!messageElement) return;
            
            messageElement.innerText = message;
            messageElement.classList.remove('text-success', 'text-danger');
            
            if (type === 'success') {
                messageElement.classList.add('text-success');
            } else {
                messageElement.classList.add('text-danger');
            }
            
            const otherMessageElement = messageElement === mobilePromoMessage ? promoMessage : mobilePromoMessage;
            if (otherMessageElement) {
                otherMessageElement.innerText = message;
                otherMessageElement.classList.remove('text-success', 'text-danger');
                if (type === 'success') {
                    otherMessageElement.classList.add('text-success');
                } else {
                    otherMessageElement.classList.add('text-danger');
                }
            }
        }

        function handleOrderClick() {
            const addressOption = document.querySelector('input[name="address_option"]:checked')?.value;
            
            if (addressOption === 'pickup') {
                if (deliverySelect.value !== 'pickup:ambil_sendiri') {
                    deliverySelect.innerHTML = '<option value="pickup:ambil_sendiri" selected>Ambil Sendiri - Gratis (Rp 0)</option>';
                    deliverySelect.value = 'pickup:ambil_sendiri';
                }
            } else {
                if (!deliverySelect || deliverySelect.value === '0' || deliverySelect.value === '') {
                    swal({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Silahkan pilih metode pengiriman terlebih dahulu!',
                        confirmButtonColor: '#0258d3'
                    });
                    return;
                }
            }

            let addressData = {};

            if (addressOption === 'pickup') {
                addressData = {
                    address_option: 'pickup'
                };
            } else if (addressOption === 'custom') {
                const customProvince = document.getElementById('custom_provinsi')?.value;
                const customDistrict = document.getElementById('custom_kota')?.value;
                const customCity = document.getElementById('custom_kecamatan')?.value;
                const customPostalCode = document.getElementById('custom_kodepos')?.value;
                const customAddress = document.querySelector('textarea[name="custom_address"]')?.value;

                if (!customProvince || !customDistrict || !customCity || !customPostalCode || !customAddress?.trim()) {
                    swal({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Silahkan lengkapi semua field alamat terlebih dahulu!',
                        confirmButtonColor: '#0258d3'
                    });
                    return;
                }

                addressData = {
                    address_option: 'custom',
                    custom_province: customProvince,
                    custom_district: customDistrict,
                    custom_city: customCity,
                    custom_postal_code: customPostalCode,
                    custom_address: customAddress
                };
            } else if (addressOption === 'profile') {
                @if (!$isset)
                swal({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Alamat profile Anda belum lengkap. Silahkan lengkapi di halaman profile terlebih dahulu atau pilih alamat baru.',
                    confirmButtonColor: '#0258d3'
                });
                return;
                @endif
                
                addressData = {
                    address_option: 'profile'
                };
            } else {
                swal({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Silahkan pilih metode pengambilan terlebih dahulu!',
                    confirmButtonColor: '#0258d3'
                });
                return;
            }

            const payload = {
                kurir: deliverySelect.value,
                ongkir: ongkirCost,
                notes: document.getElementById('notesInput') ? document.getElementById('notesInput').value : '',
                promo_code: hiddenPromo.value,
                promo_discount: promoDiscount,
                ...addressData
            };

            if (loadingOverlay) loadingOverlay.style.display = 'flex';
            if (btnOrder) btnOrder.disabled = true;
            if (btnOrderDesktop) btnOrderDesktop.disabled = true;

            fetch(`/checkout/pay/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(r => r.json())
            .then(data => {
                if (loadingOverlay) loadingOverlay.style.display = 'none';
                if (btnOrder) btnOrder.disabled = false;
                if (btnOrderDesktop) btnOrderDesktop.disabled = false;

                if (!data.success) {
                    swal({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        confirmButtonColor: '#0258d3'
                    });
                    return;
                }

                if (typeof snap !== 'undefined') {
                    snap.pay(data.snap_token, {
                        onSuccess: res => {
                            fetch(`/checkout/payment-success/${orderId}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    transaction_id: res.transaction_id,
                                    notes: payload.notes,
                                    kurir: payload.kurir,
                                    ongkir: payload.ongkir,
                                    promo_discount: payload.promo_discount,
                                    ...addressData
                                })
                            })
                            .then(r => {
                                if (r.ok) {
                                    window.location.href = '/profile';
                                } else {
                                    swal({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Gagal update order',
                                        confirmButtonColor: '#0258d3'
                                    });
                                }
                            });
                        },
                        onPending: res => {
                            swal({
                                icon: 'info',
                                title: 'Pembayaran Pending',
                                text: 'Pembayaran Anda sedang diproses. Silakan cek status di profil Anda.',
                                confirmButtonColor: '#0258d3'
                            }).then(() => {
                                window.location.href = '/profile';
                            });
                        },
                        onError: err => swal({
                            icon: 'error',
                            title: 'Pembayaran Gagal!',
                            text: err.status_message,
                            confirmButtonColor: '#0258d3'
                        }),
                        onClose: () => swal({
                            icon: 'info',
                            title: 'Pembayaran Dibatalkan',
                            text: 'Anda menutup popup tanpa menyelesaikan pembayaran',
                            confirmButtonColor: '#0258d3'
                        })
                    });
                }
            })
            .catch(err => {
                if (loadingOverlay) loadingOverlay.style.display = 'none';
                if (btnOrder) btnOrder.disabled = false;
                if (btnOrderDesktop) btnOrderDesktop.disabled = false;
                swal({
                    icon: 'error',
                    title: 'Kesalahan Jaringan!',
                    text: 'Terjadi kesalahan jaringan, silahkan coba lagi.',
                    confirmButtonColor: '#0258d3'
                });
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileRadio = document.getElementById('use_profile_address');
            const customRadio = document.getElementById('use_custom_address');
            const pickupRadio = document.getElementById('use_pickup');
            const profileSection = document.getElementById('profile-address-section');
            const customSection = document.getElementById('custom-address-section');
            const addressFieldsContainer = document.getElementById('address-fields-container');
            const shippingMethodSection = document.getElementById('shipping-method-section');
            const deliveryMethod = document.getElementById('deliveryMethod');
            const profileIncompleteNotice = document.getElementById('profile-incomplete-notice');

            function updateRadioStyles() {
                document.querySelectorAll('.modern-radio').forEach(radio => {
                    radio.classList.remove('active');
                });
                
                if (profileRadio?.checked) {
                    profileRadio.closest('.modern-radio').classList.add('active');
                } else if (customRadio?.checked) {
                    customRadio.closest('.modern-radio').classList.add('active');
                } else if (pickupRadio?.checked) {
                    pickupRadio.closest('.modern-radio').classList.add('active');
                }
            }

            function toggleAddressSection() {
                updateRadioStyles();
                
                if (pickupRadio?.checked) {
                    addressFieldsContainer.classList.remove('visible');
                    addressFieldsContainer.classList.add('hidden');
                    shippingMethodSection.style.display = 'none';
                    
                    if (deliveryMethod) {
                        deliveryMethod.innerHTML = '<option value="pickup:ambil_sendiri" selected>Ambil Sendiri - Gratis (Rp 0)</option>';
                        deliveryMethod.value = 'pickup:ambil_sendiri';
                        deliveryMethod.dispatchEvent(new Event('change'));
                    }
                    
                    if (profileIncompleteNotice) {
                        profileIncompleteNotice.style.display = 'none';
                    }
                    
                } else {
                    addressFieldsContainer.classList.remove('hidden');
                    addressFieldsContainer.classList.add('visible');
                    shippingMethodSection.style.display = 'block';
                    
                    if (profileRadio?.checked) {
                        profileSection.classList.remove('d-none');
                        customSection.classList.add('d-none');
                        resetCustomForm();
                        
                        @if (!$isset)
                            if (profileIncompleteNotice) {
                                profileIncompleteNotice.style.display = 'flex';
                            }
                            if (deliveryMethod) {
                                deliveryMethod.innerHTML = `
                                    <option value="0">Alamat profile belum lengkap</option>
                                    <option value="" disabled style="color: #999; font-style: italic; background-color: #f8f9fa;">Lengkapi alamat profile terlebih dahulu</option>
                                `;
                            }
                        @else
                            if (profileIncompleteNotice) {
                                profileIncompleteNotice.style.display = 'none';
                            }
                            loadOngkir();
                        @endif
                        
                    } else if (customRadio?.checked) {
                        profileSection.classList.add('d-none');
                        customSection.classList.remove('d-none');
                        loadCustomProvinsi();
                        
                        if (profileIncompleteNotice) {
                            profileIncompleteNotice.style.display = 'none';
                        }
                        
                        if (deliveryMethod) {
                            deliveryMethod.innerHTML = `
                                <option value="0">Pilih metode pengiriman</option>
                                <option value="" disabled style="color: #999; font-style: italic; background-color: #f8f9fa;">Lengkapi alamat terlebih dahulu</option>
                            `;
                        }
                    }
                }
            }

            function resetCustomForm() {
                if (document.getElementById('custom_provinsi')) {
                    document.getElementById('custom_provinsi').value = '';
                    document.getElementById('custom_kota').innerHTML = '<option value="">PILIH KOTA/KABUPATEN</option>';
                    document.getElementById('custom_kecamatan').innerHTML = '<option value="">PILIH KECAMATAN</option>';
                    document.getElementById('custom_kodepos').innerHTML = '<option value="">PILIH KODE POS</option>';
                    document.querySelector('textarea[name="custom_address"]').value = '';
                }
            }

            function loadCustomProvinsi() {
                fetch('/api/provinsi')
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">PILIH PROVINSI</option>';
                        data.result.forEach(p => {
                            options += `<option value="${p.id}">${p.text}</option>`;
                        });
                        document.getElementById('custom_provinsi').innerHTML = options;
                    })
                    .catch(error => console.error('Error loading provinsi:', error));
            }

            function loadOngkir() {
                if (!deliveryMethod) return;

                const addressOption = document.querySelector('input[name="address_option"]:checked')?.value || 'profile';
                
                if (addressOption === 'pickup') {
                    return;
                }
                
                let requestData = { address_option: addressOption };

                if (addressOption === 'custom') {
                    const customPostalCode = document.getElementById('custom_kodepos')?.value;
                    if (!customPostalCode) {
                        deliveryMethod.innerHTML = '<option value="0">Lengkapi alamat terlebih dahulu</option>';
                        return;
                    }
                    requestData.custom_postal_code = customPostalCode;
                }

                deliveryMethod.innerHTML = '<option value="0">Memuat data ongkir...</option>';

                fetch('/hitung-ongkir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => response.json())
                .then(data => {
                    deliveryMethod.innerHTML = '';

                    const services = Array.isArray(data.details)
                        ? data.details
                        : (data.details && data.details.costs ? data.details.costs : []);

                    if (services.length) {
                        const defaultOption = document.createElement('option');
                        defaultOption.value = '0';
                        defaultOption.textContent = 'Pilih Metode Pengiriman';
                        deliveryMethod.appendChild(defaultOption);

                        services.forEach(item => {
                            let costValue;
                            if (Array.isArray(item.cost)) {
                                costValue = item.cost[0]?.value ?? 0;
                            } else {
                                costValue = item.cost || 0;
                            }

                            const option = document.createElement('option');
                            option.value = `${item.code}:${item.service}`;
                            option.textContent = `${item.name || item.code} - ${item.service} (Rp ${costValue.toLocaleString('id-ID')})`;
                            option.setAttribute('data-cost', costValue);
                            deliveryMethod.appendChild(option);
                        });
                    } else {
                        const option = document.createElement('option');
                        option.value = '0';
                        option.textContent = 'Tidak ada layanan pengiriman';
                        deliveryMethod.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    deliveryMethod.innerHTML = '<option value="0">Gagal memuat ongkir</option>';
                });
            }

            if (profileRadio) profileRadio.addEventListener('change', toggleAddressSection);
            if (customRadio) customRadio.addEventListener('change', toggleAddressSection);
            if (pickupRadio) pickupRadio.addEventListener('change', toggleAddressSection);

            if (document.getElementById('custom_provinsi')) {
                document.getElementById('custom_provinsi').addEventListener('change', function() {
                    const idProv = this.value;
                    const kotaSelect = document.getElementById('custom_kota');
                    
                    if (!idProv) {
                        kotaSelect.innerHTML = '<option value="">PILIH KOTA/KABUPATEN</option>';
                        document.getElementById('custom_kecamatan').innerHTML = '<option value="">PILIH KECAMATAN</option>';
                        document.getElementById('custom_kodepos').innerHTML = '<option value="">PILIH KODE POS</option>';
                        return;
                    }

                    fetch(`/api/kabkota?d_provinsi_id=${idProv}`)
                        .then(res => res.json())
                        .then(data => {
                            let options = '<option value="">PILIH KOTA/KABUPATEN</option>';
                            data.result.forEach(k => {
                                options += `<option value="${k.id}">${k.text}</option>`;
                            });
                            kotaSelect.innerHTML = options;
                            
                            document.getElementById('custom_kecamatan').innerHTML = '<option value="">PILIH KECAMATAN</option>';
                            document.getElementById('custom_kodepos').innerHTML = '<option value="">PILIH KODE POS</option>';
                        })
                        .catch(error => console.error('Error loading kota:', error));
                });
            }

            let selectedCustomKabkotaId;
            if (document.getElementById('custom_kota')) {
                document.getElementById('custom_kota').addEventListener('change', function() {
                    selectedCustomKabkotaId = this.value;
                    const kecamatanSelect = document.getElementById('custom_kecamatan');
                    
                    if (!selectedCustomKabkotaId) {
                        kecamatanSelect.innerHTML = '<option value="">PILIH KECAMATAN</option>';
                        document.getElementById('custom_kodepos').innerHTML = '<option value="">PILIH KODE POS</option>';
                        return;
                    }

                    fetch(`/api/kecamatan?d_kabkota_id=${selectedCustomKabkotaId}`)
                        .then(res => res.json())
                        .then(data => {
                            let opt = '<option value="">PILIH KECAMATAN</option>';
                            data.result.forEach(kec => {
                                opt += `<option value="${kec.id}">${kec.text}</option>`;
                            });
                            kecamatanSelect.innerHTML = opt;
                            
                            document.getElementById('custom_kodepos').innerHTML = '<option value="">PILIH KODE POS</option>';
                        })
                        .catch(error => console.error('Error loading kecamatan:', error));
                });
            }

            let selectedCustomKecId;
            if (document.getElementById('custom_kecamatan')) {
                document.getElementById('custom_kecamatan').addEventListener('change', function() {
                    selectedCustomKecId = this.value;
                    const kodeposSelect = document.getElementById('custom_kodepos');
                    
                    if (!selectedCustomKecId) {
                        kodeposSelect.innerHTML = '<option value="">PILIH KODE POS</option>';
                        return;
                    }

                    fetch(`/api/kodepos?d_kabkota_id=${selectedCustomKabkotaId}&d_kecamatan_id=${selectedCustomKecId}`)
                        .then(res => res.json())
                        .then(data => {
                            let opt = '<option value="">PILIH KODE POS</option>';
                            data.result.forEach(pos => {
                                opt += `<option value="${pos.text}">${pos.text}</option>`;
                            });
                            kodeposSelect.innerHTML = opt;
                        })
                        .catch(error => console.error('Error loading kodepos:', error));
                });
            }

            if (document.getElementById('custom_kodepos')) {
                document.getElementById('custom_kodepos').addEventListener('change', function() {
                    if (this.value) {
                        loadOngkir();
                    }
                });
            }

            toggleAddressSection();
            
            @if ($isset)
                loadOngkir();
            @else
                if (customRadio?.checked) {
                    loadCustomProvinsi();
                }
            @endif
        });
    </script>
@endsection