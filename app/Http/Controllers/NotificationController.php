<?php


namespace App\Http\Controllers;

    use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Értesítés olvasottnak jelölése
    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return redirect()->back()->with('success', 'Értesítés olvasottnak jelölve.');
        } else {
            return redirect()->back()->with('error', 'Értesítés nem található.');
        }
    }
}

