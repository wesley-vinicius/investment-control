<?php

namespace App\Domain\WalletProduct\Rules;

use App\Domain\Wallet\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class WalletBelongsUser implements Rule
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
        $user_id = auth()->id();
        $wallet = Wallet::find($value);

        return $wallet->user_id == $user_id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "User doesn't have access to wallet";
    }
}
