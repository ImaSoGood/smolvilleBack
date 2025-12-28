<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage($file, $event_type, $event_id)
    {
        $imageService = new ImageService();
        $result = $imageService->processImage($file, $event_type, $event_id);

        return $result;
    }
}
