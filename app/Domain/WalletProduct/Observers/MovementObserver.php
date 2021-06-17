<?php

namespace App\Domain\WalletProduct\Observers;

use App\Domain\WalletProduct\Enum\MovementType;
use App\Domain\WalletProduct\Models\Movement;

class MovementObserver
{
    /**
     * Handle the Movement "created" event.
     *
     * @param \App\Domain\WalletProduct\Models\Movement  $movement
     * @return void
     */
    public function created(Movement $movement)
    {
        $walletProduct = $movement->walletProduct;

        if ($movement->type == MovementType::CONTRIBUTION) {
            $walletProduct->contribution($movement->quantity, $movement->amount);
        }else {
            $walletProduct->rescue($movement->quantity, $movement->amount);
        }

        $walletProduct->save();
    }

}
