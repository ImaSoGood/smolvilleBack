<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventVisit;

class EventController extends Controller
{
    public function ReturnEvents()
    {
        $events = Event::withCount('visits as attendees_count')
                        ->orderBy('date', 'ASC')
                        ->get();
        
        return $events;
    }

    public function ReturnEvent($event_id)
    {
        $event = Event::where('id', $event_id)
                        ->first();

        return json_encode($event);
    }

    public function ReturnAttendeesCount($event_id)
    {
        $count = EventVisit::where('event_id', $event_id)->count();
        return ['count' => $count];
    }

    public function checkUserAttendance($event_id, $user_id)
    {
        $result = EventVisit::where([
                    'event_id' => $event_id,
                    'user_id' => $user_id
                    ])->count();
        
        return ['is_attending' => $result > 0];
    }

    public function unattendEvent($event_id, $user_id)
    {
        $unattend = EventVisit::where([
                        'event_id' => $event_id, 
                        'user_id' => $user_id])
                        ->delete();
        if($unattend > 0)
            return ['success' => true];
        else
            return ['success' => false,
                    'error' => 'Не оказалось записей об участии..'];
    }

    public function attendEvent($event_id, $user_id)
    {
        $exists = EventVisit::where([
                    'event_id' => $event_id,
                    'user_id' => $user_id])
                    ->exists();

        if($exists)
            return false;

        $eventVisit = new EventVisit();
        $eventVisit->event_id = $event_id;
        $eventVisit->user_id = $user_id;
        $eventVisit->save();
        return true;
    }

    
}
