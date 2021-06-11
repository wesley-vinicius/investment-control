<?php

namespace App\Domain\Auth\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Core\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $payload = $this->validator($request->all());
        $this->create($payload);

        return response(null,Response::HTTP_CREATED);
    }

    protected function create(array $data)
    {
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->save();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();
    }
}
