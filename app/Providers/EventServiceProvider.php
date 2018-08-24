<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Event;
use \App\Listeners\ {
    EventAccept,
    EventReject,
    Notifications\EventAccept as EventAcceptNotification,
    Notifications\EventReject as EventRejectNotification,
    VoteLived
};

/**
 * Class EventServiceProvider
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     * @return void
     */
    public function register()
    {
        Event::listen('event.accept', EventAccept::class);
        Event::listen('event.accept.notification', EventAcceptNotification::class);
        Event::listen('event.reject', EventReject::class);
        Event::listen('event.reject.notification', EventRejectNotification::class);
        Event::listen('vote.lived', VoteLived::class);
    }
}
