<?php

$router = app('router');

$router->namespace('\Moell\LayuiAdmin\Http\Controllers')
    ->prefix('admin')
    ->middleware(['web'])
    ->group(function ($router) {
        $router->get("/", "IndexController@index")->name("admin.index");
        $router->get("login", "AuthController@loginShowForm")->name("admin.login-show-form");
        $router->resource('role', 'RoleController');

        $router->get('role/{id}/permissions', 'RoleController@permissions')->name('role.permissions');

        $router->put('role/{id}/permissions', 'RoleController@assignPermissions')->name('role.assign-permissions');

        $router->get('guard-name-roles/{guardName}', 'RoleController@guardNameRoles')->name('role.guard-name-roles');

        $router->resource('permission', 'PermissionController');

        $router->resource('admin-user', 'AdminUserController');

        $router->get('admin-user/{id}/roles/{provider}', 'AdminUserController@roles')->name('admin-user.roles');

        $router->put('admin-user/{id}/roles/{provider}', 'AdminUserController@assignRoles')->name('admin-user.assign-roles');

        $router->resource('permission-group', 'PermissionGroupController');

        $router->get('guard-name-for-permissions/{guardName}', 'PermissionGroupController@guardNameForPermissions')
            ->name('permission-group.guard-name-for-permission');

        $router->get("permission-group-all", "PermissionGroupController@all")->name("permission-group.all");

        $router->resource('menu', 'MenuController', ['only' =>
            ['index', 'show', 'store', 'update', 'destroy']
        ]);

    });

/*$router->namespace('\Moell\LayuiAdmin\Http\Controllers')
    ->prefix('api')
    ->middleware(['api', config('LayuiAdmin.super_admin.auth') . ',' . config('LayuiAdmin.multi_auth_guards'), 'LayuiAdmin.permission'])
    ->group(function ($router) {
        $router->get('permission-user-all', 'PermissionController@allUserPermission')->name('permission.all-user-permission');

        $router->get('my-menu', 'MenuController@my')->name('menu.my');

        $router->patch('user-change-password', 'ChangePasswordController@changePassword')->name('user.change-password');
    });

$router->namespace('\Moell\LayuiAdmin\Http\Controllers')->middleware('web')->group(function ($router) {
    $router->view(config('LayuiAdmin.admin_route_path'), 'dashboard');
});

$router->middleware(['api', config('LayuiAdmin.super_admin.auth') . ',' . config('LayuiAdmin.multi_auth_guards')])
    ->patch('api/user-change-password', '\Moell\LayuiAdmin\Http\Controllers\ChangePasswordController@changePassword')->name('user.change-password');*/
