<?php

namespace Moell\LayuiAdmin\Http\Controllers;


class LoginController extends Controller
{
    public function loginShowForm()
    {
        return view("admin::login");
    }

    public function login()
    {

    }
}