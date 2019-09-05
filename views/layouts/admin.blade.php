<!DOCTYPE html>
<html id="admin">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendor/laravel-layui-admin/lib/layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/laravel-layui-admin/css/admin.css') }}">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <a href="{{ route("admin.index") }}">
            <div class="layui-logo">{{ config("admin.system_name") }}</div>
        </a>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="/vendor/laravel-layui-admin/images/30.jpeg" class="layui-nav-img">
                    {{ auth("admin")->user()->name }}
                </a>
                <dl class="layui-nav-child">
                    <dd><a onclick="admin.openLayerForm('{{ route("admin.change-password-form") }}', '修改密码', 'PATCH', '500px', '300px')">修改密码</a></dd>
                    <dd><a href="{{ route("admin.logout") }}">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                @foreach($navigation as $topNav)
                    @if(isset($topNav['children']) && $topNav['children'])
                        <li class="layui-nav-item">
                            <a class="" href="javascript:;">{{ $topNav['name'] }}</a>
                            <dl class="layui-nav-child">
                                @foreach ($topNav['children'] as $children)
                                    <dd class="{{ request()->path() == trim($children['uri'], '/') ? 'layui-this' : '' }}"><a href="{{ $children['uri']  }}">{{ $children['name'] }}</a></dd>
                                @endforeach
                            </dl>
                        </li>
                        @else
                        <li class="layui-nav-item"><a href="{{ $topNav['uri'] }}">{{ $topNav['name'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div class="layui-body">
        @yield("breadcrumb")
        <div class="layui-fluid" style="margin-top: 10px;">
            <div class="layui-row">
                <div class="layui-col-md12">
                    @include('admin::message')
                    <div class="layui-card">
                        @yield("content")
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="layui-footer">
        ©
        <a href="https://github.com/moell-peng/laravel-layui-admin" target="_blank">
            moell/laravel-layui-admin
        </a>
    </div>
</div>
<script src="{{ asset('vendor/laravel-layui-admin/lib/layui/layui.js') }}"></script>
<script src="{{ asset('vendor/laravel-layui-admin/js/admin.js') }}"></script>
@yield("script")
<script>
  //JavaScript代码区域
  layui.use('element', function(){
    var element = layui.element;
  });
</script>
</body>
</html>