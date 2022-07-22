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

class userinfo_model extends model
{

    private $comstatusStr =array(
    	0	=>	' 被设为未审核状态',
    	1	=>	' 通过审核',
    	2	=>	' 被锁定',
    	3	=>	' 审核未通过',
    	4	=>	' 被暂停'
    );

    private function addErrorLog($uid,$type='',$content)
    {
        
        require_once ('errlog.model.php');
        $ErrlogM = new errlog_model($this->db, $this->def);
        return  $ErrlogM -> addErrorLog($uid, $type, $content);
    }
    
	// 获取账户信息
	function getInfo($where,$data=array())
    {
	    
	    $field  =	empty($data['field']) ? '*' : $data['field'];
	    
	    if (!empty($where)) {
	        
	        $member =   $this -> select_once('member',$where, $field);
	        
	        if($member && is_array($member)){
	            
	            /* 是否有修改用户名权限查询 */
	            if (isset($data['setname']) && $data['setname'] == '1') {
	                
	                if($member['restname']=='0'){
	                    
	                    $member['setname']  =  '1';
	                }
	            }
				if (isset($data['sf']) && $data['sf'] == '1') {
	                
					$sflist  		=  array(1=>'个人会员',2=>'企业会员',3=>'猎头会员',4=>'培训会员');
					
	                $member['sf']  	=  $sflist[$member['usertype']];
	            }
	            return $member;
            }
	    } 
	}

	//  账户数目
	function getMemberNum($Where = array()){
		return $this->select_num('member', $Where);
	}
	
	// 获取账户信息，多条查询
	public function getList($whereData , $data = array(),$utype='') {

	    $field =   $data['field'] ? $data['field'] : '*';
	    
	    $List =   $this -> select_all('member',$whereData, $field);
	    
 	    if ($utype == 'admin'){
 	        
 	        $List  =  $this -> getDataList($List);
 	    }
 	    return $List;
	}
	
	//添加用户
	public function addInfo($data){
	    
	    if ($data && is_array($data)){
	        
	        $mdata   =	$data['mdata'];
	        
	        $result  =  $this -> addMemberCheck($mdata);
	        
	        if ($result['msg']){
	            
	            return $result;
	        }
			if (!empty($mdata['clientid'])){
			    //清除其他账号clientid
			    $this->clearPushId($mdata['clientid']);
		    }
		    $mdata['did']   =   !empty($mdata['did']) ? $mdata['did'] : $this->config['did'];
	        $nid	=	$this->insert_into('member', $mdata);
	        if(!$nid){

				$user_id	=	$this->getInfo(array('username'=>$mdata['username']),array('field'=>'uid'));

				$nid		=	$user_id['uid'];

			}
	        if ($nid){
	            
	            $udata	=	!empty($data['udata']) ? $data['udata'] : array();
	            $sdata	=	!empty($data['sdata']) ? $data['sdata'] : array();
	            
	            $udata['uid']	=	$nid;
	            
	            if ($mdata['usertype'] == 1){
					$udata['did']   =   !empty($udata['did']) ? $udata['did'] : $this->config['did'];
					$this -> insert_into('resume',$udata);

					$sdata['uid']	=	$nid;
					$this -> insert_into('member_statis',$sdata);
	                
	            }else if ($mdata['usertype'] == 2){
	                if(empty($udata['crm_uid'])) {
	                    if($this->config['sy_crm_duty'] == 1){

                            $crm_uid = $this->getCrmUid(array('type' => '2'));
                        }
                        if ($crm_uid) {
                            $udata['crm_uid'] = $crm_uid;
                            $udata['crm_time'] = time();
                        }
                    }
	                $this -> insert_into('company',$udata);
	                $this -> addStatis($nid,$sdata);
	               
 	            }else if ($mdata['usertype'] == 5){
				 
                  $this -> insert_into('gq_info',$udata);
 	            }
	        }
	        return $nid;
	    }
	}

	/**
	 * 检查子账号
	 * 
	 */
	public function checkChild($data = array()){
		$res				=	array(
			'ecode'			=>	0,
			'msg'			=>	''
		);
		if(empty($data['uid'])){
			$res['ecode']	=	1;
			$res['msg']		=	'缺少企业id';
			return $res;
		}
		if(empty($data['cdata'])){
			$res['ecode']	=	2;
			$res['msg']		=	'缺少子账号信息';
			return $res;
		}
		$cdata				=	$data['cdata'];

		if(empty($cdata['name']) || empty($cdata['password'])){
			$res['ecode']	=	3;
			$res['msg']		=	'子账号信息不完整';
			return $res;
		}
		unset($cdata['password']);

		require_once ('companyaccount.model.php');        
		$comaM 				=	new companyaccount_model($this->db, $this->def);

		/*
		//判断子账号是否存在
		$oldData			=	$comaM -> getInfo(array('username' => $cdata['username'], 'comid' => $data['uid']));
      	
		if(!empty($oldData)){
			$res['ecode']	=	4;
			$res['msg']		=	'子账号已存在';
			return $res;
		}
        */

		//检查会员信息
		$result  			=	$this -> addMemberCheck($cdata);	        
		if (is_array($result) && !empty($result['msg'])){			
			$res['ecode']	=	$result['error'];
			$res['msg']		=	$result['msg'];
			return $res;
		}

		$res				=	array(
			'ecode'			=>	9,
			'msg'			=>	''
		);
		return $res;
	}

	/**
	 * @desc  添加企业子账户
	 * @param array $data
	 * $data['uid'] 企业的uid
	 * $data['cdata'] 子账号的信息
	 * $data['ptype'] vip 扣除套餐数量
	 */
	public function addChildInfo($data = array()){
		$res				=	array(
			'ecode'			=>	0,
			'msg'			=>	''
		);

		$tmpRes 			=	$this -> checkChild($data);
		if($tmpRes['ecode'] != 9){
			return $tmpRes;
		}

		//判断支付类型，扣除套餐数量
		if(isset($data['paytype']) && $data['paytype'] == 'vip'){
			require_once ('statis.model.php');        
			$statisM 		=	new statis_model($this->db, $this->def);
			$staisInfo 		=	$statisM -> getInfo($data['uid'], array('usertype' => 2, 'field' => '`sons_num`'));
			if(empty($staisInfo) || $staisInfo['sons_num'] < 1){
				$res		=	array(
					'ecode'	=>	8,
					'msg'	=>	'您的套餐数量已用完'
				);
				return $res;
			}
		}

		$cdata				=	$data['cdata'];

		//密码加密
		$pwdData			=	$this -> generatePwd(array('password' => $cdata['password']));
		$cdata['password']	=	$pwdData['pwd'];
		$cdata['salt']		=	$pwdData['salt'];

		//注册ip date
		$cdata['reg_ip']	=	fun_ip_get();
		$cdata['reg_date']	=	time();

		require_once ('companyaccount.model.php');        
		$comaM 				=	new companyaccount_model($this->db, $this->def);

		//补充其他账号信息
		$cdata['pid']		=	$data['uid'];
		$cdata['usertype']	=	2;
		$cdata['status']	=	1;
		$nid				=	$this -> insert_into('member', $cdata);

		$usernames	=   $this -> select_once('member',array('uid'=>$data['uid']),'`username`');
		$comnames	=   $this -> select_once('company',array('uid'=>$data['uid']),'`name`');
		if(empty($nid)){
			$res			=	array(
				'ecode'		=>	8,
				'msg'		=>	'添加失败'
			);
			return $res;
		}

		// 企业子账号数据添加
		$adata			=	array();
		$adata['uid']	=	$nid;
		$adata['name']	=	$cdata['name'];
		$adata['comid']	=	$data['uid'];
		
		$adata['ctime']	=	time();
		$adata['status']		=	1;
		$adata['lastupdate']	=	time();
		$adata['did']	=	'0';
		$adata['username']	=	$usernames['username'];
		$adata['comname']	=	$comnames['name'];
		$comaM -> createAccount($adata);

		//增加会员日志
		require_once ('log.model.php');
		$LogM = new log_model($this->db, $this->def);
		$LogM -> addMemberLog($data['uid'], 2, '创建子账号:'.$cdata['name'], 27, 1);

		//判断支付类型，扣除套餐数量
		if(isset($data['paytype']) && $data['paytype'] == 'vip'){
			require_once ('statis.model.php');        
			$statisM 		=	new statis_model($this->db, $this->def);
			$staisInfo 		=	$statisM -> getInfo($data['uid'], array('usertype' => 2, 'field' => '`sons_num`'));
			if(!empty($staisInfo) && $staisInfo['sons_num'] > 0){
				$statisM -> upInfo(array('sons_num' => array('-', 1)), array('usertype' => 2, 'uid' => $data['uid']));
			}
		}

		$res				=	array(
			'ecode'			=>	9,
			'msg'			=>	'创建成功'
		);
		return $res;

	}

	/**
	 * @desc  添加企业子账户
	 * @param array $where 条件
	 * @param array $data
	 * $data['uid'] 企业的uid
	 * $data['cdata'] 子账号的信息
	 * 会员名称不让修改，修改会员相关信息的话也就是修改会员的密码
	 */
	public function updChildInfo($where = array(), $data = array()){

		//不修改用户名称
		unset($data['username']);

		//修改会员密码
		if(!empty($data['password'])){
			$passwordA		=   $this -> generatePwd(array('password' => $data['password']));
			$password       =   $passwordA['pwd'];
			$salt           =   $passwordA['salt'];
			
			$this -> update_once('member', array('password' => $password, 'salt' => $salt), array('uid' => $where['uid']));
		}

		//修改子账号信息
		require_once ('companyaccount.model.php');        
		$comaM				=	new companyaccount_model($this->db, $this->def);

		$data['lastupdate']	=	time();
		$comaM -> updInfo($where, $data);

		$res				=	array(
			'ecode'			=>	9,
			'msg'			=>	'修改成功'
		);
		return $res;
	}

	/**
	 * @desc  添加企业账户，账户套餐信息添加
	 * @param int $uid
	 * @param array $data
	 */	
	private function addStatis($uid = null, $data = array()) {
	    
        $uid            =   intval($uid);
	    
	    $id             =   $data['rating'] ? intval($data['rating']) : $this->config['com_rating'];
	    
	    $integral       =   $data['integral'] ? intval($data['integral']) : 0;
	    
	    require_once ('rating.model.php');
	    
	    $ratingM        =   new rating_model($this->db, $this->def);
        
	    // 获取会员等级数据
	    $rInfo          =   $ratingM -> getInfo(array('id' => $id));
	    
        $value          =   array(            
            'uid'           => $uid,
            'rating'        => $id,
            'rating_name'   => $rInfo['name'],
            'rating_type'   => $rInfo['type']
        );
	    if($rInfo['type']  ==  1){
	        
	        $value      =   array_merge($value, array(
                
                'job_num'           =>  $rInfo['job_num'],
                'down_resume'       =>  $rInfo['resume'],
                'breakjob_num'      =>  $rInfo['breakjob_num'],
                'invite_resume'     =>  $rInfo['interview'],
                'part_num'          =>  $rInfo['part_num'],
                'breakpart_num'     =>  $rInfo['breakpart_num'],
                'lt_job_num'        =>  $rInfo['lt_job_num'],
                'lt_down_resume'    =>  $rInfo['lt_resume'],
                'lt_breakjob_num'   =>  $rInfo['lt_breakjob_num'],
                'zph_num'           =>  $rInfo['zph_num'],
				'chat_num'          =>  $rInfo['chat_num'],
                'spview_num'        =>  $rInfo['spview_num'],
                'top_num'        	=>  $rInfo['top_num'],
                'urgent_num'        =>  $rInfo['urgent_num'],
                'rec_num'        	=>  $rInfo['rec_num'],
                'sons_num'        	=>  $rInfo['sons_num'],
                'chat_num'        	=>  $rInfo['chat_num'],
                'spview_num'        =>  $rInfo['spview_num'],
            ));
	    } 
	    
	    if($rInfo['service_time']){
	        $time              =   time() + 86400 * $rInfo['service_time'];
	        $value['vip_etime']=  $time;
	    }else{
	        $value['vip_etime']=  0;
	    }
	    
	    $value['integral']     =   $rInfo['integral_buy'] + $integral;
        $value['vip_stime']     =   time();
        $value['vip_etime']     =  $rInfo['service_time'] ? strtotime('+'.$rInfo['service_time'].' day') : 0;
        
        $comSdata   =   array(
            'rating'        =>  $id,
            'rating_name'   =>  $rInfo['name'],
            'vipstime'      =>  time(),
            'vipetime'      =>  $rInfo['service_time'] ? strtotime('+'.$rInfo['service_time'].' day') : 0
        );
        
        $this->update_once('company', $comSdata, array('uid' => $uid));
        
        /* 待整理归类 */
        if($rInfo['coupon'] > 0){
            
			require_once ('coupon.model.php');
			
            $couponM        =   new coupon_model($this->db, $this->def);
             
            $coupon         =   $couponM -> getInfo(array('id' => intval($rInfo['coupon'])));
            
            $val            =   array(
                
                'uid'           =>  $uid,
                'number'        =>  time(),
                'ctime'         =>  time(),
                'coupon_id'     =>  intval($coupon['id']),
                'coupon_name'   =>  trim($coupon['name']),
                'validity'      =>  time() + $coupon['time'] * 86400,
                'coupon_amount' =>  $coupon['amount'],
                'coupon_scope'  =>  $coupon['scope']
                
            );
             
	        $this -> insert_into('coupon_list',$val);
	    }
	    
        $this -> insert_into('company_statis',$value);
	    
	}
	
	//修改用户信息
    public function upInfo($whereData = array(), $upData = array(), $data = array())
    {

        if (!empty($whereData)) {
            //处理password
            if (isset($upData['password'])) {
                if (!empty($upData['password'])) {
                    $passRes = $this->generatePwd(array('password' => $upData['password']));
                    if (!empty($passRes)) {
                        $upData['password'] = $passRes['pwd'];
                        $upData['salt'] = $passRes['salt'];
                    }
                } else {
                    unset($upData['password']);
                }
            }
            return $this->update_once('member', $upData, $whereData);
        }
    }
	/**
	 * 用户注册检测,修改基本信息检测
	 * @param $data 
	 * @param $uid  修改用户名、手机号、邮箱时才需要传入，添加时的检测不需要传
	 * @param $utype 修改基本信息时，操作的用户类型：user用户 ,admin 管理员
	 */
	public function addMemberCheck($data, $uid = null, $utype = null){
	    
	    $return  =  $oldMem  =  array();
	    
	    if (!empty($uid)){
	        
	        $oldMem  =  $this -> select_once('member',array('uid'=>$uid),'`username`,`moblie`,`email`,`status`,`lock_info`,`address`');
	    }
 
	    if (!empty($data['username'])){
	        
	        if(CheckRegUser($data['username']) == false && CheckRegEmail($data['username']) == false){
	            
	            return array('error'=>'101','msg'=>'用户名包含特殊字符');
			}
			
			if (!empty($this->config['sy_regname'])) {
	                
				$regname = @explode(',', $this->config['sy_regname']);
				
				if (in_array($data['username'], $regname)) {
					
					return array('error'=>'107','msg'=>'该用户名禁止使用！');
				}
			}
	        
	        $reged	=  $this -> select_once('member',array('username'=>trim($data['username'])),'`uid`');
	        
	        if ($reged){
	            
	            if (!empty($uid)){
	                
	                if ($reged['uid'] != $uid){
	                    
	                    return array('error'=>'102','msg'=>'用户名已被使用');
	                    
	                }
	            }else{
	                
	                return array('error'=>'102','msg'=>'用户名已被使用');
	            }
	        }else{
	            $return['username']  =  $data['username'];
	            if (!empty($oldMem)){
	                $return['oldusername']  =  $oldMem['username'];
	            }
	        }
	        
	        /* 会员中心修改用户名添加 */
	        if (isset($data['restname']) && $data['restname'] == '1') {
	            
	            $member    =   $this -> getInfo(array('uid'=> intval($uid)), array('field'=>'restname,password,salt'));
	            
	            if ($member['restname'] == '1') {
	                
	                return array('error'=>'100','msg'=>'您无权限修改用户名！');
	            }

	            $nmsg	=	regUserNameComplex($data['username']);
	            if($nmsg){
	            	return array('error'=>'100','msg'=>$nmsg);
	            }

	            if ($data['password']) {
	                
	                /* md5加密，验证密码传参：salt */
	                
	                $passRes	=	$this -> generatePwd(array('password' => $data['password'], 'salt' => $member['salt']));
	                
	                if(!empty($passRes)){
	                    
	                    $oldpass   =	$passRes['pwd'];
 	                }
  	                
	                if ($member['password'] != $oldpass) {
	                    
	                    return array('error'=>'108','msg'=>'您的密码验证错误，请重试！');
	                }
	            }
	        } 
	    }

        if (!empty($data['companyName'])){
            $reged   =   $this->select_once('company', array('name' => trim($data['companyName'])), '`uid`');

            if ($reged){

                if (!empty($uid)){
                    if ($reged['uid'] != $uid){
                        return array('error'=>'106','msg'=>'企业名称已被使用');
                    }
                }else{
                    return array('error'=>'106','msg'=>'企业名称已被使用');
                }

            }
            $return['companyName']  =  $data['companyName'];
        }
	    if (!empty($data['moblie'])){
	        
	        if(CheckMobile($data['moblie']) == false){
	            
	            return array('error'=>'103','msg'=>'手机号格式错误');
	        }
	        $reged	=  $this -> select_once('member',array('moblie'=>trim($data['moblie']),'username'=>array('=',trim($data['moblie']),'or')),'`uid`');
			
	        if ($reged){
	            
	            if (!empty($uid)){
	                
	                if ($reged['uid'] != $uid){
	                    
	                    return array('error'=>'104','msg'=>'手机号已被使用');
	                    
	                }elseif (!empty($oldMem) && $data['moblie'] != $oldMem['moblie']){//判断现有的和之前是否相同，不同返回可修改的值
	                    
	                    $return['moblie']  =  $data['moblie'];
	                }
	            }else{
	               
	                return array('error'=>'104','msg'=>'手机号已被使用');
	            }
	        }else {
	            
	            $return['moblie']  =  $data['moblie'];
	        }
	    }
	    if (!empty($data['email'])){
	        
	        if (CheckRegEmail($data['email']) == false){
	            
	            return array('error'=>'105','msg'=>'邮箱格式错误');
	        }
	        $reged	=  $this -> select_once('member',array('email'=>trim($data['email']),'username'=>array('=',trim($data['email']),'or')),'`uid`');
	        if ($reged){
	            
	            if (!empty($uid)){
	                
                    if ($reged['uid'] != $uid){
	                    
                        return array('error'=>'106','msg'=>'邮箱已被使用');
                        
                    }elseif (!empty($oldMem) && $data['moblie'] != $oldMem['moblie']){//判断现有的和之前是否相同，不同返回可修改的值
                        
                        $return['email']  =  $data['email'];
                    }
	            }else{
	                
	                return array('error'=>'106','msg'=>'邮箱已被使用');
	            }
	        }else{
	            
	            $return['email']  =  $data['email'];
	        }
	    }
	    //后台修改基本信息时的用户状态
	    if (!empty($data['status'])){
	        
	        if (!empty($oldMem)){
	            //判断现有的和之前是否相同，不同返回可修改的值
	            if ($data['status'] != $oldMem['status']){
	                $return['status']  =  $data['status'];
	            }
	            if (!empty($data['lock_info']) && $data['lock_info'] != $oldMem['lock_info']){
	                $return['lock_info']  =  $data['lock_info'];
	            }
	        }
	    }
	    //后台修改企业基本信息时的地址
	    if (!empty($data['address'])){
	        
	        if (!empty($oldMem) && $data['address'] != $oldMem['address']){
	            $return['address']  =  $data['address'];
	        }
	    }
	    //后台修改基本信息时的密码，此处不需要处理，到本model的upInfo里面处理
	    if (!empty($data['password'])){
	        
	        $return['password']  =  $data['password'];
	    }
	    //
	    if ($utype){
	        
	        $this -> setMemberInfo($uid, $utype, $return, $oldMem);
	    }
	    return $return;
	}
	private function setMemberInfo($uid, $utype, $up, $oldMem)
	{
 
	    $uData  =  array();

	    //如是修改会员基本信息时检查，可以修改的，直接修改
	    if (!empty($uid) && !empty($oldMem)){
	        //会员操作的，如原来是审核未通过，改成未审核
	        if ($utype == 'user'){
	            
	            if($oldMem['status'] == '3'){
	                
	                $up['status']  =  '0';
	            }
	        }
	        
	        $this -> upInfo(array('uid'=>$uid), $up);
	        
	        $newMem  =  $this -> select_once('member',array('uid'=>$uid),'`uid`,`username`,`usertype`,`email`');
	        //锁定会员需要发送邮件通知
	        if (!empty($up['status']) && $up['status'] == 2 && $this->config['sy_email_lock'] == '1'){
	            
	            $emailData  =  array(
	                'email'      =>  $newMem['email'],
	                'uid'        =>  $newMem['uid'],
	                'username'   =>  $newMem['username'],
	                'lock_info'  =>  $up['lock_info'],
	                'type'       =>  'lock'
	            );
	            
	            require_once ('notice.model.php');
	            
	            $noticeM   =  new notice_model($this->db, $this->def);
	            
	            $noticeM -> sendEmailType($emailData);
	        }
	        // 管理员操作的，如改变了用户审核状态，同步修改相关信息
	        if ($utype == 'admin' && !empty($up['status'])){
	            
	             
	            if ($newMem['usertype'] == 1){
	                
	                $this -> update_once('resume',array('status'=>$up['status']),array('uid'=>$uid));
	                
	            }else if ($newMem['usertype'] == 2){
	                
	                $this -> update_once('company',array('r_status' => $up['status']),array('uid'=>$uid));
	                
	            }else if ($newMem['usertype'] == 3){
	                
	                $this -> update_once('lt_job',array('r_status'=>$up['status']),array('uid'=>$uid));
	                
	            }elseif ($newMem['usertype'] == 4){
	                
	                $this -> update_once('px_subject', array('r_status'=>$up['status']), array('uid'=>$uid));
	                $this -> update_once('px_teacher', array('r_status'=>$up['status']), array('uid'=>$uid));
	                $this -> update_once('px_train_news', array('r_status'=>$up['status']), array('uid'=>$uid));
	            }
	        }
	        
	        // 管理员操作，$up['moblie'], $up['email']，同步修改手机、邮箱
	        if ($utype == 'admin') {
	        
	            if (!empty($up['moblie'])) {
	                
                    $this->update_once('resume', array('telphone' => $up['moblie']), array('uid' => $uid));
                    $this->update_once('company', array('linktel' => $up['moblie']), array('uid' => $uid));
                    $this->update_once('lt_info', array('moblie' => $up['moblie']), array('uid' => $uid));
                    $this->update_once('px_train', array('linktel' => $up['moblie']), array('uid' => $uid));
	            }
	            
	            if (!empty($up['email'])) {
	                
                    $this->update_once('resume', array('email' => $up['email']), array('uid' => $uid));
                    $this->update_once('company', array('linkmail' => $up['email']), array('uid' => $uid));
                    $this->update_once('lt_info', array('email' => $up['email']), array('uid' => $uid));
                    $this->update_once('px_train', array('linkmail' => $up['email']), array('uid' => $uid));
                }
	        }
	    }
	}

