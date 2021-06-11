<?php

namespace App\Domain\Auth\Observers;

use App\Domain\Auth\Models\User;
use App\Domain\Wallet\Models\Wallet;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Domain\Auth\Models\User  $user
     * @return void
     */
    
    public function created(User $user)
    {
        Wallet::create([
            'user_id' => $user->id,
            'name' => 'Default'
        ]);
    }
}