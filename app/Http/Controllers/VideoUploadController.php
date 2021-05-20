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
        $channel = $request->user()->channel()->first();

        // Lookup the video
        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

        // Move to temp location
        $request->file('video')->move(storage_path() . '/uploads', $video->video_filename);
        // Upload the video on S3 Storage
    }
}
