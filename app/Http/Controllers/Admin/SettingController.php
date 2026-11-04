<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function edit()
    {
        $keys = ['site_name','site_tagline','address','phone','whatsapp','email','facebook','twitter','youtube','instagram','maps_embed','logo','favicon'];
        $settings = [];
        foreach ($keys as $k) {
            $settings[$k] = Setting::get($k);
        }
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = ['site_name','site_tagline','address','phone','whatsapp','email','facebook','twitter','youtube','instagram'];
        foreach ($keys as $k) {
            Setting::set($k, trim((string) $request->input($k, '')));
        }

        $mapsEmbed = trim((string) $request->input('maps_embed', ''));
        if ($mapsEmbed !== '') {
            $mapsEmbed = preg_replace('/<script.*?>.*?<\/script>/is', '', $mapsEmbed);
            $mapsEmbed = preg_replace('/on[a-z]+\s*=\s*["\'][^"\']*["\']/i', '', $mapsEmbed);
            $mapsEmbed = preg_replace('/<iframe[^>]*src=["\']([^"\']+)["\'][^>]*><\/iframe>/i', '<iframe src="$1" width="100%" height="220" style="border:0;display:block;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', $mapsEmbed);
            Setting::set('maps_embed', $mapsEmbed);
        } else {
            Setting::set('maps_embed', '');
        }

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $allowedLogoMime = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
            $allowedLogoExt = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

            if (! in_array($logo->getMimeType(), $allowedLogoMime, true) || ! in_array(strtolower($logo->getClientOriginalExtension()), $allowedLogoExt, true)) {
                return back()->withErrors(['logo' => 'Format logo tidak valid. Gunakan JPG, PNG, WebP, atau SVG.'])->withInput();
            }

            $path = $logo->store('settings', 'public');
            Setting::set('logo', $path);
        }

        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $allowedFaviconMime = ['image/jpeg', 'image/png', 'image/webp', 'image/x-icon', 'image/vnd.microsoft.icon'];
            $allowedFaviconExt = ['jpg', 'jpeg', 'png', 'webp', 'ico'];

            if (! in_array($favicon->getMimeType(), $allowedFaviconMime, true) || ! in_array(strtolower($favicon->getClientOriginalExtension()), $allowedFaviconExt, true)) {
                return back()->withErrors(['favicon' => 'Format favicon tidak valid. Gunakan JPG, PNG, WebP, atau ICO.'])->withInput();
            }

            $path = $favicon->store('settings', 'public');
            Setting::set('favicon', $path);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}