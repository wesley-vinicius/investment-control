<?php

declare(strict_types=1);

namespace App\Domain\WalletProduct\Rules;

use App\Domain\Wallet\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class WalletBelongsUser implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        $user_id = auth()->id();
        $wallet = Wallet::find($value);

        return $wallet->user_id === $user_id;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return "User doesn't have access to wallet";
    }
}
