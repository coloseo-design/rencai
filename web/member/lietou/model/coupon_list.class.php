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
class coupon_list_controller extends lietou
{
	function index_action(){
		$couponM	=	$this->MODEL('coupon');
		
		$updata['status']		=	'3';
		
		$upwhere['uid']			=	$this->uid;
		
		$upwhere['validity']	=	array('<', time());
		
		$upwhere['status']		=	'1';
		
		$couponM->upCouponList($upwhere,$updata);
		
		
		$where['uid']			=	$this->uid;
		
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"coupon_list";
		$pageurl		=	Url('member',$urlarr);
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('coupon_list',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']		=	'id,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$couponM->getCouponList($where);
			$this->yunset("rows",$List);
		}
		
		$this->public_action();
		$this->yunset("class",33);
		$this->lietou_tpl('coupon_list');
	}

	function del_action(){
		$couponM	=	$this->MODEL('coupon');
		
		if($_GET['id']){
			$data['uid'] 		=	$this->uid;
		    $data['usertype']	=	$this->usertype;
			$return	=	$couponM->delCouponList(array('id'=>intval($_GET['id']), 'uid'=>$this->uid), $data);
			
			$this->layer_msg($return['msg'],$return['cod'],0,"index.php?c=coupon_list");
			
		}
	}

}
?>