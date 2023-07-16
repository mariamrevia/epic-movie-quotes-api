<?php

namespace App\Events;

use App\Models\Notification as ModelsNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notification implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */

    public $notification;
    public function __construct($notification)
    {
        $this->notification = $notification;
        $this->saveNotification();
    }
    public function saveNotification()
    {
        ModelsNotification::create([
            'to' => $this->notification->to,
            'from' => $this->notification->from,
            'image' => $this->notification->image,
            'username' => $this->notification->username,
            'action_type' => $this->notification->action_type,
            'created_at' => $this->notification->created_at,
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('likes.' . $this->notification->to),
        ];
    }
}
