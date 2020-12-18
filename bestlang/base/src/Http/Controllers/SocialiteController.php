<?php
namespace BestLang\Base\Http\Controllers;

use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function qq(Request $request)
    {
        print_r(\Socialite::driver('qq')->user());
        return view('base::socialite.qq');
    }
}