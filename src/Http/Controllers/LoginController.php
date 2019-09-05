<?php

namespace Moell\LayuiAdmin\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginShowForm()
    {
        return view("admin::login");
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['status'] = 0;

        if (Auth::guard("admin")->attempt($credentials)) {
            return $this->success("登录成功");
        }

        return $this->fail('账号或密码有误');
    }

    public function logout()
    {
        Auth::guard("admin")->logout();

        return redirect()->route("admin.login-show-form");
    }
}