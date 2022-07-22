<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';

//初始化日志

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS" && $result["trade_state"]=="SUCCESS")
		{
			return $result["out_trade_no"];
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		$dingdan = $this->Queryorder($data["transaction_id"]);
		if(!$dingdan){
			$msg = "订单查询失败";
			return false;
		}else{

			
			require_once(APP_PATH.'app/public/common.php');
			require_once(LIB_PATH.'ApiPay.class.php');

			global $phpyun,$db,$db_config;
			$wxPay = new apipay($phpyun,$db,$db_config['def'],'index');
			
			$wxPay->payAll($dingdan,$total_fee,'wxpay');
		}
		return true;
	}
}
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
