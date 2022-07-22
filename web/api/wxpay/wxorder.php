<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");
require_once(APP_PATH.'app/public/common.php');
require_once(LIB_PATH.'ApiPay.class.php');

$tradeId = $_POST["orderid"];

if(!preg_match('/^[0-9]+$/',$tradeId)){
	
	echo 0;
	exit();
}


$wxPay = new apipay($phpyun,$db,$db_config['def'],'index');

$order = $wxPay->getOrder($tradeId);

if($order['order_state']=='2'){

	echo 1;
	exit();
  
}elseif(isset($order['order_id']) && $order['order_id'] != "")
{
    /*
    $input = new WxPayOrderQuery();
	$input->SetOut_trade_no($order['order_id']);
	$result = WxPayApi::orderQuery($input);
 
	if(array_key_exists("return_code", $result)
		&& array_key_exists("result_code", $result)
		&& $result["return_code"] == "SUCCESS"
		&& $result["result_code"] == "SUCCESS" && $result["trade_state"]=="SUCCESS")
	{
			
			
			$order_state = $wxPay->payAll($order['order_id'],$total_fee,'wxpay');
			
			if($order_state=='2'){
					
				echo 1;
				exit();
			}
	}
	*/
}
echo 0;
exit();