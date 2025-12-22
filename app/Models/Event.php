<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'date',
        'type',
        'description',
        'location',
        'map_link',
        'image_url',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Связь с посещениями событий
    public function visits()
    {
        return $this->hasMany(EventVisit::class, 'event_id');
    }

    // Связь с голосованиями
    public function votings()
    {
        return $this->hasMany(Voting::class, 'event_id');
    }
}