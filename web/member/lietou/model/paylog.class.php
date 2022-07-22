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
class paylog_controller extends lietou{
	function index_action(){
		include(CONFIG_PATH."db.data.php");
		$this->public_action();
		
		$orderM					=	$this->MODEL('companyorder');
		
		$where['uid']			=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['order_price']	=	array('>',0);
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"paylog";
		$pageurl		=	Url('member',$urlarr);
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_order',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']	=	'id,desc';
		    $where['limit']		=	$pages['limit'];
			
			$List				=	$orderM->getList($where, array('utype'=>'lietou'));
			
			$this->yunset("rows",$List);
		}
		
		$this->lietou_tpl('paylog');
	}
	
	function del_action(){
		$orderM		=	$this->MODEL('companyorder');
		$invoiceM	=	$this->MODEL('invoice');
		$logM		=	$this->MODEL('log');
		
		if($this->usertype!='3' || $this->uid==''){
			
			$this->layer_msg('非法操作！',8,0,$_SERVER['HTTP_REFERER']);
			
		}else{
			
			$oid	=	$orderM->del((int)$_GET['id']);
			
			$return	=	$invoiceM->del('',array('oid'=>(int)$_GET['id'],'uid'=>$this->uid));
			
			if($oid){
				$logM->member_log("取消订单",88,3);
				
				$this->layer_msg('取消成功！',9,0,$_SERVER['HTTP_REFERER']);
			}else{
				
				$this->layer_msg('取消失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}
	}
}
?>