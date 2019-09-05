@section("title", "角色")

@extends("admin::layouts.admin")

@section("breadcrumb")
    <div class="admin-breadcrumb">
         <span class="layui-breadcrumb">
            <a href="{{ route("admin-user.index") }}">角色</a>
        </span>
    </div>
@endsection
@section("content")
    <div class="layui-card-body ">
        <form class="layui-form layui-col-space5" id="search-form">
            <div class="layui-inline layui-show-xs-block">
                <input type="text" name="name"  placeholder="请输名称" value="{{ request("name") }}" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline layui-show-xs-block">
                @inject("permissionGroupPresenter", "Moell\LayuiAdmin\Presenters\PermissionGroupPresenter")
                {!! $permissionGroupPresenter->makeSelect(request("pg_id")) !!}
            </div>
            <div class="layui-inline layui-show-xs-block">
                <select name="guard_name">
                    <option value="">请选择Guard</option>
                    {!! admin_enum_option_string("guard_names", request("guard_name")) !!}
                </select>
            </div>
            <div class="layui-inline layui-show-xs-block">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </form>
    </div>
    <div class="layui-card-body ">
        <script type="text/html" id="toolbar">
            <div class="layui-btn-container">
                @if(admin_user_can("permission.create"))
                <a class="layui-btn layui-btn-sm" onclick="admin.openLayerForm('{{ route("permission.create") }}', '添加', 'POST', '600px', '500px')"><i class="layui-icon"></i>添加</a>
                @endif
            </div>
        </script>
        <table  lay-filter="table-hide" style="display: none" lay-data="{height:'full-310', cellMinWidth: 80,toolbar: '#toolbar', limit: {{ $permissions->perPage() }} }">
            <thead>
            <tr>
                <th lay-data="{field:'name'}">权限名</th>
                <th lay-data="{field:'display_name'}">权限名称</th>
                <th lay-data="{field:'permission_group_name'}">权限组</th>
                <th lay-data="{field:'guard_name'}">Guard Name</th>
                <th lay-data="{field:'sequence'}">排序</th>
                <th lay-data="{field:'description'}">描述</th>
                <th lay-data="{field:'created_at'}">创建时间</th>
                <th lay-data="{field:'updated_at'}">更新时间</th>
                <th lay-data="{field:'id', fixed: 'right', align:'center'}">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>{{ $permission->display_name }}</td>
                    <td>{{ optional($permission->group)->name }}</td>
                    <td>{{ $permission->guard_name }}</td>
                    <td>{{ $permission->sequence }}</td>
                    <td>{{ $permission->description }}</td>
                    <td>{{ $permission->created_at }}</td>
                    <td>{{ $permission->updated_at }}</td>
                    <td>
                        @if(admin_user_can("permission.edit"))
                            <a class="layui-btn layui-btn-xs"
                                onclick="admin.openLayerForm('{{ route("permission.edit", ['permission' => $permission->id]) }}', '编辑', 'PATCH', '600px', '500px')">编辑</a>
                        @endif
                        @if(admin_user_can('permission.destroy'))
                            <a class="layui-btn layui-btn-xs layui-btn-danger"
                                onclick="admin.tableDataDelete('{{ route("permission.destroy", ['permission' => $permission->id]) }}', this)">删除</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div id="page"></div>
    </div>
@endsection

@section("script")
    <script>
      layui.use(['form', 'table'], function(){

        var table = layui.table;
        table.init("table-hide");

        admin.paginate("{{ $permissions->total() }}", "{{ $permissions->currentPage() }}","{{ $permissions->perPage() }}");
      });
    </script>
@endsection