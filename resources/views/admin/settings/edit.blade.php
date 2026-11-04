@extends('layouts.admin')
@section('header', 'Pengaturan')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @foreach($settings as $key => $val)
                @if($key === 'maps_embed')
                    <div class="mb-3">
                        <label class="form-label">{{ $key }}</label>
                        <textarea name="{{ $key }}" class="form-control" rows="3">{{ $val }}</textarea>
                    </div>
                @elseif($key === 'logo')
                    <div class="mb-3">
                        <label class="form-label">Logo Website</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                        @if(!empty($val))
                            <img src="{{ asset('storage/'.$val) }}" class="mt-2" style="max-height:80px; object-fit:contain;">
                        @endif
                    </div>
                @elseif($key === 'favicon')
                    <div class="mb-3">
                        <label class="form-label">Favicon Website</label>
                        <input type="file" name="favicon" class="form-control" accept="image/*">
                        @if(!empty($val))
                            <img src="{{ asset('storage/'.$val) }}" class="mt-2" style="max-height:60px; object-fit:contain;">
                        @endif
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label">{{ $key }}</label>
                        <input type="text" name="{{ $key }}" value="{{ $val }}" class="form-control">
                    </div>
                @endif
            @endforeach
            <button class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection