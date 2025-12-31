<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetVisit;
use Illuminate\Http\Request;

class MeetController extends Controller
{
    public function CreateMeeting(Request $request)
    {
        $response = [];
        $UserTokenId = hash('sha256', $request->input('user_id'));
        $MeetToken = hash('sha256', uniqid());

        $meeting = new Meeting();
        $meeting->meet_token = $MeetToken;
        $meeting->user_token_id = $UserTokenId;
        $meeting->title = $request->input('title');
        $meeting->description = $request->input('description');
        $meeting->date = $request->input('date');
        $meeting->type = $request->input('type');
        $meeting->age_limit = $request->input('age_limit');
        $meeting->location = $request->input('location') || '';
        $meeting->map_link = $request->input('map_link') || '';
        $meeting->image_url = ''; 
        $meeting->save();

        if($meeting->id)
        {
            $ImageController = new ImageController();
            $response[] = $ImageController->uploadImage($request->file('file'), 'meet', $meeting->id);
        }
        return ['success' => true];
    }
    public function ReturnMeetings()
    {
        $meetings = Meeting::withCount(['visits as visit_count'])
                                ->withCount(['views as view_count'])
                                ->with('creator')
                                ->where('status', 1)
                                ->orderBy('date', 'DESC')
                                ->get();

        return response()->json($meetings);
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

        return response()->json($meeting);
    }

    public function JoinMeeting($meeting_token, $user_id)
    {
        $join = new MeetVisit();
        $join->meeting_token = $meeting_token;
        $join->user_id = $user_id;
        $join->save();

        if($join->id)
            return true;

        return false;
    }

    public function LeaveMeeting($meeting_token, $user_id)
    {
        $leave = MeetVisit::where([
                            'meetig_token' => $meeting_token,
                            'user_id' => $user_id])
                            ->delete();
        
        return true;
    }
}
