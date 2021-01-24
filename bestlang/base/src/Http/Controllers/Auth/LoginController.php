<?php

namespace BestLang\Base\Http\Controllers\Auth;

//use BestLang\Base\Events\HistoryEvent;
use BestLang\Base\Http\Controllers\Controller;
//use BestLang\Base\Models\History;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use BestLang\Base\Models\User;
use BestLang\Base\Factory\HistoryEventFactory;
use BestLang\Base\Http\Traits\PasswordModifyTrait;
use Validator;
use Lang;
use Response;

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
    use PasswordModifyTrait;

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
        $this->middleware('guest')->except(['logout', 'login', 'passwordModify']);
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    public function showLoginForm()
    {
        return view(session('authPrefix').'.auth.login');
    }

    public function username()
    {
        //目前web前台使用email管理后台使用手机
        if(request()->ajax()){
            return 'email';//mobile
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
        event(HistoryEventFactory::loginEvent());
        if($request->ajax()){
            return response()->ajax(['user' => User::find(auth()->user()->id), 'csrf' => csrf_token()]);
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
    public function logout(Request $request)
    {
        event(HistoryEventFactory::logoutEvent());
        $this->guard()->logout();
        $request->session()->invalidate();
        if($request->ajax()){
            return response()->ajax([]);
        }else{
            return $this->loggedOut($request) ?: redirect('/');
        }

    }

    protected function loggedOut(Request $request)
    {
        if($request->ajax()) {
            return response()->ajax('登出成功!');
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[
            $this->username().'.required' => $this->username().'不能为空',
            'password.required' => '密码不能为空',
        ]);
    }

}
