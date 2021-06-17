<?php

namespace App\Domain\WalletProduct\Providers;

use App\Domain\WalletProduct\Models\Movement;
use App\Domain\WalletProduct\Observers\MovementObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProviderWalletProduct extends ServiceProvider
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
        Movement::observe(MovementObserver::class);
    }
}
