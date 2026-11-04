@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Media</div>
            <h1>Galeri Video</h1>
            <p>Berbagai video dokumentasi dan informasi publik yang dapat diakses secara online.</p>
        </div>

        <div class="row g-4">
            @forelse($videos as $v)
                <div class="col-md-6 col-xl-4">
                    <article class="gallery-card h-100">
                        @if($v->thumbnail)
                            <div class="video-thumb">
                                <img src="{{ asset('storage/'.$v->thumbnail) }}" alt="{{ $v->title }}">
                                <div class="play-badge"></div>
                            </div>
                        @endif
                        <div class="card-body">
                            <h2 class="card-title">{{ $v->title }}</h2>
                            @if($v->youtube_url)
                                <div class="mt-3">
                                    <a href="{{ $v->youtube_url }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="icon-play"></i> Tonton Video
                                    </a>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4">Belum ada video yang dipublikasikan.</div>
                </div>
            @endforelse
        </div>

        @if($videos->hasPages())
            <div class="mt-4">{{ $videos->links() }}</div>
        @endif
    </div>
</div>
@endsection