<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/9 0009
 * Time: 22:53
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
      'count' => 'isPositiveInteger|between:1,15'
    ];
}