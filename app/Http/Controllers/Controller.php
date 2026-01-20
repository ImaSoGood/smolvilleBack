<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Meeting;

abstract class Controller
{
    public function CheckDateOnMeeting($meet_token)
    {
        $ActualMeeting = Meeting::where('meet_token', $meet_token)->first();
        if($ActualMeeting->date < now())
            return true;
        return false;
    }

    public function CheckDateOnEvent($event_id)
    {
        $ActualEvent = Event::where('id', $event_id)->first();
        if($ActualEvent->date < now())
            return true;
        return false;
    }
}
