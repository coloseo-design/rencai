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
class login_controller extends wxapp_controller{
	
	function getCon_action(){
		
		$data	=	array(
			'sy_login_type'				=>	$this->config['sy_login_type']
		);
		if (isset($_POST['provider']) && ($_POST['provider'] == 'weixin' || $_POST['provider'] == 'baidu')) {
		    // 小程序关联登录入口判断
		    if ($_POST['provider'] == 'weixin'){
		        @include(DATA_PATH.'api/wxpay/wxpay_data.php');
		        if (isset($wxpaydata)){
		            if($wxpaydata['sy_xcxappid'] == '' || $wxpaydata['sy_xcxsecret'] ==''){
		                $data['isWxopen'] = false;
		            }else{
		                $data['isWxopen'] = true;
		            }
		        }
		    }
		    if ($_POST['provider'] == 'baidu'){
		        @include(DATA_PATH . 'api/baidu/baidu_data.php');
		        if (isset($baiduData)) {
		            if($baiduData['sy_bdlogin_appKey'] == '' || $baiduData['sy_bdlogin_appSecret'] == ''){
		                $data['isBdopen'] = false;
		            }else{
		                $data['isBdopen'] = true;
		            }
		        }
		    }
		}
		$data['sy_reg_type']    =   isset($this->config['sy_reg_type']) ? $this->config['sy_reg_type'] : 1;

		$this -> render_json(1,'',$data);
	}
    /**
     * 账号登录
     */
    function ulogin_action()
    {
        $lData  =  array(
            'username'     =>  $this->stringfilter($_POST['username']),
            'password'     =>  $this->stringfilter($_POST['password']),
            'wxapp'        =>  1,
            'provider'     =>  $_POST['provider'],
            'clientid'     =>  $_POST['clientid'],
            'deviceToken'  =>  $_POST['deviceToken'],
            'source'       =>  $_POST['source']
        );
        if ($_POST['provider'] == 'app'){
            $lData['port']  =   4;
        }elseif ($_POST['provider'] == 'weixin' || $_POST['provider'] == 'toutiao' || $_POST['provider'] == 'baidu'){
            $lData['port']  =   3;
        }
        
		if($_POST['act_login'] == 2){
			$lData['act_login'] = 1;
		}
        $userinfoM  =  $this->MODEL("userinfo");
        
        $return     =  $userinfoM->userLogin($lData);
        
		if($return['errcode']==2 || $return['user']['usertype'] > 2){
			$error	=	1;
		}else if($return['errcode']==9){
		    
		    //微信绑定账号
		    if (!empty($_POST['type'])){
		        
		        $bdData['uid']     =  $return['user']['uid'];
		        $bdData['type']    =  $_POST['type'];
		        $bdData['openid']  =  $_POST['openid'];
		        
		        if (!empty($_POST['unionid']) && $_POST['unionid'] != 'undefinded'){
		            
		            $bdData['unionid']	= $_POST['unionid'];
		        }
		        
		        if ($_POST['type'] == 'weixin' && !empty($_POST['code'])){
		            // 微信小程序内相关参数需重新获取
		            $getdata  =  $this->getOpenid($_POST['code']);
		            if(isset($getdata['errcode'])){
		                $this->MODEL('errlog')->addErrorLog($bdData['uid'], 10, 'wxapp微信登录绑定账号获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
		                $errmsg = $getdata['errcode'] == 40125 ? '微信小程序配置错误，请联系网站管理员' : '错误号:' .$getdata['errcode'];
		                $this->render_json(-1, $errmsg);
		            }
		            
		            $bdData['openid']  =  $getdata['openid'];
		            if (!empty($getdata['unionid'])){
		                
		                $bdData['unionid']	=	$getdata['unionid'];
		            }
		        }
		        
		        $return  =  $userinfoM->loginBind($bdData);
		        $error   =  $return['error'];
		    }else{
		        $error	=	0;
		    }
		}else{
			$error	=	-1;
		}
		$msg	=	$return['msg'];
		
		$this->render_json($error,$msg, $return);
    }
    function loginCheck_action()
    {
        $userinfoM  =  $this->MODEL("userinfo");
        $ckData     =  array(
            'clientid'     =>  $_POST['clientid'],
            'deviceToken'  =>  $_POST['deviceToken'],
            'source'       =>  $_POST['source']
        );
        
        if ($_POST['type'] == 'weixin'){
            
            if ($_POST['openid']){
                // app微信登录
                $getdata['openid']  =  $_POST['openid'];
                if (!empty($_POST['unionid']) && $_POST['unionid'] != 'undefinded'){
                    $getdata['unionid']  =  $_POST['unionid'];
                }
            }else{
                // 小程序微信登录
                $getdata	=	$this->getOpenid($_POST['code']);
            }
            
            $data		=	array();
            
            if($getdata['openid']){
                
                $userinfoM  =  $this->MODEL("userinfo");
                
                $ckData['type']         =  $_POST['type'];
                $ckData['provider']     =  $_POST['provider'];
                $ckData['openid']       =  $getdata['openid'];
                $ckData['unionid']      =  !empty($getdata['unionid']) ? $getdata['unionid'] : '';
                
                $data  =  $userinfoM->loginCheck($ckData, false);
                
            }else{
                
                $data['error']  =  3;
                $data['user']   =  array();
                if (isset($getdata['errcode'])){
                    $this->MODEL('errlog')->addErrorLog('', 10, 'wxapp微信登录获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
                    if($getdata['errcode'] == 40125){
                        $data['msg']  =  '微信小程序配置错误，请联系网站管理员';
                    }else{
                        $data['msg']  =  $getdata['errcode'] ? '错误号:'.$getdata['errcode'] : '出错了，请重试';
                    }
                }else{
                    $data['msg']		=	'参数错误';
                }
            }
        }elseif ($_POST['type']=='baidu'){
            // 小程序百度登录
            $getdata	=	$this->getBdOpenid($_POST['code']);

            $data		=	array();

            if($getdata['openid']){

                $userinfoM  =  $this->MODEL("userinfo");

                $ckData['type']         =  $_POST['type'];

                $ckData['openid']       =  $getdata['openid'];
               
                $data  =  $userinfoM->loginCheck($ckData, false);

            }else{

                $data['error']  =  3;
                $data['user']   =  array();
                if (isset($getdata['errno'])){
                    $this->MODEL('errlog')->addErrorLog('', 10, '百度小程序登录获取openid错误。code:'.$_POST['code'].'。'.$getdata['error'].'，'.$getdata['error_description']);
                    if($getdata['errno'] == 10010100){
                        $data['msg']  =  '百度小程序配置错误，请联系网站管理员';
                    }else{
                        $data['msg']  =  $getdata['errno'] ? '错误号:'.$getdata['errno'] : '出错了，请重试';
                    }
                }else{
                    $data['msg']		=	'参数错误';
                }
            }
        }else{
            
            $ckData['type']     =  $_POST['type'];
            $ckData['openid']   =  $_POST['openid'];
            $ckData['unionid']  =  $_POST['unionid'];
            $ckData['provider'] =  $_POST['provider'];
            $data  =  $userinfoM->loginCheck($ckData);
        }
        if(!isset($data['user'])){
            $data['user'] = array();
        }
		$this->render_json($data['error'],$data['msg'], $data['user']);
    }
    
	function sendmsg_action()
	{
	    $moblie			=		$_POST['moblie'];
	    
	    $this->checkMcsdk($moblie);
	    
		$noticeM 		= 		$this->MODEL('notice');
		
		$UserinfoM		=		$this->MODEL('userinfo');
		$userinfo 		= 		$UserinfoM->getInfo(array("moblie" => $moblie),array('field'=>"`usertype`,`uid`"));

        if ($this->config['sy_reg_type'] == 2 && empty($userinfo)) {

            $errcode    =   2;
            $msg        =   '请先注册账号';
        }else{
            $user = array(
                'uid' => $userinfo['uid'],
                'usertype' => $userinfo['usertype']
            );
            $port       =   $this->plat == 'mini' ? '3' : '4';    // 短信发送端口$port : 3-小程序  4-APP
            $result     =   $noticeM->sendCode($moblie, 'login', $port, $user, 6, 90, 'msg');
            if($result['error']==1){
                $errcode	=	1;
            }else{
                $errcode	=	2;
                $msg		=	$result['msg'];
            }
        }

		$this->render_json($errcode,$msg);
	}
	function getConfig_action()
    {
        $return  =  array(
            'reg_real_name_check'   =>  $this->config['reg_real_name_check'],
            'sy_reg_type'           =>  isset($this->config['sy_reg_type']) ? $this->config['sy_reg_type'] : 1
        );
        
		$this->render_json(1,'', $return);
    }
    // 创建新账号、手机号一键绑定（手机号已存在的，微信绑定已存在手机号）
    function balogin_action(){

		if ($_POST['type'] == 'weixin'){
	        
		    if ($_POST['provider'] == 'app'){
	            // app微信登录
	            $getdata['openid']  =  $_POST['openid'];
	            if (!empty($_POST['unionid']) && $_POST['unionid'] != 'undefinded'){
	                $getdata['unionid']  =  $_POST['unionid'];
	            }
	        }else{
	            // 小程序微信登录
	            $getdata	=	$this->getOpenid($_POST['code']);
	        }
	        if (!empty($getdata['openid'])){
	            
	            $ckData['type']         =  $_POST['type'];
	            $ckData['provider']     =  $_POST['provider'];
                $ckData['source']       =  $_POST['source'];
                $ckData['openid']       =  $getdata['openid'];
                $ckData['unionid']      =  !empty($getdata['unionid']) ? $getdata['unionid'] : '';
                // 解密手机号所需参数
                if ($_POST['provider'] == 'weixin'){
                    $ckData['phoneEncrypt'] =  $_POST['rsaSign'];
                    $ckData['phoneIv']      =  $_POST['sign'];
                    $ckData['appid']        =  $getdata['appid'];
                    $ckData['session_key']  =  $getdata['session_key'];
                }
                $ckData['cnewcount']	=  $_POST['cnewcount'];
                
	            $userinfoM	=  $this->MODEL('userinfo');

	            $data  =  $userinfoM->loginCheck($ckData);
                
	        }else{
	            
	            $data['error']  =  -1;
	            $data['user']   =  array();
	            if (isset($getdata['errcode'])){
	                if (isset($_POST['sign'])){
	                    $this->MODEL('errlog')->addErrorLog('', 10, 'wxapp微信一键登录获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
	                }else{
	                    $this->MODEL('errlog')->addErrorLog('', 10, 'wxapp微信登录创建新账号获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
	                }
	                if($getdata['errcode'] == 40125){
	                    $data['msg']  =  '微信小程序配置错误，请联系网站管理员';
	                }else{
	                    $data['msg']  =  $getdata['errcode'] ? '错误号:'.$getdata['errcode'] : '出错了，请重试';
	                }
	            }else{
	                $data['msg']		=	'参数错误';
	            }
	        }
		}else{
		    
		    $ckData['type']       =  $_POST['type'];
		    $ckData['source']     =  $_POST['source'];
		    $ckData['openid']     =  $_POST['openid'];
		    $ckData['unionid']    =  $_POST['unionid'];
		    $ckData['provider']   =  $_POST['provider'];
		    $ckData['cnewcount']  =  $_POST['cnewcount'];
		    
		    $userinfoM	=  $this->MODEL('userinfo');
		    $data  =  $userinfoM->loginCheck($ckData);
		}
		if(!isset($data['user'])){
		    $data['user'] = array();
		}
	    $this->render_json($data['error'],$data['msg'], $data['user']);
	}
    /**
	 * 后台未开启实名认证，需绑定已有账号，登录验证并绑定
	 */
	function baloginsave_action(){

		if ($_POST['type'] == 'weixin'){
	        
		    if ($_POST['provider'] == 'app'){
	            // app微信登录
	            $getdata['openid']  =  $_POST['openid'];
	            if (!empty($_POST['unionid']) && $_POST['unionid'] != 'undefinded'){
	                $getdata['unionid']  =  $_POST['unionid'];
	            }
	        }else{
	            // 小程序微信登录
	            $getdata	=	$this->getOpenid($_POST['code']);
	        }
	        if (!empty($getdata['openid'])){
	            
	            $wdata  =  array(
	                'openid'       =>  	$getdata['openid'],
	                'unionid'      =>  	!empty($getdata['unionid']) ? $getdata['unionid'] : '',
	                'source'       =>  	$_POST['source'],
	                'username'     =>  	$_POST['username'],
	                'password'     =>  	$_POST['password'],
	                'clientid'     =>  	$_POST['clientid'],
	                'deviceToken'  =>  	$_POST['deviceToken'],
	                'port'         =>  	$this->plat == 'mini' ? '3' : '4',	// 短信发送端口$port : 3-小程序  4-APP
	                'provider'	   =>	$_POST['provider']
	            );
	            $userinfoM	=  $this->MODEL('userinfo');
	            $result	    =  $userinfoM->bindacount($wdata, 'weixin');
	            
	            if ($result['errcode'] == 9){
	                
	                $data['user']     =  $result['user'];
	                $data['errcode']  =  1;
	                $data['msg']      =  '';
	                
	            }else if($result['errcode'] == 2){
	            	$data['user']     =  $result['user'];
	                $data['errcode']  =  2;
	                $data['msg']      =  '';
	            }else{
	                
	                $data['errcode']   =  -1;
	                $data['msg']       =  $result['msg'];
	            }
	            
	        }else{
	            
	            $data['errcode']  =  -1;
	            $data['user']   =  array();
	            if (isset($getdata['errcode'])){
	                $this->MODEL('errlog')->addErrorLog('', 10, 'wxapp微信登录绑定账号获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
	                if($getdata['errcode'] == 40125){
	                    $data['msg']  =  '微信小程序配置错误，请联系网站管理员';
	                }else{
	                    $data['msg']  =  $getdata['errcode'] ? '错误号:'.$getdata['errcode'] : '出错了，请重试';
	                }
	            }else{
	                $data['msg']	  =	'参数错误';
	            }
	        }
	    }elseif ($_POST['type'] == 'baidu'){

            // 小程序百度登录
            $getdata	=	$this->getBdOpenid($_POST['code']);
            if (!empty($getdata['openid'])){

                $wdata  =  array(
                    'openid'       =>  	$getdata['openid'],

                    'source'       =>  	$_POST['source'],
                    'username'     =>  	$_POST['username'],
                    'password'     =>  	$_POST['password'],

                    'port'         =>  	$this->plat == 'mini' ? '3' : '4',	// 短信发送端口$port : 3-小程序  4-APP
                    'provider'	   =>	$_POST['provider']
                );

                $userinfoM	=  $this->MODEL('userinfo');
                $result	    =  $userinfoM->bindacount($wdata, 'baidu');

                if ($result['errcode'] == 9){

                    $data['user']     =  $result['user'];
                    $data['errcode']  =  1;
                    $data['msg']      =  '';

                }else if($result['errcode'] == 2){
                    $data['user']     =  $result['user'];
                    $data['errcode']  =  2;
                    $data['msg']      =  '';
                }else{

                    $data['errcode']   =  -1;
                    $data['msg']       =  $result['msg'];
                }

            }else{

                $data['errcode']  =  -1;
                $data['user']   =  array();
                if (isset($getdata['errno'])){
                    $this->MODEL('errlog')->addErrorLog('', 10, '百度小程序登录获取openid错误。code:'.$_POST['code'].'。'.$getdata['error'].'，'.$getdata['error_description']);
                    if($getdata['errno'] == 10010100){
                        $data['msg']  =  '百度小程序配置错误，请联系网站管理员';
                    }else{
                        $data['msg']  =  $getdata['errno'] ? '错误号:'.$getdata['errno'] : '出错了，请重试';
                    }
                }else{
                    $data['msg']		=	'参数错误';
                }
            }
        }elseif ($_POST['type'] == 'qq'){
            
	        $wdata  =  array(
                'openid'       =>  	$_POST['openid'],
                'unionid'      =>  	$_POST['unionid'],
                'source'       =>  	$_POST['source'],
                'username'     =>  	$_POST['username'],
                'password'     =>  	$_POST['password'],
                'clientid'     =>  	$_POST['clientid'],
                'deviceToken'  =>  	$_POST['deviceToken'],
                'port'         =>  	$this->plat == 'mini' ? '3' : '4',	// 短信发送端口$port : 3-小程序  4-APP
	            'provider'	   =>	$_POST['provider']
            );
            $userinfoM	=  $this->MODEL('userinfo');
            $result	    =  $userinfoM->bindacount($wdata, 'qq');
            
            if ($result['errcode'] == 9){
	                
                $data['user']     =  $result['user'];
                $data['errcode']  =  1;
                $data['msg']      =  '';
                
            }else if($result['errcode'] == 2){
            	$data['user']     =  $result['user'];
                $data['errcode']  =  2;
                $data['msg']      =  '';
            }else{
                
                $data['errcode']   =  -1;
                $data['msg']       =  $result['msg'];
            }
        }
        if(!isset($data['user'])){
            $data['user'] = array();
        }
	    $this->render_json($data['errcode'],$data['msg'], $data['user']);
	}
	/**
	 * 后台设置实名验证，微信登录等（非微信小程序获取手机号接口）需绑定手机号后再自动注册账号
	 */
	function fastregsave_action(){
	    
	    if($_POST['provider'] == 'weixin'){
	        $source  =  13;
	    }elseif($_POST['provider'] == 'baidu'){
	        $source  =	19;
	    }elseif($_POST['provider'] == 'app'){
	        $source	=	3;
	    }
	    
	    if ($_POST['type'] == 'weixin'){
	        
	        if ($_POST['provider'] == 'app'){
	            // app微信登录
	            $getdata['openid']  =  $_POST['openid'];
	            if (!empty($_POST['unionid'])){
	                $getdata['unionid']  =  $_POST['unionid'];
	            }
	            $provider  =  $_POST['provider'];
	        }else{
	            // 小程序微信登录
	            $getdata  =  $this->getOpenid($_POST['code']);
	            $provider = 'wxxcx';
	        }
	        if (!empty($getdata['openid'])){
	            
	            $wdata  =  array(
	                'openid'       =>  $getdata['openid'],
	                'unionid'      =>  $getdata['unionid'],
	                'source'       =>  $source,
	                'moblie'       =>  $_POST['username'],
	                'moblie_code'  =>  $_POST['password'],
	                'clientid'     =>  $_POST['clientid'],
	                'deviceToken'  =>  $_POST['deviceToken'],
	                'port'         =>  $this->plat == 'mini' ? '3' : '4'	// 短信发送端口$port : 3-小程序  4-APP
	            );
	            $userinfoM	=  $this->MODEL('userinfo');
	            $result	    =  $userinfoM->fastReg($wdata, $provider, 'weixin');
	            
	            if ($result['errcode'] == 9){
	                
	                $data['user']     =  $result['user'];
	                $data['errcode']  =  1;
	                $data['msg']      =  '';
	                
	            }else{
	                
	                $data['errcode']   =  -1;
	                $data['msg']       =  $result['msg'];
	            }
	            
	        }else{
	            
	            $data['error']  =  3;
	            $data['user']   =  array();
	            if (isset($getdata['errcode'])){
	                $this->MODEL('errlog')->addErrorLog('', 10, 'wxapp微信登录绑定手机号获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
	                $data['errcode'] 	= 	$getdata['errcode'];
	                if($getdata['errcode'] == 40125){
	                    $data['msg']  =  '微信小程序配置错误，请联系网站管理员';
	                }else{
	                    $data['msg']  =  $getdata['errcode'] ? '错误号:'.$getdata['errcode'] : '出错了，请重试';
	                };
	            }else{
	                $data['msg']		=	'参数错误';
	            }
	        }
	    }elseif ($_POST['type'] == 'qq'){
            
	        $wdata  =  array(
	            'openid'       =>  $_POST['openid'],
	            'unionid'      =>  $_POST['unionid'],
	            'source'       =>  $source,
	            'moblie'       =>  $_POST['username'],
	            'moblie_code'  =>  $_POST['password'],
	            'clientid'     =>  $_POST['clientid'],
	            'deviceToken'  =>  $_POST['deviceToken'],
	            'port'         =>  $this->plat == 'mini' ? '3' : '4'	// 短信发送端口$port : 3-小程序  4-APP
	        );
	        $userinfoM	=  $this->MODEL('userinfo');
	        $result	    =  $userinfoM->fastReg($wdata, 'qq', 'qq');
	        
	        if ($result['errcode'] == 9){
	            
	            $data['user']     =  $result['user'];
	            $data['errcode']  =  1;
	            $data['msg']      =  '';
	            
	        }else{
	            
	            $data['errcode']   =  -1;
	            $data['msg']       =  $result['msg'];
	        }
        }
        $this->render_json($data['errcode'],$data['msg'], $data['user']);
	}
	/**
	 * app端获取微信unionid。app首次微信登录无法获取unionid,需重新获取，防止异常。
	 */
	function getAppWxSns_action()
	{
	    $unionid = '';
	    if (!empty($_POST['token']) && !empty($_POST['openid'])){
	        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$_POST['token'].'&openid='.$_POST['openid'].'&lang=zh_CN';
	        
	        $rep = CurlGet($url);
	        $res = json_decode($rep,true);
	        if (isset($res['unionid'])){
	            $unionid = $res['unionid'];
	        }
	    }
	    $this->render_json(0,'ok', array('unionid'=>$unionid));
	}
}
?>