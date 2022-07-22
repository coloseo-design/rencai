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
class ajax_controller extends common{
	// wapadmin使用
	function wap_job_action(){
		include(PLUS_PATH."job.cache.php");
		
		$data	=	"<option value=''>--请选择--</option>";
		
		if(is_array($job_type[$_POST['id']])){
			foreach($job_type[$_POST['id']] as $v){
				$data	.=	"<option value='$v'>".$job_name[$v]."</option>";
			}
		}
		echo $data;
	}
	// wapadmin使用
	function wap_city_action(){
	    include(PLUS_PATH."city.cache.php");
	    
	    if(is_array($city_type[$_POST['id']])){
	        $data	=	"<option value=''>--请选择--</option>";
	        foreach($city_type[$_POST['id']] as $v){
	            $data	.=	"<option value='$v'>".$city_name[$v]."</option>";
	        }
	    }
	    echo $data;
	}
	/**
	 * 简历详情
	 * 面试邀请
	 * 2019-06-22
	 */
	function sava_ajaxresume_action(){
		
		$jobM		=	$this -> MODEL('job');

		$_POST		=	$this -> post_trim($_POST);
		$_POST['port']	=	'2';
		$fidArr		=	array(
			'fuid'		=>	$this -> uid,
			'spid'		=>	$this -> spid,	//	子账号UID
			'fusername'	=>	$this -> username,
			'fusertype'	=>	$this -> usertype
		);

		$res		=	$jobM -> addYqmsInfo(array_merge($fidArr, $_POST));
		echo json_encode($res);
		die;
	}
	/**
	 * 下载简历（查看联系方式）
	 * 2019-06-24
	 */
	function forlink_action(){
		$downReM		=	$this -> MODEL('downresume');
		$data			=	array(
			'eid'		=>	$_POST['eid'],
		    'uid'		=>	$this -> uid,
		    'spid'		=>	$this -> spid,
		    'usertype'	=>	$this -> usertype,
			'utype'		=>	'wap',
			'did'		=>	$this -> userdid,
		);
		$downRes		=	$downReM -> downResume($data);
		
		$downRes['usertype']	 =	$this->usertype;
		if(!empty($downRes['msgList'])){
		    $downRes['msgList']  =  $downRes['msgList']['wxapp'];
		}
		echo json_encode($downRes);die;

	}

    //加入人才库（收藏简历）
	function talentpool_action(){
		
		$data		=	array(
			'eid'		=>	$_POST['eid'],
			'cuid'		=>	$this->uid,
			'usertype'	=>	$this->usertype,
			'uid'		=>	(int)$_POST['uid'],
		);
		
		$ResumeM	=	$this->MODEL('resume');
	    $return		=	$ResumeM -> addTalent($data);

		echo json_encode($return);die;
	}
    // 邀请面试
    function indexajaxresume_action()
    {
        
        if ($_POST) {
            
            $M                  =   $this->MODEL('comtc');
            
            $_POST['uid']       =   $this->uid;
            $_POST['spid']      =   $this->spid;
            $_POST['username']  =   $this->username;
            $_POST['usertype']  =   $this->usertype;
            
            $return             =   $M->invite_resume($_POST);
            if ($return['status']) {
                $return['msgList']  =   $return['msgList']['wxapp'];
                echo json_encode($return);
                die();
            }
        }
    }
    
