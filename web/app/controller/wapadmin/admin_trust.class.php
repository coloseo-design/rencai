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
class admin_trust_controller extends adminCommon{
	function index_action(){
		$UserEntrustM	=	$this -> MODEL('userEntrust');
		if($_GET['status']=='3'){
			$where['status']	=	'0';
			$urlarr['status']	=	$_GET['status'];
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('user_entrust',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'add_time';
			$where['limit']		=	$pages['limit'];
			$rows				=	$UserEntrustM -> getList($where,array('utype'=>'admin'));
		}
		$this->yunset("rows",$rows);	
		$this->yunset("rows",$rows);
		$this->yunset('backurl','index.php?c=user');
		$this->yunset('headertitle','委托简历');
		$this->yuntpl(array('wapadmin/admin_trust'));
	}
	function status_action(){
		$UserEntrustM	=	$this -> MODEL('userEntrust');
		$return  		=  	$UserEntrustM -> statusEntrust(array('id'=>intval($_POST['id'])),array('post'=>array('status'=>intval($_POST['status']))));
	    if ($_POST['lasturl']!=''){
		    $lasturl	=	$this->post_trim($_POST['lasturl']);
		}else{
		    $lasturl	=	$_SERVER['HTTP_REFERER'];
		}
		$this->layer_msg($return['msg'],$return['errcode'],0,$lasturl);
	}
	
	function show_action(){
		$UserEntrustM	=	$this -> MODEL('userEntrust');
		$row			=	$UserEntrustM -> getInfo(array('id'=>intval($_GET['id'])),array('eid'=>intval($_GET['eid'])));
		$lasturl		=	$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=show')===false){
    		if(strpos($lasturl, 'c=admin_trust')!==false){
    		        $_COOKIE['lasturl']	=	$lasturl;
    		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
    		    }
		}
		$this->yunset('row',$row);
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		$this->yunset('headertitle','委托简历设置');
		$this->yuntpl(array('wapadmin/admin_trust_show'));
	}

	function del_action(){
		$UserEntrustM	=	$this -> MODEL('userEntrust');
		if(intval($_GET["id"])){
			$del	=	$UserEntrustM->delInfo(intval($_GET['id']));
			if($del['errcode']==9){
		        $this->layer_msg('委托简历(ID:'.intval($_GET['id']).')删除成功！',9,0,'index.php?c=admin_trust');
		    }else{
		        $this->layer_msg('删除失败！',8);
		    }
		}
	}

}

?>