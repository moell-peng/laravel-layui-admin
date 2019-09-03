<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Auth;
use Illuminate\Http\Response;
use Moell\LayuiAdmin\AdminUserFactory;
use Moell\LayuiAdmin\Http\Requests\AdminUser\CreateOrUpdateRequest;
use Moell\LayuiAdmin\Models\AdminUser;
use Moell\LayuiAdmin\Models\Permission;
use Moell\LayuiAdmin\Resources\AdminUser as AdminUserResource;
use Moell\LayuiAdmin\Resources\AdminUserCollection;
use Moell\LayuiAdmin\Resources\RoleCollection;

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
     * @author moell<moel91@foxmail.com>
     * @param $id
     * @return AdminUserResource
     */
    public function show($id)
    {
        return new AdminUserResource($this->adminUserModel->findOrFail($id));
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
     * @return Response
     */
    public function store(CreateOrUpdateRequest $request)
    {
        $data = $request->only([
            'name', 'email', 'password'
        ]);
        $data['password'] = bcrypt($data['password']);

        AdminUser::create($data);

        return $this->noContent();
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
     *
     * @param CreateOrUpdateRequest $request
     * @param AdminUser $adminUser
     * @return Response
     */
    public function update(CreateOrUpdateRequest $request, AdminUser $adminUser)
    {
        $data = request_intersect([
            'name'
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $adminUser->fill($data);
        $adminUser->save();

        return $this->noContent();
    }

    /**
     * @author moell<moel91@foxmail.com>
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $adminUser = AdminUser::query()->findOrFail($id);

        $adminUser->delete();

        return $this->noContent();
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @param $provider
     * @return RoleCollection
     */
    public function roles($id, $provider)
    {
        $user = $this->getProviderModel($provider)->findOrFail($id);

        return new RoleCollection($user->roles);
    }

    /**
     * @author moell<moell91@foxmail.com>
     * @param $id
     * @param $provider
     * @param Request $request
     * @return Response
     */
    public function assignRoles($id, $provider, Request $request)
    {
        $user = $this->getProviderModel($provider)->findOrFail($id);

        $user->syncRoles($request->input('roles', []));

        return $this->noContent();
    }

    /**
     * @param $provider
     * @return Illuminate\Foundation\Auth\User
     */
    private function getProviderModel($provider)
    {
        return app(config('auth.providers.' . $provider . '.model'));
    }
}