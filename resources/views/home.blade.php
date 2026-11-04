@extends('layouts.app')
@section('content')

{{-- ============ HERO + SLIDER ============ --}}
<section class="home-hero">
    <div class="container">

        <div class="hero-head">
            <div class="hero-head-main">
                <div class="hero-welcome">Selamat datang di</div>
                <h1 class="hero-title">{{ $settings['site_name'] ?? 'Website Perumda Air Minum Kota Mojokerto' }}</h1>
            </div>
            <p class="hero-desc">
                {{ $settings['site_tagline'] ?? 'Informasi dan layanan air minum bagi masyarakat Kota Mojokerto.' }}
            </p>
        </div>

        <div id="homeSlider" class="carousel slide hero-slider" data-ride="carousel" data-interval="5000">
            <div class="carousel-inner">
                @forelse($sliders as $index => $slider)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $slider->image) }}"
                             class="d-block w-100" alt="{{ $slider->title ?: 'Slider ' . ($index + 1) }}">
                        @if(!empty($slider->title) || !empty($slider->link))
                            <div class="carousel-caption d-none d-md-block">
                                @if(!empty($slider->title))
                                    <h3>{{ $slider->title }}</h3>
                                @endif
                                @if(!empty($slider->link))
                                    <p><a href="{{ $slider->link }}" target="_blank" rel="noopener">Lihat detail</a></p>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    @foreach(['1.jpg','2.jpg','3.jpg','4.jpg'] as $i => $img)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <img src="{{ asset('canvas/images/slider/full/'.$img) }}"
                                 class="d-block w-100" alt="Slider {{ $i + 1 }}">
                        </div>
                    @endforeach
                @endforelse
            </div>

            @if($sliders->isNotEmpty())
                <a class="carousel-control-prev" href="#homeSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Sebelumnya</span>
                </a>
                <a class="carousel-control-next" href="#homeSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Berikutnya</span>
                </a>
            @endif
        </div>

    </div>
</section>

