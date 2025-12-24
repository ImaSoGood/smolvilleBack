<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetView extends Model
{
    use HasFactory;

    protected $table = 'meet_views';

    protected $fillable = [
        'meet_id',
        'user_id',
        'watch_time',
    ];

    protected $casts = [
        'watch_time' => 'datetime',
    ];

    // Связь с встречей
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meet_id');
    }
}
