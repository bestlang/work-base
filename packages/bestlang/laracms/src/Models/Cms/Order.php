<?php

namespace Bestlang\Laracms\Models\Cms;

use Bestlang\Laracms\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS = [
        'UNPAID' => 0,
        'PAID' => 1,
        'CANCELED' => 4
    ];
    const STATUS_TEXT = [
        0 => '未支付',
        1 => '已支付',
        4 => '已取消'
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
        return self::STATUS_TEXT[$this->attributes['status']];
    }

    public function getGatewayTextAttribute()
    {
        return self::GATEWAY_TEXT[$this->attributes['gateway']];
    }
}
