<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use App\Models\Movie;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function like(Movie $movie)
    {


        $user = auth()->user();
        $notification = (object) [
            'to' =>   $movie->user_id,
            'from' =>  $user->id,
            'image'=>$user->image,
            'username' =>$user->username,
            'timestamp' => now()->toDateTimeString()
        ];

        $actionType = 'like';

        event(new Notification($notification, $actionType));

    }
    public function comment(Movie $movie)
    {

        $user = auth()->user();
        $notification = (object) [
            'to' =>   $movie->user_id,
            'from' =>  $user->id,
            'image'=>$user->image,
            'username' =>$user->username,
            'timestamp' => now()->toDateTimeString()
        ];

        $actionType = 'comment';

        event(new Notification($notification, $actionType));

    }
}
