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
class team_add_controller extends train{
	function index_action(){
    //$train    =   $this->pxInfo;
		//print_r($train);
    	if($_GET['id']){
			$trainM		=	$this	->	MODEL('train');
			$row		=	$trainM	->	getTeaInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid));
			$this	->	yunset("row",$row);
		}
		$this	->	yunset($this->MODEL('cache')->GetCache(array('city','hy','subject')));
		$this	->	train_satic();
		$this	->	train_tpl('team_add');
	}
	function save_action(){
		$_POST					=	$this->post_trim($_POST);
		$pinfo					=	$this->pxInfo;
		$rstatus				=	$pinfo['r_status'];
	
	    $data['name']			=	$_POST['name'];
	    $data['sid']			=	$_POST['sid'];
	    $data['hy']				=	$_POST['hy'];
	    $data['provinceid']		=	$_POST['provinceid'];
	    $data['cityid']			=	$_POST['cityid'];
	    $data['threecityid']	=	$_POST['threecityid'];
	    $data['content']		=	$_POST['content'];
	    $data['r_status']		=	$rstatus;
	    $data['ctime']			=	time();
	    $data['file']			=	$_FILES['file'];
	    $data['status']			=	0;
	    $trainM					=	$this->MODEL('train');
		if($_POST['id']){
	        $where['uid']	=	$this	->	uid;
	        $where['id']	=	$_POST['id'];
	        $return			=	$trainM	->	upTeaInfo(
	        	array('id'=>$_POST['id'],'uid'=>$this->uid)
	        	,$data
	        	,array('uid'=>$this->uid,'usertype'=>$this->usertype,'member'=>'train')
	        );
	    }else{
	        $data['uid']	=	$this	->	uid;
	        $data['did']	=	$this	->	userdid;
	        $return			=	$trainM	->	addTeaInfo(
	        	$data
	        	,array('uid'=>$this->uid,'usertype'=>$this->usertype,'member'=>'train')
	        );
	    }
	    $this->ACT_layer_msg($return['msg'],$return['cod'],$return['url']);
	}
}
?>