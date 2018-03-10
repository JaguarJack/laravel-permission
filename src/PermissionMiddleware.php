<?php

namespace Lizyu\Permission;

use Closure;

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
        if ( auth()->guest() ) {
            
            $msg = ['code' => 10001, 'msg' => '未登录'];
            
            return $request->ajax() ? response()->json($msg) : redirect('/login');
        }
        
        //非超级用户需要验证权限
        $user = auth()->user();
        if ( $user->is_super != 1 ) {
            if (!$user->can($this->handleRoute($request->route()->getAction()))) {
               // return  response()->json(['msg' => '权限不足']);
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
