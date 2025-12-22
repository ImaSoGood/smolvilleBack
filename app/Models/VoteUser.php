<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteUser extends Model
{
    use HasFactory;

    protected $table = 'vote_user';

    protected $fillable = [
        'voting_id',
        'vote_params_id',
        'user_id',
    ];

    // Связь с голосованием
    public function voting()
    {
        return $this->belongsTo(Voting::class, 'voting_id');
    }

    // Связь с параметром голосования
    public function param()
    {
        return $this->belongsTo(VoteParam::class, 'vote_params_id');
    }
}