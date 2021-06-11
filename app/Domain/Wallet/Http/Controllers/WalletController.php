<?php
namespace App\Domain\Wallet\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domain\Wallet\Http\Resources\WalletResource;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function listAll(){
        $wallet = Auth::user()->wallet;

        return WalletResource::collection($wallet);
    }

    public function view($id){
        $wallet = Auth::user()->wallet()->find($id);

        if (!$wallet) {
            return response(null, 404);
        }

        return WalletResource::make($wallet);
    }
}