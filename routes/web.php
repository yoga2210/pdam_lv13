<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\AlbumController as AdminAlbumController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/halaman/{slug}', [PageController::class, 'show'])->name('page.show');

Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/pengumuman/{slug}', [AnnouncementController::class, 'show'])->name('announcements.show');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{slug}', [AgendaController::class, 'show'])->name('agenda.show');

Route::get('/galeri-foto', [GalleryController::class, 'photos'])->name('gallery.photos');
Route::get('/galeri-foto/{slug}', [GalleryController::class, 'album'])->name('gallery.album');
Route::get('/galeri-video', [GalleryController::class, 'videos'])->name('gallery.videos');

Route::get('/kontak', [ContactController::class, 'index'])->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::post('/tinymce-upload', [AdminNewsController::class, 'uploadContentImage'])->name('tinymce.upload');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('news', AdminNewsController::class)->except(['show']);
        Route::resource('announcements', AdminAnnouncementController::class)->except(['show']);
        Route::resource('agendas', AdminAgendaController::class)->except(['show']);
        Route::resource('albums', AdminAlbumController::class)->except(['show']);
        Route::post('albums/{album}/photos', [AdminAlbumController::class, 'storePhoto'])->name('albums.photos.store');
        Route::delete('photos/{photo}', [AdminAlbumController::class, 'destroyPhoto'])->name('photos.destroy');
        Route::resource('videos', AdminVideoController::class)->except(['show']);
        Route::resource('sliders', AdminSliderController::class)->except(['show']);
        Route::resource('pages', AdminPageController::class)->except(['show']);

        Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

        Route::get('/password', [AdminAuthController::class, 'showPasswordForm'])->name('password.edit');
        Route::put('/password', [AdminAuthController::class, 'updatePassword'])->name('password.update');
    });
});