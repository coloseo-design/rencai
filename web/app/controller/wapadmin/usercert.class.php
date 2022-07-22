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
class usercert_controller extends adminCommon{
	function index_action(){  
		$where['idcard_pic']	=	array('<>','');
		if($_GET['status']){
			if($_GET['status']==1){
				$where['idcard_status']	=	'1';
			}else if($_GET['status']==2){
				$where['idcard_status']	=	'0';
			}
			$urlarr['status']	=	$_GET['status'];
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this -> MODEL('page');
		$pages			=	$pageM -> pageList('resume',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			if($_GET['order']){
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	array('idcard_status,ASC','cert_time,DESC');
			}
			$where['limit']				=	$pages['limit'];
			$resumeM	=	$this -> MODEL('resume');
			$List		=	$resumeM -> getResumeList($where,array('utype'=>'admin'));
			$this -> yunset('rows',$List);
		}
		$this->yunset("backurl", basename($_SERVER['HTTP_REFERER']));
		$this->yunset("headertitle","个人认证");
		$this->yuntpl(array('wapadmin/usercert'));
	}
	function show_action(){  
	    $row = $this -> MODEL('resume') -> getResumeInfo(array('uid'=>$_GET['id']),array('logo'=>'1'));
	    
	    $lasturl=$_SERVER['HTTP_REFERER'];
	    if(strpos($lasturl, 'a=show')===false){
	        if(strpos($lasturl, 'c=usercert')!==false){
	            $this->cookie->setcookie('lasturl',$lasturl,time()+300);
	            $_COOKIE['lasturl']=$lasturl;
	        }
	    }
	    $this->yunset('lasturl',$_COOKIE['lasturl']);
	    
		$this->yunset("row",$row);
		$this->yunset("headertitle","个人认证设置");
		$this->yuntpl(array('wapadmin/usercert_show'));
	}
	
	function idcard_status_action(){
	    if($_POST['id']){
			$resumeM	=	$this -> MODEL('resume');
			$post		=	array(
				'idcard_status'	=>	intval($_POST['status']),
				'statusbody'	=>	trim($_POST['statusbody'])
			);
			$return		=	$resumeM -> statusCert($_POST['id'],array('post'=>$post));
			$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	    }
	}
	
	function del_action(){
		if(is_array($_GET['del'])){
			$linkid	=	pylode(',',$_GET['del']);
		}else{
			$linkid	=	$_GET['id'];
		}		
		$resumeM	=	$this -> MODEL('resume');
		$return		=	$resumeM -> delResumeCert($linkid);
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
}
?>