<?php

declare(strict_types=1);

namespace App\Domain\WalletProduct\Http\Controllers\Stock;

use App\Core\Http\Controllers\Controller;
use App\Domain\WalletProduct\Actions\Stock\InsertStockAction;
use App\Domain\WalletProduct\DataTransfer\Stock\InsertStockDataTransfer;
use Illuminate\Http\Request;

class InsertStockController extends Controller
{
    public function execute(Request $request, InsertStockAction $insertStockAction): void
    {
        $stockDataTransfer = InsertStockDataTransfer::fromRequest($request->all());
        $insertStockAction->execute($stockDataTransfer);
    }
}
