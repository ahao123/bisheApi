<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1
 * Time: 13:18
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDCollection;
use app\api\model\Theme as ThemeModel;
use app\lib\exception\ThemeException;

class Theme extends BaseController
{
    public function getSimpleList($ids=''){
        ( new IDCollection() )->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::all($ids);
        return $result;
        if( $result->isEmpty() ){
            throw new ThemeException([]);
        }
        return $result;
    }
}