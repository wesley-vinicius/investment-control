<?php

namespace App\Actions\Transaction;

class TransactionFactory
{

    public static function getTransaction($typeProduct)
    {
        return match($typeProduct) {
            1 => new CreateTransactionAcao
        };
    }
}
