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
class index_controller extends common{

	/**
	 * 用户订阅
	 * 2019-07-11
	 */
	function index_action(){
		//没登录，跳转到登录页
		if(empty($this -> uid)){
			$this -> ACT_msg(Url('login'), '您还未登录！');
		}
	
		//个人 企业用户才可订阅
		if($this->usertype && $this->usertype != 1 && $this->usertype != 2){
			$this -> ACT_msg($this -> config['sy_weburl'], '只有个人和企业用户才可订阅！');
		}

		$userInfo	=	$this -> getUser();
		if(empty($userInfo)){
			$this -> ACT_msg(Url('login'), '您还未登录！');
		}

		//未绑定微信时，判断是否开通公众号，有登录码则跳转至绑定页
		if(empty($userInfo['wxid']) && empty($userInfo['wxopenid'])){
			$qrcode	=	$this -> getWxcode();
			if(empty($qrcode)){
				$this -> ACT_msg($this -> config['sy_weburl'], '暂未绑定微信公众号，无法订阅！');
			}else{
				$this -> ACT_msg(Url('wxconnect'), '马上绑定微信, 接收订阅信息！');
			}
		}
		
		$subscribeM	=	$this->MODEL("subscribe");

        $this -> yunset($this->MODEL('cache') -> GetCache(array('com','job','user','city'))); 
        
		$sid		=	intval($_GET['id']);
		if(!empty($sid)){
			$info	=	$subscribeM -> getInfo(array('id' => $sid));
			$this -> yunset('info', $info);
		}
		
		$cycle_time	=	array('3' => '3天以内', '7' => '1周以内', '14' => '2周以内', '21' => '3周以内', '30' => '1月以内', '90' => '3月以内');
		$this -> yunset('cycle_time', $cycle_time);
		
		$this -> seo('subscribe');
		$this -> yun_tpl(array('index'));
	}

	/**
	 * 保存订阅用户
	 * 2019-07-11
	 */
	function save_action(){

		//防止错误提交
		if(empty($_POST['submit'])){
			$this -> ACT_layer_msg('参数错误！', 8, $_SERVER['HTTP_REFERER']);
		}
		unset($_POST['submit']);
		$_POST	=	$this -> post_trim($_POST);
		$_POST['wxloginid']  =  $_COOKIE['wxloginid'];   
		//保存订阅
		$subscribeM			=	$this -> MODEL("subscribe");
		$_POST['uid']		=	$this -> uid;
		$_POST['usertype']	=	$this -> usertype;
		$res				=	$subscribeM -> createSubscribe($_POST);
		if($res['errcode'] == 9){
			$this -> ACT_layer_msg($res['msg'], 9, Url('member',array('c'=>'subscribe')));
		}else{
			$this -> ACT_layer_msg($res['msg'], 8, $_SERVER['HTTP_REFERER']);
		}
	}

	//获取用户信息
	function getUser(){
		$userinfoM	=	$this -> MODEL('userinfo');
		return $userinfoM -> getInfo(array('uid'=> $this -> uid), array('field' => '`wxid`, `wxopenid`'));
	}

	//获取用户信息
	function getWxcode(){
		$WxM	=	$this -> MODEL('weixin');
		return $WxM -> applyWxQrcode($_COOKIE['wxloginid'], '', $this->uid);
	}

	function cert_action(){
		$subscribeM		=	$this->MODEL("subscribe");
		if($_GET['coid']){
			$arr	=	@explode("|",base64_decode($_GET['coid']));
			$email 	= 	$arr[0];
			$code 	= 	$arr[1];
			
			if(CheckRegEmail($email)==false || !ctype_alnum($code)){
				exit();
			}else{ 
				$nid=$subscribeM->upInfo(array("status"=>"1"),array("email"=>$email,"code"=>$code));
				if($nid && $this->uid){
					
					$id			=	(int)$_GET['id'];
					
					$userinfoM	=	$this->MODEL("userinfo");

                    $rows		=	$subscribeM->getInfo(array('id'=>$id,"code"=>$code),array('field'=>'`uid`'));

					$info		=	$userinfoM->getInfo(array('uid'=> $rows['uid']),array("field"=>"usertype,uid"));

					if($info['usertype']==1){
						
						$userinfoM->UpdateUserInfo(array("usertype"=>$info['usertype'],"post"=>array("email_dy"=>1,"email"=>$email,"email_status"=>1)),array("uid"=>$info['uid']));
						
					}elseif($info['usertype']==2){
						$userinfoM->UpdateUserInfo(array("usertype"=>$info['usertype'],"post"=>array("email_dy"=>1,"linkmail"=>$email,"email_status"=>1)),array("uid"=>$info['uid']));
						
					}
				}
				if ($_GET['type']){
				    header("location:".Url('register',array('c'=>'ok','type'=>6)));
				}else {
				    header("location:".Url('register',array('c'=>'ok','type'=>4)));
				}
			}
		}
		$row	=	$subscribeM->getInfo(array('id'=>intval($_GET['id']),"uid"=>$this->uid));
		if($row['id']==''){
			$this->ACT_msg($this->config['sy_weburl'],"未找到该记录！");
		}
		$this->yunset("row",$row);
		$this->seo("subscribe");
		$this->yun_tpl(array('cert'));
	}

	function send_email_action(){
		if($_POST['email']){
			$data['type']	=	"cert";
			$code 			= 	substr(uniqid(rand()), -6);
			$data['code']	=	$code;
			$data['date']	=	date("Y-m-d");
			$data['email']	=	$_POST['email'];
			$base			=	base64_encode($_POST['email']."|".$code);
			$url			=	Url("subscribe",array("c"=>"cert","coid"=>$base));
			$data['url']	=	"<a href='".$url."'>点击认证</a> 如果您不能在邮箱中直接打开，请复制该链接到浏览器地址栏中直接打开：".$url;
			
			$notice 		= $this->MODEL('notice');
			$notice->sendEmailType($data);
			
			$subscribeM		=	$this->MODEL("subscribe");
			$subscribeM->upInfo(array("code"=>$code),array("email"=>$_POST['email']));
			echo 1;die;
		}
	}
}
