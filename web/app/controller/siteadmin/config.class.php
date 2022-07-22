<?php

/*
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class config_controller extends adminCommon{

   
    //后台专用，layui上传图片公共方法
    function layui_upload_action()
    {
        
        if($_FILES['file']['tmp_name']){

            $data  =  array(
                'name'      =>  $_POST['name'],
                'path'      =>  $_POST['path'],
                'imgid'     =>  $_POST['imgid'],
                'file'      =>  $_FILES['file']
            );
            

            $UploadM=$this->MODEL('upload');
            
            $return = $UploadM->layUpload($data);
            
            if (!empty($_POST['name']) && $return['code'] == 0){
                // 后台上传logo后，重新生成缓存
                $this->web_config();
            }
        }else{
            $return  =  array(
                'code'  =>  1,
                'msg'   =>  '请上传文件',
                'data'  =>  array()
            );
        }
        echo json_encode($return);
    }
}
?>