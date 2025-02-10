<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'category',
        'user_id'
    ];

    /**
     * Relazione: ogni evento appartiene a un utente (il creatore).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
