<?php
/**
 * 字节跳动担保支付
 */
class ecpay{
    /**
     * 下单
     */
    function create_order($params = array()){
        
        include_once(DATA_PATH.'api/bytedance/tt_data.php');
        
        $params['valid_time'] = 86400;
        $params['subject'] = $params['body'];
        $params['total_amount'] = $params['total_amount']*100;
        $params['disable_msg'] = 1;
        
        $signArr = array_values($params);
        // 添加salt
        array_push($signArr, $ttData['sy_tt_salt']);
        // 字典序排序
        sort($signArr, SORT_STRING);
        // 字符串使用&符号链接接
        $string = implode("&", $signArr);
        
        $params['sign'] = md5($string);
        $params['app_id'] = $ttData['sy_tt_appId'];
        
        $url = 'https://developer.toutiao.com/api/apps/ecpay/v1/create_order';
        
        $res = CurlPost($url, json_encode($params));
        $back = json_decode($res, true);
        
        return $back;
    }
}


?>