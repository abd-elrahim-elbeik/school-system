<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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

    //use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginForm($type){

        return view('auth.login',compact('type'));
    }

    public function login(Request $request){

        if($request->type == 'student'){
            $guardName= 'student';
        }
        elseif ($request->type == 'parent'){
            $guardName= 'parent';
        }
        elseif ($request->type == 'teacher'){
            $guardName= 'teacher';
        }
        else{
            $guardName= 'web';
        }


        if (Auth::guard($guardName)->attempt(['email' => $request->email, 'password' => $request->password])) {

            if($request->type == 'student'){
                return redirect()->intended(RouteServiceProvider::STUDENT);
            }
            elseif ($request->type == 'parent'){
                return redirect()->intended(RouteServiceProvider::PARENT);
            }
            elseif ($request->type == 'teacher'){
                return redirect()->intended(RouteServiceProvider::TEACHER);
            }
            else{
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }else{
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
            return redirect()->back();
        }

    }

    public function logout(Request $request,$type)
    {
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }



}
