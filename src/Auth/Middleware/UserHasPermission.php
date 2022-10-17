<?php

namespace NoaPe\Beluga\Auth\Middleware;

use Closure;
use NoaPe\Beluga\Helpers\Permission;

class UserHasPermission
{
    /**
     * Permission name
     *
     * @var string
     */
    protected $permission = null;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Permission::hasPermission($request->user(), $this->permission)) {
            return $next($request);
        } else {
            return abort(403);
        }
    }
}
