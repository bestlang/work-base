<?php
namespace Sniper\Employee\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Sniper\Employee\Models\Position;
use Validator;

class PositionController
{
    public function delete(Request $request)
    {
        if(!auth()->user()->can('hr delete positions')){
            return response()->error('没有权限!', 4012);
        }
        $id = $request->input('id');
        if(!$id){
            return response()->error('参数错误');
        }
        $position = Position::find($id);
        $position->delete();
        return response()->ajax();
    }
    public function positionDetail(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return response()->error('参数错误');
        }
        $position = Position::with(['parent', 'employee','employee.user', 'employee.department'])->find($id);
        if($position){
            return response()->ajax($position);
        }
    }
    // 部门子树
    public function getDescendants(Request $request)
    {
        if(!auth()->user()->can('hr list positions')){
            return response()->error('没有权限!', 4012);
        }
        $tree = Position::with(['department', 'parent'])->get()->toHierarchy();
        return response()->ajax($tree);
    }
    public function treeSelect(Request $request)
    {
        $positions = Position::all();
        if(!count($positions)){
            $default = new Position();
            $default->id = 0;
            $default->name  = '做为根职位';
            $positions->push($default);
        }
        $treeSelect = $positions->toHierarchy();
        return response()->ajax($treeSelect);
    }

    public function save(Request $request)
    {
        $user = auth()->user();
        $params = $request->all();
        $rules = [
            'id' => 'numeric|nullable',
            'name' => 'required',
            'department_id' => 'numeric|required',
            'parent_id' => 'numeric|nullable',
            'desiring' => 'numeric|nullable'
        ];
        $info = [
            'id.numeric' => '参数不合法',
            'name.required' => '职位名称不能为空',
            'department_id.numeric' => '所属部门不能为空',
            'department_id.numeric' => '所属部门错误',
            //'parent_id.required' => '上级职位不能为空',
            'parent_id.numeric' => '上级职位错误',
            'desiring.numeric' => '所需员工只能为数字'
        ];
        $names = [
            'id' => 'ID',
            'name' => '职位',
            'department_id' => '所属部门',
            'desiring' => '所需员工数'
        ];
        $validator = Validator::make($params, $rules , $info , $names);
        if($validator->fails()){
            return response()->error($validator->errors()->first());
        }
        $id = $params['id'] ?? 0;
        // 更新
        if($id){
            if(!$user->can('hr edit positions') ){
                return response()->error('没有权限!', 4012);
            }
            $position = Position::find($id);
            if($params['parent_id'] == $id){
                return response()->error('更新失败！上级职位不可以是自身.');
            }
            $exists = Position::where([ 'parent_id' => $params['parent_id'], 'department_id' => $params['department_id'],  'name'=>$params['name'] ])->where('id', '!=', $params['id'])->exists();
            if($exists){
                return response()->error('更新失败！同级同名职位已存在.');
            }

            $position->update([
                'parent_id' => $params['parent_id'],
                'department_id' => $params['department_id'],
                'name' => $params['name'],
                'desiring' => $params['desiring'],
                'jd' => $params['jd']??'',
                'basicAbility' => $params['basicAbility']??'',
                'highAbility' => $params['highAbility']??'',
                'affordAbility' => $params['affordAbility']??''
            ]);
        }else{ // 新增
            if( !$user->can('hr add positions')){
                return response()->error('没有权限!', 4012);
            }
            //判断是否存在同级同名
            $exists = Position::where( [ 'parent_id' => $params['parent_id'], 'department_id' => $params['department_id'],  'name'=>$params['name'] ] )->exists();
            if($exists){
                return response()->error('添加失败！同级同名职位已存在.');
            }
            if(!$params['parent_id']){//根节点
                $root = Position::create([
                    'name' => $params['name'],
                    'department_id' => $params['department_id'],
                    'desiring' => $params['desiring'],
                    'jd' => $params['jd']??'',
                    'basicAbility' => $params['basicAbility']??'',
                    'highAbility' => $params['highAbility']??'',
                    'affordAbility' => $params['affordAbility']??''
                ]);
            }else{//非根节点
                $parent = Position::find($params['parent_id']);
                $child = Position::create([
                    'name' => $params['name'],
                    'department_id' => $params['department_id'],
                    'desiring' => $params['desiring'],
                    'jd' => $params['jd']??'',
                    'basicAbility' => $params['basicAbility']??'',
                    'highAbility' => $params['highAbility']??'',
                    'affordAbility' => $params['affordAbility']??''
                ]);
                $child->makeChildOf($parent);
            }
        }
        return response()->ajax();
    }
}