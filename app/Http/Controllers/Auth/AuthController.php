<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Requests\LoginRequest as LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth,User $user)
    {
		$this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

	 public function login(LoginRequest $request)
    {
		$credentials = $request->only('email', 'password');
		$user_credentials= array_add($credentials, 'confirmed', '1');
	    if ($this->auth->attempt($user_credentials)) {
			$admin = 0;
			 $user_roles = User::where('id', $this->auth->id())->select('admin')->get();
			foreach($user_roles as $item)
			{
				if($item->admin==1)
				{
					$admin=1;
				}
			};
			if($admin==1){
				return redirect('/admin/dashboard');
			}
			return redirect('/');
		}
        return redirect('/auth/login')->withErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }

}
