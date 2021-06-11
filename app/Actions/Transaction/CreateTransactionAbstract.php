<?php

namespace App\Actions\Transaction;

use App\Enum\TransactionType;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletProduct;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;

abstract class CreateTransactionAbstract
{

    public function execute(array $data, Wallet $wallet)
    {
        $walletProduct = $this->getWalletProduct($wallet,$data);
        $this->createTransaction($data, $walletProduct);
    }

    public function createTransaction($data, $walletProduct)
    {
        DB::transaction(function () use ($data, $walletProduct) {
            $data = $this->returnDataCreate($data, $walletProduct->id);

            $transaction = new Transaction($data);
            $transaction->save();
        });
    }

    protected abstract function returnDataCreate(array $data, int $walletProduct_id): array;

    protected abstract function calculateAmount(float $price, int $quantity): float;

    protected abstract function getWalletProduct(Wallet $wallet, array $data): WalletProduct;

}
