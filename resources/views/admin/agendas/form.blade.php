@extends('layouts.admin')
@section('header', $item->exists ? 'Edit Agenda' : 'Tambah Agenda')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists ? route('admin.agendas.update', $item) : route('admin.agendas.store') }}">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="6">{{ old('description', $item->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="event_date" value="{{ old('event_date', optional($item->event_date)->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Waktu</label>
                <input type="text" name="event_time" value="{{ old('event_time', $item->event_time) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="location" value="{{ old('location', $item->location) }}" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $item->is_published) ? 'checked' : '' }}>
                <label class="form-check-label" for="pub">Published</label>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection