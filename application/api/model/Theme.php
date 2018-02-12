<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1
 * Time: 13:20
 */

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['create_time','update_time'];

    //多对多
    public function products(){
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    //获取主题的商品
    public static function getThemeProduct($id){
        $info = self::with('products')->find($id);
        return $info;
    }
}