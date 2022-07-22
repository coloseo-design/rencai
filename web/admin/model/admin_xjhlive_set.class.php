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
class admin_xjhlive_set_controller extends adminCommon{
    
	function index_action(){
	    
	    $this -> yuntpl(array('admin/admin_xjhlive_set'));
	}
	function save_action(){
	    if($_POST['config']){
	        $post  =  array(
				'sy_xjh_subtime'        =>  $_POST['sy_xjh_subtime'],
	            'sy_xjh_notice'         =>  $_POST['sy_xjh_notice'],
	            'sy_xjhlive_appkey'     =>  $_POST['sy_xjhlive_appkey'],
	            'sy_xjhlive_appsecret'  =>  $_POST['sy_xjhlive_appsecret']
	        );
	        $configM  =  $this -> MODEL('config');
	        
	        $configM -> setConfig($post);
	        
	        $this -> web_config();
	        
	        $this -> ACT_layer_msg('配置修改成功！',9,1,2,1);
	    }
	}
	/**
	 * 查询宣讲会剩余数量
	 */
	function get_restnum_action(){
	    
	    $xjhM    =  $this->MODEL('xjhlive');
	    $return  =  $xjhM->xjhCanAdd();
	    
	    echo json_encode($return);die;
	}
}
?>