<div class="fixed-top px-0">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{ asset('landingpage/img/sinau_logo.png') }}"
             alt="Sinau Logo"
             style="max-height:70px; width:auto;">
      </a>

      <!-- Burger Mobile -->
      <button class="navbar-toggler me-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Desktop Menu -->
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0" style="font-family: 'Barlow', sans-serif">
          <a href="{{ url('/') }}"
             class="nav-item nav-link px-3 {{ request()->is('/') ? 'active' : '' }}"
             style="font-size:14px;">
            BERANDA
          </a>

          <!-- SEMUA PRODUK Trigger -->
          <a href="{{ url('/products') }}"
             class="nav-item nav-link px-3 d-flex align-items-center {{ request()->is('products*') ? 'active' : '' }}"
             style="font-size:14px;">
            SEMUA PRODUK
            <i class="fas fa-angle-down ms-1"
               id="allProductsTrigger"
               style="cursor:pointer;"></i>
          </a>

          <a href="{{ url('/about') }}"
             class="nav-item nav-link px-3 d-flex align-items-center {{ request()->is('about*') ? 'active' : '' }}"
             style="font-size:14px;">
            TENTANG SINAU
            <i class="fas fa-angle-down ms-1"
               id="aboutTrigger"
               style="cursor:pointer;"></i>
          </a>

          <a class="nav-item nav-link px-3 d-flex align-items-center" href="{{ url('/order-guide') }}" {{ request()->is('order-guide') ? 'active' : '' }}
             style="font-size:14px;">
            CARA PESAN
            <i class="fas fa-angle-down ms-1"
               id="howToTrigger"
               style="cursor:pointer;"></i>
          </a>

          <a href="{{ url('/artikel') }}"
             class="nav-item nav-link px-3 {{ request()->is('artikel') ? 'active' : '' }}"
             style="font-size:14px;">
            ARTIKEL
          </a>

          <a href="{{ url('/faq') }}"
             class="nav-item nav-link px-3 {{ request()->is('faq') ? 'active' : '' }}"
             style="font-size:14px;">
            FAQ
          </a>
        </div>

        <!-- Icons + Login/User -->
        <ul class="navbar-nav ms-auto d-flex align-items-center">
          <!-- Search -->
          <li class="nav-item me-3">
            <button class="btn btn-link p-0 text-secondary" data-bs-toggle="modal" data-bs-target="#searchModal">
              <i class="fas fa-search fa-2x" style="font-size: 22px; color: #888888"></i>
            </button>
          </li>
          <!-- Notifications -->
          <li class="nav-item dropdown">
            <button id="notifBtn"
                    class="btn btn-link text-secondary position-relative"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
              <i class="fas fa-bell fa-lg" style="font-size: 22px; color: #888888"></i>
              @if($notifications->where('notification_status', false)->count())
                <span class="position-absolute top-0 end-2 translate-middle badge rounded-pill bg-danger"
                      style="width:10px; height:10px; padding:0; background-color: #fc2865 !important;">
                </span>
              @endif
            </button>

            <div class="dropdown-menu dropdown-menu-end cart-dropdown p-0">
              <div class="cart-header px-3 py-2 d-flex justify-content-between align-items-center">
                <span style="font-family:'Poppins'; font-weight:700; font-size:1rem; color:#000; margin-top: 10px; padding:15px 20px;">
                  Notifikasi Anda
                </span>
                <a href="{{ url('/profile?#pane-notif') }}" class="lihat-semua small text-decoration-none">
                  LIHAT SEMUA &gt;
                </a>
              </div>

              <div class="cart-list" style="max-height: 750px; overflow-y: auto;">
                @forelse($notifications->where('notification_status', false) as $notif)
                  @php
                    $typeClass = match ($notif->notification_type) {
                      'Pembelian' => 'badge-purchase',
                      'Promo'     => 'badge-promo',
                      'Profil'    => 'badge-profil',
                      default     => 'badge-profil',
                    };
                  @endphp
                  <div class="notif-item px-3 py-2" data-id="{{ $notif->id }}" style="cursor:pointer;">
                    <div class="mb-1">
                      <span class="notification-badge {{ $typeClass }}">
                        {{ strtoupper($notif->notification_type) }}
                      </span>
                    </div>
                    <div style="font-family:'Poppins'; font-weight:550; font-size:0.9rem; color:#000; text-transform:uppercase">{{ Str::limit($notif->notification_head ?? 'Notifikasi', 30) }}</div>
                    <div style="font-family:'Poppins'; font-weight:500; font-size:0.8rem; color:#25252544;">{{ Str::limit($notif->notification_body, 80) }}</div>
                    <div class="text-end"><small class="text-muted">{{ $notif->created_at->format('d M Y') }}</small></div>
                  </div>
                @empty
                  <div class="text-center p-3 text-muted">Tidak ada notifikasi baru.</div>
                @endforelse
              </div>
            </div>
          </li>

          <!-- Cart Dropdown -->
          <li class="nav-item dropdown me-3">
            <button class="btn btn-link p-0 text-secondary position-relative"
                    id="cartBtn"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
              <i class="fas fa-shopping-cart fa-2x" style="font-size: 22px; color: #888888"></i>
              @if($cartCount)
                <span class="position-absolute top-0 end-2 translate-middle badge rounded-pill bg-danger" style="font-family:'Poppins'; width:15px; height:15px; padding:3px; font-size:0.7rem; font-weight:400; background-color: #fc2865 !important;">
                  {{ $cartCount }}
                </span>
              @endif
            </button>
            <div class="dropdown-menu dropdown-menu-end cart-dropdown p-0">
              {{-- Header --}}
              <div class="cart-header px-3 py-2 d-flex justify-content-between align-items-center">
                <span style="font-family:'Poppins'; font-weight:700; font-size:1rem; color:#000; margin-top: 10px; padding:15px 20px;">Keranjang Kamu  ({{ $cartCount }})</span>
                <a href="{{ url('/keranjang') }}" class="lihat-semua small text-decoration-none">LIHAT SEMUA &gt;</a>
              </div>
              {{-- List Barang --}}
              <div class="cart-list" style="max-height: 400px; overflow-y: auto;">
                @forelse($cartItems as $item)
                  @php
                    $prod = $item->product;
                    $hasNote = !empty($item->order->notes);
                  @endphp
                  <div class="cart-item px-3 py-2 d-flex">
                    <div class="d-flex align-items-start" style="gap: 12px; flex: 1;">
                      <img src="{{ $prod->images->first()
                                  ? asset('landingpage/img/product/'.$prod->images->first()->image_product)
                                  : asset('landingpage/img/nophoto.png') }}"
                          alt="Produk"
                          style="width:60px; height:60px; object-fit:cover; border-radius:6px;">
                      <div class="flex-grow-1">
                        <div style="font-family:'Poppins'; font-weight:600; font-size:0.9rem; color:#000;">{{ $prod->name }}</div>
                        <div style="font-family:'Poppins'; font-weight:400; font-size:0.9rem; color:#888888;">
                          {{ intval($prod->long_product) }}×{{ intval($prod->width_product) }}{{ $prod->additional_unit }}
                        </div>
                        @if($hasNote)
                          <div style="font-family:'Poppins'; font-weight:400; font-size:0.8rem; color:#888888;">Detail barang 1 atau note</div>
                        @endif
                      </div>
                    </div>
                    <div class="cart-price text-end" style="font-family:'Poppins'; font-weight:550; font-size:0.8rem; color:#444444;">
                      {{ $item->qty }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}
                    </div>
                  </div>
                @empty
                  <div class="text-center p-3 text-muted">Keranjang kosong.</div>
                @endforelse
              </div>
            </div>
          </li>

          <!-- Chat -->
          <li class="nav-item me-3">
            <a href="#" class="btn btn-link p-0 text-secondary">
              <i class="fas fa-comment fa-2x" style="font-size: 22px; color: #888888"></i>
            </a>
          </li>
          <!-- Separator -->
          <li class="nav-item me-3">
            <div style="width:1px; height:24px; background-color:#e4e4e4; margin: 10px 10px"></div>
          </li>

          @guest
            <li class="nav-item">
              <a href="{{ route('login') }}"
                 class="btn btn-link p-0 d-flex align-items-center text-decoration-none text-dark">
                <img src="{{ asset('landingpage/img/profil_login.png') }}"
                     class="rounded-circle me-2"
                     style="width: 40px; height: 40px;"
                     alt="avatar">
                <span>LOGIN</span>
              </a>
            </li>
          @else
            <li class="nav-item dropdown">
              <a href="#"
                class="btn btn-link p-0 d-flex align-items-center text-decoration-none text-dark"
                data-bs-toggle="dropdown">
                @if(Auth::user()->foto)
                  <img src="{{ url('landingpage/img/' . Auth::user()->foto) }}"
                      class="rounded-circle me-2"
                      style="width: 40px; height: 40px;"
                      alt="avatar">
                @else
                  <img src="{{ asset('landingpage/img/profil_login.png') }}"
                      class="rounded-circle me-2"
                      style="width: 40px; height: 40px;"
                      alt="avatar">
                @endif
                <span>{{ Str::upper(Auth::user()->first_name) }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end profile-dropdown p-2">
                <li class="px-3 py-2" style="font-family:'Poppins'; font-weight:600; font-size:1rem; color:#000; margin-top: 10px; padding:15px 20px;">
                  Hai, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!
                </li>
                <li><a class="dropdown-item" href="{{ url('/profile') }}" style="font-family:'Poppins'; font-weight:500; font-size:1rem; color:#888888; margin-top: 10px; padding:15px 20px;">AKUN ANDA</a></li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-family:'Poppins'; font-weight:500; font-size:1rem; color:#888888; margin-top: 10px; padding:15px 20px;">
                    <i class="fas fa-sign-out-alt"></i>
                    LOGOUT
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                @if(Auth::user()->role!='Customer')
                  <li><a class="dropdown-item" href="{{ url('/admin') }}" style="font-family:'Poppins'; font-weight:500; font-size:1rem; color:#888888;">DASHBOARD</a></li>
                @endif
              </ul>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>
</div>

<!-- Sidebar Mobile -->
{{-- <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar">
  <div class="offcanvas-header header-with-border">
    <a href="{{ url('/') }}" class="navbar-brand ms-4 ms-lg-0">
      <h1 class="fw text-primary m-0 text-center"><img src="{{ asset('landingpage/img/sinau_logo.jpg') }}"
             alt="Sinau Logo"
             style="max-height:80px; width:auto;"></h1>
    </a>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <!-- ... -->
  </div>
</div> --}}

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content position-relative p-0" style="background: url('{{ asset('landingpage/img/search-modals.png') }}') center/cover no-repeat;">
      <!-- Close button -->
      <button id="searchCloseBtn" type="button" class="btn-close position-absolute top-0 end-0 m-4" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body d-flex flex-column justify-content-center align-items-start text-white px-5" style="height:100vh;">
        <!-- Judul -->
        <h2 class="mb-0" style="font-family:'Poppins'; font-weight:700; font-size:3rem; color:#e4e4e4;">
          Udah Siap
        </h2>
        <h2 class="mb-4" style="font-family:'Poppins'; font-weight:700; font-size:3rem; color:#ffc74c;">
          Cetak Hari Ini?
        </h2>

        <!-- Input minimalis -->
        <form action="{{ route('landingpage.products') }}" method="GET" class="w-100" style="max-width:600px;">
          <div class="position-relative">
            <input type="text"
                   name="search"
                   class="form-control border-0 border-bottom border-light bg-transparent text-white ps-0 pe-5"
                   placeholder="lagi cari produk apa?"
                   style="font-family:'Poppins'; font-size:1.25rem; border-radius:0;"
                   value="{{ $search }}">
            <button type="submit" class="position-absolute top-50 end-0 translate-middle-y btn p-0 text-white">
              <i class="fas fa-search" style="font-size:1.25rem;"></i>
            </button>
          </div>
        </form>

        <!-- Paling sering dicari -->
        <div class="mt-5 text-white" style="font-family:'Poppins';">
          <h5 class="mb-3" style="font-weight:600;">Paling sering dicari</h5>
          <div class="d-flex flex-wrap gap-2">
            @foreach($topSearches as $term)
              <a href="{{ route('landingpage.products', ['search' => $term]) }}"
                class="top-search-link"
                style="text-decoration: none;">
                {{ $term }}
              </a>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Products Modal -->
<div class="modal fade" id="productsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl modal-xxl-custom">
    <div class="modal-content" style="border-radius:1rem; overflow:hidden; height:80vh;">
      <div class="modal-body p-0 h-100">
        <div class="row g-0 h-100">
          {{-- Kiri: 4/12 gambar produk --}}
          <div class="col-md-5">
            <div class="products-modal-image">
              <img
                src="{{ asset('landingpage/img/product-modals.png') }}"
                alt="Hero Products"
                class="img-fluid w-100 h-100"
                style="object-fit:cover;"
              >
            </div>
          </div>

          {{-- Kanan: 8/12 judul + daftar label --}}
          <div class="col-md-7 h-100 d-flex flex-column">
            <div class="p-4 overflow-auto">
                <br>
              <a href="#" class="btn-schedule mb-4 d-inline-flex align-items-center ms-0" style="margin-top: 0.5rem; margin-left: 0 !important;">
                <span class="btn-text text-dark" style="font-family: 'Poppins'; font-size:1.2rem; font-weight:550; color: #4d4d4d !important;">
                  JELAJAHI SEMUA PRODUK
                </span>
                <span class="btn-arrow ms-3">
                  <i class="bi bi-arrow-right arrow-out"></i>
                  <i class="bi bi-arrow-right arrow-in"></i>
                </span>
              </a>

              <ul class="labels-list">
                @foreach($labels->take(12) as $lbl)
                  <li>
                    <h5>{{ $lbl->name }}</h5>
                    <p>{{ $lbl->desc }}</p>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-lg-custom">
    <div class="modal-content" style="border-radius:1rem; overflow:hidden; height:80vh;">
      <div class="modal-body p-0 h-100">
        <div class="row g-0 h-100">
          {{-- Kiri: 4/12 gambar produk --}}
          <div class="col-md-7">
            <div class="products-modal-image">
              <img
                src="{{ asset('landingpage/img/about-modals.png') }}"
                alt="Hero Products"
                class="img-fluid w-100 h-100"
                style="object-fit:cover;"
              >
            </div>
          </div>

          {{-- Kanan: 8/12 judul + daftar label --}}
          <div class="col-md-5 h-100 d-flex flex-column">
            <div class="p-3 overflow-auto">
                <br>
              <h3 class="about-title mb-4">
                <span class="me-1">Semua</span><br>
                <span class="text-primary">Tentang</span><br>
                <span class="text-primary">Kami</span>
              </h3>

              <br>
              <a href="{{ url('/about') }}">
              <ul class="labels-list">
                <li>
                  <h5>Tentang Sinau Print</h5>
                  <p>Kenali Sinau Print lebih dekat</p>
                </li>
              </ul>
              </a>
              <br><br>
              <ul class="labels-list">
                <li>
                  <h5>Kontak Sinau Print</h5>
                  <p>Informasi dan kontak perusahaan</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- How To Order Modal -->
<div class="modal fade" id="howToModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-lg-custom">
    <div class="modal-content" style="border-radius:1rem; overflow:hidden; height:80vh; margin: 0 0 0 10000;">
      <div class="modal-body p-0 h-100">
        <div class="row g-0 h-100">
          {{-- Kiri: 4/12 gambar produk --}}
          <div class="col-md-7">
            <div class="products-modal-image">
              <img
                src="{{ asset('landingpage/img/howto-modals.png') }}"
                alt="Hero Products"
                class="img-fluid w-100 h-100"
                style="object-fit:cover;"
              >
            </div>
          </div>

          {{-- Kanan: 8/12 judul + daftar label --}}
          <div class="col-md-5 h-100 d-flex flex-column">
            <div class="p-4 overflow-auto">
                <br>
              <h3 class="about-title mb-4">
                <span class="me-1">Cara</span><br>
                <span class="me-1">Pesan dan</span><br>
                <span class="text-primary">Konsultasi</span>
              </h3>

              <br>
              <ul class="labels-list">
                <li>
                  <h5>Cara Pesan</h5>
                  <p>Panduan lengkap pemesanan online di Sinau Print</p>
                </li>
              </ul>
              <br><br>
              <ul class="labels-list">
                <li>
                  <h5>Konsultasi</h5>
                  <p>Konsultasi online & offline bareng Sinau Print</p>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // === Notifikasi handler ===
  const notifDropdown = document.querySelector('.notif-dropdown');
  const notifBtn = document.getElementById('notifBtn');

  if (notifBtn) {
    notifBtn.addEventListener('shown.bs.dropdown', () => {
      notifDropdown.querySelectorAll('.notif-item').forEach(item => {
        item.addEventListener('click', function () {
          const id = this.dataset.id;
          fetch(`{{ url('/readnotif') }}/${id}`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json'
            }
          })
          .then(res => {
            if (!res.ok) throw new Error('Gagal connect');
            this.remove();
            if (!notifDropdown.querySelector('.notif-item')) {
              notifDropdown.querySelector('.notif-list').innerHTML =
                '<div class="text-center p-3 text-muted">Tidak ada notifikasi baru.</div>';
            }
          })
          .catch(console.error);
        });
      });
    });
  }

  // === Modal Triggers on Hover with Auto-Hide ===
  const modalTriggers = [
    { id: 'allProductsTrigger', modalId: 'productsModal' },
    { id: 'aboutTrigger', modalId: 'aboutModal' },
    { id: 'howToTrigger', modalId: 'howToModal' },
  ];

  modalTriggers.forEach(trigger => {
    const triggerEl = document.getElementById(trigger.id);
    const modalEl = document.getElementById(trigger.modalId);
    let modalInstance = null;
    let hideTimeout = null;

    if (triggerEl && modalEl) {
      // Show modal on hover
      triggerEl.addEventListener('mouseenter', () => {
        modalInstance = new bootstrap.Modal(modalEl);
        modalInstance.show();
      });

      // Start hiding modal when mouse leaves trigger
      triggerEl.addEventListener('mouseleave', () => {
        hideTimeout = setTimeout(() => {
          if (modalInstance) modalInstance.hide();
        }, 200);
      });

      // Cancel hide if mouse enters modal
      modalEl.addEventListener('mouseenter', () => {
        if (hideTimeout) clearTimeout(hideTimeout);
      });

      // Hide modal if mouse leaves modal area
      modalEl.addEventListener('mouseleave', () => {
        if (modalInstance) modalInstance.hide();
      });
    }
  });
});
</script>





