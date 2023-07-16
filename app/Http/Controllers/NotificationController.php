<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use App\Http\Resources\NotificationResource;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
            'action_type'=>'like',
            'is_read'=> null,
             'created_at' => now()
        ];



        event(new Notification($notification));

    }
    public function comment(Movie $movie)
    {

        $user = auth()->user();
        $notification = (object) [
            'to' =>   $movie->user_id,
            'from' =>  $user->id,
            'image'=>$user->image,
            'username' =>$user->username,
            'action_type'=>'comment',
            'is_read'=> null,
            'created_at' => now()
        ];



        event(new Notification($notification));

    }
    public function show(User $user): JsonResource
    {
        $notifications = $user->receivedNotifications()->latest()->get();
        return NotificationResource::collection($notifications);
    }

    public function markread(User $user)
    {
        DB::table('notifications')
            ->where('to', $user->id)
            ->update(['is_read' => true]);
    }

}
