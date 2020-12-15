<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Train;
use Arr;
use Validator;

class TrainController
{
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $train = Train::where('id', $id)->with('participants.employee.department')->first();
        return response()->ajax($train);
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'id' => 'numeric|nullable',
            'title' => 'required',
            'content' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'last_days' => 'numeric|nullable',
            'last_hours' => 'numeric|nullable',
            'last_minutes' => 'numeric|nullable',
            'teacher' => 'nullable',
            'location' => 'nullable',
            'participants' => 'array'
        ];
        $msg = [
            'id.numeric' => '参数不合法',
            'title.required' => '课程名称不能为空',
            'content.required' => '课程内容不能为空',
            'start_time.required' => '开始日期不能为空',
            'end_time.required' => '结束日期不能为空',
            'last_days.numeric' => '天数只能为数字',
            'last_hours.numeric' => '小时只能为数字',
            'last_minutes.numeric' => '分钟只能为数字',
            'participants.array' => '参数不合法'
        ];
        $validator = Validator::make($params, $rules , $msg);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $train = new Train();
        if($id = Arr::get($params, 'id')){
            $existing = Train::where('id', $id)->first();
            if($existing){
                $train = $existing;
            }
        }
        $train->title = Arr::get($params, 'title');
        $train->content = Arr::get($params, 'content');
        $train->start_time = Arr::get($params, 'start_time');
        $train->start_time = Arr::get($params, 'start_time');
        $train->end_time = Arr::get($params, 'end_time');
        $train->last_days = Arr::get($params, 'last_days');
        $train->last_hours = Arr::get($params, 'last_hours');
        $train->last_minutes = Arr::get($params, 'last_minutes');
        $train->teacher = Arr::get($params, 'teacher');
        $train->location = Arr::get($params, 'location');
        $train->save();

        $userIds = [];
        $participants = Arr::get($params, 'participants');
        foreach ($participants as $participant){
            list($userId,) = explode('-', $participant);
            $userId = intval($userId);
            if($userId){
                $userIds[] = $userId;
            }
        }
        $train->participants()->sync($userIds);
        return response()->ajax();
    }

    public function delete(Request $request)
    {
            $id = $request->input('id', 0);
            if($id){
                $train = Train::where('id', $id)->first();
                $train->participants()->sync([]);
                $train->delete();
            }
            return response()->ajax();
    }

    public function histories(Request $request)
    {
        $query = Train::query();
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 10);
        if($keyword = $request->input('keyword', '')){
            $query->where('title', 'like', "%{$keyword}%");
        }
        $total = $query->count();
        $histories = $query->orderBy('id', 'desc')->limit($page_size)->offset(($page - 1) * $page_size)->get();
        return response()->ajax(compact(['total', 'histories', 'page_size']));
    }
}
