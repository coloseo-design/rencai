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
class index_controller extends lietou{
	function index_action(){
		$jobM			=	$this -> MODEL('job');
		$ltM			=	$this -> MODEL('lietou');
		$ltjobM			=	$this -> MODEL('lietoujob');
		$downresumeM	=	$this -> MODEL('downresume');
		
		
		//已下载简历数
		$downnum		=	$downresumeM -> getDownNum(array('comid' => $this -> uid,'usertype'=>$this->usertype,'isdel'=>9));
		$this -> yunset("downnum",$downnum);
		
		//应聘来的简历数
		$ypnum			=	$jobM -> getSqJobNum(array('com_id' => $this -> uid,'type'=>3,'isdel'=>9));
		$this -> yunset("ypnum",$ypnum);
		
		//招聘中的职位数
		$jobnum			=	$ltjobM -> getLtjobNum(array('uid' => $this->uid, 'status' => '1', 'zp_status' => array('<>','1')));
		$this -> yunset("jobnum",$jobnum);
		
		//应聘来的简历
		$yqresume		=	$jobM -> getSqJobList(array('com_id' => $this -> uid,'isdel'=>9,'type'=>3, 'is_browse' => 1,'limit' => 10));
		$this -> yunset("yqresume",$yqresume);
		
		//待处理的推荐简历
		if($_GET['type']=='recresume'){
			
			$recresume	=	$ltM -> getRebatesList(array('job_uid' => $this -> uid,'status' => 0,'orderby' => 'id,desc','limit' => 10));
			$this -> yunset("recresume",$recresume);
		}
		
		$this -> public_action();
		$this -> seo("ltindex");
		$this -> lietou_tpl('index');
	}
}
?>