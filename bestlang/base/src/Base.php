<?php
namespace BestLang\Base;
use Arr;

class Base
{
    public function getName()
    {
        return 'Base';
    }

    public function getPath()
    {
        return base_path().'/bestlang/base/';
    }

    public function home()
    {
        return view('base::index.index');
    }

    public function authPrefix()
    {
        return 'base::';
    }
}