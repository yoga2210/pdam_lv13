@extends('layouts.app')
@section('content')
<div class="page-shell py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <article class="card border-0 shadow-sm overflow-hidden">
                    <div class="card-body p-4 p-lg-5">
                        <div class="eyebrow mb-2">Tentang Kami</div>
                        <h1 class="mb-3">{{ $page->title }}</h1>

                        @if($page->image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/'.$page->image) }}" class="img-fluid rounded w-100" alt="{{ $page->title }}" style="max-height:420px; object-fit:cover;">
                            </div>
                        @endif

                        <div class="article-content" style="font-size:1rem; line-height:1.8; color:#444;">
                            {!! $page->content !!}
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection