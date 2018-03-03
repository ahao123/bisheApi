<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/19 0019
 * Time: 16:51
 */

namespace app\api\validate;


class PageParameter extends BaseValidate
{
    protected $rule = [
        'page' => 'require|isPositiveInteger',
        'size' => 'require|isPositiveInteger',
    ];

    protected $message = [
        'page' => 'page必须是正整数',
        'size' => 'size必须是正整数',
    ];
}