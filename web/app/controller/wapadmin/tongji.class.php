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
class tongji_controller extends adminCommon{ 
	function index_action(){ 
		$jobM		=	$this->MODEL('job');
		
		$linkM		=	$this->MODEL('link');
		
		$resumeM	=	$this->MODEL('resume');
		
		$companyM	=	$this->MODEL('company');
		
		$userinfoM	=	$this->MODEL('userinfo');
		
		$comorderM	=	$this->MODEL('companyorder');
		
		$today		=	strtotime('today');
		
		$yesterday	=	$today-86400;
		
		$tocomwh['usertype']		=	$yestercomwh['usertype']	=	'2';
		
		$tocomwh['reg_date']		=	array('>=',$today);
		
		$yestercomwh['reg_date'][]	=	array('>=',$yesterday);
		
		$yestercomwh['reg_date'][]	=	array('<',$today);
		
		$com['today']		=	$userinfoM -> getMemberNum($tocomwh);
		
		$com['yesterday']	=	$userinfoM -> getMemberNum($yestercomwh);
		
		$yesterjobwh['sdate'][]	=	array('>=',$yesterday);
		
		$yesterjobwh['sdate'][]	=	array('<',$today);
		
		$job['today']		=	$jobM -> getJobNum(array('sdate'=>array('>=',$today)));
		
		$job['yesterday']	=	$jobM -> getJobNum($yesterjobwh);
		
		$touserwh['usertype']		=	$yesteruserwh['usertype']=	'1';
		
		$touserwh['reg_date']		=	array('>=',$today);
		
		$yesteruserwh['reg_date'][]	=	array('>=',$yesterday);
		
		$yesteruserwh['reg_date'][]	=	array('<',$today);
		
		$user['today']		=	$userinfoM -> getMemberNum($touserwh);
		
		$user['yesterday']	=	$userinfoM -> getMemberNum($yesteruserwh);
		
		$yesterresumewh['ctime'][]	=	array('>=',$yesterday);
		
		$yesterresumewh['ctime'][]	=	array('<',$today);
		
		$resume['today']	=	$resumeM -> getExpectNum(array('ctime'=>array('>=',$today)));
		
		$resume['yesterday']=	$resumeM -> getExpectNum($yesterresumewh);
		
		$check['job']	=	$jobM -> getJobNum(array('state'=>'0'));
		
		$check['link']	=	$linkM -> getLinkNum(array('link_state'=>'0'));
		
		$check['order']	=	$comorderM -> getCompanyOrderNum(array('order_state'=>'3'));
		
		$check['com']	=	$companyM -> getCertNum(array('type'=>'3','status'=>'0'));
		
		$check['user']	=	$resumeM -> getResumeNum(array('idcard_status'=>'0','idcard_pic'=>array('<>','')));
		
		$this->yunset("resume",$resume);
		
		$this->yunset("user",$user);
		
		$this->yunset("com",$com);
		
		$this->yunset("job",$job);
		
		$this->yunset("check",$check);
		
		$this->yunset("headertitle","统计管理");
		$this->yuntpl(array('wapadmin/admin_tongji'));
	} 
}

?>