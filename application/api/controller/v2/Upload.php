<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/7
 * Time: 15:53
 */

namespace app\api\controller\v2;


class Upload
{
    public function upload(){
        $params = $_POST['file'];
        $files = json_decode($params,true);


        move_uploaded_file($files['tmp_name'],'../uploads/'.$files['name']);
        echo "success";

    }
}