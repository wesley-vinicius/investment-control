<?php

namespace App\Rules;

use App\Enum\TransactionType;
use App\Models\WalletProduct;
use Illuminate\Contracts\Validation\Rule;

class QuantityIsAvailable implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $wallet_id = request()->wallet_id;
        $product_id = request()->product_id;
        $type = request()->type;

        $walletProductExists =  WalletProduct::where('product_id', $product_id)
            ->where('wallet_id', $wallet_id)
            ->where('quantity', '>=', $value)
            ->exists();

        if(!$walletProductExists && $type == TransactionType::RESCUE) return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Amount not available for rescue.';
    }
}
