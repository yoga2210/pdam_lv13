@extends('layouts.admin')
@section('header', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-md-4 col-xl-3">
        <div class="card text-center"><div class="card-body"><h5 class="text-muted">Berita</h5><h2>{{ $newsCount }}</h2></div></div>
    </div>
    <div class="col-md-4 col-xl-3">
        <div class="card text-center"><div class="card-body"><h5 class="text-muted">Pengumuman</h5><h2>{{ $announcementCount }}</h2></div></div>
    </div>
    <div class="col-md-4 col-xl-3">
        <div class="card text-center"><div class="card-body"><h5 class="text-muted">Agenda</h5><h2>{{ $agendaCount }}</h2></div></div>
    </div>
    <div class="col-md-4 col-xl-3">
        <div class="card text-center"><div class="card-body"><h5 class="text-muted">Album</h5><h2>{{ $albumCount }}</h2></div></div>
    </div>
    <div class="col-md-4 col-xl-3">
        <div class="card text-center"><div class="card-body"><h5 class="text-muted">Video</h5><h2>{{ $videoCount }}</h2></div></div>
    </div>
</div>
@endsection