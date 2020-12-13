<?php
namespace BestLang\Base\Http\Controllers;

use Illuminate\Http\Request;

class SocialiteController extends Controller
{
    public function qq(Request $request)
    {
        foreach($request->all() as $key => $val){
            echo "<p>{$key} = {$val}</p>";
        }
        echo "<p>回调成功</p>";
        return view('base::socialite.qq');
    }
}