<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        $items = Announcement::latest()->paginate(15);
        return view('admin.announcements.index', compact('items'));
    }

    public function create()
    {
        return view('admin.announcements.form', ['item' => new Announcement()]);
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
        $data['slug'] = $this->uniqueSlug(Announcement::class, $data['title']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('announcements', 'public');
        }
        $data['is_published'] = $request->boolean('is_published');
        Announcement::create($data);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', ['item' => $announcement]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'published_at' => 'nullable|date',
            'is_published' => 'nullable|boolean',
        ]);
        if ($data['title'] !== $announcement->title) {
            $data['slug'] = $this->uniqueSlug(Announcement::class, $data['title'], $announcement->id);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('announcements', 'public');
        } else {
            unset($data['image']);
        }
        $data['is_published'] = $request->boolean('is_published');
        $announcement->update($data);
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
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