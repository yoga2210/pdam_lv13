@extends('layouts.admin')
@section('header', $item->exists ? 'Edit Video' : 'Tambah Video')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists ? route('admin.videos.update', $item) : route('admin.videos.store') }}" enctype="multipart/form-data">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $item->description) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">URL YouTube</label>
                <input type="url" name="youtube_url" value="{{ old('youtube_url', $item->youtube_url) }}" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
            </div>
            <div class="mb-3">
                <label class="form-label">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control" accept="image/*">
                @if($item->thumbnail)<img src="{{ asset('storage/'.$item->thumbnail) }}" class="mt-2" style="height:80px">@endif
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