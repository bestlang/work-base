<?php
namespace Bestlang\Laracms\Services;

use Bestlang\Laracms\Models\Cms\Order;
use Bestlang\Laracms\Models\Cms\Content;

class OrderGenerator
{
    public function __invoke($content_id, $num)
    {
        try{
            $content = Content::find($content_id);
            $price = $content->getExt()['price'];
            $order = new Order;
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