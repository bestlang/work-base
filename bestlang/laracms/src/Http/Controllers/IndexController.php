<?php

namespace BestLang\LaraCMS\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{

    public function index()
    {
        return render('index.index');
    }
}
