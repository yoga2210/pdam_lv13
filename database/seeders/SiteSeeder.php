<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Perumda Air Minum Mojokerto',
            'site_tagline' => 'Informasi dan layanan air minum bagi masyarakat',
            'address' => 'Jl. Contoh No. 1, Mojokerto, Jawa Timur',
            'phone' => '(0321) 000000',
            'whatsapp' => '6281234567890',
            'email' => 'info@pdam-mojokerto.test',
            'facebook' => '#',
            'twitter' => '#',
            'youtube' => '#',
            'instagram' => '#',
            'maps_embed' => '',
        ];
        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        $pages = [
            ['title' => 'Kata Pengantar', 'slug' => 'kata-pengantar', 'content' => '<p>Kata pengantar perusahaan.</p>'],
            ['title' => 'Visi & Misi', 'slug' => 'visi-misi', 'content' => '<p>Visi dan misi perusahaan.</p>'],
            ['title' => 'Stakeholder', 'slug' => 'stakeholder', 'content' => '<p>Informasi stakeholder.</p>'],
            ['title' => 'Gambaran Umum', 'slug' => 'gambaran-umum', 'content' => '<p>Gambaran umum perusahaan.</p>'],
            ['title' => 'Kontak', 'slug' => 'kontak', 'content' => '<p>Hubungi kami.</p>'],
        ];
        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}