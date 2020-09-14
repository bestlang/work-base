<?php

namespace Sniper\Employee\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Sniper\Employee\Models\Education;

class EducationController
{
    public function delete(Request $request)
    {

        $user_id = $request->input('user_id');
        $id = $request->input('id');
        if(!$user_id || !$id){
            return response()->error('参数错误');
        }
        $education = Education::where(['user_id' => $user_id, 'id' => $id])->first();
        if($education){
            $education->delete();
        }else{//id是临时分配的，不存在数据库，当做成功处理
            return response()->ajax();
        }
        return response()->ajax();
    }
}