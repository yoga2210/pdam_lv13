@extends('layouts.admin')
@section('header', 'Halaman')
@section('content')
<a href="{{ route('admin.pages.create') }}" class="btn btn-primary mb-3">Tambah Halaman</a>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Judul</th><th>Slug</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($items as $p)
                    <tr>
                        <td>{{ $p->title }}</td>
                        <td>{{ $p->slug }}</td>
                        <td>
                            <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action="{{ route('admin.pages.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
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