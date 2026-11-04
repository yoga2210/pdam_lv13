@php
    $settings = $settings ?? [];
    $siteLogo = !empty($settings['logo'] ?? null) ? asset('storage/' . $settings['logo']) : asset('canvas/images/logo.png');
    $siteFavicon = !empty($settings['favicon'] ?? null) ? asset('storage/' . $settings['favicon']) : ($siteLogo ?: asset('canvas/images/favicon.ico'));
    $isAdminLoggedIn = session('admin_id');
    $visitorCounterFile = storage_path('app/visitor_count.txt');
    if (! session()->has('site_visited')) {
        $visitorCount = file_exists($visitorCounterFile) ? (int) trim((string) file_get_contents($visitorCounterFile)) : 0;
        $visitorCount++;
        file_put_contents($visitorCounterFile, (string) $visitorCount, LOCK_EX);
        session(['site_visited' => true]);
    }
    $visitorCount = file_exists($visitorCounterFile) ? (int) trim((string) file_get_contents($visitorCounterFile)) : 0;
    $mapsRaw = !empty($settings['maps_embed'] ?? null) ? $settings['maps_embed'] : \App\Models\Setting::where('key', 'maps_embed')->value('value');
    $mapsEmbedValue = '';
    if (!empty($mapsRaw)) {
        if (str_contains($mapsRaw, '<iframe')) {
            $mapsEmbedValue = $mapsRaw;
        } else {
            $mapsEmbedValue = '<iframe src="' . trim($mapsRaw) . '" width="100%" height="220" style="border:0;display:block;border-radius:8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        }
    }
@endphp
<!DOCTYPE html>
<html dir="ltr" lang="id">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', $settings['site_name'] ?? 'PDAM')</title>
    <link rel="icon" type="image/png" href="{{ $siteFavicon }}">
    <link rel="shortcut icon" href="{{ $siteFavicon }}">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('canvas/css/custom.css') }}" type="text/css" />
</head>
<body class="stretched">
<div id="wrapper" class="clearfix">
    <!-- Top Bar -->
    <div id="top-bar" class="dark">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-auto">
                    <p class="mb-0 small"><i class="icon-phone"></i> {{ $settings['phone'] ?? '' }} &nbsp;|&nbsp; <i class="icon-envelope"></i> {{ $settings['email'] ?? '' }}</p>
                </div>
                <div class="col-12 col-md-auto d-none d-md-block">
                    <p class="mb-0 small">{{ $settings['address'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <header id="header" class="full-header">
        <div id="header-wrap">
            <div class="container">
                <div class="header-row">
                    <div id="logo">
                        <a href="{{ route('home') }}" class="standard-logo"><img src="{{ $siteLogo }}" alt="Logo"></a>
                        <a href="{{ route('home') }}" class="retina-logo"><img src="{{ $siteLogo }}" alt="Logo"></a>
                    </div>
                    <div id="primary-menu-trigger">
                        <svg class="svg-trigger" viewBox="0 0 100 100"><path d="M 30,33 h 40 M 30,50 h 40 M 30,67 h 40"></path></svg>
                    </div>
                    <nav class="primary-menu with-arrows">
                        <ul class="menu-container">
                            <li class="menu-item"><a class="menu-link" href="{{ route('home') }}"><div><i class="icon-home"></i> Beranda</div></a></li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('page.show', 'kata-pengantar') }}"><div><i class="icon-user"></i> Tentang</div></a></li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('news.index') }}"><div><i class="icon-newspaper"></i> Berita</div></a></li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('announcements.index') }}"><div><i class="icon-bell-alt"></i> Pengumuman</div></a></li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('agenda.index') }}"><div><i class="icon-calendar3"></i> Agenda</div></a></li>
                            <li class="menu-item">
                                <a class="menu-link" href="#"><div><i class="icon-images"></i> Galeri</div></a>
                                <ul class="sub-menu-container">
                                    <li class="menu-item"><a class="menu-link" href="{{ route('gallery.photos') }}"><div><i class="icon-picture"></i> Galeri Foto</div></a></li>
                                    <li class="menu-item"><a class="menu-link" href="{{ route('gallery.videos') }}"><div><i class="icon-play"></i> Galeri Video</div></a></li>
                                </ul>
                            </li>
                            <li class="menu-item"><a class="menu-link" href="{{ route('contact') }}"><div><i class="icon-phone"></i> Kontak</div></a></li>
                            <li class="menu-item">
                                <a class="menu-link" href="{{ $isAdminLoggedIn ? route('admin.dashboard') : route('admin.login') }}" aria-label="{{ $isAdminLoggedIn ? 'Dashboard admin' : 'Masuk login' }}">
                                    <div>
                                        <i class="{{ $isAdminLoggedIn ? 'icon-home' : 'icon-user' }}"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section id="content">
        <div class="content-wrap p-0">
            @yield('content')
        </div>
    </section>

    <footer id="footer" class="dark">
        <div class="container">
            <div class="footer-widgets-wrap">
                <div class="row col-mb-50">
                    <div class="col-lg-8">
                        <div class="row col-mb-50">
                            <div class="col-md-4">
                                <div class="widget clearfix">
                                    <img src="{{ $siteLogo }}" alt="Image" class="footer-logo mb-3" style="max-height:80px; width:auto;">
                                    <p>{{ $settings['site_tagline'] ?? '' }}</p>
                                    <div>
                                        <address>
                                            <strong>{{ $settings['site_name'] ?? 'PDAM' }}</strong><br>
                                            {{ $settings['address'] ?? '' }}<br>
                                        </address>
                                        <abbr title="Phone"><strong>Phone:</strong></abbr> {{ $settings['phone'] ?? '' }}<br>
                                        <abbr title="Email"><strong>Email:</strong></abbr> {{ $settings['email'] ?? '' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="widget widget_links clearfix">
                                    <h4>Lokasi</h4>
                                    @if(!empty($mapsEmbedValue))
                                        <div class="mt-2" style="max-height: 220px; overflow: hidden; border-radius: 8px;">
                                            {!! $mapsEmbedValue !!}
                                        </div>
                                    @else
                                        <p class="mb-0">Peta belum tersedia.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="widget clearfix">
                                    <h4>Media Sosial</h4>
                                    <a href="{{ $settings['facebook'] ?? '#' }}" class="social-icon si-small si-facebook"><i class="icon-facebook"></i></a>
                                    <a href="{{ $settings['twitter'] ?? '#' }}" class="social-icon si-small si-twitter"><i class="icon-twitter"></i></a>
                                    <a href="{{ $settings['instagram'] ?? '#' }}" class="social-icon si-small si-instagram"><i class="icon-instagram"></i></a>
                                    <a href="{{ $settings['youtube'] ?? '#' }}" class="social-icon si-small si-youtube"><i class="icon-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="widget clearfix">
                            <h4>{{ $settings['site_name'] ?? 'PDAM' }}</h4>
                            <p>{{ $settings['site_tagline'] ?? '' }}</p>
                            <div class="mt-3">
                                <i class="icon-users"></i>
                                <strong>Total Visitor:</strong> {{ number_format($visitorCount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="copyrights">
            <div class="container clearfix">
                <div class="center">&copy; {{ date('Y') }} By DISKOMINFO KOTA MOJOKERTO.</div>
            </div>
        </div>
    </footer>
</div>
<script src="{{ asset('canvas/js/jquery.js') }}"></script>
<script src="{{ asset('canvas/js/plugins.min.js') }}"></script>
<script src="{{ asset('canvas/js/functions.js') }}"></script>
</body>
</html>