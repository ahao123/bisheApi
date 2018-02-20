<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/14 0014
 * Time: 21:57
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id','product_id'];

//    public function imgUrl(){
//        return $this->belongsTo('Image','img_id','id');
//    }
}