<?php

use Illuminate\Database\Seeder;
use Bestlang\Laracms\Models\User;
use Spatie\Permission\Models\Role;
use Bestlang\Laracms\Models\Permission;
use Bestlang\Laracms\Models\Cms\FieldType;

class InitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*-
            delete from users;
            delete from roles;
            delete from role_has_permissions;
            delete from model_has_roles;
            delete from cms_field_types;
            delete from permissions;
            delete from permissions;
            delete from cms_field_types;
            delete from cms_model_fields;
            delete from cms_models;
            delete from cms_channels;
            delete from cms_contents;
        -*/
        /*-开始用户与权限-*/
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@larashop.com',
            'mobile' => '18625072568',
            'password' => bcrypt('111111'),
        ]);

        $role = Role::create([
            'name' => 'administrator',
            'guard_name' => 'api'
        ]);
        $user->assignRole($role);

        $root = Permission::create(['name' => 'system', 'show_name' => '系统权限', 'guard_name' => 'api']);

        $dashboard = Permission::create(['name' => 'dashboard', 'show_name' => '面板', 'guard_name' => 'api']);
        $dashboard->makeChildOf($root);

        $privileges = Permission::create(['name' => 'privileges', 'show_name' => '权限系统', 'guard_name' => 'api']);
        $privileges->makeChildOf($root);

        $privileges_roles = Permission::create(['name' => 'privileges roles', 'show_name' => '角色管理', 'guard_name' => 'api']);
        $privileges_roles->makeChildOf($privileges);

        $privileges_add_roles = Permission::create(['name' => 'privileges add roles', 'show_name' => '新增', 'guard_name' => 'api']);
        $privileges_add_roles->makeChildOf($privileges_roles);
        $privileges_edit_roles = Permission::create(['name' => 'privileges edit roles', 'show_name' => '编辑', 'guard_name' => 'api']);
        $privileges_edit_roles->makeChildOf($privileges_roles);
        $privileges_delete_roles = Permission::create(['name' => 'privileges delete roles', 'show_name' => '删除', 'guard_name' => 'api']);
        $privileges_delete_roles->makeChildOf($privileges_roles);
        $privileges_list_roles = Permission::create(['name' => 'privileges list roles', 'show_name' => '列表', 'guard_name' => 'api']);
        $privileges_list_roles->makeChildOf($privileges_roles);

        $privileges_permissions = Permission::create(['name' => 'privileges permissions', 'show_name' => '权限管理', 'guard_name' => 'api']);
        $privileges_permissions->makeChildOf($privileges);

        $privileges_add_permissions = Permission::create(['name' => 'privileges add permissions', 'show_name' => '新增', 'guard_name' => 'api']);
        $privileges_add_permissions->makeChildOf($privileges_permissions);
        $privileges_edit_permissions = Permission::create(['name' => 'privileges edit permissions', 'show_name' => '编辑', 'guard_name' => 'api']);
        $privileges_edit_permissions->makeChildOf($privileges_permissions);
        $privileges_delete_permissions = Permission::create(['name' => 'privileges delete permissions', 'show_name' => '删除', 'guard_name' => 'api']);
        $privileges_delete_permissions->makeChildOf($privileges_permissions);
        $privileges_list_permissions = Permission::create(['name' => 'privileges list permissions', 'show_name' => '列表', 'guard_name' => 'api']);
        $privileges_list_permissions->makeChildOf($privileges_permissions);

        $privileges_role_users = Permission::create(['name' => 'privileges role users', 'show_name' => '角色用户', 'guard_name' => 'api']);
        $privileges_role_users->makeChildOf($privileges);

        $privileges_add_role_users = Permission::create(['name' => 'privileges add role users', 'show_name' => '新增', 'guard_name' => 'api']);
        $privileges_add_role_users->makeChildOf($privileges_role_users);
        $privileges_delete_role_users = Permission::create(['name' => 'privileges delete role users', 'show_name' => '删除', 'guard_name' => 'api']);
        $privileges_delete_role_users->makeChildOf($privileges_role_users);
        $privileges_list_role_users = Permission::create(['name' => 'privileges list role users', 'show_name' => '列表', 'guard_name' => 'api']);
        $privileges_list_role_users->makeChildOf($privileges_role_users);

        $privileges_role_permissions = Permission::create(['name' => 'privileges role permissions', 'show_name' => '角色权限', 'guard_name' => 'api']);
        $privileges_role_permissions->makeChildOf($privileges);

        $privileges_edit_role_permissions = Permission::create(['name' => 'privileges edit role permissions', 'show_name' => '编辑', 'guard_name' => 'api']);
        $privileges_edit_role_permissions->makeChildOf($privileges_role_permissions);

        $cms = Permission::create(['name' => 'cms', 'show_name' => '内容管理', 'guard_name' => 'api']);
        $cms->makeChildOf($root);

        $cms_channels = Permission::create(['name' => 'cms channels', 'show_name' => '栏目管理', 'guard_name' => 'api']);
        $cms_channels->makeChildOf($cms);

        $cms_add_channels = Permission::create(['name' => 'cms add channels', 'show_name' => '新增', 'guard_name' => 'api']);
        $cms_add_channels->makeChildOf($cms_channels);
        $cms_edit_channels = Permission::create(['name' => 'cms edit channels', 'show_name' => '编辑', 'guard_name' => 'api']);
        $cms_edit_channels->makeChildOf($cms_channels);
        $cms_delete_channels = Permission::create(['name' => 'cms delete channels', 'show_name' => '删除', 'guard_name' => 'api']);
        $cms_delete_channels->makeChildOf($cms_channels);
        $cms_list_channels = Permission::create(['name' => 'cms list channels', 'show_name' => '列表', 'guard_name' => 'api']);
        $cms_list_channels->makeChildOf($cms_channels);

        $cms_contents = Permission::create(['name' => 'cms contents', 'show_name' => '内容管理', 'guard_name' => 'api']);
        $cms_contents->makeChildOf($cms);

        $cms_add_contents = Permission::create(['name' => 'cms add contents', 'show_name' => '新增', 'guard_name' => 'api']);
        $cms_add_contents->makeChildOf($cms_contents);
        $cms_edit_contents = Permission::create(['name' => 'cms edit contents', 'show_name' => '编辑', 'guard_name' => 'api']);
        $cms_edit_contents->makeChildOf($cms_contents);
        $cms_delete_contents = Permission::create(['name' => 'cms delete contents', 'show_name' => '删除', 'guard_name' => 'api']);
        $cms_delete_contents->makeChildOf($cms_contents);
        $cms_list_contents = Permission::create(['name' => 'cms list contents', 'show_name' => '列表', 'guard_name' => 'api']);
        $cms_list_contents->makeChildOf($cms_contents);

        $cms_setting = Permission::create(['name' => 'cms setting', 'show_name' => '设置', 'guard_name' => 'api']);
        $cms_setting->makeChildOf($cms);

        $cms_setting_model = Permission::create(['name' => 'cms setting model', 'show_name' => '模型管理', 'guard_name' => 'api']);
        $cms_setting_model->makeChildOf($cms_setting);
        $cms_setting_fields = Permission::create(['name' => 'cms setting fields', 'show_name' => '字段管理', 'guard_name' => 'api']);
        $cms_setting_fields->makeChildOf($cms_setting);

        $permissions = Permission::all();
        $permissions->each(function($permission)use($role){
            $role->givePermissionTo($permission);
        });
        /*-结束用户与权限-*/

        /*-开始预设字段类型-*/
        FieldType::create(['type' => 'select', 'name' => '单选列表', 'extra' => ['options' => true]]);
        FieldType::create(['type' => 'radio', 'name' => '单选按钮', 'extra' => ['options' => true]]);
        FieldType::create(['type' => 'text', 'name' => '单行文本', 'extra' => ['options' => false]]);
        FieldType::create(['type' => 'content', 'name' => '内容', 'extra' => ['options' => false]]);
        FieldType::create(['type' => 'checkbox', 'name' => '多选', 'extra' => ['options' => true]]);
        FieldType::create(['type' => 'image', 'name' => '单图', 'extra' => ['options' => false]]);
        FieldType::create(['type' => 'multiple-image', 'name' => '图集', 'extra' => ['options' => false]]);
        /*-结束预设字段类型-*/
    }
}