    /**
     * 根据用户类型，直接查找用户信息
     * @param array $whereData
     * @param array $data
     * @return array|bool|false|string|void
     */
    function getUserInfo($whereData = array(), $data = array('usertype' => null, 'field' => null))
    {

        if (!empty($whereData)) {

            $tblist =   array(1 => 'resume', 2 => 'company', 3 => 'lt_info', 4 => 'px_train', 5 => 'gq_info');
            $table  =   $tblist[$data['usertype']];
            $field  =   $data['field'] ? $data['field'] : '*';
            return $this->select_once($table, $whereData, $field);
        }
    }
	/**
	 * 根据用户类型，直接批量查找用户信息
	 * @param array $whereData
	 * @param array $data
	 */
	function getUserInfoList($whereData = array(),$data = array('usertype'=>null,'field'=>null)){
	    
	    if (!empty($whereData)){
	        
	        $tblist  =  array(1=>'resume',2=>'company',3=>'lt_info',4=>'px_train',5=>'gq_info');
	        
	        $table   =  $tblist[$data['usertype']];
	        
	        $field   =  $data['field'] ? $data['field'] : '*';
	        
	        return $this -> select_all($table,$whereData,$field);
	    }
	}
	/**
	 * 根据用户类型，修改用户信息
	 */
	function  UpdateUserInfo($data=array('usertype'=>null,'post'=>null),$Where=array()){
		
		$tblist  =  array(1=>'resume',2=>'company',3=>'lt_info',4=>'px_train');
	        
	    $table   =  $tblist[$data['usertype']];
	        
		return $this->update_once($table,$data['post'],$Where);
    }
	/**
     * 获取不同类型用户姓名、企业名称、头像
     */
	public function getUserList($whereData) {

		if($whereData){
			$memberList =   $this -> select_all('member',$whereData,'`uid`,`usertype`');
			//按usertype将uid分组

			$type		=	array();
			foreach ($memberList as $k => $v) {
				if($v['usertype']){
					$type[$v['usertype']][]	=	$v['uid'];
				}
			}
			$ResumeList = $ComList = $LtList = $TrainList = $GqList = array();
            if (!empty($type[1])){
                $ResumeList =   $this -> select_all(
                    'resume',
                    array(
                        'uid'=>array('in',pylode(',',$type[1]))
                    ),
                    '`uid`,`name`,`photo`'
                    );
            }
            if (!empty($type[2])){
                $ComList	=   $this -> select_all(
                    'company',
                    array(
                        'uid'=>array('in',pylode(',',$type[2]))
                    ),
                    '`uid`,`name`,`logo`'
                    );
            }
            if (!empty($type['3'])){
                $LtList		=   $this -> select_all(
                    'lt_info',
                    array(
                        'uid'=>array('in',pylode(',',$type[3]))
                    ),
                    '`uid`,`realname` as name,`photo`'
                    );
            }
            if (!empty($type[4])){
                $TrainList	=   $this -> select_all(
                    'px_train',
                    array(
                        'uid'=>array('in',pylode(',',$type[4]))
                    ),
                    '`uid`,`name`,`logo`'
                    );
            }
            if (!empty($type[5])){
                $GqList	=   $this -> select_all(
                    'gq_info',
                    array(
                        'uid'=>array('in',pylode(',',$type[5]))
                    ),
                    '`uid`,`name`,`photo`'
                    );
            }
			foreach($ResumeList as $k=>$v){
				$ResumeList[$k]['pic']	=	checkpic($v['photo'],$this->config['sy_friend_icon']);
				
			}
			foreach($ComList as $k=>$v){
				$ComList[$k]['pic']		=	checkpic($v['logo'],$this->config['sy_friend_icon']);
				
			}
			foreach($LtList as $k=>$v){
				$LtList[$k]['pic']		=	checkpic($v['photo'],$this->config['sy_friend_icon']);
				
			}
			foreach($TrainList as $k=>$v){
				$TrainList[$k]['pic']	=	checkpic($v['logo'],$this->config['sy_friend_icon']);
				
			}
			foreach($GqList as $k=>$v){
				$GqList[$k]['pic']		=	checkpic($v['photo'],$this->config['sy_friend_icon']);
				
			}
			
			$List  =  array_merge($ResumeList,$ComList,$LtList,$TrainList,$GqList);
			return $List;
		}
    }
    /**
     * 根据不同类型用户的搜索条件获取uid集合
     * $whereData[1]:resume表查询条件 
     * $whereData[2]:company表查询条件 
     * $whereData[3]:lt_info表查询条件
     * $whereData[4]:px_train表查询条件  
     */
	public function getUidsByWhere($whereData=array()) {
		
		if($whereData){
			

			if(!empty($whereData[1])){
				$ResumeList	=   $this -> select_all('resume',$whereData[1],'`uid`');
			}

			if(!empty($whereData[2])){
				$ComList	=   $this -> select_all('company',$whereData[2],'`uid`');
			}

			if(!empty($whereData[3])){
				$LtList		=   $this -> select_all('lt_info',$whereData[3],'`uid`');
			}

			if(!empty($whereData[4])){
				$TrainList	=   $this -> select_all('px_train',$whereData[4],'`uid`');
			}

			$List			=	array_merge($ResumeList,$ComList,$LtList,$TrainList);

			$uids			=	array();

			foreach ($List as $k => $v) {
				$uids[]		=	$v['uid'];
			}

			return $uids;
		}
    }
	
	/**
	 * 删除单个身份会员信息
	 * @param string $uid     因有批量删除，故传入的$uid为字符串型 ;如  1 或 1,2,3
	 * @param string $usertype
	 * @param string $delAccount
	 */
	public function delInfo($uid, $usertype, $delAccount = ''){
	    
	    $utname  =  '';
	    $return['layertype']  =	 0;
	    
	    if (!empty($uid)){
	        
	        if(is_array($uid)){
	            
	            $uid  =  pylode(',', $uid);
	            $return['layertype']  =  1;
	        }else if(strpos($uid, ',')){

				$return['layertype']  =  1;
			}

			if($delAccount == '1'){

				$nid	=	$this->delMember($uid);

			}else{
				if ($usertype == 1) {
					
					$utname	=	'个人';
					$nid	=	$this->delUser($uid);
				}else if ($usertype == 2) {
					
					$utname	=	'企业';
					$nid	=	$this->delCom($uid);
				}else if ($usertype == 3) {
					
					$utname	=	'猎头';
					$nid	=	$this->delLt($uid);
				}else if ($usertype == 4) {
					
					$utname	=	'培训';
					$nid	=	$this->delTrain($uid);
				}
			}
	        
	        if ($nid){
				//删除个人企业猎头培训供求，如果删除的是当前身份，就会去除会员类型
				$member	=	$this -> select_all('member',array('uid'=>array('in', $uid),'usertype' => $usertype),'`uid`');
				if(is_array($member) && $member){
					
					foreach($member as $v){
						
						$mids[]	=	$v['uid'];
					}
					$this -> update_once('member',array('usertype'=>0),array('uid'=>array('in',pylode(',',$mids))));
				}
				
	            $return['msg']      =  $utname.'会员(ID:'.$uid.')删除成功';
	            $return['errcode']  =  '9';
	        }else{

	            $return['msg']      =  $utname.'会员(ID:'.$uid.')删除失败';
	            $return['errcode']  =  '8';
	        }
	    }else{

	        $return['msg']      =  '请选择您要删除的会员';
	        $return['errcode']  =  '8';
	    }
	    
	    return $return;
	}
	/**
	 * 锁定用户(账户锁定和相关用户类型审核是否通过没有关系)
	 * @param array $whereData
	 * @param array $data
	 */
	public function lock($whereData = array('uid'=>null,'usertype'=>null),$data = array('post'=>null)){
	    
	    $return    =   array();
	    
	    if (!empty($whereData)){
	        
	        $status     =   intval($data['post']['status']);
	        $lock_info  =   trim($data['post']['lock_info']);
	        
	        if ($status == 2 && $lock_info=='') {
	            
	            $return['msg']      =  '请填写锁定原因';
	            $return['errcode']  =  '8';
	            
	        }else{
	            
				$post    =  $data['post'];
                $uid     =  $whereData['uid'];
                
                $member  =  $this->getInfo(array('uid' => $uid), array('field' => '`uid`,`username`,`email`,`moblie`'));
				
				if($status==1){
				    $sd = '解除锁定';
				    $lock_info = '';
                    // 已注销的账号，不支持解除锁定
				    $logout  =  $this->select_once('member_logout',array('uid'=>$uid,'status'=>1));
				    if (!empty($logout)){
				        
				        $return['msg']      =  '会员(ID:'.$whereData['uid'].')账号已注销，无法解除锁定';
				        $return['errcode']  =  '8';
				        return $return;
				    }
				}else{
				    $sd = '锁定';
				    $lock_info = '。原因：'.$post['lock_info'];
				}
				$nid    =    $this -> upInfo(array('uid' => $uid), $post);
				
				if ($nid){

				    $this -> commonLock($whereData['uid'],array('r_status'=>$status), $post['lock_info']);
    	           
    	            // 锁定子账户
    	            $this -> update_once('member', $post, array('pid' => $uid));

    	            //锁定会员需要发送邮件通知
    	            if ($post['status'] == 2){
    	                
    	                if($this->config['sy_email_lock'] == '1'){
    	                    
    	                    $emailData  =  array(
    	                        'email'      =>  $member['email'],
    	                        'uid'        =>  $member['uid'],
    	                        'username'   =>  $member['username'],
    	                        'lock_info'  =>  $post['lock_info'],
    	                        'type'       =>  'lock'
    	                    );
    	                    
							require_once ('notice.model.php');
    	                    
    	                    $noticeM   =  new notice_model($this->db, $this->def);
    	                    
    	                    $noticeM -> sendEmailType($emailData);
    	                }
						if($this->config['sy_msg_lock'] == '1'){
							$msgData  =  array(
    	                        'moblie'     =>  $member['moblie'],
    	                        'uid'        =>  $member['uid'],
    	                        'username'   =>  $member['username'],
    	                        'lock_info'  =>  $post['lock_info'],
    	                        'type'       =>  'lock'
    	                    );
							require_once ('notice.model.php');
    	                    
    	                    $noticeM   =  new notice_model($this->db, $this->def);
    	                    
    	                    $noticeM -> sendSMSType($msgData);
						}
    	            }
    	            
	            	$comcrm = $this->select_all('company',array('uid' => $uid),'`name`,`r_status`,`crm_uid`');

                    if(!empty($comcrm)){
                    	
                    	require_once 'crm.model.php';
            
           			 	$crmM    =   new crm_model($this->db, $this->def);
           			 	foreach ($comcrm as $k => $v) {
                    		if($v['crm_uid']!='0'){
                    			$wxcontent	=	'您的客户 '.$v['name'].$this->comstatusStr[$v['r_status']];
	                    		$crmM	->	sendCrmWxMsg($v['crm_uid'],array('first'=>$wxcontent,'title'=>'','type'=>9));
							}
	                    }
                    }
    	            
                    $return['msg']      =  '会员'.$sd.'设置成功(ID:'.$whereData['uid'].$lock_info.')';
    	            $return['errcode']  =  '9';
    	            
    	        }else{
    	            $return['msg']      =  '会员'.$sd.'设置失败(ID:'.$whereData['uid'].')';
    	            $return['errcode']  =  '8';
    	        }
	        }
	    }else{
	        $return['msg']      =  '请选择需要锁定的会员';
	        $return['errcode']  =  '8';
	    }
	    return $return;
	}

	private function commonLock($uid, $up, $lock_info = '')
	{
		$where = array('uid' => $uid);
        
        include_once('resume.model.php');
        $resumeM   =   new resume_model($this->db, $this->def);
        
	    $this->update_once('resume', $up, $where);
        $this->update_once('company', $up, $where);
        $this->update_once('lt_info', $up, $where);
        $this->update_once('px_train', $up, $where);

        $expectdata = $up;
        if($up['r_status']!=1){
        	$expectdata['state'] = 3; // 锁定账户 将简历状态改成未通过
        	$expectdata['statusbody'] = $lock_info;
        }
        $resumeM->setExpectState($expectdata,$where);

        $this->update_once('company_job', $up, $where);
        $this->update_once('partjob', $up, $where);
        $this->update_once('school_xjh', $up, $where);
        $this->update_once('lt_job', $up, $where);
        $this->update_once('px_subject', $up, $where);
        $this->update_once('px_teacher', $up, $where);
        $this->update_once('px_train_news', $up, $where);
        $this->update_once('gq_info', $up, $where);
        $this->update_once('gq_task', $up, $where);
	}

