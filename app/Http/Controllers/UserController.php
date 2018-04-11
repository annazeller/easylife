<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->gcalendar_credentials = $request->get('gcalendar_credentials');
        $user->gcalendar_integration_active = $request->get('gcalendar_integration_active');
        $user->save();

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $user)
    {   
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function updateProfile(User $user)
    { 
        if(Auth::user()->email == request('email')) {
        
        $this->validate(request(), [
                'name' => 'required',
              //  'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);

            $user->name = request('name');
           // $user->email = request('email');
            $user->password = bcrypt(request('password'));

            $user->save();

            return back()->with('message', [
                'type' => 'success', 'text' => 'Password updated!'
            ]);;
            
        }
        else{
            
        $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed'
            ]);

            $user->name = request('name');
            $user->email = request('email');
            $user->password = bcrypt(request('password'));

            $user->save();

            return back()->with('message', [
                'type' => 'success', 'text' => 'Email und Passwort!'
            ]);;  
            
        }
    }
    public function profile(){
        return view('users.profile', array('user' => Auth::user()) );
    }
 
    public function update_avatar(Request $request){
 
        // Logic for user upload of avatar
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300, 300)->save( public_path('/data/profile/' . $filename ) );
 
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
 
        return view('profile', array('user' => Auth::user()) );
 
    }




}
