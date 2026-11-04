@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <article class="article-shell">
                    <div class="eyebrow">Tentang Kami</div>
                    <h1>{{ $page->title }}</h1>

                    @if($page->image)
                        <img src="{{ asset('storage/'.$page->image) }}" class="article-thumb" alt="{{ $page->title }}">
                    @endif

                    <div class="article-content">
                        {!! $page->content !!}
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection