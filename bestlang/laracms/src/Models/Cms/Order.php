<?php

namespace BestLang\LaraCMS\Models\Cms;

use BestLang\LaraCMS\Models\User;
use Illuminate\Database\Eloquent\Model;
use BestLang\WxPay\Pay\Contracts\OrderInterface;
use \Exception;

class Order extends Model implements OrderInterface
{
    const STATUS = [
        'UNPAID' => 0,
        'PAID' => 1,
        'CANCELED' => 4,
        'CLOSED' => 5
    ];
    const STATUS_TEXT = [
        0 => '未支付',
        1 => '已支付',
        4 => '已取消',
        5 => '已关闭'
    ];
    const GATEWAY = [
        'UNKNOWN' => 0,
        'WECHAT' => 1,
        'ALIPAY' => 2
    ];
    const GATEWAY_TEXT = [
        0 => '-',
        1 => '微信',
        2 => '支付宝'
    ];
    protected $table = 'cms_orders';
    protected $guarded = [];
    protected $appends = ['status_text', 'gateway_text'];

    public static function boot()
    {
        parent::boot();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusTextAttribute()
    {
        $status = $this->attributes['status']??0;
        if(isset(self::STATUS_TEXT[$status])){
            return self::STATUS_TEXT[$status];
        }else{
            throw new Exception('unknown order status '.$status);
        }
    }

    public function getGatewayTextAttribute()
    {
        $gateway = $this->attributes['gateway']??0;
        if(isset(self::GATEWAY_TEXT[$gateway])){
            return self::GATEWAY_TEXT[$gateway];
        }else{
            throw new Exception('出错了');
        }
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }

    public function getMoney()
    {
        return $this->money;
    }

    public function getOrderNo()
    {
        return $this->order_no;
    }

    public function getOrderByOrderNo($order_no)
    {
        return static::where('order_no', $order_no)->first();
    }
}
