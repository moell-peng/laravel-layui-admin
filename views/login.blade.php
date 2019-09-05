<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>登录</title>
    <link rel="stylesheet" href="{{ asset('vendor/laravel-layui-admin/lib/layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/laravel-layui-admin/css/admin.css') }}">
</head>
<body class="layui-layout-body" style="background: #20262e;">
<canvas class="background" ></canvas>
<div id="admin-login">
    <form class="layui-form" action="">
        <h2>{{ config("admin.system_name") }}</h2>
        <div class="layui-form-item">
            <label class="layui-form-label">登录邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" required  lay-verify="email" placeholder="请输入登录邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
                <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="login">登录</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('vendor/laravel-layui-admin/lib/layui/layui.js') }}"></script>
<script src="{{ asset('vendor/laravel-layui-admin/js/admin.js') }}"></script>
<script src="{{ asset('vendor/laravel-layui-admin/js/particles.min.js') }}"></script>
<script>
  window.onload = function() {
    Particles.init({
      selector: '.background',
      color: '#ffffff',
      maxParticles: 80,
      connectParticles: true,
      responsive: [
        {
          breakpoint: 768,
          options: {
            maxParticles: 80
          }
        }, {
          breakpoint: 375,
          options: {
            maxParticles: 50
          }
        }
      ]
    });
  }
  //JavaScript代码区域
  layui.use('form', function(){
    var form = layui.form;
    var $ = layui.$;

    form.on('submit(login)', function(data){
      $.post("{{ route("admin.login") }}", data.field, function(response) {
        if (response.status === 'success') {
          layui.layer.msg(response.message, {time: 2000, icon: 6});
          window.location = "{{ route("admin.index") }}";
        } else {
          layui.layer.msg(response.message, {time: 3000, icon: 5});
        }
      })
      return false;
    });
  });
</script>
</body>
</html>