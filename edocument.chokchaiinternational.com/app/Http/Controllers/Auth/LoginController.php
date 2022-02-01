<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
  
use App\Models\User;  
use Illuminate\Support\Facades\Auth; 
use Laravel\Socialite\Facades\Socialite;
use Cookie;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login( Request $request )
    {       
        $input = $request->all();
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);    
        $remember = $request->has('remember') ? true : false; 
        if($remember==true){
            Cookie::queue('email', $input['email']);
        } 
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){   
            if(auth()->user()->is_users == 1){  
                if(isset($request->document_id)){ 
                    return redirect()->route('documents_viwe', [$request->document_id]);
                }else{
                    if(auth()->user()->email=="vivienne@farmchokchai.net"){
                        return redirect()->route('documents_io', [2]);
                    } else {
                        return redirect()->route('dashboard');
                    } 
                } 
            } else if(auth()->user()->is_users == 2){  
                return redirect()->route('login')->with('error', 'สิทธิ์การเข้าถึงไม่ถูกต้อง!'); 
            }
        } else {
            return redirect()->route('login')->with('error', 'ที่อยู่อีเมลและรหัสผ่านไม่ถูกต้อง!'); 
        }
    } 
}
