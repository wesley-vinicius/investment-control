<?php

namespace App\Actions\Transaction;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CreateTransactionAction
{

    public function execute(array $data)
    {
        $user = Auth::user();
        $wallet = $user->wallet()->findOrfail($data['wallet_id']);  
        $product = Product::findOrfail($data['wallet_id']);

        $transaction = TransactionFactory::getTransaction($product->product_type_id);
        return $transaction->execute($data, $wallet);
    }

}

