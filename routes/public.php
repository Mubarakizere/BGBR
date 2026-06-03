<?php

/*
|--------------------------------------------------------------------------
| Public Website Routes
|--------------------------------------------------------------------------
|
| These routes serve the public-facing BGBR website on the main domain.
| They require NO authentication and only read from site_* CMS tables.
| Completely isolated from the internal management system.
|
*/

use App\Http\Controllers\PublicSiteController;
use Illuminate\Support\Facades\Route;

Route::name('site.')->group(function () {
    Route::get('/', [PublicSiteController::class, 'home'])->name('home');
    Route::get('/about', [PublicSiteController::class, 'about'])->name('about');
    Route::get('/leadership', [PublicSiteController::class, 'leadership'])->name('leadership');
    Route::get('/events', [PublicSiteController::class, 'events'])->name('events');
    Route::get('/news', [PublicSiteController::class, 'news'])->name('news');
    Route::get('/news/{slug}', [PublicSiteController::class, 'newsShow'])->name('news.show');
    Route::get('/gallery', [PublicSiteController::class, 'gallery'])->name('gallery');
    Route::get('/contact', [PublicSiteController::class, 'contact'])->name('contact');
    Route::post('/contact', [PublicSiteController::class, 'contactSubmit'])
        ->name('contact.submit')
        ->middleware('throttle:5,1');
    Route::get('/donate', [PublicSiteController::class, 'donate'])->name('donate');
    Route::get('/faq', [PublicSiteController::class, 'faq'])->name('faq');
});
