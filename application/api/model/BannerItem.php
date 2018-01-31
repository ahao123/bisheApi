<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/30 0030
 * Time: 20:52
 */

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['create_time','update_time'];

    public function getImgAttr($value,$data){
        return config('setting.img_prefix').$value;
    }

}