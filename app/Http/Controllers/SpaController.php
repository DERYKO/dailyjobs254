<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SpaController extends Controller
{
    //
    public function index()
    {
        return view('layouts.app');
    }
    public function user(){
        return response()->json(Auth::check());
    }
}
