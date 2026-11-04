@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Galeri Foto</div>
            <h1>{{ $album->title }}</h1>
            @if($album->description)
                <p>{{ $album->description }}</p>
            @endif
        </div>

        <div class="row g-4">
            @forelse($album->photos as $p)
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="gallery-card h-100">
                        <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" alt="{{ $p->caption ?: $album->title }}">
                        @if($p->caption)
                            <div class="card-body">
                                <small class="text-muted">{{ $p->caption }}</small>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border rounded-4">Belum ada foto di album ini.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            <a href="{{ route('gallery.photos') }}" class="btn btn-primary rounded-pill px-4">
                <i class="icon-arrow-left"></i> Kembali ke Galeri Foto
            </a>
        </div>
    </div>
</div>
@endsection