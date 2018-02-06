<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/9 0009
 * Time: 22:50
 */

namespace app\api\controller\v1;

use app\api\validate\Count;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\DataException;

class Product
{
    public function getRecent($count = 15){
        ( new Count() )->goCheck();
        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()){
            throw new DataException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
    //获取分类
    public function getAllInGategory($id){
        ( new IDMustBePositiveInt() )->goCheck();
        $products = ProductModel::getProductByCategoryID($id);
        if( $products->isEmpty() ){
            throw new DataException();
        }
        return $products;
    }

    //商品详情
    public function getOne($id){
        ( new IDMustBePositiveInt() )->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }
}