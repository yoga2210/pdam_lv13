<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $items = Page::latest()->paginate(15);
        return view('admin.pages.index', compact('items'));
    }

    public function create()
    {
        return view('admin.pages.form', ['item' => new Page()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
        ]);
        $data['slug'] = Str::slug($data['title']);
        if (Page::where('slug', $data['slug'])->exists()) {
            $data['slug'] .= '-' . time();
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        }
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', ['item' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
        ]);
        if ($data['title'] !== $page->title) {
            $data['slug'] = Str::slug($data['title']);
        }
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        } else {
            unset($data['image']);
        }
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}