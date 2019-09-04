<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Moell\LayuiAdmin\Http\Requests\PermissionGroup\CreateOrUpdateRequest;
use Moell\LayuiAdmin\Models\PermissionGroup;
use Moell\LayuiAdmin\Models\Permission;

class PermissionGroupController extends Controller
{

    /**
     * @author moell<moell91@foxmail.com>
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $permissionGroups = tap(PermissionGroup::latest(), function ($query) {
            $query->where(request_intersect(['name']));
        })->paginate($request->get("limit"));

        return view("admin::permission_group.index", compact("permissionGroups"));
    }

    public function create()
    {
        return view("admin::permission_group.create");
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrUpdateRequest $request)
    {
        PermissionGroup::create(request_intersect(['name']));

        return $this->success();
    }

    public function edit(PermissionGroup $permissionGroup)
    {
        return view("admin::permission_group.edit", compact("permissionGroup"));
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        PermissionGroup::findOrFail($id)->update(request_intersect([
            'name'
        ]));

        return $this->success();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $permissionGroup = PermissionGroup::findOrFail($id);

        if (Permission::query()->where('pg_id', $permissionGroup->id)->count()) {
            return $this->unprocesableEtity([
                'pg_id' => 'Please move or delete the vesting permission.'
            ]);
        }

        $permissionGroup->delete();

        return $this->success();
    }
}