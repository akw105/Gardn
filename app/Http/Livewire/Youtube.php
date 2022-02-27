<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Youtube extends Component
{

    public $handle = "";


    public function render()
    {
        sleep(1);
        $videos = "";

        if ($this->handle !== "") {
            $handle = $this->handle;

            $response = Http::get('https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=' . $handle . '&key=' . env('YOUTUBE_API_KEY'));
            foreach ($response['items'] as $item) {
                $uploads = $item['contentDetails']['relatedPlaylists']['uploads'];
            }
            $response = Http::get('https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails,snippet&playlistId=' . $uploads . '&key=' . env('YOUTUBE_API_KEY'));
            $videos = $response['items'];
        } else {
            $videos = null;
        }

        return view('livewire.youtube', ['videos' => $videos]);
    }
}
