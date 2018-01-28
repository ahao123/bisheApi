<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/20 0020
 * Time: 15:44
 */

namespace app\lib\exception;

use think\Exception;

class BaseException extends Exception
{
    //状态码
    public $code = 400;
    //错误信息
    public $msg = '参数错误';
    //自定义错误码
    public $errorCode = 10000;

    public function __construct($param)
    {
        if(!is_array($param) ){
            return ;
        }
        if(array_key_exists('msg',$param) ){
            $this->code = 405;
        }

//        var_dump($param);
//        parent::__construct($message, $code, $previous);
    }
}