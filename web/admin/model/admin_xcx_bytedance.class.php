<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class admin_xcx_bytedance_controller extends adminCommon{
    
    function index_action()
    {
        
        if($_POST['pay_config']){
            
            $_POST  =  $this->post_trim($_POST);
            
            $tt  =  array(
                'sy_tt_appId'  =>  $_POST['sy_tt_appId'],
                'sy_tt_token'  =>  $_POST['sy_tt_token'],
                'sy_tt_salt'   =>  $_POST['sy_tt_salt'],
                'sy_tt_iospay' =>  isset($_POST['sy_tt_iospay']) ? 1 : 2
            );
            foreach ($tt as $v){
                if (empty($v)){
                    $this->ACT_layer_msg('请将参数配置齐', 8);
                }
            }
            made_web(DATA_PATH.'api/bytedance/tt_data.php',ArrayToString($tt),'ttData');
            
            unset($tt['sy_weburl']);
            $configM  =  $this->MODEL('config');
            $configM -> setConfig($tt);
            
            $this->web_config();
            
            $this->ACT_layer_msg('字节跳动小程序配置成功！',9,$_SERVER['HTTP_REFERER'],2,1);
        }
        
        @include(DATA_PATH.'api/bytedance/tt_data.php');
        if (isset($ttData)) {
            $this->yunset('ttData',$ttData);
        }
        
        $this->yuntpl(array('admin/admin_xcx_bytedance'));
    }
    function makeCache_action()
    {
        
        $wxappM  =  $this->MODEL('wxapp');
        $wxappM->makettCache();
    }
}

?>