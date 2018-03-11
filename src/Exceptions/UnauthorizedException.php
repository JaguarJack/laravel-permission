<?php

namespace Lizyu\Permission\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    /**
     * @description:未登录
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月11日
     * @return \Lizyu\Permission\Exceptions\UnauthorizedException
     */
    public static function notLoginYet($msg)
    {
        return new static(403, $msg, null, []);
    }
    
    /**
     * @description:权限不足
     * @author: wuyanwen <wuyanwen1992@gmail.com>
     * @date:2018年3月11日
     */
    public static function permissionForbidden($msg)
    {
        return new static(403, $msg, null, []);
    }
    
}