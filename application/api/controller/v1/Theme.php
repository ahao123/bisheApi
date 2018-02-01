<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1
 * Time: 13:18
 */

namespace app\api\controller\v1;


use think\Controller;

class Theme extends Controller
{
    public function getSimpleList($ids=''){
        //return Request::instance()->param();
        ( new IDCollection() )->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with('topicImg,headImg')->select($ids);
        if( $result->isEmpty() ){
            throw new ThemeException();
        }
        return $result;
    }
}