	//签到，TODO:会员中心
	function sign_action(){
		
	    $arr = array('type' => -2);
	    
		if($_POST['rand']){
			$IntegralM	=	$this -> MODEL('integral');
		
			$userinfoM	=	$this -> MODEL('userinfo');
			
			$date		=	date("Ymd");
			
			$member		=	$userinfoM -> getInfo(array('uid'=>$this->uid,'usertype'=>$_COOKIE['usertype']),array('field'=>"`signday`,`signdays`"));
			
			$lastreg	=	$userinfoM -> getMemberregInfo(array('uid'=>$this->uid,'usertype'=>$_COOKIE['usertype'],'orderby'=>'id,desc'));
			
			$lastregdate=	date("Ymd",$lastreg['ctime']);
			
			if($lastregdate!=$date){
				
				$yesterday	=	date("Ymd",strtotime("-1 day"));
				
				if($lastregdate==$yesterday&&intval(date("d"))>1){
					
					if($member['signday']>=5){
						
						$integral	=	$this->config['integral_signin']*2;
						
					}else{
						
						$integral	=	$this->config['integral_signin'];
						
					}
					$signday	=	$member['signday']+1;
					
					$msg		=	'连续签到'.$signday."天";
					
				}else{
					$signday	=	'1';
					
					$integral	=	$this->config['integral_signin'];
					
					$msg		=	'第一次签到';
					
				}
				$arr	=	array();
				
				$nid	=	$userinfoM -> addMemberreg(array("uid"=>$this->uid,"usertype"=>$this->usertype,'date'=>$date,"ctime"=>time(),'ip'=>fun_ip_get()));
				
				if($nid){
					
				    $IntegralM->company_invtal($this->uid,$this->usertype,$integral,true,$msg,true,2,'integral');
					
					$userinfoM -> upInfo(array('uid'=>$this->uid),array('signday'=>$signday,'signdays'=>array('+','1')));
					
					$arr['type']=date("j");
					
				}else{
					
					$arr['type']=-2;
					
				} 
				$arr['integral']	=	$integral.$this->config['integral_pricename'];
				
				$arr['signday']		=	$signday;
				
				$arr['signdays']	=	$member['signdays']+1;
				
			}
			echo json_encode($arr);die;
		}
	}
	//邮箱认证,发送邮件，TODO:会员中心
	function emailcert_action()
    {
        $ComapnyM   =   $this->MODEL('company');

        session_start();

        $code       =   $_POST['authcode'];

        if (md5(strtolower($code)) != $_SESSION['authcode'] || empty($_SESSION['authcode'])) {

            echo json_encode(array('error' => 2, 'msg' => '图片验证码不正确'));
            die();
        }

        $data       =   array(
            'usertype'  =>  $this->usertype,
            'did'       =>  $this->userid,
            'email'     =>  $_POST['email']
        );

        $errCode    =   $ComapnyM->sendCertEmail(array('uid' => $this->uid, 'type' => '1'), $data);

        echo json_encode(array('error' => $errCode ? 0 : 2, 'msg' => $errCode ? '' : '发送失败'));
        die();
    }
	
	
	//手机认证,发送短信，TODO:会员中心
	function mobliecert_action(){
	    $logM			=	$this->MODEL('log');
		$noticeM 		= 	$this->MODEL('notice');
		
		$result			=		$noticeM->jycheck($_POST['code'],'');
		if(!empty($result)){
			$this->layer_msg($result['msg'], 9, 0, '', 2, $result['error']);
		}
	  
	    if(!$this->uid || !$this->username){
	        $this->layer_msg('请先登录', 9, 0, '', 2, 110);
	    }else{
	        $shell=$this->GET_user_shell($this->uid,$_COOKIE['shell']);
	        if(!is_array($shell)){
	            $this->layer_msg('登录有误', 9, 0, '', 2, 111);
	        }
	        $moblie = $_POST['str'];
	        $user 	= array(
	            'uid'      => $this->uid,
	            'usertype' => $this->usertype
	        );
	        
	        $result 		= $noticeM->sendCode($moblie, 'cert', 2, $user);
	        $logM -> addMemberLog($user['uid'], $user['usertype'], '手机认证验证码，认证手机号：'.$moblie, 13, 1);
			
	        echo json_encode($result);exit();
	    }
	}
	//注册会员，发送短信验证码，TODO:wap前台
	function regcode_action(){
		$noticeM 	= 	$this->MODEL('notice');
		$result		=	$noticeM->jycheck($_POST['code'],'注册会员');
		if(!empty($result)){
			$this->layer_msg($result['msg'], 9, 0, '', 2, $result['error']);
		}
	    $moblie		= 	trim($_POST['moblie']);
	    // 两种情况验证手机号是否被使用，改为在发送验证码时验证
	    // 1-用户名注册且实名认证，需要发送短信验证码
	    // 2-手机号注册，有极验/顶象验证码
	    if ($_POST['noblur']){
	        $registerM	=	$this->MODEL('register');
	        $return 	= 	$registerM->regMoblie(array('moblie'=>$moblie));
	        
	        if($return['errcode']==0){
	            
	            $result 	= 	$noticeM->sendCode($moblie, 'regcode',2);
	            
	            echo json_encode($result);exit();
	        }else{
	            echo json_encode($return);exit();
	        }
	    }else{
	        $result 	= 	$noticeM->sendCode($moblie, 'regcode', 2);
	        
	        echo json_encode($result);exit();
	    }
	}
	//快速申请职位入口
	function temporaryresume_action(){
		$userinfoM	=	$this->MODEL("userinfo");
		$companyM	=	$this->MODEL("company");
		$noticeM 	= 	$this->MODEL('notice');
		$jobM		=	$this->MODEL('job');
		$resumeM	=	$this->MODEL("resume");
		
		$_POST 		= 	$this->post_trim($_POST);
		
		$ismoblie	= 	$userinfoM->getMemberNum(array("moblie"=>$_POST['telphone']));

		if($ismoblie>0){
			$return['msg']	=	'当前手机号已被使用，请更换其他手机号！';
			echo json_encode($return);die;
		}else{
			
			if ($this->config['sy_msg_isopen']==1 && $this->config['sy_msg_regcode']==1 && $this->config['reg_real_name_check'] == 1) {
				if(!$_POST['checkcode']){
					$return['msg']	=	'请输入短信验证码！';
					echo json_encode($return);die;
				}
				
    			$cert_arr	= 	$companyM->getCertInfo(array('check'=>$_POST['telphone'],'type'=>2,'orderby'=>'ctime,desc'),array('`ctime`,`check2`'));
    			
				if (is_array($cert_arr)) {
    				
					$checkTime	= 	$noticeM->checkTime($cert_arr['ctime']);
					if ($checkTime) {
						 $res	= 	$_POST['checkcode'] == $cert_arr['check2'];

						 $udata['moblie_status']	=	1;
    				} else {
						$return['msg']	=	'验证码验证超时，请重新点击发送验证码！';
						echo json_encode($return);die;
    				}
    			} else {
					$return['msg']	=	'验证码发送不成功，请重新点击发送验证码！';
					echo json_encode($return);die;
    			}
			}else{
			    
			    $result  =  $noticeM->jycheck($_POST['authcode'],'注册会员');
			    
			    if(!empty($result)){
			        $return['error']  =  $result['error'];
			        $return['msg']	  =  $result['msg'];
			        echo json_encode($return);die;
			    }
			}

			$pwmsg = regPassWordComplex($_POST['password']);
			if($pwmsg){
				$return['msg']		=  $pwmsg;
			    echo json_encode($return);die;
			}

			$res = true;
			if($res){
				$salt 	= 	substr(uniqid(rand()), -6);
				$pass 	= 	passCheck($_POST['password'],$salt);
				$ip		=	fun_ip_get();
				$data	=	array(
					'username'	=>	$_POST['telphone'],
					'password'	=>	$pass,
					'usertype'	=>	1,
					'status'	=>	$this->config['user_state'],
					'salt'		=>	$salt,
					'reg_date'	=>	time(),
					'login_date'=>	time(),
					'reg_ip'	=>	$ip,
					'login_ip'	=>	$ip,
					'source'	=>	'12',
					'moblie'	=>	$_POST['telphone'],
					'did'		=>	$this->config['did'],
				);
				// 手机号绑定同步member表
				if (!empty($udata['moblie_status'])){
				    $data['moblie_status']  =  $udata['moblie_status'];
				}
				$udata['lastupdate']	=	time();

				$sdata	=	array(
					"resume_num"	=>	"1",
					"did"			=>	$this->config['did']
				);
				$deflogo    =  $resumeM->deflogo(array('sex'=>$_POST['sex']));

	            if($deflogo!=''){
	                $udata['photo'] = $deflogo;
	                $udata['defphoto'] = 2;
	                $udata['photo_status'] = 1;
	            }
				$udata['r_status']	=	$this->config['user_state'];
				$userid	=	$userinfoM->addInfo(array('mdata'=>$data,'udata'=>$udata,'sdata'=>$sdata));
				if($userid['error']){
					$return['msg']		=	$userid['msg'];
					$return['errcode']	=	$userid['error'];
					echo json_encode($userid);die;
				}
			}
			if(intval($userid)){
				$this->cookie->add_cookie($userid,$_POST['telphone'],$salt,"",$pass,1,$this->config['sy_logintime'],$this->config['did']);
				//简历基本信息数据
				$rData = array(
					'name' 		=> $_POST['uname'],
					'sex' 		=> $_POST['sex'],
					'birthday' 	=> $_POST['birthday'],
					'edu' 		=> $_POST['edu'],
					'exp' 		=> $_POST['exp'],
					'telphone' 	=> $_POST['telphone'],
					'login_date'=> time(),
				);
				//简历求职意向数据
				include PLUS_PATH."user.cache.php";
				include PLUS_PATH."job.cache.php";
				
				$jobid	  =	(int)$_POST['jobid'];
				$jobfield = '`com_name`,`name`,`uid`,`is_link`,`is_email`,`hy`,`job1`,`job1_son`,`job_post`,`provinceid`,`cityid`,`three_cityid`,`minsalary`,`maxsalary`';
				$comjob	  =	$jobM->getInfo(array('id'=>$jobid),array('field'=>$jobfield));
				
				if ($comjob['job_post']) {
				    $job_classid	=	$comjob['job_post'];
				} elseif ($comjob['job1_son']) {
				    $job_classid	=	$comjob['job1_son'];
				} else {
				    $job_classid	=	$comjob['job1'];
				}
				if ($comjob['three_cityid']){
				    $city_classid	=	$comjob['three_cityid'];
				}elseif($comjob['cityid']){
				    $city_classid	=	$comjob['cityid'];
				}else{
				    $city_classid	=	$comjob['provinceid'];
				}
				
				$eData = array(
				    'lastupdate' 	=> time(),
				    'height_status' => 0,
				    'uid' 			=> $userid,
				    'ctime' 		=> time(),
				    'name' 			=> $job_name[$job_classid],
				    'hy' 			=> $comjob['hy'],
				    'job_classid' 	=> $job_classid,
				    'city_classid' 	=> $city_classid,
				    'minsalary' 	=> $comjob['minsalary'],
				    'maxsalary' 	=> $comjob['maxsalary'],
					'type' 			=> $userdata['user_type'][0],
					'report' 		=> $userdata['user_report'][0],
					'jobstatus' 	=> $userdata['user_jobstatus'][0],
					'state' 		=> $this->config['user_state']==1 ? $this->config['resume_status']:0,
          			'r_status' 		=> $this->config['user_state'],
					'edu' 			=> $_POST['edu'],
					'exp' 			=> $_POST['exp'],
					'sex' 			=> $_POST['sex'],
					'birthday' 		=> $_POST['birthday'],
					'source' 		=> 12,
					'sq_jobid' 		=> $jobid,
				);
                $parr = array();
                foreach ($_POST as $pk => $pv) {
                    if(strpos($pk,'_')!=false){
                        $parr	=	@explode('_', $pk);
                        if(count($parr)>1){
                            $_POST[$parr[0]][$parr[1]]	=	$pv;
                        }
                    }
                }
				//简历工作经历数据
				$workData = array();
				if ($this->config['resume_create_exp'] == '1' && $_POST['iscreateexp'] == 1) {
                    for ($i=0; $i < count($_POST['workname']); $i++) {
                        $workData[$i]   =   array(
                            'uid'       =>  $userid,
                            'name'      =>  $_POST['workname'][$i],
                            'sdate'     =>  strtotime($_POST['worksdate'][$i]),
                            'edate'     =>  $_POST['totoday'][$i] ? 0 : $_POST['workedate'][$i] ? strtotime($_POST['workedate'][$i]) : 0,
                            'title'     =>  $_POST['worktitle'][$i],
                            'content'   =>  $_POST['workcontent'][$i]
                        );
                    }
				}
				//简历教育经历数据
				$eduData = array();
				if ($this->config['resume_create_edu'] == '1' && $_POST['iscreateedu'] == 1) {
                    for ($i=0; $i < count($_POST['eduname']); $i++) {
                        $eduData[$i]    =   array(
                            'uid'       =>  $userid,
                            'name'      =>  $_POST['eduname'][$i],
                            'sdate'     =>  strtotime($_POST['edusdate'][$i]),
                            'edate'     =>  strtotime($_POST['eduedate'][$i]),
                            'specialty'   =>  $_POST['specialty'][$i],
                            'education'   =>  $_POST['eduid'][$i]
                        );
                    }
				}
				//简历项目经历数据
				$proData = array();
				if ($this->config['resume_create_project'] == '1' && $_POST['iscreatepro'] == 1) {
                    for ($i=0; $i < count($_POST['projectname']); $i++) {
                        $proData[$i]    =   array(
                            'uid'       =>  $userid,
                            'name'      =>  $_POST['projectname'][$i],
                            'sdate'     =>  strtotime($_POST['projectsdate'][$i]),
                            'edate'     =>  strtotime($_POST['projectedate'][$i]),
                            'title'     =>  $_POST['projecttitle'][$i],
                            'content'   =>  $_POST['projectcontent'][$i]
                        );
                    }
				}
				
				$addArr	= 	array(
					'uid' 		=> $userid,
					'rData' 	=> $rData,
					'eData' 	=> $eData,
					'workData' 	=> $workData,
					'eduData' 	=> $eduData,
					'proData' 	=> $proData,
					'utype' 	=> 'user'
				);
				$return	= 	$resumeM->addInfo($addArr);
				if($return['errcode']!=9){
					
					echo json_encode($return);die;
				}
				if($return['id']){
					
					$eid	=	$return['id'];
					
					if(($this->config['user_state']!="1" || !$this->config['resume_status']) && $this->config['sy_shresume_applyjob']!=1){
						$return['msg']		=	'您的账号需要通过审核，才能投递简历哦！';
						$return['errcode']	=	7;
						$return['url']		=	Url('wap',array("c"=>"job","a"=>"comapply",'id'=>intval($_POST['jobid']),'tolist'=>1));
						echo json_encode($return);die;
					}
					if($this->config['user_sqintegrity']){
						$expect	=	$resumeM->getExpect(array('id'=>$eid),array('field'=>'`integrity`'));
						if($this->config['user_sqintegrity']>$expect['integrity']){
							$return['msg']		=	'该简历完整度未达到'.$this->config['user_sqintegrity'].'%，请先完善简历！';
							$return['errcode']	=	7;
							$return['url']		=	Url('wap',array("c"=>"resume","eid"=>"".$eid.""),'member');
							echo json_encode($return);die;
						}
					}

					$value	=	array(
						'job_id'	=>	$jobid,
						'com_name'	=>	$comjob['com_name'],
						'job_name'	=>	$comjob['name'],
						'com_id'	=>	$comjob['uid'],
						'uid'		=>	$userid,
						'eid'		=>	$eid,
						'resume_state'=>$eData['state'],
						'datetime'	=>	time()
					);
					$nid  =  $jobM->addSqJob($value, array('comjob'=>$comjob));
					$resumeM->updateExpect(array('sq_jobid'=>''),array('id'=>$eid));
					$return['msg']		=	'申请成功！';
					$return['errcode']	=	9;
					$return['url']		=	Url('wap',array("c"=>"job","a"=>"comapply",'id'=>intval($_POST['jobid']),'tolist'=>1));
					echo json_encode($return);die;
				}else{
					$return['msg']		=	'保存失败！';
					$return['errcode']	=	7;
					echo json_encode($return);die;
				}
			}
		}
	}
	function checkuser($username,$name=''){
		$userinfoM	=	$this -> MODEL('userinfo');
		
		$user		=	$userinfoM -> getInfo(array('username'=>$username),array('field'=>'`uid`'));
		
		if($user['uid']){
			
			$name.="_".rand(1000,9999);
			
			return $this->checkuser($name,$username);
			
		}else{
			return $username;
		}
	}

