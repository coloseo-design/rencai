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
class admin_mobliemsg_controller extends adminCommon{
	function index_action(){
		$MobilemsgM		=	$this -> MODEL('mobliemsg');
		$where			=	array();
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('moblie_msg',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows				=	$MobilemsgM -> getList($where);
		}
		$this->yunset("rows",$rows['list']);
		$this->yunset("headertitle","短信记录");
		$this->yuntpl(array('wapadmin/admin_mobliemsg'));
	}
	function del_action(){
		$MobilemsgM	=	$this -> MODEL('mobliemsg');
		$delid		=	(int)$_GET['id'];
		if(!$delid){
			$this->layer_msg('请选择要删除的记录！',8,0,$_SERVER['HTTP_REFERER']);
		}
		$del	=	$MobilemsgM -> delMoblieMsg(array('id'=>$delid),array('type'=>'one'));
		if($del){
		    $this->layer_msg('短信记录(ID:'.$delid.')删除成功！',9,0,$_SERVER['HTTP_REFERER']);
		}else{
		    $this->layer_msg('删除失败！',8);
		}
	}
}

?>