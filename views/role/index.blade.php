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
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </form>
    </div>
    <div class="layui-card-body ">
        <script type="text/html" id="toolbar">
            <div class="layui-btn-container">
                @if(admin_user_can("role.create"))
                    <a class="layui-btn layui-btn-sm" onclick="admin.openLayerForm('{{ route("role.create") }}', '添加', 'POST', '500px', '350px')"><i class="layui-icon"></i>添加</a>
                @endif
            </div>
        </script>
        <table  lay-filter="table-hide" style="display: none" lay-data="{height:'full-310', cellMinWidth: 80,toolbar: '#toolbar', limit: {{ $roles->perPage() }} }">
            <thead>
            <tr>
                <th lay-data="{field:'name'}">名称</th>
                <th lay-data="{field:'guard_name'}">Guard Name</th>
                <th lay-data="{field:'created_at'}">创建时间</th>
                <th lay-data="{field:'updated_at'}">更新时间</th>
                <th lay-data="{field:'id', fixed: 'right', align:'center'}">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->guard_name }}</td>
                    <td>{{ $role->created_at }}</td>
                    <td>{{ $role->updated_at }}</td>
                    <td>
                        @if(admin_user_can("role.edit"))
                            <a class="layui-btn layui-btn-xs"
                               onclick="admin.openLayerForm('{{ route("role.edit", ['role' => $role->id]) }}', '编辑', 'PATCH', '500px', '350px')">编辑</a>
                        @endif
                        @if(admin_user_can("role.assign-permissions-form"))
                            <a class="layui-btn layui-btn-xs"
                               href="{{ route("role.assign-permissions-form", ['id' => $role->id]) }}">分配权限</a>
                        @endif
                        @if(admin_user_can("role.destroy"))
                            <a class="layui-btn layui-btn-xs layui-btn-danger"
                               onclick="admin.tableDataDelete('{{ route("role.destroy", ['role' => $role->id]) }}', this)">删除</a>
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

        admin.paginate("{{ $roles->total() }}", "{{ $roles->currentPage() }}","{{ $roles->perPage() }}");
      });
    </script>
@endsection