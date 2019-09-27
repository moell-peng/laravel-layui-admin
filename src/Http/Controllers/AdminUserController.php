<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Moell\LayuiAdmin\Http\Requests\AdminUser\CreateOrUpdateRequest;
use Moell\LayuiAdmin\Models\AdminUser;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * @author moell<moel91@foxmail.com>
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $adminUsers = AdminUser::query()->where(request_intersect(['name', 'email']))->paginate($request->get("limit"));

        return view("admin::admin_user.index", compact('adminUsers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view("admin::admin_user.create");
    }

    /**
     * @param CreateOrUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrUpdateRequest $request)
    {
        $data = $request->only([
            'name', 'email', 'password'
        ]);
        $data['password'] = bcrypt($data['password']);

        AdminUser::create($data);

        return $this->success();
    }

    /**
     * @param AdminUser $adminUser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AdminUser $adminUser)
    {
        return view("admin::admin_user.edit", compact('adminUser'));
    }

    /**
     * @author moell<moel91@foxmail.com>
     * @param CreateOrUpdateRequest $request
     * @param AdminUser $adminUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateOrUpdateRequest $request, AdminUser $adminUser)
    {
        $data = $request->only([
            'name', 'status'
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $adminUser->fill($data);
        $adminUser->save();

        return $this->success();
    }

    /**
     * @author moell<moel91@foxmail.com>
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $adminUser = AdminUser::query()->findOrFail($id);

        $adminUser->delete();

        return $this->success();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function assignRolesForm($id)
    {
        $adminUser = AdminUser::query()->findOrFail($id);
        $roles = Role::query()->where("guard_name", "admin")->get();
        $userRoles = $adminUser->getRoleNames();

        return view("admin::admin_user.assign_role", compact("roles", "adminUser", "userRoles"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignRoles(Request $request, $id)
    {
        AdminUser::query()->findOrFail($id)->syncRoles($request->input('roles', []));

        return $this->success();
    }
}