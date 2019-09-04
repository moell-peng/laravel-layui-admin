<?php

namespace Moell\LayuiAdmin\Presenters;


use Moell\LayuiAdmin\Models\PermissionGroup;

class PermissionGroupPresenter
{
    public function makeSelect($default = null)
    {
        $select = '<select name="%s" class="form-control"><option value="">%s</option>%s</select>';
        $options = null;

        $groups = PermissionGroup::query()->get();

        foreach ($groups as $group) {
            $selected = $group->id == $default ? 'selected' : '';
            $options .= sprintf('<option value="%s" %s > %s</option>', $group->id, $selected,  $group->name);
        }

        return sprintf($select, 'pg_id', '请选择权限组别', $options);
    }
}