<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/19 0019
 * Time: 14:37
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\api\model\Product as ProductModel;
use think\Db;
use think\Exception;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
//        return parent::NotifyProcess($data, $msg); // TODO: Change the autogenerated stub
        if($data['result_code'] == 'SUCCESS'){
            $orderNo = $data['out_trace_no'];
            Db::startTrans();
            try{
                $order = OrderModel::where('order_no','=',$orderNo)
                    ->lock(true)
                    ->find();
                if($order->status == OrderStatusEnum::UNPAID){
                    $service = new OrderService();
                    $stockStatus = $service->checkOrderStock($order['id']);
                    if($stockStatus['pass']){
                        //更新库存量
                        $this->updateOrderStatus($order->id,true);
                        $this->reduceStock($stockStatus);
                    }else{
                        $this->updateOrderStatus($order->id,false);
                    }
                }
                Db::commit();
                return true;
            }catch (Exception $ex){
                Log::error($ex);
                Db::rollback();
                return false;
            }
        }else{
            return true;
        }
    }
    //更新订单状态
    public function updateOrderStatus($orderID,$success){
        $status = $success?OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('order_id','=',$orderID)
            ->update(['status' => $status]);
    }
    //
    public function reduceStock($stockStatus){
        foreach ($stockStatus['pStatusArray'] as $simglePStatus){
            ProductModel::where('id','=',$simglePStatus['id'])
                ->setDec('stock',$simglePStatus['count']);

        }
    }
}