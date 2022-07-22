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
class admin_comorder_controller extends adminCommon{
	function index_action(){
		$OrderM	=	$this -> MODEL('companyorder');
		$where	=	array();
		if($_GET['order_state']){
			$where['order_state']	=	$_GET['order_state'];
			$urlarr['order_state']	=	$_GET['order_state'];
		}
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url($_GET['m'],$urlarr,'admin');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_order',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
			$rows    			=   $OrderM -> getList($where,array('utype'=>'admin'));
		}
		$this->yunset("backurl", basename($_SERVER['HTTP_REFERER']));
		$this->yunset("rows",$rows);
		$this->yunset("headertitle","充值记录");
		$this->yuntpl(array('wapadmin/admin_comorder'));
	}
	function edit_action(){
		$OrderM		=	$this -> MODEL('companyorder');
		$CouponM	=   $this -> MODEL('coupon');
		$row		=	$OrderM ->getInfo(array('id'=>intval($_GET['id'])));
		if($row['coupon']){
			$coupon	=  $CouponM -> getCouponListOne(array('id'=>$row['coupon']),array('field'=>'id,coupon_amount'));
			if($coupon){
			    $row['price']		      =  number_format(($row['order_price'] + $coupon['coupon_amount']),2);
			    $row['order_price']		  =  number_format($row['order_price'],2);
				$coupon['coupon_amount']  =  number_format($coupon['coupon_amount'],2);
			}
			$this -> yunset("coupon",$coupon);
		}
		$this -> yunset("row",$row);
		if($_POST['update']){
			$_POST	=	$this->post_trim($_POST);
			if($_FILES['order_pic']['tmp_name']){
				$upArr    =  array(
					'file'	=>	$_FILES['order_pic'],
					'dir'	=>	'order',	
				);
				$uploadM	=	$this -> MODEL('upload');
				$pic		=	$uploadM -> newUpload($upArr);
				if (!empty($pic['msg'])){
					$this->ACT_layer_msg($pic['msg'],8);
				}elseif (!empty($pic['picurl'])){
					$pictures	=	$pic['picurl'];
				}
			}
			if(isset($pictures)){
				$_POST['order_pic']	=	$pictures;
			}
			$mData      =   array(
				'order_price'	=>  $_POST['order_price'],
				'order_remark'	=>  $_POST['order_remark'],
				'is_invoice'	=>  $_POST['is_invoice'],
				'order_pic'		=>	$_POST['order_pic'],
			);
			if($row['order_pic']){
				$mData['order_pic']	=	$row['order_pic'];
			}
			$return		=	$OrderM  ->  upInfo(intval($_POST['id']),$mData);
			$data['msg']=$return['msg'];
			$data['url']=$_POST['lasturl'].'&last=1';
			$this->yunset("layer",$data);
		}
		// 修改完返回来源列表页路径
		$lasturl=$_SERVER['HTTP_REFERER'];
		if(strpos($lasturl, 'a=edit')===false){
		    if(strpos($lasturl, 'c=admin_comorder')!==false){
		        $this->cookie->setcookie('lasturl',$lasturl,time()+300);
		        $_COOKIE['lasturl']=$lasturl;
		    }
		}
		$this->yunset('lasturl',$_COOKIE['lasturl']);
		// 上面为空点击返回则回到列表首页
		if(intval($_GET['last']==1)){
		    $backurl='index.php?c=admin_comorder';
		    $this->yunset("backurl", $backurl);
		}
		$this->yunset("headertitle","充值记录详情");
		$this->yuntpl(array('wapadmin/admin_comorder_show'));
	}
	
	function setpay_action(){
		$OrderM		=	$this -> MODEL('companyorder');
		$return		=	$OrderM -> setPay(intval($_GET['id']));
		$this -> layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
	}
	//删除
	function del_action(){
		$OrderM		=	$this -> MODEL('companyorder');
	    $delid		=	(int)$_GET['id'];
		$return		=	$OrderM -> del($delid,array('utype'=>'admin'));
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
}
?>