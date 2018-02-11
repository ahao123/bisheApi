<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/7
 * Time: 15:53
 */

namespace app\api\controller\v2;

use think\Request;
use app\api\model\Theme as ThemeModel;

class Upload
{
    public function upload(){
        if(Request::instance()->isPost() ){
            $id = $_POST['id'];
            $file = $_FILES['file_head'];
            $filePath = './upload/image/';
            $date = date('Ymd');

            if(!is_dir($filePath.$date)){
                mkdir($filePath.$date,0777,true);
            }
//            list($usec, $sec) = explode(" ", microtime());
            $fileName = md5($file['name']);

            //插入数据库
            $filePath2 = $date."/".$fileName;
            $info = ThemeModel::get($id);
            if(!$info){
                return "error";
            }
            $info->head_img = $filePath2;
            $info->save();
            move_uploaded_file($file['tmp_name'],$filePath.$date."/".$fileName);

            echo "success";
        }else{
            echo "not post";
        }

    }
}