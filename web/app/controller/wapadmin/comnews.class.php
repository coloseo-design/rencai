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
class comnews_controller extends adminCommon{
	function index_action(){
		$CompanyM 		= 	$this->MODEL('company');
		$where			=	array();
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this  -> MODEL('page');
		$pages	=	$pageM -> pageList('company_news',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows				=	$CompanyM -> getCompanyNewsList($where);
		}
		$this->yunset("rows",$rows);
		$this->yunset('backurl','index.php?c=company');
		$this->yunset("headertitle","企业新闻");
		$this->yuntpl(array('wapadmin/admin_comnews'));
	}
	function show_action(){
		$CompanyM	=	$this->MODEL('company');
		$row		=	$CompanyM->getCompanyNewsLockInfo(intval($_GET['id']));
		$lasturl	=	$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=show')===false){
		    if(strpos($lasturl, 'c=comnews')!==false){
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		        $_COOKIE['lasturl']	=	$lasturl;
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		$this->yunset('row',$row);
		$this->yunset("headertitle","企业新闻设置");
		$this->yuntpl(array('wapadmin/admin_comnews_show'));
	}
	function status_action(){
		$CompanyM	=	$this -> MODEL('company');
		$SysmsgM 	= 	$this -> MODEL('sysmsg');
		if($_POST['id']){
			$statusData		=	array(
				'status'		=>	intval($_POST['status']),
				'statusbody'	=>	trim($_POST['statusbody']),
			);
			$nid	=	$CompanyM -> upCompanyNewsStatus(intval($_POST['id']),$statusData);
			 if ($_POST['lasturl']!=''){
	            $lasturl	=	$this->post_trim($_POST['lasturl']);
	        }else{
	            $lasturl	=	$_SERVER['HTTP_REFERER'];
	        }
			if($nid){
	            $this->layer_msg('企业新闻审核(ID:'.$_POST['id'].')设置成功！',9,0,$lasturl);
	        }else{
	            $this->layer_msg('设置失败！',8);
	        }
		}
	}
	function del_action(){
		$CompanyM	=	$this -> MODEL('company');
		if($_GET['id']){
			$return	=	$CompanyM -> delCompanyNews(intval($_GET['id']),array('uid'=>$this->uid,'usertype'=>$this->usertype));
			if($return['errcode']==9){
				$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],'index.php?c=comnews');
			}else{
				$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
			}
		}
	}
}
?>