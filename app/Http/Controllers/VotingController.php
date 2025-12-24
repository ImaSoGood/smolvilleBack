<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VoteParam;
use App\Models\VoteUser;
use App\Models\Voting;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function ReturnVotings()
    {
        $votings = Voting::withCount('userVotes as vote_count')
                            ->where('status', 'active')
                            ->orderBy('created_at', 'DESC')
                            ->get();
        
        return json_encode($votings);
    }

    public function ReturnVoteParams($voting_id)
    {
        $params = VoteParam::where('voting_id', $voting_id)
                                ->get();

        return json_encode($params);
    }

    public function SubmitVote()
    {
        
    }

    public function getVoteCount($voting_id)
    {
        $voteCount = VoteUser::where('voting_id', $voting_id)
                                ->count();
        
        return ['vote_count' => $voteCount];
    }
}
