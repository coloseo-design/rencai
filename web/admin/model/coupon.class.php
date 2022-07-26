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
class coupon_controller extends adminCommon{
	function index_action()
	{
		if($_GET['order'])
		{
			$where['orderby']		=	$_GET['t'].','.$_GET['order'];
			
			$urlarr['order']		=	$_GET['order'];
			
			$urlarr['t']			=	$_GET['t'];
		}else{
			
			$where['orderby']		=	'id';
		}
		$urlarr        		=   $_GET;
		$urlarr['page']		=	"{{page}}";
		
		$pageurl			=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM				=	$this  -> MODEL('page');
		
		$pages				=	$pageM -> pageList('coupon',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			$where['limit']	=	$pages['limit'];
			
			$couponM		=	$this->MODEL('coupon');
			
			$rows			=	$couponM -> getList($where);
			
			$this->yunset('rows',$rows);
		}
		$this->yuntpl(array('admin/admin_coupon'));
	}
	function save_action(){
		$couponM		=	$this->MODEL('coupon');
		
		if($_POST['id']){
			
			$where['id']=	$_POST['id'];
			
		}
		$return			=	$couponM->setInfo($_POST,$where);
		
		if($return['errcode']=='9'){
			
			$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
		}else{
			
			$this->ACT_layer_msg($return['msg'],$return['errcode']);
		}
	}
	
	function del_action()
	{
		if($_GET['del'])
		{
			$this->check_token();
			
			$couponM	=	$this->MODEL('coupon');
			
			$return		=	$couponM->delInfo($_GET['del']);
			
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择要删除的内容！',8);
		}
	}
}
?>