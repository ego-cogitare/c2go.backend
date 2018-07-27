<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Event;
use \App\Listeners\ {
    EventAccept, EventReject
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
        Event::listen('event.reject', EventReject::class);
    }
}
