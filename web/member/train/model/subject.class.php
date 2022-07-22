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
class subject_controller extends train{
	function index_action(){
			
		$TrainM	=	$this->MODEL('train');
		$LogM	=	$this->MODEL('log');
		
		if((int)$_GET['pause_status']){//设置显示状态
		
			$nid	=	$TrainM->upSubInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid),array('pause_status'=>(int)$_GET['pause_status']));
			
			if($nid){

				$LogM->addMemberLog($this->uid,$this->usertype,"设置培训课程显示状态",21,3);

				$this->layer_msg('显示状态设置成功！',9,0,$_SERVER['HTTP_REFERER']);

			}else{
				$this->layer_msg('显示状态设置失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
		if($_GET['del']){
			$id		=	(int)$_GET['del'];
			$return	=	$TrainM->delsubInfo($id,array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}
		$status	=	intval($_GET['status']);
		if($status=="1"){

			$where['status']		=	0;
			$where['pause_status']	=	1;
			$urlarr['status']		=	$status;
		}elseif($status=="2"){
			
			$where['status']		=	2;
			$where['pause_status']	=	1;
			$urlarr['status']		=	$status;
		}else{
			$where['status']		=	1;
			$where['pause_status']	=	1;
		}
		$pstatus	=	$_GET['pstatus'];

		if($pstatus=="2"){

			$where['pause_status']	=	2;
			$urlarr['pstatus']		=	$pstatus;
		}	
		$where['uid']	=	$this->uid;
		$urlarr['c']	=	"subject";
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url('member',$urlarr);
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_subject',$where,$pageurl,$_GET['page']);
	
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows	=	$TrainM->getSubList($where);
		
		if(is_array($rows)){

			foreach ($rows as $key=>$val){
				if($val['pic']){
					$rows[$key]['pic']	=	$val['pic'];
				}else{
					$rows[$key]['pic']	=	$this->config['sy_pxsubject_icon'];
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->yunset("def","1");

		$this->train_satic();

		$this->train_tpl('subject');
	}
	function statusbody_action(){
		$TrainM	=	$this->MODEL('train');
		$id		=	intval($_POST['id']);

		if($id){
			$msg	=	$TrainM->getSubInfo(array('id'=>$id),array('field'=>'statusbody'));
			echo $msg['statusbody'];die;
		}
	}
}
?>