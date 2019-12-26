<?php

namespace App\Http\Controllers;

use App\Models\VisitHistory;
use Illuminate\Http\Request;
use App\Pdd\GoodsPromotionUrlGenerate;

class VisitHistoryController extends Controller
{
    public function postVisitHistory(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $plantform = $request->input('plantform', 1);

        if(!$goods_id){
            return response()->json(['statusCode'=>'200', 'data'=>['message'=>'参数缺失', 'success'=>'0']]);
        }

        $user = auth()->user();
        $vh = $user->visitHistories()->where('goods_id', $goods_id)->where('plantform', $plantform)->first();
        if($vh){
            $vh->delete();
        }
        $vh = $user->visitHistories()->create(['goods_id'=>$goods_id, 'plantform'=>$plantform]);
        return response()->json(['statusCode'=>'200', 'data'=>[]]);
    }
    public function getVisitHistory(Request $request)
    {
        $plantform = $request->input('plantform', 1);
        $page = $request->input('page', 1);
        define('PAGE_SIZE', 10);
        $user = auth()->user();
        $visitHistory = $user->visitHistories()->with('goods')->where('plantform', $plantform)->orderBy('id', 'desc')->limit(PAGE_SIZE)->offset(($page-1)*PAGE_SIZE)->get();
        foreach ($visitHistory as $goods){
            if($goods->goods){
                $reality = $goods->goods->aio['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];
                $goods_list[] = $reality;
            }
        }
        return response()->json(['statusCode'=>'200', 'data'=>$goods_list]);

    }
}