	//猎头发布咨询
	function pl_action(){
		$msgM	=	$this -> MODEL('msg');
		
		$blackM	=	$this -> MODEL('black');
		
		if($this->uid==''||$this->username==''){
			echo 3;die;
		}
		if($this->usertype!= '1'){
			echo 0;die;
		}
		$black	=	$blackM -> getBlackInfo(array('p_uid'=>$this->uid,'c_uid'=>(int)$_POST['job_uid']));
		if(!empty($black)){
			echo 7;die;
		}
		if(trim($_POST['content'])==""){
			echo 2;die;
		}
		if(trim($_POST['authcode'])==""){
			echo 4;die;
		}
		session_start();
		if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode'] || empty($_SESSION['authcode'])){
			echo 5;die;
		}
		$id	=	$msgM -> addInfo(array('uid'=>$this->uid,'username'=>$this->username,'jobid'=>trim($_POST['jobid']),'job_uid'=>trim($_POST['job_uid']),'content'=>trim($_POST['content']),'com_name'=>trim($_POST['com_name']),'job_name'=>trim($_POST['job_name']),'type'=>'1','datetime'=>time()));
		if($id){
			echo 1;die;
		}else{
			echo 6;die;
		}
	}
	//申请猎头职位，TODO:猎头前台
	function yqjob_action(){
		$jobM	=	$this->MODEL('job');
		$data	=	array(
			'uid'			=>	$this -> uid,
			'usertype'		=>	$this -> usertype,
			'job_id'		=>	(int)$_POST['job_id'],
			'type'			=>	(int)$_POST['type']
		);
		$arr= $jobM->applyLtJob($data);
		echo json_encode($arr);die;
	}
	//关注猎头
	function atn_action(){
		$data	=	array(
			'id'		=>	(int)$_POST['id'],
			'uid'		=>	$this->uid,
			'usertype'	=>	$this->usertype,
			'username'	=>	$this->username,
			'sc_usertype'=>	(int)$_POST['type']
		);
		$atnM	=	$this->MODEL('atn');
		$return	=	$atnM->addAtnLt($data);
		echo json_encode($return);die;
	}
    //关注企业
	function atncompany_action(){
		$data	=	array(
			'id'			=>	(int)$_POST['id'],
			'uid'			=>	$this->uid,
			'usertype'		=>	$this->usertype,
			'username'		=>	$this->username,
			'utype'			=>	'teacher',
			'sc_usertype'	=>	2
		);
		 
		$atnM	=	$this->MODEL('atn');
		$return	=	$atnM->addAtnLt($data);
		echo json_encode($return);die;
	}

    //关注讲师
	function atn_teacher_action(){
		$data	=	array(
			'id'			=>	(int)$_POST['id'],
			'tid'			=>	(int)$_POST['tid'],
			'uid'			=>	$this->uid,
			'usertype'		=>	$this->usertype,
			'username'		=>	$this->username,
			'utype'			=>	'teacher',
			'sc_usertype'	=>	4
		);
		 
		$atnM	=	$this->MODEL('atn');
		$return	=	$atnM->addAtnLt($data);

		echo json_encode($return);die;
	}
	//关注院校
    function atn_academy_action(){
		$data	=	array(
			'id'			=>	(int)$_POST['id'],
			'uid'			=>	$this->uid,
			'usertype'		=>	$this->usertype,
			'username'		=>	$this->username,
			'sc_usertype'	=>	5,
			'utype'			=>	'academy'
		);
		$atnM	=	$this->MODEL('atn');
		$return	=	$atnM->addAtnLt($data);
		echo json_encode($return);die;
    }
	
	//职位类别
	function getjob_action(){
		include(PLUS_PATH."job.cache.php");
		$data   =   '';
		if(is_array($job_type[$_POST['id']])){	
		    if($_POST['type']=="jobone_son"){				
				$data	.=	'<li onclick="check_job_li(\''.$_POST['id'].'\',\'job1\');"><a href="javascript:;">全部</a></li>';
			}
			if($_POST['type']=="job_post"){				
				$data	.=	'<li onclick="check_job_li(\''.$_POST['id'].'\',\'job1_son\');"><a href="javascript:;">全部</a></li>';
			}			
			foreach($job_type[$_POST['id']] as $v){				
				if($_POST['type']=="jobone_son"){
					if(!empty($job_type[$v])){

						$data	.=	'<li class="qCategoryt'.$v.'" onclick="Categoryt(\''.$v.'\',\''.$job_name[$v].'\',\'job_post\');"><a href="javascript:;">'.$job_name[$v].'</a></li>';
					}else{
						
						$data	.=	'<li onclick="check_job_li(\''.$v.'\',\'job1_son\');"><a href="javascript:;">'.$job_name[$v].'</a></li>';
					}
						
					}else{
						$data	.=	'<li onclick="check_job_li(\''.$v.'\',\'job_post\');"><a href="javascript:;">'.$job_name[$v].'</a></li>';
				    }				
			}			
		}else{
			if($_POST['type']=="jobone_son"){				
				$data	.=	'<li onclick="check_job_li(\''.$_POST['id'].'\',\'job1\');"><a href="javascript:;">全部</a></li>';
			}
			if($_POST['type']=="job_post"){				
				$data	.=	'<li onclick="check_job_li(\''.$_POST['id'].'\',\'job1_son\');"><a href="javascript:;">全部</a></li>';
			}
		}
		echo $data;
	}
	
	
	//wap前台猎头职位类别
	function getltjob_action(){
		include(PLUS_PATH."ltjob.cache.php");
		$data   =   '';
		if(is_array($ltjob_type[$_POST['id']])){	
		    if($_POST['type']=="jobtwo"){				
			$data	.=	'<li onclick="check_ltjob_li(\''.$_POST['id'].'\',\'jobone\');"><a href="javascript:;">全部</a></li>';
			}		
			foreach($ltjob_type[$_POST['id']] as $v){				
				if($_POST['type']=="jobtwo"){
					$data	.=	'<li onclick="check_ltjob_li(\''.$v.'\',\'jobtwo\');"><a href="javascript:;">'.$ltjob_name[$v].'</a></li>';
				}			
			}			
		}
		echo $data;
	}
	
	//wap前台猎头行业
	function getlietouhy_action(){
		include(PLUS_PATH."lthy.cache.php");
		$data   =   '';
		if(is_array($lthy_type[$_POST['id']])){	
		    if($_POST['type']=="lthytwo"){
				$data	.=	'<li onclick="check_ltjob_li(\''.$_POST['id'].'\',\'hyid\');"><a href="javascript:;">全部</a></li>';
			}
			foreach($lthy_type[$_POST['id']] as $v){
				if($_POST['type']=="lthytwo"){
					$data	.=	'<li onclick="check_ltjob_li(\''.$v.'\',\'hyid\');"><a href="javascript:;">'.$lthy_name[$v].'</a></li>';
				}
			}
		}
		echo $data;
	}	
	//城市类别
	function getcity_action(){
		include(PLUS_PATH."city.cache.php");
		$data   =   '';
		if(is_array($city_type[$_POST['id']])){
			if($_POST['type']=="cityid"){				
				// 后台-页面设置-列表页区域默认设置。选择了二级城市,并且是职位、简历、企业列表
				if (!empty($this->config['sy_web_city_two']) && in_array($_POST['kzq'], array('job','resume','company'))){
				    $city_type[$_POST['id']] = array($this->config['sy_web_city_two']);
				}else{
				    $data .=  '<li onclick="check_city_li(\''.$_POST['id'].'\',\'provinceid\');"><a href="javascript:;">全部</a></li>';
				}
			}
			if($_POST['type']=="three_cityid"){				
				$data	.=	'<li onclick="check_city_li(\''.$_POST['id'].'\',\'cityid\');"><a href="javascript:;">全部</a></li>';
			}		
			foreach($city_type[$_POST['id']] as $v){				
				if($_POST['type']=="cityid"){
					if(!empty($city_type[$v])){
						$data	.=	'<li class="qgradet'.$v.'" onclick="gradet(\''.$v.'\',\''.$city_name[$v].'\',\'three_cityid\');"><a href="javascript:;">'.$city_name[$v].'</a></li>';
					}else{
						$data	.=	'<li onclick="check_city_li(\''.$v.'\',\'cityid\');"><a href="javascript:;">'.$city_name[$v].'</a></li>';
					}
					
				}else{
					$data	.=	'<li onclick="check_city_li(\''.$v.'\',\'three_cityid\');"><a href="javascript:;">'.$city_name[$v].'</a></li>';	
				}
			}		
		}else{
			if($_POST['type']=="cityid"){				
				$data	.=	'<li onclick="check_city_li(\''.$_POST['id'].'\',\'provinceid\');"><a href="javascript:;">全部</a></li>';
			}
			if($_POST['type']=="three_cityid"){				
				$data	.=	'<li onclick="check_city_li(\''.$_POST['id'].'\',\'cityid\');"><a href="javascript:;">全部</a></li>';
			}
		}
		echo $data;
	}	
	//校园招聘城市类别只需要两级
	function schoolcity_action(){
		include(PLUS_PATH."city.cache.php");
		$data   =   '';
		if(is_array($city_type[$_POST['id']])){
			if($_POST['type']=="cityid"){				
				$data	.=	'<li onclick="check_city_li(\''.$_POST['id'].'\',\'provinceid\');"><a href="javascript:;">全部</a></li>';
			}
			foreach($city_type[$_POST['id']] as $v){				
				if($_POST['type']=="cityid"){
					if(!empty($city_type[$v])){
						$data	.=	'<li onclick="check_city_li(\''.$v.'\',\'cityid\');"><a href="javascript:;">'.$city_name[$v].'</a></li>';
					}
				}
			}		
		}else{
			if($_POST['type']=="cityid"){				
				$data	.=	'<li onclick="check_city_li(\''.$_POST['id'].'\',\'provinceid\');"><a href="javascript:;">全部</a></li>';
			}
		}
		echo $data;
	}
	/**
	 * 企业报名招聘会
	 */
	function ajaxzphjob_action(){
		$data	=	array(
			'usertype'	=>	$this->usertype,
			'uid'		=>	$this->uid,
			'spid'		=>	$this->spid,
			'jobid'		=>	$_POST['jobid'],
			'id'		=>	intval($_POST['id']),
			'zid'		=>	intval($_POST['zid']),
		);
		$zphM	=	$this->MODEL('zph');
		$arr	=	$zphM->ajaxZph($data);
		
		if ($arr['status'] == 2 && !empty($_POST['jobid'])){
		    // 套餐不足，记录jobid的cookie来备用
		    $this->cookie->setcookie('zphjobid', $_POST['jobid'], time()+86400);
		}
		
	    echo json_encode($arr);die;
	}
	//委托简历，TODO:猎头前台
	function entrust_action(){
		$EntrustM	=	$this->MODEL('entrust');
		$data	=	array(
			'uid'		=>	$this->uid,
			'usertype'	=>	$this->usertype,
			'puid'		=>	(int)$_POST['uid'],
			'name'		=>	$_POST['name']
		);
		$return		=	$EntrustM->addEntrust($data);
		echo json_encode($return);die;
	}
	
	//天眼查工商数据获取
	function getbusiness_action(){
		if($_POST['name']){
			$noticeM	=	$this -> MODEL('notice');
			$reurn		=	$noticeM -> getBusinessInfo($_POST['name']);
			
			if(!empty($reurn['content'])){
				$comGsInfo	=	$reurn['content'];

				echo json_encode($comGsInfo);
			}
		}
	}
	
	
	
	//修改密码，TODO:会员中心
	function setpwd_action(){
		if($_POST['password']){
			$UserinfoM  =   $this->MODEL('userinfo');
			$data   	=   array(
                
                'uid'           =>  $this->uid,
                'usertype'      =>  $this->usertype,
                'oldpassword'   =>  $_POST['password'],
                'password'      =>  $_POST['passwordnew'],
                'repassword'    =>  $_POST['passwordconfirm']
                
            );
			$err    =   $UserinfoM -> savePassword($data);
			
			$arr['type']=$err['errcode'];
			$arr['msg']=$err['msg'];
			if($err['errcode'] == '9'){
                $this -> cookie -> unset_cookie();     
            }
            echo json_encode($arr);die;
		}
	}
	
	//关注培训机构
	function atn_train_action(){
		$AtnM	=	$this->MODEL('atn');
		$data	=	array(
			'id'			=>	(int)$_POST['uid'],
			'uid'			=>	$this->uid,
			'usertype'		=>	$this->usertype,
			'username'		=>	$this->username,
			'sc_usertype'	=>	4,
			'utype'			=>	'agency'
		);
		$return	=	$AtnM->addAtnLt($data);

		echo json_encode($return);die;
	}
    //消息数
    function msgNum_action()
    {
		$M    =  $this->MODEL('msgNum');
		$arr  =  $M->getmsgNum($this->uid, $this->usertype);
		echo json_encode($arr);
    }
    // AJAX URL参数生成
    function ajax_url_action(){
        if($_POST){
            if($_POST['url']!=""){
                $urls=@explode("&",$_POST['url']);
                foreach($urls as $v){
                    if($_POST['type']=="provinceid"||$_POST['type']=="cityid"||$_POST['type']=="three_cityid"){
                        if(strpos($v,"provinceid")===false && strpos($v,"cityid")===false&& strpos($v,"three_cityid")===false){
                            $gourl[]=$v;
                        }
                    }elseif($_POST['type']=="job1"||$_POST['type']=="job1_son"||$_POST['type']=="job_post"){
                        if(strpos($v,"job1")===false && strpos($v,"job1_son")===false&& strpos($v,"job_post")===false){
                            $gourl[]=$v;
                        }
                    }elseif($_POST['type']=="nid"||$_POST['type']=="tnid"){
                        if(strpos($v,"tnid")===false&&strpos($v,"nid")===false){
                            $gourl[]=$v;
                        }
                    }else{
                        if(strpos($v,$_POST['type'])===false){
                            $gourl[]=$v;
                        }
                    }
                }
                if($_POST['id']>0){
                    $gourl=@implode("&",$gourl)."&".$_POST['type']."=".$_POST['id'];
                }else{
                    $gourl=@implode("&",$gourl);
                }
            }else{
                $gourl=$_POST['type']."=".$_POST['id'];
            }
            echo "?".$gourl;die;
        }
    }
	//wap前台商城商品类别
	function getredeem_action(){
		include(PLUS_PATH."redeem.cache.php");
		$data   =   '<li onclick="check_redeem_li(\''.$_POST['id'].'\',\'nid\');"><a href="javascript:;">全部</a></li>';
		if(is_array($redeem_type[$_POST['id']])){
			foreach($redeem_type[$_POST['id']] as $v){				
				if($_POST['type']=="tnid"){
						$data.='<li onclick="check_redeem_li(\''.$v.'\',\'tnid\');"><a href="javascript:;">'.$redeem_name[$v].'</a></li>';
					}			
			}			
		}
		echo $data;
	}

    // 企业每日最大操作次数检查
    public function ajax_day_action_check_action()
    {
        $type   =   isset($_POST['type']) ? $_POST['type'] : '';
        
        $comM   =   $this -> MODEL('company');
        $com_id =   $this->uid;
        $result =   $comM -> comVipDayActionCheck($type, $com_id);
        
        echo json_encode($result);
        die();
    }
    // 切换账号
    function notuserout_action(){
        $jobid  =   intval($_POST['jobid']);
        
        $this->cookie->unset_cookie();
        

        if ($jobid) {
        
            $url    =   Url('wap', array('c' => 'login', 'job' => $jobid));
        } else {
        
            $url    =   Url('wap', array('c' => 'login'));
        }
        
        echo $url;
        die();
    }
    //公共二维码跳转
    function pubqrcode_action(){
        
        if (isset($_GET['toc']) && $_GET['toc'] == 'company'){
            header("Access-Control-Allow-Origin: https://www.hr135.com");
        }
        $wapUrl = Url('wap');
		ob_clean();
		if(($this -> config['sy_ewm_type'] == 'weixin' || $this -> config['sy_ewm_type'] == 'xcx') && $_GET['toa'] !='whb' && $_GET['totype'] != 'wxpubtool' && $_GET['toc'] != 'register'){

			//微信公众号带参数二维码

            $WxM	=	$this -> MODEL('weixin');
            
			$qrcode =	$WxM->pubWxQrcode($_GET['toc'],$_GET['toid'],$this -> config['sy_ewm_type']);
			if($qrcode){
			    
			    $imgStr	=	CurlGet($qrcode);
			    
			    header("Content-Type:image/png");
			    
			    echo $imgStr;
			    
			}

		}else{
			if( isset($_GET['toid']) && $_GET['toid'] != ''){
				$wapUrl = Url('wap',array('c'=>$_GET['toc'],'a'=>$_GET['toa'],'id'=>(int)$_GET['toid']));
			}
			if(isset($_GET['toc']) && $_GET['toc'] == 'register'){
			    $wapUrl = Url('wap',array('c'=>$_GET['toc'],'uid'=>(int)$_GET['touid']));
			}
			include_once LIB_PATH."yunqrcode.class.php";
			YunQrcode::generatePng2($wapUrl,4);
		}
    }
    // 投递简历弹出框数据
	function index_ajaxjob_action(){

        $JobM	=	$this->MODEL('job');

		$arr	=	array();
		
		$arr['status'] = 2;

		if(empty($_POST['jobid'])){

			$arr['msg']		=	'参数错误，请重试！';

		}else if(!$this->uid || !$this->username || $this->usertype != 1){
			
			$arr['msg']		=	'请登录个人用户！';
		}else{
			
			 
			$jobid			=	intval($_POST['jobid']);
			 
			$sqJobNum		=	$JobM -> getSqJobNum(array('uid' => $this -> uid, 'job_id' => $jobid,'isdel'=>9));
			
			
			if($sqJobNum > 0){	//已投递过

				$arr['msg']	=	'您已申请过该职位！';
			}else{

				$yqmsNum	=	$JobM -> getYqmsNum(array('uid'=>$this -> uid,'jobid' => $jobid,'isdel'=>9));
				
				if($yqmsNum > 0){
					
					$arr['msg']	=	'该职位已邀请您面试，无需再投简历！';
				}else{
					$ResumeM	=	$this -> MODEL('resume');
					
					$resumeWhere['uid'] = $this->uid;
					
					if($this->config['sy_shresume_applyjob']=='1'){
				 		$resumeWhere['PHPYUNBTWSTART']  =  '';
			            $resumeWhere['state'][]         =  array('=',1);
			            $resumeWhere['state'][]         =  array('=',0,'OR');
			            $resumeWhere['PHPYUNBTWEND']    =  '';
				 	}else{
				 		$resumeWhere['state'] = 1;
				 	}

					$resumeList	=	$ResumeM -> getSimpleList($resumeWhere, array('field' => '`id`,`name`,`defaults`'));
					
					if(!empty($resumeList)){

						$arr['status']		=	1;
						
						$html		=	'';
						
						foreach($resumeList as $key=>$val){
							if($val['defaults']==1){
								$html .=	"<div class='job_prompt_sendresume_list job_prompt_sendresume_list_cur' id='resume_$val[id]' data_did='$val[id]' onclick='sqjobclic($val[id]);'><i class='job_prompt_sendresume_radio'></i><i class='job_prompt_sendresume_radio_q'></i>$val[name](默认简历)</div>";
							}else{
								$html .=	"<div class='job_prompt_sendresume_list' id='resume_$val[id]' data_did='$val[id]' onclick='sqjobclic($val[id]);'><i class='job_prompt_sendresume_radio'></i><i class='job_prompt_sendresume_radio_q'></i>$val[name]</div>";
							}
						}
						
						$arr['data']	=	$resumeList;

					}else{
						
						$resuemNum		=	$ResumeM -> getExpectNum(array('uid' => $this -> uid));

						if(intval($resuemNum) > 0){
						
							$arr['msg']	=	'您的简历尚未完成审核，请联系管理员加快审核进度！';
						}else{
							$arr['msg']		=	'您还没有合适的简历';
						}

					}
				}
			}
		}
		echo json_encode($arr);die;
	}
	//报名招聘会条件判断
	function ajaxComjob_action(){
	    
	    if ($_POST['zph']){
	        
	        $zphM  =  $this->MODEL('zph');
	        $comrow   =  $zphM->getZphComInfo(array('uid'=>$this->uid,'zid'=>$_POST['id']));
	        
	    }elseif ($_POST['zphnet']){
	        
	        $zphnetM  =  $this->MODEL('zphnet');
	        $comrow   =  $zphnetM->getZphnetCom(array('uid'=>$this->uid,'zid'=>$_POST['id']));
	    }
	    if (!empty($comrow)){
	        
	        $data['status']	= 2;
	        
	        if($comrow['status']==0){
	            
	            $data['msg']	= "您已报名,请等待审核！";
	            
	        }else if($comrow['status']==1){
	            
	            $data['msg']	= "您已报名了，请不要重复报名！";
	            
	        }else if($comrow['status']==2){
	            
	            $data['msg']	= "您已报名,且审核未通过！";
	        }
	        
	    }else{
	        
	        $where	=	array(
	            'uid'		=>	$this->uid,
	            'state'		=>	1,
	            'status'	=>	0,
	            'r_status'	=>	array('<>',2),
	        );
	        if($this->config['did']){
	            $where['did']=$this->config['did'];
	        }
	        $jobM	=	$this->MODEL('job');
	        $arr	=	$jobM->getList($where, array('field'=>'`id`,`name`'));
	        $list	=	$arr['list'];
	        
	        if(!empty($list)){
	            
	            $data['list']	= $list;
	            
	            $data['status']	= 1;
	            
	        }else{
	            
	            $data['status']	= 2;
	            
	            $data['msg']	= "您还没有发布职位，请先发布职位！";
	        }
	    }
		
	    echo json_encode($data);die;
	}
    // 申请身份切换
	function applytype_action(){
	    
		$memberM		=	$this -> MODEL('userinfo');
		
		$res			=	$memberM->checkChangeApply($this->uid,$_POST['applyusertype'],$_POST['applybody']);
		echo json_encode(array('msg'=>$res['msg'],'url'=>$res['url'],'errcode'=>$res['errcode']));die;
	}
	//企业主动邀请面试
	function sendWxNotice_action(){
	    if($_POST['sid']){
	        
	        $spviewM	=	$this -> MODEL('spview');
	        $spview		=	$spviewM -> getInfo(array('id' => $_POST['sid']), array('field' => '`id`, `uid`, `starttime`'));
	        $subinfo	=	$spviewM -> getSubinfo(array('uid'=>$_POST['ruid'],'sid'=>$_POST['sid']), array('job'=>1));
	        
	        $uInfoM		=	$this -> MODEL('userinfo');
	        $member		=	$uInfoM -> getInfo(array('uid' => $_POST['ruid']), array('field' => '`uid`, `wxid`, `usertype`,`moblie`'));
	        
	        $sendData	=	array(
	            'title'		=>	'您有新的视频面试邀请！',
	            'name'		=>	$subinfo['com_name'],
	            'jobname'	=>	$subinfo['jobname'],
	            'sptime'	=>	date("Y年m月d日 H:i", $spview['starttime']),
	            'sptype'	=>	'视频面试',
	            'url'		=>	Url('wap',array('c'=>'spview','a'=>'show','id'=>$_POST['sid'],'fr'=>'wxtz')),
	            'wxid'		=>	$member['wxid'],
	            'uid'		=>	$member['uid'],
	            'usertype'	=>	$member['usertype']
	        );
	        $weixinM	=	$this->MODEL('weixin');
	        
	        $weixinM->sendWxSpview($sendData);
	        
	        $noticeM	=	$this->MODEL('notice');
	        $data		=	array(
	            'uid'		=>	$member['uid'],
	            'usertype'	=>	$member['usertype'],
	            'moblie'	=>	$member['moblie'],
	            'type'		=>	'yqspms',
	            'jobname'	=>	$subinfo['jobname'],
	            'company'	=>	$subinfo['com_name'],
	            'port'		=>	'1'
	        );
	        
	        $noticeM->sendSMSType($data);
	        
	    }elseif ($_POST['ruid'] && $this->usertype == 2){
	        // 聊天界面发送视频面试邀请
	        $companyM   =  $this->MODEL('company');
	        $com        =  $companyM->getInfo($this->uid,array('field'=>'`name`'));
	        
	        $uInfoM		=	$this -> MODEL('userinfo');
	        $member		=	$uInfoM -> getInfo(array('uid' => $_POST['ruid']), array('field' => '`uid`, `wxid`, `usertype`,`moblie`'));
	        
	        if (!empty($_POST['jobid'])){
	            
	            $jobM  =  $this->MODEL('job');
	            $job   =  $jobM->getInfo(array('id'=>$_POST['jobid']), array('field'=>'`name`'));
	        }
	        
	        $sendData	=	array(
	            'title'		=>	'您有新的视频面试邀请！',
	            'name'		=>	$com['name'],
	            'jobname'	=>	isset($job) ? $job['name'] : '无',
	            'sptime'	=>	date("Y年m月d日 H:i"),
	            'sptype'	=>	'视频面试',
	            'url'		=>	Url('wap',array('c'=>'chat','id'=>$this->uid,'type'=>2,'wxuid'=>$_POST['ruid'],'fr'=>'wxtz')),
	            'wxid'		=>	$member['wxid'],
	            'uid'		=>	$member['uid'],
	            'usertype'	=>	$member['usertype']
	        );
	        
	        $weixinM	=	$this->MODEL('weixin');
	        
	        $weixinM->sendWxSpview($sendData);
	    }
	}
	//获取视频面试职位详情
	function getSpviewJobInfo_action(){
	    
	    $sid 		=	$_POST['sid'];
	    $jobid 		= 	$_POST['jobid'];
	    
	    if($sid && $jobid){
	        
	        $spviewM	= 	$this->MODEL('spview');
	        
	        $spview		=	$spviewM->getInfo(array('id'=>$sid),array('field'=>'jobid,uid'));
	        
	        if(in_array($jobid,$spview['jobid_n'])){
	            
	            $jobM	=   $this -> MODEL('job');
	            
	            $job	=	$jobM -> getInfo(array('id'=>$jobid,'uid'=>$spview['uid'],'status'=>'0','state'=>'1','r_status'=>1));
	            
	            if(!empty($job)){
	                
	                $res['job'] 	= $job;
	                $res['error'] 	= 1;
	                
	            }else{
	                
	                $res['error'] 	= 2;
	                $res['msg'] 	= '该职位不存在';
	                
	            }
	            
	        }else{
	            
	            $res['error'] 	= 2;
	            $res['msg'] 	= '该面试不包含此职位';
	            
	        }
	        
	    }else{
	        
	        $res['error'] 	= 2;
	        $res['msg'] 	= '数据异常，请重试';
	        
	    }
	    
	    echo json_encode($res);die;
	}

	// 获取职位海报
    function getJobHb_action()
    {

        $whbM   =   $this->MODEL('whb');
        if (!$_GET['hb']) {

            $whb        =   $whbM->getWhb(array('type' => 1, 'isopen' => 1, 'orderby' => 'sort,desc'));
            $_GET['hb'] =   $whb['id'];
        }

        $data   =   array(
            'hb'    =>  $_GET['hb'] ? $_GET['hb'] : 1,
            'id'    =>  $_GET['id']
        );

        echo $whbM->getJobHb($data);
    }

    // 获取企业海报
    function getComHb_action()
    {

        $whbM       =   $this->MODEL('whb');

        if (!$_GET['hb'] && !$_GET['style']) {

            $whb    =   $whbM->getWhb(array('type' => 2, 'isopen' => 1, 'orderby' => 'sort,desc'));
            $_GET['hb'] = $whb['id'];
        }

        $data       =   array(
            'uid'   =>  $_GET['uid']
        );

        if ($_GET['hb']) {

            $data['hb'] = $_GET['hb'];
        }

        if ($_GET['style']) {

            $data['style']  =   $_GET['style'];
        }

        if ($_GET['jobids']) {

            $data['jobids'] =   $_GET['jobids'];
        }

        echo $whbM->getComHb($data);
    }
    // 获取邀请注册海报模板列表
    function getInviteRegHbList_action()
    {
        $whbM   =   $this->MODEL('whb');
        $list   =   $whbM->getWhbList(array('type' => 3, 'isopen' => 1, 'orderby' => 'sort,desc'), array('field' => 'id'));
        
        echo json_encode(['list' => $list]);die;
    }
    
    // 获取邀请注册海报
    function getInviteRegHb_action()
    {
        $whbM   =   $this->MODEL('whb');
        if (!$_GET['hb']) {
            $whb=   $whbM->getWhb(array('type' => 3, 'isopen' => 1, 'orderby' => 'sort,desc'));
            $_GET['hb'] = $whb['id'];
        }
        $data   =   array(
            'uid'   =>  $this->uid,
            'hb'    =>  $_GET['hb'] ? $_GET['hb'] : 1
        );
        echo $whbM->getInviteRegHb($data);
    }
    function addJobTelLog_action(){

    	if($_POST['jobid'] || $_POST['comid']){
    		$jobM = $this->MODEL('job');

			$jobM->addTelLog(
				array(
					'uid'		=>	$this->uid,
					'usertype'	=>	$this->usertype,
					'source'	=>	2,
					'jobid'		=>	intval($_POST['jobid']),
					'comid'		=>	intval($_POST['comid'])
				)
			);
    	}
    }
}	
?>