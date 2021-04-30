<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        // Generate a uid
        $uid = uniqid(true);

        // Grab the user channel
        $channel = $request->user()->channel()->first();

        // Create a video
        $video = $channel->videos()->create([
            'uid' => $uid,
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'video_filename' => "{$uid}.{$request->extension}",
        ]);

        return response()->json([
            'data' => [
                'uid' => $uid,
            ]
        ]);
    }
}
