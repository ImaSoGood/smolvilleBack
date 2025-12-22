<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventVisit extends Model
{
    use HasFactory;

    protected $table = 'event_visit';

    protected $fillable = [
        'event_id',
        'user_id',
    ];

    // Связь с событием
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}