@extends('landingpage.index')
@section('content')
<style>
  .thumb-container {
    max-width: 100%;
    padding-left: 16px;
  }
  .thumb-img {
    border: 2px solid transparent;
    transition: border-color .2s;
    margin-left: 8px;
  }
  .thumb-img.active {
    border-color: #0d6efd;
  }
  .thumb-img:first-child {
    margin-left: 88px;
  }
  .sticky-left {
    position: sticky;
    top: 96px;
    z-index: 10;
  }
  .is-invalid {
    border-color: #fc2865 !important;
  }
  .invalid-feedback {
    display: block;
    color: #fc2865;
    font-size: 0.75rem;
    font-weight: 400;
    font-family: 'Poppins', sans-serif;
  }
  .required-asterisk {
    color: #fc2865;
    margin-left: 2px;
  }
  .field-error-message {
    color: #fc2865;
    font-size: 0.7rem;
    font-weight: 400;
    font-family: 'Poppins', sans-serif;
    margin-top: 4px;
    display: none;
  }
  .custom-file-input-fix {
    height: 40px;
    padding: 8px 16px;
    font-size: 0.8rem;
    border-radius: 12px;
    background-color: #f9f9f9;
    border: 1px solid #ced4da;
    color: #495057;
    font-family: 'Poppins', sans-serif;
    display: flex;
    align-items: center;
  }
  .custom-file-input-fix::file-selector-button {
    padding: 6px 12px;
    margin-right: 10px;
    border: none;
    border-radius: 6px;
    background-color: #0439a0;
    color: white;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    margin-top: 0;
    margin-bottom: 0;
    vertical-align: middle;
  }
  .custom-file-input-fix::file-selector-button:hover {
    background-color: #062f87;
  }
  .form-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    font-weight: 500;
    color: #000000;
    margin-bottom: 0.4rem;
  }
  
  .cta-overlay h3 {
    font-family: 'Poppins', sans-serif;
    font-size: 2.8rem;
    font-weight: 550;
    color: #fff;
    margin-bottom: 0.8rem;
  }
  .breadcrumb {
    font-family: 'Poppins', sans-serif;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
  }
  .breadcrumb a {
    color: #fff;
    text-decoration: none;
  }
  .breadcrumb-item.active {
    color: #ffc74c;
  }
  
  .price-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    font-weight: 500;
    color: #888;
  }
  .price-main {
    font-family: 'Poppins', sans-serif;
    font-size: 1.6rem;
    font-weight: 600;
  }
  .price-discount {
    font-family: 'Poppins', sans-serif;
    color: #c3c3c3;
    font-size: 0.9rem;
  }
  
  .form-select, .form-control {
    height: 40px;
    border-radius: 50px;
    font-size: 0.8rem;
    padding: 0 24px;
    font-family: 'Poppins', sans-serif;
  }
  .input-group-text {
    border-radius: 0 50px 50px 0;
    font-size: 0.8rem;
    padding: 0 0.8rem;
    font-family: 'Poppins', sans-serif;
  }
  .form-control[type="number"] {
    padding: 0 48px;
  }
  .textarea-custom {
    font-family: 'Poppins', sans-serif;
    height: 80px;
    border-radius: 8px;
    font-size: 0.8rem;
    padding: 12px 16px;
    resize: vertical;
  }
  
  .btn-order {
    border-radius: 40px;
    width: 248px;
    height: 40px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    background-color: #0258d3;
    color: #fff;
  }
  .btn-order:hover {
    background-color: #5ee3e3;
    color: #fff !important;
    /* color: black; */
  }
  .btn-cart-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #28a745, #20c997);
    color: #fff;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    position: relative;
    overflow: hidden;
  }

  .btn-cart-icon:hover {
    background: linear-gradient(135deg, #218838, #1aa179);
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.4);
    color: #fff;
  }

  .btn-cart-icon:active {
    transform: translateY(0);
  }

  .btn-cart-icon::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .btn-cart-icon:active::before {
    width: 300px;
    height: 300px;
  }

  .order-buttons-wrapper {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
  }

  .btn-order {
    flex: 1;
    border-radius: 40px;
    height: 40px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    background-color: #0258d3;
    color: #fff;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-order:hover {
    background-color: #5ee3e3;
    color: black;
    transform: translateY(-1px);
  }

  @media (max-width: 768px) {
    .btn-cart-icon {
      width: 44px !important;
      height: 44px !important;
      font-size: 0.85rem !important;
    }
    
    .btn-order {
      height: 44px !important;
      font-size: 0.9rem !important;
      border-radius: 8px !important;
    }
    
    .order-buttons-wrapper {
      gap: 8px !important;
    }
  }
  
  .total-container {
    border: 1px solid #ccc;
    border-radius: 12px;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .total-label {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    color: #888;
    font-weight: 500;
  }
  .total-price {
    font-family: 'Poppins', sans-serif;
    font-size: 1.8rem;
    font-weight: 600;
    color: #0439a0;
  }
  
  .product-info-header {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    border-color: #ccc !important;
  }
  .info-icon {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #444444;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    font-size: 0.7rem;
    font-weight: 600;
  }
  .info-subtitle {
    margin-top: 16px;
    margin-bottom: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.85rem;
    color: #444444;
    font-weight: 540;
  }
  .info-content {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    color: #888;
    font-weight: 500;
    line-height: 1.4;
  }
  
  .carousel-container {
    max-height: 360px;
  }
  .thumbnail-img {
    width: 80px;
    height: 48px;
    object-fit: contain;
    border-radius: 6px;
    cursor: pointer;
  }
  
  .other-products-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.8rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 1.2rem;
  }
  .product-card-height {
    height: 200px;
    width: 240px;
  }
  .product-card-content {
    min-height: 112px;
    padding: 0.8rem;
  }
  .product-card-title {
    font-family: 'Poppins', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 0;
  }
  .product-card-size {
    font-family: 'Poppins', sans-serif;
    font-size: 0.7rem;
    font-weight: 400;
    color: #fff;
    margin-bottom: 1rem;
  }
  .product-card-price-label {
    font-size: 0.7rem;
    font-weight: 600;
    color: #fff;
    font-family: 'Poppins', sans-serif;
  }
  .product-card-price {
    font-family: 'Poppins', sans-serif;
    font-size: 1.1rem;
    font-weight: 500;
    color: #fc2865;
  }
  .product-card-price-normal {
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
    color: #fff;
  }

  .variant-section {
    margin-bottom: 1.5rem;
  }
  .variant-category {
    margin-bottom: 1rem;
  }
  .variant-category-title {
    font-family: 'Poppins', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    text-transform: capitalize;
  }
  .variant-options {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }
  .variant-option {
    padding: 8px 16px;
    border: 2px solid #e9ecef;
    border-radius: 20px;
    background: #fff;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    font-weight: 500;
    text-align: center;
    min-width: 60px;
    position: relative;
  }
  .variant-option:hover {
    border-color: #0439a0;
    transform: translateY(-1px);
  }
  .variant-option.selected {
    background: #0439a0;
    border-color: #0439a0;
    color: #fff;
  }
  .variant-option.disabled {
    background: #f8f9fa;
    border-color: #e9ecef;
    color: #adb5bd;
    cursor: not-allowed;
    opacity: 0.6;
  }
  .variant-option.disabled:hover {
    transform: none;
    border-color: #e9ecef;
  }
  .variant-option .price-add {
    display: block;
    font-size: 0.65rem;
    font-weight: 400;
    margin-top: 2px;
    opacity: 0.8;
  }
  .variant-option.disabled .price-add {
    opacity: 0.5;
  }
  .variant-option .stock-status {
    font-size: 0.6rem;
    font-weight: 400;
    color: #dc3545;
    margin-top: 2px;
  }

