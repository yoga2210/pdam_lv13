@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Informasi</div>
            <h1>Pengumuman</h1>
            <p>Informasi resmi dan penting yang perlu diketahui oleh masyarakat sekitar.</p>
        </div>

        <div class="announcement-list">
            @forelse($items as $a)
                <article class="announcement-item">
                    <a href="{{ route('announcements.show', $a->slug) }}">
                        <div class="d-flex justify-content-between align-items-start flex-column flex-md-row gap-2">
                            <div>
                                <span class="badge-soft">Pengumuman</span>
                                <h3 class="mt-3">{{ $a->title }}</h3>
                            </div>
                            <div class="item-meta">
                                <i class="icon-calendar3"></i>
                                {{ optional($a->published_at)->format('d M Y') }}
                            </div>
                        </div>
                        <p class="mb-0">{{ $a->excerpt ?: Str::limit(strip_tags($a->content), 180) }}</p>
                    </a>
                </article>
            @empty
                <div class="alert alert-light border rounded-4">Belum ada pengumuman yang dipublikasikan.</div>
            @endforelse
        </div>

        @if($items->hasPages())
            <div class="mt-4">{{ $items->links() }}</div>
        @endif
    </div>
</div>
@endsection