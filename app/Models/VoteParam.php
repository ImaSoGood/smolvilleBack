<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteParam extends Model
{
    use HasFactory;

    protected $table = 'vote_params';

    protected $fillable = [
        'voting_id',
        'title',
        'image_url',
    ];

    // Связь с голосованием
    public function voting()
    {
        return $this->belongsTo(Voting::class, 'voting_id');
    }

    // Связь с голосами пользователей
    public function userVotes()
    {
        return $this->hasMany(VoteUser::class, 'vote_params_id');
    }
}