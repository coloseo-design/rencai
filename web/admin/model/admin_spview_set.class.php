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
class admin_spview_set_controller extends adminCommon{

    function index_action(){
        
        $this -> yuntpl(array('admin/admin_spview_set'));
    }
    function save_action(){
        
        if($_POST['set_config']){
            
            $config  =  array(
                'sy_spview_wait'       =>  $_POST['sy_spview_wait'],
                'sy_spview_time'       =>  $_POST['sy_spview_time'],
                'sy_spview_yytime'     =>  $_POST['sy_spview_yytime'],
                'sy_spview_appkey'     =>  $_POST['sy_spview_appkey'],
                'sy_spview_appsecret'  =>  $_POST['sy_spview_appsecret']
            );
            $configM  =  $this->MODEL('config');
            
            $configM -> setConfig($config);
            
            $this -> web_config();
            
            $this->ACT_layer_msg('视频面试配置成功',9,$_SERVER['HTTP_REFERER'],2,1);
        }
    }
    /**
     * 查询视频面试剩余分钟数
     */
    function get_restnum_action(){
        
        $trtcM   =  $this->MODEL('trtc');
        $return  =  $trtcM->trtcCanAdd();
        
        echo json_encode($return);die;
    }
}
?>