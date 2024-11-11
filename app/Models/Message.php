<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'content', 'is_read', 'listing_id'];

    // Kapcsolat a Feladóhoz
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Kapcsolat a Címzetthez
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Kapcsolat a Hirdetéshez
    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    // Scope az olvasatlan üzenetek lekérdezéséhez
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
