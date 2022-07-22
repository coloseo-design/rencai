<?php
/* *
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
*/
class login_controller extends common{
	function index_action(){
		$this->get_moblie();
		//判断来源是否为马甲APP
		$this->magbind();
		// 判断来源是否为千帆云APP
		$this->isqfy();
		//微信wap登录
		if(preg_match("/^[a-zA-Z0-9_-]+$/",$_GET['wxid'])){
			$wxid = $_GET['wxid'];
			$this->cookie->setcookie("wxid",$_GET['wxid'],time() + 86400);
		}elseif($_COOKIE['wxid']){
			$wxid = $_COOKIE['wxid'];
		}
		if(preg_match("/^[a-zA-Z0-9_-]+$/",$_GET['wxloginid'])){
			$this->cookie->setcookie("wxloginid",$_GET['wxloginid'],time() + 86400);
		}
		if($wxid){
			if($wxid == $_COOKIE['wxid']){
				$this->yunset("wxid",$wxid);
				$this->yunset("wxnickname",$_COOKIE['wxnickname']);
				$this->yunset("wxpic",$_COOKIE['wxpic']);
			}else{
				$wxM = $this->MODEL('weixin');
				$wxinfo = $wxM->getWxUser($wxid);
				if($wxinfo['nickname']){
					$this->yunset("wxid",$wxid);
					$this->cookie->setcookie("wxnickname",$wxinfo['nickname'],time() + 86400);
					$this->yunset("wxnickname",$wxinfo['nickname']);
					$this->cookie->setcookie("wxpic",$wxinfo['headimgurl'],time() + 86400);
					$this->yunset("wxpic",$wxinfo['headimgurl']);
					$this->cookie->setcookie("unionid",$wxinfo['unionid'],time() + 86400);
				}
			}
		}
		if($this->uid || $this->username){
			if((int)$_GET['bind']=='1'){
				$this->cookie->unset_cookie();
				$data['msg']='重新绑定您的求职账户！';
			}elseif($_GET['wxid']){
				$this->cookie->unset_cookie();
			}else{
				$this->wapheader('member/index.php');
			}
		}
        $descM  =  $this->MODEL('description');
        $xieyi  =  $descM -> getDes(array('id'=>'5'),array('field'=>'content'));
        $this->yunset('xieyi',$xieyi);
        $yinsi  =  $descM -> getDes(array('name'=>array('like','隐私政策')),array('field'=>'content'));
        $this->yunset('yinsi',$yinsi);
		$checkurl=$_COOKIE['checkurl'];
       	$this->yunset("checkurl",$checkurl);
        unset($checkurl);
		$this->yunset('headertitle',"会员登录");
		$this->seo('login');	
		if(strpos($_SERVER['HTTP_REFERER'],'applyjobuid')){
			if($this->config['sy_seo_rewrite']){
				$endurl=str_replace(array(Url('wap'),'.html'),array('',''),$_SERVER['HTTP_REFERER']);
				$furl=explode('-',$endurl);
				$eurl=explode('_',$furl[2]);
			}else{
				$endurl=str_replace(Url('wap',array('c'=>'job','a'=>'applyjobuid')).'&','',$_SERVER['HTTP_REFERER']);
				$eurl=explode('=',$endurl);
			}
			$this -> yunset('backurl', Url('wap',array('c'=>'job','a'=>'comapply','id'=>$eurl['1'])));
		}elseif(strpos($_SERVER['HTTP_REFERER'],'wxconnect')){
		    $this -> yunset('backurl', Url('wap'));
		}else{
			$this -> yunset('backurl', $_SERVER['HTTP_REFERER']);
		}
		$this->yuntpl(array('wap/login'));
	}

    function mlogin_action()
    {
        //普通账户登录提交
        $lData['username']      =   $_POST['username'];
        $lData['uid']           =   $this->uid;
        $lData['usertype']      =   $this->usertype;
        $lData['act_login']     =   $_POST['act_login'];
        $lData['moblie']        =   $_POST['moblie'];
        $lData['backurl']       =   $_POST['backurl'];
        $lData['password']      =   $_POST['act_login'] == 1 ? $_POST['dynamiccode'] : $_POST['password'];
        $lData['qfyuid']        =   $_POST['qfyuid'];
        $lData['job']           =   $_POST['job'];
        $lData['checkurl']      =   $_POST['checkurl'];
        $lData['source']        =   2;
        $lData['authcode']      =   $_POST['authcode'];
        $lData['port']          =   2;

        $UserinfoM  =   $this->MODEL('userinfo');

        $return     =   $UserinfoM->userLogin($lData);

        if ($return['errcode'] == 2) {

            $this->layer_msg('', 9, 0, Url('wap', array('c' => 'register', 'a' => 'ident')), 2);
        } else if ($return['errcode'] == 9) {

            $this->layer_msg('', 9, 0, $return['url'], 2);
        } else {

            $this->layer_msg($return['msg'], 8, 0, '', 2);
        }
    }

