<?php

namespace Moell\LayuiAdmin\Http\Controllers;

use Illuminate\Http\Request;
use Moell\LayuiAdmin\Http\Requests\Role\CreateOrUpdateRequest;
use Moell\LayuiAdmin\Models\PermissionGroup;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @author moell<moell91@foxmail.com>
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $roles = Role::query()->where(request_intersect(['name']))->paginate($request->get("limit"));

        return view("admin::role.index", compact("roles"));
    }

    public function show($id)
    {
        return new RoleResource(Role::query()->findOrFail($id));
    }

    public function create()
    {
        return view('admin::role.create');
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrUpdateRequest $request)
    {
        Role::create(request_intersect([
            'name', 'guard_name', 'description'
        ]));

        return $this->success();
    }

    public function edit(Role $role)
    {
        return view("admin::role.edit", compact("role"));
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        if (Role::where(request_intersect(['name', 'guard_name']))->where('id', '!=', $id)->count()) {
            throw RoleAlreadyExists::create($request->name, $request->guard_name);
        }

        $role = Role::query()->findOrFail($id);

        $role->update(request_intersect([
            'name', 'guard_name', 'description'
        ]));

        return $this->success();
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Role::destroy($id);

        return $this->success();
    }

    public function assignPermissionsForm(Request $request, $id)
    {
        $role = Role::query()->findOrFail($id);

        $permissionGroups = PermissionGroup::query()
            ->with(['permission' => function ($query) use ($role) {
                $query->where('guard_name', $role->guard_name);
            }])
            ->get()->filter(function($item)  {
                return count($item->permission) > 0;
            });

        $rolePermissions = $role->getPermissionNames();

        return view("admin::role.assign_permission", compact("role", "permissionGroups", 'rolePermissions'));
    }

    /**
     * Assign permission
     *
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @param Request $request
     * @return $this
     */
    public function assignPermissions($id, Request $request)
    {
        $role = Role::query()->findOrFail($id);

        $role->syncPermissions($request->input('permissions', []));

        return redirect()->back()->with("success", "分配权限成功");
    }
}