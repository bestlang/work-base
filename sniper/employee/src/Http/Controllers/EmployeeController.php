<?php
namespace Sniper\Employee\Http\Controllers;

use BestLang\Base\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        //print_r(auth()->user());
        if(auth()->user()){
            return redirect('/admin#/panel');
            //return redirect('/admin#/panel/attendance');
        }else{
            return view('sniper::auth.login');
        }
//        return view('sniper::employee.employee.index');
    }
}