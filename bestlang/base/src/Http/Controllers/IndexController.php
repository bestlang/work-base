<?php
namespace Bestlang\Base\Http\Controllers;


class IndexController extends Controller
{
    public function csrf()
    {
        return response()->ajax(csrf_token());
    }
}