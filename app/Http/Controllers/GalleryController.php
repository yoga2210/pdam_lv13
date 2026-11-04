<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Setting;
use App\Models\Video;

class GalleryController extends Controller
{
    public function photos()
    {
        $albums = Album::where('is_published', true)->latest()->paginate(12);
        return view('gallery.photos', [
            'albums' => $albums,
            'settings' => $this->settings(),
        ]);
    }

    public function album(string $slug)
    {
        $album = Album::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('gallery.album', [
            'album' => $album,
            'settings' => $this->settings(),
        ]);
    }

    public function videos()
    {
        $videos = Video::where('is_published', true)->latest()->paginate(12);
        return view('gallery.videos', [
            'videos' => $videos,
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