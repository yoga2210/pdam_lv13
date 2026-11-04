@extends('layouts.admin')
@section('header', 'Slider')
@section('content')
<a href="{{ route('admin.sliders.create') }}" class="btn btn-primary mb-3">Tambah Slider</a>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Judul</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($items as $s)
                    <tr>
                        <td>{{ $s->title }}</td>
                        <td>{{ $s->sort_order }}</td>
                        <td>{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                        <td>
                            <a href="{{ route('admin.sliders.edit', $s) }}" class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action="{{ route('admin.sliders.destroy', $s) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection