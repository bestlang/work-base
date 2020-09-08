<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Department;
use Validator;

class DepartmentController
{
    public function index(Request $request)
    {
        $departments = Department::all();
        if(!count($departments)){
            $default = new \stdClass();
            $default->id = '0';
            $default->name  = '做为根部门';
            $departments->push($default);
        }
        $departments->map(function($department){
            $department->label = $department->name;
        });
        $treeSelect = $departments->treeSelect();
        return response()->ajax($treeSelect);
    }

    public function save(Request $request)
    {
       $params = $request->all();
        $rules = [
          'id' => 'numeric|nullable',
          'name' => 'required',
          'parent_id' => 'numeric|required',
          'manager' => 'nullable'
        ];
        $info = [
          'id.numeric' => '参数不合法',
          'name.required' => '部门名称不能为空',
          'parent_id.numeric' => '上级部门错误',
          'parent_id.required' => '请选择上级部门'
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
        // 更新
        if($id){
            $department = Department::find($id);
            $department->update(['parent_id' => $params['parent_id'], 'name' => $params['name'], 'manager' => $params['manager']]);
        }else{ // 新增
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