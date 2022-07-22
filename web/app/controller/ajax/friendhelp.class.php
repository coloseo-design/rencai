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

class friendhelp_controller extends common{
    //获取当前任务权益 或 系统默认权益
	function nowpackage_action(){
	
		$helpM		=	$this -> MODEL('friendhelp');

		$package	=	$helpM -> getPackageInfo($this -> uid);
		
		if($package){
			echo json_encode($package);
		}	
		
	
	}

    //邀请好友助力
	function addhelp_action(){
	
		if($this -> config['sy_help_open'] !='1'){

			$this->layer_msg('暂未开启好友助力！', 8, 0);
		}
		
		$helpM	=	$this -> MODEL('friendhelp');

		$return	=	$helpM -> addHelp($this->uid);
		
		echo json_encode($return);
		
	
	}

	//邀请好友助力-获取二维码
	function gethelpcode_action(){
		
		if($_GET['id'] && $_GET['token']){

			$url	=	 Url('wap').'index.php?c=friendhelp&a=show&id='.intval($_GET['id']).'&token='.rawurlencode($_GET['token']);
			

			include_once LIB_PATH."yunqrcode.class.php";
			YunQrcode::generatePng2($url,4);
		}
	}
	
}
?>