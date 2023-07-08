<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use DB;
use App\Mail\SendEmailVerificationCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class ProfileController extends Controller
{
    /**
     * Menampilkan halaman index di folder profiles dan mengirim data user yang di autentikasi
     *
     */
    public function index()
    {
        $data['profiles'] = Auth::user();
        return view('profiles.index', $data);
    }
    /**
     * Menampilkan halaman edit di folder profiles dan mengirim data user dari parameter
     *
     *
     */
    public function edit(User $profile)
    {
        return view('profiles.edit', compact('profile'));
    }
    /**
     * Menyimpan perubahan/pengubahan data user/profile ke database.
     * Bila user mengubah email maka email tersebut harus diverifikasi kembali
     *
     */
    public function update(Request $request, $id)
    {
        $pp = '';
        $user = User::find(Auth::user()->id);


        if ($request->file('photo_profile')) {
            $validator = Validator::make($request->all(), [
                'photo_profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }
            $file = $request->file('photo_profile');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('images/user/photo_profile/'), $filename);
            $pp = 'images/user/photo_profile/' . $filename;
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'no_phone' => 'required',
            'gender' => 'required|max:1',
            'info' => 'max:30',
            'bio' => 'max:500',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->email, 'email'),
            ],
        
        ]);


        if ($validator->fails()) {
            if ($request->file('photo_profile')) {

                return back()->withErrors($validator->errors())->with([
                    'photo_profile_c' => $pp,
                ]);
            } else if ($request->last_pp) {
                return back()->withErrors($validator->errors())->with([
                    'photo_profile_c' => $request->last_pp,
                ]);
            } else {
                return back()->withErrors($validator->errors());
            }
        }

        $user->name = $request->name;
        $user->no_phone = $request->no_phone;
        $user->gender = $request->gender;
        $user->bio = $request->bio;
        $user->info = $request->info;
        $user->email = $request->email;
        if ($request->file('photo_profile')) {
            $user->photo_profile = $pp;
        } else if ($request->last_pp) {
            $pp = $request->last_pp;
            $user->photo_profile = $pp;
        }

        if ($user->isDirty('email')) {
            $token = Str::random(6);
            $user->email_verified_at = null;
            $user->verification_code = Hash::make($token);
            $user->verification_code_expired_at = Carbon::now()->addMinutes(5);
            $user->save();
            Mail::to($request->email)->send(new SendEmailVerificationCode($token));
            return redirect()->intended('show-verification-code')->with('user', $user);
        }
        if ($user->save()) {
            return redirect()->route('profiles.index')
                ->with('success', 'User Has Been updated successfully');
        }

        return back()->withErrors([
            'ecode' => 'Update gagal',
        ]);

    }
    /**
     * Menghapus data user
     *
     */
    public function destroy(Request $request, User $user)
    {
        Auth::user()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data User Berhasil Dihapus!.',
        ]); 
    }
}
