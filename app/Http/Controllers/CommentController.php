<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Listing;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Listing $listing)
    {
        // Validálás
        $validatedData = $request->validate([
            'content' => 'required|string|max:500',
        ]);

        // Hozzászólás létrehozása
        Comment::create([
            'listing_id' => $listing->id,
            'user_id' => auth()->id(),
            'content' => $validatedData['content'],
        ]);

        // Visszairányítás az adott hirdetés részletei oldalára
        return redirect()->route('listings.show', $listing->id)->with('success', 'Hozzászólás sikeresen létrehozva!');
    }
}
