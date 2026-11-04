@php
    $websiteLogo = \App\Models\Setting::get('logo');
    $faviconImage = \App\Models\Setting::get('favicon');
    $adminBrandLogo = $websiteLogo ? asset('storage/' . $websiteLogo) : asset('skote/assets/images/logo-light.png');
    $faviconLogo = $faviconImage ? asset('storage/' . $faviconImage) : ($websiteLogo ? asset('storage/' . $websiteLogo) : asset('skote/assets/images/favicon.ico'));
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ $faviconLogo }}">
    <link rel="shortcut icon" href="{{ $faviconLogo }}">
    <link href="{{ asset('skote/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('skote/assets/js/plugin.js') }}"></script>
</head>
<body data-sidebar="dark">
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                        <span class="logo-lg"><img src="{{ $adminBrandLogo }}" alt="Logo Website" height="90"></span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
            </div>
            <div class="d-flex align-items-center">
                
                <a href="{{ route('home') }}" class="btn btn-sm waves-effect me-2" title="Ke Beranda Frontend">
                    <i class="bx bx-home-alt"></i>
                    <span class="d-none d-sm-inline">Beranda</span>
                </a>
                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <span class="header-item"><i class="bx bx-user-circle"></i> {{ session('admin_name') }}</span>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="ms-2">
                    @csrf
                    <button class="btn btn-sm btn-danger" title="Logout">
                        <i class="bx bx-log-out-circle"></i>
                        <span class="d-none d-sm-inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    <li><a href="{{ route('admin.dashboard') }}" class="waves-effect"><i class="bx bx-home-circle"></i><span>Dashboard</span></a></li>
                    <li><a href="{{ route('admin.news.index') }}" class="waves-effect"><i class="bx bx-news"></i><span>Berita</span></a></li>
                    <li><a href="{{ route('admin.announcements.index') }}" class="waves-effect"><i class="bx bx-bell"></i><span>Pengumuman</span></a></li>
                    <li><a href="{{ route('admin.agendas.index') }}" class="waves-effect"><i class="bx bx-calendar"></i><span>Agenda</span></a></li>
                    <li><a href="{{ route('admin.albums.index') }}" class="waves-effect"><i class="bx bx-image"></i><span>Album Foto</span></a></li>
                    <li><a href="{{ route('admin.videos.index') }}" class="waves-effect"><i class="bx bx-video"></i><span>Video</span></a></li>
                    <li><a href="{{ route('admin.sliders.index') }}" class="waves-effect"><i class="bx bx-slideshow"></i><span>Slider</span></a></li>
                    <li><a href="{{ route('admin.pages.index') }}" class="waves-effect"><i class="bx bx-file"></i><span>Halaman</span></a></li>
                    <li><a href="{{ route('admin.settings.edit') }}" class="waves-effect"><i class="bx bx-cog"></i><span>Pengaturan</span></a></li>
                    <li><a href="{{ route('admin.password.edit') }}" class="waves-effect"><i class="bx bx-lock-alt"></i><span>Ubah Password</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">@yield('header', 'Dashboard')</h4>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">&copy; {{ date('Y') }} PDAM.</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="{{ asset('skote/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('skote/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('skote/assets/js/app.js') }}"></script>
@yield('scripts')
</body>
</html>