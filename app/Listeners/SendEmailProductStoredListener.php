<?php

namespace App\Listeners;

use App\Events\ProductStoredEvent;
use App\Notifications\SendEmailProductStoredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailProductStoredListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProductStoredEvent $event)
    {
        $event->user->notify(new SendEmailProductStoredNotification(
            $event->user,
            $event->product,
        ));
    }
}
