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
    public function upload($type = 0){
        if(Request::instance()->isPost() ){
            $count = 1;$result="true";
            $id = $_POST['id'];
            $filePath = './upload/image/';
            $date = date('Ymd');
            switch ($type){
                case 0:
                    exit();
                    break;
                case 1:
                    if(isset($_FILES['file_head']) && !empty($_FILES['file_head']) ){
                        $file = $_FILES['file_head'];
                        $fileName = md5($file['name']);
                        $result = $this->uploadHeadImage($id,$file);
                    }else{
                        $count = 0;
                    }
                    break;
                case 2:
                    if(isset($_FILES['file']) && !empty($_FILES['file']) ){
                        $file = $_FILES['file'];
                        $fileName = md5($file['name']);
                        $result = $this->uploadHeadImage($id,$file,2);
                    }else {
                        $count = 0;
                    }
                    break;
                default:
                    $count = 0;
            }
            if($count == 0 || $result == "error") {
                echo "error";
                exit();
            }

            if(!is_dir($filePath.$date)){
                mkdir($filePath.$date,0777,true);
            }
            move_uploaded_file($file['tmp_name'],$filePath.$date."/".$fileName);
            echo $result;
        }else{
            echo "not post";
        }
    }
    //上传head_image
    private function uploadHeadImage($id,$file,$type=1){
        $info = ThemeModel::get($id);
        if(!$info){
            return "error";
        }
        $fileName = md5($file['name']);
        $date = date('Ymd');
        $fileType = $file['type'];
        $fileTypeArr = explode('/',$fileType);
        //插入数据库
        $filePath2 = "/upload/image/".$date."/".$fileName.".".array_pop($fileTypeArr);
        $themeModel = new ThemeModel;
        if($type == 1){
            $ret = $themeModel->where('id',$id)
                ->update(['head_img'=>$filePath2]);
        }else if($type = 2){
            $ret = $themeModel->where('id',$id)
                ->update(['img'=>$filePath2]);
        }
        if(!$ret){
            return "error";
        }else{
            return $filePath2;
        }
    }


}