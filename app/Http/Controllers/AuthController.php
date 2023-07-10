<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use DB;
use App\Mail\SendEmailVerificationCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\ImageManagerStatic as Image;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman dafar/register
     *
     *
     */
    public function showRegistrationView()
    {
        return view('auth.register');
    }
    /**
     * Menyimpan data user yang mendaftar dan mengirim email verifikasi pada email user yang didaftarkan
     *
     *
     */
    public function register(Request $request): RedirectResponse
    {
        $pp = '';

        Session::flashInput($request->input());

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
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',

            ],
            'password_confirmation' => [
                'required',
            ],
            'gender' => 'required|max:1',
            'info' => 'max:30',
            'bio' => 'max:500',
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
        $user = new User;
        $token = Str::random(6);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->no_phone = $request->no_phone;
        $user->gender = $request->gender;
        $user->bio = $request->bio;
        $user->info = $request->info;
        $user->verification_code = Hash::make($token);
        $user->verification_code_expired_at = Carbon::now()->addMinutes(5);
        $user->password = Hash::make($request->password);
        if ($request->file('photo_profile')) {
            $user->photo_profile = $pp;
        } else if ($request->last_pp) {
            $pp = $request->last_pp;
            $user->photo_profile = $pp;
        }

        $remember = $request->has('remember_me');
        $user->save();
        Mail::to($request->email)->send(new SendEmailVerificationCode($token));
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect()->intended('show-verification-code');
        }

        return redirect()->intended('/');
    }

    /**
     * Menampilkan halaman login
     *
     *
     */
    public function showLoginView()
    {
        return view('auth.login');
    }

    /**
     * Menangani autentikasi atau login user
     *
     *
     */
    public function login(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());
        
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required|string',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator->errors());
        }
        $validator = Validator::make($request->all(), [
            'login' => 'email',
        ]);
        
        $loginType = $validator->fails()
            ? 'username'
            : 'email';
        $remember = $request->has('remember_me');

        if (Auth::attempt([
            $loginType => $request->login,
            'password' => $request->password,
        ], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'logine' => 'Kombinasi '.$loginType.' dan password salah',
        ]);
    }
    /**
     * Menangani logout
     *
     *
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    /**
     * Mengirim kode verifikasi kepada user ketika ingin memverifikasi email
     *
     *
     */
    public function sendVerificationCode(Request $request): RedirectResponse
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }
        $email = Auth::user()->email;

        if (Auth::user()->verification_code_expired_at < Carbon::now()) {
            $token = Str::random(6);
            $user = DB::update('update users set verification_code = ?, verification_code_expired_at = ? where email = ?', [Hash::make($token), Carbon::now()->addMinutes(5), $email]);
            Mail::to($email)->send(new SendEmailVerificationCode($token));
            return back()->with([
                'ecode' => 'Kode Verifikasi Telah Dikirim',
            ]);
        }
        $diff = Carbon::createFromFormat('Y-m-d H:i:s', Auth::user()->verification_code_expired_at)->diff(Carbon::now());
        return back()->withErrors([
            'ecode' => 'Tunggu sampai ' . $diff->format('%i menit, %s detik') . ' lagi untuk mengirimkan kode verifikasi',
        ]);
    }
    /**
     * Menampilkan halaman enterEmail atau halaman yang digunakan untuk memasukan email ketika ingin mereset password
     *
     *
     */
    public function showEnterEmailView()
    {
        return view('auth.reset_password.enterEmail');
    }
    /**
     * Menangani email yang dimasukan ketika ingin mereset password dan mengirim kode verifikasinya ke email yang diinputkan
     *
     *
     */
    public function enterEmail(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            $token = Str::random(6);
            $user = DB::update('update users set verification_code = ?, verification_code_expired_at = ? where email = ?', [Hash::make($token), Carbon::now()->addMinutes(5), $email]);
            Mail::to($email)->send(new SendEmailVerificationCode($token));
            Session::start();
            Session::put('erp', $email);

            return redirect()->intended('show-verification-code-reset-password')->with('email', $email);
        }
        return back()->withErrors([
            'ecode' => 'Email tidak terdaftar',
        ]);
    }

    /**
     * Menampilkan halaman enterVerificationCode yang digunakan untuk memasukan kode verifikasi untuk mereset password
     *
     * 
     */
    public function showVerificationCodeResetPassword()
    {
        if (Session::get('erp')) {
            return view('auth.reset_password.enterVerificationCode');
        } else {
            return redirect()->intended('reset-password')->with('status', 'Masukan Email Terlebih Dahulu');
        }
    }

    /**
     * Menangani request user ketika ingin mendapatkan kode verifikasi lagi 
     *
     *
     */
    public function sendVerificationCodeResetPassword(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user->verification_code_expired_at < Carbon::now()) {
            $token = Str::random(6);
            $user->verification_code = Hash::make($token);
            $user->verification_code_expired_at = Carbon::now()->addMinutes(5);
            $user->save();
            Mail::to($email)->send(new SendEmailVerificationCode($token));
            return back()->with([
                'ecode' => 'Kode Verifikasi Telah Dikirim',
            ]);
        }
        $diff = Carbon::createFromFormat('Y-m-d H:i:s', $user->verification_code_expired_at)->diff(Carbon::now());
        return back()->withErrors([
            'ecode' => 'Tunggu sampai ' . $diff->format('%i menit, %s detik') . ' lagi untuk mengirimkan kode verifikasi',
        ]);
    }

    /**
     * Menyimpan perubahan password user ke database
     *
     *
     */
    public function saveNewPassword(Request $request)
    {
        Session::flashInput($request->input());
        $email = Session::get('erp');
        $request->validate([
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
            'password_confirmation' => [
                'required',
            ],
        ]);

        $useru = User::where('email', $email)->first();
        $token = Session::get('token_code');
        if (Hash::check($token, $useru->verification_code)) {
            $user = DB::update('update users set password  = ? where email = ?', [Hash::make($request->password), $email]);
            if ($user) {

                Session::forget('erp');
                Session::forget('token_code');
                return redirect()->intended('/')
                    ->with('success', 'Password telah di ubah');
            }
        }
        return back()->withErrors([
            'ecode' => 'Password gagal di ubah',
        ]);
    }

    /**
     * Mengecek kode verifikasi yang dimasukan user sudah benar atau tidak saat reset password
     *
     *
     */
    public function verifyCode(Request $request)
    {
        Session::flashInput($request->input());
        $request->validate([
            'verification_code' => 'required',
        ]);
        $email = Session::get('erp');
        $user = User::where('email', $email)->first();
        $token = $request->verification_code;
        if (Hash::check($token, $user->verification_code) && $user->verification_code_expired_at > Carbon::now()) {
            Session::put('token_code', $request->verification_code);
            $user = DB::update('update users set email_verified_at = ? where email = ?', [Carbon::now(), $email]);
            return redirect()->intended('show-enter-new-password');
        } else if ($user->verification_code_expired_at < Carbon::now() && Hash::check($token, $user->verification_code)) {
            return back()->withErrors([
                'ecode' => 'Kode verifikasi telah kadaluarsa',
            ]);
        } else {
            return back()->withErrors([
                'ecode' => 'Kode verifikasi salah',
            ]);
        }
    }

    /**
     * Menampilkan halaman enterNewPassword yang digunakan untuk memasukan password baru
     *
     *
     */
    public function showEnterNewPassword()
    {
        if (Session::get('erp') && Session::get('token_code')) {
            return view('auth.reset_password.enterNewPassword');
        } else if (Session::get('erp')) {
            return redirect()->intended('show-verification-code-reset-password')->with('status', 'Masukan Kode Verifikasi Terlebih Dahulu');
        } else {

            return redirect()->intended('reset-password')->with('status', 'Masukan Email Terlebih Dahulu');

        }
    }

    /**
     * Menangani verifikasi email user
     *
     *
     */
    public function verifyEmail(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());

        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }
        $request->validate([
            'verification_code' => 'required',
        ]);
        $email = Auth::user()->email;
        $token = $request->verification_code;
        if (Hash::check($token, Auth::user()->verification_code) && Auth::user()->verification_code_expired_at > Carbon::now()) {
            $user = User::where('email', $email)->first();
            $user->email_verified_at = Carbon::now();
            $user->save();
            return redirect()->intended('/')
                ->with('success', 'Email Berhasil di Konfirmasi');
        } else if (Auth::user()->verification_code_expired_at < Carbon::now() && Hash::check($token, Auth::user()->verification_code)) {
            return back()->withErrors([
                'ecode' => 'Kode verifikasi telah kadaluarsa',
            ]);
        } else {
            return back()->withErrors([
                'ecode' => 'Kode verifikasi salah',
            ]);
        }
    }
    /**
     * Menampilkan halaman verifyCode yang digunakan untuk memasukan kode verifikasi ketika ingin memverifikasi email
     *
     *
     */
    public function showVerificationCode()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->intended('/');
        }
        return view('auth.verifyCode');
    }
}