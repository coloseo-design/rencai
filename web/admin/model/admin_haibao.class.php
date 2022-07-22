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
class admin_haibao_controller extends adminCommon{
	function index_action(){
		
		$this->yuntpl(array('admin/admin_haibao_config'));
		
	}
	
	function save_action(){
 		if($_POST['config']){
			unset($_POST['config']);
			
			$configM		=		$this->MODEL('config');
			
			$configM->setConfig($_POST);
		   
			$this->web_config();
			
			$this->ACT_layer_msg( "海报配置设置成功！",9,1,2,1);
		 }
	}

	function get_restnum_action(){
	    $haibaouser			=		iconv('utf-8','gbk',trim($_POST['haibaouser']));
	    $key				=		trim($_POST['key']);
		$url				=		'http://haibao.phpyun.com/restnum.php';
		$url				.=		"?haibaouser=".$haibaouser."&key=".$key;
	    
		if (extension_loaded('curl')){
	        $file_contents 	= 		CurlGet($url);

	    }else if(function_exists('file_get_contents')){
			
	        $file_contents	= 		file_get_contents($url);

	    }

 	    echo $file_contents;die;
		 
	}
}
?>