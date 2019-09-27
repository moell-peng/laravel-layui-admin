<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Moell\LayuiAdmin\Http\Requests\Navigation\CreateOrUpdateRequest;
use Moell\LayuiAdmin\Models\Navigation;

class NavigationController extends Controller
{
    /**
     * @author moell<moell91@foxmail.com>
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $where = request_intersect(['type', 'guard_name']);
        if (!isset($where['guard_name']) || !$where['guard_name']) {
            $where['guard_name'] = 'admin';
        }

        $navigation = Navigation::query()
            ->where($where)
            ->orderBy('sequence', 'desc')
            ->get()
            ->toJson();

        return view("admin::navigation.index", compact("navigation"));
    }

    public function create()
    {
        return view("admin::navigation.create");
    }

    public function store(CreateOrUpdateRequest $request)
    {
        Navigation::create($request->all());

        return $this->success();
    }

    public function edit(Navigation $navigation)
    {
        return view("admin::navigation.edit", compact("navigation"));
    }

    /**
     * @param CreateOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateOrUpdateRequest $request, $id)
    {
        $navigation = Navigation::query()->findOrFail($id);

        $navigation->update($request->toArray());

        return $this->success();
    }

    public function show($id)
    {

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $navigation = Navigation::query()->findOrFail($id);

        if (Navigation::query()->where('parent_id', $navigation->id)->count()) {
            return $this->unprocesableEtity([
                'parent_id' => 'Please delete the subnavigation first.'
            ]);
        }

        $navigation->delete();

        return $this->success();
    }
}