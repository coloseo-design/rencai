<?php

require("Autoloader.php");

/**
 * 第一部分：从公私钥文件路径中读取出公私钥文件内容
 */

$rsaPrivateKeyFilePath = 'rsa/rsa_private_key.pem';
$rsaPublicKeyFilePath = 'rsa/rsa_public_key.pem';

if( !file_exists($rsaPrivateKeyFilePath) || !is_readable($rsaPrivateKeyFilePath) ||
    !file_exists($rsaPublicKeyFilePath) || !is_readable($rsaPublicKeyFilePath) ){
    return false;
}

$rsaPrivateKeyStr = file_get_contents($rsaPrivateKeyFilePath);
$rsaPublicKeyStr = file_get_contents($rsaPublicKeyFilePath);
/**
 * 第二部分：生成签名 DEMO
 */
// $requestParamsArr = array(
//     "unitPrice"=>"1",
//     "orderId"=>"81332196309172",
//     "payTime"=>"1571997691",
//     "dealId"=>"352745305",
//     "tpOrderId"=>"157199768325055",
//     "count"=>"1",
//     "totalMoney"=>"1",
//     "hbBalanceMoney"=>"0",
//     "userId"=>"3391629990",
//     "promoMoney"=>"0",
//     "promoDetail"=>"",
//     "hbMoney"=>"0",
//     "giftCardMoney"=>"0",
//     "payMoney"=>"1",
//     "payType"=>"1087",
//     "returnData"=>"",
//     "partnerId"=>"6000001",
//     "status"=>"2"
// );
$requestParamsArr = array("unitPrice"=>"1","orderId"=>"81341494729172","payTime"=>"1572227042","dealId"=>"352745305","tpOrderId"=>"157222702731789","count"=>"1","totalMoney"=>"1","hbBalanceMoney"=>"0","userId"=>"3391629990","promoMoney"=>"0","promoDetail"=>"","hbMoney"=>"0","giftCardMoney"=>"0","payMoney"=>"1","payType"=>"1117","returnData"=>"","partnerId"=>"6000001","status"=>"2");

$rsaSign = NuomiRsaSign::genSignWithRsa($requestParamsArr, $rsaPrivateKeyStr);

$requestParamsArr['sign'] = 'm1KdXpm266xb/E0jFPXSnkHZbooLUNcuCBibcV/ImWo9qFSIwmGc5GccbRz3G7AsW1vgHHhalIwM3dAAi4YNDqUMDFgo/kSxQgw6gyzgaKVllNnAlLXQvafVt051OnJogGYZ/uMtbvkjOgUswTaWO46N6244gRNgYnyMIo9QWls=';
print_r($requestParamsArr);

// /**
//  * 第三部分：校验签名 DEMO 校验开发者公钥
//  */

// $checkSignRes = NuomiRsaSign::checkSignWithRsa($requestParamsArr, $rsaPublicKeyStr);
// var_dump($checkSignRes); # true :签名校验成功，false：签名校验失败

/*
 * 校验平台公钥
 */
$ptPublic = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQChR8G0uWA9ah9COpBtlSY8A8M0A+gARY9YHaQXTCds9Dv+VHfsZLDx2KjxJh4eAJ6SzZajRzgrcEREKZDoTuGjm/kzTarMQ6f3YvakCJKrE4FjwNbOogBxxDJDQF3iL7Xclkv5OHuyIdPEAIYVCj3tTx4oLI9lUMq9Ocn8SBUJDwIDAQAB';

$ptPublicKey = convertRSAKeyStr2Pem($ptPublic);

$checkSignRes = NuomiRsaSign::checkSignWithRsa($requestParamsArr, $ptPublicKey);
var_dump($checkSignRes); # true :签名校验成功，false：签名校验失败

/**
 * @desc 密钥由字符串（不换行）转为PEM格式
 * @param $rsaKeyStr
 * @param int $keyType 0:公钥，1:私钥
 * @return string
 * @throws SF_Exception_InternalException
 */
function convertRSAKeyStr2Pem($rsaKeyStr, $keyType = 0)
{
    $rsaKeyPem = '';
    
    $beginPublicKey   = '-----BEGIN PUBLIC KEY-----';
    $endPublicKey     = '-----END PUBLIC KEY-----';
    $beginPrivateKey  = '-----BEGIN PRIVATE KEY-----';
    $endPrivateKey    = '-----END PRIVATE KEY-----';
    
    $keyPrefix = $keyType ? $beginPrivateKey : $beginPublicKey;
    $keySuffix = $keyType ? $endPrivateKey : $endPublicKey;
    
    $rsaKeyPem .= $keyPrefix. "\n";
    $rsaKeyPem .= wordwrap($rsaKeyStr, 64, "\n", true) . "\n";
    $rsaKeyPem .= $keySuffix;
    
    if(!function_exists('openssl_pkey_get_public') || !function_exists('openssl_pkey_get_private')){
        return false;
    }
    
    if($keyType == 0 && false == openssl_pkey_get_public($rsaKeyPem)){
        return false;
    }
    
    if($keyType == 1 && false == openssl_pkey_get_private($rsaKeyPem)){
        return false;
    }
    
    return $rsaKeyPem;
}
