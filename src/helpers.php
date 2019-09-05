<?php

if (!function_exists('request_intersect')) {
    /**
     * request intersect
     *
     * @param $keys
     * @return array|ø
     */
    function request_intersect($keys) {
        return array_filter(request()->only(is_array($keys) ? $keys : func_get_args()));
    }
}

if (!function_exists('make_tree')) {
    /**
     * @param array $list
     * @param int $parentId
     * @return array
     */
    function make_tree(array $list, $parentId = 0) {
        $tree = [];
        if (empty($list)) {
            return $tree;
        }

        $newList = [];
        foreach ($list as $k => $v) {
            $newList[$v['id']] = $v;
        }
        
        foreach ($newList as $value) {
            if ($parentId == $value['parent_id']) {
                $tree[] = &$newList[$value['id']];
            } elseif (isset($newList[$value['parent_id']])) {
                $newList[$value['parent_id']]['children'][] = &$newList[$value['id']];
            }
        }

        return $tree;
    }
}

if (!function_exists('admin_enum_index_value')) {
    /**
     *
     * @param $field
     * @param $index
     * @return mixed|null
     */
    function admin_enum_index_value($field, $index) {
        $config = config("admin." . $field);

        return isset($config[$index]) ? $config[$index] : null;
    }
}

if (!function_exists("admin_enum_option_string")) {
    /**
     * @param $field
     * @param null $default
     * @return null|string
     */
    function admin_enum_option_string($field, $default = null) {
        $options = null;

        $items = config("admin." . $field);
        if (!$items) {
            return $options;
        }

        foreach ($items as $index => $value) {
            $checked = $index == $default ? 'selected' : '';
            $options .= sprintf('<option value="%s" %s > %s</option>', $index, $checked,  $value);
        }

        return $options;
    }
}

if (!function_exists("admin_user_can")) {
    function admin_user_can($permissionName) {
        return auth()->guard("admin")->user()->can($permissionName);
    }
}