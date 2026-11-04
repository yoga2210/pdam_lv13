@extends('layouts.admin')
@section('header', $item->exists ? 'Edit Berita' : 'Tambah Berita')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}" enctype="multipart/form-data">
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
                <textarea name="content" id="contentEditor" class="form-control" rows="12">{{ old('content', $item->content) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" accept="image/*">
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#contentEditor',
        height: 420,
        plugins: 'advlist autolink lists link image media table code wordcount',
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media table | code',
        automatic_uploads: true,
        file_picker_types: 'image file',
        images_upload_url: '{{ route('admin.tinymce.upload') }}',
        images_upload_handler: function (blobInfo, progress) {
            return new Promise(function(resolve, reject) {
                const file = blobInfo.blob();
                if (file.size > 20 * 1024 * 1024) {
                    reject('Ukuran file maksimal 20MB.');
                    return;
                }

                const formData = new FormData();
                formData.append('file', file, blobInfo.filename());
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('admin.tinymce.upload') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.location) {
                        resolve(data.location);
                    } else {
                        reject('Upload gagal.');
                    }
                })
                .catch(() => reject('Upload gagal.'));
            });
        },
        relative_urls: false,
        document_base_url: '{{ url('/') }}/',
        setup: function(editor) {
            editor.on('BeforeUpload', function(e) {
                const file = e.file;
                if (file.size > 20 * 1024 * 1024) {
                    e.preventDefault();
                    alert('Ukuran file maksimal 20MB.');
                }
            });
        }
    });
</script>
@endsection