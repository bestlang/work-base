<?php
namespace Sniper\Employee;

class Employee
{
    public function getName()
    {
        return 'employee';
    }

    public function getPath()
    {
        return base_path().'/sniper/employee/';
    }

    public function home()
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