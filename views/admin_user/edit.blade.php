<div class="layui-card-body ">
    <form class="layui-form" method="post" action="{{ route("admin-user.update", ['admin_user' => $adminUser->id]) }}" id="layer-form">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-block">
                <input type="text" name="name" required value="{{ $adminUser->name }}"  lay-verify="required" placeholder="请输入姓名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <select name="status" lay-verify="required">
                    <option value="0" {{ $adminUser->status == 0 ? "selected" : '' }}>启用</option>
                    <option value="1" {{ $adminUser->status == 1 ? "selected" : '' }}>禁用</option>
                </select>
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