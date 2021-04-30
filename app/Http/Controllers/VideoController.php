<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Requests\VideoUpdateRequest;

class VideoController extends Controller
{
    // Using the VideoUpdateRequest instead of basic Request
    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->update([
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),
        ]);
        
        // If it's ajax request, redirect with a 200
        if($request->ajax()) {
            return response()->json(null, 200);
        }

        return redirect()->back();
    }

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

        // Sending the uid in response to put the upload
        return response()->json(
            [
                'uid' => $uid,
            ]
        );
    }
}
