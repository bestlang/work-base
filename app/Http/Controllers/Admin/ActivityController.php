<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityGallery;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use Mockery\Exception;
use App\Apis\Pdd;
use App\Pdd\GoodsPromotionUrlGenerate;
use Illuminate\Support\Facades\Log;

class ActivityController extends Controller
{
    // 列表
    public function activityList(Request $request)
    {
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 20);
        $offset = ($page - 1) * $page_size;
        $activities = Activity::orderBy('order_factor', 'desc')->orderBy('id', 'desc')->limit($page_size)->offset($offset)->get();
        return response()->ajax(['activities'=>$activities]);
    }
    // get a single activity
    public function activity(Request $request)
    {
        $activityId = $request->input('activityId', 0);
        if(!$activityId){
            $activityId = $request->input('act_id', 0);
        }
        if(!$activityId){
            return response()->error('参数缺失');
        }
        try {
            $activity = Activity::withTrashed()->with('galleries')->findOrFail($activityId);
            $activity->status_original = $activity->getOriginal('status');
            $status = config('activitystatus');
            $statusArr = [];
            foreach ($status as $k => $s){
                $statusArr[] = ['id'=>$k, 'name'=>$s];
            }
            $activity->statusArr = $statusArr;
        }catch (Exception $e){
            return response()->error($e->getMessage());
        }
        return response()->ajax(['activity'=>$activity]);
    }
    // 添加保存
    public function add(Request $request)
    {
        $data = $request->except('galleries');
        $activity = Activity::create($data);
        $galleries = $request->input('galleries');
        if(count($galleries)){
            foreach ($galleries as $ga){
                $activity->galleries()->save(new ActivityGallery(['thumbnail'=>$ga]));
            }
        }

        return response()->ajax(['name'=>$activity]);
    }
    // 更新保存
    public function save(Request $request)
    {
        $data = $request->except(['galleries']);
        $id = $request->input('id');
        $activity = Activity::find($id);
        $activity->update($data);
        $galleries = $request->input('galleries');

        if(count($galleries)){
            foreach ($galleries as $ga){
                $activity->galleries()->updateOrCreate(['thumbnail'=>$ga]);
            }
        }
        return response()->ajax(['name'=>$activity]);
    }

    public function delete(Request $request)
    {
        $activityId = $request->input('activityId');
        $activity = Activity::find($activityId);
        $activity->galleries()->delete();
        $activity->delete();
        return response()->ajax([]);
    }
    // 总记录数字
    public function page(Request $request)
    {
        $total = Activity::whereRaw("1=1")->count();
        return response()->ajax(['total'=>$total]);
    }
    // 活动类型
    public function types(Request $request)
    {
        $types = ActivityType::orderBy('order_factor', 'desc')->get();
        return response()->ajax(['types'=>$types]);
    }
    // 适用人群
    public function applicables(Request $request)
    {
        return response()->ajax(['applicables'=>config('activityapplicable')]);
    }
    // 推送商品
    public function attachGoods(Request $request)
    {
        $plantform = $request->input('plantform', '1');
        $goods_id = $request->input('goods_id');
        $type = $request->input('type');

        if(!$goods_id){
            return response()->error('参数缺失');
        }
        if($plantform == '1'){
            $hitGoods = GoodsPromotionUrlGenerate::where('goods_id', $goods_id)->first();
            if(!$hitGoods){
                $pdd = new Pdd;
                $aio = $pdd->goodsPromotionUrlGenerate($goods_id);
            }else{
                $aio = $hitGoods->aio;
            }
        }
        if($aio instanceof \stdClass){
            $aio = $this->object2array($aio);
        }
        Log::info('$aio:', $aio);
        $max = Activity::max('order_factor');
        // 检测是否重复操作
        $activity = Activity::withTrashed()->where('plantform', $plantform)->where('goods_id',$goods_id)->where('type', $type)->first();

        if($activity){
            $activity->status = 1;
            $activity->deleted_at = null;
            $activity->order_factor = $max + 1;
            $activity->save();
            return response()->ajax([]);
        }
        // 检测商品是否插入缓存表并取出来
        $activity = Activity::create(['plantform'=>$plantform, 'goods_id'=>$goods_id, 'type'=>$type]);
        $obj = $aio['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];
        $activity->name = $obj['we_app_info']['title'];
        $activity->thumbnail = $obj['goods_detail']['goods_thumbnail_url'];
        if($type == 1){
            $activity->status = 1;
        }
        if($type == 5){
            $activity->status = 1;
        }
        $activity->order_factor = $max + 1;
        $activity->save();
        $goods_gallery_urls = $obj['goods_detail']['goods_gallery_urls'];
        $galleries = [];
        foreach ($goods_gallery_urls as $g){
            $galleries[] = ['thumbnail'=> $g, 'activity_id'=>$activity->id];
        }
        $activity->galleries()->insert($galleries);

        return response()->ajax([]);
    }

    // 删除相册图片
    public function galleryDelete(Request $request)
    {
        $activityId = $request->input('activityId', 0);
        $thumbnail = $request->input('thumbnail');
        $activity = Activity::find($activityId);
        $activity->galleries()->where('thumbnail', $thumbnail)->delete();
        return response()->ajax([]);
    }

    // 状态类型列表
    public function status()
    {
        $status = config('activitystatus');
        $statusArr = [];
        foreach ($status as $k => $s){
            $statusArr[] = ['id'=>$k, 'name'=>$s];
        }
        return response()->ajax(['statusArr'=>$statusArr]);
    }
    // 对象转数组
    public function object2array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object2array($v);
            }
        }

        return $obj;
    }
}
