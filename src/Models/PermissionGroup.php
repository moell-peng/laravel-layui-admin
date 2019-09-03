<?php

namespace Moell\LayuiAdmin\Models;


use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $guarded = ['id'];

    public function permission()
    {
        return $this->hasMany('Moell\LayuiAdmin\Models\Permission', 'pg_id');
    }
}