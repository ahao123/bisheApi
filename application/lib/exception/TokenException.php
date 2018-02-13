<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/14 0014
 * Time: 21:11
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $msg = 'token已过期';
    public $errorCode = 10001;
}