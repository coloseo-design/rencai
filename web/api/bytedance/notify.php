<?php
ini_set('date.timezone','Asia/Shanghai');
require_once(dirname(dirname(dirname(__FILE__)))."/global.php");
require_once(DATA_PATH.'api/bytedance/tt_data.php');

$token = $ttData['sy_tt_token'];

if (isset($_GET['signature'])){
    // 字节跳动开发者平台-小程序-担保交易设置回调
    $params = array(
        trim($_GET['nonce']),
        trim($_GET['timestamp']),
        $token
    );
    $signature = $_GET['signature'];
    sort($params, SORT_STRING);
    $tmpStr = implode( $params );
    $signStr = sha1( $tmpStr );
    
}else{
    // 正常支付交易订单回调
    $post = file_get_contents("php://input");
    $postArr = json_decode($post, true);
    $signature = $postArr['msg_signature'];
    // 处理签名开始
    $params = array($token);
    foreach ($postArr as $k=>$v){
        if (!in_array($k, array('msg_signature', 'type')) && !empty($v)){
            $params[] = $v;
        }
    }
    // 字典序排序
    sort($params, SORT_STRING);
    // 所有字段内容连接成一个字符串
    $string = implode("", $params);
    $signStr = sha1($string);
}

if (isset($signStr)){
    
    if ($signStr == trim($signature) && $token != ''){
        // 验签成功
        if (isset($postArr['msg'])){
            // 支付订单回调
            $msg = json_decode($postArr['msg'], true);
            
            require_once(APP_PATH.'app/public/common.php');
            require_once(LIB_PATH.'ApiPay.class.php');
            
            $payType = 'toutiao';
            
            if ($msg['way'] == 1){
                $payType = 'wxpay';
            }elseif ($msg['way'] == 2){
                $payType = 'alipay';
            }
            
            $apiPay = new apipay($phpyun,$db,$db_config['def'],'index');
            
            $return = $apiPay->payAll($msg['cp_orderno'], '', $payType);
            
            if ($return == 2){
                // 担保交易-支付接口回调输出
                $return = array(
                    'err_no'=>0,
                    'err_tips'=>'success'
                );
                echo json_encode($return);die;
            }
        }
        if (isset($_GET['signature'])){
            // 字节跳动开发者平台-小程序-担保交易设置回调输出
            echo $_GET['echostr'];die;
        }
    }
}

?>