<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ListingController extends Controller
{
    public function index()
    {
        $listings = Listing::with('images')->get(); // Lekérdezzük a hirdetéseket, beleértve a kapcsolódó képeket is
        $categories = Category::all(); // Kategóriák lekérdezése

        return view('listings.index', compact('listings', 'categories'));
    }

    // Egy hirdetés részletes oldala
    public function show($id)
    {
        $listing = Listing::findOrFail($id);
        return view('listings.show', compact('listing'));
    }

    // Hirdetés létrehozási űrlap megjelenítése
    public function create()
    {
        Log::info('create() metódus elindult');
        $categories = Category::all(); // Kategóriák lekérdezése az adatbázisból
        return view('listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validálás
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'city' => 'required|string|max:255',
            'delivery_method' => 'required|in:házhozszállítás,személyesen,mindkettő',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Képek validálása
        ]);

        // Hirdetés létrehozása
        $listing = Listing::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'city' => $request->city,
            'delivery_method' => $request->delivery_method,
            'user_id' => auth()->id(),
        ]);

        // Kép feltöltés ellenőrzése és mentése
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                // Kép útvonalának mentése az adatbázisba
                Image::create([
                    'listing_id' => $listing->id,
                    'filename' => $path,
                ]);
            }
        }

        return redirect()->route('listings.index')->with('success', 'Hirdetés létrehozva!');
    }

    // Hirdetés szerkesztési űrlap megjelenítése
    public function edit($id)
    {
        $listing = Listing::findOrFail($id);
        $categories = Category::all();

        return view('listings.edit', compact('listing', 'categories'));
    }

    // Hirdetés frissítése
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $listing = Listing::findOrFail($id);
        $listing->update($request->only(['title', 'description', 'price', 'category_id']));

        return redirect()->route('listings.show', $listing->id)->with('success', 'Hirdetés frissítve!');
    }

    // Hirdetés törlése
    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        if (auth()->user()->hasRole('admin') || auth()->id() == $listing->user_id) {
            $listing->delete();
            return redirect()->route('listings.index')->with('success', 'Hirdetés sikeresen törölve.');
        } else {
            return redirect()->route('listings.index')->with('error', 'Nincs jogosultságod a hirdetés törlésére.');
        }
    }

    public function search(Request $request)
    {
        $query = Listing::query();

        // Keresés cím szerint
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Keresés kategória szerint
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Keresés város szerint
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        // A találatok lekérdezése
        $listings = $query->get();
        $categories = Category::all();

        return view('listings.index', compact('listings', 'categories'));
    }
}
