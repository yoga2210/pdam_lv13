@extends('layouts.admin')
@section('header', $item->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists ? route('admin.announcements.update', $item) : route('admin.announcements.store') }}" enctype="multipart/form-data">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ringkasan</label>
                <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $item->excerpt) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Konten</label>
                <textarea name="content" class="form-control" rows="8">{{ old('content', $item->content) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control">
                @if($item->image)<img src="{{ asset('storage/'.$item->image) }}" class="mt-2" style="height:80px">@endif
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Publikasi</label>
                <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($item->published_at)->format('Y-m-d\TH:i')) }}" class="form-control">
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