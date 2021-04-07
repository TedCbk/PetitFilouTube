<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Storage;
use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $fileId;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId; 
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get the current image path and assign it a name and an extension, resize it, upload to s3 and delete the temporary file
        $path = storage_path() . '/uploads/' . $this->fileId;
        $fileName = $this->fileId . '.png';

        // Using storage facade to send it to the S3 server
        Storage::disk('s3images')->put('profile/' . $fileName, fopen($path, 'r+'));

    }
}
