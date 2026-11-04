<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function index()
    {
        $items = Album::latest()->paginate(15);
        return view('admin.albums.index', compact('items'));
    }

    public function create()
    {
        return view('admin.albums.form', ['item' => new Album()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'is_published' => 'nullable|boolean',
        ]);
        $data['slug'] = $this->uniqueSlug(Album::class, $data['title']);
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('albums', 'public');
        }
        $data['is_published'] = $request->boolean('is_published');
        Album::create($data);
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil ditambahkan.');
    }

    public function edit(Album $album)
    {
        return view('admin.albums.form', ['item' => $album]);
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'is_published' => 'nullable|boolean',
        ]);
        if ($data['title'] !== $album->title) {
            $data['slug'] = $this->uniqueSlug(Album::class, $data['title'], $album->id);
        }
        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('albums', 'public');
        } else {
            unset($data['cover']);
        }
        $data['is_published'] = $request->boolean('is_published');
        $album->update($data);
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()->route('admin.albums.index')->with('success', 'Album berhasil dihapus.');
    }

    public function storePhoto(Request $request, Album $album)
    {
        $request->validate(['image' => 'required|image|max:20480|dimensions:max_width=1920,max_height=1080', 'caption' => 'nullable|string']);
        $path = $request->file('image')->store('photos', 'public');
        $album->photos()->create(['image' => $path, 'caption' => $request->caption]);
        return back()->with('success', 'Foto berhasil ditambahkan.');
    }

    public function destroyPhoto(Photo $photo)
    {
        $photo->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    protected function uniqueSlug(string $model, string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $i = 1;
        while ($model::where('slug', $slug)->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }
}