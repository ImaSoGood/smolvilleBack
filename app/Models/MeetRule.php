<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetRule extends Model
{
    use HasFactory;

    protected $table = 'meet_rules';

    protected $fillable = [
        'token_id',
        'rule_token',
    ];

    // Связь с создателями (пользователями с правами)
    public function creators()
    {
        return $this->hasMany(MeetUsersCreator::class, 'token_id');
    }
}