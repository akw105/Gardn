<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\TwitterHandle;
use Illuminate\Support\Str;

class ProcessTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tweet;

    /**
     * Create a new job instance.
     * https://www.digitalocean.com/community/tutorials/how-to-process-tweets-in-real-time-with-laravel
     *
     * @return void
     */
    public function __construct($tweet)
    {
        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     * 
     * Does the user_screen_name match a saved Twitter handle?
     * If yes, save it.
     * If no, ignore it. 
     *
     * @return void
     */
    public function handle()
    {
        $tweet = $this->tweet;

        $tweet_text = isset($tweet['text']) ? $tweet['text'] : null;
        $user_screen_name = isset($tweet['user']['screen_name']) ? $tweet['user']['screen_name'] : null;

        $handle = TwitterHandle::firstWhere('handle', $user_screen_name);

        if ($handle) {
            Post::create([
                'user_id' => $handle->user_id,
                'title' => $user_screen_name . ' tweeted',
                'slug' => Str::slug($user_screen_name . '-' . Now(), '-'),
                'body' => '<p>' . $tweet_text . '</p>',
                'teaser' => $user_screen_name . ' tweeted',
                'published' => '1',
                'public' => '1',
                'source' => 'Twitter'
            ]);
        }
    }
}
