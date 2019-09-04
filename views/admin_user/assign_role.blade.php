<div class="layui-card-body ">
    <form class="layui-form" method="post" action="{{ route("admin-user.assign-roles", ['id' => $adminUser->id]) }}" id="layer-form">
        @csrf
        @foreach($roles as $role)
            <div class="layui-col-sm4">
                <input type="checkbox"
                       name="roles[]"
                       lay-skin="primary"
                       {{ $userRoles->contains($role->name) ? "checked" : "" }}
                       value="{{ $role->name }}"
                       title="{{ $role->name }}">
            </div>
        @endforeach
    </form>
</div>