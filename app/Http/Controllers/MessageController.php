<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Listing;
use App\Notifications\MessageReceived;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Kapott üzenetek megjelenítése
    public function index()
    {
        // Az összes üzenet, amelyet a bejelentkezett felhasználó kapott, csoportosítva a feladó és a hirdetés szerint
        $messages = Message::with(['sender', 'listing'])
            ->where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Frissítjük az olvasatlan üzenetek állapotát "olvasottra"
        $messages->each(function ($message) {
            if (!$message->is_read) {
                $message->is_read = true;
                $message->save();
            }
        });

        // Az üzenetek csoportosítása a feladó és a hirdetés szerint
        $messageGroups = $messages->groupBy(function ($message) {
            return $message->listing_id . '-' . $message->sender_id;
        })->map(function ($group) {
            return [
                'listing' => $group->first()->listing,
                'messages' => $group,
                'latest_message' => $group->first(), // Az utolsó üzenet megjelenítése a listában
                'sender' => $group->first()->sender, // A feladó adatainak átadása a nézethez
            ];
        });
        // Elküldött üzenetek lekérdezése
        $sentMessages = Message::with(['receiver', 'listing'])
            ->where('sender_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // Elküldött üzenetek csoportosítása
        $sentMessageGroups = $sentMessages->groupBy(function ($message) {
            return $message->listing_id . '-' . $message->receiver_id;
        })->map(function ($group) {
            return [
                'listing' => $group->first()->listing,
                'messages' => $group,
                'latest_message' => $group->first(), // Az utolsó üzenet megjelenítése a listában
                'receiver' => $group->first()->receiver, // A címzett adatainak átadása a nézethez
            ];
        });

        // Nézet visszaadása a csoportosított üzenetekkel
        return view('messages.index', compact('messageGroups', 'sentMessageGroups'));
    }

    // Megjeleníti az üzenet létrehozási űrlapot
    public function create($receiver_id = null, $listing_id = null)
    {
        // Keresd meg a címzettet és a hirdetést az adatbázisban
        $receiver = $receiver_id ? User::findOrFail($receiver_id) : null;
        $listing = $listing_id ? Listing::findOrFail($listing_id) : null;

        // Térjünk vissza az űrlapot tartalmazó nézettel, és adjuk át a címzettet és a hirdetést
        return view('messages.create', compact('receiver', 'receiver_id', 'listing'));
    }

    // Az üzenet elmentéséhez szükséges metódus
    public function store(Request $request)
    {
        // Üzenet adatainak validálása
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'listing_id' => 'required|exists:listings,id',
            'content' => 'required|string|min:1|max:1000',
        ]);

        // Hozzáférés ellenőrzése - csak bejelentkezett felhasználók küldhetnek üzenetet
        if (auth()->check()) {
            // Új üzenet létrehozása és adatainak beállítása
            $message = new Message();
            $message->sender_id = auth()->id();
            $message->receiver_id = $request->receiver_id;
            $message->listing_id = $request->listing_id;
            $message->content = $request->content;
            $message->save();

            // Értesítés küldése a címzettnek
            $receiver = User::find($request->receiver_id);
            $receiver->notify(new MessageReceived($message));

            // Átirányítás a hirdetés oldalára sikeres üzenetküldés üzenettel
            return redirect()->route('listings.show', ['listing' => $request->listing_id])->with('success', 'Üzenet sikeresen elküldve.');
        } else {
            // Ha a felhasználó nincs bejelentkezve, átirányítás a bejelentkezési oldalra
            return redirect()->route('login')->with('error', 'Be kell jelentkezned az üzenet küldéséhez.');
        }
    }

    // Üzenet válasz űrlap megjelenítése
    public function reply($receiver_id, $listing_id = null)
    {
        $receiver = User::findOrFail($receiver_id);
        $listing = $listing_id ? Listing::findOrFail($listing_id) : null;
        return view('messages.reply', compact('receiver', 'listing'));
    }

    // Üzenet válasz mentése
    public function sendReply(Request $request, $receiver_id)
    {
        // Üzenet adatainak validálása
        $request->validate([
            'content' => 'required|string|min:1|max:1000',
            'listing_id' => 'nullable|exists:listings,id',
        ]);

        if (auth()->check()) {
            // Új válasz létrehozása
            $message = new Message();
            $message->sender_id = auth()->id();
            $message->receiver_id = $receiver_id;
            $message->content = $request->content;
            $message->listing_id = $request->listing_id;
            $message->save();

            // Értesítés küldése a címzettnek
            $receiver = User::find($receiver_id);
            $receiver->notify(new MessageReceived($message));

            return redirect()->route('messages.index')->with('success', 'Válasz sikeresen elküldve.');
        } else {
            return redirect()->route('login')->with('error', 'Be kell jelentkezned az üzenet küldéséhez.');
        }
    }

    // Megjeleníti az összes üzenetet egy adott felhasználóval és hirdetéssel kapcsolatban
    public function showConversation($sender_id, $listing_id = null)
    {
        // Lekérjük a felhasználóhoz és a hirdetéshez kapcsolódó üzeneteket
        $query = Message::with(['sender', 'listing'])
            ->where(function ($query) use ($sender_id) {
                $query->where('sender_id', auth()->id())
                    ->where('receiver_id', $sender_id);
            })
            ->orWhere(function ($query) use ($sender_id) {
                $query->where('sender_id', $sender_id)
                    ->where('receiver_id', auth()->id());
            });

        // Hirdetés alapján szűrünk, ha meg van adva
        if ($listing_id) {
            $query->where('listing_id', $listing_id);
        }

        // Üzenetek lekérése a dátum alapján rendezve
        $messages = $query->orderBy('created_at', 'asc')->get();

        // Visszatérés a nézethez a beszélgetés üzeneteivel
        return view('messages.conversation', compact('messages'));
    }
}
