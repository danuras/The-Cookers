<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon; 
use DB;
use App\Mail\SendEmailVerificationCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationView()
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],'c_password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            
            'gender' => 'required|max:1',
            'info' => 'max:30',
            'bio'=>'max:500',
        ]);
        if($request->c_password != $request->password){
            return back()->withErrors([
                's_password' => 'Password tidak sama',
            ]);
        }
        $photo_profile_name = '';
        if($request->file('photo_profile')){
            $photo_profile = $request->file('photo_profile');
            $photo_profile_name = time() . '_' . $photo_profile->getClientOriginalName();
            $photo_profile->storeAs('public/photo_profiles', $photo_profile_name);
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
        $user->photo_profile = $photo_profile_name;
        $remember = $request->has('remember_me');
        Mail::to($request->email)->send(new SendEmailVerificationCode($token));
        $user->save();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect()->intended('show-verification-code');
        }

        return  redirect()->intended('/');
    }
    public function showLoginView()
    {
        return view('auth.login');
    }
    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $remember = $request->has('remember_me');
 
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'logine' => 'Kombinasi email dan password salah',
        ]);
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }
    public function sendVerificationCode(Request $request): RedirectResponse
    {
        
        $email = Auth::user()->email;
        
        if (Auth::user()->verification_code_expired_at < Carbon::now()){
            $token = Str::random(6);
            $user = DB::update('update users set verification_code = ?, verification_code_expired_at = ? where email = ?', [Hash::make($token), Carbon::now()->addMinutes(5), $email]);
            Mail::to($email)->send(new SendEmailVerificationCode($token));
            return back()->withErrors([
                'ecode' => 'Kode Verifikasi Telah Dikirim',
            ]);
        }
        $diff = Carbon::createFromFormat('Y-m-d H:i:s', Auth::user()->verification_code_expired_at)->diff(Carbon::now());
        return back()->withErrors([
            'ecode' => 'Tunggu sampai '.$diff->format('%i menit, %s detik').' lagi untuk mengirimkan kode verifikasi',
        ]);
    }
    
    public function showEnterEmailView()
    {
        return view('auth.reset_password.enterEmail');
    }
    public function enterEmail(Request $request): RedirectResponse
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if($user){
            $token = Str::random(6);
            $user = DB::update('update users set verification_code = ?, verification_code_expired_at = ? where email = ?', [Hash::make($token), Carbon::now()->addMinutes(5), $email]);
            Mail::to($email)->send(new SendEmailVerificationCode($token));
            Session::start();
            Session::put('erp', $email);
            
            return redirect()->intended('show-verification-code-reset-password' )->with('email', $email);
        }
        return back()->withErrors([
            'ecode' => 'Email tidak terdaftar',
        ]);
    }
    
    public function showVerificationCodeResetPassword()
    {
        return view('auth.reset_password.enterVerificationCode');
    }
    public function sendVerificationCodeResetPassword(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());
        $email = $request->email;
        $useru = User::where('email', $email)->first();
        if ($useru->verification_code_expired_at < Carbon::now()){
            $token = Str::random(6);
            $user = DB::update('update users set verification_code = ?, verification_code_expired_at = ? where email = ?', [Hash::make($token), Carbon::now()->addMinutes(5), $email]);
            Mail::to($email)->send(new SendEmailVerificationCode($token));
            return back()->withErrors([
                'ecode' => 'Kode Verifikasi Telah Dikirim',
            ]);
        }
        $diff = Carbon::createFromFormat('Y-m-d H:i:s', $useru->verification_code_expired_at)->diff(Carbon::now());
        return back()->withErrors([
            'ecode' => 'Tunggu sampai '.$diff->format('%i menit, %s detik').' lagi untuk mengirimkan kode verifikasi',
        ]);
    }

    public function saveNewPassword(Request $request): RedirectResponse{
        
        Session::flashInput($request->input());
        $email = $request->email;
        Session::forget('erp');
        $request->validate([
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'c_password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);
        
        if($request->c_password != $request->password){
            return back()->withErrors([
                's_password' => 'Password tidak sama',
            ]);
        }
        $user = DB::update('update users set password  = ? where email = ?', [Hash::make($request -> password), $email]);
        if($user){
            return  redirect()->intended('/')
            ->with('success', 'Password telah di ubah');
        } 
        return back()->withErrors([
            'ecode' => 'Password gagal di ubah',
        ]);
    }

    public function verifyCode(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());

        $request->validate([
            'verification_code' => 'required',
            'email' => 'required',
        ]);
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $token = $request->verification_code;
        if(Hash::check($token, $user->verification_code) && $user->verification_code_expired_at > Carbon::now()){
            $user = DB::update('update users set email_verified_at = ? where email = ?', [Carbon::now(), $email]);
            return  redirect()->intended('show-enter-new-password')
            ->with('email', $email);
        } else if ($user->verification_code_expired_at < Carbon::now() && Hash::check($token, $user->verification_code)){
            return back()->withErrors([
                'ecode' => 'Kode verifikasi telah kadaluarsa',
            ]);
        }else {  
            return back()->withErrors([
                'ecode' => 'Kode verifikasi salah',
            ]);
        }
    }

    
    public function showEnterNewPassword()
    {
        return view('auth.reset_password.enterNewPassword');
    }

    public function verifyEmail(Request $request): RedirectResponse
    {
        Session::flashInput($request->input());
        $request->validate([
            'verification_code' => 'required',
        ]);
        $email = Auth::user()->email;
        $token = $request->verification_code;
        if(Hash::check($token, Auth::user()->verification_code) && Auth::user()->verification_code_expired_at > Carbon::now()){
            $user = DB::update('update users set email_verified_at = ? where email = ?', [Carbon::now(), $email]);
            return  redirect()->intended('/')
            ->with('success', 'Email Berhasil di Konfirmasi');
        } else if (Auth::user()->verification_code_expired_at < Carbon::now() && Hash::check($token, Auth::user()->verification_code)){
            return back()->withErrors([
                'ecode' => 'Kode verifikasi telah kadaluarsa',
            ]);
        }else {  
            return back()->withErrors([
                'ecode' => 'Kode verifikasi salah',
            ]);
        }
    }
    
    public function showVerificationCode()
    {
        return view('auth.verifyCode');
    }
}