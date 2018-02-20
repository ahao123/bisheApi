<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/12 0012
 * Time: 20:34
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['update_time','description'];

    public function getTopicImgAttr($value,$data){
        return config('setting.img_prefix').$value;
    }
}