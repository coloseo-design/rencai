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
class admin_tiny_controller extends adminCommon{
	function index_action(){  
		$TinyM	=	$this -> MODEL('tiny');
		$where	=	array();
		if($_GET['status']){
			if($_GET['status']=='2'){
				$where['status']	=	'0';
			}else{
				$where['status']	=	$_GET['status'];
			}
			$urlarr['status']	=	$_GET['status'];
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this -> MODEL('page');
		$pages	=	$pageM -> pageList('resume_tiny',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows				=	$TinyM -> getResumeTinyList($where);
		}
		$this->yunset("rows",$rows['list']);	
		$this->yunset('backurl','index.php?c=user');
		$this->yunset("headertitle","普工简历");	
		$this->yuntpl(array('wapadmin/admin_tiny'));
	}
	function show_action(){
		$TinyM	=	$this -> MODEL('tiny');
		if(intval($_GET['id'])){
			$row	=	$TinyM -> getResumeTinyInfo(array('id'=>intval($_GET['id'])));
		}
		$lasturl	=	$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=show')===false){
		    if(strpos($lasturl, 'c=admin_tiny')!==false){
		        $_COOKIE['lasturl']	=	$lasturl;
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		$this->yunset("row",$row);		
		$this->yunset('headertitle','普工简历详情');
		$this->yuntpl(array('wapadmin/admin_tiny_show'));
	}
	function status_action(){//审核
		$TinyM	=	$this -> MODEL('tiny');
		$status	=	$TinyM -> setResumeTinyStatus(intval($_POST['id']),array('status'=>intval($_POST['status'])));
	    if ($_POST['lasturl']!=''){
	        $lasturl	=	$_POST['lasturl'];
	    }else{
	        $lasturl	=	$_SERVER['HTTP_REFERER'];
	    }
		if($status){
			$this->layer_msg('普工简历(ID:'.$_POST['id'].')审核设置成功',9,0,$lasturl);
		}else{
			$this->layer_msg('设置失败！',8);
		}
	}
	function del_action(){
		$TinyM	=	$this -> MODEL('tiny');
		if(intval($_GET['id'])){
			$del	=	$TinyM -> delResumeTiny(intval($_GET['id']));
			if($del){
	            $this->layer_msg('普工简历(ID:'.intval($_GET["id"]).')删除成功！',9,0,'index.php?c=admin_tiny');
	        }else{
	            $this->layer_msg('删除失败！',8);
	        }
		}
	}
}
?>