<?php
namespace BestLang\Base\Http\Controllers;


class IndexController extends Controller
{
    public function csrf()
    {
        return response()->ajax(csrf_token());
    }
}