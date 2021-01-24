<?php

namespace BestLang\LaraCms\Http\Controllers;

use Illuminate\Http\Request;
use HashConfig;

class UCenterController extends Controller
{
    public $theme;
    public function __construct()
    {
        $this->theme = HashConfig::get('site', 'theme');
    }

    public function user()
    {
        return response()->ajax(auth()->user());
    }

    public function index(Request $request)
    {
        if(!auth()->user()){
            return redirect('/login');
        }
        return view("laraCMS::themes.{$this->theme}.ucenter.index");
    }

    public function passwordModifyForm(Request $request)
    {
        return view("laraCMS::themes.{$this->theme}.ucenter.passwordModifyForm");
    }
}