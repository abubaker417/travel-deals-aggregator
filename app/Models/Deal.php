<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'origin',
        'destination',
        'price',
        'departure_date',
        'return_date',
        'details',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'book_marks', 'deal_id', 'user_id')
                    ->withTimestamps();
    }
}
