<?php

declare(strict_types=1);

namespace App\Domain\WalletProduct\Http\Controllers\Stock;

use App\Core\Http\Controllers\Controller;
use App\Domain\WalletProduct\Actions\Stock\InsertStockAction;
use App\Domain\WalletProduct\DataTransfer\Stock\InsertStockDataTransfer;
use Symfony\Component\HttpFoundation\Request;

class InsertStockController extends Controller
{
    public function execute(Request $request, InsertStockAction $insertStockAction): void
    {
        $stockDataTranfer = InsertStockDataTransfer::fromRequest($request->all());
        $insertStockAction->execute($stockDataTranfer);
    }
}
