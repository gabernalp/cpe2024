<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function username(){

        return 'document';

    }
	
	public function showLoginForm()
{
    if(!session()->has('url.intended'))
    {
        if(url()->previous() != env("APP_URL")){
			
			session(['url.intended' => url()->previous()]);

		}
		else {
			
			session(['url.intended' => env("APP_URL").'/mi-perfil']);
		}
    }

	return view('auth.login');    

}
    
	
}
