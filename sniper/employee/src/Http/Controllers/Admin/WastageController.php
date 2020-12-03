<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Wastage;
use Sniper\Employee\Models\User;
use Validator;
use Arr;

class WastageController
{
    public function delete(Request $request)
    {
        $id = $request->input('id');
        $wastage  = Wastage::find($id);
        if(!$id){
            return response()->ajax('参数错误');
        }
        if(!$wastage){
            return response()->ajax('记录不存在');
        }
        try{
            $wastage->delete();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }finally{
            return response()->ajax();
        }
    }
    public function histories(Request $request)
    {
        $page = $request->input('page', 0);
        $keyword = $request->input('keyword', null);
        $pageSize = $request->input('page_size', 10);
        $query = Wastage::with('user');
        if($keyword){
            $query->where('name', 'like', "%{$keyword}%");
        }
        $total = $query->count();
        $items = $query->orderBy('id', 'desc')
            ->limit($pageSize)
            ->offset(($page-1)*$pageSize)
            ->get();
        return response()->ajax(['total' => $total, 'items' => $items]);
    }

    public function save(Request $request)
    {
        $params = $request->all();
        $rules = [
            'id' => 'numeric|nullable',
            'date' => 'required',
            'employee' => 'required',
        ];
        $msg = [
            'date.required' => '请选择离职日期',
            'employee.required' => '请选择人员'
        ];
        $validator = Validator::make($params, $rules , $msg);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        list($name, $email) = explode('-',  $params['employee'], 2);
        $user = User::where('email', $email)->where('name', $name)->first();
        if(!$user){
            return response()->error('人员信息错误！');
        }
        $id = Arr::get($params, 'id', 0);
        if($id){//更新逻辑
            $wastage = Wastage::find($id);
            if($wastage){
                try{
                    $wastage->date = $params['date'];
                    $wastage->user_id = $user->id;
                    $wastage->name = $user->name;
                    $wastage->apply = json_encode(Arr::get($params, 'apply',[]));
                    $wastage->handover = json_encode(Arr::get($params, 'handover',[]));
                    $wastage->record = json_encode(Arr::get($params, 'record',[]));
                    $wastage->other = json_encode(Arr::get($params, 'other',[]));
                    $wastage->note = Arr::get($params, 'note', '');
                    $wastage->save();
                    if($user->employee){
                        $user->employee->onJob = 0;
                        $user->push();
                    }else{
                        throw new \Exception('员工信息不存在');
                    }
                }catch (\Exception $e){
                    return response()->error($e->getMessage());
                }
            }else{
                return response()->error('记录不存在');
            }
        }else{//新增逻辑
            try{
                $wastage = new Wastage();
                $wastage->date = $params['date'];
                $wastage->user_id = $user->id;
                $wastage->name = $user->name;
                $wastage->apply = json_encode(Arr::get($params, 'apply',[]));
                $wastage->handover = json_encode(Arr::get($params, 'handover',[]));
                $wastage->record = json_encode(Arr::get($params, 'record',[]));
                $wastage->other = json_encode(Arr::get($params, 'other',[]));
                $wastage->note = Arr::get($params, 'note', '');
                $wastage->save();
                if($user->employee){
                    $user->employee->onJob = 0;
                    $user->push();
                }else{
                    throw new \Exception('员工信息不存在');
                }
            }catch (\Exception $e){
                return response()->error($e->getMessage());
            }
        }
        return response()->ajax($request->all());
    }
}
