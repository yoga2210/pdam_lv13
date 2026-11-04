<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $items = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('items'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['item' => new Slider()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['image'] = $request->file('image')->store('sliders', 'public');
        $data['sort_order'] = $request->input('sort_order', 0);
        $data['is_active'] = $request->boolean('is_active');
        Slider::create($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', ['item' => $slider]);
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:20480|dimensions:max_width=1920,max_height=1080',
            'link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        } else {
            unset($data['image']);
        }
        $data['sort_order'] = $request->input('sort_order', $slider->sort_order);
        $data['is_active'] = $request->boolean('is_active');
        $slider->update($data);
        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil dihapus.');
    }
}