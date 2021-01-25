<?php
namespace BestLang\LaraCMS\Http\Controllers;


use Illuminate\Http\Request;

class PayController
{
    public function wxpay(Request $request)
    {
        $order_no = $request->input('order_no');
        return render('pay.wxpay', ['order_no' => $order_no]);
    }
    public function alipay(Request $request)
    {
        $order_no = $request->input('order_no');
        return render('pay.alipay', ['order_no' => $order_no]);
    }
}