<style>
  .modal {
    pointer-events: none;
  }
  .modal-dialog {
    pointer-events: auto;
  }
  .nav-link.active {
    position: relative;
    font-weight: bold;
    padding-left: 24px !important;
  }

  .nav-link.active::before {
    content: '';
    width: 7px;
    height: 7px;
    background-color: #0258d3;
    position: absolute;
    left: 8px;
    top: 50%;
    transform: translateY(-50%) rotate(45deg);
    border-radius: 1px;
  }
  /* Pastikan modal bisa diklik dan tombol close tidak diblok */
  #searchModal {
    pointer-events: auto !important;
  }

  #searchModal .modal-content {
    pointer-events: auto !important;
  }

  #searchCloseBtn {
    z-index: 1056 !important;
    position: absolute !important;
    top: 1rem !important;
    right: 1rem !important;
    opacity: 1 !important;
    pointer-events: auto !important;
  }

  /* Tambahan defensif untuk pastikan tombol bisa diakses */
  #searchCloseBtn::before {
    display: none !important;
  }
/* Gaya Dropdown Notifikasi seperti modal */
.notif-dropdown {
  width: 300px;
  border-radius: 1rem;
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
  overflow: hidden;
}

/* List scrollable */
.notif-list {
  max-height: 350px;
  overflow-y: auto;
  background: #fff;
}

