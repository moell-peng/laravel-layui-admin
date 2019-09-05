@section("title", "管理员管理")

@extends("admin::layouts.admin")

@section("breadcrumb")
    <div class="admin-breadcrumb">
         <span class="layui-breadcrumb">
            <a href="{{ route("admin-user.index") }}">管理员列表</a>
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
                <input type="text" name="email"  placeholder="请输邮箱" value="{{ request("email") }}" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-inline layui-show-xs-block">
                <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
            </div>
        </form>
    </div>
    <div class="layui-card-body ">
        <script type="text/html" id="toolbar">
            <div class="layui-btn-container">
                @if(admin_user_can("admin-user.create"))
                    <a class="layui-btn layui-btn-sm" onclick="admin.openLayerForm('{{ route("admin-user.create") }}', '添加', 'POST', '500px', '350px')"><i class="layui-icon"></i>添加</a>
                @endif
            </div>
        </script>
        <script type="text/html" id="table-action">
            <div class="layui-btn-container">
                <a class="layui-btn layui-btn-xs" data-href="{{ route("admin-user.create") }}" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-xs layui-btn-danger" data-href="{{ route("admin-user.create") }}" lay-event="delete">删除</a>
            </div>
        </script>
        <table  lay-filter="table-hide" style="display: none" lay-data="{height:'full-310', cellMinWidth: 80,toolbar: '#toolbar', limit: {{ $adminUsers->perPage() }} }">
            <thead>
            <tr>
                <th lay-data="{field:'name'}">名称</th>
                <th lay-data="{field:'email'}">邮箱</th>
                <th lay-data="{field:'status'}">状态</th>
                <th lay-data="{field:'created_at'}">创建时间</th>
                <th lay-data="{field:'updated_at'}">更新时间</th>
                <th lay-data="{field:'id', fixed: 'right', width:200, align:'center'}">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($adminUsers as $adminUser)
                <tr>
                    <td>{{ $adminUser->name }}</td>
                    <td>{{ $adminUser->email }}</td>
                    <td>{{ $adminUser->status == 0 ? '启用' : '禁用' }}</td>
                    <td>{{ $adminUser->created_at }}</td>
                    <td>{{ $adminUser->updated_at }}</td>
                    <td>
                        @if(admin_user_can("admin-user.edit"))
                            <a class="layui-btn layui-btn-xs"
                                onclick="admin.openLayerForm('{{ route("admin-user.edit", ['admin_user' => $adminUser->id]) }}', '编辑', 'PATCH', '500px', '350px')">编辑</a>
                        @endif
                        @if(admin_user_can("admin-user.assign-roles-form"))
                                <a class="layui-btn layui-btn-xs"
                                   onclick="admin.openLayerForm('{{ route("admin-user.assign-roles-form", ['id' => $adminUser->id]) }}', '分配角色', 'PUT', '600px', '350px', true)">分配角色</a>
                        @endif
                        @if(admin_user_can("admin-user.destroy"))
                                <a class="layui-btn layui-btn-xs layui-btn-danger"
                                   onclick="admin.tableDataDelete('{{ route("admin-user.destroy", ['admin_user' => $adminUser->id]) }}', this)">删除</a>
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

        table.on("tool(table-hide)", function(obj) {
          console.log(obj);
            switch (obj.event) {
              case 'edit':
                console.log(obj.data);
                break;
              case 'delete':
                console.log(obj.data);
                break;
            }
        });

        admin.paginate("{{ $adminUsers->total() }}", "{{ $adminUsers->currentPage() }}","{{ $adminUsers->perPage() }}");
      });
    </script>
@endsection