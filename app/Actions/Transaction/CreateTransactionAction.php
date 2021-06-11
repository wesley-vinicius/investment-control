<?php

namespace App\Actions\Transaction;

use App\Enum\TransactionType;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletProduct;
use DomainException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateTransactionAction
{

    public function execute(array $data)
    {
        $user = Auth::user();
        $wallet = Wallet::find($data['wallet_id']);

        if ($wallet->user_id != $user->id) {
            throw new DomainException("User doesn't have access to wallet");
        }

        DB::transaction(function () use ($data){
            $walletProduct = $this->getWalletProduct($data);
            $amount = $this->calculateAmount($data['price'], $data['quantity']);

            $transaction = new Transaction([
                'wallet_product_id' => $walletProduct->id,
                'price' => $data['price'],
                'type' => $data['type'],
                'quantity' => $data['quantity'],
                'amount' => $amount,
                'date' => $data['date'],
                'rates' => $data['rates'] ?? 0
            ]);
            $transaction->save();
        });
    }

    private function calculateAmount(float $price, int $quantity) : float
    {
        return floatval($price * $quantity);
    }

    private function getWalletProduct(array $data): WalletProduct
    {
        $walletProduct = WalletProduct::where('product_id', $data['product_id'])->first();

        if(!$walletProduct && $data['type'] == TransactionType::RESCUE)
            throw new DomainException('The product was not found in the wallet :(');

        if (!$walletProduct && $data['type'] == TransactionType::CONTRIBUTION) {
            $walletProduct = new WalletProduct([
                'wallet_id' => $data['wallet_id'],
                'product_id' => $data['product_id'],
            ]);
            $walletProduct->save();
        }

        return $walletProduct;
    }
}

