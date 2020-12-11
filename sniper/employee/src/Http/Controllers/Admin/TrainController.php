<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Train;
use Arr;
use Validator;

class TrainController
{
    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'title' => 'required',
            'content' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'last_days' => 'numeric|nullable',
            'last_hours' => 'numeric|nullable',
            'last_minutes' => 'numeric|nullable',
            'teacher' => 'nullable',
            'location' => 'nullable',
        ];
        $msg = [
            'title.required' => '课程名称不能为空',
            'content.required' => '课程内容不能为空',
            'start_time.required' => '开始日期不能为空',
            'end_time.required' => '结束日期不能为空',
            'last_days.numeric' => '天数只能为数字',
            'last_hours.numeric' => '小时只能为数字',
            'last_minutes.numeric' => '分钟只能为数字',
            //'' => '',
        ];
        $validator = Validator::make($params, $rules , $msg);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $train = new Train();
        $train->title = Arr::get($params, 'title');
        $train->content = Arr::get($params, 'content');
        $train->start_time = Arr::get($params, 'start_time');
        $train->start_time = Arr::get($params, 'start_time');
        $train->end_time = Arr::get($params, 'end_time');
        $train->last_days = Arr::get($params, 'last_days');
        $train->last_hours = Arr::get($params, 'last_hours');
        $train->last_minutes = Arr::get($params, 'last_minutes');
        $train->teacher = Arr::get($params, 'teacher');
        $train->save();
        return response()->ajax();
    }

    public function delete(Request $request)
    {

    }

    public function histories(Request $request)
    {

    }
}
