<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ url('/admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Data</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class='fa fa-database'></i></div>
                    Master Data
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ request()->is('admin/orders') ? 'active' : '' }}" href="{{ url('/admin/orders') }}">Pesanan</a>
                        <a class="nav-link {{ request()->is('admin/product') ? 'active' : '' }}" href="{{ url('/admin/product') }}">Produk</a>
                        <a class="nav-link {{ request()->is('admin/banner') ? 'active' : '' }}" href="{{ url('/admin/banner') }}">Banner</a>
                        <a class="nav-link {{ request()->is('admin/discount') ? 'active' : '' }}" href="{{ url('/admin/discount') }}">Diskon</a>
                        <a class="nav-link {{ request()->is('admin/promocode') ? 'active' : '' }}" href="{{ url('/admin/promocode') }}">Kode Promo</a>
                        <a class="nav-link {{ request()->is('admin/newsletter') ? 'active' : '' }}" href="{{ url('/admin/newsletter') }}">Newsletter</a>
                        <a class="nav-link {{ request()->is('admin/article') ? 'active' : '' }}" href="{{ url('/admin/article') }}">Artikel</a>
                        <a class="nav-link {{ request()->is('admin/faq') ? 'active' : '' }}" href="{{ url('/admin/faq') }}">FAQ</a>
                        <a class="nav-link {{ request()->is('admin/testimonial') ? 'active' : '' }}" href="{{ url('/admin/testimonial') }}">Testimoni</a>
                        <a class="nav-link {{ request()->is('admin/customer') ? 'active' : '' }}" href="{{ url('/admin/customer') }}">Customer</a>
                        <a class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}" href="{{ url('/admin/setting') }}">Setting</a>
                    </nav>
                </div>
                @if(Auth::user()->role == 'Admin')
                    <div class="sb-sidenav-menu-heading">Akun</div>
                    <a class="nav-link {{ request()->is('admin/user') ? 'active' : '' }}" href="{{ url('/admin/user') }}">
                        <div class="sb-nav-link-icon"><i class='fas fa-user-edit'></i></div>
                        Kelola User
                    </a>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Masuk Sebagai:</div>
            @if(Auth::user()->role != 'Customer')
            {{ Auth::user()->role }}
            @else
            {{ Auth::user()->role }} - Terlarang
            @endif
        </div>
    </nav>
</div>