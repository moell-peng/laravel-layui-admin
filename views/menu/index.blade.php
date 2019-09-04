@section("title", "导航菜单")

@extends("admin::layouts.admin")

@section("breadcrumb")
    <div class="admin-breadcrumb">
         <span class="layui-breadcrumb">
            <a href="{{ route("permission-group.index") }}">导航菜单</a>
        </span>
    </div>
@endsection
@section("content")
    <div class="layui-card-body ">
        <form class="layui-form layui-col-space5" id="search-form">
            <div class="layui-inline layui-show-xs-block">
                <a class="layui-btn layui-btn-sm" onclick="admin.openLayerForm('{{ route("permission-group.create") }}', '添加', 'POST', '400px', '200px')"><i class="layui-icon"></i>添加</a>
            </div>
        </form>
    </div>
    <div class="layui-card-body ">
        <table class="layui-table layui-form"  id="tree-table" lay-size="sm"></table>
    </div>
@endsection

@section("script")
    <script>
      layui.config({
        base: "../vendor/laravel-layui-admin/js/"
      });
      layui.use(['form', 'table', 'treeTable'], function(){
        var table = layui.table;
        var form = layui.form;
        table.init("table-hide");

        var treeTable = layui.treeTable;
        treeTable.render({
          elem: '#tree-table',
          data: {!! $menus !!},
          icon_key: 'name',
          parent_key: "parent_id",
          end: function(e){
            form.render();
          },
          cols: [
            {
              key: 'name',
              title: '名称',
              template: function(item){
                if(item.level == 0){
                  return '<span style="color:red;">'+item.name+'</span>';
                }else if(item.level == 1){
                  return '<span style="color:green;">'+item.name+'</span>';
                }else if(item.level == 2){
                  return '<span style="color:#aaa;">'+item.name+'</span>';
                }
              }
            },
            {
              key: 'uri',
              title: 'URI',
            },
            {
              key: 'permission_name',
              title: '关联权限',
              template: function (item) {
                return item.permission_name ? item.permission_name : '';
              }
            },
            {
              key: 'type',
              title: '菜单类型代码',
              align: 'center',
            },
            {
              key: 'guard_name',
              title: '权限守卫',
              align: 'center',
            },
            {
              key: 'sequence',
              title: '排序',
              align: 'center',
            },
            {
              title: '操作',
              align: 'center',
              template: function(item){
                return '<a lay-filter="add">添加</a> | <a target="_blank" href="/detail?id='+item.id+'">编辑</a>';
              }
            }
          ]
        });
      });
    </script>
@endsection