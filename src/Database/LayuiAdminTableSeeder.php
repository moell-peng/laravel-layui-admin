<?php

namespace Moell\LayuiAdmin\Database;

use Illuminate\Database\Seeder;
use Moell\LayuiAdmin\Models\AdminUser;
use Moell\LayuiAdmin\Models\Navigation;
use Moell\LayuiAdmin\Models\PermissionGroup;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class LayuiAdminTableSeeder extends Seeder
{
    private $permissions = [
        [
            'name' => 'admin-user.index',
            'display_name' => '列表',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.create',
            'display_name' => '创建页',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.show',
            'display_name' => '详细',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.store',
            'display_name' => '保存',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.edit',
            'display_name' => '编辑页',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.update',
            'display_name' => '更新',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.destroy',
            'display_name' => '删除',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.roles',
            'display_name' => '角色列表',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.assign-roles',
            'display_name' => '分配角色',
            'pg_id' => 1
        ],
        [
            'name' => 'admin-user.assign-roles-form',
            'display_name' => '分配角色页面',
            'pg_id' => 1,
        ],
        [
            'name' => 'role.index',
            'display_name' => '角色列表',
            'pg_id' => 2
        ],
        [
            'name' => 'role.show',
            'display_name' => '详细',
            'pg_id' => 2
        ],
        [
            'name' => 'role.create',
            'display_name' => '创建页',
            'pg_id' => 2
        ],
        [
            'name' => 'role.store',
            'display_name' => '保存',
            'pg_id' => 2
        ],
        [
            'name' => 'role.edit',
            'display_name' => '编辑页',
            'pg_id' => 2
        ],
        [
            'name' => 'role.update',
            'display_name' => '更新',
            'pg_id' => 2
        ],
        [
            'name' => 'role.destroy',
            'display_name' => '删除',
            'pg_id' => 2
        ],
        [
            'name' => 'role.assign-permissions',
            'display_name' => '角色分配权限',
            'pg_id' => 2
        ],
        [
            'name' => 'role.assign-permissions-form',
            'display_name' => '角色分配权限页',
            'pg_id' => 2
        ],
        [
            'name' => 'permission.index',
            'display_name' => '列表',
            'pg_id' => 3
        ],
        [
            'name' => 'permission.show',
            'display_name' => '详细',
            'pg_id' => 3
        ],
        [
            'name' => 'permission.create',
            'display_name' => '创建页',
            'pg_id' => 3
        ],
        [
            'name' => 'permission.store',
            'display_name' => '保存',
            'pg_id' => 3
        ],
        [
            'name' => 'permission.edit',
            'display_name' => '编辑页',
            'pg_id' => 3
        ],
        [
            'name' => 'permission.update',
            'display_name' => '更新',
            'pg_id' => 3
        ],
        [
            'name' => 'permission.destroy',
            'display_name' => '删除',
            'pg_id' => 3
        ],
        [
            'name' => 'navigation.index',
            'display_name' => '列表',
            'pg_id' => 4
        ],
        [
            'name' => 'navigation.show',
            'display_name' => '详细',
            'pg_id' => 4
        ],
        [
            'name' => 'navigation.create',
            'display_name' => '创建页',
            'pg_id' => 4
        ],
        [
            'name' => 'navigation.store',
            'display_name' => '保存',
            'pg_id' => 4
        ],
        [
            'name' => 'navigation.edit',
            'display_name' => '编辑页',
            'pg_id' => 4
        ],
        [
            'name' => 'navigation.update',
            'display_name' => '更新',
            'pg_id' => 4
        ],
        [
            'name' => 'navigation.destroy',
            'display_name' => '删除',
            'pg_id' => 4
        ],
        [
            'name' => 'permission-group.index',
            'display_name' => '列表',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.show',
            'display_name' => '详细',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.create',
            'display_name' => '创建页',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.store',
            'display_name' => '保存',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.edit',
            'display_name' => '编辑页',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.update',
            'display_name' => '更新',
            'pg_id' => 5
        ],
        [
            'name' => 'permission-group.destroy',
            'display_name' => '删除',
            'pg_id' => 5
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @author moell<moel91@foxmail.com>
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        $this->createdAdminUser();

        $this->createPermissionGroup();

        $this->createRole();

        $this->createPermission();

        $this->createNavigation();

        $this->associateRolePermissions();
    }

    /**
     * @author moell<moel91@foxmail.com>
     */
    private function createdAdminUser()
    {
        AdminUser::query()->truncate();

        AdminUser::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        ]);
    }

    /**
     * @author moell<moel91@foxmail.com>
     */
    private function createPermission()
    {
        Permission::query()->delete();

        foreach ($this->permissions as $permission) {
            $permission['guard_name'] = 'admin';
            Permission::create($permission);
        }
    }

    /**
     * @author moell<moel91@foxmail.com>
     */
    private function createPermissionGroup()
    {
        PermissionGroup::truncate();
        PermissionGroup::insert([
            [
                'id'    => 1,
                'name'  => '管理员',
            ], [
                'id'    => 2,
                'name'  => '角色'
            ], [
                'id'    => 3,
                'name'  => '权限'
            ], [
                'id'    => 4,
                'name'  => '导航'
            ], [
                'id'    => 5,
                'name'  => '权限组'
            ]
        ]);
    }

    /**
     * @author moell<moel91@foxmail.com>
     */
    private function createRole()
    {
        Role::query()->delete();
        Role::create([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
    }

    /**
     * @author moell<moel91@foxmail.com>
     */
    private function createNavigation()
    {
        Navigation::truncate();
        Navigation::insert([
            [
                'id'        => 1,
                'parent_id' => 0,
                'uri'       => '/admin',
                'name'      => '设置',
                'permission_name' => null,
                'icon'      => '&#xe726;',
                'guard_name'=> "admin"
            ],
            [
                'id'        => 2,
                'parent_id' => 1,
                'uri'       => '/admin/admin-user',
                'name'      => '管理员',
                'permission_name' => 'admin-user.index',
                'icon'      => '',
                'guard_name'=> "admin"
            ],
            [
                'id'        => 3,
                'parent_id' => 1,
                'uri'       => '/admin/role',
                'name'      => '角色',
                'permission_name' => 'role.index',
                'icon'      => '',
                'guard_name'=> "admin"
            ],
            [
                'id'        => 4,
                'parent_id' => 1,
                'uri'       => '/admin/permission',
                'name'      => '权限',
                'permission_name' => 'permission.index',
                'icon'      => '',
                'guard_name'=> "admin"
            ],
            [
                'id'        => 5,
                'parent_id' => 1,
                'uri'       => '/admin/permission-group',
                'name'      => '权限组别',
                'permission_name' => 'permission-group.index',
                'icon'      => '',
                'guard_name'=> "admin"
            ],
            [
                'id'        => 6,
                'parent_id' => 1,
                'uri'       => '/admin/navigation',
                'name'      => '导航菜单',
                'permission_name' => 'navigation.index',
                'icon'      => '',
                'guard_name'=> "admin"
            ],

        ]);
    }

    /**
     * @author moell<moel91@foxmail.com>
     */
    private function associateRolePermissions()
    {
        $role = Role::first();

        AdminUser::query()->first()->assignRole($role->name);

        foreach ($this->permissions as $permission) {
            $role->givePermissionTo($permission['name']);
        }
    }
}
