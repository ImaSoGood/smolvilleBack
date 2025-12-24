<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage($file, $event_type, $event_id)
    {
        //$file = $request->file('file');
        //$event_type = $request->input('event_type');
        //$event_id = $request->input('event_id');

        $imageService = new ImageService();
        $result = $imageService->processImage($file, $event_type, $event_id);

        return $result;
    }
}
