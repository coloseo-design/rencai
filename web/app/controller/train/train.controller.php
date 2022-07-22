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
class train_controller extends common{	
	function public_action(){
		$this->yunset("trainstyle",TPL_PATH."train");
		$this->yunset("train_style",$this->config['sy_weburl']."/app/template/train");
		$this->yunset("uid",$this->uid);
		$this->yunset("username",$this->username);
	}
	function train_tpl($tpl){
		$this->yuntpl(array('train/'.$tpl));
	}
}
?>