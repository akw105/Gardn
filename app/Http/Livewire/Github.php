<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Github extends Component
{

    public $handle = "";

    public function render()
    {
        sleep(1);

        $response = Http::withHeaders([
            'method' => 'token',
            'token' => env('GITHUB_TOKEN'),
        ])->get('https://api.github.com/users/' . $this->handle . '/repos');

        $repos = json_decode($response->body());
        if (!is_array($repos)) {
            $repos = null;
        }
        return view('livewire.github', ['repos' => $repos]);
    }
}
