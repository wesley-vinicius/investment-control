<?php

declare(strict_types=1);

namespace App\Domain\Auth\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domain\Auth\Action\LoginAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request, LoginAction $action): \Illuminate\Http\JsonResponse
    {
        $credentials = $this->validator($request->only('email', 'password'));
        $result = $action->execute($credentials);


        return response()->json([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
        ]);
    }

    #[ArrayShape(['message' => "string"])]
    public function logout(): array
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked',
        ];
    }

    public function me(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->user();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validator(array $data): array
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();
    }
}
