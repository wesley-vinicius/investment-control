<?php

namespace App\Domain\Auth\Providers;

use App\Domain\Auth\Models\User;
use App\Domain\Auth\Observers\UserObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProviderAuth extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
      
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
