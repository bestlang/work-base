<?php
use Bestlang\Laracms\Models\Cms\Config;
if(!function_exists('render')){
    function render($viewPath){
        $theme = Config::get('site', 'theme');
        return view("laracms::{$theme}.{$viewPath}");
    }
}