<?php
require_once __DIR__ .'/autoload.php';

use Qiniu\Storage\UploadManager;
use Qiniu\Processing\ImageUrlBuilder;

class qiniuOss{
    
    /**
     * 上传文件到oss
     */
    function uploadFile($token, $file, $dir = 'data/upload/caster'){
        
        if (empty($token)){
            
            return array('msg'=>'没有上传凭证');
        }
        //根据本地文件路径获取后缀名
        $imgType  =  end(@explode('.',$file['name']));
        $imgType  =  strtolower($imgType);
        //判断后缀名是否合法
        if(!$file['tmp_name']){
            
            $return['msg'] = '未找到相关文件';
        }else{
            
            $dir .= '/'.date('Ymd').'/';
            //重置文件名称 时间戳+随机数
            $key        =  $dir . time().rand(1000,9999).'.'.$imgType;
            $thumbKey   =  $dir . time().rand(1000,9999).'_s.'.$imgType;
            $filePath   =  $file['tmp_name'];//本地上传文件路径
            
            // 初始化 UploadManager 对象并进行文件的上传。
            $uploadMgr = new UploadManager();
            
            // 调用 UploadManager 的 putFile 方法进行文件的上传。
            list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
            
            if ($err !== null) {
                $return['msg']  =  $err['error'];
            } else {
                $return['url']  =  $ret['key'];
            }
        }
        return $return;
    }
}
?>