<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'category_id', 'user_id'];

    // Kapcsolat a Category modellel
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Kapcsolat a User modellel
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Kapcsolat az Image modellel
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
