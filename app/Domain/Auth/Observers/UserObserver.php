<?php

declare(strict_types=1);

namespace App\Domain\Auth\Observers;

use App\Domain\Auth\Models\User;
use App\Domain\Wallet\Models\Wallet;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */

    public function created(User $user): void
    {
        Wallet::create([
            'user_id' => $user->id,
            'name' => 'Default',
        ]);
    }
}
