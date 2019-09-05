<?php

namespace Moell\LayuiAdmin\Http\Middleware;

use Auth;
use Route;
use Spatie\Permission\Exceptions\UnauthorizedException;

class AdminPermission
{
    /**
     * @author moell<moel91@foxmail.com>
     * @param $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $permission = Route::currentRouteName();

        if (Auth::guard("admin")->user()->can($permission)) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }
}