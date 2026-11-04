<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('pages.show', [
            'page' => $page,
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