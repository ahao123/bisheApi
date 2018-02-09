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


//        echo "success";
//        $files = $_FILES['file_head'];
//        move_uploaded_file($_FILES['file_head']['tmp_name'],'./upload/'.$_FILES['file_head']['name']);
        if(Request::instance()->isPost() ){
            $title = $_POST['title'];
            $file = $_FILES['file_head'];
            move_uploaded_file($file['tmp_name'],'./uploads/'.$file['name']);
            echo "success";
        }else{
            echo "not post";
        }

    }
}