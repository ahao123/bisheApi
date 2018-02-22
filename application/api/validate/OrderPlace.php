<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 13:18
 */

namespace app\api\validate;


use app\lib\exception\ParamException;

class OrderPlace extends BaseValidate
{
    /*
        products = [
            [
                'product_id' => 1
                'count'  = 2
            ],
            [
                'product_id' => 1
                'count'  => 2
            ]
        ];
     */
    protected $rule = [
        'products' => 'checkProducts',
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count'  => 'require|isPositiveInteger',
    ];
    /*
     *检验Products
     */
    public function checkProducts($value, $rule = '',
                             $data = '', $field = '')
    {
        if( empty($value) ){
            throw new ParamException([
                'msg' => 'products不能为空'
            ]);
        }
        if(!is_array($value)){
            throw new ParamException([
                'msg' => 'products格式不正确'
            ]);
        }
        foreach($value as $item){
            $this->checkProduct($item);
        }
        return true;
    }

    protected function checkProduct($value){
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value);
        if(!$result){
            throw new ParamException([
                'msg' => 'product参数错误'
            ]);
        }
    }

}