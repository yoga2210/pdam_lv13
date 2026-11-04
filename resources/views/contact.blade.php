@extends('layouts.app')
@section('content')
@php
    $contactMap = $settings['maps_embed'] ?? null;
    if (!empty($contactMap)) {
        if (!str_contains($contactMap, '<iframe')) {
            $contactMap = '<iframe src="' . trim($contactMap) . '" width="100%" height="100%" style="border:0; min-height:340px; display:block; border-radius:12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
        }
    }
@endphp
<div class="page-shell py-5">
    <div class="container">
        <div class="page-header-box text-center text-lg-start mb-4">
            <div class="eyebrow">Hubungi Kami</div>
            <h1 class="mb-2">Kontak</h1>
            <p class="mb-0 text-muted">Silakan hubungi kami untuk informasi lebih lanjut, layanan, atau kebutuhan komunikasi lainnya.</p>
        </div>

        <div class="row g-4 align-items-stretch">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="mb-4">Informasi Kontak</h3>
                        <ul class="list-unstyled mb-0">
                            @if(!empty($settings['address']))
                                <li class="d-flex align-items-start mb-3">
                                    <i class="icon-map-marker1 me-3 mt-1"></i>
                                    <span>{{ $settings['address'] }}</span>
                                </li>
                            @endif
                            @if(!empty($settings['phone']))
                                <li class="d-flex align-items-start mb-3">
                                    <i class="icon-phone me-3 mt-1"></i>
                                    <span>{{ $settings['phone'] }}</span>
                                </li>
                            @endif
                            @if(!empty($settings['whatsapp']))
                                <li class="d-flex align-items-start mb-3">
                                    <i class="icon-whatsapp me-3 mt-1"></i>
                                    <span>{{ $settings['whatsapp'] }}</span>
                                </li>
                            @endif
                            @if(!empty($settings['email']))
                                <li class="d-flex align-items-start mb-3">
                                    <i class="icon-envelope me-3 mt-1"></i>
                                    <span>{{ $settings['email'] }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            @if(!empty($contactMap))
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-3">
                            <h3 class="mb-3">Lokasi Kami</h3>
                            <div class="ratio ratio-16x9" style="border-radius: 12px; overflow: hidden;">
                                {!! $contactMap !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection