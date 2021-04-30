<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoUploadController extends Controller
{
    public function index()
    {
        return view('video.upload');
    }
    
    public function store(Request $request)
    {
        // Grab the user channel

        // Lookup the video

        // Move to temp location

        // Upload the video on S3 Storage
    }
}
