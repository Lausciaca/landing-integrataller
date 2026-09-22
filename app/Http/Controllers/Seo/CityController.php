<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CityController extends Controller
{
    /**
     * Hub page listing all local landing pages.
     */
    public function index(): View
    {
        return view('seo.cities-index', [
            'cities' => config('seo.cities'),
        ]);
    }

    /**
     * Programmatic local landing page (e.g. /talleres-en-rosario).
     */
    public function show(string $ciudad): View
    {
        $city = config("seo.cities.$ciudad");

        abort_unless(is_array($city), 404);

        return view('seo.city', [
            'slug' => $ciudad,
            'city' => $city,
        ]);
    }
}
