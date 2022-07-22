<?php

/**
 * $Author ：PHPYUN开发团队
 *
 * 官网: http://www.phpyun.com
 *
 * 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
 *
 * 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */

class set_controller extends com_controller
{
    
	function getCert_action()
	{

		$comM		=   $this -> MODEL('company');
		$comCert	=   $comM -> getCertInfo(array('uid' => $this->member['uid'], 'type' => '3'));
		
        $data['comname']    =   $this->comInfo['name'];
        $data['statusbody'] =   $comCert['statusbody'];
        if($comCert){

          $data['status']   =   $comCert['status'];
        }else{

           $data['status']  =   -1;
        }

        $data['com_social_credit']	=   $this->config['com_social_credit'];
        $data['com_cert_owner']	    =   $this->config['com_cert_owner'];
        $data['com_cert_wt']	    =   $this->config['com_cert_wt'];
        $data['com_cert_other']	    =   $this->config['com_cert_other'];
        // 小程序里面因安全域名限制，在开启oss的情况下，委托书/承诺函范本上传时服务器也传了一份，这里直接用服务器上的
        $data['exa_cert_wt']        =   $this->config['exa_cert_wt'] ? $this->config['sy_weburl'].$this->config['exa_cert_wt']:'';
        $data['pic_type']           =   $this->config['pic_type'];
        $data['file_maxsize']       =   $this->config['file_maxsize'];
        
        if($comCert['check'] || $comCert['owner_cert'] || $comCert['wt_cert'] || $comCert['other_cert']){
            
            $data['social_credit']  =   $comCert['social_credit'];
            $data['url']            =   $comCert['old_check'];
            $data['ocurl']          =   $comCert['old_owner_cert'];
            $data['wturl']          =   $comCert['old_wt_cert'];
            $data['otherurl']       =   $comCert['old_other_cert'];
	        $this->render_json(1,'ok',$data);
	    }else{
	        
	        $this->render_json(2,'',$data);
	    }

	}

	//上传企业认证图片处理返回url
	function upCertPic_action(){

		$UploadM		=	$this	->	MODEL('upload');

		$picurl			=	'';
		$msg			=	'';
		$error			=	'';

		if(isset($_FILES['file'])){
				    // pc端上传
		    $upArr    	=  array(
		        'file'  =>  $_FILES['file'],
		        'dir'   =>  'cert'
		    );
		    $uploadM  	=	$this->MODEL('upload');
		    $pic      	=	$uploadM->newUpload($upArr);

		    if (!empty($pic['msg'])){

		    	$error	=	2;
		        $msg 	= 	$pic['msg'];

		    }elseif (!empty($pic['picurl'])){
		        $error	=	1;
		        $picurl =  $pic['picurl'];
		    }
		}else{
			$error	=	2;
		    $msg 	= 	'请选择图片';
		}

		$this->render_json($error,$msg,$picurl);
	}

