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
class admin_privacy_config_controller extends adminCommon{  

	function index_action(){
	
		$this->yuntpl(array('admin/admin_privacy_config'));
	}

	function save_action(){
	    
	    $_POST =  $this->post_trim($_POST);
	    
	    $configM  =  $this->MODEL('config');
	    
	    if ($_POST['sy_privacy_open']){
	        
	        $data['sy_privacy_open'] = 1;
	    }else{
	        
	        $data['sy_privacy_open'] = 2;
	    }
		if ($_POST['sy_comprivacy_open']){
	        
	        $data['sy_comprivacy_open'] = 1;
	    }else{
	        
	        $data['sy_comprivacy_open'] = 2;
	    }

		$data['sy_privacy_appid']		=  $_POST['sy_privacy_appid'];
		$data['sy_privacy_token']		=  $_POST['sy_privacy_token'];
		$data['sy_privacy_time']		=  $_POST['sy_privacy_time'];
		$data['sy_privacy_callrec']		=  $_POST['sy_privacy_callrec'];
		$data['sy_privacy_uname']		=  $_POST['sy_privacy_uname'];
		$data['sy_privacy_idcard']		=  $_POST['sy_privacy_idcard'];
	    $data['sy_privacy_type']		=  $_POST['sy_privacy_type'];
	   
	    $configM -> setConfig($data);
	    
	    $this->web_config();
	    
	    $this->ACT_layer_msg("隐私号设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	}
	
	
}

?>