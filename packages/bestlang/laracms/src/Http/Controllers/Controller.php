<?php

namespace Bestlang\Laracms\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Bestlang\Laracms\Models\Cms\Config;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

//    public function render($viewPath)
//    {
//        $theme = Config::get('site', 'theme');
//        return view("laracms::{$theme}.{$viewPath}");
//    }
}
