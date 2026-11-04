@extends('layouts.admin')
@section('header', 'Video')
@section('content')
<a href="{{ route('admin.videos.create') }}" class="btn btn-primary mb-3">Tambah Video</a>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Judul</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($items as $v)
                    <tr>
                        <td>{{ $v->title }}</td>
                        <td>{{ $v->is_published ? 'Published' : 'Draft' }}</td>
                        <td>
                            <a href="{{ route('admin.videos.edit', $v) }}" class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action="{{ route('admin.videos.destroy', $v) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection