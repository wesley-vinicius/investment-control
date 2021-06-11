<?php

namespace App\Http\Controllers\Transaction;

use App\Actions\Transaction\CreateTransactionAction;
use App\Http\Controllers\Controller;
use App\Rules\QuantityIsAvailable;
use App\Rules\WalletBelongsUser;
use App\Rules\WalletProductExists;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function create(Request $request, CreateTransactionAction $createProductAction)
    {
        $payload = $this->validatorCreate($request->all());
        try {
            $createProductAction->execute($payload);

            return response([
                'message' => 'Transaction performed successfully :)'
            ],Response::HTTP_CREATED);

        } catch (\Exception $e) {
            Log::error($e);
            return response([
                'message' => $e->getMessage()
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function validatorCreate(array $data){
        return Validator::make($data, [
            "wallet_id"=> ['bail','required', 'integer', 'exists:wallets,id', new WalletBelongsUser()],
            "product_id"=> ['bail', 'required', 'integer', 'exists:products,id', new WalletProductExists()],
            "price" => ['bail', 'required', 'gt:0', 'numeric'],
            "quantity" => ['bail', 'required', 'min:1', 'integer', new QuantityIsAvailable()],
            "date" => ['bail', 'required', 'string', 'date'],
            "rates" => ['nullable', 'numeric'],
            "type" => ['bail', 'required', 'integer', Rule::in(['1', '2'])],
        ])->validate();
    }
}
