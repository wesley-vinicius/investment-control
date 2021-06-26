<?php

declare(strict_types=1);

namespace App\Domain\Auth\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $this->validator($request->only('email', 'password'));

        if (! Auth::attempt($credentials)) {
            return response()->json(
                ['message' => 'Credentials not match'],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return response()->json([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked',
        ];
    }

    public function me()
    {
        return auth()->user();
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ])->validate();
    }
}
