<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/11
 * Time: 13:11
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppid;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code = $code;
        $this->wxAppid = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf( config('wx.login_url'),$this->wxAppid,$this->wxAppSecret,$this->code );
    }

    public function get(){
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result,true);
        if( empty($wxResult) ){
            throw new Exception('获取openID和session_key异常');
        }
        $loginFail = array_key_exists('errcode',$wxResult);
        if($loginFail){
            //失败
            $this->processLoginError($wxResult);
        }else{
            //成功
            return $this->grantToken($wxResult);
        }
    }

    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg' => $wxResult['errmsg'],
            'errCode' => $wxResult['errcode'],
        ]);
    }

    private function grantToken($wxResult){
        //拿到openID
        //查看数据库是否存在该openID,不存在则新增
        //生成令牌，写入缓存
        //把令牌返回到客户端
        $openid = $wxResult['openid'];
        $user = UserModel::getByOpenID($openid);
        if($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cachedValue = $this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function saveToCache($cachedValue){
        //生成令牌并且缓存
        $key = self::generateToken();
        $value = json_encode($cachedValue);
        $token_expire = config('setting.token_expire');
        $request = cache($key,$value,$token_expire);
        if(!$request){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $key;
    }

    private function prepareCachedValue($wxResult,$uid){
        $cachedValue = $wxResult;
        $cachedValue['uid'] = $uid;
        $cachedValue['scope'] = ScopeEnum::User;//权限

        return $cachedValue;
    }

    private function newUser($openid){
        //数据库插入一条数据
        $user = UserModel::create([
            'openid' => $openid,
        ]);
        return $user->id;
    }
}