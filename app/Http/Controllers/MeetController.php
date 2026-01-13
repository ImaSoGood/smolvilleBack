<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\MeetView;
use App\Models\MeetVisit;
use Illuminate\Http\Request;

class MeetController extends Controller
{
    public function CreateMeeting(Request $request)
    {
        $UserTokenId = hash('sha256', $request->input('user_id'));
        if($this->checkMeetingsLimit($UserTokenId))
            return ['success' => false,
                    'message' => 'Возможно создать встречу только раз в 12 часов :)'];
        $MeetToken = hash('sha256', uniqid());

        $validated = $request->validate([
            'title' => 'required|string|max:256',
            'description' => 'required|string|max:1024',
            'date' => 'required|date|after:now',
            'type' => 'required|string|max:64',
            'age_limit' => 'required|integer|min:0|max:100',
            'location' => 'nullable|string|max:256',
            'map_link' => 'nullable|string|max:512|url',
        ]);

        $meeting = new Meeting();
        $meeting->meet_token = $MeetToken;
        $meeting->user_token_id = $UserTokenId;
        $meeting->title = $validated['title'];
        $meeting->description = $validated['description'];
        $meeting->date = $validated['date'];
        $meeting->type = $validated['type'];
        $meeting->age_limit = $validated['age_limit'];
        $meeting->location = $validated['location'] ?? 'Локация не указана';
        $meeting->map_link = $validated['map_link'] ?? 'Без ссылки';
        $meeting->image_url = '';
        $meeting->save();

        if($meeting->id)
        {
            $ImageController = new ImageController();
            $ImageController->uploadImage($request->file('file'), 'meet', $meeting->id);
        }

        return ['success' => true];
    }

    public function ReturnMeetings()
    {
        $meetings = Meeting::withCount(['visits as attendees_count'])
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

    public function AttendMeeting(Request $request)
    {
        $meeting_token = $request->input('meet_token');
        $user_id = $request->input('user_id');
        $ActualMeeting = Meeting::where('meet_token', $meeting_token)->first();

        $exists = MeetVisit::where([
                                'meeting_token' => $meeting_token,
                                'user_id' => $user_id])
                                ->exists();
        if($exists)
            return ['success' => false, 'message' => 'Уже записаны на встречу'];

        $join = new MeetVisit();
        $join->meeting_token = $meeting_token;
        $join->meeting_id = $ActualMeeting->id;
        $join->user_id = $user_id;
        $join->save();

        if($join->id)
            return ['success' => true];

        return ['success' => false];
    }

    public function UnattendMeeting(Request $request)
    {
        $meeting_token = $request->input('meeting_id');
        $user_id = $request->input('user_id');

        $leave = MeetVisit::where([
                            'meetig_token' => $meeting_token,
                            'user_id' => $user_id])
                            ->delete();
        
        return ['success' => true];
    }   

    public function CheckMeetingAttendance(Request $request)
    {
        $meetToken = $request->input('meet_token');
        $userId = $request->input('user_id');

        $existance = MeetVisit::where([
                        'meet_token' => $meetToken,
                        'user_id' => $userId])
                        ->exists();
        return $existance;
    }

    public function AddMeetView(Request $request)
    {
        $meetToken = $request->input('meet_token');
        $userId = $request->input('user_id');

        $ActualMeet = Meeting::where('meet_token', $meetToken)->first();

        $MeetView = new MeetView();
        $MeetView->meet_id = $ActualMeet->id;
        $MeetView->user_id = $userId;
        $MeetView->watch_time = now();
        $MeetView->save();
    }

    private function checkMeetingsLimit($UserTokenId)
    {
        $limitCount = env('CREATION_LIMIT_MEETING_H', 12);

        $userMeeting = Meeting::where('user_token_id', $UserTokenId)
                            ->where('created_at', '>=', now()->subHours($limitCount))
                            ->exists();
        return $userMeeting;
    }
}
