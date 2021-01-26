<?php
namespace Sniper\Employee;

class Employee
{
    public function moduleName()
    {
        return 'employee';
    }

    public function homePage()
    {
        if(auth()->user()){
            return redirect('/admin/#/panel');
        }else{
            return view('employee::auth.login');
        }
    }

    public function authPrefix()
    {
        return 'employee::';
    }
}