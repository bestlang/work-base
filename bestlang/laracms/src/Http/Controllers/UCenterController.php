<?php

namespace Bestlang\Laracms\Http\Controllers;

use Illuminate\Http\Request;

class UCenterController extends Controller
{
    public function index(Request $request)
    {
        if(!auth()->user()){
            return redirect('/login');
        }
        return view('laracms::dark.ucenter.index');
    }
}