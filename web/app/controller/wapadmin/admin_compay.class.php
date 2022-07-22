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
class admin_compay_controller extends adminCommon{
	function index_action(){
		$OrderM	=	$this -> MODEL('companyorder');
		$where	=	array();
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM	=	$this -> MODEL('page');
		$pages	=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows				=	$OrderM -> getPayList($where,array('utype'=>'admin'));
		}
		$this->yunset("rows",$rows);
		$this->yunset("headertitle","消费记录");
		$this->yuntpl(array('wapadmin/admin_compay'));
	}

	function del_action(){
		$OrderM	=	$this -> MODEL('companyorder');
	    $delid	=	(int)$_GET['id'];
		$del	=	$OrderM -> delPay($delid);
	    if($del){
	        $this->layer_msg($del['msg'],$del['errcode'],$del['layertype'],$_SERVER['HTTP_REFERER']);
	    }
	}
}
?>