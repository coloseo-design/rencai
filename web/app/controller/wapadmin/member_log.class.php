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
class member_log_controller extends adminCommon{ 
	function index_action(){
        $where          =   array();

		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";

		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('member_log',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
			if($_GET['order']){
				$where['orderby']	=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']	=	$_GET['order'];
				$urlarr['t']		=	$_GET['t'];
			}else{
				$where['orderby']	=	array('id,desc');
			}
			$where['limit']			=	$pages['limit'];
			$logM					=	$this -> MODEL('log');
			$rows 					=	$logM -> getMemlogList($where,array('utype'=>'admin'));
			$this -> yunset("rows",$rows);
		}
		$this->yunset("headertitle","日志");
		
		$this->yuntpl(array('wapadmin/admin_memberlog'));
	}

	function del_action(){
		if($_GET['id']||$_GET["del"]){
			if(is_array($_GET["del"])){
				$where['id']	=	array('in',pylode(',',$_GET["del"]));
			}else{
				$where['id']	=	$_GET['id'];
			}
			$logM	=	$this -> MODEL('log');
			
			$return	=	$logM -> delMemlog($where);
			
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}
	}

}
?>