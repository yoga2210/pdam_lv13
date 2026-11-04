@extends('layouts.app')
@section('content')
<div class="page-shell">
    <div class="container">
        <div class="page-header-box">
            <div class="eyebrow">Hubungi Kami</div>
            <h1>Kontak</h1>
            <p>Silakan hubungi kami untuk informasi lebih lanjut, layanan, atau kebutuhan komunikasi lainnya.</p>
        </div>

        <div class="contact-stack">
            <div class="contact-card">
                <h3>Informasi Kontak</h3>
                <ul class="contact-list">
                    @if(!empty($settings['address']))
                        <li>
                            <i class="icon-map-marker1"></i>
                            <span>{{ $settings['address'] }}</span>
                        </li>
                    @endif
                    @if(!empty($settings['phone']))
                        <li>
                            <i class="icon-phone"></i>
                            <span>{{ $settings['phone'] }}</span>
                        </li>
                    @endif
                    @if(!empty($settings['whatsapp']))
                        <li>
                            <i class="icon-whatsapp"></i>
                            <span>{{ $settings['whatsapp'] }}</span>
                        </li>
                    @endif
                    @if(!empty($settings['email']))
                        <li>
                            <i class="icon-envelope"></i>
                            <span>{{ $settings['email'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>

            @if(!empty($settings['maps_embed']))
                <div class="contact-card">
                    <h3>Lokasi Kami</h3>
                    <div>{!! $settings['maps_embed'] !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection