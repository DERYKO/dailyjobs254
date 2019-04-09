<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\SendMessage;
use App\Notifications\NewAccount;
use App\User;
use App\Http\Controllers\Controller;
use App\Wallet;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use Notifiable;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|regex:/[0-9]{10}/|digits:10|unique:users',
            'id_no' => 'required|integer|min:9|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user=User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'id_no' => $data['id_no'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        Wallet::create([
          'user_id'=>$user->id,
          'balance'=>0
        ]);
        //$this->dispatch(new SendMessage($user,'Hi '.$user->first_name.', Welcome to the best platform to increase your hustle'));
        //$this->notify(new NewAccount($user));
        return $user;
    }
}
