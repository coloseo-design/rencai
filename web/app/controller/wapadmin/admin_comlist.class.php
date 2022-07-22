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
class admin_comlist_controller extends adminCommon{
	function index_action(){ 
		$CompanyM	=	$this -> MODEL('company');
		if(trim($_GET['keyword'])){
			$where['name']		=	array('like',trim($_GET['keyword']));
			$urlarr['keyword']	=	$_GET['keyword'];
		}
		if ($_GET['status']) {
			$status				=	intval($_GET['status']);
			$where['r_status']	=	$status == 4 ? 0 : $status;
			$urlarr['status']	=	$status;
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company', $where, $pageurl, $_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'uid';
			$where['limit']		=	$pages['limit'];
			$rows				=	$CompanyM -> getList($where,array('utype'=>'admin'));
		}
        $this->yunset("rows",$rows['list']);
        $this->yunset("backurl",'index.php?c=company');
        $this->yunset("headertitle","公司管理");
		$this->yuntpl(array('wapadmin/admin_comlist'));
	}
	function edit_action(){
		$CompanyM	=	$this -> MODEL('company');
		if(intval($_GET['id'])){
			$row		=	$CompanyM -> getInfo(intval($_GET['id']),array('logo'=>'1','utype'=>'admin','crm'=>'1'));
			$this->yunset($this->MODEL('cache')->GetCache(array('city','hy','com'))); 
			$lasturl	=	$_SERVER['HTTP_REFERER'];
			if(strpos($lasturl, 'a=show')===false){
				if(strpos($lasturl, 'c=admin_comlist')!==false){
					$this->cookie->setcookie('lasturl',$lasturl,time()+300);
					$_COOKIE['lasturl']	=	$lasturl;
				}
			}
			$this->yunset("row",$row);
		} 
		$this->yunset("headertitle","公司审核");
		$this->yuntpl(array('wapadmin/admin_comshow'));
	}
	function status_action(){
		$UserinfoM	=	$this -> MODEL('userinfo');
		$statusData	=	array(
			'status'		=>	intval($_POST['status']),
			'lock_info'		=>	trim($_POST['statusbody']),
		);
		$return		=	$UserinfoM -> status(array('uid'=>intval($_POST['id']),'usertype'=>'2'),array('post'=>$statusData));
		if($return['errcode']==9){
			$this->layer_msg($return['msg'],$return['errcode'],0,'index.php?c=admin_comlist');
		}else{
			$this->layer_msg($return['msg'],$return['errcode'],0,'index.php?c=admin_comlist&a=status');
		}
	}
	function del_action(){
		$UserinfoM	=	$this -> MODEL('userinfo');
		$return     =   $UserinfoM -> delInfo(intval($_GET['del']), 2);
		if($return){
			$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],'index.php?c=admin_comlist');
		}else{
			$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}
	}
}
?>