<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Milly\Laragram\FSM\FSM;
use Milly\Laragram\Laragram;
use App\Models\BotUser;
use App\Http\Controllers\BotUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bot', function () {
    return Laragram::sendMessage(
        chat_id: 1585277374,
        text: 'Saytdan '
    );
});

Route::post('/bot', function(){
    FSM::route('/', [BotUserController::class, 'start_private']);
});
