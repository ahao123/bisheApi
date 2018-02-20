<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/15
 * Time: 12:46
 */

namespace app\api\validate;


class AddressNew extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'mobile' => 'require|isMobile',
        'province' => 'require|isNotEmpty',
        'city' => 'require|isNotEmpty',
        'country' => 'require|isNotEmpty',
        'detail' => 'require|isNotEmpty',
    ];
//    protected $message = [
//        'name' => '空',
//        'mobile' => 'require|isNotEmpty',
//        'city' => 'require|isNotEmpty',
//        'country' => 'require|isNotEmpty',
//        'detail' => 'require|isNotEmpty',
//    ];
}