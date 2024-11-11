<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    // űrlap megjelenítése
    public function showForm()
    {
        return view('contact');
    }

    // űrlap elküldése
    public function sendEmail(Request $request)
    {
        // űrlap adatainak validálása
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // E-mail küldés
        Mail::to('info@cserekartya.hu')->send(new ContactMail($validated));

        // Visszajelzés a felhasználónak
        return back()->with('success', 'Az üzenetét sikeresen elküldtük!');
    }
}