    /**
     * 会员审核(会员审核，被锁定的账号，无法修改审核状态)
     * @param array $whereData 参数格式 uid=>array('in', '1,2,3'); uid=>1
     * @param array $data
     * @return mixed
     */
	public function status($whereData = array('uid'=>null,'usertype'=>null), $data = array('post'=>null))
    {
        if (!empty($whereData)) {
            
            $post      =  $data['post'];
            $usertype  =  intval($whereData['usertype']);

            $up     =   array('r_status' => $data['post']['status']);
            $where  =   array(
                'uid'       =>  $whereData['uid'],
                'r_status'  =>  array('<>', 2)
            );
            // 处理审核提示和管理员日志需要的内容
            if ($up['r_status'] == 4){
                $msg = '暂停';
            }elseif ($up['r_status'] == 3){
                $msg = '审核未通过';
            }elseif ($up['r_status'] == 0){
                $msg = '未审核';
            }elseif ($up['r_status'] == 1){
                $msg = '审核通过';
            }
            $lock_info = !empty($post['lock_info']) ? '。原因：'.$post['lock_info'] : '';
            // 保存审核信息
            if (isset($post['lock_info'])){
                $this->update_once('member',array('lock_info'=>$post['lock_info']),array('uid'=>$whereData['uid']));
            }
            $isSendMsg = true;
            /**
             * @desc 身份信息非审核状态，相关表（简历、职位、课程等）数据设置未审核
             */
            if ($usertype == 1) {
                
                $identity = '个人';
                $nid  =  $this->update_once('resume', $up, $where);

                include_once('resume.model.php');
                $resumeM   =   new resume_model($this->db, $this->def);

                $expectdata = $up;
		        if($up['r_status']!=1){
		        	$expectdata['state'] = 0;
		        }

                $resumeM->setExpectState($expectdata,$where);
                
            } else if ($usertype == 2) {
                $where['r_status'] = array();
                $where['r_status'][] = array('<>', 2);
                
                $comup = $up;
                if($data['post']['status']==4){
                    $comup['zt_time'] = time();
                }else if($post['setup']!='1'){
            		$where['r_status'][] = array('<>', 4);
                }
                if ($comup['r_status'] == 1){
                    // 企业审核通过，同步把logo审核状态设为通过
                    $comup['logo_status'] = 0;
                }
                if($post['setup']=='1'){
                	$isSendMsg = false;
                }

                $identity = '企业';
                $nid  =  $this->update_once('company', $comup, $where);
                $this->update_once('partjob', $up, $where);
                $this->update_once('company_job', $up, $where);
                $this->update_once('school_xjh', $up, $where);
                $this->update_once('lt_job', $up, array( 'uid' => $whereData['uid'], 'usertype' => 2));
                
                $comcrm = $this->select_all('company',$where,'`name`,`r_status`,`crm_uid`');
                
                if(is_array($comcrm)){
                    
                    require_once 'crm.model.php';
                    
                    $crmM    =   new crm_model($this->db, $this->def);
                    foreach ($comcrm as $k => $v) {
                        if($v['crm_uid']!='0'){
                            $wxcontent	=	'您的客户 '.$v['name'].$this->comstatusStr[$v['r_status']];
                            $crmM	->	sendCrmWxMsg($v['crm_uid'],array('first'=>$wxcontent,'title'=>'','type'=>9));
                        }
                    }
                }
            } else if ($usertype == 3) {
                
                $identity = '猎头';
                $nid  =  $this->update_once('lt_info', $up, $where);
                $this->update_once('lt_job', $up, array('uid' => $whereData['uid'], 'usertype' => 3 ));
                
            } else if ($usertype == 4) {
                
                $identity = '培训';
                $nid  =  $this->update_once('px_train', $up, $where);
                $this->update_once('px_teacher', $up, $where);
                $this->update_once('px_subject', $up, $where);
                $this->update_once('px_train_news', $up, $where);
            }
            
            if ($nid) {
                if($isSendMsg){
	                // 会员审核发送通知
	                $stData =   array(
	                    'status'    =>  $post['status'],
	                    'statusbody'=>  $post['lock_info'],
	                    'usertype'  =>  $usertype
	                );
	            }
                $this->sendStatus($whereData['uid'], $stData);
                //$this->update_once('member',array('status'=>$post['status']),array('uid'=>$whereData['uid']));
                $return['msg'] = $identity.'会员'.$msg.'设置成功(ID:' . $whereData['uid']['1'].$lock_info. ')';
                
                $return['errcode'] = '9';
            } else {
                $return['msg'] = $identity.'会员'.$msg.'设置失败(ID:' . $whereData['uid']['1'] . ')';
                $return['errcode'] = '8';
            }
        } else {
            $return['msg'] = '系统繁忙';
            $return['errcode'] = '8';
        }
        return $return;
    }
	/**
	 * 会员审核发送通知
	 * @param $uid   参数格式：uid = array('in', '1,2,3'); uid = 1;
	 * @param array $post
	 */
	private function sendStatus($uid,$post=array()){
        //审核通过和审核未通过才提醒，并且要先判断审核提醒是否开启通知    
        
	    $msgtx    =  $this -> config['sy_msg_userstatus'];
	    $emailtx  =  $this -> config['sy_email_userstatus'];
	    
	    if ($post['status'] == 1 || $post['status'] == 3){
	        
	        $members = $this -> getList(array('uid'=>$uid,'status'=>1),array('field'=>'uid,username,email,moblie'));
	         
	        if ($members){
	            
	            $date        =  date('Y-m-d H:i:s');
	            $statusInfo  =  '';
	            //处理审核信息
	            if($post['status'] == 1){
	                
	                $statusInfo  =  '审核通过！';
	                
	            }elseif($post['status'] == 3){
	                
	                $statusInfo  =  '审核未通过，';
	                
	                if($post['statusbody']){
	                    
	                    $statusInfo  .=  '原因：'.$post['statusbody'];
	                    
	                }
	            }
	            
	            if ($msgtx == '1' || $emailtx == '1'){
    	            $tplData  =  array(
    	                'auto_statis'  	=>  $statusInfo,
    	                'date'         	=>  $date,
    	                'type'         	=>  'userstatus'
    	            );
    				
    	            //因发送内容相同，可以先提取发送内容，然后再批量发送，可以减少循环查询次数
    	            require_once('notice.model.php');
    	            
    	            $noticeM   =   new notice_model($this->db, $this->def);
    	            //获取短息通知内容
    	            $msgTpl    =   $noticeM -> getTpl($tplData,'msg');
    	            //获取邮件通知内容
    	            $emailTpl  =   $noticeM -> getTpl($tplData,'email');
	            }
	            
	            $uids          =   array();
	            
	            foreach ($members as $k=>$v){
	                
	                $uids[]  =  $v['uid'];
	                //批量发送短信
	                if ($v['moblie'] && $msgtx == '1'){
	                    
	                    $mdata	=	array(
	                        'uid'		=>	$v['uid'],
	                        'cuid'		=>	0,
	                        'moblie'	=>	$v['moblie'],
	                        'type'		=>	'userstatus',
							'port'		=>	'5'							
	                    );
	                    $noticeM -> sendSMSType($mdata,$msgTpl['content']);
	                }
	                //批量发送邮件
	                if ($v['email'] && $emailtx == '1'){
	                    
	                    $edata  =  array(
	                        'uid'      =>  $v['uid'],
	                        'cuid'     =>  0,
	                        'email'    =>  $v['email'],
	                        'type'     =>  'userstatus'
	                    );
	                    $noticeM -> sendEmailType($edata,$emailTpl);
	                }
	            }
	            //发送系统通知
	            include_once('sysmsg.model.php');
	            
	            $sysmsgM    =   new sysmsg_model($this->db, $this->def);
	            
				$statusInfo	=	'您的账号'.$statusInfo;
	            $sysmsgM    ->  addInfo(array('uid'=>$uids,'content'=>$statusInfo,'usertype' => $post['usertype']));
	        }
	    }
	}
	//后台个人会员列表处理数据
	private function getDataList($List){
	    
	    foreach($List as $v){
	        if($v['uid']){
	        	if($v['usertype']=='1'){
	        		$useruids[]   =   $v['uid'];
	        	}
	        	if($v['usertype']=='2'){
	        		if($v['pid']){
	        			$comuids[]   =   $v['pid'];
	        		}else{
	        			$comuids[]   =   $v['uid'];
	        		}
	        		
	        	}
	        	if($v['usertype']=='3'){
	        		$ltuids[]   =   $v['uid'];
	        	}
	        	if($v['usertype']=='4'){
	        		$pxuids[]   =   $v['uid'];
	        	}
	        }

	    }
	    
	    
	    $countname = array();
	    if(!empty($useruids)){
	    	$resumes   =   $this -> select_all('resume',array('uid'=>array('in',pylode(',', $useruids))),'`uid`,`name`,`def_job`');
	    	foreach($resumes as $rk=>$rv){
	    		$countname[$rv['uid']] = $rv['name'];
	    	}
	    }
	    if(!empty($comuids)){
	    	$coms      =   $this -> select_all('company',array('uid'=>array('in',pylode(',', $comuids))),'`uid`,`name`');
	    	foreach($coms as $ck=>$cv){

	    		$countname[$cv['uid']] = $cv['name'];
	    	}
	    }

	    if(!empty($ltuids)){
	    	$lts       =   $this -> select_all('lt_info',array('uid'=>array('in',pylode(',', $ltuids))),'`uid`,`com_name`');
	    	
	    	foreach($lts as $lk=>$lv){
	    		$countname[$lv['uid']] = $lv['com_name'];
	    	}
	    }
	    if(!empty($pxuids)){
	    	$pxs       =   $this -> select_all('px_train',array('uid'=>array('in',pylode(',', $pxuids))),'`uid`,`name`');
	    	foreach($pxs as $pk=>$pv){
	    		$countname[$pv['uid']] = $pv['name'];
	    	}
	    }

	    foreach($List as $k=>$v){
	        if(!empty($resumes)){
	        	foreach($resumes as $val){
		            
		            if($val['uid']==$v['uid']){
		                
		                $List[$k]['name']	  =	 $val['name'];
		                $List[$k]['def_job']  =	 $val['def_job'];
		            }
		        }
	        }
	        if(!empty($countname)){
	        	if($v['usertype']==2 && $v['pid']){
	        		$uid = $v['pid'];
	        	}else{
	        		$uid = $v['uid'];
	        	}
	        	$List[$k]['countname'] = $countname[$uid];
	        }
	        
	    }

	    return $List;
	}
	/**
	 * @desc 生成password（包括原密码验证）
	 * 
	 * @param array $pwdData (password:明密  salt：加密随机字符)
	 * 
	 */
	public function generatePwd($pwdData){
		
	    $pwdRes	=	array();
		
		if(empty($pwdData['password'])){
		
		    return $pwdRes;
		    
		}
		
		if (empty($pwdData['salt'])) {
		    
		    $salt =   substr(uniqid(rand()), -6);
		    
		}else{
		    
		    $salt =   $pwdData['salt'];
		    
		}
		
		$pass = passCheck($pwdData['password'],$salt);
		
		$pwdRes['pwd']	=	$pass;
		
		$pwdRes['salt']	=	$salt;
		
		return $pwdRes;
	}
	/**
	 * 删除个人会员
	 */
	private function delUser($uid){
	    
	    if (!empty($uid)){

			
			
			$return	=	$this -> delete_all('resume',array('uid'=>array('in',$uid)),'');
			
	        if ($return){
				
	            $this -> delete_all('answer',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('answer_review',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('atn',array('uid'=>array('in',$uid),'sc_uid'=>array('in',$uid,'OR')),'');
	            
	            $this -> delete_all('attention',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('blacklist',array('p_uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('change',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_cs_log',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_cs_pick',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_friend',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_friend',array('fid'=>array('in',$uid),'fusertype'=>1),'');
	            
	            $this -> delete_all('chat_log',array('from'=>array('in',$uid),'fusertype'=>1),'');
	            
	            $this -> delete_all('chat_log',array('to'=>array('in',$uid),'tusertype'=>1),'');
	            
	            $this -> delete_all('chat_member',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_right',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_rewardlist',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_rewardlog',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_sharelog',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_msg',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_order',array('uid'=>array('in',$uid),'usertype'=>1), '');
	            
	            $this -> delete_all('company_pay',array('com_id'=>array('in',$uid),'usertype'=>1),'');
				
	            $this -> delete_all('concheck_log',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('coupon_list',array('uid'=>array('in',$uid)),'');
				
	            $this -> delete_all('down_resume',array('uid'=>array('in',$uid)),'');
				
	            $this -> delete_all('evaluate_log',array('uid'=>array('in',$uid)),'');
				
	            $this -> delete_all('fav_job',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('job_tellog', array('uid' => array('in',$uid)), '');
	            
				$this -> delete_all('login_log',array('uid'=>array('in',$uid),'usertype'=>1),'');
				
	            $this -> delete_all('look_job',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('look_resume',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('member_log',array('uid'=>array('in',$uid),'usertype'=>1),'');
				
	            $this -> delete_all('member_statis',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('msg',array('uid'=>array('in',$uid)));
	            
	            $this -> delete_all('part_apply',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('part_collect',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('px_subject_collect',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('px_zixun',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('question',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('rebates',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('report',array('p_uid'=>array('in',$uid),'c_uid'=>array('in',$uid,'OR')),'');
				
	            $this -> delete_all('resume_expect',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_city_job_class',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_cityclass',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_doc',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_edu',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_jobclass',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_other',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_project',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_show',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_skill',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_trainging',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('resume_work',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('spview_log',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('spview_subscribe',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('spview_subscribe_msg',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('subscribe',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('subscriberecord',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('talent_pool',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('user_entrust',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('user_entrust_record',array('uid'=>array('in',$uid)),'');

	            $this -> delete_all('user_resume',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('userid_job',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('userid_msg',array('uid'=>array('in',$uid)),'');
	            
				$this -> delete_all('xjhlive_black',array('uid'=>array('in',$uid),'usertype'=>1),'');
				
				$this -> delete_all('xjhlive_chat',array('fuid'=>array('in',$uid),'fusertype'=>1),'');
				
				$this -> delete_all('xjhlive_yy',array('uid'=>array('in',$uid)),'');
				
				$this -> delete_all('xjhlive_yy_msg',array('uid'=>array('in',$uid)),'');
				
				$this -> delete_all('zphnet_look',array('uid'=>array('in',$uid),'usertype'=>1),'');
				
				$this -> delete_all('zphnet_user',array('uid'=>array('in',$uid),'usertype'=>1),'');
	        }

	        return $return;
	    }
	}
	
	/**
	 * 删除企业会员
	 */
	private function delCom($uid){
	    if (!empty($uid)){
			
	        $return    =  $this -> delete_all('company',array('uid'=>array('in',$uid)), '');

	        if ($return){
	            
	            $this -> delete_all('answer',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('answer_review',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('ad_order',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('atn',array('uid'=>array('in',$uid),'sc_uid'=>array('in',$uid,'OR')), '');
	            
	            $this -> delete_all('attention',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('banner',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('blacklist',array('c_uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('change',array('uid'=>array('in',$uid),'usertype'=>2),'');
	            
	            $this -> delete_all('chat_cs_log',array('uid'=>array('in',$uid),'usertype'=>2),'');
	            
	            $this -> delete_all('chat_cs_pick',array('uid'=>array('in',$uid),'usertype'=>2),'');
	            
	            $this -> delete_all('chat_friend',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('chat_friend',array('fid'=>array('in',$uid),'fusertype'=>2), '');
	            
	            $this -> delete_all('chat_log',array('from'=>array('in',$uid),'fusertype'=>2), '');
	            
	            $this -> delete_all('chat_log',array('to'=>array('in',$uid),'tusertype'=>2), '');
	            
	            $this -> delete_all('chat_member',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('chat_right',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_account',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_job',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_job_link',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_job_reward',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_rewardlist',array('comid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_rewardlog',array('comid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_share',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_job_sharelog',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_job_sharelog',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_cert',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('company_news',array('uid'=>array('in',$uid)), '');

	            $this -> delete_all('company_order',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('company_pay',array('com_id'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('company_product',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_show',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_statis',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_msg',array('cuid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('concheck_log',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
				$this -> delete_all('coupon_list',array('uid'=>array('in',$uid)), '');
				
	            $this -> delete_all('down_resume',array('comid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('email_msg',array('uid'=>array('in',$uid),'cuid'=>array('in',$uid,'OR')), '');
	            
				$this -> delete_all('evaluate_log',array('uid'=>array('in',$uid)), '');
				
	            $this -> delete_all('fav_job',array('com_id'=>array('in',$uid)), '');
	            
	            $this -> delete_all('friend_help',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('friend_help_log',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('hotjob',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('invoice_record',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('job_tellog', array('comid' => array('in',$uid)), '');
	            
				$this -> delete_all('login_log',array('uid'=>array('in',$uid),'usertype'=>2), '');
				
	            $this -> delete_all('look_job',array('com_id'=>array('in',$uid)), '');
	            
	            $this -> delete_all('look_resume',array('com_id'=>array('in',$uid),'usertype'=>2), '');
	            
				$this -> delete_all('lt_job',array('uid'=>array('in',$uid)), '');
				
	            $this -> delete_all('member_log',array('uid'=>array('in',$uid),'usertype'=>2), '');
				
	            $this -> delete_all('msg',array('job_uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('partjob',array('uid'=>array('in',$uid)), '');

	            $this -> delete_all('part_apply',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('part_collect',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('px_subject_collect',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('px_zixun',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('question',array('uid'=>array('in',$uid)), '');
	             
	            $this -> delete_all('rebates',array('job_uid'=>array('in',$uid),'uid'=>array('in',$uid,'OR')), '');

	            $this -> delete_all('report',array('p_uid'=>array('in',$uid),'c_uid'=>array('in',$uid,'OR')), '');
	            
	            $this -> delete_all('school_xjh',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('special_com',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('spview',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('spview_log',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('spview_subscribe',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('spview_subscribe_msg',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('subscribe',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('subscriberecord',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('talent_pool',array('cuid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('user_entrust_record',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('userid_job',array('com_id'=>array('in',$uid)), '');
	            
	            $this -> delete_all('userid_msg',array('fid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('zhaopinhui_com',array('uid'=>array('in',$uid)), '');

	            $this -> delete_all('zphnet_com',array('uid'=>array('in',$uid)), '');

	            $this -> delete_all('zphnet_look',array('uid'=>array('in',$uid), 'usertype'=>2), '');
	            
	            $this -> delete_all('zphnet_user',array('uid'=>array('in',$uid), 'usertype'=>2), '');
	            
	            $this -> delete_all('crmnew_concern',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('crm_comlog',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('crm_out',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('crm_work_plan',array('comid'=>array('in',$uid)), '');

	            $this -> delete_all('xjhlive_black',array('uid'=>array('in',$uid),'usertype'=>2), '');
	            
	            $this -> delete_all('xjhlive_chat',array('fuid'=>array('in',$uid),'fusertype'=>2), '');
	            
	            $this -> delete_all('xjhlive_com',array('uid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('yqmb',array('uid'=>array('in',$uid)), '');
	            
	        }
	        return $return;
	    }
	}
	/**
	 * 删除猎头会员
	 */
	private function delLt($uid){
	    
	    if (!empty($uid)){

			
	        $return    =  $this -> delete_all('lt_info',array('uid'=>array('in',$uid)), '');
	        
	        if ($return){
	            
	            $this -> delete_all('answer', array('uid' => array('in', $uid),'usertype'=>3), '');
	            
	            $this -> delete_all('answer_review', array('uid' => array('in', $uid),'usertype'=>3), '');
	            
	            $this -> delete_all('atn',array('uid'=>array('in',$uid),'sc_uid'=>array('in',$uid,'OR')), '');
	            
	            $this -> delete_all('attention', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('change',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_cs_log',array('uid'=>array('in',$uid),'usertype'=>3),'');
	            
	            $this -> delete_all('chat_cs_pick',array('uid'=>array('in',$uid),'usertype'=>3),'');
	            
	            $this -> delete_all('chat_friend',array('uid'=>array('in',$uid),'usertype'=>3), '');
	            
	            $this -> delete_all('chat_friend',array('fid'=>array('in',$uid),'fusertype'=>3), '');
	            
	            $this -> delete_all('chat_log',array('from'=>array('in',$uid),'fusertype'=>3), '');
	            
	            $this -> delete_all('chat_log',array('to'=>array('in',$uid),'tusertype'=>3), '');
	            
	            $this -> delete_all('chat_member',array('uid'=>array('in',$uid),'usertype'=>3), '');
	            
	            $this -> delete_all('chat_right',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_cert', array('uid' => array('in', $uid),'usertype'=>3), '');
	            
	            $this -> delete_all('company_job_reward',array('uid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_rewardlist',array('comid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_rewardlog',array('comid'=>array('in',$uid)),'');
	            
	            $this -> delete_all('company_job_share',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_job_sharelog',array('comid'=>array('in',$uid)), '');
	            
	            $this -> delete_all('company_order', array('uid' => array('in', $uid),'usertype'=>3), '');
	            
	            $this -> delete_all('company_pay', array('com_id' => array('in', $uid),'usertype'=>3), '');
	            
				$this -> delete_all('coupon_list',array('uid'=>array('in',$uid)), '');
				
	            $this -> delete_all('down_resume', array('comid' => array('in', $uid),'usertype'=>3), '');
	            
	            $this -> delete_all('email_msg',array('uid'=>array('in',$uid),'cuid'=>array('in',$uid,'OR')), '');
	            
				$this -> delete_all('evaluate_log',array('uid'=>array('in',$uid)), '');
				
	            $this -> delete_all('fav_job',array('uid'=>array('in',$uid),'com_uid'=>array('in',$uid,'OR')), '');
				
				$this -> delete_all('login_log', array('uid' => array('in', $uid),'usertype'=>3), '');
				
	            $this -> delete_all('lt_job', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('lt_statis', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('member_log',array('uid'=>array('in',$uid),'usertype'=>3), '');
				
	            $this -> delete_all('msg', array('job_uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_subject_collect', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_zixun', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('question', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('rebates',array('uid'=>array('in',$uid),'job_uid'=>array('in',$uid,'OR')), '');
	            
	            $this -> delete_all('xjhlive_black',array('uid'=>array('in',$uid),'usertype'=>3), '');
	            
	            $this -> delete_all('xjhlive_chat',array('fuid'=>array('in',$uid),'fusertype'=>3), '');
	            
	            $this -> delete_all('userid_job', array('comid' => array('in', $uid),'type'=>3), '');
				
	        }
	        return $return;
	    }
	}
	/**
	 * 删除培训会员
	 */
	private function delTrain($uid){
	    
	    if (!empty($uid)){

			
	        $return    =  $this -> delete_all('px_train',array('uid'=>array('in',$uid)), '');
	        
	        if ($return){
	            
	            $this -> delete_all('answer', array('uid' => array('in', $uid),'usertype'=>4), '');
	            
	            $this -> delete_all('answer_review', array('uid' => array('in', $uid),'usertype'=>4), '');
	            
	            $this -> delete_all('atn',array('uid'=>array('in',$uid),'sc_uid'=>array('in',$uid,'OR')), '');
	            
	            $this -> delete_all('attention', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('change',array('uid'=>array('in',$uid),'usertype'=>1),'');
	            
	            $this -> delete_all('chat_cs_log',array('uid'=>array('in',$uid),'usertype'=>4),'');
	            
	            $this -> delete_all('chat_cs_pick',array('uid'=>array('in',$uid),'usertype'=>4),'');
	            
	            $this -> delete_all('company_cert', array('uid' => array('in', $uid),'usertype'=>4), '');
	            
	            $this -> delete_all('company_order', array('uid' => array('in', $uid), 'usertype' => 4), '');
	            
	            $this -> delete_all('company_pay', array('com_id' => array('in', $uid),'usertype'=>4), '');
	            
	            $this -> delete_all('email_msg',array('uid'=>array('in',$uid),'cuid'=>array('in',$uid,'OR')), '');
				
				$this -> delete_all('evaluate_log',array('uid'=>array('in',$uid)), '');
				
				$this -> delete_all('login_log', array('uid' => array('in', $uid),'usertype'=>4), '');
				
	            $this -> delete_all('member_log',array('uid'=>array('in',$uid),'usertype'=>4), '');
				
	            $this -> delete_all('msg', array('job_uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_banner', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_baoming', array('s_uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_subject', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_subject_collect', array('s_uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_teacher', array('uid' => array('in', $uid)), '');
				
	            $this -> delete_all('px_train_news', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_train_show', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_train_statis', array('uid' => array('in', $uid)), '');
	            
	            $this -> delete_all('px_zixun', array('s_uid' => array('in', $uid)), '');
				
	        }
	        return $return;
	    }
	}

	function delgq($uid){

		if (!empty($uid)){

			
	        
	        $return    =  $this -> delete_all('gq_info',array('uid'=>array('in',$uid)), '');
	        
	        if ($return){
	            
				$this -> delete_all('company_order', array('uid' => array('in', $uid), 'usertype' => 5), '');
				
				$this -> delete_all('evaluate_log',array('uid'=>array('in',$uid)), '');
				
	            $this -> delete_all('gq_task', array('uid' => array('in', $uid)), '');
				
				$this -> delete_all('gq_browse', array('uid' => array('in', $uid)), '');
				
				$this -> delete_all('login_log', array('uid' => array('in', $uid),'usertype'=>5), ''); 
				
				$this -> delete_all('member_log',array('uid'=>array('in',$uid),'usertype'=>5), '');

	        }
		}
		return $return;
	}
	/**
	 * @desc 修改用户名
	 * @param array $data
	 */
	function saveUserName($data = array()) {
        
        $value      =   array('username' => trim($data['username']));
        
        if (isset($data['restname']) && $data['restname'] == '1') {
            $value['password']      =  $data['password'];
            $value['restname']      =  $data['restname'];
        }
	    
        $uid        =   intval($data['uid']);
        
        $result     =   $this -> addMemberCheck($value, $uid);
		
        if ($result['username']) {
            
            if ($data['restname']=='1' || $data['admin'] == '1') {
                
                unset($value['password']);    
                
                require_once ('log.model.php');
                $LogM = new log_model($this->db, $this->def);
                $LogM -> addMemberLog($data['uid'], $data['usertype'], '修改用户名，原用户名：' . $result['oldusername'], 11);
				
				$this -> update_once('member', $value,  array('uid' => $uid));
                
				$return['errcode'] = '1';
            }else{
                
				$return['msg'] = '修改次数已用完！';
			}
            
        }else{
            
            if ($data['admin'] == '1') {
                
                return $result;
            }else{
                
		        $return['msg'] = $result['msg']?$result['msg']:'修改失败！';
            }
		}
        
        return $return;
	    
	}
	
	/**
	 * @desc 修改密码
	 * @param array $data
	 */
	function savePassword($data = array()) {
	   
	    if (!empty($data)) {
	        
	        $return        =   array();
	        
	        $uid           =   intval($data['uid']);
	        $pass          =   trim($data['password']);
	        $oldpass       =   trim($data['oldpassword']);
	        $repass        =   trim($data['repassword']);
	        
	        $info          =   $this -> getInfo(array('uid'=> $uid), array('field'=>'salt,password'));
	        
	        if($info && is_array($info)){
	            
	            //$pwdA      =   $this->generatePwd(array('password'=>$oldpass,'salt'=>$info['salt']));
	            
	            //$old       =   $pwdA['pwd'];

	            $pwmsg 	   =   regPassWordComplex($pass);

	            if (!passCheck($oldpass,$info['salt'],$info['password'])) {
	                
	                $return['errcode']     =   8;
	                
	                $return['msg']         =   '原始密码错误，请重试！';
	                
	            }elseif ($pass != $repass) {
	                
	                $return['errcode']     =   8;
	                
	                $return['msg']         =   '确认密码与新密码不一致，请重试！';
	                
	            }elseif($pwmsg!=''){

	            	$return['errcode']     =   8;
	                
	                $return['msg']         =   $pwmsg;
	                
	            }else{
	                
    	            $passwordA                 =   $this -> generatePwd(array('password'=>$pass));
    	            $password                  =   $passwordA['pwd'];
    	            $salt                      =   $passwordA['salt'];
    	            
    	            $return['id']              =   $this -> update_once('member',array('password'=>$password, 'salt'=>$salt), array('uid'=>intval($data['uid'])));
    	            
    	            require_once ('log.model.php');
    	            $LogM = new log_model($this->db, $this->def);
    	            $LogM->addMemberLog($data['uid'], $data['usertype'], '修改密码', 8,2);
    	            
    	            $return['errcode']         =   9 ;
    	            
    	            $return['msg']             =   '密码修改成功，请重新登录！';
    	            
	            }
	        }
	        
	        return $return;
	        
	    }
	    
	}
	 
	/**
	 * 获取member_reg信息
	 * 通用的whereData条件
	 */ 
	function getMemberregInfo($whereData,$data=array()){
		
		$field	=	empty($data['field']) ? '*' : $data['field'];
		
		$List 	=	$this -> select_once('member_reg', $whereData, $field);
		
		return $List;
		
	}
	/**
	 * 获取member_reg信息
	 * 通用的data数组
	 */ 
	function addMemberreg($data=array()){
		
		$nid	=	$this -> insert_into('member_reg', $data);
		
		return $nid;
		
	}
	/**
	 * 上传个人头像
	 */
	public function upLogo($id,$data=array()){
		
		if($id && !empty($data)){
			
			require_once ('integral.model.php');
			
			$IntegralM 	= 	new integral_model($this -> db, $this -> def);
			
			$IntegralM	->	invtalCheck($id,1,'integral_avatar','上传头像',20);
		
			
			if($data['wap']){
				
				$photo			=	'./data/upload/user/'.date('Ymd').'/'.$data['pic'];
				
			}else{
				
				$photo			=	str_replace('../data/upload/user/','./data/upload/user/',$data[1]);
			
			}
			
			if($this -> config['user_photo_status'] == 1){
				
			    $photo_status	=	'1';
				
				$return['msg']='3';
			
			}else{
				$photo_status	=	'0';
			    
			    $return ['msg']	=	'1';
			}

			//5.0图片上传后就显示，后台审核不通过直接删除
			$this -> update_once('resume',array('photo'=>$photo,'photo_status'=>$photo_status),array('uid'=>$id));

			$this -> update_once('resume_expect',array('photo'=>$photo),array('uid'=>$id));
				
			$this -> update_once('answer',array('pic'=>$photo),array('uid'=>$id));
			
			$this -> update_once('question',array('pic'=>$photo),array('uid'=>$id));
			
			return $return;
		
		}
		
	}
	/**
	 * 个人身份认证
	 */
	public function upidcardInfo($whereData = array(),$data = array()){
		
		if(!empty($whereData)){
			
			require_once ('resume.model.php');
			$ResumeM	=	new resume_model($this -> db, $this -> def);
			$resume		=	$ResumeM -> getResumeInfo(array('uid'=>$whereData['uid']));
			
			if($resume['r_status']==2){
				$status	=	0;
			}else{
				$status	=	$this->config['user_idcard_status'] == '1' ? '0' : '1';
			}
			
			$data['name']	=	$data['name']?$data['name']:$resume['name'];
			
			$PostData	=	array(
				'name'			=>	$data['name'],
				'idcard'		=>	$data['idcard'],
				'idcard_status'	=>	$status,
				'cert_time'		=>	time()
			);

			//图片路径处理
			if ($data['file']['tmp_name'] || $data['preview']){
                
                $upArr                  =                array(
					'file'              =>               $data['file'],
					'dir'               =>              'cert',
					'base'              =>               $data['preview'],
				);

                $result                 =               $this -> upload($upArr);
                
                if (!empty($result['msg'])){
                    
                    $return['msg']      =               $result['msg'];

                    $return['errcode']  =               '8';
                    
                    return $return;
                    
                }elseif (!empty($result['picurl'])){
                    
                    $picurl          =               $result['picurl'];
                        
                }
            }elseif($data['idcard_pic']){
				$picurl		=	$data['idcard_pic'];
			}
	        if (isset($picurl)){
	            $PostData['idcard_pic']        =  $picurl;
	        }

			$id		=	$this -> update_once('resume',$PostData,array('uid'=>$whereData['uid']));
			
			$this -> update_once('resume_expect',array('idcard_status' => $status, 'uname' => trim($data['name'])),array('uid'=>$whereData['uid']));
			
			if($id){
				
				if ((!is_array($resume) || $resume['idcard_pic']=='') && $this->config['user_idcard_status']!=1){
					
					$com	=	$this->select_once('company_pay',array('com_id'=>$whereData['uid'],'pay_remark'=>'上传身份验证'));
					
					if(empty($com)){
						require_once ('integral.model.php');
						$IntegralM	=	new integral_model($this->db, $this->def);
						$IntegralM->invtalCheck($whereData['uid'],$data['usertype'],'integral_identity','上传身份验证',21);
					}
				}
				require_once ('log.model.php');
				$LogM = new log_model($this->db, $this->def);
				$LogM -> addMemberLog($whereData['uid'],$data['usertype'],'上传身份验证图片',13,1);

				if ($this -> config['user_idcard_status'] == '1'){
                        
					$return['errcode']  =  '9';
					
					$return['msg']      =  '上传成功，请等待审核';

					require_once('admin.model.php');
					$adminM = new admin_model($this->db,$this->def);
					$adminM->sendAdminMsg(array('first'=>'个人用户《'.$data['name'].'》上传了新的身份认证，请查看审核。','type'=>8));
				}else{
					
					$return['errcode']  =  '9';
					$return['msg']      =  '上传成功';
				}
			}else{
				
				$return['msg']		=	'上传失败！';
				$return['errcode']	=	8;
			}
			return $return;
		}
	}
	 	/**
	 * 处理单个图片上传
	 * @param file/需上传文件; dir/上传目录; type/上传图片类型; base/需上传base64; preview/pc预览即上传
	 */
	private function upload($data = array('file'=>null,'dir'=>null,'type'=>null,'base'=>null,'preview'=>null)){
	    
	    include_once('upload.model.php');
	    
	    $UploadM                =               new upload_model($this->db, $this->def);
	    
	    $upArr                  =               array(

            'file'              =>              $data['file'],
            
            'dir'               =>              $data['dir'],
            
            'type'              =>              $data['type'],
            
            'base'              =>              $data['base'],
            
            'preview'           =>              $data['preview']
            
        );
        
	    $return                 =               $UploadM -> newUpload($upArr);
	    
        return $return;
        
    }

    /**
     * 登录
     * @param array $data   $data['uid'] $data['usertype']
     * @return array|int[]|string[]
     */
	public function userLogin($data = array())
    {

		$username    =  $data['username'];
		if(!empty($data['moblie'])){
			$moblie  =  $data['moblie'];
		}else{
			$moblie  =  $data['username'];
		}
		$return  =  array('msg'=>'系统繁忙','errcode'=>8);
		require ('notice.model.php');
		$noticeM  =  new notice_model($this->db, $this->def);
		//会员已登录判断
		if(!empty($data['uid'])  && $data['uid'] > 0 && $username!=''){
			if($data['usertype']=='1'){
				return array('msg'=>'您现在是个人会员登录状态!');
			}elseif($data['usertype']=='2'){					
				return array('msg'=>'您现在是企业会员登录状态!');
			}elseif($data['usertype']=='3'){
				return array('msg'=>'您现在是猎头会员登录状态!');
			}elseif($data['usertype']=='4'){
				return array('msg'=>'您现在是培训会员登录状态!');
			}
		}
		//username验证
		if($this->config['sy_msg_isopen'] && $this->config['sy_msg_login'] && !empty($data['act_login'])){					
			if(!CheckMobile($moblie)){
				return array('msg'=>'手机号码格式不正确!','errcode'=>'8');
			}
			// 未注册手机登录直接注册新账号
			$member_arr	=	$this->getMemberNum(array('moblie'=>$moblie));


			if(!$member_arr || $member_arr==0){

			    $return =	$this -> regUserByMobile($moblie, $data);

				if($return['errcode']!=1){
					return $return;
				}else{
					$regNew	=	1;
				}
			}
			$where		=	array('moblie'=> $moblie);
		}else {
			//验证码判断 手机动态码登录 无需验证验证码
			if($data['wxapp'] != '1'){
				$result			=		$noticeM->jycheck($data['authcode'],'前台登录');
				if(!empty($result)){
					return array('msg'=>$result['msg'],'errcode'=>'8');
				}
			}

			if(CheckRegUser($username)==false && CheckRegEmail($username)==false && ($username!='')){
				return array('msg'=>'用户名或密码不正确！','errcode'=>'8');
			}
			
			$where			=		array('username'=> $username);

			if(CheckMobile($username)){
				$where['PHPYUNBTWSTART']	=	'OR';
				
				$where['moblie']		=	$username;

				$where['moblie_status']	=	1;
				
				$where['PHPYUNBTWEND']	=	'';
			
			}
			//邮箱登录				
			if(CheckRegEmail($username)){

				$where['PHPYUNBTWSTART']	=	'OR';
				
				$where['email']		=	$username;

				$where['email_status']	=	1;
				
				$where['PHPYUNBTWEND']	=	'';
			}
		}
		
		$user  =  $this->getInfo($where);
		
		//开启UC情况下 需要判断UC账户 并进行同步登录
		if($this->config['sy_uc_type']=="uc_center"  && !$data['act_login']){
			
		
			include APP_PATH.'data/api/uc/config.inc.php';
			include APP_PATH.'/api/uc/include/db_mysql.class.php';
			include APP_PATH.'/api/uc/uc_client/client.php';
			$uname = $username;
			

			list($uid, $uname, $password, $email) = uc_user_login($uname, $data['password']);

		
			if($uid>0){
				//创建登录同步通知
				$ucsynlogin=uc_user_synlogin($uid);
				
				$return['uclogin']	=	$ucsynlogin;
			}
		}
		//如果系统未找到该用户 转向UC验证 是否UC用户 排除动态码登录
		if(empty($user)){
			
			//自动将UC账号注册至系统
			if($uid > 0) {
				
				if($data['source']){
					$source	=	$data['source'];
				}else{
					$source	=	1;
				}
				$salt 							= 		substr(uniqid(rand()), -6);
				$pass 							= 		passCheck($data['password'],$salt);
				$adata['username']				=		$data['username'];
				$adata['password']				=		$pass;
				$adata['did']					=		$this->config['did'];
				$adata['status']				=		1;
				$adata['salt']					=		$salt;
				$adata['source']				=		$source;
				$adata['reg_date']				=		time();
				$adata['reg_ip']				=		fun_ip_get();
				$adata['usertype']				=		0;
				$userid							=		$this->insert_into('member',$adata);
				//
				$user			=	$adata;
				$user['uid']	=	$userid;
				$res	        =	true;
				$loginType      =   'UC';
			}else{
				return array('msg'=>'该用户不存在!','errcode'=>'8');
			}
		}else{
			
			if($user['status']=='2'){
				return array('msg'=>'您的账号已被锁定!','errcode'=>'8','url'=>Url('register',array('c'=>'ok','type'=>2),'1'));	
			}

			//如果是企业用户，验证企业是否暂停
			if($user['usertype']=='2'){

				$commember  =  $this->select_once('company',array('uid'=>$user['uid']),'r_status');
				
				if($commember['r_status']==4){

					return array('msg'=>'您的账号已被暂停!','errcode'=>'8');
				}
			}
			if ($this->config['sy_msg_isopen'] && $this->config['sy_msg_login'] && !empty($data['act_login'])) {

				//短信验证码校验				
				if($regNew == 1){	

					$companywhere['check']	=	$user['moblie'];
				}else{

					$companywhere['uid']	=	$user['uid'];
				}

				$companywhere['type']		=		2;
				$companywhere['orderby']	=		array('ctime,desc');
				
				include_once ('company.model.php');
				$CompanyM					=		new company_model($this->db, $this->def);	
				$cert_arr					=		$CompanyM->getCertInfo($companywhere);					
				if (is_array($cert_arr)) {
					$checkTime 				= 		$noticeM->checkTime($cert_arr['ctime']);
					if($checkTime){
						$res 				= 		$data['password'] == $cert_arr['check2'] ? true : false;
						if($res == false){
							return array('msg'=>'短信验证码错误！','errcode'=>'8'); 
						}						
					}else {		
						return array('msg'=>'验证码验证超时，请重新点击发送验证码！','errcode'=>'8'); 			
					}					
				}else {		
					return array('msg'=>'验证码发送不成功，请重新点击发送短信验证码！','errcode'=>'8'); 			
				}
				$loginType  =  '短信验证码';
			}else{
				//普通密码校验
				$res  =  passCheck($data['password'],$user['salt'],$user['password']);
				$loginType  =  '账号';
			}
		}

		if($res){
				
			//更新用户QQ互联ID					
			if (session_id() == ''){
				session_start();
			}					
			if(!empty($_SESSION['qq']['openid'])){					   							
				if($_SESSION['qq']['unionid']){	
					$qqdata				= 		array(
						'qqid'			=>		$_SESSION['qq']['openid'],
						'qqunionid'		=>		$_SESSION['qq']['unionid']
					);								
				}else{
					$qqdata				= 		array(
						'qqid'			=>		$_SESSION['qq']['openid']
					);
				}						
				$this->upInfo(array('username'=>$user['username']),$qqdata);						
				unset($_SESSION['qq']);					
			}
			//更新用户微信unionid
			if(!empty($_SESSION['wx']['openid'])){													
				if($_SESSION['wx']['unionid']){							
					$udate 			= 		array(
						'wxid'		=>		$_SESSION['wx']['openid'],
						'unionid'	=>		$_SESSION['wx']['unionid']
					);					
				}else{
					$udate 			= 		array(
						'wxid'		=>		$_SESSION['wx']['openid']
					);
				}	
				$this->upInfo($udate, array('wxid' => '', 'wxid' => ''));
				$this->upInfo(array('username'=>$user['username']),$udate);						
				unset($_SESSION['wx']);					
			}elseif($_COOKIE['wxid']){
            	
            	if($_COOKIE['unionid']){							
					$udate 			= 		array(
						'wxid'		=>		$_COOKIE['wxid'],
						'unionid'	=>		$_COOKIE['unionid']
					);					
				}else{
					$udate 			= 		array(
						'wxid'		=>		$_COOKIE['wxid']
					);
				}
				$this->upInfo($udate, array('wxid' => '', 'wxid' => ''));
				$this->upInfo(array('username'=>$user['username']),$udate);
            }
			//更新用户新浪sinaid
			if(!empty($_SESSION['sina']['openid'])){
				$this->upInfo(array('username'=>$user['username']),array('sinaid'=>$_SESSION['sina']['openid']));
				unset($_SESSION['sina']);
			}
			//马甲app内绑定登录
			if(!empty($_SESSION['mag']['user_id'])){
				$this->upInfo(array('maguid'=>$_SESSION['mag']['user_id']),array('maguid'=>''));
				$this->upInfo(array('uid'=>$user['uid']),array('maguid'=>$_SESSION['mag']['user_id']));
				unset($_SESSION['mag']);
			}
			//千帆云app内绑定登录
			if (!empty($data['qfyuid'])){
				$this->upInfo(array('qfyuid'=>$data['qfyuid']),array('qfyuid'=>''));
				$this->upInfo(array('uid'=>$user['uid']),array('qfyuid'=>$data['qfyuid']));
			}	

			// 非APP/小程序cookie设置
			if (empty($data['wxapp'])){
			    
			    require_once('cookie.model.php');
			    $cookie  =  new cookie_model($this->db,$this->def);
			    
				$cookie->unset_cookie();
				$cookie->add_cookie($user['uid'],$user['username'],$user['salt'],$user['email'],$user['password'],$user['usertype'],$this->config['sy_logintime'],$user['did']);
			}
			//会员登录信息变更
			$ip       =  fun_ip_get();
			$upLogin  =  array(
				'login_ip'		=>	$ip,
				'login_date'	=> 	time(),
				'login_hits' 	=>	array('+', 1)
			);
			if (!empty($data['wxapp'])){
				if (!empty($data['clientid'])){
					$upLogin['clientid']     =  $data['clientid'];
					$upLogin['deviceToken']  =  $data['deviceToken'];
					//清除其他账号clientid
					$this->clearPushId($data['clientid'], $user['uid']);
				}
			}
			$this->upInfo(array('uid'=>$user['uid']), $upLogin);

			if(!empty($user['usertype'])){
			    
			    require_once ('log.model.php');
			    $LogM = new log_model($this->db, $this->def);
			    //会员日志，记录登录
			    $loginType .= $LogM->LoginType($data);
			    $LogM->addMemberLog($user['uid'],$user['usertype'], $loginType);
			    
				$logtime					   	=		date('Ymd',$user['login_date']);
				$nowtime					   	=		date('Ymd',time());
				if($logtime!=$nowtime){
				    //登录积分
				    include_once ('integral.model.php');
				    $integralM  =  new integral_model($this->db, $this->def);	
					$integralM->invtalCheck($user['uid'],$user['usertype'],'integral_login','会员登录',22);
					//登录日志
					$logdata['uid']			=	$user['uid'];
					$logdata['usertype']	=	$user['usertype'];
					$logdata['did']			=	$user['did'];
					
					$LogM->addLoginlog($logdata, $data);
				}
				$resumeData = array('login_date'=>time());
				// 个人登录自动刷新简历
				if ($this->config['resume_sx'] == 1 && $user['usertype'] == 1) {
				 
				    $expect  =  $this->select_once('resume_expect',array('uid'=>$user['uid'],'defaults'=>1), '`id`');
				    if (empty($expect)){
				        $expect  =  $this->select_once('resume_expect',array('uid'=>$user['uid'],'orderby'=>'`id`'), '`id`');
				    }
				    if (!empty($expect)) {
				        $this->update_once('resume_expect', array('lastupdate'=>time()),array('id'=>$expect['id']));
				        $resumeData['lastupdate'] = time();

				        $LogM->addResumeSxLog(array('uid' => $user['uid'], 'resume_id' => $expect['id'], 'r_time' => time(), 'port' => $data['port'], 'ip' => fun_ip_get()));
				    }
				}
				// 同步登录时间
				$this->update_once('company', array('login_date' => time()), array('uid' => $user['uid']));
				$this->update_once('resume', $resumeData, array('uid' => $user['uid']));
			}
			
			if(empty($user['usertype'])){
				$return['errcode']			=		2;
				$return['msg']				=		'';
			}else if(!empty($_COOKIE['wxid'])){
				include_once ('wxredpack.model.php');
				$wxRedPackM 				= 		new wxredpack_model($this->db,$this->def);
				$wxRedPackM -> sendRedPack(array('type'=>'2','openid'=>$_COOKIE['wxid']));
				$cookie->setcookie('wxid','',time() - 86400);
				$return['msg']				=		'绑定成功，请按左上方返回进入微信客户端';
				$return['url']				=		Url('wap').'member/';
				$return['errcode']			=		9;
			}else if(!empty($data['job'])){
				$return['errcode']			=		9;
				$return['msg']				=		'';
				$return['url']				=		Url('wap',array('c'=>'job','a'=>'comapply','id'=>intval($data['job'])));
			}else if(!empty($data['checkurl'])){
				$return['errcode']			=		9;
				$return['msg']				=		'';
				$return['url']				=		$data['checkurl'];
			}else{
				
				if(!empty($data['backurl'])){
				    $return['url']		    =     	$data['backurl'];
				}else{
					if(!empty($data['num']) && $data['num']!=1 ){
					    if(!empty($data['referurl'])){
					        $return['url']  =     	$data['referurl'];
					    }else{
					        $return['url']  =     	$this->config['sy_weburl'].'/member/index.php';
					    }
					}else{
						$return['url']		=     	$_SERVER['HTTP_REFERER'];
					}
				}
				$return['errcode']		    =		9;
				$return['msg']				=		'登录成功';
			}
			if (!empty($return['url'])){
			    if (strpos($return['url'], 'register') !==false || strpos($return['url'], 'login') !==false || strpos($return['url'], 'setname') !==false || stripos($return['url'], 'forgetpw') !== false || ($return['url'] == $this->config['sy_weburl'] || $return['url'] == $this->config['sy_weburl'].'/') || $return['url'] == Url('wap')){
			        if ($data['source'] == 2){
						$return['url']  =  Url('wap',array(),'member');
					}else{
						$return['url']  =  $this->config['sy_weburl'].'/member/index.php';
					}
				}
			}
			// app 需要token
			if (!empty($data['wxapp'])){
				$token                      =       md5($user['username'].$user['password'].$user['salt'].$user['usertype']);
				if($user['usertype'] > 0){
					$type					=		$user['usertype'];
				}else{
					$type					=		0;
				}
				$return['user']				=		array('uid'=>$user['uid'],'usertype'=>$type,'token'=>$token);
				if($user['pid']){
					$return['user']['spid'] =		1;
				}
			}
			
			return $return;
		}else{
			
			return array('msg'=>'用户名或密码不正确！','errcode'=>'8');
		}
		return $return;
	}

    /**
     * 手机登录，直接注册
     * @param String $moblie 未注册手机号登录，直接注册新会员
     * @return int[]
     */
	private function regUserByMobile($moblie, $data = array())
    {
		
		include_once ('company.model.php');
		include_once ('notice.model.php');
		require_once('cookie.model.php');

		$cookie		=	new cookie_model($this->db,$this->def);
		$noticeM	=	new notice_model($this->db, $this->def);
		$return		=	array('errcode'=>8);

		$usertype	=	0;
		$ip			=	fun_ip_get();
        $code       =   $data['password'];
		
        $CompanyM					=		new company_model($this->db, $this->def);
        $cert_arr					=		$CompanyM->getCertInfo(array('type' => '2', 'check' => $moblie,'orderby'=>'ctime,desc'));
        if (is_array($cert_arr)) {
            $checkTime 				= 		$noticeM->checkTime($cert_arr['ctime']);
            if($checkTime){
                $res 				= 		$code == $cert_arr['check2'] ? true : false;
                if($res == false){
                    return array('msg'=>'短信验证码错误！','errcode'=>'8');
                }
            }else {
                return array('msg'=>'验证码验证超时，请重新点击发送验证码！','errcode'=>'8');
            }
        }else {
            return array('msg'=>'验证码发送不成功，请重新点击发送短信验证码！','errcode'=>'8');
        }

		$data['username']	=	$moblie;

		$password			=	mt_rand(111111,999999);
			
		if($this->config['sy_uc_type']=="uc_center"){
			include APP_PATH.'data/api/uc/config.inc.php';
			include APP_PATH.'/api/uc/include/db_mysql.class.php';
			include APP_PATH.'/api/uc/uc_client/client.php';
			
			$ucusername = 	$data['username'];
			$ucemail	=	$ucinfo['UC_EMAIL'];
			 
			$uid 		=	uc_user_register($ucusername, $password, $ucemail);
		 
			list($uid,$username,$password,$email,$salt)	=	uc_user_login($ucusername,$password);
			$pass 		= 	md5(md5($password).$salt);

		}elseif($this->config['sy_pw_type']=='pw_center'){
			include(APP_PATH.'/api/pw_api/pw_client_class_phpapp.php');
			$email		=	'';
			$pw			=	new PwClientAPI($data['username'],$password,$email);
			$pwuid		=	$pw->register();
			$salt		=	substr(uniqid(rand()), -6);
			$pass		=	passCheck($password, $salt);
		}else{
			$salt		=	substr(uniqid(rand()), -6);
			$pass		=	passCheck($password, $salt);
		}

		if($_COOKIE['wxid']){
			$source	=	'9';
		}elseif($_SESSION['wx']['openid']){
			$source	=	'4';
		}elseif($_SESSION['qq']['openid']){
			$source	=	'8';
		}elseif($_SESSION['sina']['openid']){
			$source	=	'10';
		}elseif($data['source']){
			$source	=	$data['source'];
		}else{
			$source	=	1;
		}
		
		/* 生成uid */
		$adata['username']		=	$data['username'];
		$adata['password']		=	$pass;
		$adata['email']			=	'';
		$adata['moblie']		=	$moblie;
		$adata['moblie_status']	=	1;
		$adata['did']			=	!empty($data['did']) ? $data['did'] : $this->config['did'];
		$adata['status']		=	1;
		$adata['salt']			=	$salt;
		$adata['source']		=	$source;
		$adata['reg_date']		=	time();
		$adata['reg_ip']		=	$ip;
		$adata['qqid']			=	$_SESSION['qq']['openid'];
		$adata['sinaid']		=	$_SESSION['sina']['openid'];
		$adata['wxid']			=	$_SESSION['wx']['openid'];
		$adata['usertype']		=	0;
		$adata['maguid']		=	$_SESSION['mag']['user_id'];
		$adata['qfyuid']		=	$_POST['qfyuid'];
		 
		$userid		=	$this->insert_into('member',$adata);

		//  容错机制，防止插入表没返回UID
		if (!$userid){

            $user_id    =	$this->getInfo(array('username'=>$data['username']),array('field'=>'uid'));
            $userid     =	$user_id['uid'];
        }

		if($userid){

			$cookie->unset_cookie();
			
			if($this->config['sy_pw_type']=='pw_center'){
				$this->upInfo(array('pwuid'=>$pwuid),array('uid'=>$userid));
			}
			 
			//处理注册赠送优惠券
			if($this->config['reg_coupon']){
				$coupon						=		$this->select_once('coupon',array('id'=>$this->config['reg_coupon']));
				$cdata['uid']				=		$userid;
				$cdata['number']			=		time();
				$cdata['ctime']				=		time();
				$cdata['coupon_id']			=		$coupon['id'];
				$cdata['coupon_name']		=		$coupon['name'];
				$cdata['validity']			=		time()+$coupon['time']*86400;
				$cdata['coupon_amount']		=		$coupon['amount'];
				$cdata['coupon_scope']		=		$coupon['scope'];
				$this->insert_into('coupon_list',$cdata);
			}
			
			if(checkMsgOpen($this -> config)){

				$noticeM->sendSMSType(array('name'=>$data['username'],'username'=>$data['username'],'password'=>$password,'moblie'=>$moblie,'type'=>'reg','uid'=>$userid,'port' => $data['port']));
			}
			
			 
			$this->upInfo(array('uid'=>$userid),array('login_date'=>time(),'login_ip'=>$ip));
			
			$return['msg']		=		'注册成功';
			$return['errcode']	=		1;
			
			
			if (!empty($data['wxapp'])){
			    // wxapp 需要token
			    $token                  =   md5($data['username'].$pass.$salt.'0');
			    $return['user']			=   array('uid'=>$userid,'usertype'=>0,'token'=>$token);

			    if (!empty($data['clientid'])){
			        //清除其他账号clientid
			        $this->clearPushId($data['clientid'], $userid);
			    }
			}else{
			    // 浏览器需要cookie
			    $cookie->add_cookie($userid,$data['username'],$salt,$data['email'],$pass,'',$this->config['sy_logintime'],$adata['did']);
			}

			return $return;
		}else{

			$return['msg']	=		'注册失败';
			$this -> addErrorLog('', 1,$return['msg']);
			$return['errcode']	=	8;
			return	$return;
		}
	}

    /**
     * 注册
     *
     * @param array $data   $data['uid']    $data['usertype']
     * @return mixed
     */
	public function userReg($data = array()){

		if($data['moblie']){
			$resume_info 				= 		$this->getUserInfo(array('telphone'=>$data['moblie'] , 'moblie_status'=>'1') , array('usertype'=>'1','field'=>'uid,name'));
			$company_info 				= 		$this->getUserInfo(array('linktel'=>$data['moblie'] , 'moblie_status'=>'1'),array('usertype'=>'2','field'=>'uid,name'));
			$lt_info		 			= 		$this->getUserInfo(array('moblie'=>$data['moblie'] , 'moblie_status'=>'1'),array('usertype'=>'3','field'=>'uid,realname'));
			$px_info 					= 		$this->getUserInfo(array('linktel'=>$data['moblie'] , 'moblie_status'=>'1'),array('usertype'=>'4','field'=>'uid,name'));
			$m_info 					= 		$this->getInfo(array('moblie' => $data['moblie'], 'username' => array('=', $data['moblie'], 'OR')),array('field'=>'`uid`,`usertype`,`username`,`moblie`'));
		}elseif($data['email']){
			$resume_info 				= 		$this->getUserInfo(array('email'=>$data['email'] , 'moblie_status'=>'1') ,array('usertype'=>'1','field'=>'uid,name'));
			$company_info 				= 		$this->getUserInfo(array('linkmail'=>$data['email'] , 'moblie_status'=>'1') ,array('usertype'=>'2','field'=>'uid,name'));
			$lt_info 					= 		$this->getUserInfo(array('email'=>$data['email'] , 'moblie_status'=>'1') ,array('usertype'=>'3','field'=>'uid,realname'));
			$px_info 					= 		$this->getUserInfo(array('linkmail'=>$data['email'] , 'moblie_status'=>'1') ,array('usertype'=>'4','field'=>'uid,name'));
			$m_info 					= 		$this->getInfo(array('email' => $data['email'], 'username' => array('=', $data['email'], 'OR')),array('field'=>'`uid`,`usertype`,`username`,`email`'));
		}
		
		if($resume_info){

			$rdata['name']				=		$resume_info['name'];
			$rdata['uid']				=		$resume_info['uid'];
			$rdata['usertype']			=		'1';
		}else if($company_info){

			$rdata['name']				=		$company_info['name'];
			$rdata['uid']				=		$company_info['uid'];
			$rdata['usertype']			=		'2';
		}else if($lt_info){

			$rdata['name']				=		$lt_info['realname'];
			$rdata['uid']				=		$lt_info['uid'];
			$rdata['usertype']			=		'3';
		}else if($px_info){

			$rdata['name']				=		$px_info['name'];
			$rdata['uid']				=		$px_info['uid'];
			$rdata['usertype']			=		'4';
		}else if($m_info){
			
			if($m_info['usertype']=='1'){

			    $info 					= 		$this->getUserInfo(array('uid'=>$m_info['uid']),array('usertype'=>'1','field'=>'name'));
				$rdata['name']			=		$info['name'];
			}else if($m_info['usertype']=='2'){

			    $info 					= 		$this->getUserInfo(array('uid'=>$m_info['uid']),array('usertype'=>'2','field'=>'name'));
				$rdata['name']			=		$info['name'];
			}else if($m_info['usertype']=='3'){

			    $info 					= 		$this->getUserInfo(array('uid'=>$m_info['uid']),array('usertype'=>'3','field'=>'realname'));
				$rdata['name']			=		$info['realname'];
			}else if($m_info['usertype']=='4'){

			    $info 					= 		$this->getUserInfo(array('uid'=>$m_info['uid']),array('usertype'=>'4','field'=>'name'));
				$rdata['name']			=		$info['name'];
			}
			
			$rdata['uid']				=		$m_info['uid'];
			$rdata['usertype']			=		$m_info['usertype'];
		}

		if($rdata!=null){

			$return['data']				=		$rdata;	
			return $return;
		}
		if($this->config['sy_web_mobile']!=''){

			$regnamer					=		@explode(';',$this->config['sy_web_mobile']);
			if(in_array($data['moblie'],$regnamer)){

				$return['errcode']		=		2;	
			}
		}
		$return['errcode']				=		0;	

		return $return;
	}

    /**
     * 注册
     * $data    处理的数据
     * @param array $data
     * @return int[]
     */
	public function userRegSave($data = array())
    {
		
		include_once ('notice.model.php');
		$noticeM	=	new notice_model($this->db, $this->def);

		$return		=	array('errcode'=>8);

		if($this->config['reg_user_stop']!=1){
			$return['msg']		=		'网站已关闭注册！';	
			$return['errcode']	=		8;
			return	$return;
		}
		 
		if(!empty($data['uid'])){
			$return['msg']		=		'您已经登录了！';	
			$return['errcode']	=		8;
			return 		$return;
		}
		
		$ip           			=  		 fun_ip_get();
		
		if($this->config['sy_reg_interval']>0){
		    
			$intervaltime    	=   	time() - 3600 * $this->config['sy_reg_interval'];
			
			$regnum          	=   	$this ->  getMemberNum(array('reg_ip' => $ip , 'reg_date' => array('>=', $intervaltime)));
			
			if($regnum){
				$return['errcode']			=		8;
				$return['msg']				=		'请勿频繁注册！';	

				return 		$return;
			}
		}

		//关闭用户名注册
		if($data['codeid']=='1' && $this->config['reg_user']!='1'){
		    
		    $return['msg']		=		'网站已关闭用户名注册！';	
			$return['errcode']	=		8;
			return		$return;
		}
		//关闭手机注册
		if($data['codeid']=='2' && $this->config['reg_moblie']!='1'){
		    
		    $return['msg']		=		'网站已关闭手机注册！';	
			$return['errcode']	=		8;
			return		$return;
		}
		//关闭邮箱注册
		if($data['codeid']=='3' && $this->config['reg_email']!='1'){
		    
		    $return['msg']		=		'网站已关闭邮箱注册！';	
			$return['errcode']	=		8;
			return		$return;
		}

        if ($this->config['sy_reg_type'] == 2) {

            if ($data['reg_type'] == 1) {

                if ($this->config['sy_resumename_num'] == 1) {

                    if (!$data['reg_name'] || !preg_match("/^[\x{4e00}-\x{9fa5}]{2,6}$/u", $data['reg_name'])) {

                        $return['msg'] = '姓名请输入2-6位汉字！';
                        $return['errcode'] = 8;
                        return $return;
                    }
                }
            } else if ($data['reg_type'] == 2) {

                $comNum = $this->select_num(array('name' => $data['reg_name']));

                if ((int)$comNum > 0) {
                    $return['msg']      =   '企业名称已存在！';
                    $return['errcode']  =   8;
                    return $return;
                }
            }
        }

		/* 用户名注册 */
        if ($data['codeid'] == '1') {

            $data['username']   =   str_replace('！', '!', $data['username']);
            $username           =   $data['username'];
            $msg                =   regUserNameComplex($username);//检测用户名复杂度

            if ($username == '') {

                $return['msg']  =   '用户名不能为空！';
            } elseif (CheckRegUser($username) == false && CheckRegEmail($username) == false) {

                $return['msg']  =   '用户名不得包含特殊字符！';
            } elseif ($msg != '') {

                $return['msg']  =   $msg;
            } else {

                $usernameNum    =   $this->getMemberNum(array('username' => $username));
                if ($usernameNum > 0) {
                    $return['msg'] = '用户名已存在，请重新输入！';
                }
            }

            if ($return['msg']) {
                $return['errcode']  =   8;
                return $return;
            }
        }

		/* 是否要输入手机号 */
        $needMobile     =   false;
        if ($data['codeid'] == 2) {
            $needMobile =   true;
        } else if ($this->config['reg_real_name_check'] == 1) {
            $needMobile =   true;
        }
        if ($needMobile) {
            if ($data['moblie'] == '') {
                $return['msg']  =   '手机号码不能为空！';
            } elseif (!CheckMobile($data['moblie'])) {
                $return['msg']  =   '手机格式错误！';
            } else {
                $moblieNum      =   $this->getMemberNum(array('moblie' => $data['moblie']));
                if ($moblieNum > 0) {
                    $return['msg']  =   '手机已存在！';
                }
            }
            if ($return['msg']) {
                $return['errcode']  =   8;
                return $return;
            }
        }

		/* 是否要输入email */
        $needEmail  =   false;
        if ($data['codeid'] == 3) {
            $needEmail  =   true;
        }
        if ($needEmail) {
            if ($data['email'] == '') {
                $return['msg'] = '邮箱不能为空';
            } elseif (CheckRegEmail($data['email']) == false) {
                $return['msg'] = '邮箱格式错误！';
            } else {
                $emailNum = $this->getMemberNum(array('email' => $data['email']));
                if ($emailNum > 0) {
                    $return['msg'] = '邮箱已存在，请重新输入！';
                }
            }
            if ($return['msg']) {
                $return['errcode'] = 8;
                return $return;
            }
        }

		/* 是否验证短信验证码 */
        $needMsg = false;

        if ($data['codeid'] == 2 && $this->config['sy_msg_regcode'] == '1') {
            $needMsg = true;
        } else if ($this->config['reg_real_name_check'] == 1) {
            $needMsg = true;
        }
        if ($needMsg) {

            $regCertMobile = $this->select_once('company_cert', array('type' => '2', 'check' => $data['moblie'], 'orderby' => 'ctime,desc'), '`check2`,`ctime`');
            $codeTime = $noticeM->checkTime($regCertMobile['ctime']);
            if ($data['moblie_code'] == '') {

                $return['msg'] = '短信验证码不能为空！';
                $return['errcode'] = 8;
                return $return;
            } elseif (!$codeTime) {

                $return['msg'] = '短信验证码验证超时，请重新点击发送验证码！';
                $return['errcode'] = 8;
                return $return;
            } elseif ($regCertMobile['check2'] != $data['moblie_code']) {

                $return['msg'] = '短信验证码错误！';
                $return['errcode'] = 8;
                return $return;
            } else {

                $adata['moblie_status'] = '1';
            }
        }

		/* 已通过短信验证，则不需要极验证、图片验证 */
        if ($data['wxapp'] != 1) {
            if (!$needMsg) {
                $result = $noticeM->jycheck($data['code'], '注册会员');
                if (!empty($result)) {
                    $return['msg'] = $result['msg'];
                    $return['errcode'] = 8;
                    return $return;
                }
            }
        }

		/* 手机注册和邮箱注册 */
        if ($data['codeid'] == '2') {
            $data['username'] = $data['moblie'];
        } elseif ($data['codeid'] == '3') {
            $data['username'] = $data['email'];
        }

        $password   =   $data['password'];

        $pwmsg      =   regPassWordComplex($password);//检测用户名复杂度
        /* 密码 */
        if ($data['password'] == '') {

            $return['msg'] = '密码不能为空！';
            $return['errcode'] = 8;
            return $return;
        } elseif (mb_strlen($data['password']) < 6 || mb_strlen($data['password']) > 20) {

            $return['msg'] = '密码长度应在6-20位！';
            $return['errcode'] = 8;
            return $return;
        } elseif ($pwmsg != '') {

            $return['msg'] = $pwmsg;
            $return['errcode'] = 8;
            return $return;
        }

		if($data['username']){
            $nid = $this->getMemberNum(array('username' => $data['username']));

            if ($nid) {
                $return['msg'] = '账户名已存在！';
                $return['errcode'] = 8;
                return $return;
            }

            if ($this->config['sy_uc_type'] == "uc_center") {
                include APP_PATH . 'data/api/uc/config.inc.php';
                include APP_PATH . '/api/uc/include/db_mysql.class.php';
                include APP_PATH . '/api/uc/uc_client/client.php';
                $ucusername = $data['username'];
                //没有邮箱的情况下使用默认邮箱
                if (!$_POST['email']) {
                    $ucemail = $ucinfo['UC_EMAIL'];
                } else {
                    $ucemail = $_POST['email'];
                }
                $uid = uc_user_register($ucusername, $_POST['password'], $ucemail);
                if ($uid <= 0) {
                    switch ($uid) {
                        case "-1":
                            $return['msg'] = '用户名不合法!';
                            break;
                        case "-2":
                            $return['msg'] = '包含不允许注册的词语!';
                            break;
                        case "-3":
                            $return['msg'] = '用户名已经存在!';
                            break;
                        case "-4":
                            $return['msg'] = 'Email 格式有误!';
                            break;
                        case "-5":
                            $return['msg'] = 'Email 不允许注册!';
                            break;
                        case "-6":
                            $return['msg'] = '该 Email 已经被注册!';
                            break;
                    }
                    $return['errcode'] = 8;
                    return $return;
                } else {
                    list($uid, $username, $password, $email, $salt) = uc_user_login($ucusername, $_POST['password']);
                    $pass = md5(md5($_POST['password']) . $salt);
                }
            } elseif ($this->config['sy_pw_type'] == 'pw_center') {
                include(APP_PATH . '/api/pw_api/pw_client_class_phpapp.php');
                $password = $data['password'];
                $email = $data['email'];
                $pw = new PwClientAPI($data['username'], $password, $email);
                $pwuid = $pw->register();
                $salt = substr(uniqid(rand()), -6);
                $pass = passCheck($password, $salt);
            } else {
                $salt = substr(uniqid(rand()), -6);
                $pass = passCheck($data['password'], $salt);
            }

            if (isset($_COOKIE['wxid'])) {
                $source = '9';
            } elseif (isset($_SESSION['wx']['openid'])) {
                $source = '4';
            } elseif (isset($_SESSION['qq']['openid'])) {
                $source = '8';
            } elseif (isset($_SESSION['sina']['openid'])) {
                $source = '10';
            } elseif (isset($data['source'])) {
                $source = $data['source'];
            } else {
                $source = 1;
            }
			
			/* 生成uid */
            $adata['username'] = $data['username'];
            $adata['password'] = $pass;
            $adata['email'] = $data['email'];
            $adata['moblie'] = $data['moblie'];
            $adata['did'] = !empty($data['did']) ? $data['did'] : $this->config['did'];
            $adata['status'] = 1;
            $adata['salt'] = $salt;
            $adata['source'] = $source;
            $adata['reg_date'] = time();
            $adata['reg_ip'] = $ip;
            $adata['qqid'] = $_SESSION['qq']['openid'];
            $adata['sinaid'] = $_SESSION['sina']['openid'];
            $adata['wxid'] = $_SESSION['wx']['openid'];

            //  小程序邀请注册
            $adata['regcode'] = isset($data['fromUser']) ? $data['fromUser'] : (int)$_COOKIE['regcode'];

            if ($this->config['sy_reg_type'] == 2) {

                $adata['usertype']      =   $data['reg_type'];

                if (isset($data['wxapp'])) {
                    if (isset($data['bdopenid'])) {
                        $adata['bdopenid'] = $data['bdopenid'];
                    }
                    if (isset($data['app_wxid'])) {
                        $adata['app_wxid'] = $data['app_wxid'];
                    }
                    if (isset($data['wxopenid'])) {
                        $adata['wxopenid'] = $data['wxopenid'];
                    }
                    if (isset($data['unionid'])) {
                        $adata['unionid'] = $data['unionid'];
                    }
                    if (isset($data['qqid'])) {
                        $adata['qqid'] = $data['qqid'];
                    }
                    if (isset($data['qqunionid'])) {
                        $adata['qqunionid'] = $data['qqunionid'];
                    }
                }

                if (isset($data['reg_qq'])){

                    $adata['qqid']      =   $data['reg_qq']['openid'];
                    $adata['qqunionid'] =   $data['reg_qq']['unionid'];
                }elseif (isset($data['reg_weixin'])){

                    $adata['wxid']      =   $data['reg_weixin']['openid'];  //  公众号openid

                    $adata['unionid']   =   $data['reg_weixin']['unionid'];
                }elseif (isset($data['reg_sina'])){

                    $adata['sinaid']    =   $data['reg_sina']['openid'];
                }
            } else {

                $adata['usertype'] = 0;
            }

            $adata['maguid'] = $_SESSION['mag']['user_id'];
            $adata['qfyuid'] = $_POST['qfyuid'];
		    
			//马甲app内注册的
			if(isset($_SESSION['mag'])){
			    unset($_SESSION['mag']);
			}
			
			if (!empty($data['clientid'])){
			    $adata['clientid']     =  $data['clientid'];
			    $adata['deviceToken']  =  $data['deviceToken'];
			}
			$userid		=	$this->insert_into('member',$adata);
			if (!$userid) {

                $uInfo  =   $this->getInfo(array('username' => $data['username']), array('field' => 'uid'));
                $userid =   $uInfo['uid'];
            }

			if($userid){

				if($this->config['sy_pw_type']=='pw_center'){
					$this->upInfo(array('pwuid'=>$pwuid),array('uid'=>$userid));
				}

				//邀请注册获得积分
				if(!empty($_COOKIE['regcode'])){
					$regMember	=	$this->select_once('member',array('uid'=>(int)$_COOKIE['regcode']),"`usertype`");
					if(!empty($regMember)){
					    include_once ('integral.model.php');
					    $IntegralM	=	new integral_model($this->db, $this->def);
						$IntegralM -> invtalCheck((int)$_COOKIE['regcode'],$regMember['usertype'], 'integral_invite_reg', '邀请注册', 23);
					}
				}

				//处理注册赠送优惠券
				if($this->config['reg_coupon']){
					$coupon						=		$this->select_once('coupon',array('id'=>$this->config['reg_coupon']));
					$cdata['uid']				=		$userid;
					$cdata['number']			=		time();
					$cdata['ctime']				=		time();
					$cdata['coupon_id']			=		$coupon['id'];
					$cdata['coupon_name']		=		$coupon['name'];
					$cdata['validity']			=		time()+$coupon['time']*86400;
					$cdata['coupon_amount']		=		$coupon['amount'];
					$cdata['coupon_scope']		=		$coupon['scope'];
					$this->insert_into('coupon_list',$cdata);
				}

				/* 发送通知短信、邮件 */
				if($data['email']){
					$noticeM->sendEmailType(array('name'=>$data['username'],'username'=>$data['username'],'password'=>$data['password'],'email'=>$data['email'],'type'=>'reg','uid'=>$userid));
				}
				if(checkMsgOpen($this -> config)){

					$noticeM->sendSMSType(array('name'=>$data['username'],'username'=>$data['username'],'password'=>$data['password'],'moblie'=>$data['moblie'],'type'=>'reg','uid'=>$userid,'port' => $data['port']));
				}
				 
				$this->upInfo(array('uid'=>$userid),array('login_date'=>time(),'login_ip'=>$ip));

                $return['msg'] = '注册成功';
                $return['errcode'] = 1;

                // app 需要token
                if (!empty($data['wxapp'])) {

                    if ($this->config['sy_reg_type'] == 2) {

                        $token = md5($data['username'] . $pass . $salt . $adata['usertype']);
                        $return['user'] = array('uid' => $userid, 'usertype' => $adata['usertype'], 'token' => $token);
                        $this->addIdentInfo($userid, array('reg_name' => $data['reg_name'], 'reg_link' => $data['reg_link'], 'reg_type' => $data['reg_type'], 'source' => $data['source']));
                    }else{

                        $token = md5($data['username'] . $pass . $salt . '0');
                        $return['user'] = array('uid' => $userid, 'usertype' => 0, 'token' => $token);
                    }
                    if (!empty($data['clientid'])) {

                        //清除其他账号clientid
                        $this->clearPushId($data['clientid'], $userid);
                    }
                } else {

                    require_once('cookie.model.php');
                    $cookie = new cookie_model($this->db, $this->def);
                    $cookie->unset_cookie();

                    if ($this->config['sy_reg_type'] == 2) {

                        $cookie->add_cookie($userid, $data['username'], $salt, $data['email'], $pass, $data['reg_type'], $this->config['sy_logintime'], $this->config['did']);
                        $newResult  =   $this->addIdentInfo($userid, array('reg_name' => $data['reg_name'], 'reg_link' => $data['reg_link'], 'reg_type' => $data['reg_type'], 'source' => $data['source']));

                        $return['url']  =   $newResult['url'];
                        $return['reg_type'] =   $this->config['sy_reg_type'];
                    }else {

                        $cookie->add_cookie($userid, $data['username'], $salt, $data['email'], $pass, '', $this->config['sy_logintime'], $this->config['did']);
                    }
                }

                return $return;
			}else{

                $this->addErrorLog('', 1, $return['msg']);

                $return['msg'] = '注册失败';
                $return['errcode'] = 8;
                return $return;
			}

		}else{
            $return['msg'] = '用户名不能为空！';
            $return['errcode'] = 8;
            return $return;
		}
	}

    /**
     * 选择身份直接注册账号，添加基本信息
     * @param $uid
     * @param array $data
     * @return mixed
     */
    private function addIdentInfo($uid, $data = array())
    {

        $usertype   =   $data['reg_type'];
        $user       =   $this->getInfo(array('uid' => intval($uid)), array('field' => '`uid`,`username`,`password`,`salt`,`email`,`moblie`,`moblie_status`,`email_status`,`did`,`login_date`'));

        //根据激活类型 生成对应信息表附表信息
        if ($usertype == '1') {

            $table = 'member_statis';
            $table2 = 'resume';

            $data1 = array('uid' => $user['uid']);

            $crm_uid = $this->getCrmUid(array('type' => '1'));

            $data2 = array(

                'uid' => $user['uid'],
                'name' => $data['reg_name'],
                'email' => $user['email'],
                'email_status' => $user['email_status'],
                'telphone' => $user['moblie'],
                'r_status' => $this->config['user_state'],
                'moblie_status' => $user['moblie_status'],
                'crm_uid' => $crm_uid,
                'crm_time' => $crm_uid ? time() : '',
                'did' => !empty($user['did']) ? $user['did'] : $this->config['did'],
                'login_date' => time()
            );
        } elseif ($usertype == '2') {

            $table = 'company_statis';
            $table2 = 'company';

            require_once('rating.model.php');
            $ratingM = new rating_model($this->db, $this->def);

            $data1 = $ratingM->fetchRatingInfo(array('uid' => $user['uid']));
            $data1['uid'] = $user['uid'];
            $data1['did'] = $this->config['did'];
            $data2['uid'] = $user['uid'];
            $data2['name'] = $data['reg_name'];
            $data2['linkman'] = $data['reg_link'];
            $data2['linkmail'] = $user['email'];
            $data2['linktel'] = $user['moblie'];
            $data2['rating'] = $data1['rating'];
            $data2['rating_name'] = $data1['rating_name'];
            $data2['vipstime'] = $data1['vip_stime'];
            $data2['vipetime'] = $data1['vip_etime'];
            $data2['did'] = !empty($user['did']) ? $user['did'] : $this->config['did'];
            $data2['email_status'] = $user['email_status'];
            $data2['moblie_status'] = $user['moblie_status'];
            $data2['r_status'] = $this->config['com_status'];
            $data2['login_date'] = time();
            if ($this->config['sy_crm_duty'] == 1) {
                $crm_uid = $this->getCrmUid(array('type' => '2'));
            }

            if ($crm_uid) {
                $data2['crm_uid'] = $crm_uid;
                $data2['crm_time'] = time();
            }
        } elseif ($usertype == '3') {

            $table = 'lt_statis';
            $table2 = 'lt_info';

            require_once('rating.model.php');
            $ratingM = new rating_model($this->db, $this->def);

            $data1 = $ratingM->ltratingInfo(0, $uid);
            $data1['uid'] = $user['uid'];
            $data2['uid'] = $user['uid'];
            $data2['name'] = $data['reg_name'];
            $data2['email'] = $user['email'];
            $data2['moblie'] = $user['moblie'];
            $data2['did'] = !empty($user['did']) ? $user['did'] : $this->config['did'];
            $data2['email_status'] = $user['email_status'];
            $data2['moblie_status'] = $user['moblie_status'];
            $data2['r_status'] = $this->config['lt_status'];
        } elseif ($usertype == '4') {

            $table = 'px_train_statis';
            $table2 = 'px_train';
            $data1['uid'] = $user['uid'];
            $data2['uid'] = $user['uid'];
            $data2['name'] = $data['name'];
            $data2['linkman'] = $data['reg_link'];
            $data2['linkmail'] = $user['email'];
            $data2['linktel'] = $user['moblie'];
            $data2['email_status'] = $user['email_status'];
            $data2['moblie_status'] = $user['moblie_status'];
            $data2['did'] = !empty($user['did']) ? $user['did'] : $this->config['did'];
            $data2['r_status'] = $this->config['px_status'];
        }

        if ($table) {

            require_once('log.model.php');
            $LogM = new log_model($this->db, $this->def);
            //容错机制 判断附表数据是否存在 不存在才作新增操作
            $existTable = $this->select_num($table, array('uid' => $user['uid']));

            if ($existTable < 1) {
                $this->insert_into($table, $data1);
                //会员注册插入会员日志
                $LogM->addMemberLog($user['uid'], $usertype, '用户:' . $user['username'] . '注册成功');

                //判断是否记录已发送
                require_once 'integral.model.php';
                $IntegralM = new integral_model($this->db, $this->def);
                $integralwhere['com_id'] = $user['uid'];
                $integralwhere['pay_remark'] = '注册赠送';
                $Interpay = $IntegralM->getInfo($integralwhere);

                if (empty($Interpay) && $usertype != 5) {

                    if ($this->config['integral_reg'] > 0) {
                        $IntegralM->company_invtal($user['uid'], $usertype, $this->config['integral_reg'], true, '注册赠送', true, 2, 'integral', 23);
                    }

                    if ($this->config['integral_login']) {
                        $IntegralM->invtalCheck($user['uid'], $usertype, 'integral_login', '会员登录', 22);
                    }

                    if ($this->config['integral_mobliecert'] && $user['moblie_status'] == 1) {
                        $IntegralM->invtalCheck($user['uid'], $usertype, 'integral_mobliecert', '手机绑定');
                    }
                }
            }
            //会员日志，记录手动登录
            $LogM->addMemberLog($user['uid'], $usertype, '用户选择身份成功');
            // 登录日志
            $logtime = date('Ymd', $user['login_date']);
            $nowtime = date('Ymd', time());
            if ($logtime != $nowtime) {
                $logdata['uid'] = $user['uid'];
                $logdata['usertype'] = $usertype;
                $logdata['did'] = $user['did'];
                $LogM->addLoginlog($logdata, $user);
            }
        }
        $existTable2 = $this->select_num($table2, array('uid' => $user['uid']));
        if ($existTable2 < 1) {
            $this->insert_into($table2, $data2);
            if ($usertype == '2' && $data2['r_status'] == 0) {
                require_once 'admin.model.php';
                $adminM = new admin_model($this->db, $this->def);
                $adminM->sendAdminMsg(array('first' => '有新的企业会员《' . $user['username'] . '》需要审核，账号ID（' . $user['uid'] . '）', 'type' => 9));
            }
        }

        if ($usertype == 1) {

            if ($data['source'] == 1) {

                $return['url'] = Url('member', array('c' => 'expect', 'act' => 'add'));
            } elseif ($data['source'] == 2) {

                $return['url'] = Url('wap') . 'member/index.php?c=addresume';
            }

        } else {

            if ($data['source'] == 1) {

                $return['url'] = Url('member', array('c' => 'info'));
            } else {

                $return['url'] = Url('wap') . 'member/index.php?c=info';
            }
        }

        return $return;
    }
    

	function insertMember($data=array()){
	   
	    $nid	=	$this->insert_into('member', $data);
	    return $nid;
	}
	
	/**
	 * @desc   注册成功，选择身份
	 * @param  array $data
	 * @return array $return
	 */
	function upUserType($data = array())
    {
        $uid        =   intval($data['uid']);

        $usertype   =   intval($data['usertype']);

        if (in_array($usertype, array('1', '2', '3', '4'))) {
            
            $user   =   $this->getInfo(array('uid' => $uid), array('field' => '`uid`,`username`,`email_status`,`moblie_status`,`password`,`salt`,`email`,`moblie`,`did`'));
            
            $return =   array();
            
            if ($user['uid']) {
                // 增加来源
				if (isset($data['provider'])){
				    $user['provider'] = $data['provider'];
				}
				if (isset($data['iswap'])) {
				    $user['source'] = 2;
				}
            	$this -> activUser($user['uid'], $usertype, $user);
                
            	if (!isset($data['wxapp'])) {
                    
                    $cookie = new cookie_model($this->db, $this->def);
                    $cookie->setcookie('usertype', intval($usertype), time() + 86400);
                }
                
                if (isset($data['iswap'])) {
                    
                    if ($usertype == 1) {
                    
                        $return['url'] = Url('wap').'member/index.php?c=addresume';
                    } else {
                        
                        $return['url'] = Url('wap').'member/index.php?c=info';
                    }
                    
                } else {

                    if ($usertype == 1) {
                        
                        $return['url'] = Url('member', array('c' => 'expect', 'act' => 'add'));
                    } else {
                        
                        $return['url'] = Url('member', array('c' => 'info'));
                    }
                }

                $return['errcode']  =   1;
                
                // uni-app 需要token
                if (isset($data['wxapp'])) {
                    
                    $token  		=   md5($user['username'].$user['password'].$user['salt'].$usertype);
                    
                    $return['user'] =   array('uid' => $uid, 'usertype' => $usertype, 'token' => $token);
                }
            } else {
                
                $return['msg']      =   '请先注册';
                $return['errcode']  =   9;
            }
        } else {

            $return['msg']      =   '参数错误，请正确选择！';
            $return['errcode']  =   9;
        }

        return $return;
    }

    /**
     * 选择身份
     * @param $uid
     * @param $usertype
     * @param array $user
     */
    public function activUser($uid, $usertype, $user = array())
    {

        $this->upInfo(array('uid' => intval($uid)), array('usertype' => $usertype));

        if (empty($user)) {
            $user   =   $this->getInfo(array('uid' => intval($uid)), array('field' => '`uid`,`username`,`password`,`salt`,`email`,`moblie`,`moblie_status`,`email_status`,`did`,`login_date`'));
        }

        //根据激活类型 生成对应信息表附表信息
        if ($usertype == '1') {

            $table  =   'member_statis';
            $table2 =   'resume';

            $data1  =   array('uid' => $user['uid']);

            $crm_uid=   $this->getCrmUid(array('type' => '1'));

            $data2  =   array(

                'uid' => $user['uid'],
                'email' => $user['email'],
                'email_status' => $user['email_status'],
                'telphone' => $user['moblie'],
                'r_status' => $this->config['user_state'],
                'moblie_status' => $user['moblie_status'],
                'crm_uid' => $crm_uid,
                'crm_time' => $crm_uid ? time() : '',
                'did' => !empty($user['did']) ? $user['did'] : $this->config['did'],
                'login_date' => time()

            );

        } elseif ($usertype == '2') {

            $table = 'company_statis';
            $table2 = 'company';

            require_once('rating.model.php');
            $ratingM = new rating_model($this->db, $this->def);

            $data1 = $ratingM->fetchRatingInfo(array('uid' => $user['uid']));
            $data1['uid'] = $user['uid'];
            $data1['did'] = $this->config['did'];
            $data2['uid'] = $user['uid'];
            $data2['linkmail'] = $user['email'];
            $data2['linktel'] = $user['moblie'];
            $data2['rating'] = $data1['rating'];
            $data2['rating_name'] = $data1['rating_name'];
            $data2['vipstime'] = $data1['vip_stime'];
            $data2['vipetime'] = $data1['vip_etime'];
            $data2['did'] = !empty($user['did']) ? $user['did'] : $this->config['did'];
            $data2['email_status'] = $user['email_status'];
            $data2['moblie_status'] = $user['moblie_status'];
            $data2['r_status'] = $this->config['com_status'];
            $data2['login_date'] = time();
            if ($this->config['sy_crm_duty'] == 1) {
                $crm_uid = $this->getCrmUid(array('type' => '2'));
            }


            if ($crm_uid) {
                $data2['crm_uid'] = $crm_uid;
                $data2['crm_time'] = time();
            }
        } elseif ($usertype == '3') {
            $table = 'lt_statis';
            $table2 = 'lt_info';

            require_once('rating.model.php');
            $ratingM = new rating_model($this->db, $this->def);

            $data1 = $ratingM->ltratingInfo(0, $uid);
            $data1['uid'] = $user['uid'];
            $data2['uid'] = $user['uid'];
            $data2['email'] = $user['email'];
            $data2['moblie'] = $user['moblie'];
            $data2['did'] = !empty($user['did']) ? $user['did'] : $this->config['did'];
            $data2['email_status'] = $user['email_status'];
            $data2['moblie_status'] = $user['moblie_status'];
            $data2['r_status'] = $this->config['lt_status'];
        } elseif ($usertype == '4') {
            $table = 'px_train_statis';
            $table2 = 'px_train';
            $data1['uid'] = $user['uid'];
            $data2['uid'] = $user['uid'];
            $data2['linkmail'] = $user['email'];
            $data2['linktel'] = $user['moblie'];
            $data2['email_status'] = $user['email_status'];
            $data2['moblie_status'] = $user['moblie_status'];
            $data2['did'] = !empty($user['did']) ? $user['did'] : $this->config['did'];
            $data2['r_status'] = $this->config['px_status'];
        }

        if ($table) {

            require_once('log.model.php');
            $LogM = new log_model($this->db, $this->def);
            //容错机制 判断附表数据是否存在 不存在才作新增操作
            $existTable = $this->select_num($table, array('uid' => $user['uid']));

            if ($existTable < 1) {
                $this->insert_into($table, $data1);
                //会员注册插入会员日志
                $LogM->addMemberLog($user['uid'], $usertype, '用户:' . $user['username'] . '注册成功');

                //判断是否记录已发送
                require_once 'integral.model.php';
                $IntegralM = new integral_model($this->db, $this->def);
                $integralwhere['com_id'] = $user['uid'];
                $integralwhere['pay_remark'] = '注册赠送';
                $Interpay = $IntegralM->getInfo($integralwhere);

                if (empty($Interpay) && $usertype != 5) {

                    if ($this->config['integral_reg'] > 0) {
                        $IntegralM->company_invtal($user['uid'], $usertype, $this->config['integral_reg'], true, '注册赠送', true, 2, 'integral', 23);
                    }

                    if ($this->config['integral_login']) {
                        $IntegralM->invtalCheck($user['uid'], $usertype, 'integral_login', '会员登录', 22);
                    }

                    if ($this->config['integral_mobliecert'] && $user['moblie_status'] == 1) {
                        $IntegralM->invtalCheck($user['uid'], $usertype, 'integral_mobliecert', '手机绑定');
                    }
                }
            }
            //会员日志，记录手动登录
            $LogM->addMemberLog($user['uid'], $usertype, '用户选择身份成功');
            // 登录日志
            $logtime = date('Ymd', $user['login_date']);
            $nowtime = date('Ymd', time());
            if ($logtime != $nowtime) {
                $logdata['uid'] = $user['uid'];
                $logdata['usertype'] = $usertype;
                $logdata['did'] = $user['did'];
                $LogM->addLoginlog($logdata, $user);
            }
        }
        $existTable2 = $this->select_num($table2, array('uid' => $user['uid']));
        if ($existTable2 < 1) {
            $this->insert_into($table2, $data2);
            if ($usertype == '2' && $data2['r_status'] == 0) {
                require_once 'admin.model.php';
                $adminM = new admin_model($this->db, $this->def);
                $adminM->sendAdminMsg(array('first' => '有新的企业会员《' . $user['username'] . '》需要审核，账号ID（' . $user['uid'] . '）', 'type' => 9));
            }
        }
    }

    /**
     * @desc 企业 / 个人注册，查询CRM信息绑定
     * @param array $data
     * @return mixed
     */
	public function getCrmUid($data = array()) {
	    
	    if ($data['city'] == 1) {
	        
	        $crmWhere                      =   array();
	        $crmWhere['is_crm']            =   '1';
	        $crmWhere['status']            =   '1';
	        $crmWhere['PHPYUNBTWSTART_A']  =   '';
	        $crmWhere['crm_city'][]        =   array('findin', $data['provinceid'], 'OR');
	        $crmWhere['crm_city'][]        =   array('findin', $data['cityid'], 'OR');
	        if ($data['three_cityid']) {
	            $crmWhere['crm_city'][]    =   array('findin', $data['three_cityid'], 'OR');
	        }
	        $crmWhere['PHPYUNBTWEND_A']    =   '';
	        $crmWhere['orderby']           =   'uid';


	        $crms   =	$this -> select_all('admin_user', $crmWhere, '`uid`');

        } else {

            $day    =    date('w') ==0 ? 7 : date('w');
            $crms   =	$this -> select_all('admin_user', array('is_crm' => 1, 'status' => 1, 'crm_duty' => array('findin', $day), 'orderby' => 'uid'), '`uid`');
        }
        
	    
	    if (is_array($crms)) {
	        
	        foreach ($crms as $k => $v){
	            
	            $CrmUid[$v['uid']] =   $k + 1;
	            $CrmK[$k]          =   $v['uid'];
	        }

	        if ($data['type'] == '1') {

	            $endCrm =   $this->select_once('resume', array('crm_uid' => array('>', 0), 'orderby' => 'uid, desc'), '`crm_uid`');
	        }elseif ($data['type'] == '2'){

                $sql    =   "SELECT `crm_uid` FROM ".DEF_DATA."company LEFT JOIN ".DEF_DATA."member ON ".DEF_DATA."company.uid = ".DEF_DATA."member.uid WHERE ".DEF_DATA."member.source <> 16 AND ".DEF_DATA."company.crm_uid > 0 ORDER BY ".DEF_DATA."company.uid DESC LIMIT 1;";

	            $endCrm =   $this->DB_query_all($sql, 'one');
	        }

	        if (!$CrmUid[$endCrm['crm_uid']]) {

	            $CrmUid[$endCrm['crm_uid']]    =   0;
	        }
	        if ($CrmUid[$endCrm['crm_uid']] >= count($crms)){

	            $crm_uid    =  $CrmK[0];
	        }else{

	            $crm_uid    =  $CrmK[$CrmUid[$endCrm['crm_uid']]];
	        }
	    }

	    return  $crm_uid;
    }

	//快捷登录信息绑定
	public function bindUser($username,$password,$bindinfo){
			
		if($username && $password){

			$userinfo 		= 	$this->select_once('member',array('username'=>$username));
			
			if(!$userinfo && CheckMobile($username)){//手机号登录

				$user 		= 	$this->select_once('member',array('moblie'=>$username),'username,usertype,password,uid,usertype,salt,status,did,login_date');

				$binding	=	$this->getUserInfo(array('uid'=>$user['uid'],'moblie_status'=>1),array('usertype'=>$user['usertype'],'field'=>'uid'));

				if(!empty($binding)){
					$userinfo	= 	$user;
				}
			}
			if(!$userinfo&&CheckRegEmail($username)){//邮箱登录

				$user 		= 	$this->select_once('member',array('email'=>$username),'username,usertype,password,uid,usertype,salt,status,did,login_date');
				
				$binding	=	$this->getUserInfo(array('uid'=>$user['uid'],'email_status'=>1),array('usertype'=>$user['usertype'],'field'=>'uid'));
				
				if(!empty($binding)){
					$userinfo 	= 	$user;
				}
			}
			if(!empty($userinfo)){
				
				$res = passCheck($password,$userinfo['salt']) == $userinfo['password'] ? true : false;
				if($res){
					if($userinfo['status']=='1'){
						//开始绑定操作
						if($bindinfo['qqid']){
							$sqlBind['qqid']		=	$bindinfo['qqid'];
							$sqlBind['qqunionid']	=	$bindinfo['qqunionid'];
						}
						if($bindinfo['sinaid']){
							$sqlBind['sinaid']		=	$bindinfo['sinaid'];
						}
						if($bindinfo['wxid']){
							$sqlBind['wxid']		=	$bindinfo['wxid'];
							$sqlBind['unionid']		=	$bindinfo['wxunionid'];
						}
						if($sqlBind){
							$this->update_once('member',$sqlBind,array('uid'=>$userinfo['uid']));
							$error['info'] 	= $userinfo;
							$error['error'] = '1';
						}else{
							$error['msg'] = '绑定失败！';
						}
					}else{
						$error['msg'] = '该账户正在审核中，请稍后再绑定';
					}
				}else{
					$error['msg'] = '密码错误，请重试！';
				}
			}else{
				$error['msg'] = '请输入正确的账户名！';
			}
		}else{
			$error['msg'] = '请输入需要绑定的账户、密码！';
		}
		return $error;
	}
	
	function upMemberInfo($uData=array(),$setData=array()){
        if (! empty($setData)) {

            $result =   $this -> addMemberCheck($setData, $uData['uid'], $uData['usertype']);

            if ($result['msg']) {

                $result['errcode']  =   8;

                $result['url']      =   $_SERVER['HTTP_REFERER'];

                return $result;
            }
            if (!empty($setData['did'])){
                $result['did']  =   $setData['did'];
            }
            $result['reg_ip']   =   $setData['reg_ip'];
            
            if($setData['utype'] == 'admin'){
                
                $result['moblie']   =   $result['moblie'] ? $result['moblie'] : $setData['moblie'];
                $result['email']    =   $result['email'] ? $result['email'] : $setData['email'];
            }
            $nid    =   $this->upInfo(array('uid' => $uData['uid']), $result);

            if ($nid) {
              
 
                if ($setData['utype'] == 'admin') {
                    
                    if ($result['moblie']) {
                        
                        $this -> update_once('resume', array('moblie_status'=>'0', 'telphone'=>''), array('telphone'=>$result['moblie'], 'uid'=>array('<>',$uData['uid'])));
                        
                        $this -> update_once('company', array('moblie_status'=>'0', 'linktel'=>''), array('linktel'=>$result['moblie'], 'uid'=>array('<>',$uData['uid'])));
                        $this -> update_once('lt_info', array('moblie_status'=>'0', 'moblie'=>''), array('moblie'=>$result['moblie'], 'uid'=>array('<>',$uData['uid'])));
                        $this -> update_once('px_train', array('moblie_status'=>'0', 'linktel'=>''), array('linktel'=>$result['moblie'], 'uid'=>array('<>',$uData['uid'])));
                    }
                  
                    if ($result['email']) {
                        
                        $this -> update_once('resume',array('email_status'=>'0', 'email'=>''), array('email'=>$result['email'],'uid' =>array('<>',$uData['uid'])));
                        $this -> update_once('company',array('email_status'=>'0', 'linkmail'=>''), array('linkmail'=>$result['email'],'uid' =>array('<>',$uData['uid'])));
                        $this -> update_once('lt_info',array('email_status'=>'0', 'email'=>''), array('email'=>$result['email'],'uid' =>array('<>',$uData['uid'])));
                        $this -> update_once('px_train',array('email_status'=>'0', 'linkmail'=>''),array('linkmail'=>$result['email'],'uid' =>array('<>',$uData['uid'])));
                    }
                    

                    $this -> update_once('resume', array('telphone' => $result['moblie'], 'email' => $result['email']), array('uid' => $uData['uid']));

                    $this -> update_once('company', array('linktel' => $result['moblie'], 'linkmail' => $result['email']), array('uid' => $uData['uid']));

                    $this -> update_once('lt_info', array('moblie' => $result['moblie'], 'email' => $result['email']), array('uid' => $uData['uid']));

                    $this -> update_once('px_train', array('linktel' => $result['moblie'], 'linkmail' => $result['email']), array('uid' => $uData['uid']));
                }
            } 

            $result['msg']      =   $nid ? '修改成功！' : '修改失败！';

            $result['errcode']  =   $nid ? 9 : 8;

            $lasturl            =   str_replace('&amp;', '&', $uData['lasturl']);

            $result['url']      =   $lasturl;

            return $result;
        }
    }
	
	function delMember($del){

        if (!empty($del)) {
            
            $return =   array();
            
            if (is_array($del)) {

                $delid = pylode(',', $del);

                $return['layertype'] = 1;
            } else {

                $return['layertype'] = 0;
                $delid = $del;
            }
		 
            $resume = $this->select_all('resume', array('uid' => array('in', $delid)), '`uid`');
            if (is_array($resume) && $resume) {
                foreach ($resume as $v) {
                    if ($v['uid']) {
                        $rids[] = $v['uid'];
                    }
                }
            }

            $comacc = $this->select_all('company_account', array('uid' => array('in', $delid)), '`uid`');
            if (is_array($comacc) && $comacc) {
                foreach ($comacc as $v) {
                    if ($v['uid']) {
                        $comaccids[] = $v['uid'];
                    }
                }
            }
            
            $company = $this->select_all('company', array('uid' => array('in', $delid)), '`uid`');
            if (is_array($company) && $company) {
                foreach ($company as $v) {
                    if ($v['uid']) {
                        $comids[] = $v['uid'];
                    }
                }
            }

            $lt = $this->select_all('lt_info', array('uid' => array('in', $delid)), '`uid`');
            if (is_array($lt) && $lt) {
                foreach ($lt as $v) {
                    $ltids[] = $v['uid'];
                }
            }

            $px = $this->select_all('px_train', array('uid' => array('in',  $delid)), '`uid`');
            if (is_array($px) && $px) {
                foreach ($px as $v) {
                    if ($v['uid']) {
                        $pxids[] = $v['uid'];
                    }
                }
            }

            $gq = $this->select_all('gq_info', array('uid' => array('in', $delid)), '`uid`');
            if (is_array($gq) && $gq) {
                foreach ($gq as $v) {
                    if ($v['uid']) {
                        $gqids[] = $v['uid'];
                    }
                }
            }

			$result	=	$this->delete_all('member', array('uid' => array('in', $delid)),'');
			
			if($result){
				if (is_array($rids) && !empty($rids)) {
					$result	=	$this->delUser(pylode(',', $rids));
				}
				if (is_array($comids) && !empty($comids)) {
					$result	=	$this->delCom(pylode(',', $comids));
				}
				if (is_array($ltids) && !empty($ltids)) {
					$result	=	$this->delLt(pylode(',', $ltids));
				}
				if (is_array($pxids) && !empty($pxids)) {
					$result	=	$this->delTrain(pylode(',', $pxids));
				}
				if (is_array($gqids) && !empty($gqids)) {
					$result	=	$this->delgq(pylode(',', $gqids));
				}
				if (is_array($comaccids) && !empty($comaccids)) {
					$result	=	$this->delete_all('company_account', array('uid' => array('in', pylode(',', $comaccids))),'');
				}
			}
            $return['errcode']  =   $result ? 9 : 8;
            $return['msg']      =   $result ? '会员删除成功' : '会员删除失败';
            
        } else {
            
            $return['msg']      =   '请选择您要删除的会员';
            $return['errcode']  =   '8';
        }
        return $return;
    }
	/**
	 * 小程序和app账号绑定（微信、QQ、新浪微博）
	 */
	public function loginBind($data)
	{
		if(!empty($data)){
		    
		    if (empty($data['openid'])){
		        $return['error']  =  2;
		        $return['msg']	  =  '参数异常，绑定失败';
	            return $return;
		    }
		    $uni   =  'wxapp';
			$openid  =  $data['openid'];
			$field   =  '`uid`,`username`,`password`,`salt`,`usertype`';
			    
			if ($data['type'] == 'weixin'){
			    
			    if ($data['provider'] == 'app'){
			        // app内
			        $field  .=  ',`app_wxid`,`unionid`';
			        $up      =  array('app_wxid'=>$openid);
			        $uni     =  'APP/微信';
			    }else{
			        // 微信小程序内
			        $field  .=  ',`wxopenid`,`unionid`';
			        $up      =  array('wxopenid'=>$openid);
			        $uni     =  '微信小程序';
			    }
			    if (!empty($data['unionid'])){
			        $up['unionid'] = $data['unionid'];
			    }
			    
			}elseif ($data['type'] == 'baidu'){
                $field  .=  ',`bdopenid`';
                $up = array('bdopenid'=>$openid);
                $uni = "百度小程序";
            }elseif ($data['type'] == 'qq'){
			    
			    $field  .=  ',`qqid`,`qqunionid`';
			    $up      =  array('qqid'=>$openid,'qqunionid'=> !empty($data['unionid']) ? $data['unionid'] : '');
			    if ($data['provider'] == 'app'){
			        $uni     =  'APP/QQ';
			    }else{
			        $uni     =  'QQ';
			    }
			    
			}elseif ($data['type'] == 'sinaweibo'){
			    
			    $field  .=  ',`sinaid`';
			    $up      =  array('sinaid'=>$openid);
			    if ($data['provider'] == 'app'){
			        $uni     =  'APP/weibo';
			    }else{
			        $uni     =  'weibo';
			    }
			}
			$user  =  $this->select_once('member', array('uid'=>$data['uid']), $field);
			
			if (isset($up)){
			    
			    $nid  =  $this->upInfo(array('uid'=>$user['uid']),$up);
			    
			    if ($data['type'] == 'weixin' && $data['provider'] == 'weixin' && !empty($data['unionid']) && empty($this->config['mini_wxopen'])){
			        // 微信小程序内登录的，已绑定开放平台的，处理微信小程序绑定微信开放平台状态
			        $new_config = array('mini_wxopen'=>1);
			        
			        include 'config.model.php';
			        $configM  =  new config_model($this->db, $this->def);
			        $configM->setConfig($new_config);
			        // 重新生成config.php缓存
			        $configM->makeConfig();
			    }
			    require_once ('log.model.php');
			    $LogM = new log_model($this->db, $this->def);
			    $LogM->addMemberLog($user['uid'], $user['usertype'], $uni.'绑定成功');
			    
			    // 清空该账号的其他绑定账号
			    $upWhere = array('uid'=>array('<>',$user['uid']));
			    if ($data['type'] == 'weixin'){
			        
			        if (!empty($data['unionid']) && $data['unionid'] != $user['unionid']){
			            
			            $upWhere['PHPYUNBTWSTART']  =  '';
			            $upWhere['unionid']		    =  $data['unionid'];
			            if ($data['provider'] == 'app'){
			                // app内
			                $upWhere['app_wxid']  =  array('=',$openid,'OR');
			            }else{
			                // 微信小程序内
			                $upWhere['wxopenid']  =  array('=',$openid,'OR');
			            }
			            $upWhere['PHPYUNBTWEND']  =   '';
			        }else {
			            if ($data['provider'] == 'app'){
			                // app内
			                $upWhere['app_wxid']  =  $openid;
			            }else{
			                // 微信小程序内
			                $upWhere['wxopenid']  =  $openid;
			            }
			        }
			        $clear = array('wxid'=>'','app_wxid'=>'','wxopenid'=>'','unionid'=>'');
			        
			    }elseif ($data['type'] =='baidu'){
			        
			        $upWhere['bdopenid']  =  $openid;
			        
			        $clear = array('bdopenid'=>'');
			        
			    }elseif ($data['type'] == 'qq'){
			        
			        if (!empty($data['unionid']) && $data['unionid'] != $user['qqunionid']){
			            
			            $upWhere['PHPYUNBTWSTART']  =  '';
			            $upWhere['qqunionid']  =  $data['unionid'];
			            $upWhere['qqid']	   =  array('=',$openid,'OR');
			            $upWhere['PHPYUNBTWEND']  =   '';
			            
			            $clear = array('qqid'=>'','qqunionid'=>'');
			            
			        }else {
			            $upWhere['qqid']  =  $openid;
			            
			            $clear = array('qqid'=>'');
			        }
			        
			    }elseif ($data['type'] == 'sinaweibo'){
			        
			        $upWhere['sinaid']  =  $openid;
			        
			        $clear = array('sinaid'=>'');
			    }else{
			        // 参数错误，清除清理查询条件
			        $upWhere = array();
			    }
			    
			    if (!empty($upWhere) && !empty($clear)){
			        
			        $bm = $this->select_all('member', $upWhere, '`uid`,`usertype`');
			        if (!empty($bm)){
			            $bmuid = array();
			            foreach ($bm as $bv){
			                $bmuid[] = $bv['uid'];
			                $LogM->addMemberLog($bv['uid'], $bv['usertype'], '在'.$uni.'解除绑定，绑定到新账号(ID:'.$user['uid'].')');
			            }
			            
			            $this->upInfo(array('uid'=>array('in', pylode(',', $bmuid))), $clear);
			        }
			    }
			}
			if(isset($nid)){
				$return['error']	=  0;
				$return['msg']    =  '';
				$token		 	=  md5($user['username'].$user['password'].$user['salt'].$user['usertype']);
				$return['user']	=  array('uid'=>$user['uid'],'usertype'=>$user['usertype'],'token'=>$token);
			}else{
				$return['error']	=  2;
				$return['msg']	=  '绑定失败';
			}
			return $return;
		}
	}
	/**
	 * 小程序和app第三方登录检测（微信、QQ、新浪微博）
	 */
	public function loginCheck($data)
	{
	    
	    if ($data['type'] == 'weixin'){
	        
	        if ($data['provider'] == 'app'){
	            // app内微信登录
	            if (!empty($data['unionid'])){
	                
	                $where  =  array('unionid'=>$data['unionid'], 'app_wxid' => array('=', $data['openid'], 'OR'));
	                
	            }else{
	                $where  =  array('app_wxid'=>$data['openid']);
	            }
	            $uni  =  'APP/微信';
	        }else{
	            // 微信小程序内微信登录
	            if (!empty($data['unionid'])){
	                
	                $where  =  array('unionid'=>$data['unionid'], 'wxopenid' => array('=', $data['openid'], 'OR'));
	                
	            }else{
	                $where  =  array('wxopenid'=>$data['openid']);
	            }
	            $uni  =  '微信小程序';
	        }
	    }elseif($data['type']=='baidu'){
            // 百度小程序内百度登录
            $where  =  array('bdopenid'=>$data['openid']);
        }elseif ($data['type'] == 'qq'){
	        
	        if (!empty($data['unionid'])){
	            
	            $where  =  array('qqunionid'=>$data['unionid']);
	            
	        }else{
	            
	            $where  =  array('qqid'=>$data['openid']);
	        }
	        $uni  =  'APP/QQ';
	    }elseif ($data['type'] == 'sinaweibo'){
	        
	        $where  =  array('sinaid'=>$data['openid']);
	        $uni  =  'APP/weibo';
	    }
	    
	    $userinfo  =  $this->getInfo($where,array('field'=>'uid,username,password,salt,usertype,login_date,status'));
	    
	    if (!empty($userinfo)){
	        
            if($userinfo['status']=='2'){
                $return['error']  =  3;
                $return['msg']    =  '您的账号已被锁定';
                return $return;
            }
            
            $time	  =	time();
            $ip 	  =	fun_ip_get();
            $upLogin  =  array(
                'login_ip'    =>  $ip,
                'login_date'  =>  $time,
                'login_hits'  =>  array('+', 1)
            );
            if (!empty($data['clientid'])){
                $upLogin['clientid']     =  $data['clientid'];
                $upLogin['deviceToken']  =  $data['deviceToken'];
                //清除其他账号clientid
                $this->clearPushId($data['clientid'], $userinfo['uid']);
            }
            if ($data['provider'] == 'app'){
                // app内微信登录
                $upLogin['app_wxid'] = $data['openid'];
            }else{
                // 微信小程序内微信登录
                $upLogin['wxopenid'] = $data['openid'];
            }
            if (!empty($data['unionid'])){
                $upLogin['unionid'] = $data['unionid'];
            }
            $this->upInfo(array('uid'=>$userinfo['uid']), $upLogin);

            if ($userinfo['usertype'] > 0){

                //  同步登录时间
                $this->update_once('company', array('login_date' => time()), array('uid' => $userinfo['uid']));
                $this->update_once('resume', array('login_date' => time()), array('uid' => $userinfo['uid']));

                //会员日志，记录手动登录
                require_once ('log.model.php');
                $LogM   =   new log_model($this->db, $this->def);
                $LogM->addMemberLog($userinfo['uid'],$userinfo['usertype'], $uni. '登录成功');

                // 有身份类型的记录登录日志、加登录积分
                $logtime	=	date('Ymd',$userinfo['login_date']);
                $nowtime	=	date('Ymd',$time);
                if($logtime!=$nowtime){
                    require_once 'integral.model.php';
                    $IntegralM  =   new integral_model($this->db, $this->def);
                    $IntegralM -> invtalCheck($userinfo['uid'],$userinfo['usertype'],'integral_login','会员登录',22);
                    
                    //登录日志
                    $logindata = array(
                        'uid'      => $userinfo['uid'],
                        'usertype' => $userinfo['usertype']
                    );
                    $LogM->addLoginlog($logindata, $data);
                }
            }
            
            $token  =  md5($userinfo['username'].$userinfo['password'].$userinfo['salt'].$userinfo['usertype']);
            
            $return['error']   =  $userinfo['usertype'] > 0 ? 0 : 1;
            $return['errmsg']  =  '';
            $return['user']	   =  array('uid'=>$userinfo['uid'],'usertype'=>$userinfo['usertype'],'token'=>$token);
            
            if ($data['provider'] == 'weixin' && !empty($data['unionid']) && empty($this->config['mini_wxopen'])){
                // 微信小程序内登录的，已绑定开放平台的，处理微信小程序绑定微信开放平台状态
                $new_config = array('mini_wxopen'=>1);
                
                include 'config.model.php';
                $configM  =  new config_model($this->db, $this->def);
                $configM->setConfig($new_config);
                // 重新生成config.php缓存
                $configM->makeConfig();
            }
	    }else{
	        
	        if (!empty($data['phoneEncrypt']) && !empty($data['phoneIv'])){
	            // 如果传了微信手机号解密参数(属于微信小程序)
	            $return  =  $this->decodePhoneNumber($data);
	            
	        }else{
	            
	            if(!empty($data['cnewcount'])){
	                if ($data['type'] == 'weixin' && $data['provider'] == 'weixin'){
	                    $provider = 'wxxcx';
	                }else{
	                    $provider = $data['provider'];
	                }
	                $return  =  $this->fastReg($data, $provider, $data['type']);
	            }else{
	            	$return['error']  =  2;
                	$return['msg']    =  '';
                	$return['user']   =  array();
	            }
	        }
		}
		return $return;
	}
	/**
	 * 微信小程序通过解密getPhoneNumber接口参数，来获取手机号。 然后检测是否绑定账号，没绑定的，自动注册账号
	 */
	public function decodePhoneNumber($data = array()){
	    
	    $iv             =  $data['phoneIv'];
	    $encryptedData  =  $data['phoneEncrypt'];
	    //解密手机号
	    include APP_PATH."/api/wxapp/PHP/wxBizDataCrypt.php";
	    $pc = new wxBizDataCrypt($data['appid'], $data['session_key']);
	    
	    $errCode = $pc->decryptData($encryptedData,$iv,$res);
	    
	    if($errCode !== 0){
	        
	        $return['error']   =  $errCode;
	        $return['errmsg']  =  '数据异常，请稍后重试';
	        
	    }else{
	        //根据手机号查询已有数据，如没有则注册新账号
	        $res    =  json_decode($res,true);
	        $phone  =  $res['purePhoneNumber'];
	        if(!$phone || $phone==''){
	            
	            $return['error']   =  2;
	            $return['errmsg']  =  '微信绑定手机号错误';
	            
	        }else{
	            
	            $user  =  $this->select_once('member', array('moblie'=>$phone),'`uid`,`usertype`');
	            
	            if (!empty($user)){
	                //已有账号，绑定微信
	                $data['uid']  =  $user['uid'];
	                if($user['usertype']==1 || $user['usertype']==2 || $user['usertype']==0){
	                    
	                    $return   =  $this->loginBind($data);
	                    
	                }else{
	                    
	                    $return['error']   =  -1;
	                    $return['errmsg']  =  "只能登录个人或企业身份账号";
	                }
	            }else{
	            
	                $wdata  =  array(
	                    'moblie'    =>  $phone,
	                    'openid'    =>  $data['openid'],
	                    'unionid'   =>  $data['unionid'],
	                    'source'    =>  $data['source']
	                );
	                $return  =  $this->fastReg($wdata, 'wxxcx');
	            }
	        }
	    }
	    return $return;
	}
	//申请切换用户列表
	public function getUserChangeList($where,$data=array()){
		$usertype	=	array('1'=>'个人会员','2'=>'企业会员','3'=>'猎头会员','4'=>'培训会员');
		$field  =	empty($data['field']) ? '*' : $data['field'];
		$rows	=	$this->select_all('user_change',$where,$field);
		
		if(is_array($rows) && $rows){
			foreach($rows as $val){
				$memberid[]	=	$val['uid'];
			}
			$member	=	$this->select_all('member',array('uid'=>array('in',pylode(',',$memberid))),'`uid`,moblie');
			foreach($rows as $k=>$v){
				$rows[$k]['pres_usertype']		=		$usertype[$v['pres_usertype']];
				$rows[$k]['apply_usertype']		=		$usertype[$v['apply_usertype']];
				foreach($member as $val){
					if($v['uid']==$val['uid']){
						$rows[$k]['moblie']		=		$val['moblie'];
					}
				}

			}
		}
		return $rows;
	}

	public function addUserChange($addData=array()){
		$return	=	$this	->	insert_into('user_change',$addData);
		return	$return;
	}
	public function upusChange($whereData=array(),$upData=array()){

		$return	=	$this	->	update_once('user_change',$upData,$whereData);
		return	$return;
	}
	// 获取账户信息
	function getUserChangeInfo($where,$data=array()){

		$field  =	empty($data['field']) ? '*' : $data['field'];

		$rows =   $this -> select_once('user_change',$where, $field);
				
		return $rows;
	
	}
	function upAllUserChange($idarr,$data=array(), $port = null){

		$status		=	$data['status'];

		if(!empty($idarr)){

			$rows	=	$this->select_all('user_change',array('id'=>array('in',pylode(',',$idarr)),'status'=>array('<>',1)));

			$ids	=	array();
			$uidarr =	array();
			foreach($rows as $k=>$v){
				$ids[]		=	$v['id'];
				$uidarr[]	=	$v['uid'];
			}

			$nid			=	$this->update_once('user_change',$data,array('id'=>array('in',pylode(',',$ids))));

			if($nid){
				//审核通过
				$mems		=	$this->select_all('member',array('uid'=>array('in',pylode(',',$uidarr))),'`uid`,`moblie`');

				$mobliearr	=	array();

				foreach($mems as $mk=>$mv){

					$mobliearr[$mv['uid']]	=	$mv['moblie'];

				}

				$ucarr		=	$this->select_all('user_change',array('id'=>array('in',pylode(',',$ids))));

				foreach($ucarr as $uk=>$uv){

					$this->actUserchange($uv['id'],$uv['uid'],$uv['apply_usertype'],$uv['name'],$status,$mobliearr[$uv['uid']], $port);

				}
				$return['msg']      =  '转换会员审核成功';
				$return['errcode']  =  9;
				
				
			}else{
				//审核失败
				$return['msg']      =  '转换会员审核失败';
	            $return['errcode']  =  8;
			}

		}else{
			$return['msg']      =  '请选择要转换的用户';
            $return['errcode']  =  8;
		}
		return $return;
	}
	//审核
	function upUserChange($id,$uid,$moblie,$data=array(), $port = null){
		$status			=		$data['status'];
		$nid			=		$this->update_once('user_change',$data,array('id'=>$id));
		if($nid){
			//审核通过
			$userwhere['id']	=			$id;
			$userwhere['uid']	=			$uid;
			$userows			=			$this->getUserChangeInfo($userwhere);
			if($userows){
				$this->actUserchange($id,$uid,$userows['apply_usertype'],$userows['name'],$status,$moblie, $port);
				$return['msg']      =  '转换会员(ID:'.$id.')审核成功';
				$return['errcode']  =  9;
			
			}else{
				$return['msg']      =  '转换会员数据不存在';
				$return['errcode']  =  8;
			}
		}else{
			//审核失败
			$return['msg']      =  '转换会员(ID:'.$id.')审核失败';
            $return['errcode']  =  8;
		}
		return $return;
	}
	/**
	 * 身份切换
	 * $data     处理的数据
	 * $data['uid']
	 * $data['usertype'] 需要切换成的身份
	 */
	public function changeUsertype($data = array()){
	    $return				=	array(
	        'errcode'		=>	8,
	        'msg'			=>	''
	    );
	    
	    $uid				=	intval($data['uid']);
	    $usertype			=	intval($data['usertype']);
	    
	    if(!$uid){
	        $return['msg']	=	'请先登录!';
	        return $return;
	    }
	    //判断是否有子账户
	    if(!empty($data['spid'])){
	        $return['msg']	=	'当前为子账户，不支持切换!';
	        return $return;
	    }
	    //参数判断
	    if(!in_array($usertype, array(1, 2, 3, 4))){
	        $return['msg']	=	'无法转换成此身份!';
	        return $return;
	    }
	    
	    //先获取uid信息
	    $memField			=	array('field' => '`uid`,`username`, `usertype`, `pid`, `email`, `moblie`, `address`,`salt`,`email`,`password`,`did`,`moblie_status`,`email_status`,`did`');
	    
	    $memInfo			=	$this -> getInfo(array('uid' => $uid), $memField);
	    if(empty($memInfo)){
	        $return['msg']	=	'数据错误!';
	        return $return;
	    }
	    
	    //判断转换的身份 相同身份切换 直接返回成功，常见于同浏览器多窗口切换 或 后台管理员切换
	    if(empty($usertype) || $usertype == $memInfo['usertype']){
	        
	        $return				=	array(
	            'errcode'		=>	9,
	            'msg'			=>	'ok',
	            'memInfo'		=>	$memInfo
	        );
	        return $return;
	        
	    }
	    // 添加切换身份日志
	    $marr  =  array(
	        'uid'       =>  $uid,
	        'usertype'  =>  $usertype,
	        'content'   =>  '用户'.$memInfo['username'].'切换身份成功',
	        'opera'     =>  11,
	        'type'      =>  1,
	        'ip'        =>  fun_ip_get(),
	        'ctime'     =>  time(),
	        'did'       =>  $memInfo['did']
	    );
	    $this->insert_into('member_log',$marr);
	    // 根据切换的身份，来选择身份
	    $this->activUser($uid,$usertype,$memInfo);
	    
	    $return				=	array(
	        'errcode'		=>	9,
	        'msg'			=>	'ok',
	        'memInfo'		=>	$memInfo
	    );
	    return $return;
	}
    /**
     * 后台切换身份后处理
     */
	function actUserchange($id,$uid,$usertype,$username,$status,$moblie,$port = null)
	{
		
		require_once 'notice.model.php';
		$noticeM    =   new notice_model($this->db, $this->def);
		if($status==1){
			
			switch($usertype){
				case '1' : $table = 'resume';
				break;
				case '2' : $table = 'company';
				break;
				case '3' : $table = 'lt_info';
				break;
				case '4' : $table = 'px_train';
				break;
			}
		
			$existTable = $this->select_num($table,array('uid' => $uid));	
			if($existTable<1){
				$this -> activUser($uid,$usertype);
			}
			$this -> update_once('member', array('usertype' => $usertype), array('uid' => $uid));
		}
				
		include_once ('weixin.model.php');
		$Weixin	=	new weixin_model($this->db, $this->def);
		$userdata		=		array(
			'id'		=>		$id,
			'uid'		=>		$uid,
			'status'	=>		$status
		);
		$Weixin->sendWxUsercahnge($userdata);
		if($moblie){

			//发送短信
			$sendData['type']		=	'userchange';
			$sendData['moblie']		=	$moblie;
			if($status==1){
				$sendData['status']	=	'切换成功';
			}else{	
				$sendData['status']	=	'拒绝切换';
			}
			$sendData['port']		=	$port;
			
			$noticeM -> sendSMSType($sendData);
		}
	
	}
	/**
	 * 删除简历
	 * @param string $id    格式：单个，如1 ; 批量，如1,2,3
	 * @param array $data
	 */
	public function delUserChange($id){
	    
		if(!empty($id)){
            $return 		= array(
                'errcode'   => 8,
                'layertype' => 0,
                'msg'       => ''
            );
            
            if(is_array($id)){
                $ids    =	$id;
                $return['layertype']	=	1;
            }else{
                $ids    =   @explode(',', $id);
			}
			$id             =   pylode(',', $ids);

			
   
			$return['id']	=	$this -> delete_all('user_change',array('id' => array('in',$id)), '');

            $return['msg']		=	'申请转换会员信息(ID:'.pylode(',', $ids).')';
            $return['errcode']	=	$return['id'] ? '9' :'8';
            $return['msg']		=	$return['id'] ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }else{
            $return['msg']		=	'请选择您要删除的申请转换会员信息！';
            $return['errcode']	=	8;
        }
        
        return	$return;
	}

	
	/**
	* 用户申请切换身份校验
	* errcode 1：有条件不符并且有跳转链接 2：有错误提示无需跳转 3：拒绝 重新申请 5:需要填写申请理由 6：身份申请成功 等待审核 9：身份切换成功
	*/
	function checkChangeApply($uid,$usertype,$body=''){
	
		if(empty($uid)){
			$return['msg']		=	'请先登录';
			$return['url']		=	Url('login');
			$return['errcode']	=	1;
			
		}elseif($this -> config['sy_user_change'] !='1'){
		
			$return['msg']		=	'请联系管理员进行操作！';
			
			$return['errcode']	=	2;
		
		}else{
			$uid		=	(int)$uid;
			$usertype	=	(int)$usertype;	
			
			//获取账户基本信息
			$where['uid']		=		$uid;
		
			$user				=		$this->getInfo($where,array('field'=>'`usertype`,`username`,`salt`,`email`,`password`,`pid`,`wxopenid`,`wxid`,`did`'));
			
			if($user['usertype']>0){
				
				//查询是否有申请记录
				$cahnge	=	$this->getUserChangeInfo(array('uid' => $uid,'orderby'=>'id,desc'));
				
				//已经有申请记录的 禁止重复申请
				if(!empty($cahnge) && $cahnge['status']==0){
					
					$utypes					=	array('1'=>'个人会员','2'=>'企业会员','3'=>'猎头会员','4'=>'培训会员');
					$return['msg']			=	'您已申请'.$utypes[$cahnge['apply_usertype']].',请等待管理员审核';
					
					$return['wxopenid']		=	$user['wxopenid'];
					$return['wxid']			=	$user['wxid'];
					$return['errcode']		=	6;
				
				}else{

					//之前申请过并且被拒绝的 如果有body内容，则视为重新申请 
					if($cahnge['status']==2  && !$body){

						$return['msg']			=	'管理员已拒绝您的申请,原因：'.$cahnge['statusbody'];
						
						$return['errcode']		=	3;
						
					}else{
						
						
						if($this -> config['sy_change_noshen'] != '1'){

							if($usertype == 1){
								$InfoNum =	$this -> select_num('resume',$where);
							}else if($usertype == 2){
								$InfoNum =	$this -> select_num('company',$where);
							}else if($usertype == 3){
								$InfoNum =	$this -> select_num('lt_info',$where);
							}else if($usertype == 4){
								$InfoNum =	$this -> select_num('px_train',$where);
							}
						}
						//免审核或已经审核过的可以直接切换
						if($InfoNum>0 || $this -> config['sy_change_noshen'] == '1'){
							
							$changeData['uid']		=	$uid;
							$changeData['usertype']	=	$usertype;
							$changeData['spid']		=	$user['pid'];

							$res	=	$this -> changeUsertype($changeData);

							if($res['errcode'] == 9){

								require_once('cookie.model.php');
								$cookieM  =  new cookie_model($this->db,$this->def);

								$cookieM -> add_cookie($uid, $user['username'], $user['salt'], $user['email'], $user['password'], $usertype, $this->config['sy_logintime'], $user['did']);

								$return['errcode']	=	9;
								
								$token  =  md5($user['username'].$user['password'].$user['salt'].$usertype);
								$return['user']		=	array('uid'=>$uid,'usertype'=>$usertype,'token'=>$token);
								
							}else{
								
								$return['msg']			=	$res['msg'];
								$return['errcode']		=	4;
							}	
							
						
						}else{
							//需要重新申请 如果有BODY字段 视为提交新申请 没有body则返回说明状态
							if($body != ''){
								
								$addData				=		array(
									'uid'				=>		$uid,
									'name'				=>		$user['username'],
									'did'				=>		$user['did'],
									'apply_usertype'	=>		$usertype,
									'pres_usertype'		=>		$user['usertype'],
									'applybody'			=>		$body,
									'apply_time'		=>		time(),
									'lastupdate'		=>		time(),
									'type'				=>		1,
									'state'				=>		0,
								);

								$this -> addUserChange($addData);
								
								$return['wxid']			=		$user['wxid'];
								$return['msg']			=		'申请成功，请等待管理员审核！';
								$return['errcode']		=		6;

							
							}else{
								
								$return['errcode']		=		5;//需要填写申请理由
							}
						}
					}
				}
			}else{
				$return['msg']		=	'请先完善基本信息或者退出登录选择新身份';
				$return['url']		=	$_SERVER['HTTP_REFERER'];
				$return['errcode']	=	1;
			}
		}

		return $return;
	
	}

    /**
     * 第三方登录绑定账号
     * @param array $data
     * @param string $type
     * @return array|string[]
     */
	function bindacount($data = array(),$type='')
    {

	    $username   =  $data['username'];
	    $return     =  array('msg'=>'系统繁忙','errcode'=>8);

	    require ('notice.model.php');
	    $noticeM    =  new notice_model($this->db, $this->def);

	    //会员已登录判断
	    if(!empty($data['uid'])  && $data['uid'] > 0 && $username!=''){

	        if($data['usertype']=='1'){
	            return array('msg'=>'您现在是个人会员登录状态!');
	        }elseif($data['usertype']=='2'){
	            return array('msg'=>'您现在是企业会员登录状态!');
	        }elseif($data['usertype']=='3'){
	            return array('msg'=>'您现在是猎头会员登录状态!');
	        }elseif($data['usertype']=='4'){
	            return array('msg'=>'您现在是培训会员登录状态!');
	        }
	    }
	    //验证码判断
	    if(!isset($data['provider'])){

	        $result =   $noticeM->jycheck($data['authcode'],'前台登录');
	        if(!empty($result)){
	            return array('msg'=>$result['msg'],'errcode'=>'8');
	        }
	    }
	    
	    if(CheckRegUser($username)==false && CheckRegEmail($username)==false && ($username!='')){
	        return array('msg'=>'用户名包含特殊字符或为空!','errcode'=>'8');
	    }
	    
	    $where  =  array('username'=> $username);
	    
	    if(CheckMobile($username)){

	        $where['PHPYUNBTWSTART']	=	'OR';
	        $where['moblie']		    =	$username;
	        $where['moblie_status']	    =	1;
	        $where['PHPYUNBTWEND']	    =	'';
	    }
	    //邮箱登录
	    if(CheckRegEmail($username)){
	        
	        $where['PHPYUNBTWSTART']	=	'OR';
	        $where['email']		        =	$username;
	        $where['email_status']	    =	1;
	        $where['PHPYUNBTWEND']	    =	'';
	    }
	    
	    $user  =  $this->getInfo($where);
	    
	    if (!empty($user)){

	        if($user['status']=='2'){
	            return array('msg'=>'您的账号已被锁定!','errcode'=>'8','url'=>Url('register',array('c'=>'ok','type'=>2),'1'));
	        }
	        //普通密码校验
	        $res  =  passCheck($data['password'],$user['salt'],$user['password']);
	        
	        if($res){

	            //cookie设置
	            if (!isset($data['provider'])){
	                
	                require_once('cookie.model.php');
	                $cookie  =  new cookie_model($this->db,$this->def);
	                $cookie->unset_cookie();
	                $cookie->add_cookie($user['uid'],$user['username'],$user['salt'],$user['email'],$user['password'],$user['usertype'],$this->config['sy_logintime'],$user['did']);
	            }
	            //会员登录信息变更
	            $ip       =  fun_ip_get();
	            $upLogin  =  array(
	                'login_ip'=>$ip,
	                'login_date'=> time(),
	                'login_hits' => array('+', 1)
	            );
	            if (isset($data['provider'])){
	                if (!empty($data['clientid'])){
	                    $upLogin['clientid']     =  $data['clientid'];
	                    $upLogin['deviceToken']  =  $data['deviceToken'];
	                    //清除其他账号clientid
	                    $this->clearPushId($data['clientid'], $user['uid']);
	                }
	            }
	            if($type=='weixin'){
	                if (isset($data['provider'])){
	                    if ($data['provider'] == 'app'){
	                        $upLogin['app_wxid']  =  !empty($data['openid']) ? $data['openid'] : '';
	                    }else{
	                        $upLogin['wxopenid']  =  !empty($data['openid']) ? $data['openid'] : '';
	                    }
	                }else{
	                    $upLogin['wxid']  =  !empty($data['openid']) ? $data['openid'] : '';
	                }
	                $upLogin['unionid']   =  !empty($data['unionid']) ? $data['unionid'] : '';
	                
	            }elseif ($type == 'qq'){
	                
	                $upLogin['qqid']       =  !empty($data['openid']) ? $data['openid'] : '';
	                $upLogin['qqunionid']  =  !empty($data['unionid']) ? $data['unionid'] : '';
	                
	            }elseif ($type == 'sinaweibo'){
	                
	                $upLogin['sinaid']  =  !empty($data['openid']) ? $data['openid'] : '';
	            }elseif ($type=="baidu"){
	                $upLogin['bdopenid']  =  !empty($data['openid']) ? $data['openid'] : '';
	            }
	            $this->upInfo(array('uid'=>$user['uid']), $upLogin);
	            
	            if(!empty($user['usertype'])){

	                //  同步登录时间
                    $this->update_once('company', array('login_date' => time()), array('uid' => $user['uid']));
                    $this->update_once('resume', array('login_date' => time()), array('uid' => $user['uid']));

	                //登录日志
	                if (isset($data['provider'])){
	                    if ($data['source'] == '3'){
	                        $state_content = 'app绑定账号';
	                    }elseif ($data['source'] == '13'){
	                        $state_content = '微信小程序绑定账号';
	                    }elseif ($data['source'] == '19'){
	                        $state_content = '百度小程序绑定账号';
	                    }
	                }elseif ($type=='weixin'){
	                    
	                    $state_content  =  $data['source'] == 1 ? 'PC绑定微信' : 'wap绑定微信';
	                }elseif ($type=='qq'){
	                    
	                    $state_content  =  $data['source'] == 1 ? 'PC绑定QQ' : 'wap绑定QQ';
	                }elseif ($type=='sinaweibo'){
	                    
	                    $state_content  =  $data['source'] == 1 ? 'PC绑定新浪微博' : 'wap绑定新浪微博';
	                }
	                //会员日志，记录手动登录
					require_once ('log.model.php');
					$LogM = new log_model($this->db, $this->def);
					$LogM->addMemberLog($user['uid'],$user['usertype'], $state_content. '登录成功');
					
	                $logtime					   	=		date('Ymd',$user['login_date']);
	                $nowtime					   	=		date('Ymd',time());
	                if($logtime!=$nowtime){
	                    
	                    //登录积分
	                    include_once ('integral.model.php');
	                    $integralM  =  new integral_model($this->db, $this->def);
	                    $integralM->invtalCheck($user['uid'],$user['usertype'],'integral_login','会员登录',22);
	                    
	                    // 登录日志
	                    $logdata['content']		=	$state_content;
	                    
	                    $logdata['uid']			=	$user['uid'];
	                    $logdata['usertype']	=	$user['usertype'];
	                    $logdata['did']			=	$user['did'];
	                    
	                    $LogM->addLoginlog($logdata);
	                }
	            }
	            
	            if(empty($user['usertype'])){
	                $return['errcode']			=		2;
	                $return['msg']				=		'';
	            }else{
	                
	                $return['errcode']		    =		9;
	                $return['msg']				=		'登录成功';
	            }
	            
	            if (isset($data['source'])){
	                // wap、pc所需跳转地址
	                if ($data['source'] == 2){
	                    $return['url']  =  Url('wap',array(),'member');
	                }elseif ($data['source'] == 1){
	                    $return['url']  =  $this->config['sy_weburl'].'/member/index.php';
	                }
	            }
	            // app/小程序， 需要token
	            if (isset($data['provider'])){
	                
	                if($type=='weixin' && $data['provider'] == 'weixin' && !empty($data['unionid']) && empty($this->config['mini_wxopen'])){
	                    // 微信小程序内登录的，已绑定开放平台的，处理微信小程序绑定微信开放平台状态
	                    $new_config = array('mini_wxopen'=>1);
	                    
	                    include 'config.model.php';
	                    $configM  =  new config_model($this->db, $this->def);
	                    $configM->setConfig($new_config);
	                    // 重新生成config.php缓存
	                    $configM->makeConfig();
	                }
	                
	                $token                      =       md5($user['username'].$user['password'].$user['salt'].$user['usertype']);
	                if($user['usertype'] > 0){
	                    $usertype				=		$user['usertype'];
	                }else{
	                    $usertype				=		0;
	                }
	                $return['user']				=		array('uid'=>$user['uid'],'usertype'=>$usertype,'token'=>$token);
	                if($user['pid']){
	                    $return['user']['spid'] =		1;
	                }
	            }
	            
	            return $return;
	        }else{
	            
	            return array('msg'=>'用户名或密码不正确！','errcode'=>'8');
	        }
	    }else{
	        return array('msg'=>'用户名或密码不正确！','errcode'=>'8');
	    }
	    return $return;
	}

    /**
     * 微信/QQ等直接登录注册
     * @param array $data
     * @param string $type
     * @param string $provider
     * @return mixed
     */
	function fastReg($data = array(), $type = '', $provider = 'weixin')
	{

	    // 微信小程序和百度小程序不需要验证
	    if($type != 'wxxcx' && $data['moblie']!=''){

	        // 验证手机号
			if(!CheckMobile($data['moblie'])){

				$return['msg']			=		'手机格式错误！';	
			}else{
                //检查手机号是否已存在 如果存在则直接绑定
				$mobileUser =   $this -> getInfo(array('moblie' => $data['moblie']));
			}
			
			if($return['msg']){
				$return['errcode']		=		8;
				return 		$return;
			}
			$regCertMobile				=   	$this->select_once('company_cert',array('type' => '2', 'check' => $data['moblie'],'orderby'=>'ctime,desc'), '`check2`,`ctime`');
		    
			include_once ('notice.model.php');
			$noticeM	=	new notice_model($this->db, $this->def);
			
			$codeTime					=		$noticeM->checkTime($regCertMobile['ctime']);
			
			if($data['moblie_code']==''){

				$return['msg']			=		'短信验证码不能为空！';
				$return['errcode']		=		8;
				return  $return;
			}elseif(!$codeTime){

				$return['msg']			=		'短信验证码验证超时，请重新点击发送验证码！';
				$return['errcode']		=		8;
				return  $return;
			}elseif($regCertMobile['check2']!=$data['moblie_code']){

				$return['msg']			=		'短信验证码错误！';
				$return['errcode']		=		8;
				return  $return;
			}
			if($this->config['sy_msg_regcode']=='1' || $type != ''){
				$needMsg 				= 		true;
			}
			if(!$needMsg){
    			
    			$result				    =		$noticeM->jycheck($data['code'],'前台登录');

    			if(!empty($result)){
    				
    				$return['msg']	    =		$result['msg'];
    				$return['errcode']  =		8;
    				return  $return;
    			}
    		}
		}
		if(!empty($mobileUser['uid'])){
		    //直接绑定该账户
		    if($mobileUser['status']=='2'){

			    $return['msg']		    =		'当前手机号对应账户已被锁定！';
    			$return['errcode']		=		8;
		    }else{
		        
		        if ($provider == 'weixin'){
    	        
        	        if ($type != ''){
        	            if($type == 'app'){

        	                $mdata['app_wxid']  =  !empty($data['openid']) ? $data['openid'] : '';
        	                $loginType          = 'APP/微信';
        	            }else{
        	                $mdata['wxopenid']  =  !empty($data['openid']) ? $data['openid'] : '';
        	                $loginType          = '微信小程序';
        	            }
        	        }else{
        	            $mdata['wxid']  =  !empty($data['openid']) ? $data['openid'] : '';
        	            $loginType      = '微信公众号';
        	        }
        	        $mdata['unionid']   =  !empty($data['unionid']) ? $data['unionid'] : '';
        	        
        	    }elseif ($provider == 'qq'){
        	        
        	        $mdata['qqid']      =  !empty($data['openid']) ? $data['openid'] : '';
        	        $mdata['qqunionid'] =  !empty($data['unionid']) ? $data['unionid'] : '';
        	        $loginType          = 'QQ';
        	        
        	    }elseif ($provider == 'sinaweibo'){
        	        
        	        $mdata['sinaid']    =  !empty($data['openid']) ? $data['openid'] : '';
        	        $loginType          = 'weibo';
        	    }
        	    
        	    //更新登录信息
				
				$ip						=	fun_ip_get();
				$mdata['login_ip']		=	$ip;
				$mdata['login_date']	=	time();
				$mdata['login_hits']	=	array('+', 1);

				if ($type == 'app'){
					if (!empty($data['clientid'])){
						$mdata['clientid']     =  $data['clientid'];
						$mdata['deviceToken']  =  $data['deviceToken'];
						//清除其他账号clientid
						$this->clearPushId($data['clientid'], $mobileUser['uid']);
					}
				}
				//更新绑定 登录信息
        	    $this->upInfo(array('uid'=>$mobileUser['uid']),$mdata);	
				
				if(!empty($mobileUser['usertype'])){

                    //  同步登录时间
                    $this->update_once('company', array('login_date' => time()), array('uid' => $mobileUser['uid']));
                    $this->update_once('resume', array('login_date' => time()), array('uid' => $mobileUser['uid']));

                    //会员日志，记录手动登录
				    require_once ('log.model.php');
				    $LogM = new log_model($this->db, $this->def);
				    $LogM->addMemberLog($mobileUser['uid'],$mobileUser['usertype'], $loginType. '绑定账号短信登录成功');
				    
					$logtime					   	=		date('Ymd',$mobileUser['login_date']);
					$nowtime					   	=		date('Ymd',time());
					if($logtime!=$nowtime){
					    //登录积分
					    require_once ('integral.model.php');
					    $IntegralM 	= 	new integral_model($this -> db, $this -> def);
					    $IntegralM->invtalCheck($mobileUser['uid'],$mobileUser['usertype'],'integral_login','会员登录',22);
					    //登录日志
					    $logdata['uid']			=	$mobileUser['uid'];
					    $logdata['usertype']	=	$mobileUser['usertype'];
					    $logdata['did']			=	$mobileUser['did'];
					    
					    $LogM->addLoginlog($logdata, array('provider'=>$provider));
					}
				}

        	    if ($type == ''){
    	            // 非小程序/APP
    	            require_once('cookie.model.php');
    	            $cookie  =  new cookie_model($this->db,$this->def);
    	            $cookie->unset_cookie();
    	            $cookie->add_cookie($mobileUser['uid'], $mobileUser['username'], $mobileUser['salt'], $mobileUser['email'], $mobileUser['password'], $mobileUser['usertype'], $this->config['sy_logintime'], $mobileUser['did']);
    	         
    	        }else{
    	            // 小程序/APP
    	            $token          =   md5($mobileUser['username'].$mobileUser['password'].$mobileUser['salt'].$mobileUser['usertype']);
    	            $return['user'] =   array('uid'=>$mobileUser['uid'],'usertype'=>$mobileUser['usertype'],'token'=>$token);
    	            
    	            if ($type == 'wxxcx' && !empty($data['unionid']) && empty($this->config['mini_wxopen'])){
    	                // 微信小程序内登录的，已绑定开放平台的，处理微信小程序绑定微信开放平台状态
    	                $new_config =   array('mini_wxopen'=>1);
    	                
    	                include 'config.model.php';
    	                $configM    =   new config_model($this->db, $this->def);
    	                $configM->setConfig($new_config);
    	                // 重新生成config.php缓存
    	                $configM->makeConfig();
    	            }
    	        }
    	        
    	        $return['msg']		    =  '账户绑定成功！';
    	        $return['errcode'] 	    =  9;
    	        if ($type != ''){
    	            
    	        	$return['error']    = 1;
    	        }
		    }
		}else{
		    $ip     =  fun_ip_get();
    	    $time   =  time();
    	    $salt   =  substr(uniqid(rand()),-6);
    	    $rand   =  mt_rand(111111,999999);
    	    // 处理用户名
    	    if (!empty($data['moblie'])){
    	        
    	        $username       =  $data['moblie'];
    	    }else{
    	        
    	        if ($provider == 'weixin'){
    	            
    	            $username   =  'wxid_'.$time.$rand;
    	        }elseif ($provider == 'qq'){
    	            
    	            $username   =  'qqid_'.$time.$rand;
    	        }elseif ($provider == 'sinaweibo'){
    	            
    	            $username   =  'sinaid_'.$time.$rand;
    	        }
    	    }
    	    
    	    $mdata  =  array(
    	        'username'       =>  $username,
    	        'password'       =>  passCheck($rand,$salt),
    	        'salt'           =>  $salt,
    			'moblie'         =>  !empty($data['moblie']) ? $data['moblie'] : '',
    	        'moblie_status'  =>  !empty($data['moblie']) ? 1 : 0,
    	        'usertype'       =>  0,
    	        'reg_date'       =>  $time,
    	        'reg_ip'         =>  $ip,
    	        'login_date'     =>  $time,
    	        'login_ip'       =>  $ip,
    	        'status'         =>  1,
    	        'source'         =>  $data['source'],
    	        'clientid'       =>  !empty($data['clientid']) ? $data['clientid'] : '',
    	        'deviceToken'    =>  !empty($data['deviceToken']) ? $data['deviceToken'] : '',
    	        'did'            =>  $this->config['did']
    	    );
    	    if ($provider == 'weixin'){
    	        
    	        if ($type != ''){
    	            if($type == 'app'){
    	                $mdata['app_wxid']  =  !empty($data['openid']) ? $data['openid'] : '';
    	            }else{
    	                $mdata['wxopenid']  =  !empty($data['openid']) ? $data['openid'] : '';
    	            }
    	        }else{
    	            $mdata['wxid']  =  !empty($data['openid']) ? $data['openid'] : '';
    	        }
    	        $mdata['unionid']   =  !empty($data['unionid']) ? $data['unionid'] : '';
    	        
    	    }elseif ($provider == 'qq'){
    	        
    	        $mdata['qqid']       =  !empty($data['openid']) ? $data['openid'] : '';
    	        $mdata['qqunionid']  =  !empty($data['unionid']) ? $data['unionid'] : '';
    	        
    	    }elseif ($provider == 'sinaweibo'){
    	        
    	        $mdata['sinaid']  =  !empty($data['openid']) ? $data['openid'] : '';
    	    }
    	    $userid  =  $this->insert_into('member', $mdata);
    	    
    	    if ($userid){
    	        
    	        //处理注册赠送优惠券
    	        if($this->config['reg_coupon']){
    	            $coupon						=		$this->select_once('coupon',array('id'=>$this->config['reg_coupon']));
    	            $cdata['uid']				=		$userid;
    	            $cdata['number']			=		$time;
    	            $cdata['ctime']				=		$time;
    	            $cdata['coupon_id']			=		$coupon['id'];
    	            $cdata['coupon_name']		=		$coupon['name'];
    	            $cdata['validity']			=		$time+$coupon['time']*86400;
    	            $cdata['coupon_amount']		=		$coupon['amount'];
    	            $cdata['coupon_scope']		=		$coupon['scope'];
    	            $this->insert_into('coupon_list',$cdata);
    	        }
    	        if ($type == ''){
    	            // 非小程序/APP
    	            require_once('cookie.model.php');
    	            $cookie  =  new cookie_model($this->db,$this->def);
    	            $cookie->unset_cookie();
    	            $cookie->add_cookie($userid, $mdata['username'], $salt, '', $mdata['password'], '', $this->config['sy_logintime'], $mdata['did']);
    	            
    	        }else{
    	            // 小程序/APP
    	            $token                      =       md5($mdata['username'].$mdata['password'].$salt.'0');
    	            $return['user']             =       array('uid'=>$userid,'usertype'=>0,'token'=>$token);
    	        }
    	        
    	        $return['msg']		=  '注册成功';
    			
    			$return['errcode'] 	=   9;
    	        if($type != ''){
    	        	$return['error']=   1;
    	        }
    	        
    	        $return['uid']      =  $userid;
    	        
    	    }else{
    
    	        $return['msg']		=  '注册失败';
    	        $return['errcode']  =  8;
    			//增加错误日志
    			$this -> addErrorLog('', 1,$return['msg']);
    	    }
		    
		}
		if ($type == 'wxxcx' && !empty($data['unionid']) && empty($this->config['mini_wxopen'])){
		    // 微信小程序内登录的，已绑定开放平台的，处理微信小程序绑定微信开放平台状态
		    $new_config = array('mini_wxopen'=>1);
		    
		    include 'config.model.php';
		    $configM  =  new config_model($this->db, $this->def);
		    $configM->setConfig($new_config);
		    // 重新生成config.php缓存
		    $configM->makeConfig();
		}
	    if ($type != '' && $return['errcode']  ==  8){
	        
	        $return['error']  =  -1;
	        $return['errmsg']   =  $return['msg'];
	        $return['user']     =  array();
	        unset($return['msg']);
	    }
	    return $return;
	}
	/**
	 * 清除其他账号绑定的app推送标识
	 */
	function clearPushId($clientid, $uid = ''){
	    if (!empty($clientid)){
	        if ($uid == ''){
	            $this->update_once('member', array('clientid'=>'', 'deviceToken'=>''),array('clientid'=>$clientid));
	        }else{
	            $appmember  =  $this->select_all('member',array('clientid'=>$clientid,'uid'=>array('<>',$uid)),'uid');
	            if (!empty($appmember)){
	                $appuid = array();
	                foreach ($appmember as $v){
	                    $appuid[] = $v['uid'];
	                }
	                $this->update_once('member',array('clientid'=>'','deviceToken'=>''),array('uid'=>array('in',pylode(',', $appuid))));
	            }
	        }
	    }
	}
}
?>