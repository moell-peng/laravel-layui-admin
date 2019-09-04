@section("title", "分配权限")

@extends("admin::layouts.admin")

@section("breadcrumb")
    <div class="admin-breadcrumb">
         <span class="layui-breadcrumb">
            <a href="{{ route("role.index") }}">角色</a>
             <a><cite>分配权限</cite></a>
        </span>
    </div>
@endsection
@section("content")
    <div class="layui-card-body">
        <form class="layui-form" method="post" action="{{ route("role.assign-permissions", ['id' => $role->id]) }}" id="layer-form">
            @csrf
            @method("PUT")
            @foreach($permissionGroups as $group)
                <div class="layui-card">
                    <div class="layui-card-header">
                        <input type="checkbox" lay-skin="primary" lay-filter="father">
                        {{ $group->name }}
                    </div>
                    <div class="layui-card-body">
                        <div class="layui-row">
                            @foreach($group->permission as $permission)
                                <div class="layui-col-sm4">
                                    <input type="checkbox"
                                           onclick="alert(this)"
                                           name="permissions[]"
                                           lay-skin="primary"
                                           {{ $rolePermissions->contains($permission->name) ? "checked" : "" }}
                                           value="{{ $permission->name }}"
                                           title="{{ $permission->display_name }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-sm" lay-submit="">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">重置</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section("script")
    <script>
      layui.use(['form'], function(){
        var form = layui.form;
        form.on('checkbox(father)', function(data){
          if(data.elem.checked){
            $(data.elem).parent().siblings('.layui-card-body').find('input').prop("checked", true);
            form.render();
          }else{
            $(data.elem).parent().siblings('.layui-card-body').find('input').prop("checked", false);
            form.render();
          }
        });
      });
    </script>
@endsection
