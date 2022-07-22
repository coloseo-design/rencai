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
class payment_controller extends lietou{
	function index_action(){
		$this->yunset($this->MODEL('cache')->GetCache(array('city')));
		$comorderM	=	$this->MODEL('companyorder');
		$lietouM	=	$this->MODEL('lietou');
		$couponM	=	$this->MODEL('coupon');
		
		$ConfigM    =	$this->MODEL('config');
		$rows		=	$ConfigM->getBankList(array('id'=>array('>', 0)));
		
		$this		->	yunset("rows",$rows);
		
		$order		=	$comorderM->getInfo(array('uid'=>$this->uid,'id'=>(int)$_GET['id']));
		if(is_array($order)){
			$orderbank				=	@explode("@%",$order['order_bank']);
			$order['bank_name']		=	$orderbank[0];
			$order['bank_number']	=	$orderbank[1];			
		}

		if(empty($order)){
			header('Location: index.php?c=paylog');
			
			exit();

		}else{
			$order['price_format']	=	number_format($order['order_price'],2);
			$coupons				=	$couponM->getCouponList(array('uid'=>$this->uid, 'validity'=>array('>', time()), 'coupon_scope'=>array('<=', $order['order_price']), 'status'=>'1'));
			
			if($order['order_time']>strtotime("-7 day")){
				
				$order['invoice']	=	'1';
			}
			$ltinfo		=	$lietouM->getInfo(array('uid'=>$this->uid), array('field'=>'`moblie`,`realname`,`provinceid`,`cityid`'));
			
			if($ltinfo['moblie']==''||$ltinfo['realname']==''||$ltinfo['provinceid']==''){
				
				$ltinfo['link_null']=	'1';
			}
			
			
			$this->yunset("ltinfo",$ltinfo);
			$this->yunset("coupons",$coupons);
			$this->yunset("order",$order);
			$this->public_action();
			$this->lietou_tpl('payment');
		}
	}
	 
	/**
	 * 微信扫码支付
	 */
	function wxurl_action()
	{
	    $comorderM  =  $this->MODEL('companyorder');
	    
	    $data  =  array(
	        'uid'      =>  $this->uid,
	        'usertype' =>  $this->usertype,
	        'orderId'  =>  (int)$_POST['orderId'],
	        'coupon'   =>  $_POST['coupon']
	    );
	    $return  =  $comorderM->payComOrderByWXPC($data);
	    
	    echo $return['msg'];die;
	}
	/**
	 * 银行转账
	 */
	function paybank_action()
	{
	    $comorderM	=	$this->MODEL('companyorder');
	    
	    $data['id']				=	$_POST['oid'];
	    $data['coupon']			=	$_POST['coupon'];
	    $data['uid']			=	$this->uid;
	    $data['usertype']		=	$this->usertype;
		$data['did']			=	$this->userdid;
	    $data['file']			=	$_FILES['file'];
	    $data['bank_name']		=	$_POST['bank_name'];
	    $data['bank_number']	=	$_POST['bank_number'];
	    $data['bank_price']		=	$_POST['bank_price'];
	    $data['bank_time']		=	$_POST['bank_time'];
	    $data['order_remark']	=	$_POST['order_remark'];
	    
	    $return  =  $comorderM->payComOrderByBank($data);
	    
	    $this->ACT_layer_msg($return['msg'],$return['errcode'],$return['url']);
	}
}
?>