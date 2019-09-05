<?php

namespace Moell\LayuiAdmin\Http\Middleware;


use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected $guards;

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$this->guards) {
            return route('login');
        }

        if (in_array('admin', $this->guards)) {
            return route("admin.login-show-form");
        }
    }

    public function authenticate($request, array $guards)
    {
        $this->guards = $guards;

        parent::authenticate($request, $guards);
    }
}
