<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityTuanOrder extends Model
{
    protected $table = 'activity_tuan_orders';
    protected $guarded = [];

    // 团助力
    public function votes()
    {
        return $this->hasMany(ActivityTuanOrderVote::class, 'order_id')->with('userInfo');
    }

    // 活动
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // 拼团成功与否下定论
    public function conclusion()
    {
        $created_timestamp = strtotime(strval($this->created_at));
        if($this->status == 1){
            if(time() - $created_timestamp >= 86400){
                $effectiveVoteCount = $this->votes()->effective()->count();
                if($effectiveVoteCount >= $this->activity->tuan_size){
                    $this->status = 2;
                }else{
                    $this->status = 4;
                }
                $this->save();
            }
        }
        return $this;
    }

    public function isUnderGoing()
    {
        return time() - strtotime(strval($this->created_at)) < 86400;
    }
}
