<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/1
 * Time: 22:24
 */

namespace app\lib\exception;


class ParamException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;

}