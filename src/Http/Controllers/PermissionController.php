<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Moell\LayuiAdmin\Http\Requests\Permission\CreateOrUpdateRequest;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Moell\LayuiAdmin\Models\Permission;


class PermissionController extends Controller
{
    /**
     * @author moell<moell91@foxmail.com>
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $permissions =tap(Permission::latest(), function ($query) {
            $query->where(request_intersect([
                'name', 'guard_name', 'pg_id'
            ]));
        })->with('group')->paginate($request->get('limit'));

        return view("admin::permission.index",compact("permissions"));
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @return PermissionResource
     */
    public function show($id)
    {
        return new PermissionResource(Permission::query()->findOrFail($id));
    }

    public function create()
    {
        return view("admin::permission.create");
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrUpdateRequest $request)
    {
        $attributes = $request->only([
            'pg_id', 'name', 'guard_name', 'display_name', 'sequence', 'description'
        ]);

        Permission::create($attributes);

        return $this->success();
    }

    /**
     * @param Permission $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $permission)
    {
        return view("admin::permission.edit", compact("permission"));
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        $permission = Permission::query()->findOrFail($id);

        $attributes = $request->only([
            'pg_id', 'name', 'guard_name', 'display_name', 'sequence', 'description'
        ]);

        $isset = Permission::query()
            ->where(['name' => $attributes['name'], 'guard_name' => $attributes['guard_name']])
            ->where('id', '!=', $id)
            ->count();

        if ($isset) {
            throw PermissionAlreadyExists::create($attributes['name'], $attributes['guard_name']);
        }

        $permission->update($attributes);

        return $this->success();
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        permission::query()->findOrFail($id)->delete();

        return $this->success();
    }
}