<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Department;
use Sniper\Employee\Models\Position;
use Validator;

class DepartmentController
{
    public function delete(Request $request)
    {
        if(!auth()->user()->can('hr delete departments')){
            return response()->error('没有权限!', 4012);
        }
        $id = $request->input('id');
        if(!$id){
            return response()->error('参数错误');
        }
        $position = Department::find($id);
        $position->delete();
        return response()->ajax();
    }
    public function departmentDetail(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return response()->error('参数错误');
        }
        $department = Department::with('parent')->find($id);
        if($department){
            return response()->ajax($department);
        }
    }
    // 部门子树
    public function getDescendants(Request $request)
    {
        if(!auth()->user()->can('hr list departments')){
            return response()->error('没有权限!', 4012);
        }
        $tree = Department::with('parent')->get()->toHierarchy();
        return response()->ajax($tree);
    }
    //所以直属根节点的部门
    public function level1(Request $request)
    {
        $root = Department::whereNull('parent_id')->first();
        $children = $root->children()->get();
        return response()->ajax($children);
    }

    public function treeSelect(Request $request)
    {
        $departments = Department::all();
        if(!count($departments)){
            $default = new Department();
            $default->id = '0';
            $default->name  = '做为根部门';
            $departments->push($default);
        }
        $treeSelect = $departments->toHierarchy();
        return response()->ajax($treeSelect);
    }

    public function save(Request $request)
    {
        $user = auth()->user();
        if( !$user->can('hr add departments')  && !$user->can('hr edit departments') ){
            return response()->error('没有权限!', 4012);
        }
       $params = $request->all();
        $rules = [
          'id' => 'numeric|nullable',
          'name' => 'required',
          'parent_id' => 'numeric|nullable',
          'manager' => 'nullable'
        ];
        $info = [
          'id.numeric' => '参数不合法',
          'name.required' => '部门名称不能为空',
          'parent_id.numeric' => '上级部门错误',
        ];
        $names = [
          'id' => 'ID',
          'name' => '部门',
          'parent_id' => '上级部门',
          'manager' => '经理'
        ];
        $validator = Validator::make($params, $rules , $info , $names);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $id = $params['id'] ?? 0;
        isset($params['parent_id']) || $params['parent_id'] = null;
        // 更新
        if($id){
            $department = Department::find($id);
            $exists = Department::where([ 'parent_id' => $params['parent_id'],  'name'=>$params['name'] ])->where('id', '!=', $params['id'])->exists();
            if($exists){
                return response()->error('添加失败！同级同名部门已存在.');
            }
            $department->update(['parent_id' => $params['parent_id'], 'name' => $params['name'], 'manager' => $params['manager']]);
        }else{ // 新增
            //判断是否存在同级同名
            $exists = Department::where( [ 'parent_id' => $params['parent_id'],  'name'=>$params['name'] ] )->exists();
            if($exists){
                return response()->error('添加失败！同级同名部门已存在.');
            }
            if(!$params['parent_id']){//根节点
                $root = Department::create(['name' => $params['name'], 'manager' => $params['manager']]);
            }else{//非根节点
                $parent = Department::find($params['parent_id']);
                $child = Department::create(['name' => $params['name'], 'manager' => $params['manager']]);
                $child->makeChildOf($parent);
            }
        }
        return response()->ajax();
    }
}