<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Setting;

class AnnouncementController extends Controller
{
    public function index()
    {
        $items = Announcement::where('is_published', true)->latest('published_at')->paginate(10);
        return view('announcements.index', [
            'items' => $items,
            'settings' => $this->settings(),
        ]);
    }

    public function show(string $slug)
    {
        $item = Announcement::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('announcements.show', [
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