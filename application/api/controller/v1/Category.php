<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/10 0010
 * Time: 21:19
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\DataException;

class Category
{
    public function getAllCategories(){
         $result = CategoryModel::find()->select();
         if( $result->isEmpty() ){
            throw new DataException();
         }
         return $result;
    }
}