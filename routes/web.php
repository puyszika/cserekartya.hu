<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\CommentController;

// Kezdőlap, nyilvános elérés
Route::get('/', [PageController::class, 'home'])->name('home');

// Nyilvánosan elérhető oldalak
Route::get('/listings', [ListingController::class, 'index'])->name('listings.index'); // Hirdetések listázása
Route::get('/listings/search', [ListingController::class, 'search'])->name('listings.search'); // Keresési eredmények megjelenítése
Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listings.show'); // Egy hirdetés részletes megtekintése
Route::get('/contact', [ContactController::class, 'showForm'])->name('contact'); // Kapcsolatfelvételi űrlap
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.send'); // Kapcsolatfelvételi űrlap elküldése
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');


// Csak bejelentkezett felhasználók számára elérhető oldalak
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard'); // Dashboard (Jetstream biztosítja)

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index'); // Üzenetek
    Route::get('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead'); // Értesítések
    Route::get('/messages/create/{receiver_id}', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/reply/{receiver_id}', [MessageController::class, 'reply'])->name('messages.reply');
    Route::get('/messages/conversation/{sender_id}/{listing_id?}', [MessageController::class, 'showConversation'])->name('messages.conversation');
    Route::post('/messages/reply/{receiver_id}', [MessageController::class, 'sendReply'])->name('messages.sendReply');
    Route::get('listings.create', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/listings', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{id}/edit', [ListingController::class, 'edit'])->name('listings.edit'); // Hirdetés szerkesztése
    Route::put('/listings/{id}', [ListingController::class, 'update'])->name('listings.update'); // Hirdetés frissítése
    Route::delete('/listings/{id}', [ListingController::class, 'destroy'])->name('listings.destroy'); // Hirdetés törlése
    Route::post('/listings/{listing}/comments', [CommentController::class, 'store'])->name('comments.store');


});







