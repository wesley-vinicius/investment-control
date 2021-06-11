<?php

namespace App\Actions\Transaction;

use App\Enum\TransactionType;
use App\Models\Wallet;
use App\Models\WalletProduct;

class CreateTransactionAcao extends CreateTransactionAbstract
{

    protected function returnDataCreate(array $data, int $walletProduct_id): array
    {
        $amount = $this->calculateAmount($data['price'], $data['quantity']);
        return [
            'wallet_product_id' => $walletProduct_id,
            'price' => $data['price'],
            'type' => $data['type'],
            'quantity' => $data['quantity'],
            'amount' => $amount,
            'date' => $data['date'],
            'rates' => $data['rates'] ?? 0
        ];
    }

    protected function calculateAmount(float $price, int $quantity): float
    {
        return floatval($price * $quantity);
    }

    protected function getWalletProduct(Wallet $wallet, array $data): WalletProduct
    {
        //$walletProduct = $wallet->getWalletProductByProductId($data['product_id']);
        $walletProduct = $wallet->walletProduct()
        ->where('product_id', $data['product_id'])
        ->first();

        if (!$walletProduct && $data['type'] == TransactionType::RESCUE)
            throw new \DomainException('The product was not found in the wallet :(');

        if (!$walletProduct) {
            $walletProduct = new WalletProduct([
                'wallet_id' => $data['wallet_id'],
                'product_id' => $data['product_id'],
            ]);
            $walletProduct->save();
        }

        return $walletProduct;
    }
}
