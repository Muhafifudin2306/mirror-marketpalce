<div class="fixed-top px-0">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="">
                <img src="{{ asset('landingpage/img/sinau_logo.png') }}" alt="Sinau Logo"
                    style="max-height:70px; width:auto;">
            </a>

            <!-- Burger Mobile -->
            <button class="navbar-toggler m-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Sidebar Mobile -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar">
                <div class="offcanvas-header p-4 border">
                    <h5 id="offcanvasTopLabel" class="fw-bold fs-600 font-first">Menu Navigasi</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body p-4">
                    <div class="navbar-nav ms-auto d-inline d-xl-none" style="">
                        <a href="{{ url('/') }}"
                            class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('/') ? 'active' : '' }}">
                            BERANDA
                        </a>

                        <!-- SEMUA PRODUK Trigger -->
                        <a href="{{ url('/products') }}"
                            class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('products*') ? 'active' : '' }}">
                            SEMUA PRODUK
                        </a>

                        <a href="{{ url('/about') }}"
                            class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('about*') ? 'active' : '' }}">
                            TENTANG SINAU
                        </a>

                        <a class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('order-guide*') ? 'active' : '' }}"
                            href="{{ url('/order-guide') }}">
                            CARA PESAN
                        </a>

                        <a href="{{ url('/articles') }}"
                            class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('articles') ? 'active' : '' }}">
                            ARTIKEL
                        </a>

                        <a href="{{ url('/faq') }}"
                            class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('faq') ? 'active' : '' }}">
                            FAQ
                        </a>

                        <a href="{{ url('/profile?#pane-notif') }}"
                            class="nav-item nav-link font-first d-inline d-xl-none fw-600 fs-13-px d-flex align-items-center ">
                            NOTIFIKASI
                        </a>

                        <a href="{{ url('/keranjang') }}"
                            class="nav-item nav-link font-first d-inline d-xl-none fw-600 fs-13-px d-flex align-items-center ">
                            KERANJANG
                        </a>

                        <a href="{{ url('/chats') }}"
                            class="nav-item nav-link d-inline d-xl-none font-first fw-600 fs-13-px d-flex align-items-center ">
                            CHAT ADMIN
                        </a>

                        @guest
                            <a href="{{ route('login') }}"
                                class="nav-item nav-link font-first d-inline d-xl-none fw-600 fs-13-px d-flex align-items-center ">
                                LOGIN
                            </a>

                            <a href="{{ route('register') }}"
                                class="nav-item nav-link d-inline d-xl-none font-first fw-600 fs-13-px d-flex align-items-center ">
                                REGISTER
                            </a>
                        @else
                            <a href="{{ url('/profile') }}"
                                class="nav-item nav-link font-first d-inline d-xl-none fw-600 fs-13-px d-flex align-items-center ">
                                AKUN ANDA
                            </a>

                            <a href="{{ url('/chats') }}"
                                class="nav-item nav-link d-inline d-xl-none font-first fw-600 fs-13-px d-flex align-items-center "
                                href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                LOGOUT
                            </a>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Desktop Menu -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="{{ url('/') }}"
                        class="nav-item nav-link font-first fw-600 fs-13-px {{ request()->is('/') ? 'active' : '' }}">
                        BERANDA
                    </a>

                    <!-- SEMUA PRODUK Trigger -->
                    <a href="{{ url('/products') }}"
                        class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('products*') ? 'active' : '' }}">
                        SEMUA PRODUK
                        <i class="fas fa-angle-down ms-1" id="allProductsTrigger" style="cursor:pointer;"></i>
                    </a>

                    <a href="{{ url('/about') }}"
                        class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('about*') ? 'active' : '' }}">
                        TENTANG SINAU
                        <i class="fas fa-angle-down ms-1" id="aboutTrigger" style="cursor:pointer;"></i>
                    </a>

                    <a class="nav-item nav-link font-first fw-600 fs-13-px d-flex align-items-center {{ request()->is('order-guide*') ? 'active' : '' }}"
                        href="{{ url('/order-guide') }}">
                        CARA PESAN
                        <i class="fas fa-angle-down ms-1" id="howToTrigger" style="cursor:pointer;"></i>
                    </a>

                    <a href="{{ url('/articles') }}"
                        class="nav-item nav-link font-first fw-600 fs-13-px {{ request()->is('articles') ? 'active' : '' }}">
                        ARTIKEL
                    </a>

                    <a href="{{ url('/faq') }}"
                        class="nav-item nav-link font-first fw-600 fs-13-px {{ request()->is('faq') ? 'active' : '' }}">
                        FAQ
                    </a>
                </div>

                <!-- Icons + Login/User -->
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Search -->
                    <li class="nav-item me-3">
                        <button class="btn btn-link p-0 text-secondary" data-bs-toggle="modal"
                            data-bs-target="#searchModal">
                            <i class="fas fa-search fa-2x" style="font-size: 18px; color: #888888"></i>
                        </button>
                    </li>

                    <!-- Notifications -->
                    <li class="nav-item dropdown position-relative me-3">
                        <button id="notifBtn" class="btn btn-link text-secondary position-relative dropdown-btn"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="fas fa-bell fa-lg" style="font-size: 18px; color: #888888"></i>
                            @if ($notifications->where('notification_status', false)->count())
                                <span class="notification-badge-dot"></span>
                            @endif
                        </button>

                        <div class="dropdown-menu modern-dropdown notification-dropdown">
                            <div class="dropdown-header">
                                <h6 class="dropdown-title">Notifikasi Anda</h6>
                                <a href="{{ url('/profile?#pane-notif') }}" class="view-all-link">
                                    LIHAT SEMUA
                                </a>
                            </div>

                            <div class="dropdown-body">
                                @forelse($notifications->where('notification_status', false)->take(5) as $notif)
                                    @php
                                        $typeClass = match ($notif->notification_type) {
                                            'Pembelian' => 'badge-purchase',
                                            'Promo' => 'badge-promo',
                                            'Profil' => 'badge-profil',
                                            default => 'badge-profil',
                                        };
                                    @endphp
                                    <div class="notification-item" data-id="{{ $notif->id }}">
                                        <div class="notification-content">
                                            <span class="notification-type-badge {{ $typeClass }}">
                                                {{ strtoupper($notif->notification_type) }}
                                            </span>
                                            <h6 class="notification-title">
                                                {{ Str::limit($notif->notification_head ?? 'Notifikasi', 35) }}
                                            </h6>
                                            <p class="notification-text">
                                                {{ Str::limit($notif->notification_body, 90) }}
                                            </p>
                                            <small class="notification-date">
                                                {{ $notif->created_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        <i class="fas fa-bell-slash"></i>
                                        <p>Tidak ada notifikasi baru</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </li>

                    <!-- Cart Dropdown -->
                    <li class="nav-item dropdown position-relative me-3">
                        <button class="btn btn-link p-0 text-secondary position-relative dropdown-btn" id="cartBtn"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="fas fa-shopping-cart fa-2x" style="font-size: 18px; color: #888888"></i>
                            @if ($cartCount)
                                <span class="cart-badge-count">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </button>

                        <div class="dropdown-menu modern-dropdown cart-dropdown">
                            <div class="dropdown-header">
                                <h6 class="dropdown-title">Keranjang Anda ({{ $cartCount }})</h6>
                                <a href="{{ url('/keranjang') }}" class="view-all-link">
                                    LIHAT SEMUA
                                </a>
                            </div>

                            <div class="dropdown-body">
                                @forelse($cartItems->take(4) as $item)
                                    @php
                                        $prod = $item->product;
                                        $hasNote = !empty($item->order->notes);
                                        $image = $prod->images->first();
                                    @endphp
                                    <div class="cart-item">
                                        <div class="cart-item-image">
                                            @if($image && $image->image_product && file_exists(storage_path('app/public/' . $image->image_product)))
                                                <img src="{{ asset('storage/' . $image->image_product) }}" 
                                                    alt="{{ $prod->name }}">
                                            @else
                                                <img src="{{ asset('landingpage/img/nophoto.png') }}" 
                                                    alt="No Image">
                                            @endif
                                        </div>
                                        
                                        <div class="cart-item-content">
                                            <h6 class="cart-item-title">{{ Str::limit($prod->name, 30) }}</h6>
                                            <p class="cart-item-size">
                                                @if($prod->long_product && $prod->width_product)
                                                    {{ intval($prod->long_product) }}×{{ intval($prod->width_product) }}{{ $prod->additional_unit }}
                                                @else
                                                    {{ $prod->additional_size }} {{ $prod->additional_unit }}
                                                @endif
                                            </p>
                                            @if ($hasNote)
                                                <p class="cart-item-note">{{ Str::limit($item->order->notes, 25) }}</p>
                                            @endif
                                            <div class="cart-item-price">
                                                {{ $item->qty }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="empty-state">
                                        <i class="fas fa-shopping-cart"></i>
                                        <p>Keranjang masih kosong</p>
                                        <a href="{{ route('landingpage.products') }}" class="btn btn-primary btn-sm">
                                            Mulai Belanja
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </li>

                    <!-- Chat -->
                    <li class="nav-item me-3">
                        <a href="{{ url('/chats') }}" class="btn btn-link p-0 text-secondary">
                            <i class="fas fa-comment fa-2x" style="font-size: 18px; color: #888888"></i>
                        </a>
                    </li>

                    <!-- Separator -->
                    <li class="nav-item me-3">
                        <div class="nav-separator"></div>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}"
                                class="btn btn-link p-0 d-flex align-items-center text-decoration-none text-dark">
                                <img src="{{ asset('landingpage/img/profil_login.png') }}" class="rounded-circle me-2"
                                    style="width: 40px; height: 40px;" alt="avatar">
                                <span class="font-first fw-600">LOGIN</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a href="#"
                                class="btn btn-link p-0 d-flex align-items-center text-decoration-none text-dark dropdown-btn"
                                data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                @if (Auth::user()->foto)
                                    <img src="{{ url('landingpage/img/' . Auth::user()->foto) }}"
                                        class="rounded-circle me-2" style="width: 40px; height: 40px;" alt="avatar">
                                @else
                                    <img src="{{ asset('landingpage/img/profil_login.png') }}"
                                        class="rounded-circle me-2" style="width: 40px; height: 40px;" alt="avatar">
                                @endif
                                <span class="font-first fw-600">{{ Str::upper(Auth::user()->first_name) }}</span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end profile-dropdown p-2">
                                <div class="py-2"
                                    style="font-family:'Poppins';  font-size:1rem; color:#000; margin-top: 10px; padding:15px 20px;">
                                    Hai, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!
                                </div>
                                <a class="dropdown-item" href="{{ url('/profile') }}"
                                    style="font-family:'Poppins'; font-weight:500; font-size:1rem; color:#888888; margin-top: 10px; padding:15px 20px;">
                                    AKUN ANDA
                                </a>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    style="font-family:'Poppins'; font-weight:500; font-size:1rem; color:#888888; margin-top: 10px; padding:15px 20px;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    LOGOUT
                                </a>
                                <hr class="dropdown-divider">
                                @if (Auth::user()->role != 'Customer')
                                    <a class="dropdown-item" href="{{ url('/admin') }}"
                                        style="font-family:'Poppins'; font-weight:500; font-size:1rem; color:#888888;">
                                        DASHBOARD
                                    </a>
                                @endif
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content position-relative p-0"
            style="background: url('{{ asset('landingpage/img/search-modals.png') }}') center/cover no-repeat;">
            <!-- Close button -->
            <button id="searchCloseBtn" type="button" class="btn-close position-absolute top-0 end-0 m-4"
                data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body d-flex flex-column justify-content-center align-items-start text-white px-5"
                style="height:100vh;">
                <!-- Judul -->
                <h2 class="mb-0 search-title-1">Udah Siap</h2>
                <h2 class="mb-4 search-title-2">Cetak Hari Ini?</h2>

                <!-- Input minimalis -->
                <form action="{{ route('landingpage.products') }}" method="GET" class="w-100 search-form">
                    <div class="position-relative">
                        <input type="text" name="search"
                            class="form-control search-input"
                            placeholder="lagi cari produk apa?"
                            value="{{ $search }}">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Paling sering dicari -->
                <div class="mt-5 text-white popular-searches">
                    <h5 class="mb-3 popular-title">Paling sering dicari</h5>
                    <div class="popular-list">
                        @foreach (array_slice($topSearches, 0, 5) as $term)
                            <a href="{{ route('landingpage.products', ['search' => $term]) }}"
                                class="popular-search-item">
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
                    <div class="col-md-5">
                        <div class="products-modal-image">
                            <img src="{{ asset('landingpage/img/product-modals.png') }}" alt="Hero Products"
                                class="img-fluid w-100 h-100" style="object-fit:cover;">
                        </div>
                    </div>
                    <div class="col-md-7 h-100 d-flex flex-column">
                        <div class="p-4 overflow-auto">
                            <br>
                            <a href="#" class="btn-schedule mb-4 d-inline-flex align-items-center ms-0"
                                style="margin-top: 0.5rem; margin-left: 0 !important;">
                                <span class="btn-text text-dark"
                                    style="font-family: 'Poppins'; font-size:1.2rem; font-weight:550; color: #4d4d4d !important;">
                                    JELAJAHI SEMUA PRODUK
                                </span>
                                <span class="btn-arrow ms-3">
                                    <i class="bi bi-arrow-right arrow-out"></i>
                                    <i class="bi bi-arrow-right arrow-in"></i>
                                </span>
                            </a>
                            <ul class="labels-list">
                                @foreach ($labels->take(12) as $lbl)
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
                    <div class="col-md-7">
                        <div class="products-modal-image">
                            <img src="{{ asset('landingpage/img/about-modals.png') }}" alt="Hero Products"
                                class="img-fluid w-100 h-100" style="object-fit:cover;">
                        </div>
                    </div>
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
                    <div class="col-md-7">
                        <div class="products-modal-image">
                            <img src="{{ asset('landingpage/img/howto-modals.png') }}" alt="Hero Products"
                                class="img-fluid w-100 h-100" style="object-fit:cover;">
                        </div>
                    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // === Initialize Bootstrap dropdowns with custom settings ===
    const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdownElements.forEach(element => {
        new bootstrap.Dropdown(element, {
            autoClose: 'outside',
            boundary: 'viewport'
        });
    });

    // === Notification Handler ===
    const notifBtn = document.getElementById('notifBtn');
    const notifDropdown = document.querySelector('.notification-dropdown');
    
    if (notifBtn && notifDropdown) {
        notifBtn.addEventListener('shown.bs.dropdown', () => {
            const notifItems = notifDropdown.querySelectorAll('.notification-item');
            notifItems.forEach(item => {
                item.addEventListener('click', function() {
                    const id = this.dataset.id;
                    if (id) {
                        fetch(`{{ url('/readnotif') }}/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                this.style.animation = 'fadeOut 0.3s ease';
                                setTimeout(() => {
                                    this.remove();
                                    
                                    const remainingNotifs = notifDropdown.querySelectorAll('.notification-item');
                                    if (remainingNotifs.length === 0) {
                                        const dropdownBody = notifDropdown.querySelector('.dropdown-body');
                                        dropdownBody.innerHTML = `
                                            <div class="empty-state">
                                                <i class="fas fa-bell-slash"></i>
                                                <p>Tidak ada notifikasi baru</p>
                                            </div>
                                        `;
                                        
                                        const badge = notifBtn.querySelector('.notification-badge-dot');
                                        if (badge) {
                                            badge.remove();
                                        }
                                    } else {
                                        if (remainingNotifs.length === 0) {
                                            const badge = notifBtn.querySelector('.notification-badge-dot');
                                            if (badge) {
                                                badge.remove();
                                            }
                                        }
                                    }
                                }, 300);
                            }
                        })
                        .catch(error => {
                            console.error('Error marking notification as read:', error);
                        });
                    }
                });
            });
        });
    }

    // === Modal Triggers for Hover (Desktop only) ===
    const modalTriggers = [
        { id: 'allProductsTrigger', modalId: 'productsModal' },
        { id: 'aboutTrigger', modalId: 'aboutModal' },
        { id: 'howToTrigger', modalId: 'howToModal' }
    ];

    // Only enable hover modals on desktop
    if (window.innerWidth > 768) {
        modalTriggers.forEach(trigger => {
            const triggerEl = document.getElementById(trigger.id);
            const modalEl = document.getElementById(trigger.modalId);
            let modalInstance = null;
            let hideTimeout = null;

            if (triggerEl && modalEl) {
                triggerEl.addEventListener('mouseenter', () => {
                    if (hideTimeout) {
                        clearTimeout(hideTimeout);
                        hideTimeout = null;
                    }
                    
                    if (!modalInstance) {
                        modalInstance = new bootstrap.Modal(modalEl, {
                            backdrop: false,
                            keyboard: true
                        });
                    }
                    modalInstance.show();
                });

                triggerEl.addEventListener('mouseleave', () => {
                    hideTimeout = setTimeout(() => {
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }, 300);
                });

                modalEl.addEventListener('mouseenter', () => {
                    if (hideTimeout) {
                        clearTimeout(hideTimeout);
                        hideTimeout = null;
                    }
                });

                modalEl.addEventListener('mouseleave', () => {
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                });

                modalEl.addEventListener('hidden.bs.modal', () => {
                    modalInstance = null;
                });
            }
        });
    }

    const searchModal = document.getElementById('searchModal');
    const searchInput = searchModal?.querySelector('.search-input');
    
    if (searchModal && searchInput) {
        searchModal.addEventListener('shown.bs.modal', () => {
            setTimeout(() => {
                searchInput.focus();
            }, 300);
        });
    }

    document.querySelectorAll('.dropdown-item-custom').forEach(item => {
        item.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
            }
        });
    });

    const cartItems = document.querySelectorAll('.cart-item');
    cartItems.forEach(item => {
        item.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // === Responsive Dropdown Positioning ===
    function adjustDropdownPosition() {
        const dropdowns = document.querySelectorAll('.dropdown-menu.modern-dropdown');
        dropdowns.forEach(dropdown => {
            const rect = dropdown.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            
            dropdown.style.transform = '';
            
            if (rect.right > viewportWidth - 20) {
                dropdown.style.left = 'auto';
                dropdown.style.right = '0';
                dropdown.style.transform = 'translateY(8px)';
            }
            
            if (rect.left < 20) {
                dropdown.style.left = '0';
                dropdown.style.right = 'auto';
                dropdown.style.transform = 'translateY(8px)';
            }
        });
    }

    document.addEventListener('shown.bs.dropdown', adjustDropdownPosition);
    
    window.addEventListener('resize', () => {
        if (document.querySelector('.dropdown-menu.show')) {
            adjustDropdownPosition();
        }
    });
});

const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(-20px); }
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .notification-item {
        animation: slideIn 0.3s ease-out;
    }
    
    .cart-item {
        animation: slideIn 0.3s ease-out;
    }
    
    .dropdown-item-custom {
        animation: slideIn 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>

<style>
/* ===== DROPDOWN STYLES ===== */
.modern-dropdown {
    min-width: 350px;
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    padding: 0;
    background: #fff;
    transform: translateY(8px);
    animation: dropdownFadeIn 0.3s ease-out;
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(8px);
    }
}

/* Dropdown positioning */
.dropdown-menu.modern-dropdown {
    left: 50% !important;
    transform: translateX(-50%) translateY(8px) !important;
}

.profile-dropdown {
    left: auto !important;
    right: 0 !important;
    transform: translateY(8px) !important;
    min-width: 280px;
}

/* ===== DROPDOWN HEADERS ===== */
.dropdown-header {
    padding: 20px 24px 16px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: between;
    align-items: center;
    background: #fff;
    border-radius: 16px 16px 0 0;
}

.dropdown-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 1rem;
    color: #2c3e50;
    margin: 0;
    flex: 1;
}

.view-all-link {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #3498db;
    text-decoration: none;
    transition: color 0.2s ease;
}

.view-all-link:hover {
    color: #2980b9;
    text-decoration: underline;
}

/* ===== DROPDOWN BODY ===== */
.dropdown-body {
    max-height: 400px;
    overflow-y: auto;
    padding: 8px 0 16px;
}

/* Custom scrollbar */
.dropdown-body::-webkit-scrollbar {
    width: 4px;
}

.dropdown-body::-webkit-scrollbar-track {
    background: #f8f9fa;
}

.dropdown-body::-webkit-scrollbar-thumb {
    background: #dee2e6;
    border-radius: 2px;
}

/* ===== NOTIFICATION STYLES ===== */
.notification-dropdown {
    min-width: 380px;
}

.notification-item {
    padding: 16px 24px;
    border-bottom: 1px solid #f8f9fa;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-type-badge {
    display: inline-block;
    padding: 4px 10px;
    font-size: 0.7rem;
    font-weight: 600;
    border-radius: 12px;
    text-transform: uppercase;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 8px;
}

.badge-purchase {
    background-color: #03a7a7;
    color: #fff;
}

.badge-promo {
    background-color: #fc2965;
    color: #fff;
}

.badge-profil {
    background-color: #0258d3;
    color: #fff;
}

.notification-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    color: #2c3e50;
    margin: 0 0 6px 0;
    line-height: 1.3;
}

.notification-text {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 0.85rem;
    color: #6c757d;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.notification-date {
    font-family: 'Poppins', sans-serif;
    font-size: 0.75rem;
    color: #95a5a6;
}

/* ===== CART STYLES ===== */
.cart-dropdown {
    min-width: 380px;
}

.cart-item {
    padding: 16px 24px;
    border-bottom: 1px solid #f8f9fa;
    display: flex;
    gap: 16px;
    transition: background-color 0.2s ease;
}

.cart-item:hover {
    background-color: #f8f9fa;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item-image {
    flex-shrink: 0;
}

.cart-item-image img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.cart-item-content {
    flex: 1;
    min-width: 0;
}

.cart-item-title {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    color: #2c3e50;
    margin: 0 0 6px 0;
    line-height: 1.3;
}

.cart-item-size {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 0.8rem;
    color: #6c757d;
    margin: 0 0 4px 0;
}

.cart-item-note {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    font-size: 0.75rem;
    color: #95a5a6;
    margin: 0 0 8px 0;
    font-style: italic;
}

.cart-item-price {
    font-family: 'Poppins', sans-serif;
    font-weight: 600;
    font-size: 0.85rem;
    color: #e74c3c;
}

/* ===== PROFILE STYLES (OLD DESIGN) ===== */
.profile-dropdown {
    min-width: 280px;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    left: auto !important;
    right: 0 !important;
    transform: translateY(8px) !important;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 40px 24px;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 16px;
}

.empty-state p {
    font-family: 'Poppins', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    margin: 0 0 16px 0;
}

/* ===== BADGE COUNTS ===== */
.notification-badge-dot {
    position: absolute;
    top: -2px;
    right: -2px;
    background: #e74c3c;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.cart-badge-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #e74c3c;
    color: white;
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'Poppins', sans-serif;
    font-size: 0.7rem;
    font-weight: 600;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* ===== PROFILE DROPDOWN (OLD STYLE) ===== */
.profile-dropdown {
    min-width: 280px;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

/* ===== NAVIGATION STYLES ===== */
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

.nav-separator {
    width: 1px;
    height: 24px;
    background-color: #e4e4e4;
    margin: 10px 10px;
}

.dropdown-btn {
    transition: all 0.2s ease;
}

.dropdown-btn:hover {
    transform: translateY(-1px);
}

/* ===== SEARCH MODAL STYLES ===== */
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
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-title-1,
.search-title-2 {
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 3rem;
    line-height: 1.1;
}

.search-title-1 {
    color: #e4e4e4;
}

.search-title-2 {
    color: #ffc74c;
}

.search-form {
    max-width: 600px;
}

.search-input {
    font-family: 'Poppins', sans-serif;
    font-size: 1.25rem;
    border: none;
    border-bottom: 2px solid rgba(255, 255, 255, 0.3);
    background: transparent;
    color: white;
    padding: 15px 50px 15px 0;
    border-radius: 0;
    transition: border-color 0.3s ease;
}

.search-input:focus {
    background: transparent;
    border-color: #ffc74c;
    color: white;
    box-shadow: none;
    outline: none;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-btn {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: white;
    font-size: 1.25rem;
    padding: 10px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.search-btn:hover {
    color: #ffc74c;
}

.popular-searches {
    font-family: 'Poppins', sans-serif;
}

.popular-title {
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 16px;
}

.popular-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.popular-search-item {
    display: inline-block;
    padding: 12px 20px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    color: white;
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.popular-search-item:hover {
    background: rgba(255, 199, 76, 0.2);
    border-color: #ffc74c;
    color: #ffc74c;
    text-decoration: none;
    transform: translateX(5px);
}

/* ===== RESPONSIVE STYLES ===== */
@media (max-width: 768px) {
    .modern-dropdown {
        min-width: 300px;
        transform: translateY(5px);
    }
    
    .notification-dropdown,
    .cart-dropdown {
        min-width: 320px;
    }
    
    .dropdown-menu.modern-dropdown {
        left: 50% !important;
        transform: translateX(-50%) translateY(5px) !important;
    }
    
    .profile-dropdown {
        right: 0 !important;
        left: auto !important;
        transform: translateY(5px) !important;
        min-width: 260px;
    }
    
    .dropdown-header {
        padding: 16px 20px 12px;
    }
    
    .dropdown-title {
        font-size: 0.9rem;
    }
    
    .view-all-link {
        font-size: 0.8rem;
    }
    
    .notification-item,
    .cart-item {
        padding: 12px 20px;
    }
    
    .cart-item-image img {
        width: 60px;
        height: 60px;
    }
    
    .search-title-1,
    .search-title-2 {
        font-size: 2.5rem;
    }
    
    .search-input {
        font-size: 1.1rem;
        padding: 12px 45px 12px 0;
    }
    
    .popular-search-item {
        padding: 10px 16px;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .modern-dropdown {
        min-width: 280px;
        max-width: 90vw;
    }
    
    .notification-dropdown,
    .cart-dropdown {
        min-width: 280px;
        max-width: 90vw;
    }
    
    .search-title-1,
    .search-title-2 {
        font-size: 2rem;
    }
    
    .search-form {
        max-width: 100%;
    }
    
    .dropdown-body {
        max-height: 300px;
    }
}

/* ===== MODAL FADE ANIMATIONS ===== */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: none;
}

/* ===== ADDITIONAL HOVER EFFECTS ===== */
.dropdown-btn:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(2, 88, 211, 0.1);
    border-radius: 8px;
}

.modern-dropdown {
    pointer-events: auto;
}

.modern-dropdown .dropdown-item-custom,
.modern-dropdown .notification-item,
.modern-dropdown .cart-item {
    pointer-events: auto;
}
</style>
