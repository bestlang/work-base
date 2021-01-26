<?php
namespace BestLang\Base;
use Arr;

class Base
{
    public function moduleName()
    {
        return 'Base';
    }

    public function modulePath()
    {
        return base_path().'/bestlang/base/';
    }

    public function homePage()
    {
        return view('base::index.index');
    }

    public function authPrefix()
    {
        return 'base::';
    }
}