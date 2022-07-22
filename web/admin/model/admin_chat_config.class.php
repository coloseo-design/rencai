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
class admin_chat_config_controller extends adminCommon{  
	function index_action(){
		$this->yuntpl(array('admin/admin_chat_config'));
	}

	function save_action(){
	    
	    $_POST =  $this->post_trim($_POST);
	    
	    $configM  =  $this->MODEL('config');
	    
	    if ($_POST['sy_chat_open']){
	        
	        $data['sy_chat_open'] = 1;
	    }else{
	        
	        $data['sy_chat_open'] = 2;
	    }
		if ($_POST['sy_chat_exphone']){
	        
	        $data['sy_chat_exphone'] = 2;
	    }else{
	        
	        $data['sy_chat_exphone'] = 1;
	    }
	    if ($_POST['sy_chat_concheck']){
	        
	        $data['sy_chat_concheck'] = 2;
	    }else{
	        
	        $data['sy_chat_concheck'] = 1;
	    }
	    $data['sy_chat_limit']		=  $_POST['sy_chat_limit'];
	    $data['sy_chat_rates']		=  $_POST['sy_chat_rates'];
	    $data['sy_chat_name']		=  $_POST['sy_chat_name'];
	    $data['sy_chat_day']		=  $_POST['sy_chat_day'];
	    $data['sy_chat_appkey']		=  $_POST['sy_chat_appkey'];
	    $data['sy_chat_appsecret']  =  $_POST['sy_chat_appsecret'];
	    $data['sy_chat_mapkey']		=  $_POST['sy_chat_mapkey'];
	    $data['sy_chat_weburl']     =  'wss://yunliao.phpyun.com/wss';
	    
	    $configM -> setConfig($data);
	    
	    $this->web_config();
	    
	    $this->ACT_layer_msg("聊天设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	}
	
	/**
	 * 查询聊天服务是否可用
	 */
	function get_restnum_action(){
	    
	    $chatM   =  $this->MODEL('chat');
	    $return  =  $chatM->chatRequest();
	    
	    echo json_encode($return);die;
	}
}

?>