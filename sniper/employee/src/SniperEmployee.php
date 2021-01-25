<?php
namespace Sniper\Employee;

class SniperEmployee
{
    public function moduleName()
    {
        return 'sniper';
    }

    public function homePage()
    {
        if(auth()->user()){
            return redirect('/admin/#/panel');
        }else{
            return view('sniper::auth.login');
        }
    }

    public function getAuthPrefix()
    {
        return 'sniper::';
    }
}