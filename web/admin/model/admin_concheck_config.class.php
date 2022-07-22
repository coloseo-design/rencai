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
class admin_concheck_config_controller extends adminCommon{  
	function index_action(){
		$this->yuntpl(array('admin/admin_concheck_config'));
	}

	function save_action(){
	    
	    $_POST =  $this->post_trim($_POST);
	    
	    $configM  =  $this->MODEL('config');
	    
	    if ($_POST['sy_concheck_open']){
	        
	        $data['sy_concheck_open'] = 1;
	    }else{
	        
	        $data['sy_concheck_open'] = 2;
	    }
		
	    $data['sy_concheck_appkey']		=  $_POST['sy_concheck_appkey'];
	    $data['sy_concheck_appsecret']  =  $_POST['sy_concheck_appsecret'];
	    
	    $configM -> setConfig($data);
	    
	    $this->web_config();
	    
	    $this->ACT_layer_msg("内容安全检测设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
	}
	function get_restnum_action(){
	    
	    $returnArr['num'] = 0;

	    $url		=	'https://u.phpyun.com/feature';
	    $url		.=	'?appKey='.$this->config['sy_concheck_appkey'].'&appSecret='.$this->config['sy_concheck_appsecret'];
		
	    if (extension_loaded('curl')){
			
	        $return 	= 	CurlGet($url);
			
	    }else if(function_exists('file_get_contents')){
			
	        $return 	= 	file_get_contents($url);
			
	    }
		if($return){
			$msgInfo = json_decode($return,true);
			if($msgInfo['code'] == '200'){
				$returnArr['num'] = $msgInfo['num'];
			}
		}

		echo json_encode($returnArr);die;
	}
}

?>