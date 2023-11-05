<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $connection = 'sync';
    public $queue = 'messages';

    private User $user;
    public string $message;
    public string $messageType;

    public function __construct(User $user, string $message, string $messageType = 'info')
    {
        $this->user = $user;
        $this->message = $message;
        $this->messageType = $messageType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel("user-message." . $this->user->id),
        ];
    }
}
