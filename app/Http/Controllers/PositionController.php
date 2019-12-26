<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apis\Pdd;

class PositionController extends Controller
{
    //
    public function homeTopSwiper(Request $request)
    {
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 50);
        $pdd = new Pdd();
        $result = $pdd->themeListGet($page, $page_size);

        $imgList = [];

        $s = new \stdClass();
        $s->src = "http://jetcdn.larashop.com/uploads/addToMine4.png";
        $s->id = 1;
        $imgList[] = $s;
        $b = new \stdClass();
        $b->src = "http://jetcdn.larashop.com/uploads/zeroBuyNew.png";
        $b->id = 2;
        $imgList[] = $b;

        $s = new \stdClass();
        $s->src = "http://jetcdn.larashop.com/uploads/addToMine4.png";
        $s->id = 1;
        $imgList[] = $s;
        $b = new \stdClass();
        $b->src = "http://jetcdn.larashop.com/uploads/zeroBuyNew.png";
        $b->id = 2;
        $imgList[] = $b;

        return response()->json([
            'data' => $imgList,
            'success' => '1',
            'message' => 'ok'
        ], 200);
    }

    public function messages()
    {
        $messages = [];
        $messages[] = [
            'avatar' => 'http://jetcdn.larashop.com/uploads/shua.png',
            'title' => '天天刷福利,小礼拿不停!',
            'content' => '刷福利平台每天发放各种小礼物,购物优惠券,还有更多购物返利等你来拿~'
        ];
        return response()->json([
            'data' => $messages,
            'success' => '1',
            'message' => 'ok'
        ], 200);
    }
}
