<?php

namespace Bestlang\Laracms\Http\Controllers\Admin;

use Bestlang\Laracms\Models\User;
use Illuminate\Http\Request;
use Bestlang\Laracms\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Bestlang\Laracms\Models\Permission;

class PrivilegesController extends Controller
{
    //get login user's full permission
    public function userPermissions()
    {
        $user = Auth::user();
        $userPermissions = $user->getPermissionsViaRoles();

        $allPermissions = Permission::all();

        if($user->hasRole('administrator')){
            $userPermissions = $allPermissions;
        }
        $permissionIds = $userPermissions->map(function ($item){ return $item->id;})->toArray();
        $permissions = $userPermissions->map(function ($item){ return $item->name;})->toArray();


        //make sure one has the parent permission if one has a leaf permission of it, for the menu
        foreach ($allPermissions as $permission){
            $children_permissions = Permission::whereBetween('left', [$permission->left, $permission->right])->get();
            $children_permissions->each(function ($item)use($permission, $permissionIds, &$permissions){
                if(in_array($item->id, $permissionIds)){
                    array_push($permissions, $permission->name);
                }
            });
        }

        return response()->ajax(collect($permissions)->unique()->values()->all());
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
    // remove a user from role user list
    public function removeRoleModel(Request $request)
    {
        $params = $request->all();

        $role_id = Arr::get($params, 'role_id', 0);
        $model_id = Arr::get($params, 'model_id', 0);
        $model_type = Arr::get($params, 'model_type', '');

        $user = User::find($model_id);
        $role = Role::find($role_id);
        $login_user = Auth::user();
        if(get_class($user) === get_class($login_user)){
            if($user->id === $login_user->id){
                return response()->error('不可删除当前用户!');
            }
        }
        $user->removeRole($role);
        return response()->ajax();
    }
    public function roles()
    {
        return response()->ajax(Role::all());
    }

    public function roleUsers(Request $request)
    {
        $params = $request->all();
        $id = Arr::get($params, 'id', 0);
        if($id){
            $role = Role::with(['users'])->find($id);
            return response()->ajax($role);
        }
        return response()->ajax([]);
    }

    public function saveRole(Request $request)
    {
        $user = Auth::user();
        $params = $request->all();
        $id = Arr::get($params, 'id');
        $name = Arr::get($params, 'name');
        if($id){
            try{
                if($user->can('privileges edit roles')){
                    $role = Role::find($id);
                    $role->name = $name;
                    $role->save();
                }else{
                    return response()->error('无权限!');
                }
            }catch (\Exception $e){
                return response()->error('error occur:'.$e->getMessage());
            }

        }else{
            $role = new Role();
            $role->name = $name;
            $role->save();
        }
        return response()->ajax();
    }

    public function deleteRole(Request $request)
    {
        $id = $request->input('id', 0);
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
    public function permissionsTree(Request $request)
    {
        $params = $request->all();
        $disabled = Arr::get($params, 'disabled', false);
        $tree = Permission::all()->map(function($item)use($disabled){
            if($disabled){
                $item->disabled=true;
            }
            return $item;
        })->toHierarchy();
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
        Permission::where('id', $id)->update(['name'=>$name, 'show_name'=>$show_name]);
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
