<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;

    protected $table = 'voting';

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_at',
        'image_url',
        'event_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Связь с событием
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Связь с параметрами голосования
    public function params()
    {
        return $this->hasMany(VoteParam::class, 'voting_id');
    }

    // Связь с голосами пользователей
    public function userVotes()
    {
        return $this->hasMany(VoteUser::class, 'voting_id');
    }
}