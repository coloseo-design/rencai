<?php
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require("Autoloader.php");
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");

require_once(dirname(dirname(dirname(__FILE__)))."/api/baiduPay/baiduPay.php");

$dingdan           =  $_POST['tpOrderId'];	    //获取百度传递过来的订单号
$totalMoney        =  $_POST['totalMoney'];	    //获取百度传递过来的总价格

// 生成签名时不需要rsaSign参数，验证签名时需要sign参数（验证签名需要将传过来的rsaSign和生成的签名进行对比验证）
$requestParamsArr  =  $_POST;
unset($requestParamsArr['rsaSign']);
$requestParamsArr['sign'] = $_POST['rsaSign'];
//验证签名
$checkSignRes = checkSign($requestParamsArr);

if ($checkSignRes){
    
    if ($_POST['status'] == 2){
        
        require_once(APP_PATH.'app/public/common.php');
        require_once(LIB_PATH.'ApiPay.class.php');
        
        $apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
        
        $payType = 'baidu';
        
        if ($_POST['payType'] == '1087'){
            $payType = 'alipay';
        }elseif ($_POST['payType'] == '1117'){
            $payType = 'wxpay';
        }elseif ($_POST['payType'] == '10004'){
            $payType = 'baidu';
        }
        
        $return = $apiPay->payAll($dingdan,$totalMoney,$payType);
        if ($return == 2){
            
            $result  =  array('errno'=>0,'msg'=>'success','data'=>array('isConsumed'=>2));
            echo json_encode($result);die;
        }
    }
}

$result  =  array('errno'=>1,'msg'=>'fail');
echo json_encode($result);



// $string = ArrayToString($_POST);

// $receiveFile  =  dirname(dirname(dirname(__FILE__)))."/data/api/baidu/notify.txt";
// $fp = @fopen($receiveFile, "a");

// flock($fp, LOCK_EX);
// fputs($fp, $string.'||'.$qm."\r\n");
// fclose($fp);
?>