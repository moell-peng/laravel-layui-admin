<div class="layui-card-body ">
    <form class="layui-form" method="post" action="{{ route("permission.update", ['permission' => $permission->id]) }}" id="layer-form">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" required value="{{ $permission->name }}"  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">显示名称</label>
            <div class="layui-input-block">
                <input type="text" name="display_name" value="{{ $permission->display_name }}" required  lay-verify="required" placeholder="请输入显示名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限组别</label>
            <div class="layui-input-block">
                @inject("permissionGroupPresenter", "Moell\LayuiAdmin\Presenters\PermissionGroupPresenter")
                {!! $permissionGroupPresenter->makeSelect($permission->pg_id) !!}
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Guard</label>
            <div class="layui-input-block">
                <select name="guard_name" lay-verify="required">
                    <option value=""></option>
                    {!! admin_enum_option_string("guard_names", $permission->guard_name) !!}
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="text" name="sequence" value="{{ $permission->sequence }}" required  lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <textarea name="description" placeholder="请输入内容" class="layui-textarea">{{ $permission->description }}</textarea>
            </div>
        </div>
    </form>
</div>