<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a contact request submitted from the landing page.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'taller' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Contact::create($validated);

        return redirect()
            ->route('contacto')
            ->with('status', '¡Gracias! Recibimos tu consulta y te vamos a contactar a la brevedad.');
    }
}
