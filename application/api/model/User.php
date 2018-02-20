<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/11
 * Time: 13:10
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address(){
        return $this->hasOne('UserAddress','user_id','id');
    }
    
    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)
            ->find();
        return $user;
    }
}