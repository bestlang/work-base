<?php
namespace BestLang\LaraCms\Services;

use BestLang\LaraCms\Models\Cms\Order;
use BestLang\LaraCms\Models\Cms\Content;

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