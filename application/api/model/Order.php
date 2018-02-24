<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16 0016
 * Time: 22:15
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id','update_time'];

//    protected $autoWriteTimestamp = true;//自动写入时间

    //读取器
    public function getSnapItemsAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }
    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }


    public static function getSummaryByUser($uid,$page = 1,$size=15){
        $paginData = self::where('user_id','=',$uid)
            ->order('create_time desc')
            ->paginate($size,true,['page' => $page]);
        return $paginData;
    }


}