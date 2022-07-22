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
class passwd_controller extends lietou
{
	function index_action(){
		
		$UserinfoM	=	$this -> MODEL('userinfo');
		
		if($_POST['submit']){
			
			$data	=	array(
				
				'uid'          	 =>  intval($this->uid),
				
				'usertype'     	 =>  $this->usertype,
				
				'oldpassword'  	 =>  trim($_POST['oldpassword']),
				
				'password'     	 =>  trim($_POST['password']),
				
				'repassword'   	 =>  trim($_POST['password2'])
			
			);
			
			$info	=	$UserinfoM -> getInfo(array('uid'=> $this->uid));
			
			if(is_array($info)){
				
				$err	=	$UserinfoM -> savePassword($data);
			
			}
			
			
			
			if($err['errcode'] == '8'){ 
                    
				$this -> ACT_layer_msg($err['msg'], $err['errcode'], "index.php?c=passwd");
                
			}else{
                $this->cookie->unset_cookie();   
				$this -> ACT_layer_msg($err['msg'], $err['errcode'], $this->config['sy_weburl'] . "/index.php?m=login");
                
			}
		
		}
		
		$this->public_action();
		
		$this->yunset("class","6");
		
		$this->lietou_tpl('passwd');
	}
	
}
?>