<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1
 * Time: 13:20
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = ['delete_time','update_time','create_time','pivot'];

    public static function getMostRecent($count){
        return self::limit($count)
            ->where(['is_new'=>1])
            ->order('create_time desc')
            ->select();
    }

    public static function getProductByCategoryID($GategoryID){
        $products = self::where('category_id','=',$GategoryID)
            ->select();
        return $products;
    }

}