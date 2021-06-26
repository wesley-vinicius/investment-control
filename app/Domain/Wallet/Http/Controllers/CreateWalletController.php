<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domain\Auth\Models\User;
use App\Domain\Wallet\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateWalletController extends Controller
{
    public function execute(Request $request)
    {
        $user = Auth::user();
        $payload = $this->validator($request->all());
        $this->create($user, $payload);

        return response(null, Response::HTTP_CREATED);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ])->validate();
    }

    protected function create(User $user, array $data): void
    {
        $wallet = new Wallet([
            'user_id' => $user->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);
        $wallet->save();
    }
}
