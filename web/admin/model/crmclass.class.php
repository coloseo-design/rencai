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
class crmclass_controller extends adminCommon{
    
	function index_action(){
		$categoryM			=	$this -> MODEL('category');
	
		$whereData['keyid'] =	'0';
		
		$position			=	$categoryM -> getCrmClassList($whereData);

		$this	->	yunset('position',$position);
		$this	->	yuntpl(array('admin/crm_class'));
	}
	
	function save_action(){
	    $_POST		=	$this -> post_trim($_POST);
	    
		$addData['ctype']	 	= $_POST['ctype'];
		$addData['name']	 	= explode('-',$_POST['name']);
		$addData['variable']	= explode('-',$_POST['str']);
		$addData['keyid'] 		= $_POST['nid'];
		
		$categoryM 				= $this   -> MODEL('category');
		$return					= $categoryM -> addCrmClass($addData);
		echo $return['msg'];die;
	}
	
	function up_action(){

	    $categoryM	= $this		->	MODEL('category');
		
		//查询子类别
		if($_GET['id']){
			$id					=	$_GET['id'];
			$whereOne['id']		=	$id;
			$whereTwo['keyid']	=	$id;
			$whereTwo['orderby']=	'sort,asc';
			$class1				= 	$categoryM	->	getCrmClass($whereOne);
			$class2				=	$categoryM	->	getCrmClassList($whereTwo);
			$this	->	yunset("id",$id);
			$this	->	yunset("class1",$class1);
			$this	->	yunset("class2",$class2);
		}
		$position				=	$categoryM	->	getCrmClassList(array('keyid'=>'0'));
		$this	->	yunset("position",$position);
		$this	->	yuntpl(array('admin/crm_class'));
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
		$return	=	$categoryM	->	delCrmClass($whereData,$data);
		$this   ->  layer_msg( $return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER'],2,1);
	}
	
	function ajax_action(){
		$categoryM			=	$this	->	MODEL('category');
		$whereData['id']	=	$_POST['id'];
		$addData['sort']	=	$_POST['sort'];
		$addData['name']	=	$_POST['name'];
		
		$categoryM	->	addCrmClass($addData,$whereData);
		echo '1';
		die;
	}
	
	function upCache_action() {
	    
        include_once (LIB_PATH . 'cache.class.php');
        $cacheclass = new cache(PLUS_PATH, $this->obj);
        $makecache = $cacheclass->crm_cache('crm.cache.php');

        echo $makecache ? 1 : 0;
        die();
    }
    
}
?>