	//上传企业资质
	function saveCert_action()
	{
		
		$comM		=   $this -> MODEL('company');

		if($this->comInfo['r_status']==0){
		    
		    $status	=	$this->comInfo['r_status'];
		}else{

		    $status	=	$this -> config['com_cert_status'] == '1' ? 0 : 1;
		}

        $upData     =   array(
            'ctime'     =>  time(),
            'status'    =>  $status
        );
		if($_POST['social_credit']){
			$upData['social_credit']    =   $_POST['social_credit'];
		}
		if($_POST['check']){

			$upData['check']            =   $_POST['check'];
		}else if($_POST['base']){

            $upData['base']             =   $_POST['base'];
        }
		if($_POST['owner_cert']){

			$upData['owner_cert']       =   $_POST['owner_cert'];
		}else if($_POST['base_owner_cert']){

            $upData['base_owner_cert']  =   $_POST['base_owner_cert'];
        }
		if($_POST['wt_cert']){

			$upData['wt_cert']          =   $_POST['wt_cert'];
		}else if($_POST['base_wt_cert']){

            $upData['base_wt_cert']     =   $_POST['base_wt_cert'];
        }
		if($_POST['other_cert']){

			$upData['other_cert']       =   $_POST['other_cert'];
		}else if($_POST['base_other_cert']){

            $upData['base_other_cert']  =   $_POST['base_other_cert'];
        }

		$cert       =   $comM -> getCertInfo(array('uid' =>$this->member['uid'], 'type' => '3'));
		
		//判断是否上传必要资质
        $errcode    =   0;
        $msg        =   '必须上传';
        $douhao     =   false;


        if($this->config['com_cert_owner']==1 && !$_POST['owner_cert'] && !$cert['owner_cert'] && !$_POST['base_owner_cert']){
            if($douhao){
                $msg    .=  ',';
            }
            $douhao     =   true;
            $msg        .=  '经办人身份证';
            $errcode    =   8;
        }
        if($this->config['com_cert_wt']==1 && !$_POST['wt_cert'] && !$_POST['base_wt_cert'] && !$cert['wt_cert']){
            if($douhao){
                $msg    .=  ',';
            }
            $douhao     =   true;
            $msg        .=  '委托函';
            $errcode    =   8;
        }
        
        if($errcode==8){
        	$this->render_json(2,$msg);
		}
        //判断是否上传必要资质end

		if (!empty($cert) && $cert['ctime']) {
		     
		    $err        =   $comM -> upCertInfo(array('id'=>$cert['id'], 'uid' => $this->member['uid']), $upData, array('yyzz' => '1', 'usertype' => 2, 'com_name'=>trim($_POST['name'])));
			
		}else{
			$postData   =   array(
				'uid'       =>  $this->member['uid'],
				'type'      =>  '3',
				'step'      =>  '1',
				'did'       =>  $this ->config['did'],
				'usertype'  =>  2,
			    'com_name'  =>  trim($_POST['name'])
			);
			$postData	=   array_merge($postData, $upData);
			$err		=   $comM -> addCertInfo($postData);
		}

		if($err){
			$error		=	$err['errcode']==9 ? 1 : 2;
			if($error==1){
                $msg    =   '更新成功！';
			}else{
			    $msg    =   !empty($err['msg']) ? $err['msg'] : '更新失败！';
			}
		}
		$this->render_json($error,$msg);
	}


	//手机认证,发送短信；
	function mobliecert_action()
	{
	    //判断手机号码是否存在
		$UserinfoM         =   $this->MODEL('userinfo');
		$where['uid']      =   array('<>',$this->member['uid']);
		$where['moblie']   =   $_POST['moblie'];
		$Info              =  $UserinfoM->getInfo($where);
		
		if($Info){
		    $this->render_json(10,'手机号码已存在，请重新填写新号码');
		}
		$com 	=	array(
		    'uid'      => $this->member['uid'],
		    'usertype' => '2'
		);
		$moblie		=	trim($_POST['moblie']);
		$noticeM	=	$this->MODEL('notice');

		$port		=	$this->plat == 'mini' ? '3' : '4';	// 短信发送端口$port : 3-小程序  4-APP
		$result		=	$noticeM->sendCode($moblie, 'cert', $port, $com);

		if ($result['error'] == 1){
		    
		    $logM  =  $this->MODEL('log');
		    $logM->addMemberLog($com['uid'], $com['usertype'], '手机认证验证码，认证手机号：'.$moblie, 13, 2);
		    $this->render_json(0,'ok');
		}else{
		    $this->render_json($result['error'],$result['msg']);
		}
	}

