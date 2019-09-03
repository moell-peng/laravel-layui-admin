<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Moell\LayuiAdmin\Models\AdminUser;

class IndexController extends Controller
{
    public function index()
    {
        $adminUser = AdminUser::query()->first();
        Auth::guard('admin')->login($adminUser);
        return view("admin::layouts.admin");
    }
}