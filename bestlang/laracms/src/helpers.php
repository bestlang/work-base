<?php
if(!function_exists('render')){
    function render($viewPath, $data=[]){
        $theme = HashConfig::get('site', 'theme');

        $pathInfo = request()->getPathInfo();
        $cacheDir = '.cache';
        $generate = trim($pathInfo, '/') . '.html';
        $fullPath = public_path() . DIRECTORY_SEPARATOR . $cacheDir . DIRECTORY_SEPARATOR . $generate;
        $expectDir = dirname($fullPath);
        if(!file_exists($expectDir)){
            mkdir($expectDir, 0777, true);
        }

        $content = view("laraCMS::themes.{$theme}.{$viewPath}", $data)->__toString();
        file_put_contents($fullPath, $content);
        return $content;
    }
}