	//登录短信验证码发送
    function sendmsg_action()
    {
        $noticeM    =   $this->MODEL('notice');
        $result     =   $noticeM->jycheck($_POST['authcode'], '前台登录');
        if (!empty($result)) {
            $this->layer_msg($result['msg'], 9, 0, '', 2, $result['error']);
        }

        $moblie     =   $_POST['moblie'];
        $UserinfoM  =   $this->MODEL('userinfo');
        $userinfo   =   $UserinfoM->getInfo(array("moblie" => $moblie), array('field' => "`usertype`,`uid`"));

        if ($this->config['sy_reg_type'] == 2 && empty($userinfo)){

            $result =   array(
                'error' =>  2,
                'msg'   =>  '请先注册账号'
            );
        } else {
            $user   = array(
                'uid'   => $userinfo['uid'],
                'usertype'  =>  $userinfo['usertype']
            );

            $result = $noticeM->sendCode($moblie, 'login', 1, $user, 6, 90, 'msg');
        }

        echo json_encode($result);
        exit();
    }

	function loginlock_action(){
		$this->seo("login"); 
		$this->yuntpl(array('wap/loginlock'));
	}
	function utype_action(){
		if($this->uid){
		    $this->wapheader('member/');
		}
		$this->seo("login");
		$this->yuntpl(array('wap/utype'));
	}

