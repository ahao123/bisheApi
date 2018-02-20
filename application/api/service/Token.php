<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/14 0014
 * Time: 20:59
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    //生成令牌
    public static function generateToken(){
        //32个字符组成随机字符窜
        $randChar = getRandChar(32);
        //加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChar.$timestamp.$salt);
    }
    //根据令牌获取id
    public static function getCurentUid(){
        return self::getCurrentTokenVar('uid');
    }

    public static function getCurrentTokenVar($key){
        $token = Request::instance()
            ->header('token');
//        cache('ss','aaa');
//        $aa = cache('ss');

        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }
        else{
            if(!is_array($vars)){
                $result = json_decode($vars,true);
            }
            if(array_key_exists($key,$result)){
                return $result[$key];
            }
            else{
                throw new Exception('token变量不存在');
            }
        }
    }
    /*
     * 检查权限  大于等于用户权限
     */
    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope >= ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    /*
     * 检查权限  等于用户权限
     */
    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope == ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }
    /*
     *
     */
    public static function isValidOperate($checkedUID){
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入UID');
        }
        $currentUID = self::getCurentUid();
        if( $currentUID == $checkedUID ){
            return true;
        }
        return false;
    }
    /*
     * 校验token
     */
    public static function verifyToken($token){
        $exist = Cache::get($token);
        if(!$exist){
            return false;
        }
        return true;
    }
}