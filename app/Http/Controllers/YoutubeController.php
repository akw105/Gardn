<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Jobs\ProcessYouTube;


class YoutubeController extends Controller
{


    public function save(Request $request)
    {
        foreach ($request->all() as $field => $value) {
            if (Str::startsWith($field, 'video')) {
                $video = Str::after($field, 'video_');
                ProcessYouTube::dispatch($video);
            }
        }
        return response()->json('200');
    }
}
