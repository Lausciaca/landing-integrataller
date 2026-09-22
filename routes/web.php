<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Seo\CityController;
use App\Http\Controllers\Seo\FeatureController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/servicios', 'servicios')->name('servicios');
Route::view('/tutoriales', 'tutoriales')->name('tutoriales');

Route::view('/contacto', 'contacto')->name('contacto');
Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');

Route::view('/terminos', 'legal.terminos')->name('terminos');
Route::view('/politica-de-privacidad', 'legal.privacidad')->name('privacidad');

// SEO programático (long-tail)
Route::get('/caracteristicas', [FeatureController::class, 'index'])->name('features.index');
Route::get('/caracteristicas/{slug}', [FeatureController::class, 'show'])->name('features.show');
Route::get('/talleres', [CityController::class, 'index'])->name('cities.index');
Route::get('/talleres-en-{ciudad}', [CityController::class, 'show'])->name('cities.show');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
