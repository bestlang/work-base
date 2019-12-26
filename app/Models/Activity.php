<?php

namespace App\Models;

use App\Pdd\GoodsPromotionUrlGenerate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Activity extends Model
{
    use SoftDeletes;
    //
    protected $table = 'activities';
    protected $guarded = [];
    protected $dates = ['start_time', 'end_time'];

    protected $casts = [
        'end_time'   => 'datetime:Y-m-d H:i',
        'start_time'   => 'datetime:Y-m-d H:i'
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    public function galleries()
    {
        return $this->hasMany(ActivityGallery::class);
    }

    public function typeName()
    {
        return $this->belongsTo(ActivityType::class, 'type');
    }

    public function getStatusAttribute()
    {
        $statusArr = config('activitystatus');
        return $statusArr[$this->attributes['status']];
    }

    public function goods()
    {
        return $this->hasOne(GoodsPromotionUrlGenerate::class, 'goods_id', 'goods_id');
    }
}
