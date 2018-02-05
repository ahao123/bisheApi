<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/5 0005
 * Time: 20:19
 */

namespace app\lib\exception;


class DataException extends BaseException
{
    public $code = 404;
    public $msg = '没有该数据';
    public $errorCode = 10002;
}