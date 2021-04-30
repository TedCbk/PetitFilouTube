<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    // Only the user that belongs to that video can update it
    public function update(User $user, Video $video)
    {
        return $user->id === $video->channel->user_id;
    }
}
