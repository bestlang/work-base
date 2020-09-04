<?php
if(!function_exists('render')){
    function render($viewPath, $data=[]){
        $theme = hashconfig::get('site', 'theme');
        return view("laracms::{$theme}.{$viewPath}", $data);
    }
}