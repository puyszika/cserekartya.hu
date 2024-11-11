<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Kapcsolat a Listing modellel
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}
