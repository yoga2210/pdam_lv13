<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class ContactController extends Controller
{
    public function index()
    {
        $settings = [];
        foreach (['site_name','address','phone','whatsapp','email','facebook','twitter','youtube','instagram','maps_embed','logo'] as $k) {
            $settings[$k] = Setting::get($k);
        }
        return view('contact', compact('settings'));
    }
}