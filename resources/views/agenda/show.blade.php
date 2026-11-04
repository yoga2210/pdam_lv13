@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <article class="article-shell">
                    <div class="eyebrow">Agenda</div>
                    <h1>{{ $item->title }}</h1>
                    <div class="item-meta mb-3">
                        <i class="icon-calendar3"></i>
                        {{ optional($item->event_date)->format('d M Y') }}
                    </div>
                    <div class="item-meta mb-3">
                        <i class="icon-time"></i>
                        {{ $item->event_time ?? 'Waktu belum diatur' }}
                    </div>
                    <div class="item-meta mb-3">
                        <i class="icon-map-marker1"></i>
                        {{ $item->location ?? 'Lokasi belum diatur' }}
                    </div>

                    <div class="article-content">
                        {!! $item->description !!}
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('agenda.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="icon-arrow-left"></i> Kembali ke Agenda
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection