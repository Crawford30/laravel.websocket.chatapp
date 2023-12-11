<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Http\Request;
use Pusher\Pusher;

class SocketsController extends Controller
{
    //Handle Connection
    public function connect(Request $request){
        $broadCaster = new PusherBroadcaster(
            new Pusher(
                env("PUSHER_APP_KEY"),
                env("PUSHER_APP_SECRET"),
                env("PUSHER_APP_ID"),
                []
            )
            );

//Returns a valid authentication response
            return $broadCaster->validAuthenticationResponse($request, []);
    }
}
