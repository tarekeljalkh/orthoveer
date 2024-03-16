<?php

namespace App\Events;

use App\Models\Scan;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanCreatedNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $scanId;
    public $date;

    /**
     * Create a new event instance.
     */
    public function __construct(Scan $scan)
    {
        $this->message = '#'. $scan->id .' a new Order has been placed';
        $this->scanId = $scan->id;
        $this->date = date('h:i A | d-F-Y', strtotime($scan->created_at));
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('scan-created'),
        ];
    }
}