@media (max-width: 768px) {
  .container-fluid.px-4 {
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
  
  .container.product-card {
    margin-top: -120px !important;
    padding: 0 16px !important;
  }
  
  .cta-overlay {
    left: -10% !important;
    top: 50% !important;
  }
  
  .cta-overlay h3 {
    font-size: 1.6rem !important;
    line-height: 1.3;
    margin-bottom: 0.6rem !important;
    display: block !important;
    visibility: visible !important;
  }
  
  .row.g-5 {
    gap: 2rem !important;
    --bs-gutter-x: 1rem !important;
    --bs-gutter-y: 2rem !important;
  }
  
  .col-lg-7 {
    order: 1;
  }
  
  .sticky-left {
    position: static !important;
    top: auto !important;
  }
  
  .carousel-container {
    max-height: 240px !important;
    margin-bottom: 12px;
  }
  
  .thumb-container {
    padding-left: 8px !important;
    justify-content: center !important;
  }
  
  .thumbnail-img {
    width: 56px !important;
    height: 36px !important;
  }
  
  .thumb-img {
    margin-left: 4px !important;
  }
  
  .thumb-img:first-child {
    margin-left: 0 !important;
  }
  
  .col-lg-5 {
    order: 2;
    padding: 0 !important;
  }
  
  .price-main {
    font-size: 1.2rem !important;
  }
  
  .price-discount {
    font-size: 0.8rem !important;
  }
  .form-select, .form-control {
    height: 44px !important;
    font-size: 0.85rem !important;
    padding: 0 16px !important;
    border-radius: 8px !important;
  }
  
  .form-label {
    font-size: 0.8rem !important;
    margin-bottom: 0.5rem !important;
  }
  
  .input-group-text {
    border-radius: 0 8px 8px 0 !important;
    font-size: 0.8rem !important;
    padding: 0 12px !important;
  }
  
  .form-control[type="number"] {
    padding: 0 16px !important;
    border-radius: 8px 0 0 8px !important;
  }
  
  .custom-file-input-fix {
    height: 44px !important;
    padding: 8px 12px !important;
    font-size: 0.8rem !important;
    border-radius: 8px !important;
  }
  
  .custom-file-input-fix::file-selector-button {
    padding: 8px 12px !important;
    font-size: 0.75rem !important;
    margin-right: 8px !important;
  }
  
  .textarea-custom {
    height: 60px !important;
    padding: 10px 12px !important;
    font-size: 0.8rem !important;
  }
  
  .row.g-2 {
    gap: 0.75rem !important;
  }
  
  .row.g-2 .col {
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }
  
  .row.mb-3:last-of-type .col-auto:first-child,
  .row.mb-3:last-of-type .col-12:first-child {
    flex: 0 0 100% !important;
    max-width: 100% !important;
    margin-bottom: 1rem;
  }
  
  .row.mb-3:last-of-type .col-auto:last-child,
  .row.mb-3:last-of-type .col-12:last-child {
    flex: 0 0 100% !important;
    max-width: 100% !important;
  }
  
  #qty {
    width: 100% !important;
    padding: 0 16px !important;
  }
  
  .btn-order {
    width: 100% !important;
    height: 48px !important;
    font-size: 0.9rem !important;
    border-radius: 8px !important;
  }
  
  .total-container {
    padding: 16px !important;
    border-radius: 8px !important;
    flex-direction: column !important;
    text-align: center !important;
    gap: 8px;
  }
  
  .total-label {
    font-size: 0.85rem !important;
  }
  
  .total-price {
    font-size: 1.6rem !important;
  }
  
  .product-info-header {
    font-size: 0.85rem !important;
    padding: 12px 0 !important;
  }
  
  .info-icon {
    width: 14px !important;
    height: 14px !important;
    font-size: 0.65rem !important;
    margin-right: 6px !important;
  }
  
  .info-subtitle {
    font-size: 0.8rem !important;
    margin-top: 12px !important;
    margin-bottom: 6px !important;
  }
  
  .info-content {
    font-size: 0.75rem !important;
    line-height: 1.5 !important;
    padding-right: 0 !important;
  }
  
  .content {
    overflow: visible !important;
  }
  
  .col-6 {
    padding-left: 6px !important;
    padding-right: 6px !important;
  }
  .other-products-section {
    display: none !important;
  }
  .breadcrumb {
    display: none !important;
  }
  
  .field-error-message {
    font-size: 0.7rem !important;
    margin-top: 3px !important;
  }
  
  .invalid-feedback {
    font-size: 0.7rem !important;
  }
  
  .alert {
    font-size: 0.75rem !important;
    padding: 8px 12px !important;
    margin-bottom: 1rem !important;
  }
  
  .form-text {
    font-size: 0.65rem !important;
    line-height: 1.4 !important;
  }
  
  .mb-3 {
    margin-bottom: 1rem !important;
  }
  
  .mt-4 {
    margin-top: 1.5rem !important;
  }
  
  .mt-5 {
    margin-top: 2rem !important;
  }
  
  .pt-5 {
    padding-top: 2rem !important;
  }
  
  .container-fluid.footer.mt-5.pt-5 {
    margin-top: 3rem !important;
    padding-top: 2rem !important;
  }
  
  .row.g-4 {
    gap: 1rem !important;
  }
.container-fluid.footer.mt-5.pt-5 .position-relative img {
  height: 200px !important;
  object-fit: cover !important;
}

.container-fluid.footer .position-absolute.cta-overlay {
  top: 30% !important;
  transform: translateY(-50%) !important;
}

.variant-options {
  gap: 6px !important;
}
.variant-option {
  padding: 6px 12px !important;
  font-size: 0.7rem !important;
  min-width: 50px !important;
}
.variant-option .price-add {
  font-size: 0.6rem !important;
}
.variant-option .stock-status {
  font-size: 0.55rem !important;
}
}

@media (max-width: 480px) {
  .container.product-card {
    margin-top: -100px !important;
  }
  
  .cta-overlay h3 {
    font-size: 1.4rem !important;
  }
  
  .carousel-container {
    max-height: 200px !important;
  }
  
  .thumbnail-img {
    width: 48px !important;
    height: 32px !important;
  }
  
  .price-main {
    font-size: 1.1rem !important;
  }
  
  .total-price {
    font-size: 1.4rem !important;
  }
  
  .other-products-title {
    font-size: 1.1rem !important;
  }
  
  .product-card-height {
    height: 80px !important;
  }
  
  .product-card-content {
    min-height: 50px !important;
    padding: 0.3rem !important;
  }
  
  .product-card-title {
    font-size: 0.65rem !important;
    line-height: 1.0 !important;
  }
  
  .product-card-size {
    font-size: 0.5rem !important;
    margin-bottom: 0.2rem !important;
  }
  
  .product-card-price {
    font-size: 0.7rem !important;
  }
  
  .product-card-price-normal {
    font-size: 0.7rem !important;
  }
}
/* ===== MARKETPLACE STYLE IMAGE MODAL ===== */
.marketplace-modal {
  background: #000;
  border: none;
  border-radius: 0;
  height: 100vh;
  width: 100vw;
  position: relative;
}

.marketplace-body {
  padding: 0;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background: #000;
}

.image-wrapper {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 60px 80px;
  box-sizing: border-box;
}

.marketplace-image {
  max-width: 100%;
  max-height: 100%;
  width: auto;
  height: auto;
  object-fit: contain;
  transition: all 0.3s ease;
  cursor: zoom-in;
}

