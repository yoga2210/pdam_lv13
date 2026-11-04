<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Setting;

class AgendaController extends Controller
{
    public function index()
    {
        $items = Agenda::where('is_published', true)->orderBy('event_date')->paginate(10);
        return view('agenda.index', [
            'items' => $items,
            'settings' => $this->settings(),
        ]);
    }

    public function show(string $slug)
    {
        $item = Agenda::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('agenda.show', [
            'item' => $item,
            'settings' => $this->settings(),
        ]);
    }

    protected function settings(): array
    {
        $keys = ['site_name','site_tagline','address','phone','whatsapp','email','facebook','twitter','youtube','instagram','maps_embed','logo'];
        $out = [];
        foreach ($keys as $k) {
            $out[$k] = Setting::get($k);
        }
        return $out;
    }
}