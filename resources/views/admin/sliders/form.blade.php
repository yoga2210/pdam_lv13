@extends('layouts.admin')
@section('header', $item->exists ? 'Edit Slider' : 'Tambah Slider')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists ? route('admin.sliders.update', $item) : route('admin.sliders.store') }}" enctype="multipart/form-data">
            @csrf
            @if($item->exists) @method('PUT') @endif
            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" {{ $item->exists ? '' : 'required' }}>
                @if($item->image)<img src="{{ asset('storage/'.$item->image) }}" class="mt-2" style="height:80px">@endif
            </div>
            <div class="mb-3">
                <label class="form-label">Link</label>
                <input type="text" name="link" value="{{ old('link', $item->link) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input" id="act" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="act">Aktif</label>
            </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection