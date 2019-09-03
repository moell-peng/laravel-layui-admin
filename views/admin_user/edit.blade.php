<div class="layui-card-body ">
    <form class="layui-form" method="post" action="{{ route("admin-user.update", ['id' => $adminUser->id]) }}" id="layer-form">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-block">
                <input type="text" name="name" required value="{{ $adminUser->name }}"  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码框</label>
            <div class="layui-input-inline">
                <input type="password" name="password"  placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">不少于八位</div>
        </div>
    </form>
</div>