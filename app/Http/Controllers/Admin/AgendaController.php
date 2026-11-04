<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AgendaController extends Controller
{
    public function index()
    {
        $items = Agenda::latest()->paginate(15);
        return view('admin.agendas.index', compact('items'));
    }

    public function create()
    {
        return view('admin.agendas.form', ['item' => new Agenda()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);
        $data['slug'] = $this->uniqueSlug(Agenda::class, $data['title']);
        $data['is_published'] = $request->boolean('is_published');
        Agenda::create($data);
        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.form', ['item' => $agenda]);
    }

    public function update(Request $request, Agenda $agenda)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'event_time' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);
        if ($data['title'] !== $agenda->title) {
            $data['slug'] = $this->uniqueSlug(Agenda::class, $data['title'], $agenda->id);
        }
        $data['is_published'] = $request->boolean('is_published');
        $agenda->update($data);
        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil dihapus.');
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