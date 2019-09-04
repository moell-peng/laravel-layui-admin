<div class="layui-card-body ">
    <form class="layui-form" method="post" action="{{ route("permission-group.store") }}" id="layer-form">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" required value="{{ old("name") }}"  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
            </div>
        </div>
    </form>
</div>