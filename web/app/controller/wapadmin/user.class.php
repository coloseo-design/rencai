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
class user_controller extends adminCommon{
	function index_action(){  
		$tinyM		=	$this->MODEL('tiny');
		$resumeM	=	$this->MODEL('resume');
		$userinfoM	=	$this->MODEL('userinfo');
		$entrustM	=	$this->MODEL('userEntrust');
		$list['user_num_dsh']		=	$userinfoM -> getMemberNum(array('usertype'=>'1','status'=>'0'));//待审核个人会员
		$list['resume_num_dsh']		=	$resumeM -> getExpectNum(array('r_status'=>'0'));//待审核个人会员
		$list['wtresume_num_dsh']	=	$entrustM -> getEntrustNum(array('status'=>'0'));//待审核委托简历
		$list['usercert_num_dsh']	=	$resumeM -> getResumeNum(array('idcard_pic'=>array('<>',''),'idcard_status'=>'0'));//待审核个人认证
		$list['tiny_num_dsh']		=	$tinyM -> getResumeTinyNum(array('status'=>'0'));//待审核普工简历
		$this->yunset("list",$list);

		$this->yunset('backurl','index.php');
		$this->yunset("headertitle","个人用户管理");
		$this->yuntpl(array('wapadmin/user'));
	}
	function logout_action(){
		$this->adminlogout();
		$this->layer_msg("您已成功退出！",9,0,"index.php");
	}
}
?>