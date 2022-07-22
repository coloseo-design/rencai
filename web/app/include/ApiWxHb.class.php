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


//微信红包处理类

include(dirname(dirname(dirname(__FILE__)))."/data/api/wxpay/wxpay_data.php");

define("APIKEY",$wxpaydata['sy_wxpaykey']);  //微信现金红包api key
define("PATHCERT",$wxpaydata['sy_wxpem_cert']); //cert存放位置,不放在网站下
define("PATHKEY",$wxpaydata['sy_wxpem_key']); //key存放位置,不放在网站下
define("PATHCA",$wxpaydata['sy_wxpem_ca']); //ca存放位置,不放在网站下
define("APPID",$wxpaydata['sy_wxpayappid']);   //公众号
define('MCHID', $wxpaydata['sy_wxpaymchid']);  //商户号

class ApiWxHb{
	
	const APIKEY   = APIKEY;
	const PATHCERT = PATHCERT;
	const PATHKEY  = PATHKEY;
	const PATHCA   = PATHCA;
	const APPID    = APPID;
	const MCHID    = MCHID;

	var $para;

	function set_para($key,$value){
		$this->para[$key] = $value;
	}
	
	function create_noncestr( $length = 24 ) {  
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
		$str ="";  
		for ( $i = 0; $i < $length; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);   
		}  
		return $str;  
	}



	function check_sign_para(){
		
		if(!$this->para["nonce_str"]   || 
			!$this->para["mch_billno"] || 
			!$this->para["mch_id"]     || 
			!$this->para["wxappid"]    || 
			!$this->para["send_name"]  ||
			!$this->para["re_openid"]  || 
			!$this->para["total_amount"] || 
			!$this->para["total_num"]  || 
			!$this->para["wishing"]    || 
			!$this->para["client_ip"]  || 
			!$this->para["act_name"]
			)
		{
			return false;
		}
		return true;

	}

	function create_sign(){
		if($this->check_sign_para() == false) {
			return 'FAIL';die;
		}
		ksort($this->para);
		$tempsign = "";
		foreach ($this->para as $k => $v){
			if (null != $v && "null" != $v && "sign" != $k) {
				$tempsign .= $k . "=" . $v . "&";
			}
		}
		$tempsign = substr($tempsign, 0, strlen($tempsign)-1); //去掉最后的&
		$tempsign .="&key=". APIKEY;  //拼接APIKEY

		return strtoupper(md5($tempsign));
	}

	function create_xml(){
		$return = $this->set_para('sign', $this->create_sign());
		if($return == 'FAIL'){
			return;
		}else{
			return $this->ArrayToXml($this->para);
		}
		
	}

	function ArrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.= "</xml>";
        return $xml; 
    }
	
	function curl_post_ssl($url, $vars, $second=30)
	{
		$ch = curl_init();
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		
		//以下两种方式需选择一种
		//第一种方法，cert 与 key 分别属于两个.pem文件
		curl_setopt($ch,CURLOPT_SSLCERT,PATHCERT);
 		curl_setopt($ch,CURLOPT_SSLKEY,PATHKEY);
 		
	 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
	 
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
		$data = curl_exec($ch);
		
		if($data){
			curl_close($ch);
			return $data;
		}
		else { 
			$error = curl_errno($ch);
		
			curl_close($ch);
			return false;
		}
	}
	//红包发送
	function sendHb($data){
		
		$this->set_para("nonce_str", $this->create_noncestr()); //随机字符串
		$this->set_para("mch_billno", $data['mch_billno']); //订单号
		$this->set_para("mch_id", MCHID); //商户号
		$this->set_para("wxappid", APPID);  //公众号
		$this->set_para("send_name", $data['send_name']); //红包发送者名称
		$this->set_para("re_openid", $data['openid']); //接受红包的用户 
		$this->set_para("total_amount", $data['total_amount']); //付款金额，单位分
		$this->set_para("total_num", 1); //红包发放总人数
		$this->set_para("wishing", $data['wishing']); //红包祝福语
		$this->set_para("client_ip", $data['client_ip']); //调用接口的机器 Ip 地址	
		$this->set_para("act_name", $data['act_name']); //活动名称
		// 发放红包使用场景，红包金额大于200或者小于1元时必传(即非‘其他’场景)
		if ($data['scene_id'] != 0){
		    $this->set_para("scene_id", 'PRODUCT_'.$data['scene_id']); //场景id
		}
		//目前微信里暂无显示的地方
		
		$this->set_para("remark", $data['remark']);//备注信息

		$postxml = $this->create_xml(); 
		if(!$postxml){
			$responseObj = array('return_code'=>'FAIL','return_msg'=>'签名参数错误！');
		}else{
			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
			$response = $this->curl_post_ssl($url, $postxml);
			$responseObj = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
			$responseObj = (array)$responseObj;  
		}
		
		return $responseObj;
	}

	function senpay_create_sign(){
		
		ksort($this->para);
		$tempsign = "";
		foreach ($this->para as $k => $v){
			if (null != $v && "null" != $v && "sign" != $k) {
				$tempsign .= $k . "=" . $v . "&";
			}
		}
		$tempsign = substr($tempsign, 0, strlen($tempsign)-1);
		$tempsign .="&key=". APIKEY;

		return strtoupper(md5($tempsign));
	}

	function senpay_create_xml(){
		$return = $this->set_para('sign', $this->senpay_create_sign());
		if($return == 'FAIL'){
			return;
		}else{
			return $this->ArrayToXml($this->para);
		}
		
	}
	function sendPay($data){


		$this->set_para("mchid", MCHID); //商户号
		$this->set_para("mch_appid", APPID);  //公众号
		$this->set_para("nonce_str", $this->create_noncestr()); //随机字符串
		$this->set_para("partner_trade_no", $data['partner_trade_no']); //订单号
		$this->set_para("check_name", 'FORCE_CHECK'); 
		$this->set_para("re_user_name", $data['real_name']); //接受打款的用户 
		$this->set_para("openid", $data['openid']); //接受打款的用户 
		$this->set_para("amount", $data['amount']); //付款金额，单位分
		$this->set_para("desc", $data['desc']); //企业付款操作说明信息
		$this->set_para("spbill_create_ip", $data['spbill_create_ip']); //调用接口的机器 Ip 地址	
		
		$postxml = $this->senpay_create_xml();
		
		if(!$postxml){
			$responseObj = array('return_code'=>'FAIL','return_msg'=>'签名参数错误！');
		}else{
			$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
			$response = $this->curl_post_ssl($url, $postxml);
			
			$responseObj = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
			
			$responseObj = (array)$responseObj;  

		}
		
		return $responseObj;
	}


}

?>