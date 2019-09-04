<div class="layui-card-body">
    <form class="layui-form" method="post" action="{{ route("navigation.store") }}" id="layer-form">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" required value=""  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">上级菜单ID</label>
            <div class="layui-input-block">
                <input type="text" name="parent_id" required value="0"  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">URI</label>
            <div class="layui-input-block">
                <input type="text" name="uri" required value=""  lay-verify="required" placeholder="请输入导航链接" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Guard</label>
            <div class="layui-input-block">
                <select name="guard_name" lay-verify="required">
                    <option value=""></option>
                    {!! admin_enum_option_string("guard_names") !!}
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">导航类型</label>
            <div class="layui-input-block">
                <input type="text" name="type" required value="admin"  lay-verify="required" placeholder="请输入导航类型" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">关联权限</label>
            <div class="layui-input-block">
                <input type="text" name="permission_name" required value=""  lay-verify="required" placeholder="请输入关联权限" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">icon</label>
            <div class="layui-input-block">
                <input type="text" name="icon" required value=""  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sequence" required value="0"  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
            </div>
        </div>
    </form>
</div>