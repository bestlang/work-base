<?php

namespace Bestlang\Base\Http\Controllers\Auth;

use Bestlang\Base\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'login']);
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    public function showLoginForm()
    {
        return view('base::auth.login');
    }

    public function username()
    {
        if(request()->ajax()){
            return 'mobile';
        }else{
            return 'email';
        }
    }

    public function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        if($request->ajax()){
            return response()->error($this->username().':'.Lang::get('auth.throttle', ['seconds' => $seconds]), Response::HTTP_TOO_MANY_REQUESTS);
        }else{
            throw ValidationException::withMessages([
                $this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])],
            ])->status(Response::HTTP_TOO_MANY_REQUESTS);
        }
    }

    public function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if($request->ajax()){
            return response()->ajax(['user' => auth()->user()]);
        }else{
            return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
        }
    }

    public function sendFailedLoginResponse(Request $request)
    {
        if($request->ajax()){
            return response()->error($this->username().':'.trans('auth.failed'));
        }else{
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }
    }

    protected function loggedOut(Request $request)
    {
        if($request->ajax()) {
            return response()->ajax('登出成功!');
        }
    }

}
