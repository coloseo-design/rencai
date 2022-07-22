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

function baiduOrder($data)
{
    
    require (DATA_PATH."api/baidu/baidu_data.php");
    
    require("Autoloader.php");
    
    $requestParamsArr = array(
        'dealId'       =>  $baiduData['sy_dealId'],
        'appKey'       =>  $baiduData['sy_appKey'],
        'totalAmount'  =>  $data['totalAmount']*100,
        'tpOrderId'    =>  $data['tpOrderId'],
    );
    
    $requestParamsArr['rsaSign']  =  rsaSign($requestParamsArr, $baiduData['sy_privateKey']);
    
    $bizInfo  =  array(
        'tpData'=> $requestParamsArr
    );
    return $bizInfo;
}
/**
 * 签名
 */
function rsaSign($requestParamsArr, $privateKey = '')
{
    if (empty($privateKey)){
        echo 'no rsa_private_key';die;
    }
    
    $rsaStr  =  convertRSAKeyStr2Pem($privateKey,1);
    
    $rsaSign = NuomiRsaSign::genSignWithRsa($requestParamsArr, $rsaStr);
    
    $requestParamsArr['sign']  =  $rsaSign;
    
    return $rsaSign;
}
/**
 * 签名
 */
function checkSign($requestParamsArr,$keyType = 0)
{
    if ($keyType == 0){
        // 获取平台公钥
        require_once(dirname(dirname(dirname(__FILE__)))."/data/api/baidu/baidu_data.php");
        
        $ptPublic = $baiduData['sy_publicKey'];
        
        if (empty($ptPublic)){
            echo 'no ptPublic';die;
        }
        $rsaStr = convertRSAKeyStr2Pem($ptPublic);
        
    }else{
        // 获取用户私钥
        require (DATA_PATH."api/baidu/baidu_data.php");
        
        $privateKey  =  $baiduData['sy_privateKey'];
        
        if (empty($privateKey)){
            echo 'no rsa_private_key';die;
        }
        
        $rsaStr  =  convertRSAKeyStr2Pem($privateKey,1);
    }
    
    $checkSignRes = NuomiRsaSign::checkSignWithRsa($requestParamsArr, $rsaStr);
    
    return $checkSignRes;
}
/**
 * @desc 密钥由字符串（不换行）转为PEM格式（用户网站保存的公钥转为PEM格式）
 * @param $rsaKeyStr
 * @param int $keyType 0:公钥，1:私钥
 * @return string
 * @throws SF_Exception_InternalException
 */
function convertRSAKeyStr2Pem($rsaKeyStr, $keyType = 0)
{
    $pemWidth = 64;
    $rsaKeyPem = '';
    
    $begin = '-----BEGIN ';
    $end = '-----END ';
    $key = ' KEY-----';
    $type = $keyType ? 'RSA PRIVATE' : 'PUBLIC';
    
    $keyPrefix = $begin . $type . $key;
    $keySuffix = $end . $type . $key;
    
    $rsaKeyPem .= $keyPrefix . "\n";
    $rsaKeyPem .= wordwrap($rsaKeyStr, $pemWidth, "\n", true) . "\n";
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
?>