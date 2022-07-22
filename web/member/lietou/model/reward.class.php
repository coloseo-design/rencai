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
class reward_controller extends lietou{
	//赏金推荐
	function index_action(){
		$this->public_action();
		$this->yunset("class",14);
		//获取赏金职位信息 
		$packM = $this->MODEL('pack');

		$job = $packM->getRewardJobInfo((int)$_GET['jobid'],array('isjob'=>1));
		

		$this->yunset('job',$job);
		//查询简历库
		$where['uid']	=  $this->uid;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('member',$urlarr);

	    $pageM			=	$this->MODEL('page');
	    $pages			=	$pageM->pageList('lt_talent',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $talentM  =  $this->MODEL('talent');
	        
	        $List   	=  $talentM->getList($where);
	    }
		$this->yunset("rows",$List);
		
		$this->lietou_tpl('talent_reward');
	}
	
	function sqjob_action(){	
		$packM = $this->MODEL('pack');
		$return  = $packM->sqRewardJob($_POST['jobid'],$this->uid,$this->usertype,$_POST['eid']);
		echo json_encode($return);
	}
}
?>