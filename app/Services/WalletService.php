<?php

namespace App\Services;
use App\User;


class WalletService
{
    public $user = null;
    public $money_records = [];

    public function __construct($user){
        $this->user = $user;
        $this->money_records = $this->user->moneyRecords;
    }

    public function summarize()
    {
        /**
         * 订单状态描述（
         * -1 未支付;
         * 0-已支付；
         * 1-已成团；
         * 2-确认收货；
         * 3-审核成功；
         * 4-审核失败（不可提现）；
         * 5-已经结算；
         * 8-非多多进宝商品（无佣金订单）;
         * 10-已处罚）
         */

        // 日度
        $today_sum = 0;
        $today_start = date("Y-m-d H:i:s", strtotime(date("Y-m-d")));
        $today_end = date("Y-m-d H:i:s", strtotime("$today_start +1 day"));
        $todays = $this->money_records->reject(function($record)use($today_start, $today_end){
            $time = $record->order_pay_time;
            if(!$time){
                $time = $record->created_at;
            }
            return in_array($record->order_status, ['-1', '4', '8', '10']) || $time > $today_end || $time < $today_start;
        });
        foreach ($todays as $r){
            $today_sum += $r->amount;
        }

        // 昨天
        $yesterday_sum = 0;
        $yesterday_start = date("Y-m-d H:i:s", strtotime("$today_start -1 day"));
        $yesterday_end = $today_start;
        $yesterdays = $this->money_records->reject(function($record)use($yesterday_start, $yesterday_end){
            $time = $record->order_pay_time;
            if(!$time){
                $time = $record->created_at;
            }
            return in_array($record->order_status, ['-1', '4', '8', '10']) || $time > $yesterday_end || $time < $yesterday_start;
        });
        foreach ($yesterdays as $r){
            $yesterday_sum += $r->amount;
        }

        // 月度
        $month_sum = 0;
        $month_start = date('Y-m-d H:i:s', strtotime(date("Y-m")));
        $month_end =  date("Y-m-d H:i:s", strtotime("$month_start +1 month"));
        $months = $this->money_records->reject(function($record)use($month_start, $month_end){
            $time = $record->order_pay_time;
            if(!$time){
                $time = $record->created_at;
            }
            return in_array($record->order_status, ['-1', '4', '8', '10']) ||  $time > $month_end || $time < $month_start;
        });
        foreach ($months as $r){
            $month_sum += $r->amount;
        }

        // 预估总收益
        $estimate_sum = 0;
        $estimates = $this->money_records->reject(function($record){
            return in_array($record->order_status, [-1, 4, 8, 10]);
        });
        foreach ($estimates as $r){
            $estimate_sum += $r->amount;
        }

        // 可提现
        $withdrawable_sum = $this->withdrawable();
        return [
            'today_sum'=>sprintf('%.2f', $today_sum),
            'yesterday_sum'=>sprintf('%.2f', $yesterday_sum),
            'month_sum'=>sprintf('%.2f', $month_sum),
            'estimate_sum'=>sprintf('%.2f', $estimate_sum),
            'withdrawable_sum'=>sprintf('%.2f', $withdrawable_sum)
        ];
    }

    public function withdrawable()
    {
        // 可提现
        $withdrawable_sum = 0;
        $withdrawable = $this->money_records->filter(function($record){
            return $record->order_status == 3 || $record->order_status == 5 || $record->type == 2 || $record->type == 3;
        });
        foreach ($withdrawable as $r){
            $withdrawable_sum += $r->amount;
        }
        return $withdrawable_sum;
    }
}