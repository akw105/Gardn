<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\YoutubeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/github', function () {
    return view('fetchData');
});
Route::post('/save-repos', [GithubController::class, 'save']);

Route::get('/youtube', function () {
    return view('fetchData');
});
Route::post('/save-videos', [YouTubeController::class, 'save']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
