<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use App\Models\Permission;

class PrivilegesController extends Controller
{
    public function roles()
    {
        return response()->ajax(Role::all());
    }

    public function roleUsers(Request $request, $id)
    {
        $params = $request->all();
        if($id){
            $users = Role::find($id)->users;
            return response()->ajax($users);
        }
        return response()->ajax([]);
    }

    public function addRole(Request $request)
    {
        $params = $request->all();
        $name = $params['name'];
        $role = new Role();
        $role->name = $name;
        $role->save();
        return response()->ajax();
    }

    public function deleteRole(Request $request, $id)
    {
        Role::find($id)->delete();
        return response()->ajax();
    }

    /*
     * get permissions in tree format
     */
    public function permissionsTree()
    {
        $tree = Permission::all()->toHierarchy();
        return response()->ajax($tree);
    }

    public function addPermission(Request $request)
    {
        $params = $request->all();
        $parent_id = Arr::get($params, 'parent_id', 0);
        $name = Arr::get($params, 'name', 0);
        $show_name = Arr::get($params, 'show_name', 0);
        if($parent_id){
            $parent = Permission::find($parent_id);
            if($parent){
                $child = Permission::create(['name' => $name, 'show_name'=>$show_name]);
                $child->makeChildOf($parent);
            }
        }
        return response()->ajax();
    }

    public function editPermission(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id', 0);
        $name = Arr::get($params, 'name', 0);
        $show_name = Arr::get($params, 'show_name', 0);
        $permission = Permission::find($id);
//        $permission->name = $name;
//        $permission->show_name = $show_name;
        $permission->update(['name'=>$name, 'show_name'=>$show_name]);
        return response()->ajax();
    }

    public function deletePermission(Request $request)
    {
        $id = $request->get('id', 0);
        if($id){
            $permission = Permission::find($id);
            $permission->delete();
            return response()->ajax();
        }
        return response()->error('error occur');
    }
}
