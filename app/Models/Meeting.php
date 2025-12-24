<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $table = 'meet_meetings';
    protected $hidden = ['id'];

    protected $fillable = [
        'meet_token',
        'user_token_id',
        'description',
        'date',
        'title',
        'image_url',
        'type',
        'age_limit',
        'location',
        'map_link',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => 'boolean',
    ];

    // Связь с просмотрами встреч
    public function views()
    {
        return $this->hasMany(MeetView::class, 'meet_id');
    }

    // Связь с посещениями встреч
    public function visits()
    {
        return $this->hasMany(MeetVisit::class, 'meeting_id');
    }

    // Связь с создателем встречи
    public function creator()
    {
        return $this->hasOne(MeetUsersCreator::class, 'token_id', 'user_token_id');
    }
}
