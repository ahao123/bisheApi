<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/15
 * Time: 12:44
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\UserAddress;
use app\api\service\Token;
use app\api\validate\AddressNew;
use app\api\model\User as UserModel;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\api\service\Token as TokenService;


class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress,getUserAddress'],
    ];

    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();
        //根据Token获取用户id
        //根据id查找数据
        //获取用户传递的地址数据
        //根据信息是否存在判断是更新还是添加
        $uid = Token::getCurentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException([]);
        }
        $dataArray = $validate->getDataByRule( input('post.') );

        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save($dataArray);
        }else{
            $user->address->save($dataArray);
        }
        return new SuccessMessage();
    }

    public function getUserAddress(){
        $uid = TokenService::getCurentUid();
        $userAddress = UserAddress::where('user_id','=',$uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }
}