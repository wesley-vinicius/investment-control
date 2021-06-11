<?php

namespace App\Observers;

use App\Enum\TransactionType;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $walletProduct = $transaction->walletProduct;

        if ($transaction->type == TransactionType::CONTRIBUTION) {
            $walletProduct->contribution($transaction->quantity, $transaction->amount);
        }else {
            $walletProduct->rescue($transaction->quantity, $transaction->amount);
        }

        $walletProduct->save();
    }
}
