@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Dokumentasi</div>
            <h1>Galeri Foto</h1>
            <p>Kumpulan dokumentasi kegiatan, proyek, dan momen penting dari instansi kami.</p>
        </div>

        <div class="row g-4">
            @forelse($albums as $a)
                <div class="col-md-6 col-xl-4">
                    <article class="gallery-card h-100">
                        @if($a->cover)
                            <img src="{{ asset('storage/'.$a->cover) }}" class="card-img-top" alt="{{ $a->title }}">
                        @endif
                        <div class="card-body">
                            <h2 class="card-title">
                                <a href="{{ route('gallery.album', $a->slug) }}">{{ $a->title }}</a>
                            </h2>
                            @if($a->description)
                                <p class="mb-0 mt-2">{{ Str::limit(strip_tags($a->description), 100) }}</p>
                            @endif
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4">Belum ada album foto yang dipublikasikan.</div>
                </div>
            @endforelse
        </div>

        @if($albums->hasPages())
            <div class="mt-4">{{ $albums->links() }}</div>
        @endif
    </div>
</div>
@endsection