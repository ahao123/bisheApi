<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/11
 * Time: 13:02
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = [
        'code' => 'require|isNotEmpty'
    ];
    protected $message = [
        'code' => 'code为空'
    ];

}