	function setutype_action(){
		if($_COOKIE['username'] && $_COOKIE['password'] && (CheckRegUser($_COOKIE['username']) OR CheckRegEmail($_COOKIE['username']))){
			$Member			=		$this->MODEL("userinfo");
			$RatingM		=		$this->MODLE('rating');
			$user 			= 		$Member->getInfo(array("username"=>$_COOKIE['username']),array("field"=>"`uid`,`username`,`password`,`salt`,`usertype`,`did`"));
		
			$userid 		= 		$user['uid'];
			if(!$user['usertype']){
				if(passCheck($_COOKIE['password'],$user['salt'],$user['password']) && $user['password']!=''){
					$usertype 			=  (int)$_GET['usertype'];
					if($usertype=='1'){
						$table1 		=  "member_statis";
						$table2			=  "resume";
						$data1			=  array("uid"=>$userid);
						$data2['uid']	=  $userid;
					}elseif($usertype=='2'){
						$table1 		=  "company_statis";
						$table2 		=  "company";
						$ratingM        =  $this->MODEL('rating');
						$data1          =  $ratingM->FetchRatingInfo();
						$data2['uid']	=  $userid;
						$data1['did']	=  $user['did'];
					}elseif($usertype=='3'){
						$table1			=  'lt_statis';
						$table2			=  'lt_info';
						$id 			=  $this->config['lt_rating'];
						$rwhere['id']	=  $id;

						$row 			=  $RatingM->getInfo($rwhere);
						$data1=array('uid'=>$userid,'rating'=>$id,'rating_name'=>$row['name'],'rating_type'=>$row['type'],'lt_job_num'=>$row['lt_job_num'],'lt_down_resume'=>$row['lt_resume'],'lt_editjob_num'=>$row['lt_editjob_num'],'lt_breakjob_num'=>$row['lt_breakjob_num']);
						if($row['service_time']>0){
							$time=time()+86400*$row['service_time'];
						}else{
							$time=0;
						}
						$data1['vip_etime']=$time;
						$data2['uid']=$userid;
						$data2['did']=$user['did'];

					}elseif($usertype=='4'){
						$table1 = 'train_statis';
						$table2 = 'px_train';
						$data1=array('uid'=>$userid,'integral'=>$this->config['integral_reg']);
						$data2['uid']=$userid;
						$data2['did']=$user['did'];
					}
					$Member->upInfo(array("uid"=>$userid),array("usertype"=>$usertype));
					$Member->InsertReg($table1,$data1);
					$Member->InsertReg($table2,$data2);
					
					if(($usertype == '1' && $this->config['user_state']!='1') || ($usertype == '2' && $this->config['com_status']!='1') || ($usertype == '3' && $this->config['lt_status']!='1') ||  ($usertype == '4' && $this->config['px_status']!='1')){
						$this->ACT_msg_wap(Url('wap',array('c'=>'login')),'请等待账户审核！', 1, 3);
						$this->yuntpl(array('wap/utype'));
					}else{
						$this->cookie->add_cookie($userid,$user['username'],$user['salt'],$user['email'],$user['password'],$usertype,$this->config['sy_logintime'],$user['did']);
						$this->wapheader('member/');
					}
					
				}else{
					$this->cookie->unset_cookie();
					echo "激活失败";
				}
			}else{
				$this->cookie->unset_cookie();
				echo "激活失败";
			}
		}else{
			header("Location:".Url('wap'));
		}
	}
	/**
	 * 绑定微信、关注公众号二维码（主要是已登录用户未绑定微信，视频面试、宣讲会预约需要发微信通知，需要用户关注公众号并绑定微信）
	 */
	function wxlogin_action(){
	    
	    $WxM=$this->MODEL('weixin');
	    $qrcode = $WxM->applyWxQrcode($_COOKIE['wxloginid'], '', $this->uid);
	    if(!$qrcode){
	        echo 0;
	    }else{
	        echo $qrcode;
	    }
	}
	/**
	 * 查询微信二维码扫码绑定情况（主要是已登录用户未绑定微信，视频面试、宣讲会预约需要发微信通知，需要用户关注公众号并绑定微信）
	 */
	function getwxloginstatus_action(){
	    
	    if($_COOKIE['wxloginid']){
	        
	        $WxM	 =  $this->MODEL('weixin');
	        $result  =  $WxM->getWxLoginStatus($_COOKIE['wxloginid'], $this->uid);
	        if($result['status'] == 1 && !empty($result['member'])){
	            
	            $this->layer_msg('扫码成功',9);
	            
	        }else{
	            
	            $this->layer_msg('');
	        }
	    }else{
	        $this->layer_msg('');
	    }
	}
	//查询马甲绑定
	function magbind(){
	    if ($this->config['sy_maglogin']==1 && !$_POST){
	        session_start();
	        if (!$_SESSION['mag']['user_id']){
	            $this->getMag();
	        }
	        if($_SESSION['mag']['user_id']){
				$userinfoM	 		= 		$this->MODEL('userinfo');
				$where['maguid']	=		$_SESSION['mag']['user_id'];
	            $userinfo 	 		=		$userinfoM->getInfo($where,array('field'=>'`uid`,`usertype`,`username`,`email`,`password`,`salt`,`status`,`did`'));
	            $time 				= 		time();
	            if (!$userinfo['uid']){
	                $this->yunset("maglogin",1);
	            }else{
	                //锁定
	                if($userinfo['status']=="2"){
	                    header('Location: '.Url('wap',array('c'=>'login','a'=>'loginlock','type'=>1)));
	                    exit();
	                }
	                $ip 			= 		fun_ip_get();
	                $logdate		=		date("Ymd",$userinfo['login_date']);
	                $nowdate		=		date("Ymd",$time);
	                if($logdate!=$nowdate){
	                    $integralM  =  $this->MODEL('integral');
	                    $integralM->invtalCheck($userinfo['uid'],$userinfo['usertype'],"integral_login","会员登录",22);
					}
					$bwhere['uid']		=		$userinfo['uid'];
					$bdata				=		array(
						'login_ip'		=>		$ip,
						'login_date'	=>		$time,
						'login_hits'	=>		array('+',1)
					);
					$userinfoM->upInfo($bwhere,$bdata);
	                $this->cookie->add_cookie($userinfo['uid'],$userinfo['username'],$userinfo['salt'],$userinfo['email'],$userinfo['password'],$userinfo['usertype'],$this->config['sy_logintime'],$userinfo['did']);
	                $this->wapheader('member/index.php');
	            }
	        }
	    }
	}
	function getMag(){
	    $userAgent 		= 		$_SERVER['HTTP_USER_AGENT'];
	    $info 			=	    strstr($userAgent, "MAGAPPX");
	    $info			=		explode("|",$info);
	    $agent			=		array('token'=>$info[7]);
	    if ($agent['token']){
	        $Url		= 		$this->config['sy_magweburl']."/mag/cloud/cloud/getUserInfo?token=".$agent['token']."&secret=".$this->config['sy_magsecret'];
	        $CurlReturn =		CurlGet($Url);
	        $result		=		json_decode($CurlReturn,true);
	        if ($result['success']==true){
	            //获取马甲用户头像
	            if(strpos($result['data']['head'],$this->config['sy_magimgurl'])===false){
	                $headData 	= 		@explode("?",$result['data']['head']);
	                $head 		= 		$this->getImage($headData[0], 'user');
	            }else{
	                $head 		= 		$result['data']['head'];
	            }
	            $_SESSION['mag']["user_id"] 		= 		$result['data']['user_id'];
	            $_SESSION['mag']["name"] 			= 		$result['data']['name'];
	            $_SESSION['mag']["head"] 			= 		$head;
	        }
	    }
	}
	//获取马甲用户头像
	function getImage($url,$path){
	    $CurlReturn 	=		 CurlGet($url);
	    $time 			= 		 time();
	    $filename	 	= 		 $time.'.jpg';
	    $picDir 		= 		 date('Ymd', $time);
	    $dirName 		= 		 APP_PATH . '/data/upload/'.$path.'/' . $picDir;
	    if (!file_exists($dirName)){
	        mkdir($dirName, 0777, true);
	    }
	    $res 			= 		 fopen($dirName . '/' . $filename, 'a');
	    fwrite($res, $CurlReturn);
	    fclose($res);
	    return $this->config['sy_weburl'].'/data/upload/'.$path.'/' . $picDir.'/'.$filename;
	}
	// 判断运行环境是否为千帆云APP
	function isqfy(){
	    $userAgent  =  strtolower($_SERVER['HTTP_USER_AGENT']);
	    if (stripos($userAgent, 'qianfan') !== false && $this->config['sy_qfylogin'] == 1){
	        $this->yunset('qfylogin', 1);
	    }
	}
	//查询千帆云绑定
	function qfybind_action(){
	    if ($this->config['sy_qfylogin']==1 && $_POST['qfyuid']!=''){
			$userinfoM 				= 		$this->MODEL('userinfo');
			$uwhere['qfyuid']		=		$_POST['qfyuid'];
	        $userinfo 				= 		$userinfoM->getInfo($uwhere,array("field"=>"`uid`,`usertype`,`username`,`email`,`password`,`salt`,`status`,`did`"));
	        $time 					= 		time();
	        if ($userinfo && is_array($userinfo)){
	            //锁定
	            if($userinfo['status']=="2"){
	                echo json_encode(array('error'=>2,'url'=>'?c=login&a=loginlock&type=1'));die;
	            }
	            $ip 				= 		fun_ip_get();
	            $logdate			=		date("Ymd",$userinfo['login_date']);
	            $nowdate			=		date("Ymd",$time);
	            if($logdate!=$nowdate){
	                $IntegralM  =  $this->MODEL('integral');
					$IntegralM->invtalCheck($userinfo['uid'],$userinfo['usertype'],"integral_login","会员登录",22);
				}
				$awhere['uid']		=		$userinfo['uid'];
				$adata				=		array(
					'login_ip'		=>		$ip,
					'login_date'	=>		$time,
					'login_hits'	=>		array('+',1)
				);					
	            $userinfoM->upInfo($awhere,$adata);
	            $this->cookie->add_cookie($userinfo['uid'],$userinfo['username'],$userinfo['salt'],$userinfo['email'],$userinfo['password'],$userinfo['usertype'],$this->config['sy_logintime'],$userinfo['did']);
	            echo json_encode(array('error'=>1,'url'=>'member/index.php'));die;
	        }else{
	            echo json_encode(array('error'=>-1));die;
	        }
	    }
	}
	/**
	 * 第三方登录后，绑定已有账号，登录验证并绑定
	 */
	function baloginsave_action(){

		$userinfoM			=  $this->MODEL('userinfo');
	    if($_POST['provider']=='weixin'){
	    	session_start();
	    	if($_SESSION['wx']['openid']){
            
	            $lData['openid']	=	$_SESSION['wx']['openid'];
	            $lData['unionid']	=	$_SESSION['wx']['unionid'];
				$lData['username']	=	$_POST['username'];
				$lData['uid']		=	$this->uid;
				$lData['source']	=	2;
				$lData['usertype']	=	$this->usertype;
				$lData['password']	=	$_POST['password'];
				$lData['authcode']	=	$_POST['authcode'];
				
	            $result	    		=	$userinfoM->bindacount($lData,'weixin');
	            
	        }else{
	            $result['msg']		=	'微信登录信息已失效，请重新登录！';
	        }
	    }else if($_POST['provider']=='qq'){
	    	session_start();
	    	if($_SESSION['qq']['openid']){
                
			    $lData['openid']	=	$_SESSION['qq']['openid'];
	            $lData['unionid']	=	$_SESSION['qq']['unionid'];
				$lData['username']	=	$_POST['username'];
				$lData['uid']		=	$this->uid;
				$lData['source']	=	2;
				$lData['usertype']	=	$this->usertype;
				$lData['password']	=	$_POST['password'];
				$lData['authcode']	=	$_POST['authcode'];
			    
			    $result	    		=  $userinfoM->bindacount($lData,'qq');
			    
			}else{
			    $result['msg'] 		= 'QQ登录信息已失效，请重新登录！';
			}

	    }else if($_POST['provider']=='sinaweibo'){
	    	session_start();
	    	if($_SESSION['sina']['openid']){
                
			    $lData['openid']	=	$_SESSION['sina']['openid'];
	            $lData['username']	=	$_POST['username'];
				$lData['uid']		=	$this->uid;
				$lData['source']	=	2;
				$lData['usertype']	=	$this->usertype;
				$lData['password']	=	$_POST['password'];
				$lData['authcode']	=	$_POST['authcode'];
			    
			    $result	    		=  $userinfoM->bindacount($lData,'sinaweibo');
			    
			}else{
			    $result['msg'] 		= '微博登录信息已失效，请重新登录！';
			}
	    }

        if($result['errcode']==2){
            $this->layer_msg('',9,0,Url('wap',array('c'=>'register','a'=>'ident')),2);
        }else if($result['errcode']==9){
            $this->layer_msg('',9,0,$result['url'],2);
        }else{
            $this->layer_msg($result['msg'],9,0,'',2);
        }
	}
	function balogin_action(){

		if($_POST['provider']=='weixin'){
			session_start();
			if($_SESSION['wx']['openid']){
				    
	            //微信未绑定账号直接注册账号的
		        $wdata  =  array(
		            'openid'   =>  $_SESSION['wx']['openid'],
		            'unionid'  =>  $_SESSION['wx']['unionid'],
		            'source'   =>  4
		        );
		        
		        $userinfoM  =  $this->MODEL('userinfo');
		        $result     =  $userinfoM->fastReg($wdata, '' ,'weixin');
		        
		        if ($result['errcode'] == 9){
		            $res['error'] 	= 1;
					$res['msg'] 	= '注册成功，请选择身份类型';
					$res['url'] 	= Url('wap',array('c'=>'register','a'=>'ident'));
		        }else{
		            $res['error'] 	= 2;
					$res['msg'] 	= '账号注册失败！';
					$res['url'] 	= Url('wap');
		        }
			}else{
				$res['error'] 	= 2;
				$res['msg'] 	= '微信登录信息已失效，请重新登录！';
				$res['url'] 	= Url('wap');
			}
		}else if($_POST['provider']=='qq'){
			session_start();
			if($_SESSION['qq']['openid']){
                
			    $wdata  =  array(
		            'openid'   =>  $_SESSION['qq']['openid'],
		            'unionid'  =>  $_SESSION['qq']['unionid'],
		            'source'   =>  8
		        );
		        
		        $userinfoM  =  $this->MODEL('userinfo');
		        $result     =  $userinfoM->fastReg($wdata, '' ,'qq');
		        if ($result['errcode'] == 9){
		            $res['error'] 	= 1;
					$res['msg'] 	= '注册成功，请选择身份类型';
					$res['url'] 	= Url('wap',array('c'=>'register','a'=>'ident'));
		        }else{
		            $res['error'] 	= 2;
					$res['msg'] 	= '账号注册失败！';
					$res['url'] 	= Url('wap');
		        }
			}else{
			    $res['error'] 	= 2;
				$res['msg'] 	= 'QQ登录信息已失效，请重新登录！';
				$res['url'] 	= Url('wap');
			}

		}else if($_POST['provider']=='sinaweibo'){
			session_start();
			if($_SESSION['sina']['openid']){
                
			    $wdata  =  array(
		            'openid'   =>  $_SESSION['sina']['openid'],
		            'source'   =>  10
		        );
		        
		        $userinfoM  =  $this->MODEL('userinfo');
		        $result     =  $userinfoM->fastReg($wdata, '' ,'sinaweibo');
		        
		        if ($result['errcode'] == 9){
		            $res['error'] 	= 1;
					$res['msg'] 	= '注册成功，请选择身份类型';
					$res['url'] 	= Url('wap',array('c'=>'register','a'=>'ident'));
		        }else{
		            $res['error'] 	= 2;
					$res['msg'] 	= '账号注册失败！';
					$res['url'] 	= Url('wap');
		        }
			}else{
			    $res['error'] 	= 2;
				$res['msg'] 	= '微博登录信息已失效，请重新登录！';
				$res['url'] 	= Url('wap');
			}
		}
		
		echo json_encode($res);
	}
}
?>