/* Close Button - Marketplace Style */
.marketplace-close-btn {
  position: fixed;
  top: 20px;
  right: 20px;
  width: 44px;
  height: 44px;
  background: rgba(0, 0, 0, 0.7);
  border: none;
  border-radius: 50%;
  color: #fff;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 1070;
  backdrop-filter: blur(10px);
}

.marketplace-close-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: scale(1.1);
}

.marketplace-close-btn:active {
  transform: scale(0.95);
}

/* Navigation Arrows */
.image-nav-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  pointer-events: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
}

.nav-btn {
  width: 50px;
  height: 50px;
  background: rgba(0, 0, 0, 0.6);
  border: none;
  border-radius: 50%;
  color: #fff;
  font-size: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  pointer-events: auto;
  opacity: 0;
  transform: scale(0.8);
}

.marketplace-modal:hover .nav-btn {
  opacity: 1;
  transform: scale(1);
}

.nav-btn:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: scale(1.1);
}

.nav-btn:disabled {
  opacity: 0.3;
  cursor: not-allowed;
}

/* Image Counter */
.image-counter {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0, 0, 0, 0.7);
  color: #fff;
  padding: 8px 16px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 500;
  backdrop-filter: blur(10px);
  font-family: 'Poppins', sans-serif;
}

/* Loading State */
.marketplace-image[src=""] {
  width: 200px;
  height: 200px;
  background: linear-gradient(90deg, #333 25%, #555 50%, #333 75%);
  background-size: 200% 100%;
  animation: shimmer 1.5s infinite;
  border-radius: 8px;
}

@keyframes shimmer {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

/* Zoom Feature */
.marketplace-image.zoomed {
  cursor: zoom-out;
  transform: scale(2);
}

/* Mobile Responsive */
@media (max-width: 768px) {
  .image-wrapper {
    padding: 80px 20px 20px;
  }
  
  .marketplace-close-btn {
    top: 15px;
    right: 15px;
    width: 40px;
    height: 40px;
    font-size: 16px;
  }
  
  .nav-btn {
    width: 44px;
    height: 44px;
    font-size: 16px;
  }
  
  .image-nav-overlay {
    padding: 0 10px;
  }
  
  .image-counter {
    bottom: 20px;
    font-size: 12px;
    padding: 6px 12px;
  }
}

@media (max-width: 480px) {
  .image-wrapper {
    padding: 70px 15px 15px;
  }
  
  .marketplace-close-btn {
    width: 36px;
    height: 36px;
    font-size: 14px;
    top: 10px;
    right: 10px;
  }
  
  .nav-btn {
    width: 40px;
    height: 40px;
    font-size: 14px;
  }
}

/* Modal Animation - Fade */
.modal.fade .modal-dialog {
  transition: opacity 0.3s ease-out;
  opacity: 0;
}

.modal.show .modal-dialog {
  opacity: 1;
}

/* Clickable Image Styles */
.clickable-image {
  cursor: pointer;
  transition: all 0.3s ease;
  border-radius: 8px;
}

.clickable-image:hover {
  transform: scale(1.02);
  opacity: 0.9;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.thumbnail-img:hover {
  transform: scale(1.05);
  border-color: #0439a0 !important;
  box-shadow: 0 4px 8px rgba(4, 57, 160, 0.2);
}

.modal-open {
  overflow: hidden !important;
}
#qty {
  padding: 0 8px 0 24px !important;
  text-align: center;
}

#qty::-webkit-outer-spin-button,
#qty::-webkit-inner-spin-button {
  -webkit-appearance: inner-spin-button !important;
  opacity: 1 !important;
  position: relative !important;
}

@media (max-width: 768px) {
  #qty {
    width: 100% !important;
    padding: 0 8px 0 16px !important;
  }
}
.custom-file-input-fix::file-selector-button {
  padding: 6px 12px;
  margin-right: 10px;
  border: none;
  border-radius: 6px;
  background-color: #0439a0 !important;
  color: white !important;
  font-weight: 500;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
  font-size: 0.75rem;
  margin-top: 0;
  margin-bottom: 0;
  vertical-align: middle;
  
  transition: none !important;
}

.custom-file-input-fix::file-selector-button:hover {
  background-color: #0439a0 !important;
  color: white !important;
  transform: none !important;
}

.custom-file-input-fix::file-selector-button:active {
  background-color: #0439a0 !important;
  color: white !important;
  transform: none !important;
}

.custom-file-input-fix::file-selector-button:focus {
  background-color: #0439a0 !important;
  color: white !important;
  outline: none !important;
  box-shadow: none !important;
}

@media (max-width: 768px) {
  .custom-file-input-fix::file-selector-button {
    padding: 8px 12px !important;
    font-size: 0.75rem !important;
    margin-right: 8px !important;
    background-color: #0439a0 !important;
    color: white !important;
  }
  
  .custom-file-input-fix::file-selector-button:hover {
    background-color: #0439a0 !important;
    color: white !important;
  }
  
  .custom-file-input-fix::file-selector-button:active {
    background-color: #0439a0 !important;
    color: white !important;
  }
  
  .custom-file-input-fix::file-selector-button:focus {
    background-color: #0439a0 !important;
    color: white !important;
  }
}
</style>

