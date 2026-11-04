<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::latest()->paginate(15);
        return view('admin.news.index', compact('items'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new News()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);
        $data['slug'] = $this->uniqueSlug(News::class, $data['title']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }
        $data['is_published'] = $request->boolean('is_published');
        News::create($data);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);
        if ($data['title'] !== $news->title) {
            $data['slug'] = $this->uniqueSlug(News::class, $data['title'], $news->id);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        } else {
            unset($data['image']);
        }
        $data['is_published'] = $request->boolean('is_published');
        $news->update($data);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function uploadContentImage(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'File tidak ditemukan.'], 400);
        }

        $request->validate([
            'file' => 'required|image|max:20480|dimensions:max_width=1920,max_height=1080',
        ]);

        $path = $request->file('file')->store('tinymce', 'public');

        return response()->json([
            'location' => asset('storage/' . $path),
        ]);
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