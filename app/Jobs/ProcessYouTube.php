<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Auth;


class ProcessYouTube implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     * 
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     * 
     *
     * @return void
     */
    public function handle()
    {
        $video = $this->video;

        $response = Http::get('https://www.googleapis.com/youtube/v3/videos?part=snippet&id=' . $video . '&key=' . env('YOUTUBE_API_KEY'));

        if ($response['items']['0']) {
            Post::create([
                'user_id' => Auth::user()->id,
                'title' => isset($response['items']['0']['snippet']['title']) ? $response['items']['0']['snippet']['title'] : 'YouTube Video',
                'slug' => Str::slug($response['items']['0']['snippet']['title'] . '-' . Now(), '-'),
                'body' => isset($response['items']['0']['snippet']['description']) ? $response['items']['0']['snippet']['description'] : null,
                'teaser' => Str::of(isset($response['items']['0']['snippet']['description']))->limit(50) ? $response['items']['0']['snippet']['description'] : null,
                'published' => '1',
                'public' => '1',
                'source' => 'YouTube',
                'external_url' => isset($response['items']['0']['id']) ? 'https://youtube.com/watch?v=' . $response['items']['0']['id'] : null,
            ]);
        }
    }
}