{{-- ============ BERITA, PENGUMUMAN, AGENDA ============ --}}
<section class="home-section">
    <div class="container">
        <div class="row">

            {{-- Kabar Terbaru --}}
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="sec-head">
                    <h2 class="sec-title">Kabar Terbaru</h2>
                    <a href="{{ route('news.index') }}" class="sec-link">Semua berita</a>
                </div>

                <div class="row">
                    @forelse($news as $n)
                        <div class="col-md-6 mb-4">
                            <article class="news-card">
                                <a href="{{ route('news.show', $n->slug) }}" class="news-thumb">
                                    @if($n->image)
                                        <img src="{{ asset('storage/'.$n->image) }}" alt="{{ $n->title }}">
                                    @else
                                        <span class="news-thumb-empty"><i class="icon-line-image"></i></span>
                                    @endif
                                </a>
                                <div class="news-body">
                                    <time class="news-date">{{ optional($n->published_at)->format('d M Y') }}</time>
                                    <h3 class="news-title">
                                        <a href="{{ route('news.show', $n->slug) }}">{{ $n->title }}</a>
                                    </h3>
                                    <p class="news-excerpt">{{ Str::limit($n->excerpt, 100) }}</p>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><p class="empty-note">Belum ada berita.</p></div>
                    @endforelse
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="col-lg-4">
                <div class="side-panel mb-4">
                    <div class="sec-head sec-head-sm">
                        <h2 class="sec-title">Pengumuman</h2>
                    </div>
                    <ul class="side-list">
                        @forelse($announcements as $a)
                            <li>
                                <a href="{{ route('announcements.show', $a->slug) }}">
                                    <span class="side-item-title">{{ $a->title }}</span>
                                    <span class="side-item-meta">{{ optional($a->published_at)->format('d M Y') }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="empty-note">Belum ada pengumuman.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="side-panel">
                    <div class="sec-head sec-head-sm">
                        <h2 class="sec-title">Agenda</h2>
                    </div>
                    <ul class="side-list">
                        @forelse($agendas as $g)
                            <li>
                                <a href="{{ route('agenda.show', $g->slug) }}" class="agenda-item">
                                    <span class="agenda-date">
                                        <strong>{{ optional($g->event_date)->format('d') }}</strong>
                                        <small>{{ optional($g->event_date)->format('M') }}</small>
                                    </span>
                                    <span class="agenda-text">
                                        <span class="side-item-title">{{ $g->title }}</span>
                                        <span class="side-item-meta">{{ $g->location }}</span>
                                    </span>
                                </a>
                            </li>
                        @empty
                            <li class="empty-note">Belum ada agenda.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>

        </div>
    </div>
</section>

{{-- ============ GALERI ============ --}}
<section class="home-section home-section-alt">
    <div class="container">
        <div class="sec-head">
            <h2 class="sec-title">Galeri Foto</h2>
            <a href="{{ route('gallery.photos') }}" class="sec-link">Semua album</a>
        </div>

        <div class="row">
            @forelse($albums ?? [] as $album)
                <div class="col-md-4 mb-4 mb-md-0">
                    <figure class="gallery-item">
                        <a href="{{ route('gallery.album', $album->slug) }}">
                            @if($album->cover)
                                <img src="{{ asset('storage/'.$album->cover) }}" alt="{{ $album->title }}">
                            @else
                                <img src="{{ asset('canvas/images/portfolio/4/1.jpg') }}" alt="{{ $album->title }}">
                            @endif
                        </a>
                    </figure>
                </div>
            @empty
                <div class="col-12"><p class="empty-note">Belum ada album foto.</p></div>
            @endforelse
        </div>
    </div>
</section>

<style>
    :root {
        --brand-dark: #053f56;
        --brand: #0a7a68;
        --brand-light: #0f9a8a;
        --ink: #1f2d33;
        --muted: #6b7b82;
        --line: #e3eaed;
        --bg-alt: #f4f8f8;
    }
 
    #content .content-wrap {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
}

    /* ---------- Hero ---------- */
    .home-hero {
        background: linear-gradient(120deg, var(--brand-dark) 0%, var(--brand) 55%, var(--brand-light) 100%);
        padding: 40px 0 44px;
        color: #fff;
    }
    .hero-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 24px;
        margin-bottom: 22px;
    }
    .hero-eyebrow {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .hero-welcome { font-size: 18px; line-height: 1.3; }
    .hero-title {
        font-size: 30px;
        font-weight: 700;
        color: #fff;
        margin: 2px 0 0;
        line-height: 1.2;
    }
    .hero-desc {
        font-size: 12px;
        line-height: 1.5;
        text-align: right;
        color: #d6fff6;
        max-width: 260px;
        margin: 0;
    }

    .hero-slider {
        border-radius: 18px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 14px 34px rgba(0, 0, 0, .28);
    }
    .hero-slider .carousel-item img {
        height: 380px;
        object-fit: cover;
        object-position: center;
    }
    .hero-slider .carousel-control-prev-icon,
    .hero-slider .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, .35);
        border-radius: 50%;
        width: 38px;
        height: 38px;
        background-size: 50% 50%;
    }

    .hero-slider .carousel-caption {
        right: 10%;
        left: 10%;
        bottom: 16%;
        text-align: left;
        background: linear-gradient(90deg, rgba(5, 63, 86, 0.72), rgba(5, 63, 86, 0.12));
        border-radius: 14px;
        padding: 18px 20px;
        max-width: 420px;
    }
    .hero-slider .carousel-caption h3 {
        margin: 0 0 8px;
        font-size: 26px;
        font-weight: 700;
        color: #fff;
    }
    .hero-slider .carousel-caption p {
        margin: 0;
    }
    .hero-slider .carousel-caption a {
        color: #fff;
        font-weight: 600;
        text-decoration: underline;
    }

    /* ---------- Section dasar ---------- */
    .home-section { padding: 64px 0; background: #fff; }
    .home-section-alt { background: var(--bg-alt); }

    .sec-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 12px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--line);
        position: relative;
    }
    .sec-head::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -1px;
        width: 56px;
        height: 3px;
        background: var(--brand);
    }
    .sec-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--ink);
        margin: 0;
        line-height: 1.3;
    }
    .sec-link {
        font-size: 14px;
        font-weight: 600;
        color: var(--brand);
    }
    .sec-link:hover { color: var(--brand-dark); text-decoration: underline; }
    .sec-head-sm { margin-bottom: 8px; }
    .sec-head-sm .sec-title { font-size: 18px; }

    .empty-note { color: var(--muted); font-size: 14px; margin: 0; padding: 12px 0; }

    /* ---------- Kartu berita ---------- */
    .news-card {
        height: 100%;
        display: flex;
        flex-direction: column;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow .2s ease;
    }
    .news-card:hover { box-shadow: 0 8px 22px rgba(5, 63, 86, .12); }
    .news-thumb {
        display: block;
        height: 180px;
        background: var(--bg-alt);
        overflow: hidden;
    }
    .news-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .news-thumb-empty {
        display: flex;
        height: 100%;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: #b9c7cc;
    }
    .news-body { padding: 16px 18px 20px; display: flex; flex-direction: column; flex: 1; }
    .news-date { font-size: 12px; color: var(--muted); margin-bottom: 6px; }
    .news-title { font-size: 17px; font-weight: 700; line-height: 1.4; margin: 0 0 8px; }
    .news-title a { color: var(--ink); }
    .news-title a:hover { color: var(--brand); }
    .news-title,
    .news-excerpt {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .news-title { -webkit-line-clamp: 2; }
    .news-excerpt {
        -webkit-line-clamp: 3;
        font-size: 14px;
        line-height: 1.6;
        color: var(--muted);
        margin: 0;
    }

    /* ---------- Sidebar ---------- */
    .side-panel {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
        padding: 20px 20px 8px;
    }
    .side-list { list-style: none; margin: 0; padding: 0; }
    .side-list li { border-bottom: 1px solid var(--line); }
    .side-list li:last-child { border-bottom: 0; }
    .side-list a { display: block; padding: 12px 0; }
    .side-item-title {
        display: block;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.45;
        color: var(--ink);
    }
    .side-list a:hover .side-item-title { color: var(--brand); }
    .side-item-meta { display: block; font-size: 12px; color: var(--muted); margin-top: 3px; }

    .agenda-item { display: flex !important; gap: 14px; align-items: flex-start; }
    .agenda-date {
        flex: 0 0 52px;
        text-align: center;
        background: var(--brand);
        color: #fff;
        border-radius: 8px;
        padding: 6px 0;
        line-height: 1.1;
    }
    .agenda-date strong { display: block; font-size: 20px; }
    .agenda-date small { font-size: 11px; text-transform: uppercase; }
    .agenda-text { flex: 1; min-width: 0; }

    /* ---------- Galeri ---------- */
    .gallery-item {
        margin: 0;
        height: 240px;
        border-radius: 12px;
        overflow: hidden;
        background: #dfe8ea;
    }
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s ease;
    }
    .gallery-item:hover img { transform: scale(1.04); }

    /* ---------- Responsif ---------- */
    @media (max-width: 767px) {
        .home-hero { padding: 28px 0 32px; }
        .hero-head { flex-direction: column; align-items: flex-start; gap: 10px; }
        .hero-title { font-size: 22px; }
        .hero-desc { text-align: left; max-width: none; }
        .hero-slider .carousel-item img { height: 200px; }
        .home-section { padding: 44px 0; }
        .news-thumb { height: 200px; }
        .gallery-item { height: 220px; }
    }

    @media (prefers-reduced-motion: reduce) {
        .news-card, .gallery-item img { transition: none; }
    }
</style>

@endsection