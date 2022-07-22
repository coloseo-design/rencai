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
class company_controller extends adminCommon{
	function index_action(){  
		$this->yunset("headertitle","企业管理");
		$JobM		=	$this -> MODEL('job');
		$CompanyM	=	$this -> MODEL('company');
		$OnceM		=	$this -> MODEL('once');
		$list['job_num_dsh']		=	$JobM -> getJobNum(array('state'=>'0'));//待审核职位
		$list['com_num_dsh']		=	$CompanyM -> getCompanyNum(array('r_status'=>'0'));//待审核企业会员
		$list['comcert_num_dsh']	=	$CompanyM -> getCertNum(array('type'=>'3','status'=>'0'));//待审核企业认证
		$list['comnews_num_dsh']	=	$CompanyM -> getCompanyNewsNum(array('status'=>'0'));//待审核企业新闻
		$list['comproduct_num_dsh']	=	$CompanyM -> getCompanyProductNum(array('status'=>'0'));//待审核企业产品
		$list['oncejob_num_dsh']	=	$OnceM -> getOnceNum(array('status'=>'0'));//待审核店铺招聘
		$this->yunset("list",$list);
		$this->yunset('backurl','index.php');
		$this->yuntpl(array('wapadmin/company'));
	}
	function logout_action(){
		$this->adminlogout();
		$this->layer_msg("您已成功退出！",9,0,"index.php");
	}
}
?>