<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetVisit extends Model
{
    use HasFactory;

    protected $table = 'meet_visit';

    protected $fillable = [
        'meeting_token',
        'meeting_id',
        'user_id',
    ];

    // Связь с встречей
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}