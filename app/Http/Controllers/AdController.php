<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    public function ReturnAds()
    {
        $ads = Ad::all();

        return response()->json($ads);
    }
}
