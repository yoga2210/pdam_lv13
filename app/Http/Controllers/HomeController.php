<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Album;
use App\Models\Announcement;
use App\Models\News;
use App\Models\Setting;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'sliders' => Slider::where('is_active', true)->orderBy('sort_order')->get(),
            'news' => News::where('is_published', true)->latest('published_at')->take(6)->get(),
            'announcements' => Announcement::where('is_published', true)->latest('published_at')->take(6)->get(),
            'agendas' => Agenda::where('is_published', true)->orderBy('event_date')->take(6)->get(),
            'albums' => Album::with('photos')->where('is_published', true)->latest()->take(3)->get(),
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