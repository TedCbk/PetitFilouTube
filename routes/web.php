<?php

use App\Http\Controllers\ChannelSettingsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VideoUploadController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/channel/{channel}/edit', [ ChannelSettingsController::class, 'edit']);
    Route::put('/channel/{channel}/edit', [ ChannelSettingsController::class, 'update']);
    
    Route::get('/upload', [ VideoUploadController::class, 'index']);

    Route::post('/videos', [VideoController::class, 'store']);
});
