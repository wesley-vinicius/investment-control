<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Wallet;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
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