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
class set_controller extends user_controller
{
    //个人设置信息页面
    function getInfo_action()
    {
        
        $resumeM	=  $this->MODEL('resume');
        $resume		=	$resumeM->getResumeInfo(array('uid'=>$this->member['uid']),array('logo'=>1,'setname'=>1,'field'=>'`name`,`exp`,`edu`,`birthday`,`status`,`sex`,`telphone`,`moblie_status`,`email`,`email_status`,`idcard_pic`,`idcard_status`,`photo`,`def_job`'));


        if(empty($resume['name'])){
            
            $resume['name']	=	$this->member['username'];
        }
        
        $data  =  array_merge($this->member,$resume);
        
        $data['cuswitch']   =	$this->config['sy_user_change'];
        $data['iosfk']		=	$this->config['sy_iospay'] ;
        $data['sy_lietou_web']   = $this->config['sy_lietou_web'];
        $data['sy_train_web']   = $this->config['sy_train_web'];
        $data['xcx_contact']  =  $this->config['sy_xcx_contact'] ? $this->config['sy_xcx_contact'] : 2;
        $data['app_push']   =  $this->member['app_push'];
        
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
            if($_POST['provider'] == 'baidu'){
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
        
        $this -> render_json(0, 'ok', $data);
    }
    //查询用户是否有多重身份
    function transferInfo_action(){
        $userInfo   = $this->MODEL('userinfo');
        $userStatue = $userInfo -> getUserInfo(array('uid'=>$this->member['uid']),array('usertype'=>2));
        $userStat   = $userInfo -> getUserInfo(array('uid'=>$this->member['uid']),array('usertype'=>3));
        $userSta    = $userInfo -> getUserInfo(array('uid'=>$this->member['uid']),array('usertype'=>4));
        $this->yunset('userStatue',$userStatue);
        $this->yunset('userStat',$userStat);
        $this->yunset('userSta',$userSta);

        $data['userStatue']   = $userStatue;
        $data['userStat']   = $userStat;
        $data['userSta']   = $userSta;
        $data['config']	=	array(
			'reg_namemaxlen' 		=>  $this->config['sy_reg_namemaxlen'],
            'reg_nameminlen'		=>  $this->config['sy_reg_nameminlen'],
       		'reg_name_sp'    		=>  $this->config['reg_name_sp'],
            'reg_name_zm'    		=>  $this->config['reg_name_zm'],
            'reg_name_num'   		=>  $this->config['reg_name_num'],
            'reg_name_han'   		=>  $this->config['reg_name_han'],

            'reg_pw_sp'    			=>  $this->config['reg_pw_sp'],
            'reg_pw_zm'    			=>  $this->config['reg_pw_zm'],
            'reg_pw_num'   			=>  $this->config['reg_pw_num'],
		);
        $this -> render_json(0, 'ok', $data);
    }
    //身份证审核查询
	function getidcard_action(){
	    
		$ResumeM	=	$this		->	MODEL('resume');
		$resume		=	$ResumeM	->	getResumeInfo(array('uid'=>$this->member['uid']),array('logo'=>1));
		
		$return 	=	array(
			'statusbody'			=>	$resume['statusbody'],
            'url'			=>	$resume['idcard_pic'],
            'idcard'		=>	$resume['idcard'],
            'status'		=>	$resume['idcard_status'],
            'file_maxsize'	=>	$this->config['file_maxsize'],
            'pic_type'	=>	$this->config['pic_type']
        );
		$this -> render_json(1, 'ok', $return);
	}
	//上传身份证
	function saveidcard_action()
	{
	    $UserinfoM	=	$this -> MODEL('userinfo');
		
		$upResumeData	=	array(
			'name'		=>	$resume['name'],
			
			'idcard'	=>	$_POST['idcard'],
			
		    'uid'		=>	$this->member['uid'],
			
			'usertype'	=>	'1',
			'preview'   =>  $_POST['preview'],
			'file'		=>  $_FILES['photos']
		);
		
		$return		=	$UserinfoM -> upidcardInfo(array('uid'=>$this->member['uid']),$upResumeData);
		$error		=	$return['errcode']==9 ? 1 : 2;
		$this -> render_json($error, $return['msg']);
	}
	//手机认证,发送短信；
	function mobliecert_action(){
		$noticeM	=	$this -> MODEL('notice');	
		$logM		=	$this -> MODEL('log');
        if($_POST['type']=='wap') {

            $result = $noticeM->jycheck($_POST['code'], '');
            if (!empty($result)) {
                $this->render_json($result['error'], "图片验证码错误");
            }
        }
		$moblie 	=	$_POST['moblie'];
     //判断手机号码是否存在
		$UserinfoM         =   $this->MODEL('userinfo');
		$where['uid']      =   array('<>',$this->member['uid']);
		$where['moblie']   =   $_POST['moblie'];
		$Info              =  $UserinfoM->getInfo($where);
		if(!checkMsgOpen($this -> config)){
	        $this->render_json(10,'没有配置短信,请联系管理员');
	    }elseif($this->config['sy_msg_cert']=="2"){
	        $this->render_json(10,'短信通知已关闭，请联系管理员');
		}elseif($Info){
			$this->render_json(10,'手机号码已存在，请重新填写新号码');
		}else{
			 $moblie =	$_POST['moblie'];
	    	 $msgM	=	$this->MODEL('mobliemsg');
	         $num	=	$msgM->getNum(array('moblie'=>$moblie,'ctime'=>array('>',strtotime('today'))));
	         if($num>=$this->config['moblie_msgnum']){
	            $this->render_json(12,'同一手机号一天发送次数已超');
	         }
	         $ip		=	fun_ip_get();
	         $ipnum	=	$msgM->getNum(array('ip'=>$ip,'ctime'=>array('>',strtotime('today'))));
	        if($ipnum>=$this->config['ip_msgnum']){
	            $this->render_json(13,'同一ip一天发送次数已超',13);
	        }
			$user 		=	array(
				'uid'      => $this->member['uid'],
				'usertype' => '1'
			);
			$port	=	$this->plat == 'mini' ? '3' : '4';	// 短信发送端口$port : 3-小程序  4-APP
			$result =	$noticeM->sendCode($moblie, 'cert', $port, $user);
			$logM -> addMemberLog($user['uid'], $user['usertype'], '手机认证验证码，认证手机号：'.$moblie, 13, 1);
			$this -> render_json(0, 'ok', $result);
		}
	}
	//修改密码
	function pwd_action()
	{
		$UserinfoM  =   $this->MODEL('userinfo');
		$data   	=   array(
            
		    'uid'           =>  $this->member['uid'],
            'usertype'      =>  '1',
            'oldpassword'   =>  $_POST['oldpwd'],
            'password'      =>  $_POST['newpwd'],
            'repassword'    =>  $_POST['confirmpwd']
            
        );
		$err			=   $UserinfoM -> savePassword($data);
    
		$data['error']	=	$err['errcode']==9 ? 1 : 2;
		
		$this -> render_json($data['error'], $err['msg']);
		
	}
	//手机号和邮箱绑定
	function bindingbox_action()
	{
	    if($_POST['id']=='tel'){
			
			$CompanyM     		=   	$this -> MODEL('company');
          
        	$UserinfoM   		=   	$this->MODEL('userinfo');
          
          	$moblie      		=    	$_POST['moblie'];
          
          	$uid          		=   	$this->member['uid'];
          
			$where['uid']      	=   	array('<>',$uid);
			  
          	$where['moblie']   	=   	$moblie;
          
          	$Info              	=  		$UserinfoM->getInfo($where);
          	if($Info){

				$error			=		2;

				$msg    		=    	'手机号码已存在，请重新填写新号码';
				   
          	}else{

				$data  =  array(
					
					'uid'		=>  $this->member['uid'],
					'usertype'  =>  '1',
					'moblie'	=>  $_POST['moblie'],
					
				);
				$res  =  array();
				$user    =  $UserinfoM->getInfo(array('uid'=>$uid),array('field'=>'username,moblie,password,salt,usertype'));
				if (isset($_POST['provider']) && $user['username'] == $user['moblie']){
				    // 用户名和手机号重复，修改手机号会修改用户名，需要重新生成token;
				    $token  =  md5($data['moblie'].$user['password'].$user['salt'].$user['usertype']);
				    $res['user']  =  array('uid'=>$uid,'usertype'=>$user['usertype'],'token'=>$token);
				}
		    	$return		=	  $CompanyM -> upCertInfo(array('uid'=>$this->member['uid'],'check2'=>$_POST['code']),array('status'=>'1'), $data); 
	
				if($return==4){
					$error		=		2;
					$msg		=		'验证码时间已过期，请重新获取验证码';
				}elseif($return ==3){
					$error		=		2;
					$msg		=		'验证码错误';
				}elseif($return ==2){
					$error		=		2;
					$msg		=		'验证码不存在，请获取验证码';
				}elseif($return==1){
					$error		=		1;
				}else{
					$error		=		2;
					$msg		=		'绑定失败';
				} 
			}
          
	    }elseif ($_POST['id']=='email'){

			$ComapnyM	=	$this->MODEL('company');
			//判断邮箱是否存在
			$UserinfoM   		=   	$this->MODEL('userinfo');
          
          	$email      		=    	$_POST['email'];
          
          	$uid          		=   	$this->member['uid'];
          
			$where['uid']      	=   	array('<>',$uid);
			  
          	$where['email']   	=   	$email;
          
			$Info              	=  		$UserinfoM->getInfo($where);
            $noticeM	=	$this -> MODEL('notice');

            if($_POST['type']=='wap') {

                $result = $noticeM->jycheck($_POST['code'], '');
                if (!empty($result)) {
                    $this->render_json($result['error'], "图片验证码错误");
                }
            }
          	if($Info){
				$error			=		2;
				$msg    		=    	'邮箱已存在，请重新填写邮箱';
          	}else{

				$data      	=   array(
		                
					'usertype' 	=>  '1',
					
					'email'    	=> 	$_POST['email']
					
				);
				$return			=   $ComapnyM -> sendCertEmail(array('uid'=>$this->member['uid'], 'type'=>'1'), $data);
				if($return  == 3){

					$error			=		2;
					$msg    		=    	'邮件没有配置，请联系管理员！';
				}elseif($return ==2){

					$error			=		2;
					$msg			=		'邮件通知已关闭，请联系管理员';
				}elseif($return ==1){
					$error			=		1;
				}else{
				
					$error			=		2;
					$msg			=		'操作错误';
				}
			
			}

		}
		
		$this -> render_json($error,$msg,$res);
		
	}
	//修改用户名
	function setname_action(){
		$UserinfoM	=	$this->MODEL('userinfo');
		$data	=	array(
			'username'	=>  trim($_POST['username']),
			'password'	=>  trim($_POST['password']),
			'uid'		=>  $this->member['uid'],
			'usertype'	=>  1,
			'restname'	=>  '1'
		);
		if (!empty($data['username'])) {
			$return =	$UserinfoM->saveUserName($data);
			
			if($return['errcode'] == '1'){
				$error	=	1;
			}else{
				$error	=	2;
				$msg	=	$return['msg'];
			}
		}else{
			$error	=	2;
			$msg	=	'修改失败';
		}
		
		$this -> render_json($error, $msg);
		
	}
    //账户分离
	function transfer_action(){
	
		
		if($_POST['bdtypes']){
			$_POST['bdtype'] = explode(',',$_POST['bdtypes']);
		}
		$transferM	=	$this -> MODEL('transfer');
		
		$return		=	$transferM -> setTransfer($this->member['uid'],$_POST);
		
		
		$this -> render_json($return['errcode'], $return['msg']);
	}
    //社交账号绑定页面
	function getBind_action(){
	    
	    $userInfoM  =  $this->MODEL('userinfo');
	    $member     =  $userInfoM->getInfo(array('uid'=>$this->member['uid']),array('field'=>'`qqid`,`bdopenid`,`qqunionid`,`wxid`,`wxopenid`,`unionid`,`app_wxid`,`sinaid`,`maguid`,`qfyuid`'));
	    
	    $return  =  array(
	        'qqbind'    =>  0,
	        'wxbind'    =>  0,
	        'sinabind'  =>  0,
	        'magbind'   =>  0,
	        'qfybind'   =>  0,
            'bdbind'    =>  0,
	    );
	    if (isset($this->config['sy_qqdt']) && $this->config['sy_qqdt'] == 1 && !empty($member['qqunionid'])){
	        $return['qqbind']  =  1;
	    }elseif (!empty($member['qqid'])){
	        $return['qqbind']  =  1;
	    }
	    if ($_POST['provider'] == 'app'){
	        if (!empty($member['app_wxid']) || !empty($member['unionid'])){
	            $return['wxbind']  =  1;
	        }else{
	            if (!empty($member['wxid'])){
	                $return['wxbind']  =  2;
	            }
	        }
	    }elseif ($_POST['provider'] == 'h5'){
	        if (!empty($member['wxid']) || !empty($member['unionid'])){
	            $return['wxbind']  =  1;
	        }else{
	            if (!empty($member['wxopenid']) || !empty($member['app_wxid'])){
	                $return['wxbind']  =  2;
	            }
	        }
	    }else{
	        if (!empty($member['wxopenid']) || !empty($member['unionid'])){
	            $return['wxbind']  =  1;
	        }else{
	            if (!empty($member['wxid']) || !empty($member['app_wxid'])){
	                $return['wxbind']  =  2;
	            }
	        }
	    }
	    if (!empty($member['sinaid'])){
	        $return['sinabind']  =  1;
	    }
	    if (!empty($member['maguid'])){
	        $return['magbind']  =  1;
	    }
	    if (!empty($member['qfyuid'])){
	        $return['qfybind']  =  1;
	    }
        if (!empty($member['bdopenid'])){
            $return['bdbind'] = 1;
        }
	    $this->render_json(0, 'ok', $return);
	}
	//保存社交账号绑定
	function binding_action()
	{
	    if ($_POST['isbind'] == 1){
	        
	        $uni = 'wxapp';
	        if (isset($_POST['provider'])){
	            if ($_POST['provider'] == 'weixin'){
	                $uni = '微信小程序';
	            }elseif ($_POST['provider'] == 'app'){
	                $uni = 'APP/微信';
	            }elseif ($_POST['provider'] == 'h5'){
	                $uni = 'H5/微信';
	            }
	        }
	        if ($_POST['type'] == 'qq'){
	            
	            $uni =  'APP/QQ';
	            
	        }elseif ($_POST['type'] == 'sinaweibo'){
	            
	            $uni =  'APP/weibo';
	        }elseif ($_POST['type'] == 'mag'){
	            
	            $uni =  '马甲APP';
	        }elseif ($_POST['type'] == 'qfy'){
	            
	            $uni =  '千帆云APP';
	        }elseif ($_POST['type'] == 'baidu'){
	            $uni = '百度小程序';
            }
	        $comM      =   $this -> MODEL('company');
	        $comM -> delBd($this->member['uid'], array('type'=>$_POST['type'], 'usertype'=>$this->member['usertype']));
	        
	        $logM  =  $this->Model('log');
	        $logM->addMemberLog($this->member['uid'],$this->member['usertype'], $uni.'解除绑定');
	        
	        $this->render_json(0, 'ok');
	        
	    }else{
	        
	        $bdData['uid']     =  $this->member['uid'];
	        $bdData['type']    =  $_POST['type'];
	        $bdData['openid']  =  $_POST['openid'];
	        $bdData['provider']=  $_POST['provider'];
	        if (!empty($_POST['unionid'])){
	            
	            $bdData['unionid']	= $_POST['unionid'];
	        }
	        
	        if ($_POST['type'] == 'weixin' && !empty($_POST['code'])){
	            
	            $getdata  =  $this->getOpenid($_POST['code']);
	            if (isset($getdata['errcode'])){
	                $this->MODEL('errlog')->addErrorLog($this->member['uid'], 10, '微信小程序绑定获取openid错误。code:'.$_POST['code'].'。'.$getdata['errcode'].'，'.$getdata['errmsg']);
	                $this->render_json($getdata['errcode'],$getdata['errmsg']);
	            }
	            $bdData['openid']  =  $getdata['openid'];
	            if (!empty($getdata['unionid'])){
	                
	                $bdData['unionid']	=	$getdata['unionid'];
	            }
	        }elseif ($_POST['type']=='baidu' && !empty($_POST['code'])){
                $getdata  =  $this->getBdOpenid($_POST['code']);
                if (isset($getdata['errno'])){
                    $this->MODEL('errlog')->addErrorLog('', 10, '百度小程序登录获取openid错误。code:'.$_POST['code'].'。'.$getdata['error'].'，'.$getdata['error']);
                    $this->render_json($getdata['errno'],$getdata['error']);
                }
                $bdData['openid']  =  $getdata['openid'];
            }
	        $userInfoM  =  $this->MODEL('userinfo');
	        $return     =  $userInfoM->loginBind($bdData);
	        $this->render_json($return['error'],$return['msg']);
	    }
	}
	// 查询申请注销记录
	function getLogout_action()
	{
	    $logoutM  =  $this->MODEL('logout');
	    $row      =  $logoutM->getInfo(array('uid'=>$this->member['uid']));
	    
	    if (!empty($row)){
	        
	        $this->render_json(1,'您已申请了注销账号');
	    }else{

	        $this->render_json(0,'ok');
	    }
	}
	//注销账号申请
	public function logoutApply_action()
	{
        $_POST  =   $this->post_trim($_POST);

        $p      =   array(
            'password'  =>  $_POST['password']
        );

        $logoutM=   $this->MODEL('logout');
        $return =   $logoutM->apply(array('uid' => $this->member['uid']), $p);

        if ($return['errcode'] == 9) {

            $this->render_json(0, 'ok');
        } else {

            $this->render_json($return['errcode'], $return['msg']);
        }
	}
	// 开启、关闭app推送
    function pushSet_action()
    {

        $UserinfoM  =   $this->MODEL('userinfo');
        $UserinfoM->upInfo(array('uid' => $this->member['uid']), array('app_push' => $_POST['app_push']));
        $this->render_json(0, 'ok');
    }
}