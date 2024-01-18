<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\Profile;
use App\Models\DocumentType;

class RegisterController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255','unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
			'phone'    => ['required', 'string', 'max:255','unique:users'],
			'document'    => ['required', 'string', 'max:255', 'unique:users'],
        ]);
    }
    
	public function showregistrationform()
	{
		$documenttypes = DocumentType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $profiles = Profile::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        return view('auth.register', compact('documenttypes', 'departments'));
	}
    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([

            'name'     => mb_strtoupper($data['name']),
            'documenttype_id'     => $data['documenttype_id'],
            'document'     => $data['document'],
            'email'    => mb_strtolower($data['email']),
            'phone'     => $data['phone'],
            'place_role'     => $data['place_role'],
            'department_id'     => $data['department_id'],
            'city_id'     => $data['city_id'],
            'profile_id'     => $data['profile_id'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
