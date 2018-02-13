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
use app\api\model\Product as ProductModel;

class Upload
{
    public function upload($type = 0){
        if(Request::instance()->isPost() ){
            header("Access-Control-Allow-Origin: *");
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
                        $fileName = md5(getRandChar(3).$file['name']);
                        $result = $this->uploadHeadImage($id,$file);
                    }else{
                        $count = 0;
                    }
                    break;
                case 2:
                    if(isset($_FILES['file']) && !empty($_FILES['file']) ){
                        $file = $_FILES['file'];
                        $fileName = md5(getRandChar(3).$file['name']);
                        $result = $this->uploadHeadImage($id,$file,$fileName,2);
                    }else {
                        $count = 0;
                    }
                    break;
                case 3:
                    if(isset($_FILES['file']) && !empty($_FILES['file']) ){
                        $file = $_FILES['file'];
                        $fileName = md5(getRandChar(3).$file['name']);
                        if(isset($_POST['type']) && $_POST['type'] == "add"){
                            $result = $this->uploadProductImage($id,$file,$fileName,'add');
                        }else{
                            $result = $this->uploadProductImage($id,$file,$fileName);
                        }
                    }else{
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
            $fileTypeArr = explode('/',$file['type']);
            move_uploaded_file($file['tmp_name'],$filePath.$date."/".$fileName.".".array_pop($fileTypeArr));
            echo $result;
        }else{
            echo "not post";
        }
    }
    //上传thmem head_image/image
    private function uploadHeadImage($id,$file,$fileName,$type=1){
        $info = ThemeModel::get($id);
        if(!$info){
            return "error";
        }
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
    //上传商品图片
    private function uploadProductImage($id,$file,$fileName,$type="edit"){
        $date = date('Ymd');
        $fileType = $file['type'];
        $fileTypeArr = explode('/',$fileType);
        //插入数据库
        $filePath2 = "/upload/image/".$date."/".$fileName.".".array_pop($fileTypeArr);

        if($type == "edit"){
            $info = ProductModel::get($id);
            if(!$info){
                return "error";
            }
            $productModel = new ProductModel;
            $ret = $productModel->where('id',$id)
                ->update(['main_img_url'=>$filePath2]);
            if(!$ret){
                return "error";
            }
        }

        return $filePath2;
    }

}