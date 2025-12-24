<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetVisit;
use Illuminate\Http\Request;

class MeetController extends Controller
{
    public function ReturnMeetings()
    {
        $meetings = Meeting::withCount(['visits as visit_count'])
                                ->withCount(['views as view_count'])
                                ->with('creator')
                                ->where('status', 1)
                                ->orderBy('date', 'DESC')
                                ->get();

        return json_encode($meetings);
    }

    public function ReturnMeeting($token)
    {
        $meeting = Meeting::withCount(['visits as visit_count'])
                                ->withCount(['views as view_count'])
                                ->with('creator')
                                ->where('status', 1)
                                ->where('token', $token)
                                ->orderBy('date', 'DESC')
                                ->first();

        return json_encode($meeting);
    }

    public function JoinMeeting($meeting_id, $user_id)
    {
        $join = new MeetVisit();
        //$join->
    }
}
