<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WalletService;

class WalletController extends Controller
{
    public function index()
    {
        /**
         * 订单状态描述（
         * -1 未支付;
         * 0-已支付；
         * 1-已成团；
         * 2-确认收货；
         * 3-审核成功；
         * 4-审核失败（不可提现）；
         * 5-已经结算；
         * 8-非多多进宝商品（无佣金订单）;
         * 10-已处罚）
         */
        $user = auth()->user();

        $ws = new WalletService($user);
        $summarize = $ws->summarize();
        return response()->json(['statusCode'=>'200',
                'data'=>$summarize]);
    }

    public function details(Request $request)
    {
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 10);
        $type = $request->input('type');
        $user = auth()->user();
        $money_records = $user->moneyRecords()->where('type', $type)->with('contributer')->orderBy('id', 'desc')->limit($page_size)->offset($page_size*($page-1))->get();
        return response()->json(['statusCode'=>'200',
            'data'=>$money_records]);
    }

    public function types()
    {
        // 资金类型1购物佣金2提现扣除3系统赠送
        $arr = ['1'=>'返利/佣金', '2'=>'提现扣除', '3'=>'系统赠送'];
        return response()->json(['statusCode'=>'200', 'data'=>$arr], 200);
    }
}
