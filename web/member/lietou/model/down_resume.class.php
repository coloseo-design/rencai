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
class down_resume_controller extends lietou{
 	function index_action(){
		$where['comid']				=  $this -> uid;
		$where['usertype']			=  $this -> usertype;
		$where['isdel']				=  9;
	    $urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('member',$urlarr);

	    $pageM			=	$this   ->  MODEL('page');
	    $pages			=	$pageM  ->  pageList('down_resume',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $downM  =  $this -> MODEL('downresume');
	        
	        $List   =  $downM  ->  getList($where,array('utype'=>'lietou'));
			$this->yunset("list",$List['list']);
	    }
 	    
		$this->public_action();
		$this->lietou_tpl('down_resume');
 	}
 	function del_action(){
 		if($_POST['delid'] || $_GET['del']){
			if ($_GET['del']){
				$id   =  intval($_GET['del']);
			}elseif ($_POST['delid']){
				$id   =  $_POST['delid'];
			}
			$downM    =  $this->MODEL('downresume');
			$return   =  $downM -> delInfo($id,array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
 		}
 	}
}
?>