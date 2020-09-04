<?php
namespace Sniper\Employee\Http\Controllers;

use Bestlang\Base\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('sniper::employee.employee.index');
    }
}