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
class payconfig_controller extends adminCommon{
	function index_action(){
		$this->yunset("config",$this->config);
		$this->yuntpl(array('admin/admin_pay_config'));
	}
	function alipay_action(){
		$ConfigM	=	$this->MODEL('config');
		if($_POST['pay_config']){
			$alipaya['sy_weburl']					=	$this->config['sy_weburl'];
			$alipaya['sy_alipayid']					=	trim($_POST['sy_alipayid']);
			$alipaya['alipaytype']					=	trim($_POST['alipaytype']);
			$alipaya['sy_alipaycode']				=	trim($_POST['sy_alipaycode']);
			$alipaya['sy_alipayemail']				=	trim($_POST['sy_alipayemail']);
			$alipaya['sy_alipayname']				=	trim($_POST['sy_alipayname']);

			$alipaya['sy_alipayappid']				=	trim($_POST['sy_alipayappid']);
			$alipaya['sy_alipayprivatekey']			=	trim($_POST['sy_alipayprivatekey']);
			$alipaya['sy_alipaypublickey']			=	trim($_POST['sy_alipaypublickey']);

			
			
			if($_POST['alipaytype']=="1"){
				$dir = "alipay";
			}elseif($_POST['alipaytype']=="2"){
		   		$dir							= "alipaydual";
		   		$alipaya['receive_address']		=	$this->config['sy_webadd'];
		   		$alipaya['receive_phone']		=	$this->config['receive_phone'];
		   		$alipaya['receive_mobile']		=	$this->config['receive_mobile'];
			}elseif($_POST['alipaytype']=="3"){
				$dir							=	"alipayescow";
			}
			$alipay_v							=	$ConfigM->getInfo(array('name'=>'alipaytype'));
			if(empty($alipay_v)){
				$ConfigM->addInfo(array('config'=>$_POST['alipaytype'],'name'=>'alipaytype'));
			}else{
				$ConfigM->upInfo(array('name'=>'alipaytype'),array('config'=>$_POST['alipaytype']));
			}
			$this->web_config();
			made_web(APP_PATH."data/api/".$dir."/alipay_data.php",ArrayToString($alipaya),"alipaydata");
			$this->ACT_layer_msg( "支付宝配置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		if($this->config['alipaytype']=="1"){
			$dir	=	"alipay";
		}elseif($this->config['alipaytype']=="2"){
		   	$dir	=	"alipaydual";
		}elseif($this->config['alipaytype']=="3"){
		   	$dir	=	"alipayescow";
		}
		@include(APP_PATH."data/api/".$dir."/alipay_data.php");
		$this->yunset("alipaydata",$alipaydata);
		$this->yuntpl(array('admin/admin_alipay_config'));
	}
	function wxpay_action(){
		if($_POST['pay_config']){
	   		$wxpay['sy_wxpayappid']				=	trim($_POST['sy_wxpayappid']);
			$wxpay['sy_wxappsecret']			=	trim($_POST['sy_wxappsecret']);
	   		$wxpay['sy_wxpaymchid']				=	trim($_POST['sy_wxpaymchid']);
			$wxpay['sy_wxpaykey']				=	trim($_POST['sy_wxpaykey']);
			$wxpay['sy_wxpem_cert']				=	$_POST['sy_wxpem_cert'];
			$wxpay['sy_wxpem_key']				=	$_POST['sy_wxpem_key'];
			$wxpay['sy_wxpem_ca']				=	$_POST['sy_wxpem_ca'];
			//小程序用
			$wxpay['sy_xcxappid']				=	trim($_POST['sy_xcxappid']);
			$wxpay['sy_xcxsecret']				=	trim($_POST['sy_xcxsecret']);
		    made_web(APP_PATH."data/api/wxpay/wxpay_data.php",ArrayToString($wxpay),"wxpaydata");
			$this->ACT_layer_msg( "微信支付配置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		@include(APP_PATH."data/api/wxpay/wxpay_data.php");
		$this->yunset("wxpaydata",$wxpaydata);
		$this->yuntpl(array('admin/admin_wxpay_config'));
	}
	function tenpay_action(){
		if($_POST['pay_config']){
 			$tenpay['sy_weburl']				=	$this->config['sy_weburl'];
	   		$tenpay['sy_tenpayid']				=	trim($_POST['sy_tenpayid']);
	   		$tenpay['sy_tenpaycode']			=	trim($_POST['sy_tenpaycode']);
		    made_web(APP_PATH."data/api/tenpay/tenpay_data.php",ArrayToString($tenpay),"tenpaydata");
			$this->ACT_layer_msg( "财付通配置成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
		@include(APP_PATH."data/api/tenpay/tenpay_data.php");
		$this->yunset("tenpaydata",$tenpaydata);
		$this->yuntpl(array('admin/admin_tenpay_config'));
	}
	function bank_action(){
		$ConfigM	=	$this->MODEL('config');
		if($_POST['pay_bank']){
			$postData=array(
				'name'				=>	$_POST['sy_bankuser'],
				'bank_name'			=>	$_POST['sy_bankname'],
				'bank_number'		=>	$_POST['sy_bankdnumber'],
				'bank_address'		=>	$_POST['sy_bankdeposit'],
			);
			if(!$_POST['bankid']){
				$bank	=	$ConfigM->addBank($postData);
				$this->ACT_layer_msg( "银行卡(ID:".$bank.")添加成功！",9,"index.php?m=payconfig&c=bank",2,1);
			}else{
				$bank	=	$ConfigM->upBank(array('id'=>$_POST['bankid']),$postData);
				$this->ACT_layer_msg( "银行卡(ID:".$_POST['bankid'].")修改成功！",9,"index.php?m=payconfig&c=bank",2,1);
			}
		}
		if($_GET['id']){
			$bankone	=	$ConfigM->getBankInfo(array('id'=>$_GET['id']));
			$this->yunset("bankone",$bankone);
		}
		$bankrows	=	$ConfigM->getBankList();
		$this->yunset("bankrows",$bankrows);
		$this->yuntpl(array('admin/admin_bank_config'));
	}
	function save_action(){
		$ConfigM	=	$this->MODEL('config');
		if($_POST['config']){
			unset($_POST['config']);
			foreach($_POST as $key=>$v){
				$config		=	$ConfigM->getNum(array('name'=>$key));
				if($config==false){
					$ConfigM->addInfo(array('name'=>$key,'config'=>$v));
				}else{
					$ConfigM->upInfo(array('name'=>$key),array('config'=>$v));
				}
			}
			$this->web_config();
			$this->ACT_layer_msg( "修改成功！",9,$_SERVER['HTTP_REFERER'],2,1);
		}
	}
	function del_action(){
		$this->check_token();
		$ConfigM	=	$this->MODEL('config');
		$ConfigM->delBank(array('id'=>$_GET['id']));
		$this->layer_msg( "银行卡(ID:".$_GET['id'].")删除成功！",9,0,"index.php?m=payconfig&c=bank");
	}
}
?>