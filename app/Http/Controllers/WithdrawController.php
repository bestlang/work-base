<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;
use App\Services\WalletService;

class WithdrawController extends Controller
{

    public function postWithdraw(Request $request)
    {
        $amount = $request->input('amount', 0);
        if(!$amount){
            return response()->json(['statusCode'=>'200', 'data' => ['success'=>'0', 'message'=>'提现金额不能为零']], 200);
        }

        $user = auth()->user();
        $ws = new WalletService($user);
        $withdrawable = $ws->withdrawable();
        if($amount>$withdrawable){
            return response()->json(['statusCode'=>'200', 'data' => ['success'=>'0', 'message'=>'提现金额不能大于目前最大可提现金额']], 200);
        }
        DB::beginTransaction();
        try{
            $um = $user->moneyRecords()->create(['type'=>'2', 'amount'=>0 - $amount]);
            $wd = $user->withdraws()->create(['amount'=>$amount, 'user_money_id'=>$um->id]);
        }catch (Exception $e){
            DB::rollBack();
            $message = $e->getMessage();
            return response()->json(['statusCode'=>'200', 'data'=>['message'=>$message]]);
        }
        DB::commit();
        return response()->json(['statusCode'=>'200', 'data'=>['success'=>'1', 'message'=>'申请成功']]);
    }

    public function getWithdraw(Request $request)
    {
        $page = $request->input('page', 1);
        define('PAGE_SIZE', 10);

        $user = auth()->user();
        $ws = $user->withdraws()->orderBy('id', 'desc')->limit(PAGE_SIZE)->offset(($page-1)*PAGE_SIZE)->get();
        return response()->json(['statusCode'=>'200', 'data'=>$ws]);
    }
}
