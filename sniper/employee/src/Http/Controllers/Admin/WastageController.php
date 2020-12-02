<?php

namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Wastage;
use Sniper\Employee\Models\User;

class WastageController
{
    public function histories(Request $request)
    {
        $page = $request->input('page', 0);
        $keyword = $request->input('keyword', null);
        $pageSize = $request->input('page_size', 10);
        $query = Wastage::query();
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
        list($name, $email) = explode('-',  $params['employee'], 2);
        $user = User::where('email', $email)->where('name', $name)->first();
        if(!$user){
            return response()->error('人员信息错误！');
        }

        try{
            $wastage = new Wastage();
            $wastage->user_id = $user->id;
            $wastage->name = $user->name;
            $wastage->apply = json_encode($request->input('apply',[]));
            $wastage->handover = json_encode($request->input('handover',[]));
            $wastage->record = json_encode($request->input('record',[]));
            $wastage->other = json_encode($request->input('other',[]));
            $wastage->save();
        }catch (\Exception $e){
            return response()->error($e->getMessage());
        }


        return response()->ajax($request->all());

    }
}
