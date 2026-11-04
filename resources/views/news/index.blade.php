@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Informasi</div>
            <h1>Berita</h1>
            <p>Berbagai informasi dan perkembangan terbaru dari instansi kami untuk masyarakat.</p>
        </div>

        <div class="row g-4">
            @forelse($items as $n)
                <div class="col-md-6 col-xl-4">
                    <article class="news-card h-100">
                        @if($n->image)
                            <img src="{{ asset('storage/'.$n->image) }}" class="card-img-top" alt="{{ $n->title }}">
                        @endif
                        <div class="card-body">
                            <div class="news-meta">
                                <i class="icon-calendar3"></i>
                                {{ optional($n->published_at)->format('d M Y') }}
                            </div>
                            <h2 class="card-title">
                                <a href="{{ route('news.show', $n->slug) }}">{{ $n->title }}</a>
                            </h2>
                            <p class="card-text">{{ $n->excerpt ?: Str::limit(strip_tags($n->content), 140) }}</p>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4">Belum ada berita yang dipublikasikan.</div>
                </div>
            @endforelse
        </div>

        @if($items->hasPages())
            <div class="mt-4">{{ $items->links() }}</div>
        @endif
    </div>
</div>
@endsection