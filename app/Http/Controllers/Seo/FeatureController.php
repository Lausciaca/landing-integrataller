<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class FeatureController extends Controller
{
    /**
     * Hub page listing all programmatic feature landings.
     */
    public function index(): View
    {
        return view('seo.features-index', [
            'features' => config('seo.features'),
        ]);
    }

    /**
     * Programmatic feature landing page (e.g. /caracteristicas/control-de-turnos).
     */
    public function show(string $slug): View
    {
        $feature = config("seo.features.$slug");

        abort_unless(is_array($feature), 404);

        return view('seo.feature', [
            'slug' => $slug,
            'feature' => $feature,
        ]);
    }
}
