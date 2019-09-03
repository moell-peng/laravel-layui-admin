@section("title", "添加")

@extends("admin::layouts.admin")

@section("breadcrumb")
    <div class="admin-breadcrumb">
         <span class="layui-breadcrumb">
            <a href="{{ route("admin-user.index") }}">管理员列表</a>
            <a><cite>创建</cite></a>
        </span>
    </div>
@endsection

@section("content")
    <div class="layui-card-body ">
        <form class="layui-form" method="post" action="{{ route("admin-user.store") }}" id="layer-form">
            @csrf
            <div class="layui-form-item">
                <label class="layui-form-label">姓名</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required value="{{ old("name") }}"  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="email" required value="{{ old("email") }}"  lay-verify="email" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">密码框</label>
                <div class="layui-input-inline">
                    <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">不少于八位</div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="create">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section("script")
    <script>
      layui.use(['form'], function(){
        var form = layui.form;
        form.on("submit(create)", function () {
            console.log("test");
        })
      });
    </script>
@endsection