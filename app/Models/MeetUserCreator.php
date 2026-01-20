<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetUserCreator extends Model
{
    use HasFactory;

    protected $table = 'meet_users_creator';

    protected $fillable = [
        't_id',
        'token_id',
        'rule_token',
    ];

    // Связь с правилом
    public function rule()
    {
        return $this->belongsTo(MeetRule::class, 'token_id', 'token_id');
    }

    // Связь со встречами, созданными этим пользователем
    public function meetings()
    {
        return $this->hasMany(Meeting::class, 'user_token_id', 'token_id');
    }
}