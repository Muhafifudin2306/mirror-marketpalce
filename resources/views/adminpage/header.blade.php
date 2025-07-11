<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="{{ url('/admin') }}">Sinau Print Admin</a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

    </div>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                @empty(Auth::user()->foto)
                    <img src="{{ asset('landingpage/img/profil_login.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 30px; height: 30px;">
                @else
                    @php
                    $fotoPath = 'landingpage/img/' . Auth::user()->foto;
                    $fotoUrl = url($fotoPath);
                    @endphp
                    @if (file_exists(public_path($fotoPath)))
                    <img src="{{ $fotoUrl }}" class="rounded-circle img-fluid" style="width: 30px; height: 30px;">
                    @else
                    <img src="{{ asset('landingpage/img/noimg.png') }}" class="rounded-circle img-fluid" style="width: 30px; height: 30px;">
                    @endif
                @endempty
                 | {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ url('/profile') }}">Profil</a></li>
                <li><hr class="dropdown-divider"/></li>
                <li><a class="dropdown-item" href="{{ url('/') }}">Landingpage</a></li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </ul>
        </li>
    </ul>
</nav>