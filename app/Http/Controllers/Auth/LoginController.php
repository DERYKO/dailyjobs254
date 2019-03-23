<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->user = new User();
    }

    //login
    public function login(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'phone' => 'required|regex:/[0-9]{10}/|digits:10',
        ]);
        // Get user record
        $user = User::where('phone', $request->get('phone'))->first();
        if ($user) {
            if ($request->get('phone') != $user->phone) {
                return response()->json(['message' => 'Unregistered Mobile Number!!!!'], 401);
            } elseif (Hash::check($request->get('password'), $user->password) == false) {
                return response()->json(['message' => 'invalid password'], 401);
            } else {
                Auth::login($user);
                return $user;
            }
        } else {
            return response()->json(['message' => 'User does not exists!!!'], 401);
        }

        // Check Condition Mobile No. Found or Not


    }
}
