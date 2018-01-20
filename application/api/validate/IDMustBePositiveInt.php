<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/29
 * Time: 20:53
 */
namespace app\api\validate;

/*
 * 验证正整数
 */
class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInteger',
    ];
    protected $message = [
        'id' => '必须是正整数',
    ];

}