<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Sniper\Employee\Models\Job;
use Illuminate\Http\Request;

class JobController
{
    public function delete(Request $request)
    {

        $user_id = $request->input('user_id');
        $id = $request->input('id');
        if(!$user_id || !$id){
            return response()->error('参数错误');
        }
        $job = Job::where(['user_id' => $user_id, 'id' => $id])->first();
        if($job){
            $job->delete();
        }else{//id是临时分配的，不存在数据库，当做成功处理
            return response()->ajax();
        }
        return response()->ajax();
    }
}