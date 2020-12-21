<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Notice;
use Arr;
use Sniper\Employee\Models\User;
use Validator;

class NoticeController
{
    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'id' => 'numeric|nullable',
            'title' => 'required',
            'content' => 'required',
            'notice_date' => 'required|date',
            'audiences' => 'array'
        ];
        $msg = [
            'id.numeric' => '参数不合法',
            'title.required' => '主题不能为空',
            'content.required' => '公告内容不能为空',
            'notice_date.required' => '公告日期不能为空',
            'notice_date.date' => '公告日期不合法',
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
        $notice->user_id = auth()->user()->id;
        $notice->title = Arr::get($params, 'title');
        $notice->content = Arr::get($params, 'content');
        $notice->note = Arr::get($params, 'note', '');
        $notice->notice_date = Arr::get($params, 'notice_date', null);
        $notice->attachments = json_encode(Arr::get($params, 'attachments', []));
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

    //不做权限验证 panel也要调用
    public function detail(Request $request)
    {
        $id = $request->input('id');
        $notice = Notice::where('id', $id)->with(['audiences.employee.department', 'user'])->first();
        $notice->attachments = json_decode($notice->attachments);
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
        $histories = $query->with('user')->orderBy('id', 'desc')->limit($page_size)->offset(($page - 1) * $page_size)->get();
        return response()->ajax(compact(['total', 'histories', 'page_size']));
    }

    public function send(Request $request)
    {
        $id = $request->input('id', 0);
        $notice = null;
        try{
            if(!$id){
                throw new \Exception('参数错误');
            }
            $notice = Notice::where('id', $id)->firstOrFail();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }
        $send_at = now();
        $notice->sent = 1;
        $notice->send_at = $send_at;
        $notice->audiences()->update(['sent' => 1, 'send_at' => $send_at]);
        $notice->save();
        return response()->ajax();
    }

    // personal notices
    public function notices(Request $request)
    {
        $userId = auth()->user()->id;
        $user = User::find($userId);
        $query = $user->notices();
        $page = $request->input('page', 1);
        $page_size = $request->input('page_size', 10);
        if($keyword = $request->input('keyword', '')){
            $query->where('title', 'like', "%{$keyword}%");
        }
        $total = $query->count();
        $notices = $query->orderBy('id', 'desc')->limit($page_size)->offset(($page - 1) * $page_size)->get();

        return response()->ajax(compact(['notices', 'total']));
    }
}
