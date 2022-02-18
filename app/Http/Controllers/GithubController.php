<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Jobs\ProcessGithub;


class GithubController extends Controller
{

    public function save(Request $request)
    {
        $handle = $request->handle;
        foreach ($request->all() as $field => $value) {
            if (Str::startsWith($field, 'repo')) {
                $repo = Str::after($field, 'repo_');
                ProcessGithub::dispatch($repo, $handle);
            }
        }
        return response()->json('200');
    }
}
