<?php

use App\Events\SendMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use BeyondCode\LaravelWebSockets\Apps\AppProvider;
use BeyondCode\LaravelWebSockets\Dashboard\DashboardLogger;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('chat-app');
});


Route::get('/', function (AppProvider $appProvider) {
    return view('chat-app', [
        "port" => "6001",
        "host" => "127.0.0.1",
        "authEndpoint" => "/api/sockets/connect",
        "logChannel" => DashboardLogger::LOG_CHANNEL_PREFIX,
        "apps" => $appProvider->all()
    ]);
});


Route::post("/chat/send", function(Request $request) {
    $message = $request->input("message", null);
    $name = $request->input("name", "Anonymous");
    $time = (new DateTime(now()))->format(DateTime::ATOM);
    if ($name == null) {
        $name = "Anonymous";
    }
    //Calling the event, its going to be handled by the queue, hence the queue should be ruunning
    SendMessage::dispatch($name, $message, $time);
});
