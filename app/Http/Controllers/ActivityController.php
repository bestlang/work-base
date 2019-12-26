<?php

namespace App\Http\Controllers;

use App\Models\ActivityTuanOrder;
use App\Models\ActivityTuanOrderVote;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Apis\Pdd;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function activityList(Request $request)
    {
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 20);
        $type = $request->input('type', 1);
        $offset = ($page - 1) * $page_size;
        $activities = Activity::where('type', 1)->where('status', 1)->with(['typeName', 'goods'])->orderBy('order_factor', 'desc')->orderBy('id', 'desc')->limit($page_size)->offset($offset)->get();
        return response()->ajax(['activities' => $activities]);
    }

    // get a single activity
    public function activity(Request $request)
    {
        $activityId = $request->input('activityId', 0);
        if(!$activityId){
            $activityId = $request->input('act_id', 0);
        }
        $buyType = $request->input('buyType', 'A');

        $sharedWxUserId = $request->input('s',null);

        $sharedUser = null;

        if (!$activityId) {
            return response()->json(['statusCode' => '200', 'data' => ['activity' => '', 'message' => '参数缺失']], 200);
        }
        $activity = Activity::published()->withTrashed()->with(['galleries', 'typeName'])->where('id',$activityId)->first();
        if(!$activity){
            return response()->json(['statusCode' => '200', 'data' => ['activity' => 'ENDING', 'message' => '已下架']], 200);
        }
        $prepared = $activity->toArray();
        // 拉取最新的商品信息
        if($activity->goods_id){
            $pdd = new Pdd();
            $prepared['goods'] = $pdd->goodsPromotionUrlGenerate($activity->goods_id, $buyType); // 'B' 代表全返(0元购) // 'C' 代表拼团0元购
            $goods_detail = $prepared['goods']->goods_promotion_url_generate_response->goods_promotion_url_list[0]->goods_detail;
            // 剩余券的数量
            $coupon_remain_quantity = $goods_detail->coupon_remain_quantity;
            // 当前价格
            $goods_current_price = $goods_detail->min_group_price - $goods_detail->coupon_discount;
            if($activity->type == 5){
                if(!$coupon_remain_quantity || $goods_current_price > 500){
                    $activity->status = 4;
                    $activity->save();
                }
            }

        }
        // 拼团0元购 获取是否已经参团 进行状态
        if($activity->type == 3){
            // 确定谁是团长
            if($sharedWxUserId){ //分享出去的链接
                $sharedUser = $leader = UserService::getUserByMpOpenId($sharedWxUserId);
            }else{
                $leader = auth()->user();
            }

            if($sharedUser){
                $prepared['sharedUser'] = $sharedUser;
                $tuanRelated = [];

                $order = ActivityTuanOrder::where('user_id', $sharedUser->id)->where('activity_id', $activityId)->orderBy('id', 'desc')->limit(1)->first();
                Log::info($order);
                if ($order) {
                    $tuanRelated['participated'] = 0;
                    $created_timestamp = strtotime(strval($order->created_at));
                    $tuanRelated['tuan_end'] = date('Y-m-d H:i:s', $created_timestamp + 86400);
                    $order = $order->conclusion();//如果满足条件则给团的成团状态下定论
                    $tuanRelated['tuan_status'] = $order->status;
                    // 查出团长以及参团人的信息
                    $tuanRelated['tuan_votes'] = $order->votes()->effective()->get();
                }
                $prepared = array_merge($tuanRelated, $prepared);
            }else {
                $prepared['sharedUser'] = "";
                $tuanRelated = [];

                $order = ActivityTuanOrder::where('user_id', $leader->id)->where('activity_id', $activityId)->orderBy('id', 'desc')->limit(1)->first();
                Log::info($order);
                if (!$order) {
                    $tuanRelated['participated'] = 0;
                } else {
                    $tuanRelated['participated'] = 1;
                    $created_timestamp = strtotime(strval($order->created_at));
                    $tuanRelated['tuan_end'] = date('Y-m-d H:i:s', $created_timestamp + 86400);
                    $order = $order->conclusion();//如果满足条件则给团的成团状态下定论
                    $tuanRelated['tuan_status'] = $order->status;
                    // 查出团长以及参团人的信息
                    $tuanRelated['tuan_votes'] = $order->votes()->effective()->get();
                }
                $prepared = array_merge($tuanRelated, $prepared);
            }

            // 团长信息
            $prepared['leader'] = $leader;
        }
        return response()->ajax(['activity' => $prepared]);
    }
    // 0元购s
    public function zeroBenifits()
    {
        $zeroBenifits = Activity::published()->where('type', 5)->with('goods')->orderBy('order_factor', 'desc')->get();
        return response()->ajax(['zeroBenifits' => $zeroBenifits]);
    }

    public function createTuanOrder(Request $request)
    {
        $activityId = $request->input('activityId', 0);
        $user = auth()->user();
        $activity = Activity::find($activityId);
        if(!$activity || $activity->type != '3'){
            return response()->json(['statusCode' => '200', 'data' => ['success'=>'0', 'message'=>'数据异常']], 200);
        }
        $order = $user->activityTuanOrders()->create(['activity_id'=>$activityId]);
        if($order){
            return response()->ajax([]);
        }
    }

    public function voteTuanOrder(Request $request)
    {
        $activityId = $request->input('activityId', null);
        $sharedWxUserId = $request->input('s',null);
        if(!$activityId || !$sharedWxUserId){
            return response()->json(['statusCode' => '200', 'data' => ['success'=>'0', 'message'=>'参数不全']], 200);
        }
        $sharedUser = UserService::getUserByMpOpenId($sharedWxUserId);
        $order = ActivityTuanOrder::where('user_id', $sharedUser->id)->where('activity_id', $activityId)->orderBy('id', 'desc')->limit(1)->first();
        $order = $order->conclusion();

        $user = auth()->user();
        if($order->isUnderGoing()){ //拼团未结束
            $vote = $order->votes()->where('user_id', $user->id)->first();
            if($vote){ //助力过
                if($vote->effective){
                    $message = '已经助力一次啦!不可重复助力';
                }else{
                    $message = '非新用户不可以助力了哦!';
                }
            }else{ //没助力过
                // 判断是否新用户
                $isNewbie = UserService::isNewbie($user);
                if(!$isNewbie){ // 非新用户
                    // 插入一条无效的投票
                    $order->votes()->create(['user_id'=>$user->id, 'effective'=>'0']);
                    $message = '非新用户不可以助力了哦!';
                }else{ // 新用户
                    if($user->parent_id == $sharedUser->id){ // 拉新过来的用户
                        // 插入一条有效的投票
                        $order->votes()->create(['user_id'=>$user->id, 'effective'=>'1']);
                        $message = '助力成功!';
                    }else{ // 别人拉过来的算作老用户
                        // 插入一条无效的投票
                        $order->votes()->create(['user_id'=>$user->id, 'effective'=>'0']);
                        $message = '非新用户不可以助力哦!';
                    }
                }
            }
        }else{ //拼团已结束
            $message = '助力失败!拼团已经结束';
        }
        return response()->error($message);
    }
}