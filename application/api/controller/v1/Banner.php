<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\TestValidate;
use think\Validate;

class Banner extends BaseController
{
    /**
     * @param $id
     */
    public function getBanner($id){
        //验证器
        $data = [
            'name' => 'sdassdaasdasdas',
            'id' => $id
        ];
//        $validate = new Validate([
//            'name'=>'require|max:10',
//            'id' => 'email'
//        ]);
//        $result = $validate->batch()->check($data);//批量验证
//        var_dump($result);
//        var_dump($validate->getError());

        $valitate = new TestValidate();
        $result = $valitate->batch()->check($data);
        var_dump($valitate->getError());

//        var_dump($id);
    }
}