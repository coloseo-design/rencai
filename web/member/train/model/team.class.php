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
class team_controller extends train
{
	function index_action(){
		$trainM	=	$this	->	MODEL('train');
		if($_GET['del']){
			$return	=	$trainM	->	delTea(
				array('id'		=>	(int)$_GET['del'],'uid'	=>	$this->uid)
				,array('uid'	=>	$this->uid,'usertype'=>	$this->usertype,'member'=>'train'));
			$this	->	layer_msg($return['msg'],$return['cod'],$return['laytype'],$return['url']);
		}
		
		$where['status']		=	isset($_GET['status'])	?	intval($_GET['status']) : '1';
		$where['uid']			=	$this->uid;
		$where['orderby']		=	'id,desc';
		$urlarr['c']			=	$_GET['c'];
		$urlarr['page']			=	"{{page}}";
		$pageurl				=	Url('member',$urlarr);
		$pageM					=	$this  -> MODEL('page');
		$pages					=	$pageM -> pageList('px_teacher',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
		    
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$trainM	->	getTeaList($where);
		    $this	->	yunset("rows",$rows);
		    $this	->	yunset("total",$pages['total']);
		}

		$this	->	yunset($this->MODEL('cache')->GetCache(array('city','hy','subject')));
		$this	->	yunset("def","2");
		$this	->	train_satic();
		$this	->	train_tpl('team');
	}
	function statusbody_action(){
		if(intval($_POST['id'])){
			$trainM	=	$this	->	MODEL('train');
			$msg	=	$trainM	->	getTeaInfo(array('id'=>intval($_POST['id'])),array('field'=>'statusbody'));
			echo $msg['statusbody'];die;
		}
	}
}
?>