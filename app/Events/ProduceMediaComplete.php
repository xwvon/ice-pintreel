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
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProduceMediaComplete implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels, InteractsWithQueue;
    
    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 3;

    public array $body;
    private string $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($body, $user_id)
    {
        $this->body = $body;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Log::info($this->user_id);
        $username = User::where('_id', $this->user_id)->first()->username;
        return new PrivateChannel($username . '-media-completed');
    }

    /**
     * By default, Laravel will broadcast the event using the event's class name.
     * However, you may customize the broadcast name by defining a broadcastAs method on the event:
     */
    public function broadcastAs(): string
    {
        return 'ice:media-completed';
    }
}
