<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['listing_id', 'filename'];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
