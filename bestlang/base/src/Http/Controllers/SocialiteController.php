<?php
namespace BestLang\Base\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use BestLang\Base\Models\User;
use BestLang\Base\Models\Socialite as SocialiteModel;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function qq(Request $request)
    {
        return Socialite::driver('qq')->redirect();
    }
    public function qqCallback(Request $request)
    {
        $user = Socialite::driver('qq')->withUnionId()->user();
        $socialiteUser = SocialiteModel::updateOrCreate(
            ['plantform' => 'qq', 'unionId' => $user->unionid],
            ['nickname' => $user->nickname, 'avatar' => $user->avatar]
        );
        if(!$socialiteUser->user_id){
            $user = User::create([
                'name' => $socialiteUser->nickname,
                'email' => $socialiteUser->id.'_'.randomStr().'@sample.com',
                'password' => bcrypt('111111')
            ]);
            $socialiteUser->user_id = $user->id;
            $socialiteUser->save();
            Auth::login($user);
        }else{
            Auth::login($socialiteUser->user);
        }
        //return redirect('/');
        return view('base::socialite.qq');
    }
}