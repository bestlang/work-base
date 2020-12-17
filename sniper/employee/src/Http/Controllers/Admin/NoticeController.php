<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Notice;
use xin\helper\Arr;

class NoticeController extends Controller
{
    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'id' => 'numeric|nullable',
            'title' => 'required',
            'content' => 'required',
            'audiences' => 'array'
        ];
        $msg = [
            'id.numeric' => '参数不合法',
            'title.required' => '主题不能为空',
            'content.required' => '通知内容不能为空',
            'audiences.array' => '参数不合法'
        ];
        $validator = Validator::make($params, $rules , $msg);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $notice = new Notice();
        if($id = Arr::get($params, 'id')){
            $existing = Notice::where('id', $id)->first();
            if($existing){
                $notice = $existing;
            }
        }
        $notice->user_id = auth()->user->id;
        $notice->title = Arr::get($params, 'title');
        $notice->content = Arr::get($params, 'content');
        $notice->note = Arr::get($params, 'note', '');
        $notice->attachments = Arr::get($params, 'attachments', '');
        $notice->save();

        $userIds = [];
        $audiences = Arr::get($params, 'audiences');
        foreach ($audiences as $audience){
            list($userId,) = explode('-', $audience);
            $userId = intval($userId);
            if($userId){
                $userIds[] = $userId;
            }
        }
        $notice->audiences()->sync($userIds);
        return response()->ajax();
    }

    public function detail(Request $request)
    {
        $id = $request->input('id');
        $notice = Notice::where('id', $id)->with('audiences.employee.department')->first();
        return response()->ajax($notice);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        if($id){
            $notice = Notice::where('id', $id)->first();
            $notice->audiences()->sync([]);
            $notice->delete();
        }
        return response()->ajax();
    }

    public function histories(Request $request)
    {
        $query = Notice::query();
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
