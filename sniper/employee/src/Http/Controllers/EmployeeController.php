<?php
namespace Sniper\Employee\Http\Controllers;

use BestLang\Base\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        if(auth()->user()){
            return redirect('/admin#/panel');
        }else{
            return view('sniper::auth.login');
        }
        //return view('sniper::employee.employee.index');
    }
}