<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Moell\LayuiAdmin\Http\Requests\PermissionGroup\CreateOrUpdateRequest;
use Moell\LayuiAdmin\Models\PermissionGroup;
use Moell\LayuiAdmin\Models\Permission;
use Moell\LayuiAdmin\Resources\PermissionGroupCollection;
use Moell\LayuiAdmin\Resources\PermissionGroup as PermissionGroupResource;

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
     *  @author moell<moell91@foxmail.com>
     * @param Request $request
     * @return PermissionGroupCollection
     */
    public function all(Request $request)
    {
        $permissionGroups = PermissionGroup::latest()->get();

        return new PermissionGroupCollection($permissionGroups);
    }

    /**
     * @param $guardName
     * @return \Illuminate\Http\JsonResponse
     */
    public function guardNameForPermissions($guardName)
    {
        $permissionGroups = PermissionGroup::query()
            ->with(['permission' => function ($query) use ($guardName) {
                $query->where('guard_name', $guardName);
            }])
            ->get()->filter(function($item)  {
                return count($item->permission) > 0;
            });

        return response()->json([
            'data' => array_values($permissionGroups->toArray())
        ]);
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrUpdateRequest $request)
    {
        PermissionGroup::create(request_intersect(['name']));

        return $this->created();
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @return PermissionGroupResource
     */
    public function show($id)
    {
        return new PermissionGroupResource(PermissionGroup::findOrFail($id));
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        PermissionGroup::findOrFail($id)->update(request_intersect([
            'name'
        ]));

        return $this->noContent();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
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

        return $this->noContent();
    }
}