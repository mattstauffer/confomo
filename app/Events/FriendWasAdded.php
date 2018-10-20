<?php

namespace App\Events;

use App\Friend;
use Illuminate\Queue\SerializesModels;

class FriendWasAdded extends Event
{
    use SerializesModels;

    /**
     * @var \App\Friend
     */
    public $friend;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Friend $friend)
    {
        $this->friend = $friend;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
