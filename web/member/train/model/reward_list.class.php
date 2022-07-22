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
class reward_list_controller extends train{
	function index_action(){
		
		$redeemM		=	$this->MODEL('redeem');
		
		$where['uid']	    =	$this->uid;
		$where['usertype']	=	$this->usertype;
		
		$urlarr['c']	=	"reward_list";
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url('member',$urlarr);
		$pageM			=	$this  -> MODEL('page');	  
		$pages			=	$pageM -> pageList('change',$where,$pageurl,$_GET['page']);
		
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');
		
		$rowlist	=			$redeemM->getChangeList($where);
		$rows		=	$rowlist['list'];
		$this->yunset("rows",$rows);

		$num	=	$redeemM->getChangeNum($where);
		$this->yunset("num",$num);

		$statis				=	$this->train_satic();
		$statis['integral']	=	number_format($statis[integral]);
		$this->yunset("statis",$statis);

		$this->train_tpl('reward_list');
	}
	
	function del_action(){

		$redeemM	=	$this->MODEL('redeem');
		$return		=	$redeemM->delChange('',array('id'=>(int)$_GET['id'],'uid'=>$this->uid));

		$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
	}
}
?>