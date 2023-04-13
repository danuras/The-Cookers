<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon; 
use DB;
use App\Mail\SendEmailVerificationCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    /**
     * Display a profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['profiles'] = Auth::user();
        return view('profiles.index', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $profile)
    {
        return view('profiles.edit', compact('profile'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'gender' => 'required|max:1',
            'info' => 'max:30',
            'bio'=>'max:500',
        ]);
        if($user->username != $request->username){
            $request->validate([
                'username' => 'required|unique:users',
            ]);
            $user->username = $request->username;
        }
        
        if($user->email != $request->email){

            $request->validate([            
                'email' => 'required|email|unique:users',
            ]);
            $token = Str::random(6);
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->verification_code = Hash::make($token);
            $user->verification_code_expired_at = Carbon::now()->addMinutes(5);
            $user->name = $request->name;
            $user->no_phone = $request->no_phone;
            $user->gender = $request->gender;
            $user->bio = $request->bio;
            $user->info = $request->info;
            if($request->file('photo_profile')){
                $request->validate([
                    'photo_profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
                ]);
                $user->photo_profile = file_get_contents($request->file('photo_profile'));
            }
            $user->save();
            Mail::to($request->email)->send(new SendEmailVerificationCode($token));
            return redirect()->intended('show-verification-code')->with('user', $user);
        }
        
        $user->name = $request->name;
        $user->no_phone = $request->no_phone;
        $user->gender = $request->gender;
        $user->bio = $request->bio;
        $user->info = $request->info;
        if($request->file('photo_profile')){
            $user->photo_profile = file_get_contents($request->file('photo_profile'));
        }
        $user->save();

        return redirect()->route('profiles.index')
        ->with('success', 'User Has Been updated successfully'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('profiles.index')
            ->with('success', 'User has been deleted successfully');
    }
}
