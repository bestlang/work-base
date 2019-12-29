<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use App\Models\Permission;

class PrivilegesController extends Controller
{
    //get login user's full permission
    public function userPermissions()
    {
        $user = Auth::user();
        $permissions = $user->getPermissionsViaRoles()->map(function ($item){ return $item->name;});
        return response()->ajax($permissions);
    }
    // assign permissions to a specific role
    public function givePermissionsTo(Request $request)
    {
        $params = $request->all();
        $role_id = Arr::get($params, 'role_id', 0);
        $currentPermissions = Arr::get($params, 'permissions', 0);
        $role = Role::find($role_id);
        $oldPermissions = $role->getAllPermissions()->pluck('id')->toArray();
        $role->permissions()->detach($oldPermissions);//[]
        $role->permissions()->attach($currentPermissions);//[]
        return response()->ajax();
    }
    // get permissions of a role
    public function rolePermissions(Request $request)
    {
        $role_id = $request->input('role_id', 0);
        $role = Role::find($role_id);
        return response()->ajax($role->permissions()->pluck('id')->toArray());
    }
    // delete a user from role user list
    public function deleteRoleModel(Request $request)
    {
        $params = $request->all();

        $role_id = Arr::get($params, 'role_id', 0);
        $model_id = Arr::get($params, 'model_id', 0);
        $model_type = Arr::get($params, 'model_type', '');

        $user = User::find($model_id);
        $role = Role::find($role_id);
        $user->removeRole($role);
        return response()->ajax();
    }
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

    public function saveRole(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id', '');
        $name = Arr::get($params, 'name', '');
        if($id){
            $role = Role::find($id);
            $role->name = $name;
            $role->save();
        }else{
            $role = new Role();
            $role->name = $name;
            $role->save();
        }
        return response()->ajax();
    }

    public function deleteRole(Request $request, $id)
    {
        $role = Role::find($id);
        $count = Role::where('id', '<', $id)->count();
        if($count){
            $role->delete();
        }else{
            return response()->error('超级管理员不得删除');
        }
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
                return response()->ajax($child);
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
