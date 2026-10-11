<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Seo\CityController;
use App\Http\Controllers\Seo\FeatureController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/servicios', 'servicios')->name('servicios');
Route::view('/tutoriales', 'tutoriales')->name('tutoriales');

Route::view('/contacto', 'contacto')->name('contacto');
Route::post('/contacto', [ContactController::class, 'store'])->middleware('throttle:6,1')->name('contacto.store');
Route::view('/demo/solicitada', 'demo.thank-you')->name('demo.thank-you');

Route::post('/newsletter/suscribir', [NewsletterController::class, 'store'])->middleware('throttle:6,1')->name('newsletter.store');
Route::get('/newsletter/confirmacion-enviada', [NewsletterController::class, 'pending'])->name('newsletter.pending');
Route::get('/newsletter/confirmar/{token}', [NewsletterController::class, 'confirmForm'])->where('token', '[A-Za-z0-9]{64}')->name('newsletter.confirm.show');
Route::post('/newsletter/confirmar', [NewsletterController::class, 'confirm'])->middleware('throttle:6,1')->name('newsletter.confirm');
Route::get('/newsletter/confirmada', fn () => view('newsletter.confirmed', ['confirmed' => true]))->name('newsletter.confirmed');
Route::get('/newsletter/baja/{token}', [NewsletterController::class, 'unsubscribeForm'])->where('token', '[A-Za-z0-9]{64}')->name('newsletter.unsubscribe.show');
Route::post('/newsletter/baja', [NewsletterController::class, 'unsubscribe'])->middleware('throttle:6,1')->name('newsletter.unsubscribe');

Route::view('/terminos', 'legal.terminos')->name('terminos');
Route::view('/politica-de-privacidad', 'legal.privacidad')->name('privacidad');

// SEO programático (long-tail)
Route::get('/caracteristicas', [FeatureController::class, 'index'])->name('features.index');
Route::get('/caracteristicas/{slug}', [FeatureController::class, 'show'])->name('features.show');
Route::get('/talleres', [CityController::class, 'index'])->name('cities.index');
Route::get('/talleres-en-{ciudad}', [CityController::class, 'show'])->name('cities.show');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
