<?php

declare(strict_types=1);

namespace App\Domain\WalletProduct\Providers;

use App\Domain\WalletProduct\Models\Movement;
use App\Domain\WalletProduct\Observers\MovementObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProviderWalletProduct extends ServiceProvider
{
    
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Movement::observe(MovementObserver::class);
    }
}