	function bindingbox_action()
	{
		$comM				=   	$this -> MODEL('company');

		$UserinfoM   		=   	$this->MODEL('userinfo');

		$uid          		=   	$this->member['uid'];
	    if($_POST['id']=='tel'){

			$moblie      		=    	$_POST['moblie'];
		
		  	$where['uid']      	=   	array('<>',$uid);
			
			$where['moblie']   	=   	$moblie;
		
			$Info              	=  		$UserinfoM->getInfo($where);
			if($Info){
				$this	->	render_json(2,'手机号码已存在，请重新填写新号码','');
			}else{
				$data     =   array(
					'uid'         =>	$this ->member['uid'],
					'usertype'    =>	$this ->member['usertype'],
					'moblie'      =>	$_POST['moblie'],
				);
				$return  =  array();
				$user    =  $UserinfoM->getInfo(array('uid'=>$uid),array('field'=>'username,moblie,password,salt'));
				if (isset($_POST['provider']) && $user['username'] == $user['moblie']){
				    // 用户名和手机号重复，修改手机号会修改用户名，需要重新生成token;
				    $token  =  md5($data['moblie'].$user['password'].$user['salt'].$user['usertype']);
				    $return['user']  =  array('uid'=>$uid,'usertype'=>$user['usertype'],'token'=>$token);
				}
				$result  =   $comM -> upCertInfo(array('uid'=>$this ->member['uid'], 'check2'=>$_POST['code']), array('status'=>'0'), $data);
				
				if($result==1){
				    $this	->	render_json(0,'手机绑定成功',$return);	
				}if($result==4){
					
				   $this	->	render_json(4,'短信验证码已过期，请重新发送！');
					
				}else  if($result==3){
					$this	->	render_json(3,'短信验证码不正确！');
				}else if($result==2){
					$this	->	render_json(2,'请先获取短信验证码！');
				}else{
					$this	->	render_json(2,'手机绑定失败！');
				}

			}

	    }elseif ($_POST['id']=='email'){
            if(!empty($_POST['source']) && $_POST['source'] == 'wap'){
                session_start();
                $code       =   $_POST['authcode'];
                if (md5(strtolower($code)) != $_SESSION['authcode'] || empty($_SESSION['authcode'])) {
                    $error	=	4;
                    $data['errmsg']	=	'验证码不正确';
                    $this	->	render_json($error,$data['errmsg']);
                }
            }

			$email      		=    	$_POST['email'];

			$where['uid']      	=   	array('<>',$uid);
			  
          	$where['email']   	=   	$email;
          
			$Info              	=  		$UserinfoM->getInfo($where);

			if($Info){
				$error	=	2;
				$data['errmsg']	=	'邮箱已存在，请重新填写邮箱';
				$this	->	render_json($error,$data['errmsg']);
			}else{
				$data      =   array(
					'usertype' =>  $this ->member['usertype'],
					'email'    =>  $_POST['email']
				);
				
				$return   =   $comM -> sendCertEmail(array('uid'=>$this->member['uid'], 'type'=>'1'), $data);
				if($return=='1'){
					$error	=	0;
					$data['errmsg']	=	'邮箱绑定成功';
					$this	->	render_json($error,$data['errmsg']);
				}elseif($return  == 3){
					$data['errmsg']    		=    	'邮件没有配置，请联系管理员！';
					$this	->	render_json($return,$data['errmsg']);
				}elseif($return ==2){
					$data['errmsg']			=		'邮件通知已关闭，请联系管理员';
					$this	->	render_json($return,$data['errmsg']);
				}else{
					$data['errmsg']	=	'操作错误';
					$this	->	render_json($return,$data['errmsg']);
				}
				
			}

	    }

	}

	function pwd_action()
	{
		if($_POST['newpwd']){
			$UserinfoM  =   $this->MODEL('userinfo');
			$data   	=   array(
			    'uid'           =>  $this->member['uid'],
			    'usertype'      =>  $this->member['usertype'],
                'oldpassword'   =>  $_POST['oldpwd'],
                'password'      =>  $_POST['newpwd'],
                'repassword'    =>  $_POST['confirmpwd']
            );
			$return    =   $UserinfoM -> savePassword($data);
			
		}
		$data['error']	=	$return['errcode']==9 ? 0 : 2;
		
		$this -> render_json($data['error'], $return['msg']);

	}
	
