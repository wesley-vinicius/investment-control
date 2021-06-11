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
}