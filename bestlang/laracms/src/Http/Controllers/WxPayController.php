<?php
namespace BestLang\LaraCms\Http\Controllers;


use Illuminate\Http\Request;

use BestLang\LaraCms\Models\Cms\Order;


class WxPayController
{
    //native1
    public function native1(Request $request)
    {
        $order_no = $request->input('order_no');

        $url = app()['wxPay']->native1($order_no);

        return response()->ajax($url);
    }
    //native1 需要调用统一下单api的
    public function wechatNativeNotify()
    {
        app()['wxPay']->wechatNativeNotify();
    }
    //都要用
    public function wechatAsyncNotify(Request $request)
    {
        app()['wxPay']->wechatAsyncNotify();
    }

    //微信支付的native2
    public function native2(Request $request)
    {
        $order_no = $request->input('order_no');
        try{
            $order = Order::where('order_no', $order_no)->firstOrFail();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        $url = app()['wxPay']->native2($order);

        return response()->ajax($url);
    }

}