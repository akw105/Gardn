<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\GithubHandle;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Auth;


class ProcessGithub implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repo, $handle;

    /**
     * Create a new job instance.
     * 
     *
     * @return void
     */
    public function __construct($repo, $handle)
    {
        $this->repo = $repo;
        $this->handle = $handle;
    }

    /**
     * Execute the job.
     * 
     *
     * @return void
     */
    public function handle()
    {
        $repo = $this->repo;
        $handle = $this->handle;

        $response = Http::withHeaders([
            'method' => 'token',
            'token' => env('GITHUB_TOKEN')
        ])->get('https://api.github.com/repos/' . $handle . '/' . $repo);

        if ($response) {
            Post::create([
                'user_id' => Auth::user()->id,
                'title' => isset($response['name']) ? $response['name'] : 'Github Project',
                'slug' => Str::slug($response['name'] . '-' . Now(), '-'),
                'body' => isset($response['description']) ? $response['description'] : null,
                'teaser' => Str::of(isset($response['description']))->limit(50) ? $response['description'] : null,
                'published' => '1',
                'public' => '1',
                'source' => 'Github',
                'external_url' => isset($response['svn_url']) ? $response['svn_url'] : null,
            ]);
        }
    }
}
