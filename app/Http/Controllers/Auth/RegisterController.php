<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Auth;

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
    protected $redirectTo = '/home';
    private $name;
    private $email;
    private $password;

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(Request $r)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

            $newUser = User::create([
                'name' => $r->name,
                'email' => $r->email,
                'password' => Hash::make($r->password),
                'dinner' => session()->get('dinner'),
                'sleephours' => session()->get('sleephours'),
                'morningTime' => session()->get('morningTime'),
                'eveningTime' => session()->get('eveningTime'),
                'workingHours' => session()->get('workingHours'),
                'breakfast' => session()->get('breakfast'),
                'workingBegin' => session()->get('workingBegin'),
                'dinnertime' => session()->get('dinnertime'),
                'drive' => session()->get('drive'),
            ]);

            Auth::login($newUser);
            return Redirect::to('/home');

    }

    public function step1(Request $r)
    {
        $dinner = ($r->dinner_h * 60 ) + $r->dinner_min;
        $sleephours = ($r->sleepHours_h * 60 ) + $r->sleepHours_min;
        $morningTime= ($r->morningTime_h * 60 ) + $r->morningTime_min;
        $eveningTime= ($r->eveningTime_h * 60 ) + $r->eveningTime_min;
        $workingHours = ($r->workingHours_h * 60 ) + $r->workingHours_min;
        $breakfast = ($r->breakfast_h * 60 ) + $r->breakfast_min;
        $drive = ($r->drive_h * 60 ) + $r->drive_min;
        $workingBegin = $r->workingBegin_h . ':' . $r->workingBegin_min . ':00';
        $dinnertime =  $r->dinner_time_h . ':' . $r->dinner_time_min . ':00';

        session()->put('dinner', $dinner);
        session()->put('sleephours',$sleephours);
        session()->put('morningTime',$morningTime);
        session()->put('eveningTime',$eveningTime);
        session()->put('workingHours',$workingHours);
        session()->put('breakfast',$breakfast);
        session()->put('drive',$drive);
        session()->put('workingBegin',$workingBegin);
        session()->put('dinnertime',$dinnertime);

        return redirect('register');
    }
}
