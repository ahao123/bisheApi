<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/4
 * Time: 23:08
 */

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //读取器 构件image url路径
//    public function prefixImgUrl($value,$data){
//        $finnal_url = $value;
//        if($data['from'] == 1){//本地图片
//            $finnal_url = config('setting.img_prefix').$value;
//        }
//        return $finnal_url;
//    }
}