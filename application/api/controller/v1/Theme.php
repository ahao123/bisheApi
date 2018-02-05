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
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\DataException;

class Theme
{
    public function getSimpleList($ids=''){
        ( new IDCollection() )->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::all($ids);

        if( !$result ){
            throw new DataException([]);
        }
        return $result;
    }

    public function getComplexOne($id){
        ( new IDMustBePositiveInt() )->goCheck();
        $result = ThemeModel::getThemeProduct($id);
        if(!$result){
            throw new DataException([]);
        }
        return $result;
    }
}