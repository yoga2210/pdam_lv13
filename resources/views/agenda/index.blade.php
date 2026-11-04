@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Kegiatan</div>
            <h1>Agenda</h1>
            <p>Jadwal kegiatan dan acara penting yang diselenggarakan oleh instansi kami.</p>
        </div>

        <div class="agenda-list">
            @forelse($items as $g)
                <article class="agenda-item">
                    <a href="{{ route('agenda.show', $g->slug) }}">
                        <div class="date-pill">
                            {{ optional($g->event_date)->format('d M Y') }}
                        </div>
                        <h3>{{ $g->title }}</h3>
                        <p class="mb-2">
                            {{ Str::limit(strip_tags($g->description), 160) }}
                        </p>
                        <div class="item-meta">
                            <i class="icon-time"></i>
                            {{ $g->event_time ?? 'Waktu belum diatur' }}
                        </div>
                        <div class="item-meta mt-1">
                            <i class="icon-map-marker1"></i>
                            {{ $g->location ?? 'Lokasi belum diatur' }}
                        </div>
                    </a>
                </article>
            @empty
                <div class="alert alert-light border rounded-4">Belum ada agenda yang dipublikasikan.</div>
            @endforelse
        </div>

        @if($items->hasPages())
            <div class="mt-4">{{ $items->links() }}</div>
        @endif
    </div>
</div>
@endsection