<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pdd\GoodsPromotionUrlGenerate;

class CollectGoodsController extends Controller
{
    public function postCollectGoods(Request $request)
    {
        $goods_id = $request->input('goods_id');
        $plantform = $request->input('plantform', 1);

        $user = auth()->user();
        $cg = $user->collectGoods()->where('goods_id', $goods_id)->where('plantform', $plantform)->first();
        if($cg){
            $cg->delete();
        }else{
            $cg = $user->collectGoods()->create(['goods_id'=>$goods_id, 'plantform'=>$plantform]);
        }
        return response()->ajax($cg);
    }

    public function getCollectGoods(Request $request)
    {
        $plantform = $request->input('plantform', 1);
        $page = $request->input('page', 1);
        define('PAGE_SIZE', 10);
        $user = auth()->user();
        $collectGoods = $user->collectGoods()->with('goods')->where('plantform', $plantform)->orderBy('id', 'desc')->limit(PAGE_SIZE)->offset(($page-1)*PAGE_SIZE)->get();
        $goods_list = [];
        foreach ($collectGoods as $goods){
            if($goods->goods){
                $aio = $goods->goods->aio;
                $reality = $aio['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];
                $goods_list[] = $reality;
            }
        }
        return response()->ajax($goods_list);
    }
}
