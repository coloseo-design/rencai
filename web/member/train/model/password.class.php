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
class password_controller extends train{
	function index_action(){
		if($_POST['submit']){
			$UserinfoM  =   $this->MODEL('userinfo');
			$data   	=   array(
                
                'uid'           =>  $this->uid,
                'usertype'      =>  $this->usertype,
                'oldpassword'   =>  $_POST['oldpassword'],
                'password'      =>  $_POST['password'],
                'repassword'    =>  $_POST['repassword']
                
            );
			$err    =   $UserinfoM -> savePassword($data);
			

			if($err['errcode'] == '8'){
                     
                $this -> ACT_layer_msg($err['msg'], $err['errcode'],$_SERVER['HTTP_REFERER']);
                
            }else{
                $this -> cookie -> unset_cookie();
                $this -> ACT_layer_msg($err['msg'], $err['errcode'], $this->config['sy_weburl'] ."/train/index.php?c=login");
                
            }
		}
		$this	->	train_satic();
		$this	->	train_tpl('password');
	}
}
?>