<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/13 0013
 * Time: 15:26
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = "微信服务器接口调用失败";
    public $errorCode = 999;
}