<?php

namespace Bestlang\Laracms\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        return render('index.index');
    }

    public function cms()
    {
        return render('index.cms');
    }

    public function about()
    {
        return render('index.about');
    }

    public function contact()
    {
        return render('index.contact');
    }

    public function csrf()
    {
        return response()->ajax(csrf_token());
    }
}
