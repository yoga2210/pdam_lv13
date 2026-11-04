<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index()
    {
        $items = Video::latest()->paginate(15);
        return view('admin.videos.index', compact('items'));
    }

    public function create()
    {
        return view('admin.videos.form', ['item' => new Video()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => ['nullable', 'url'],
            'thumbnail' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'is_published' => 'nullable|boolean',
        ]);
        $data['slug'] = $this->uniqueSlug(Video::class, $data['title']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }
        $data['is_published'] = $request->boolean('is_published');
        Video::create($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.form', ['item' => $video]);
    }

    public function update(Request $request, Video $video)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'youtube_url' => ['nullable', 'url'],
            'thumbnail' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'is_published' => 'nullable|boolean',
        ]);
        if ($data['title'] !== $video->title) {
            $data['slug'] = $this->uniqueSlug(Video::class, $data['title'], $video->id);
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        } else {
            unset($data['thumbnail']);
        }
        $data['is_published'] = $request->boolean('is_published');
        $video->update($data);
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video berhasil dihapus.');
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