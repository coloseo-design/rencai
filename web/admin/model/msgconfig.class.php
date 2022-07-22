<?php

class msgconfig_controller extends adminCommon{
	function index_action(){
		$cacheM     =   $this->MODEL('cache');
        $options    =   array('city');
	    
	    $cache      =   $cacheM -> GetCache($options);


		$this       ->  yunset($cache);
		
		$this->yuntpl(array('admin/admin_msg_config'));
		
	}
	
	//保存
	function save_action(){

		$configM	=	$this->MODEL('config');
 		if($_POST['config']){
			
			unset($_POST['config']);
			$configM->setConfig($_POST);

			$this->web_config();
			
			$this->ACT_layer_msg( "短信配置设置成功！",9,1,2,1);
		
		}
	}
	
	//短信模板列表
	function tpl_action(){
		
		$this->yuntpl(array('admin/admin_msg_tpl'));
		
	}
	
	//短信模板设置
	function settpl_action(){
		
		include(CONFIG_PATH."db.tpl.php");
		
		$this->yunset("arr_tpl",$arr_tpl);
		
		$templatesM	=	$this->MODEL("templates");
		
		if($_POST['config']){
			
			$configNum	=	$templatesM->getNum(array('name'=>trim($_POST['name'])));
				
			$content	= 	str_replace("amp;nbsp;","nbsp;",$_POST['content']);
			
			if($configNum>0){
				
				$templatesM->upInfo(array('name'=>trim($_POST['name'])),array('content'=>$content,'title'=>trim($_POST['title'])));
				
			}else{
				
				$templatesM->addInfo(array('name'=>trim($_POST['name']),'content'=>$content,'title'=>trim($_POST['title'])));
			
			}
			
			$this->ACT_layer_msg( "短信模版配置设置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
			
		}
		
		$row	=	$templatesM->getInfo(array('name'=>$_GET['name']));
		
		$this->yunset("row",$row);
		
		$this->yuntpl(array('admin/admin_settpl'));
		
	}
	
	function get_restnum_action(){
		

		$returnArr['msgnum'] = $returnArr['businessnum'] = 0;
		//短信检测
	    
	    $url		=	'https://u.phpyun.com/feature';
	    $url		.=	'?appKey='.$this->config['sy_msg_appkey'].'&appSecret='.$this->config['sy_msg_appsecret'];
		
	    if (extension_loaded('curl')){
			
	        $return 	= 	CurlGet($url);
			
	    }else if(function_exists('file_get_contents')){
			
	        $return 	= 	file_get_contents($url);
			
	    }
		
		if($return){
			$msgInfo = json_decode($return,true);
			if($msgInfo['code'] == '200'){
				$returnArr['msgnum'] = $msgInfo['num'];
			}
			unset($return);
		}
		//空号检测
		$url		=	'https://u.phpyun.com/feature';
	    $url		.=	'?appKey='.$this->config['sy_kh_appkey'].'&appSecret='.$this->config['sy_kh_appsecret'];
		
	    if (extension_loaded('curl')){
			
	        $return 	= 	CurlGet($url);
			
	    }else if(function_exists('file_get_contents')){
			
	        $return 	= 	file_get_contents($url);
			
	    }
		
		if($return){
			$msgInfo = json_decode($return,true);
			if($msgInfo['code'] == '200'){
				$returnArr['khnum'] = $msgInfo['num'];
			}
			unset($return);
		}
		//天眼查检测
		$url		=	'https://u.phpyun.com/feature';
	    $url		.=	'?appKey='.$this->config['sy_tyc_appkey'].'&appSecret='.$this->config['sy_tyc_appsecret'];
		
	    if (extension_loaded('curl')){
			
	        $return 	= 	CurlGet($url);
			
	    }else if(function_exists('file_get_contents')){
			
	        $return 	= 	file_get_contents($url);
			
	    }
		if($return){
			$msgInfo = json_decode($return,true);
			if($msgInfo['code'] == '200'){
				$returnArr['businessnum'] = $msgInfo['num'];
			}
		}

		
	    echo json_encode($returnArr);die;
	}


    function get_restnums_action(){
        $user = trim($this->config['sy_msg_appkey']);
        $pass = trim($this->config['sy_msg_appsecret']);
        $url = 'http://api.smsbao.com/query';
        $url.= '?u='.$user.'&p='.md5($pass);
        if(function_exists('file_get_contents')){
            $file_contents = file_get_contents($url);
        }else{
            $ch = curl_init();
            $timeout = 5;
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        $result = explode(",", $file_contents);
        echo $result['1'];

    }

}

?>