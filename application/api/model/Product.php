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

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public function imgs(){
        return $this->hasMany('ProductImage','product_id','id');
    }

    public function property(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

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

    public static function getProductDetail($id){
        //根据productImage的order排序
//        $product = self::with('imgs,property')
//            ->find($id);

        $product = self::with([
            'imgs' => function($query){
                    $query->where('status',1)
                        ->order('order');
            }
        ])
            ->with(['property' => function($query){
                    $query->where('status',1);
            }])
            ->find($id);

        return $product;
    }
}