/* Item hover */
.notif-item:hover {
  background-color: #f5faff;
}

.notification-badge {
  display: inline-block;
  padding: 0.25em 0.6em;
  font-size: 0.9rem;
  font-weight: 550;
  border-radius: 0.5rem;
  text-transform: uppercase;
  font-family: 'Poppins', sans-serif;
  margin-bottom: 0.5rem;
}

/* warna sudah kamu definisikan */
.badge-purchase { background-color: #03a7a7; color: #fff; }
.badge-promo    { background-color: #fc2965; color: #fff; }
.badge-profil   { background-color: #0258d3; color: #fff; }

.profile-dropdown {
    min-width: 260px;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
  }

/* Dropdown keranjang */
.cart-dropdown {
  width: 420px;              /* diperlebar */
  border-radius: 1rem;
  box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
  overflow: hidden;
}

/* Header tipis */
.cart-header {
  background: #fff;
}

/* List scrollable */
.cart-list {
  background: #fff;
}

/* Item hover */
.cart-item:hover {
  background-color: #f8f9fa;
}

/* Style default */
.lihat-semua {
  font-family: 'Poppins';
  font-weight: 550;
  font-size: 0.7rem;
  color: #05d1d1;
  margin-top: 10px;
  transition: color 0.2s, background-color 0.2s;
}

/* Style saat hover */
.lihat-semua:hover {
  color: #028b8b;
  text-decoration: underline;
}

</style>