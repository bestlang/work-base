<?php

namespace BestLang\LaraCms\Http\Controllers;

use Illuminate\Http\Request;

class UCenterController extends Controller
{
    public function index(Request $request)
    {
        if(!auth()->user()){
            return redirect('/login');
        }
        return render('ucenter.index');
    }

    public function passwordModifyForm(Request $request)
    {
        return render('ucenter.passwordModifyForm');
    }
}