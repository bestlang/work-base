<?php

namespace Bestlang\Laracms\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        //return view('cms.'.config('cms.theme').'.index.index');
        return view('laracms::dark.index.index');
    }

    public function cms()
    {
        return view('laracms::dark.index.cms');
    }

    public function about()
    {
        return view('laracms::dark.index.about');
    }

    public function contact()
    {
        return view('laracms::dark.index.contact');
    }
}