	function setname_action(){
		$UserinfoM	=	$this->MODEL('userinfo');
		$data	=	array(
			'username'	=>  trim($_POST['username']),
			'password'	=>  trim($_POST['password']),
			'uid'		=>  $this->member['uid'],
			'usertype'	=>  2,
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
		$this -> render_json($error, $msg,$return);
	}
	/**
	 * 子账号列表
	 */
	function child_action(){

		$comaM      =   $this -> MODEL('companyaccount');

        $rows       =   array();

        $page				=	$_POST['page'];

        $where['comid'] 	=   $this ->member['uid'];
        $total = $comaM->getNum($where);
		$where['orderby']	=	'uid';		

		$limit				=	$_POST['limit'] ? $_POST['limit'] : 10;

		if($page){//分页
			$pagenav		=	($page-1)*$limit;
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	$limit;
		}

        $rows	=	$comaM -> getWorkList($where);		
		
        $list	=	count($rows) ? $rows : array();
		$this	-> render_json(0,'',$list,$total);
	}
	/**
	 * 创建子账号之前检测数量
	 */
	function childCheck_action()
	{
	    $statisM    =   $this -> MODEL('statis');
	    $res        =   $statisM -> getItemUseCondition(array(
	        'uid'   =>  $this -> member['uid'],
	        'item'  =>  'sons_num'
	    ));
	    
	    if($res['ecode'] == 55){
	        $msg	=  $res['msg'];
	        $error	=  3;
	    }else{
	        $msg    =  'ok';
	        $error  =  0;
	    }
		$data['iosfk']		=	$this->config['sy_iospay'] ;
	    $this->render_json($error,$msg,$data);
	}
	/**
	 * 创建子账号
	 */
	function childedit_action(){

		$cuid		=	intval($_POST['cuid']);

		$sonInfo	=	array();
		$error		=	1;
		//检查是否可以套餐足够
		if(empty($cuid)){
			$statisM    =   $this -> MODEL('statis');
			$res        =   $statisM -> getItemUseCondition(array(
				'uid'   =>  $this -> member['uid'],
				'item'  =>  'sons_num'
			));
	
			if($res['ecode'] == 55){
				$msg	=	$res['msg'];	
				$error	=	3;
			}
		}else{
			$comaM      =   $this -> MODEL('companyaccount');
			$info		=	$comaM -> getWorkList(array('uid' => $cuid));
			if(empty($info)){
				$msg	=	'子账号不存在';
				$error	=	2;
			}
			$sonInfo	=	$info[0];
		}

		$this->render_json($error,$msg,$sonInfo);
		
		
	}
	/**
     * 添加 修改子账号
     */
    function childeditsave_action(){
        
        $_POST      =   $this -> post_trim($_POST);
        

        $cuid       =   intval($_POST['cuid']);

        $memberM    =   $this -> MODEL('userinfo');
        unset($_POST['cuid']);
        unset($_POST['uid']);
        if(empty($cuid)){
            $res    =   $memberM -> addChildInfo(array(
                'uid'       =>  $this -> member['uid'],
                'cdata'     =>  $_POST,
                'paytype'   =>  'vip'
              ));

        }else{
            $res    =   $memberM -> updChildInfo(array('uid' => $cuid), $_POST);
        }
        $error		=	$res['ecode'] == 9 ? 1:2;
        $msg		=	$res['msg'];

        $this->render_json($error,$msg);

    }
    /**
     * 删除子账号
     */
    public function del_action()
    {
        $_POST  =   $this -> post_trim($_POST);

        $comaM  =   $this -> MODEL('companyaccount');

        $res    =   $comaM -> delChild(array('pid' => $this->member['uid'], 'uid' => $_POST['suid']));
        $error	=	$res['ecode']==9 ? 1 : 2;
        $msg	=	$res['msg'];
        $this	->	render_json($error,$msg);
    }
    /**
	 * 分配子账号
	 */
	public function childassign_action(){

		if($_POST['submit']){//保存分配
			unset($_POST['submit']);
			$_POST      =   $this -> post_trim($_POST);
			//参数判断
			$cuid       =   intval($_POST['cuid']);
			if(empty($cuid)){
				$msg	=	'非法操作！';
				$error	=	2;
			}else{
				$statisM    	=   $this -> MODEL('statis');
				unset($_POST['cuid']);
				$_POST['uid']   =   $this -> member['uid'];
				$_POST['spid']  =   $cuid;

				
				$res        =   $statisM -> assignChildStatis($_POST);
				$error		=	$res['ecode']==9 ? 1 : 2; 
				$msg		=	$res['msg'];
			}
			
			$this->render_json($error,$msg,null);
		}
		
		$cuid		=	intval($_POST['cuid']);

		$inids      =   $this -> member['uid'].','.$cuid;

        $statisM    =   $this -> MODEL('statis');
        
		$statisList =   $statisM -> getList(array('uid' => array('in', $inids)));

		if(empty($statisList)){
			$msg	=	'主账号套餐不存在';
			$error	=	2;
		}else{
			$fatherS    =   $sonS   =   array();
        
			foreach ($statisList as $sv) {

	            if($sv['uid'] == $this -> member['uid']){
	            
					$fatherS		=   $sv;
	            }elseif ($sv['uid'] == $cuid) {
	                
					$sonS			=   $sv;
	            }
	        }

	        $data        =   array(
	            'fathers'   =>  $fatherS,
	            'sons'      =>  $sonS,
	            'chat_name'	=>  isset($this->config['sy_chat_name']) ? $this->config['sy_chat_name'] : '',
	            'chat_open' =>  isset($this->config['sy_chat_open']) ? $this->config['sy_chat_open'] : 2
			);
			$error	=	1;
			$msg	=	'';
		}

        $this->render_json($error,$msg,$data);
	}
	function upMap_action(){
	    $companyM	=	$this->MODEL('company');
	    if($_POST){
	    	$coordinates  =  $this->Convert_GCJ02_To_BD09($_POST['x'], $_POST['y']);
	        $data	=	array(
	            'xvalue'	=>	$coordinates['lng'],
	            'yvalue'	=>	$coordinates['lat']
	        );
	        $return	=	$companyM->setMap($this->member['uid'],$data);
	        if($return['cod']  == '9'){
	            $error	=	1;
	        }else{
	            $error	=	2;
	        }
	        $this->render_json($error, $return['msg']);
	    }
	}
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
	
	function binding_action()
	{
	    $userInfoM  =  $this->MODEL('userinfo');
	    
	    if ($_POST['isbind'] == 1){
	        
	        $uni = 'wxapp';
	        if (isset($_POST['provider'])){
	            if ($_POST['provider'] == 'weixin'){
	                $uni = '微信小程序';
	            }
	            if ($_POST['provider'] == 'app'){
	                $uni = 'APP/微信';
	            }
	        }
	        if ($_POST['type'] == 'weixin'){
	            
	            $up  =  array('wxid'=>'','wxopenid'=>'','app_wxid'=>'','unionid'=>'');
	            
	        }elseif ($_POST['type'] == 'qq'){
	            
	            $up  =  array('qqid'=>'','qqunionid'=>'');
	            $uni =  'APP/QQ';
	            
	        }elseif ($_POST['type'] == 'sinaweibo'){
	            
	            $up  =  array('sinaid'=>'');
	            $uni =  'APP/weibo';
	        }elseif ($_POST['type'] == 'baidu'){
	            $up = array('bdopenid'=>'');
	            $uni = '百度小程序';
            }
	        
	        $userInfoM->upInfo(array('uid'=>$this->member['uid']), $up);
	        
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
	        $return  =  $userInfoM->loginBind($bdData);
	        $this->render_json($return['error'],$return['msg']);
	    }
	}
	// 查询申请记录
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
            'password' => $_POST['password']
        );

