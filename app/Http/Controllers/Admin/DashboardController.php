<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Album;
use App\Models\Announcement;
use App\Models\News;
use App\Models\Video;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'newsCount' => News::count(),
            'announcementCount' => Announcement::count(),
            'agendaCount' => Agenda::count(),
            'albumCount' => Album::count(),
            'videoCount' => Video::count(),
        ]);
    }
}