<div class="container-fluid footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
  <div class="position-relative mb-0">
    <img class="w-100 rounded" src="{{ asset('landingpage/img/blue_bg.png') }}" alt="CTA Image">
    <div class="position-absolute start-0 translate-middle-y cta-overlay d-none d-md-block" style="left: 5%;">
      <h3 class="mb-2">
        {{ $product->label->name }} - {{ $product->name }}
        @if($product->additional_size && $product->additional_unit)
          {{ $product->additional_size }} {{ $product->additional_unit }}
        @endif
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('landingpage.products') }}">Semua Produk</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ $product->name }}
          </li>
        </ol>
      </nav>
    </div>
    <div class="position-absolute start-0 translate-middle-y cta-overlay d-block d-md-none" style="left: 3%; top: 20%;">
      <h3 class="mb-2">
        {{ $product->label->name }} - {{ $product->name }}
        @if($product->additional_size && $product->additional_unit)
          {{ $product->additional_size }} {{ $product->additional_unit }}
        @endif
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a href="{{ url('/') }}">Beranda</a>
          </li>
          <li class="breadcrumb-item">
            <a href="{{ route('landingpage.products') }}">Semua Produk</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ $product->name }}
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<main>
  <div class="container-fluid px-4">
    <div class="container product-card mobile-spacing" style="margin-top:-150px;">
      @php
        $base = $product->price;
        $final = $product->getDiscountedPrice();
        $bestDiscount = $product->getBestDiscount();
      @endphp
      <div class="row g-5 g-md-5 g-2">
        @php $thumbs = $product->images->take(4); @endphp
        <div class="col-lg-7">
          <div class="sticky-left">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner carousel-container">
                @if($thumbs->isEmpty())
                  @for($i = 0; $i < 4; $i++)
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                      <img src="{{ asset('landingpage/img/nophoto.png') }}"
                          class="d-block w-100 clickable-image"
                          style="max-height:360px; object-fit:contain;"
                          alt=""
                          onclick="openImagePreview('{{ asset('landingpage/img/nophoto.png') }}', {{ $i }})">
                    </div>
                  @endfor
                @else
                  @foreach($thumbs as $i => $img)
                    @php
                      $imgPath = storage_path('app/public/' . $img->image_product);
                      $src = file_exists($imgPath)
                        ? asset('storage/' . $img->image_product)
                        : asset('landingpage/img/nophoto.png');
                    @endphp
                    <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                      <img src="{{ $src }}"
                          class="d-block w-100 clickable-image"
                          style="max-height:360px; object-fit:contain;"
                          alt=""
                          onclick="openImagePreview('{{ $src }}', {{ $i }})">
                    </div>
                  @endforeach

                  @for($j = $thumbs->count(); $j < 4; $j++)
                    <div class="carousel-item">
                      <img src="{{ asset('landingpage/img/nophoto.png') }}"
                          class="d-block w-100 clickable-image"
                          style="max-height:360px; object-fit:contain;"
                          alt=""
                          onclick="openImagePreview('{{ asset('landingpage/img/nophoto.png') }}', {{ $j }})">
                    </div>
                  @endfor
                @endif
              </div>

              <button class="carousel-control-prev" type="button"
                      data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>
              <button class="carousel-control-next" type="button"
                      data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>
            </div>

            <div class="d-flex mt-3 thumb-container"
                style="justify-content: start; padding-left: 12px;">
              @if($thumbs->isEmpty())
                @for($i = 0; $i < 4; $i++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="thumb-img me-2 thumbnail-img {{ $i === 0 ? 'active' : '' }}">
                @endfor
              @else
                @foreach($thumbs as $i => $img)
                  @php
                    $imgPath = storage_path('app/public/' . $img->image_product);
                    $src = file_exists($imgPath)
                      ? asset('storage/' . $img->image_product)
                      : asset('landingpage/img/nophoto.png');
                  @endphp
                  <img src="{{ $src }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $i }}"
                      class="thumb-img me-2 thumbnail-img {{ $i === 0 ? 'active' : '' }}">
                @endforeach

                @for($j = $thumbs->count(); $j < 4; $j++)
                  <img src="{{ asset('landingpage/img/nophoto.png') }}"
                      data-bs-target="#productCarousel"
                      data-bs-slide-to="{{ $j }}"
                      class="thumb-img me-2 thumbnail-img">
                @endfor
              @endif
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <p class="price-label">*Mulai dari</p>
          @if($finalBase < $product->price)
              <h4 class="price-main" style="color:#fc2865;">
                  Rp {{ number_format($finalBase, 0, ',', '.') }}
              </h4>
              <p class="price-discount">
                  <del>Rp {{ number_format($product->price, 0, ',', '.') }}</del>
              </p>
          @else
              <h4 class="price-main">
                  Rp {{ number_format($product->price, 0, ',', '.') }}
              </h4>
          @endif
          @php
            $base  = $product->price;
            $final = $base;
            $disc = $product->discounts->first();

            if ($disc) {
                if ($disc->discount_percent) {
                $amount = $base * ($disc->discount_percent / 100);
                } else {
                $amount = $disc->discount_fix;
                }
                $final = max(0, $base - $amount);
            }

            $user = auth()->user();

            $currentFinishingId = optional(
              $product->label->finishings
                      ->firstWhere('finishing_name', optional($orderProduct)->finishing_type)
            )->id;

            $isEdit = isset($orderProduct);
            $order = optional($orderProduct)->order;
          @endphp
          <form id="orderForm" method="POST" action="{{ $isEdit ? route('order-product.update', $orderProduct) : route('orders.store') }}" enctype="multipart/form-data">
            @csrf

            @if($isEdit)
              @method('PUT')
            @endif

            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $msg)
                    <li style="font-family: 'Poppins', sans-serif; font-size: 0.8rem;">{{ $msg }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            <input type="hidden" id="basePrice" value="{{ $product->price }}">
            <input type="hidden" id="discountedPrice" value="{{ $final }}">
            <input type="hidden" id="unit" value="{{ $product->additional_unit }}">
            <input type="hidden" name="order_status" value="0">

            @if($bestDiscount)
                @if($bestDiscount->discount_percent)
                    <input type="hidden" id="discountPercent" value="{{ $bestDiscount->discount_percent }}">
                    <input type="hidden" id="discountType" value="percent">
                @else
                    <input type="hidden" id="discountAmount" value="{{ $bestDiscount->discount_fix }}">
                    <input type="hidden" id="discountType" value="fix">
                @endif
            @else
                <input type="hidden" id="discountType" value="none">
            @endif

            @if($bestDiscount)
                @if($bestDiscount->discount_percent)
                    <input type="hidden" name="diskon_persen" value="{{ $bestDiscount->discount_percent }}">
                @else
                    <input type="hidden" name="potongan_rp" value="{{ $bestDiscount->discount_fix }}">
                @endif
            @endif

            <div class="mb-3">
              <label class="form-label"><b>BAHAN</b><span class="required-asterisk">*</span></label>
              <select 
                name="product_id" 
                id="product_id"
                class="form-select @error('product_id') is-invalid @enderror"
                required
              >
                <option value="{{ $product->id }}" {{ old('product_id', $product->id)==$product->id?'selected':'' }}>
                  {{ $product->name }}
                  @if($product->additional_size && $product->additional_unit)
                    {{ $product->additional_size }} {{ $product->additional_unit }}
                  @endif
                </option>
              </select>
              @error('product_id')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
              @enderror
              <div class="field-error-message" id="product_id_error">Pilih bahan produk</div>
            </div>

            @if($variantCategories->isNotEmpty())
              <div class="variant-section">
                @foreach($variantCategories as $category)
                  <div class="variant-category">
                    <div class="variant-category-title">
                      {{ $category['display_name'] }}<span class="required-asterisk">*</span>
                    </div>
                    <div class="variant-options">
                      @foreach($category['variants'] as $variant)
                        <div class="variant-option {{ !$variant['is_available'] ? 'disabled' : '' }}" 
                             data-variant-id="{{ $variant['id'] }}"
                             data-category="{{ $category['category'] }}"
                             data-price="{{ $variant['price'] }}"
                             data-available="{{ $variant['is_available'] ? 'true' : 'false' }}">
                          <div>{{ $variant['value'] }}</div>
                          {{-- @if($variant['price'] > 0)
                            <span class="price-add">{{ $variant['formatted_price'] }}</span>
                          @endif
                          @if(!$variant['is_available'])
                            <span class="stock-status">(Kosong)</span>
                          @endif --}}
                        </div>
                      @endforeach
                    </div>
                    <div class="field-error-message" id="variant_{{ $category['category'] }}_error">
                      Pilih {{ strtolower($category['display_name']) }}
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            @if($product->label->finishings->isNotEmpty())
              <div class="mb-3">
                <label class="form-label"><b>FINISHING</b></label>
                <select 
                  name="finishing_id" 
                  id="finishingSelect"
                  class="form-select @error('finishing_id') is-invalid @enderror"
                >
                  <option value="" data-price="0">Pilih Finishing</option>
                  @foreach($product->label->finishings as $fin)
                    <option 
                      value="{{ $fin->id }}" 
                      data-price="{{ $fin->finishing_price }}"
                      {{ old('finishing_id', $currentFinishingId) == $fin->id ? 'selected':'' }}>
                      {{ $fin->finishing_name }} (Rp {{ number_format($fin->finishing_price,0,',','.') }})
                    </option>
                  @endforeach
                </select>
                @error('finishing_id')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
            @endif

            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>KEBUTUHAN EXPRESS</b></label>
                <select 
                  id="needExpress" 
                  name="express" 
                  class="form-select @error('express') is-invalid @enderror">
                  <option value="0" {{ old('express', optional($order)->express ?? '0') == '0' ? 'selected' : '' }}>Tidak</option>
                  <option value="1" {{ old('express', optional($order)->express ?? '0') == '1' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('express')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>DEADLINE JAM</b><span class="required-asterisk" id="deadline_asterisk" style="display: none;">*</span></label>
                <input
                  type="time"
                  id="deadlineTime"
                  name="waktu_deadline"
                  class="form-control @error('waktu_deadline') is-invalid @enderror"
                  {{ old('express', optional($order)->express ?? '0') == '1' ? '' : 'disabled' }}
                  value="{{ old('waktu_deadline', optional($order)->waktu_deadline ? substr($order->waktu_deadline,0,5) : '') }}">
                @error('waktu_deadline')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="deadline_error">Deadline jam wajib diisi jika memilih express</div>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>KEBUTUHAN PROOFING</b></label>
                <select 
                  id="needProofing" 
                  name="kebutuhan_proofing" 
                  class="form-select @error('kebutuhan_proofing') is-invalid @enderror">
                  <option value="0" {{ old('kebutuhan_proofing', optional($order)->kebutuhan_proofing ?? '0') == '0' ? 'selected' : '' }}>Tidak</option>
                  <option value="1" {{ old('kebutuhan_proofing', optional($order)->kebutuhan_proofing ?? '0') == '1' ? 'selected' : '' }}>Ya</option>
                </select>
                @error('kebutuhan_proofing')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="col">
                <label class="form-label"><b>QTY PROOFING</b><span class="required-asterisk" id="proof_asterisk" style="display: none;">*</span></label>
                <input
                  type="number"
                  id="proofQty"
                  name="proof_qty"
                  class="form-control @error('proof_qty') is-invalid @enderror"
                  value="{{ old('proof_qty', optional($order)->proof_qty ?? '') }}"
                  {{ old('kebutuhan_proofing', optional($order)->kebutuhan_proofing ?? '0') == '1' ? '' : 'disabled' }}>
                @error('proof_qty')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="proof_qty_error">Qty proofing wajib diisi jika memilih proofing</div>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label"><b>DESAIN CETAK</b><span class="required-asterisk">*</span></label>
                <input 
                  type="file" 
                  name="order_design" 
                  accept=".jpeg,.jpg,.png,.pdf,.svg,.cdr,.psd,.ai,.tiff,.rar,.zip" 
                  class="form-control @error('order_design') is-invalid @enderror custom-file-input-fix"
                  id="order_design"
                  {{ !$isEdit ? 'required' : '' }}
                >
                @error('order_design')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="order_design_error">File desain cetak wajib diupload</div>
                @if($isEdit && $orderProduct && $orderProduct->order->order_design)
                  <small class="text-success mt-1 d-block">
                    <i class="bi bi-check-circle"></i> 
                    File saat ini: 
                    <a href="#" class="text-primary text-decoration-underline" 
                      onclick="showFilePreview('{{ asset('storage/landingpage/img/order_design/' . $orderProduct->order->order_design) }}', '{{ $orderProduct->order->order_design }}')">
                      {{ $orderProduct->order->order_design }}
                    </a>
                  </small>
                @endif
              </div>
              <div class="col">
                <label class="form-label"><b>DESAIN PREVIEW</b></label>
                <input 
                  type="file" 
                  name="preview_design" 
                  accept=".jpeg,.jpg,.png,.pdf" 
                  class="form-control @error('preview_design') is-invalid @enderror custom-file-input-fix"
                  id="preview_design"
                >
                @error('preview_design')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                @if($isEdit && $orderProduct && $orderProduct->order->preview_design)
                  <small class="text-success mt-1 d-block">
                    <i class="bi bi-check-circle"></i> 
                    File saat ini: 
                    <a href="#" class="text-primary text-decoration-underline" 
                      onclick="showFilePreview('{{ asset('storage/landingpage/img/order_design/' . $orderProduct->order->preview_design) }}', '{{ $orderProduct->order->preview_design }}')">
                      {{ $orderProduct->order->preview_design }}
                    </a>
                  </small>
                @endif
              </div>
              <small class="form-text text-muted mt-2" style="font-family: 'Poppins', sans-serif; font-size: 0.7rem;">
                Format yang diterima: .jpeg, .jpg, .png, .pdf, .svg, .cdr, .psd, .ai, .tiff.<br>
                Untuk multiple file desain, unggah dalam arsip .rar atau .zip.
              </small>
            </div>

            @if($product->width_product && $product->long_product)
              <div class="row g-2 mb-3">
                <div class="col">
                  <label class="form-label"><b>PANJANG (cm)</b><span class="required-asterisk">*</span></label>
                  <div class="input-group flex-nowrap">
                    <input
                      type="number"
                      name="length"
                      id="panjang"
                      class="form-control @error('length') is-invalid @enderror"
                      placeholder="Panjang"
                      value="{{ old('length', optional($orderProduct)->length ?? intval($product->long_product)) }}"
                      style="height:40px; border-radius:50px 0 0 50px; font-size:0.8rem; padding:0 1.6rem;"
                      @if ($product->label->type != 'khusus')
                      readonly
                      @endif
                      required
                    >
                    <span class="input-group-text">cm</span>
                  </div>
                  @error('length')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="field-error-message" id="length_error">Panjang wajib diisi</div>
                </div>
                <div class="col">
                  <label class="form-label"><b>LEBAR (cm)</b><span class="required-asterisk">*</span></label>
                  <div class="input-group flex-nowrap">
                    <input
                      type="number"
                      name="width"
                      id="lebar"
                      class="form-control @error('width') is-invalid @enderror"
                      placeholder="Lebar"
                      value="{{ old('width', optional($orderProduct)->width ?? intval($product->width_product)) }}"
                      style="height:40px; border-radius:50px 0 0 50px; font-size:0.8rem; padding:0 1.6rem;"
                      @if ($product->label->type != 'khusus')
                      readonly
                      @endif
                      required
                    >
                    <span class="input-group-text">cm</span>
                  </div>
                  @error('width')
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                  <div class="field-error-message" id="width_error">Lebar wajib diisi</div>
                </div>
              </div>
            @endif

            <div class="mb-3">
              <label class="form-label"><b>CATATAN</b></label>
              <textarea
                name="notes"
                class="form-control textarea-custom @error('notes') is-invalid @enderror"
                placeholder="Masukkan catatan tambahan jika ada">{{ old('notes', optional($order)->notes ?? '') }}</textarea>
              @error('notes')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
              @enderror
            </div>

            <div class="row mb-3">
              <div class="col-12 col-md-auto mb-2 mb-md-0">
                <label class="form-label"><b>QTY</b><span class="required-asterisk">*</span></label>
                <input
                  type="number"
                  name="qty"
                  id="qty"
                  value="{{ old('qty', optional($orderProduct)->qty ?? 1) }}"
                  class="form-control @error('qty') is-invalid @enderror"
                  placeholder="1"
                  style="width:100px; height:40px; border-radius:50px; font-size:0.8rem; padding:0 48px;"
                  required
                  min="1"
                >
                @error('qty')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <div class="field-error-message" id="qty_error">Qty minimal 1</div>
              </div>
              <div class="col-12 col-md-auto d-flex align-items-end">
                <div class="order-buttons-wrapper">
                  <button type="submit" name="action" value="buy_now" class="btn btn-order">
                    {{ $isEdit ? 'UBAH & CHECKOUT' : 'BELI SEKARANG' }}
                  </button>
                  
                  <button type="submit" name="action" value="add_to_cart" class="btn-cart-icon" title="Tambah ke Keranjang">
                    <i class="fas fa-shopping-cart"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="total-container">
              <div class="total-label">Total Harga</div>
              <div class="total-price">Rp <span id="totalHarga">0</span></div>
            </div>
          </form>

          <div class="mt-4">
            <div class="d-flex align-items-center justify-content-between w-100 border-0 bg-transparent pb-2 mb-2 border-bottom product-info-header" data-bs-toggle="collapse" data-bs-target="#collapseInfo" aria-expanded="false" aria-controls="collapseInfo">
              <div class="d-flex align-items-center">
                <div class="info-icon">i</div>
                INFORMASI PRODUK
              </div>
              <div id="iconChevron" style="transition: transform 0.3s;"><i class="bi bi-chevron-right"></i></div>
            </div>
            <div class="collapse show" id="collapseInfo">
              <div class="info-subtitle">
                Lama Pengerjaan
              </div>
              <div class="info-content">
                {!! nl2br(e(str_replace(';', "\n", 
                  $product->production_time ?: 'Order 1 - 50 pcs : 1 Hari; Order > 50 pcs : 2 Hari'
                ))) !!}
                <p>Catatan : <br>
                  * File Sudah Ready to Print <br>
                  * Lama Pengerjaan tidak termasuk lama delivery <br>
                  * Tidak Berlaku untuk Hari Libur/Tanggal Merah <br>
                  * Order Urgent / Jumlah Besar Deadline Konfirmasi CS <br>
                </p>
              </div>
              <div class="info-subtitle">
                Keterangan Produk
              </div>
              <div class="info-content" style="padding-right: 16px;">
                {{ $product->description }}
              </div>
              <div class="info-subtitle">
                Spesifikasi
              </div>
              <div class="info-content">
                {!! nl2br(e(str_replace(';', "\n", $product->spesification_desc))) !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="container-fluid footer mt-5 pt-5 wow fadeIn other-products-section" data-wow-delay="0.1s">
    <div class="position-relative">
      <img
        class="w-100 rounded" style="max-height:480px"
        src="{{ asset('landingpage/img/login_register_bg.png') }}"
        alt="Background"/>

      <div class="position-absolute top-50 start-50 translate-middle w-100 px-3">
        <div class="container">
          <h3 class="other-products-title">
            Produk Lainnya
          </h3>
          <div class="row g-4">
            @foreach($bestProducts as $prod)
              <div class="col-lg-3 col-md-6 col-6">
                <a href="{{ route('landingpage.produk_detail', $prod->slug) }}" class="text-decoration-none">
                  <div class="product-item shadow-sm h-100" style="border-radius:8px; background: transparent;">
                    <div class="position-relative bg-light overflow-hidden product-card-height" style="border-radius:8px;">
                      @php
                        $image = $prod->images->first();
                        $imageSrc = asset('landingpage/img/nophoto.png');

                        if($image && $image->image_product) {
                          $imagePath = storage_path('app/public/' . $image->image_product);
                          if(file_exists($imagePath)) {
                            $imageSrc = asset('storage/' . $image->image_product);
                          }
                        }
                      @endphp
                      <img src="{{ $imageSrc }}" class="img-fluid w-100 h-100" style="object-fit:cover;">
                    </div>
                    <div class="content product-card-content d-flex flex-column">
                      <div class="product-card-title">
                        {{ $prod->name }}
                        @if($prod->additional_size && $prod->additional_unit)
                          {{ $prod->additional_size }} {{ $prod->additional_unit }}
                        @endif
                      </div>
                      <div class="product-card-size">
                        @if($prod->long_product && $prod->width_product)
                          Ukuran {{ intval($prod->long_product) }}x{{ intval($prod->width_product) }} {{ $prod->additional_unit }}
                        @else
                          {{ $prod->additional_size }} {{ $prod->additional_unit }}
                        @endif
                      </div>
                      @php
                          $base = $prod->price; 
                          $final = $prod->getDiscountedPrice();
                          $prodBestDiscount = $prod->getBestDiscount();
                      @endphp

                      @if($final < $base)
                          <div class="product-card-price-label mb-0 mt-1">MULAI DARI</div>
                          <div class="price-container d-flex align-items-center" style="gap:6px;">
                              <span class="discount-price text-decoration-line-through text-white" style="font-size: 0.7rem;">
                                  {{ $prod->getFormattedPrice() }}
                              </span>
                              <img 
                                  src="{{ asset('landingpage/img/discount_logo.png') }}" 
                                  alt="Diskon" 
                                  class="discount-logo" 
                                  style="width:14px; height:auto;"
                              >
                              <span class="product-card-price">
                                  {{ $prod->getFormattedDiscountedPrice() }}
                              </span>
                          </div>
                      @else
                          <div class="product-card-price-label mb-0 mt-1">Mulai Dari</div>
                          <div class="price-container mt-0">
                              <span class="product-card-price-normal">{{ $prod->getFormattedPrice() }}</span>
                          </div>
                      @endif
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="filePreviewModalLabel">Preview File</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div id="filePreviewContent">
          </div>
        </div>
        <div class="modal-footer">
          <a id="downloadFileBtn" href="#" class="btn btn-success" download>
            <i class="bi bi-download"></i> Download
          </a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content marketplace-modal">
        <button type="button" class="marketplace-close-btn" data-bs-dismiss="modal" aria-label="Close">
          <i class="fas fa-times"></i>
        </button>
        
        <div class="modal-body marketplace-body">
          <div class="image-wrapper">
            <img id="previewImage" src="" alt="Preview" class="marketplace-image">
          </div>
          
          <div class="image-nav-overlay">
            <button class="nav-btn nav-prev" onclick="navigateImage(-1)">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button class="nav-btn nav-next" onclick="navigateImage(1)">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
          
          <div class="image-counter">
            <span id="imageCounter">1 / 4</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
  function showFilePreview(fileUrl, fileName) {
    const modal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
    const modalTitle = document.getElementById('filePreviewModalLabel');
    const previewContent = document.getElementById('filePreviewContent');
    const downloadBtn = document.getElementById('downloadFileBtn');
    
    modalTitle.textContent = `Preview: ${fileName}`;
    
    downloadBtn.href = fileUrl;
    downloadBtn.download = fileName;
    
    const extension = fileName.split('.').pop().toLowerCase();
    
    previewContent.innerHTML = '';
    
    if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
      previewContent.innerHTML = `
        <img src="${fileUrl}" class="img-fluid" style="max-height: 500px;" alt="Preview">
      `;
    } else if (extension === 'pdf') {
      previewContent.innerHTML = `
        <embed src="${fileUrl}" width="100%" height="500px" type="application/pdf">
        <p class="mt-2 text-muted">Jika PDF tidak tampil, <a href="${fileUrl}" target="_blank">klik di sini</a></p>
      `;
    } else if (['svg'].includes(extension)) {
      previewContent.innerHTML = `
        <img src="${fileUrl}" class="img-fluid" style="max-height: 500px;" alt="SVG Preview">
      `;
    } else {
      previewContent.innerHTML = `
        <div class="text-center py-5">
          <i class="bi bi-file-earmark-zip" style="font-size: 4rem; color: #6c757d;"></i>
          <h5 class="mt-3">${fileName}</h5>
          <p class="text-muted">File ini tidak dapat di-preview.<br>Silakan download untuk melihat isi file.</p>
        </div>
      `;
    }
    
    modal.show();
  }
</script>

<script>
  document.getElementById('add-to-cart')?.addEventListener('submit', function(e) {
    e.preventDefault();
    @if(Auth::check())
      swal({
        title: "Berhasil!",
        text: "Produk telah ditambahkan ke keranjang.",
        icon: "success",
      }).then(() => this.submit());
    @else
      swal({
        title: "Gagal!",
        text: "Anda harus login terlebih dahulu.",
        icon: "error",
      }).then(() => location.href = "{{ route('login') }}");
    @endif
  });

  document.querySelectorAll('.thumb img').forEach(img => img.addEventListener('click', function(){
    document.querySelectorAll('.thumb img').forEach(i=>i.classList.remove('active'));
    this.classList.add('active');
  }));

  const collapseEl   = document.getElementById('collapseInfo');
  const iconChevron  = document.getElementById('iconChevron');

  if (collapseEl.classList.contains('show')) {
    iconChevron.style.transform = 'rotate(90deg)';
  } else {
    iconChevron.style.transform = 'rotate(0deg)';
  }

  collapseEl.addEventListener('show.bs.collapse', function () {
    document.getElementById('iconChevron').style.transform = 'rotate(90deg)';
  });
  collapseEl.addEventListener('hide.bs.collapse', function () {
    document.getElementById('iconChevron').style.transform = 'rotate(0deg)';
  });
</script>
<script>
  const carousel = document.getElementById('productCarousel');
  const thumbs = document.querySelectorAll('.thumb-img');

  thumbs.forEach((img, idx) => {
    img.addEventListener('click', () => {
      thumbs.forEach(i => i.classList.remove('active'));
      img.classList.add('active');
    });
  });

  carousel.addEventListener('slid.bs.carousel', function(e) {
    const currentIndex = Array.from(
      e.currentTarget.querySelectorAll('.carousel-item')
    ).indexOf(e.relatedTarget);

    thumbs.forEach((img, idx) => {
      img.classList.toggle('active', idx === currentIndex);
    });
  });
  
  document.getElementById('needExpress').addEventListener('change', function() {
    const deadlineInput = document.getElementById('deadlineTime');
    const asterisk = document.getElementById('deadline_asterisk');
    const errorMsg = document.getElementById('deadline_error');
    
    if(this.value === '1') {
      deadlineInput.disabled = false;
      deadlineInput.required = true;
      asterisk.style.display = 'inline';
    } else {
      deadlineInput.disabled = true;
      deadlineInput.required = false;
      deadlineInput.value = '';
      asterisk.style.display = 'none';
      errorMsg.style.display = 'none';
    }
  });

  document.getElementById('needProofing').addEventListener('change', function() {
    const proofInput = document.getElementById('proofQty');
    const asterisk = document.getElementById('proof_asterisk');
    const errorMsg = document.getElementById('proof_qty_error');
    
    if(this.value === '1') {
      proofInput.disabled = false;
      proofInput.required = true;
      asterisk.style.display = 'inline';
    } else {
      proofInput.disabled = true;
      proofInput.required = false;
      proofInput.value = '';
      asterisk.style.display = 'none';
      errorMsg.style.display = 'none';
    }
  });

  let selectedVariants = {};

  document.addEventListener('DOMContentLoaded', function() {
    const variantOptions = document.querySelectorAll('.variant-option');
    const form = document.getElementById('orderForm');
    
    @if($variantCategories->isNotEmpty())
      const requiredCategories = @json($variantCategories->pluck('category')->toArray());
    @else
      const requiredCategories = [];
    @endif

    @if($isEdit && isset($orderProduct))
      @foreach($variantCategories as $category)
        @foreach($category['variants'] as $variant)
          @if($variant['is_selected'] ?? false)
            selectedVariants['{{ $category['category'] }}'] = {
              id: '{{ $variant['id'] }}',
              price: {{ $variant['price'] }}
            };
          @endif
        @endforeach
      @endforeach
      
      variantOptions.forEach(option => {
        const category = option.dataset.category;
        if(selectedVariants[category] && selectedVariants[category].id == option.dataset.variantId) {
          option.classList.add('selected');
        }
      });
    @endif

    variantOptions.forEach(option => {
      option.addEventListener('click', function() {
        if(this.classList.contains('disabled')) {
          return;
        }

        const category = this.dataset.category;
        const variantId = this.dataset.variantId;
        const price = parseFloat(this.dataset.price) || 0;

        const categoryOptions = document.querySelectorAll(`.variant-option[data-category="${category}"]`);
        categoryOptions.forEach(opt => opt.classList.remove('selected'));
        
        this.classList.add('selected');
        selectedVariants[category] = {
          id: variantId,
          price: price
        };

        computeTotal();
      });
    });

    function validateVariants() {
      let isValid = true;
      let errorMessages = [];

      document.querySelectorAll('.field-error-message[id^="variant_"]').forEach(msg => {
        msg.style.display = 'none';
      });

      requiredCategories.forEach(category => {
        if(!selectedVariants[category]) {
          isValid = false;
          const errorElement = document.getElementById(`variant_${category}_error`);
          if(errorElement) {
            errorElement.style.display = 'block';
          }
          errorMessages.push(`Pilih ${category}`);
        }
      });

      return {isValid, errorMessages};
    }

    form.addEventListener('submit', function(e) {
      let hasError = false;
      let errorMessages = [];
      
      document.querySelectorAll('.field-error-message').forEach(msg => {
        msg.style.display = 'none';
      });

      if(requiredCategories.length > 0) {
        const variantValidation = validateVariants();
        if(!variantValidation.isValid) {
          hasError = true;
          errorMessages = errorMessages.concat(variantValidation.errorMessages);
        }
      }

      const productId = document.getElementById('product_id');
      if(!productId.value) {
        document.getElementById('product_id_error').style.display = 'block';
        hasError = true;
        errorMessages.push('Pilih bahan produk');
      }
      
      const deadlineTime = document.getElementById('deadlineTime');
      const needExpress = document.getElementById('needExpress');
      if(needExpress.value === '1' && !deadlineTime.value) {
        document.getElementById('deadline_error').style.display = 'block';
        hasError = true;
        errorMessages.push('Deadline jam wajib diisi jika memilih express');
      }
      
      const proofQty = document.getElementById('proofQty');
      const needProofing = document.getElementById('needProofing');
      if(needProofing.value === '1' && (!proofQty.value || proofQty.value < 1)) {
        document.getElementById('proof_qty_error').style.display = 'block';
        hasError = true;
        errorMessages.push('Qty proofing wajib diisi jika memilih proofing');
      }
      
      const orderDesign = document.getElementById('order_design');
      const isEdit = {{ $isEdit ? 'true' : 'false' }};
      if(!isEdit && !orderDesign.files.length) {
        document.getElementById('order_design_error').style.display = 'block';
        hasError = true;
        errorMessages.push('File desain cetak wajib diupload');
      }
      
      const panjang = document.getElementById('panjang');
      const lebar = document.getElementById('lebar');
      
      if(panjang && (!panjang.value || panjang.value <= 0)) {
        document.getElementById('length_error').style.display = 'block';
        hasError = true;
        errorMessages.push('Panjang wajib diisi');
      }
      if(lebar && (!lebar.value || lebar.value <= 0)) {
        document.getElementById('width_error').style.display = 'block';
        hasError = true;
        errorMessages.push('Lebar wajib diisi');
      }
      
      const qty = document.getElementById('qty');
      if(!qty.value || qty.value < 1) {
        document.getElementById('qty_error').style.display = 'block';
        hasError = true;
        errorMessages.push('Qty minimal 1');
      }
      
      if(hasError) {
        e.preventDefault();
        return false;
      }

      const hiddenInputsContainer = document.createElement('div');
      for(const [category, variant] of Object.entries(selectedVariants)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_variants[]';
        input.value = variant.id;
        hiddenInputsContainer.appendChild(input);
      }
      form.appendChild(hiddenInputsContainer);
      return true;
    });

    const originalPrice = parseFloat(document.getElementById('basePrice').value) || 0;
    const unit = document.getElementById('unit').value;
    const finishingSelect = document.getElementById('finishingSelect');
    const needExpress = document.getElementById('needExpress');
    const panjangInput = document.getElementById('panjang');
    const lebarInput = document.getElementById('lebar');
    const qtyInput = document.getElementById('qty');
    const totalEl = document.getElementById('totalHarga');
    
    const discountType = document.getElementById('discountType').value;
    const discountPercent = discountType === 'percent' ? 
        (parseFloat(document.getElementById('discountPercent')?.value) || 0) : 0;
    const discountAmount = discountType === 'fix' ? 
        (parseFloat(document.getElementById('discountAmount')?.value) || 0) : 0;

    function applyDiscount(price) {
        if (discountType === 'percent') {
            return price - (price * (discountPercent / 100));
        } else if (discountType === 'fix') {
            return Math.max(0, price - discountAmount);
        }
        return price;
    }

    function computeTotal() {
        let basePrice = applyDiscount(originalPrice);
        
        let variantPrice = 0;
        for(const [category, variant] of Object.entries(selectedVariants)) {
            variantPrice += variant.price;
        }

        let pricePerUnit = basePrice + variantPrice;
        let hpl = pricePerUnit;

        const productSizes = @json($product->toArray());
        const defaultPanjang = productSizes.long_product;
        const defaultLebar = productSizes.width_product;

        if (panjangInput && lebarInput) {
            const l = parseFloat(panjangInput.value) || 0;
            const w = parseFloat(lebarInput.value) || 0;

            let finalP = 0;
            let finalL = 0;

            if (l * w > defaultPanjang * defaultLebar) {
                finalP = l 
                finalL = w 

                const areaInM = (finalP / 100) * (finalL / 100);
                hpl = pricePerUnit * areaInM;
            } else {
                finalP = defaultPanjang;
                finalL = defaultLebar;

                const areaInM2 = (finalP / 100) * (finalL / 100);
                hpl = pricePerUnit * areaInM2;
            }
        }

        const qty = parseInt(qtyInput.value) || 1;
        const subtotalHpl = hpl * qty;

        const finishingPrice = finishingSelect
            ? parseFloat(finishingSelect.selectedOptions[0]?.dataset.price) || 0
            : 0;
        const subtotalFinishing = finishingPrice * qty;

        let total = subtotalHpl + subtotalFinishing;

        if (needExpress.value === '1') {
            total = total * 1.5;
        }

        totalEl.innerText = Math.round(total).toLocaleString();
    }

    if (finishingSelect) finishingSelect.addEventListener('change', computeTotal);
    needExpress.addEventListener('change', computeTotal);
    if (panjangInput) panjangInput.addEventListener('input', computeTotal);
    if (lebarInput) lebarInput.addEventListener('input', computeTotal);
    qtyInput.addEventListener('input', computeTotal);

    computeTotal();
    
    const needExpressVal = document.getElementById('needExpress').value;
    const needProofingVal = document.getElementById('needProofing').value;
    
    if(needExpressVal === '1') {
        document.getElementById('deadline_asterisk').style.display = 'inline';
    }
    
    if(needProofingVal === '1') {
        document.getElementById('proof_asterisk').style.display = 'inline';
    }

    document.getElementById('deadlineTime')?.addEventListener('blur', function() {
      const needExpress = document.getElementById('needExpress');
      const errorMsg = document.getElementById('deadline_error');
      if(needExpress.value === '1' && !this.value) {
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });

    document.getElementById('proofQty')?.addEventListener('blur', function() {
      const needProofing = document.getElementById('needProofing');
      const errorMsg = document.getElementById('proof_qty_error');
      if(needProofing.value === '1' && (!this.value || this.value < 1)) {
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });

    document.getElementById('order_design')?.addEventListener('change', function() {
      const errorMsg = document.getElementById('order_design_error');
      const isEdit = {{ $isEdit ? 'true' : 'false' }};
      if(!isEdit && !this.files.length) {
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });

    if(panjangInput) {
      panjangInput.addEventListener('blur', function() {
        const errorMsg = document.getElementById('length_error');
        if(!this.value || this.value <= 0) {
          errorMsg.style.display = 'block';
        } else {
          errorMsg.style.display = 'none';
        }
      });
    }
    
    if(lebarInput) {
      lebarInput.addEventListener('blur', function() {
        const errorMsg = document.getElementById('width_error');
        if(!this.value || this.value <= 0) {
          errorMsg.style.display = 'block';
        } else {
          errorMsg.style.display = 'none';
        }
      });
    }

    document.getElementById('qty')?.addEventListener('blur', function() {
      const errorMsg = document.getElementById('qty_error');
      if(!this.value || this.value < 1) {
        errorMsg.style.display = 'block';
      } else {
        errorMsg.style.display = 'none';
      }
    });
  });
  let currentImageIndex = 0;
  let imageUrls = [];

  function openImagePreview(imageSrc, imageIndex = 0) {
    imageUrls = [];
    const carouselImages = document.querySelectorAll('#productCarousel .carousel-item img');
    carouselImages.forEach(img => {
      if (img.src && !img.src.includes('nophoto.png')) {
        imageUrls.push(img.src);
      }
    });
    
    if (imageUrls.length === 0) {
      imageUrls.push(imageSrc);
    }
    
    currentImageIndex = imageIndex;
    
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'), {
      backdrop: true,
      keyboard: true
    });
    
    updateModalImage();
    modal.show();
  }

  function updateModalImage() {
    const previewImage = document.getElementById('previewImage');
    const counter = document.getElementById('imageCounter');
    const prevBtn = document.querySelector('.nav-prev');
    const nextBtn = document.querySelector('.nav-next');
    
    if (imageUrls.length > 0) {
      previewImage.src = imageUrls[currentImageIndex];
      
      counter.textContent = `${currentImageIndex + 1} / ${imageUrls.length}`;
      
      prevBtn.disabled = currentImageIndex === 0;
      nextBtn.disabled = currentImageIndex === imageUrls.length - 1;
      
      const navOverlay = document.querySelector('.image-nav-overlay');
      navOverlay.style.display = imageUrls.length > 1 ? 'flex' : 'none';
      
      const counterEl = document.querySelector('.image-counter');
      counterEl.style.display = imageUrls.length > 1 ? 'block' : 'none';
    }
  }

  function navigateImage(direction) {
    const newIndex = currentImageIndex + direction;
    if (newIndex >= 0 && newIndex < imageUrls.length) {
      currentImageIndex = newIndex;
      updateModalImage();
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('imagePreviewModal');
    const previewImage = document.getElementById('previewImage');
    
    document.addEventListener('keydown', function(e) {
      const modalInstance = bootstrap.Modal.getInstance(modal);
      if (modalInstance) {
        if (e.key === 'Escape') {
          modalInstance.hide();
        } else if (e.key === 'ArrowLeft') {
          navigateImage(-1);
        } else if (e.key === 'ArrowRight') {
          navigateImage(1);
        }
      }
    });
    
    previewImage.addEventListener('click', function() {
      this.classList.toggle('zoomed');
    });
    
    modal.addEventListener('click', function(e) {
      if (e.target === modal || e.target.classList.contains('marketplace-body')) {
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) {
          modalInstance.hide();
        }
      }
    });
    
    previewImage.addEventListener('click', function(e) {
      e.stopPropagation();
    });
    
    document.querySelector('.image-nav-overlay').addEventListener('click', function(e) {
      e.stopPropagation();
    });
    
    modal.addEventListener('hidden.bs.modal', function() {
      previewImage.classList.remove('zoomed');
      previewImage.src = '';
      currentImageIndex = 0;
      imageUrls = [];
    });
    
    const carouselImages = document.querySelectorAll('#productCarousel .carousel-item img');
    carouselImages.forEach((img, index) => {
      img.setAttribute('onclick', `openImagePreview('${img.src}', ${index})`);
    });
  });
</script>

@endsection