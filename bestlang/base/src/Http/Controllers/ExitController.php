<?php

namespace Bestlang\Base\Http\Controllers;

class ExitController extends Controller
{
    public function logout()
    {
        auth()->logout();

        return response()->ajax();
    }
}