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
//        $params = $_POST['file'];
//        $files = json_decode($params,true);
//        move_uploaded_file($files['tmp_name'],'../uploads/'.$files['name']);
//        echo "success";
//        $files = $_FILES['file_head'];
//        move_uploaded_file($_FILES['file_head']['tmp_name'],'./upload/'.$_FILES['file_head']['name']);
        if(Request::instance()->isPost()){
            $params = $_POST['test'];
            var_dump($params);
        }else{
            echo "not post";
        }

    }
}