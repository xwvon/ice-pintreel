<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MediaUploadComplete implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $user_id;
    public array $body;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $data)
    {
        $this->user_id = $user_id;
        $this->body = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $username = User::where('_id', $this->user_id)->first()->username;
        return new PrivateChannel($username . '-media-completed');
    }

    /**
     * By default, Laravel will broadcast the event using the event's class name.
     * However, you may customize the broadcast name by defining a broadcastAs method on the event:
     */
    public function broadcastAs(): string
    {
        return 'ice:upload-completed';
    }
}
