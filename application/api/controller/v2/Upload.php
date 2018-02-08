<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/7
 * Time: 15:53
 */

namespace app\api\controller\v2;


use think\Request;

class Upload
{
    public function upload(){
        $params = Request::instance()->param();

//        $paramsArr = json_decode($params);
//        $files = $paramsArr['file'];

//        move_uploaded_file($files['tmp_name'],'./upload/'.$files['name']);
//        echo "success";
        var_dump($params);
    }
}