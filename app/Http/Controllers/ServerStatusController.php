<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServerStatus;
use Illuminate\Http\Request;

class ServerStatusController extends Controller
{
    public function ServerStatus()
    {
        $status = ServerStatus::orderBy('id', 'DESC')->first();
        return response()->json($status);
    }
}
