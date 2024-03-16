<?php

namespace App\Listeners;

use App\Events\ScanCreatedNotificationEvent;
use App\Models\ScanCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ScanCreatedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ScanCreatedNotificationEvent $event): void
    {
        $notification = new ScanCreatedNotification();
        $notification->message = $event->message;
        $notification->scan_id = $event->scanId;
        $notification->save();
    }
}