        $logoutM=   $this->MODEL('logout');
        $return =   $logoutM->apply(array('uid' => $this->member['uid']), $p);

        if ($return['errcode'] == 9) {

            $this->render_json(0, 'ok');
        } else {

            $this->render_json($return['errcode'], $return['msg']);
        }
	}
	/**
	 * 邀请模板列表
	 */
	function yqmb_action(){
	    
	    
		$yqmbM              =   $this -> MODEL('yqmb');

        $page				=	$_POST['page'];

        $where['uid'] 	    =   $this ->member['uid'];
        		
		$where['orderby']	=	'id,desc';		

		$limit				=	$_POST['limit'] ? $_POST['limit'] : 10;

		if($page){//分页
			$pagenav		=	($page-1)*$limit;
			$where['limit']	=	array($pagenav,$limit);
		}else{
			$where['limit']	=	$limit;
		}

        $rows	=	$yqmbM -> getList($where);

        $mbnum	=	$yqmbM -> getNum(array('uid' => $this->member['uid']));
		
        $list	=	count($rows) ? $rows : array();

        $data['list'] 	= $list;

        $data['mbnum'] 	= $mbnum ? $mbnum : 0;

        $data['maxnum'] = $this->config['com_yqmb_num'] ? $this->config['com_yqmb_num'] : 0;

		$this->render_json(0,'',$data);
	}
	
	/**
     * 删除模板
     */
    public function delYqmb_action()
    {
        $_POST  =   $this -> post_trim($_POST);

        $yqmbM  =   $this -> MODEL('yqmb');

        $res    =   $yqmbM->delYqmb($_POST['id'],array('uid'=>$this->member['uid']));
        $error	=	$res['errcode']==9 ? 1 : 2;
        $msg	=	$res['msg'];
        $this	->	render_json($error,$msg);
    }
    
    function yqmbedit_action(){

		$yid		=	intval($_POST['yid']);
		$yqmbM      =   $this -> MODEL('yqmb');
		$error		=	1;
		
		if(empty($yid)){
			$mbnum	=	$yqmbM->getNum(array('uid'=>$this->member['uid']));
			
			$info   =  array(
			    'name'     =>  '',
			    'linkman'  =>  '',
			    'linktel'  =>  '',
			    'address'  =>  '',
			    'content'  =>  ''
			);
			if($mbnum>=$this->config['com_yqmb_num']){
				$msg	=	'最多可以创建'.$this->config['com_yqmb_num'].'个模板';	
				$error	=	3;
			}
		}else{
			$info		=	$yqmbM -> getInfo(array('id' => $yid));
			if(empty($info)){
				$msg	=	'模板不存在';
				$error	=	2;
			}
		}

		$this->render_json($error,$msg,$info);
		
		
	}
	function yqmbeditsave_action(){
		$_POST      =   $this -> post_trim($_POST);
        
		$yqmbM 		= 	$this->MODEL('yqmb');
        $yid       	=   intval($_POST['yid']);

        $where  	=   array();
		if($yid){
            
            $where['id']=   $yid;
            
        }
        
        $data = array(
            'uid'       =>  $this->member['uid']
        );
        $setdata = array(
            'name'      => $_POST['name'],
            'linkman'   => $_POST['linkman'],
            'linktel'   => $_POST['linktel'],
            'content'   => $_POST['content'],
            'intertime' => $_POST['intertime'],
            'address'   => $_POST['address'],
        );
        $return         =   $yqmbM->addInfo($setdata,$data,$where);

        $error		=	$return['errcode'] == 9 ? 1:2;
        $msg		=	$return['msg'];

        $this->render_json($error,$msg);
	}
    // 开启、关闭app推送
	function pushSet_action(){
	    
	    $UserinfoM = $this->MODEL('userinfo');
	    $UserinfoM->upInfo(array('uid'=>$this->member['uid']), array('app_push'=>$_POST['app_push']));
	    $this->render_json(0,'ok');
	}

    /**
     * 使用充值卡
     */
	function useCard_action()
    {

        $_POST  = $this->post_trim($_POST);
        $vData  =   array(
            'card'  =>  $_POST['card'],
            'password'  =>  $_POST['password']
        );

        $data['userdid'] = $this->userdid;

        $couponM=   $this->MODEL('coupon');
        $return =   $couponM->usePreCard($vData, array('uid' => $this->member['uid'], 'username' => $this->member['username'], 'usertype' => 2));

        $error  =	$return['errcode'] == 9 ? 1 : 2;
        $msg    =   $return['msg'];

        $this->render_json($error,$msg);


    }
}
?>