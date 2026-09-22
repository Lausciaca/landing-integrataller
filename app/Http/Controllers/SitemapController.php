<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate the XML sitemap for all public and programmatic pages.
     */
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['loc' => route('servicios'), 'priority' => '0.9', 'changefreq' => 'monthly'],
            ['loc' => route('tutoriales'), 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => route('contacto'), 'priority' => '0.8', 'changefreq' => 'yearly'],
            ['loc' => route('features.index'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('cities.index'), 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['loc' => route('terminos'), 'priority' => '0.3', 'changefreq' => 'yearly'],
            ['loc' => route('privacidad'), 'priority' => '0.3', 'changefreq' => 'yearly'],
        ];

        foreach (array_keys(config('seo.features')) as $slug) {
            $urls[] = ['loc' => route('features.show', $slug), 'priority' => '0.7', 'changefreq' => 'monthly'];
        }

        foreach (array_keys(config('seo.cities')) as $slug) {
            $urls[] = ['loc' => route('cities.show', $slug), 'priority' => '0.7', 'changefreq' => 'monthly'];
        }

        return response()
            ->view('sitemap', ['urls' => $urls, 'lastmod' => now()->toAtomString()])
            ->header('Content-Type', 'application/xml');
    }
}
