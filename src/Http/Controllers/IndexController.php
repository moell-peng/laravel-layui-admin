<?php

namespace Moell\LayuiAdmin\Http\Controllers;


class IndexController extends Controller
{
    public function index()
    {
        return view("admin::layouts.admin");
    }
}