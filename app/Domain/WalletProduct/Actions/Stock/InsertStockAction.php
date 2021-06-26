<?php

declare(strict_types=1);

namespace App\Domain\WalletProduct\Actions\Stock;

use App\Domain\WalletProduct\DataTransfer\Stock\InsertStockDataTransfer;
use App\Domain\WalletProduct\Models\Movement;
use App\Domain\WalletProduct\Models\WalletProduct;

class InsertStockAction
{
    public function execute(InsertStockDataTransfer $data): void
    {
        $walletProduct = $this->getWalletProduct($data);

        $dataCreate = $data->fromCreateMoviment();
        $dataCreate['wallet_product_id'] = $walletProduct->id;

        $movement = new Movement($dataCreate);
        $movement->save();
    }

    private function getWalletProduct($data): WalletProduct
    {
        $walletProduct = WalletProduct::where('product_id', $data->product_id)->first();

        if (! $walletProduct) {
            $walletProduct = new WalletProduct($data->fromCreateProduct());
            $walletProduct->save();
        }

        return $walletProduct;
    }
}
