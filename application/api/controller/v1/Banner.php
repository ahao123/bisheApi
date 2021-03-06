<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\TestValidate;
use app\lib\exception\DataException;
use app\lib\exception\ParamException;
use think\Db;
use think\Validate;
use app\api\model\Banner as BannerModel;

class Banner
{
    /**
     * @param $id
     */
    public function getBanner($id){
        //验证器
//        $data = [
//            'name' => 'sdassdaasdasdas',
//            'id' => $id
//        ];
//        $validate = new Validate([
//            'name'=>'require|max:10',
//            'id' => 'email'
//        ]);
//        $result = $validate->batch()->check($data);//批量验证
//        var_dump($result);
//        var_dump($validate->getError());

//        $valitate = new TestValidate();
//        $result = $valitate->batch()->check($data);
//        var_dump($valitate->getError());
        (new IDMustBePositiveInt())->goCheck();

        $info = BannerModel::getBannerByID($id);
        if(!$info){
            throw new DataException([]);
        }
//        $c = config('setting.img_prefix');
        return $info;
    }
}