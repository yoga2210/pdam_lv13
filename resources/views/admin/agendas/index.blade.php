@extends('layouts.admin')
@section('header', 'Agenda')
@section('content')
<a href="{{ route('admin.agendas.create') }}" class="btn btn-primary mb-3">Tambah Agenda</a>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Judul</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                @foreach($items as $g)
                    <tr>
                        <td>{{ $g->title }}</td>
                        <td>{{ optional($g->event_date)->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.agendas.edit', $g) }}" class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action="{{ route('admin.agendas.destroy', $g) }}" class="d-inline" onsubmit="return confirm('Hapus?')">
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