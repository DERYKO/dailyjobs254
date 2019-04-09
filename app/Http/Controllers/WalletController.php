<?php

namespace App\Http\Controllers;

use App\Transcation;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function balance(){
        $wallet=Wallet::where('user_id',Auth::id())->first();
        $transcations=Transcation::where('from_id',Auth::id())->where('to_id',Auth::id())->orderBy('created_at')->get();
        return response()->json(['balance'=>$wallet,'transcations'=>$transcations]);
    }
}
