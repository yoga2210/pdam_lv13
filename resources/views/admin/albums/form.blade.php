@extends('layouts.admin')
@section('header', $item->exists ? 'Edit Album' : 'Tambah Album')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists ? route('admin.albums.update', $item) : route('admin.albums.store') }}" enctype="multipart/form-data">
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
                <label class="form-label">Cover</label>
                <input type="file" name="cover" class="form-control">
                @if($item->cover)<img src="{{ asset('storage/'.$item->cover) }}" class="mt-2" style="height:80px">@endif
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_published" value="1" class="form-check-input" id="pub" {{ old('is_published', $item->is_published) ? 'checked' : '' }}>
                <label class="form-check-label" for="pub">Published</label>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@if($item->exists)
<div class="card mt-4">
    <div class="card-body">
        <h5>Foto Album</h5>
        <form method="POST" action="{{ route('admin.albums.photos.store', $item) }}" enctype="multipart/form-data" class="row g-2 mb-3">
            @csrf
            <div class="col-md-4"><input type="file" name="image" class="form-control" required></div>
            <div class="col-md-4"><input type="text" name="caption" placeholder="Caption" class="form-control"></div>
            <div class="col-md-2"><button class="btn btn-success">Upload</button></div>
        </form>
        <div class="row g-2">
            @foreach($item->photos as $p)
                <div class="col-6 col-md-3">
                    <div class="card">
                        <img src="{{ asset('storage/'.$p->image) }}" class="card-img-top" alt="">
                        <div class="card-body p-2">
                            <form method="POST" action="{{ route('admin.photos.destroy', $p) }}" onsubmit="return confirm('Hapus foto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection