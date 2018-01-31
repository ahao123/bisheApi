<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/20 0020
 * Time: 15:14
 */

namespace app\api\model;

use think\Model;

class Banner extends Model
{
    protected $hidden = ['id','create_time'];

    public function items(){
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerByID($id){
        $info = self::with('items')->find($id);

        return $info;
    }
}