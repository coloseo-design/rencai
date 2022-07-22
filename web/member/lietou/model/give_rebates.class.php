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
class give_rebates_controller extends lietou{
	//推荐给我的返利
	function index_action(){
		$this->public_action();
		$this->yunset("class",15);
		
		$lietouM			=	$this -> MODEL('lietou');
		
		$where['job_uid']	=	$this -> uid;
		
		$urlarr		=	array("c"=>$_GET['c'],"page"=>"{{page}}");
		
		$pageurl	=	Url('member',$urlarr);
		
		$pageM		=	$this  -> MODEL('page');
		
		$pages		=	$pageM -> pageList('rebates',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$lietouM -> getRebatesList($where,array('isjob'=>'yes'));
			
			$this->yunset("rows" , $List);
			
		}
		
		$this->lietou_tpl('give_rebates');
	}
	function save_action(){
		if($_POST){
			$data['reply']		=	$_POST['reply'];
			
			$data['reply_time']	=	time();
			
			$data['status']		=	"1";
			
			$where['id']		=	(int)$_POST['id'];
			
			$where['job_uid']	=	$this->uid;
			
			$this -> MODEL('lietou') -> upRebates($data,$where);
			
			$this -> MODEL('log') -> addMemberLog($this->uid,$this->usertype,"回复推荐给我的返利",18,2);//会员日志
			
 			echo 1;die;
		}
	}
	function set_action(){
		if($_POST['id']){
			$where['id']		=	(int)$_POST['id'];
			
			$where['job_uid']	=	$this->uid;
			
			$nid = $this -> MODEL('lietou') -> upRebates(array("status"=>intval($_POST['status'])),$where);
			
			echo 1;die;
		}
	}
	function del_action(){
		if($_GET['id']){
			$id			=	(int)$_GET['id'];
			$ltM		=	$this -> MODEL('lietou');
			$result		=	$ltM -> delRebates($id,array('uid'=>$this->uid,'usertype'=>$this->usertype,'type'=>2));//type==2推荐给我的人才
			$this -> layer_msg($result['msg'],$result['errcode'], $result['layertype'], $_SERVER['HTTP_REFERER']);
		}
	}
}
?>