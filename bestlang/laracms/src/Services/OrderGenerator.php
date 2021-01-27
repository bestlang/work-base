<?php
namespace BestLang\LaraCMS\Services;

use BestLang\LaraCMS\Models\CMS\Order;
use BestLang\LaraCMS\Models\CMS\Content;

class OrderGenerator
{
    public function __invoke($content_id, $num)
    {
        try{
            $content = Content::find($content_id);
            $price = $content->price;
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->name = $content->title;
            $order->money = $price * $num;
            $order->product_id = $content_id;
            $order->save();
        }catch (\Exception $e){
            return $e->getMessage();
        }
        return $order;
    }
}