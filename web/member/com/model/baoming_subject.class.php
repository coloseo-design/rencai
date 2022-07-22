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
class baoming_subject_controller extends company{
	/*
	查看报名培训课程列表页面
	**/
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		
		$trainM		=	$this->MODEL('train');
		
		$this		->	public_action();
		
		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;
		
		$urlarr['page']	=	'{{page}}';
		
		$urlarr['c']	=	"baoming_subject";
		
		$pageurl		=	Url('member',$urlarr);
		
		$pageM			=	$this -> MODEL('page');
		
		$pages			=	$pageM -> pageList('px_baoming',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['orderby']	=	'id,desc';
			
		    $where['limit']		=	$pages['limit'];
			
		    $List				=	$trainM->getBmList($where,array('scene'=>'detail'));
			
			$this->yunset("rows",$List);
		}
		
		$this	->	yunset("arr_data", $arr_data);
		$this	->	com_tpl('baoming_subject');
	}
	
	/*
	取消培训课程报名
	**/
	function del_action(){
		$trainM		=	$this -> MODEL('train');
		
		if($_GET['id']){
			
			$return	=	$trainM -> delBm(array('id'=>$_GET['id']),array('usertype'=>$this->usertype,'uid'=>$this->uid));
			
			if($return['errcode']==9){
				
				$msg	=	'取消成功';
			}else{
				
				$msg	=	'取消失败';
			}
			
			$this -> layer_msg($msg, $return['errcode'], 0, "index.php?c=baoming_subject");
			
		}
	}
}
?>