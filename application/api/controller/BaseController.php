<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 13:06
 */

namespace app\api\controller;

use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    protected function checkPrimaryScope(){
        Token::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        Token::needExclusiveScope();
    }
}