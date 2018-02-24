<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 9:27
 */

namespace app\api\service;

use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($id)
    {
        if(empty($id)){
            throw new Exception('订单号不允许为空');
        }
        $this->orderID = $id;
    }

    public function pay(){
        //订单号存在
        //订单号和当前用户匹配
        //订单是否已支付
        //库存量检测
        if( $this->checkOrderValid() ){
            $orderService = new OrderService();
            $status = $orderService->checkOrderStock($this->orderID);
            if( !$status['pass'] ){
                return $status;
            }
            return $this->makeWxOrder($status['orderPrice']);
        }
    }

    private function checkOrderValid(){
        $order = OrderModel::where('id','=',$this->orderID)
            ->find();
        if(!$order){
            throw new OrderException([]);
        }
        if(!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg'  => '订单与用户不匹配',
                'errorCode' => 10001,
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException([
                'msg' => '订单已支付过',
                'errorCode' => 80003,
                'code' => 400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
    //微信支付
    private function makeWxOrder($totalPrice){
        $openid = Token::getCurrentTokenVar('openid');
        if(!$openid){
            throw new TokenException([]);
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('wen');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetNotify_url(config('secure.pay_back_url'));//回调地址
        return $this->getPaySignature($wxOrderData);
    }
    //调用微信支付
    private function getPaySignature($wxOrderData){
        $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预支付订单失败','error');
        }
        //prepay_id
        $this->recordPreOrder($wxOrder);
        //返回小程序需要的微信支付参数
        $signature = $this->sign($wxOrder);
        return $signature;
    }
    //更新prepay_id字段
    private function recordPreOrder($wxOrder){
        OrderModel::where('id','=',$this->orderID)
            ->update( ['prepay_id' => $wxOrder['prepay_id'] ] );
    }

    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp( (string)time() );
        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage("prepay_id=".$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawVal = $jsApiPayData->GetValues();
        $rawVal['pay_sign'] = $sign;
        unset($rawVal['appId']);
        return $rawVal;
    }
}