<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 12:50
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderServive;
use app\api\model\Order as OrderModel;
use app\api\validate\PageParameter;
use app\api\service\Token as TokenService;
use app\lib\exception\OrderException;
use think\Controller;

class Order extends BaseController
{
    //用户选择商品，向Api提交所选择商品的具体信息
    //检查商品库存量
    //有库存则把订单信息插入数据库
    //调用支付接口
    //进行库存量检测
    //服务器调用微信支付接口进行支付
    //小程序根据服务器返回的结果拉起微信支付
    //微信返回一个支付结果
    //成功。库存量检查和扣除
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
    ];

    public function placeOrder(){
        ( new OrderPlace() )->goCheck();
        $products = input('post.products/a');//获取数组参数
        $uid = \app\api\service\Token::getCurentUid();

        $order = new OrderServive();
        $status = $order->place($uid,$products);
        return $status;
    }
    //获取订单信息
    public function getSummaryByUser($page = 1,$size = 15){
        ( new PageParameter() )->goCheck();
        $uid = TokenService::getCurentUid();
        $paginOrder = OrderModel::getSummaryByUser($uid,$page,$size);
        if( $paginOrder->isEmpty() ){
            return [
                'data' => [],
                'current_page' => $paginOrder::getCurrentPage()
            ];
        }
        $data = $paginOrder->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $paginOrder::getCurrentPage()
        ];
    }
    //订单详情
    public function getDetail($id){
        ( new IDMustBePositiveInt() )->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException([]);
        }
        return $orderDetail->hidden(['prepay_id']);
    }
}