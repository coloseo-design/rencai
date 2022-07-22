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
class ltjob_class_controller extends adminCommon{
	function index_action(){
		$categoryM			=	$this -> MODEL('category');
		$whereData['keyid'] =	'0';
		$position			=	$categoryM -> getLtjobClassList(array('keyid'=>'0'));
		$this->yunset("position",$position);
		$this->yuntpl(array('admin/admin_ltjob'));

	}
	//添加
	function save_action(){
	    $_POST		=	$this -> post_trim($_POST);
	    
		$addData['ctype']	 	= $_POST['ctype'];
		$addData['name']	 	= explode('-',$_POST['name']);
		$addData['keyid'] 		= $_POST['nid'];
		
		$categoryM 				= $this   -> MODEL('category');
		$return					= $categoryM -> addLtjobClass($addData);
		echo $return['msg'];die;
	}
	//分类管理
	function up_action(){
		$categoryM	= $this		->	MODEL('category');
		//查询子类别
		if($_GET['id']){
			$id					=	$_GET['id'];
			$whereOne['id']		=	$id;
			$whereTwo['keyid']	=	$id;
			$whereTwo['orderby']=	'sort,asc';
			$onejob				= 	$categoryM	->	getLtjobClass($whereOne);
			$twojob				=	$categoryM	->	getLtjobClassList($whereTwo);
			$this	->	yunset("id",$id);
			$this	->	yunset("onejob",$onejob);
			$this	->	yunset("twojob",$twojob);
		}
		$position				=	$categoryM	->	getLtjobClassList(array('keyid'=>'0'));
		$this	->	yunset("position",$position);
		$this	->	yuntpl(array('admin/admin_ltjob'));

	}
	
	//删除
	function del_action(){
		$whereData				=	array();
		$data					=	array();
		$categoryM				=	$this	->	MODEL('category');
		if($_GET['delid']){//单个删除
			$this				->	check_token();
			$whereData['id']	=	$_GET['delid'];
			$data['type']		=	'one';	
		}
		if($_POST['del']){//批量删除
			$whereData['id']	=	array('in',pylode(',',$_POST['del']));
			$data['type']		=	'all';	
		}
		$return	=	$categoryM	->	delLtjobClass($whereData,$data);
		$this   ->  layer_msg( $return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER'],2,1);
	}
	
	function ajax_action(){
		$categoryM			=	$this	->	MODEL('category');
		$whereData['id']	=	$_POST['id'];
		$addData['sort']	=	$_POST['sort'];
		$addData['name']	=	$_POST['name'];
		
		$categoryM	->	addLtjobClass($addData,$whereData);
		echo '1';
		die;
	}
}

?>