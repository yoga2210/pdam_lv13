@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <article class="article-shell">
                    <div class="eyebrow">Berita</div>
                    <h1>{{ $item->title }}</h1>
                    <div class="item-meta mb-3">
                        <i class="icon-calendar3"></i>
                        {{ optional($item->published_at)->format('d M Y') }}
                    </div>

                    @if($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="article-thumb" alt="{{ $item->title }}">
                    @endif

                    <div class="article-content">
                        {!! $item->content !!}
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('news.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="icon-arrow-left"></i> Kembali ke Berita
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection