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
    public function items(){
        $this->hasMany('BannerItem','banner_id','id');
    }
}