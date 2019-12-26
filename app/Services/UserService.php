<?php

namespace App\Services;
use App\User;
use App\Pdd\PddOrder;
use App\ActivityTuanOrderVote;

class UserService
{
    /**
     * @param $openId
     * @return null
     * 根据小程序openId获取数据库中用户的信息
     */
    public static function getUserByMpOpenId($openId)
    {
        $_user = null;
        try {
            $_user = User::where('mp->openid', $openId)->firstOrFail();
        }catch (\Exception $e){}
        return $_user;
    }
    // 是否新用户
    public static function isNewbie($user)
    {
        //没有下过单
        //没有给给团助力过
        $order = PddOrder::where('custom_parameters', $user->id.'A')->orWhere('custom_parameters', $user->id.'B')->first();
        $vote = ActivityTuanOrderVote::where('user_id', $user->id)->first();
        return !$order && !$vote;
    }
}