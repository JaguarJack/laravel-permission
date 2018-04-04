<?php

namespace Lizyu\Permission;

use Closure;
use Lizyu\Permission\Exceptions\UnauthorizedException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //非超级用户需要验证权限
        $user = auth()->user();
        if ( !isset($user->is_super) || $user->is_super != 1 ) {
            if (!$user->can($this->handleRoute($request->route()->getAction()))) {
                throw UnauthorizedException::permissionForbidden('Permission Forbidden');
            }
        }
        
        return $next($request);
    }
    
    /**
     * @description:Detail Route to Get Permission
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月10日
     * @param unknown $route
     * @return string
     */
    protected function handleRoute($route)
    {
        list($controller, $action) = explode('@', $route['uses']);
        
        $controller = str_ireplace('controller', '', @array_pop(explode('\\', $controller)));
        
        return sprintf('%s@%s', strtolower($controller), strtolower($action));
    }
}
