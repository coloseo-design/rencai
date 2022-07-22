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
class chat_model extends model{
    /**
     * 查询单个直聊用户
	 * $whereData 	 查询条件
     * $data 		 自定义处理数组
     */
    public function getMember($whereData, $data = array()) {
        
        $field  =  empty($data['field']) ? '*' : $data['field'];
        
        $member  	=  $this -> select_once('chat_member', $whereData, $field);  
		
        if (!empty($member['avatar'])){
            
            $member['avatar']  = checkpic($member['avatar'] , $this->config['sy_chat_logo']);
        }
        
        return $member;    
	}
	/**
	 * 查询多个直聊用户
	 * $whereData 	 查询条件
	 * $data 		 自定义处理数组
	 */
	public function getMemberList($whereData, $data = array()) {
	    
	    $field  =  empty($data['field']) ? '*' : $data['field'];
	    
	    $List   =  $this -> select_all('chat_member', $whereData, $field);
	    
	    return $List;
	}
	/**
	 * 添加直聊用户
	 * $upData      要修改的数据
	 * $whereData 	 查询条件
	 */
	public function addMember($data) 
	{
	    if (!empty($data)){
	        
	        $nid  =  $this -> insert_into('chat_member',$data);
	    }
	    
	    return $nid;
	}
	/**
	 * 修改直聊用户
	 * $upData      要修改的数据
	 * $whereData 	 查询条件
	 */
	public function upMember($upData,$whereData) {
	    
	    if (!empty($whereData)){
	        
	        $nid  =  $this -> update_once('chat_member',$upData,$whereData);
	    }
	    
	    return $nid;
	}
	/**
	 * 删除直聊用户
	 */
	public function delMember($whereData)
	{
	    if (!empty($whereData)){
	        
	        $this -> delete_all('chat_member', $whereData, '');
	    }
	}
	/**
	 * 保存消息
	 * @param 引用字段：$data:字段
	 */
	public  function addChatLog($data=array()){
	    
	    $nid    =   $this -> insert_into('chat_log', $data);
	    
	    return $nid;
	}
    /**
     * 查询聊天记录
	 * $whereData 	 查询条件
     * $data 		 自定义处理数组
     */
	public function getChatLog($whereData, $data = array('utype'=>null)) {
        
        $field  =  empty($data['field']) ? '*' : $data['field'];
        
        $List  	=  $this -> select_once('chat_log', $whereData, $field);  
        
        if ($data['utype']){
            
            $List['sendTime']  =  ceil($List['sendTime']/1000);
            $List['sendTime_n']=  date('Y-m-d H:i',$List['sendTime']);
        }
        return $List;    
	}
	/**
	 * 查询聊天记录
	 * $whereData 	 查询条件
	 * $data 		 自定义处理数组
	 */
	public function getChatLogList($whereData, $data = array()) {
	    
	    $field  =  empty($data['field']) ? '*' : $data['field'];
	    
	    $List   =  $this -> select_all('chat_log', $whereData, $field);
	    
	    if(!empty($List)){
	        
	        if(isset($data['admin'])){
	            
	            $eids = $jobids = $rname = $jname = $ru = $cu = $lu = array();
	            foreach($List as $key=>$val){
	                
	                if($val['msgtype']=='resume'){
	                    
	                    if (strpos($val['content'],'eid=')!==false){
	                        
	                        $eid = str_replace('eid=', '', $val['content']);
	                        if(!in_array($eid,$eids)){
	                            $eids[]=$eid;
	                        }
	                    }
	                }
	                if($val['msgtype']=='job' || $val['msgtype'] == 'adminjob'){
	                    
	                    if (strpos($val['content'],'jobid=')!==false){
	                        
	                        $jobid = str_replace('jobid=', '', $val['content']);
	                        if(!in_array($jobid,$jobids)){
	                            $jobids[]=$jobid;
	                        }
	                    }
	                }
	                if ($val['fusertype'] == 1){
	                    $ru[] = $val['from'];
	                }
	                if ($val['tusertype'] == 1){
	                    $ru[] = $val['to'];
	                }
	                if ($val['fusertype'] == 2){
	                    $cu[] = $val['from'];
	                }
	                if ($val['tusertype'] == 2){
	                    $cu[] = $val['to'];
	                }
	                if ($val['fusertype'] == 3){
	                    $lu[] = $val['from'];
	                }
	                if ($val['tusertype'] == 3){
	                    $lu[] = $val['to'];
	                }
	            }
	            $alluid  =  array_merge($ru, $cu, $lu);
	            
	            $member  =  $this->select_all('member', array('uid'=>array('in',pylode(',', array_unique($alluid)))),'`uid`,`username`');
                $resume  =  $this->select_all('resume', array('uid'=>array('in',pylode(',', array_unique($ru)))),'`uid`,`name`');
                $company =  $this->select_all('company', array('uid'=>array('in',pylode(',', array_unique($cu)))),'`uid`,`name`');
                if (!empty($lu)){
                    $ltinfo  =  $this->select_all('lt_info', array('uid'=>array('in',pylode(',', array_unique($lu)))),'`uid`,`realname` AS `name`');
                }
                if(!empty($eids)){
	                
	                $resumes  = $this -> select_all('resume_expect',array('id'=>array('in',pylode(',',$eids))),'`id`,`name`');
	                
	                foreach($resumes as $rk=>$rv){
	                    $rname[$rv['id']] = $rv['name'];
	                }
	                
	            }
	            if(!empty($jobids)){
	                
	                $jobs     = $this -> select_all('company_job',array('id'=>array('in',pylode(',',$jobids))),'`id`,`name`');
	                foreach($jobs as $jk=>$jv){
	                    $jname[$jv['id']] = $jv['name'];
	                }
	            }
	            
	            foreach($List as $k=>$v){
	                $List[$k]['fname'] = '';
	                $List[$k]['tname'] = '';
	                foreach ($company as $valu){
	                    if ($v['from'] == $valu['uid']){
	                        $List[$k]['fname']  = '<br/>' . $valu['name'];
	                    }
	                    if ($v['to'] == $valu['uid']){
	                        $List[$k]['tname']  = '<br/>' . $valu['name'];
	                    }
	                }
	                foreach ($resume as $value) {
	                    if ($v['from'] == $value['uid']){
	                        $List[$k]['fname']  = '<br/>' . $value['name'];
	                    }
	                    if ($v['to'] == $value['uid']){
	                        $List[$k]['tname']  = '<br/>' . $value['name'];
	                    }
	                }
	                if (!empty($ltinfo)){
	                    foreach ($ltinfo as $lv) {
	                        if ($v['from'] == $lv['uid']){
	                            $List[$k]['fname']  = '<br/>' . $lv['name'];
	                        }
	                        if ($v['to'] == $lv['uid']){
	                            $List[$k]['tname']  = '<br/>' . $lv['name'];
	                        }
	                    }
	                }
	                foreach ($member as $val){
	                    
	                    if ($v['from'] == $val['uid']){
	                        if ($v['fusertype'] == 1){
	                            $ufname  =  '&nbsp;&nbsp;<em style="color:#009688">[个人]</em>';
	                        }elseif ($v['fusertype'] == 2){
	                            $ufname  =  '&nbsp;&nbsp;<em style="color:#009688">[企业]</em>';
	                        }elseif ($v['fusertype'] == 3){
	                            $ufname  =  '&nbsp;&nbsp;<em style="color:#009688">[猎头]</em>';
	                        }
	                        $List[$k]['fname']  =  $val['username'].$ufname . $List[$k]['fname'];
	                    }
	                    if ($v['to'] == $val['uid']){
	                        if ($v['tusertype'] == 1){
	                            $utname  =  '&nbsp;&nbsp;<em style="color:#009688">[个人]</em>';
	                        }elseif ($v['tusertype'] == 2){
	                            $utname  =  '&nbsp;&nbsp;<em style="color:#009688">[企业]</em>';
	                        }elseif ($v['tusertype'] == 3){
	                            $utname  =  '&nbsp;&nbsp;<em style="color:#009688">[猎头]</em>';
	                        }
	                        $List[$k]['tname']  =  $val['username'].$utname . $List[$k]['tname'];
	                    }
	                }
	                if($v['fusertype']==9){
	                	$List[$k]['fname']  = '网站客服';
	                }
	                if($v['tusertype']==9){
	                	$List[$k]['tname']  = '网站客服';
	                }
	                if($v['msgtype']=='resume'){
	                    
	                    if (strpos($v['content'],'eid=')!==false){
	                        
	                        $eid = str_replace('eid=', '', $v['content']);
	                        if (!empty($rname[$eid])){
	                            $List[$k]['content']= '发送简历（ID '.$eid.'）：'.$rname[$eid];
	                        }else{
	                            $List[$k]['content']= '发送简历（ID '.$eid.'）：[简历不存在]';
	                        }
	                    }
	                    
	                }else if($v['msgtype']=='job' || $v['msgtype'] == 'adminjob'){
	                    
	                    if (strpos($v['content'],'jobid=')!==false){
	                        
	                        $jobid = str_replace('jobid=', '', $v['content']);
	                        if (!empty($jname[$jobid])){
	                            $List[$k]['content']= '发送职位（ID '.$jobid.'）：'.$jname[$jobid];
	                        }else{
	                            $List[$k]['content']= '发送职位（ID '.$jobid.'）：[职位不存在]';
	                        }
	                    }
	                    
	                }else if($v['msgtype']=='ask'){
	                    
	                    if (strpos($v['content'],'ask=')!==false){
	                        
	                        $askid = str_replace('ask=', '', $v['content']);
	                        
	                        $asktype = '';
	                        
	                        if($askid=='tel'){
	                            
	                            $asktype  = '电话';
	                            
	                        }else if($askid=='wx'){
	                            
	                            $asktype  = '微信';
	                        }
	                        $List[$k]['content']= '请求交换'.$asktype.'：'.$v['askvalue'];
	                    }
	                    
	                }else if($v['msgtype']=='confirm'){
	                    
	                    if (strpos($v['content'],'confirm=')!==false){
	                        
	                        $confirmid = str_replace('confirm=', '', $v['content']);
	                        
	                        $confirmtype = '';
	                        
	                        if($confirmid=='tel'){
	                            
	                            $confirmtype  = '电话';
	                            
	                        }else if($confirmid=='wx'){
	                            
	                            $confirmtype  = '微信';
	                        }
	                        $List[$k]['content']= '同意交换'.$confirmtype.'：'.$v['fconfirm'];
	                    }
	                    
	                }else if($v['msgtype']=='refuse'){
	                    
	                    if (strpos($v['content'],'refuse=')!==false){
	                        
	                        $refuseid = str_replace('refuse=', '', $v['content']);
	                        
	                        $refusetype = '';
	                        
	                        if($refuseid=='tel'){
	                            
	                            $refusetype  = '电话';
	                            
	                        }else if($refuseid=='wx'){
	                            
	                            $refusetype  = '微信';
	                        }
	                        $List[$k]['content']= '拒绝交换'.$refusetype;
	                    }
	                    
	                }else if($v['msgtype']=='voice'){
	                    
	                    if (strpos($v['content'],'voice[http')!==false){
	                        
	                        preg_match('/voice\[([^\s]+?)\]/u',$v['content'],$m);
	                        
	                        $List[$k]['mtype']  =   'voice';
	                        
	                        $List[$k]['content']=   $m[1];
	                    }
	                    
	                }else if($v['msgtype']=='char'){
	                    
	                    if (strpos($v['content'],'img[http')!==false){
	                        
	                        preg_match('/img\[([^\s]+?)\]/u',$v['content'],$m);
	                        
	                        $List[$k]['mtype']  =   'img';
	                        
	                        $List[$k]['content']=   $m[1];
	                    }
	                }
	            }
	        }
	    }
	    return $List;
	}
	/**
	 * 修改消息
	 * $upData      要修改的数据
	 * $whereData 	 查询条件
	 */
	public function upChatLog($upData,$whereData) {
	    
	    if (!empty($whereData)){
	        
	        $nid  =  $this -> update_once('chat_log',$upData,$whereData);
	    }
	    
	    return $nid;
	}
	/**
	 * 查询聊天数量
	 * $whereData 	 查询条件
	 */
	public function getChatLogNum($whereData) {
	    
	    $num  =  $this -> select_num('chat_log', $whereData);
	    
	    return $num;
	}
	/**
	 * 删除聊天记录，按条件分为删除全部记录和单个人记录
	 * $whereData 	 查询条件
	 */
	public function delChatLog($data = array()) {
	    
	    if(!empty($data['toid'])){
	        // 处理uid。管理员uid与其他身份不同
	        $data['toid']  =  str_replace('a', '', $data['toid']);
	        
	        $br  =  $this->getBeginid($data);
	        
	        if (!empty($br['beginid'])){
				 
	            $this -> delete_all('chat_log', array('beginid'=>$br['beginid']), '');
	            // 用户自己删除，同时删除好友关系
	            $this -> delete_all('chat_friend', array('beginid'=>$br['beginid']), '');
	            // 再删除聊天权限
	            $this -> delete_all('chat_right', array('uid'=>$br['uid'],'comid'=>$br['comid'],'usertype'=>$br['comtype']), '');
	            
	            require_once ('log.model.php');
	            $LogM = new log_model($this->db, $this->def);
	            $LogM->addMemberLog($data['uid'], $data['usertype'], '将聊天对象(ID: '.$data['to'].')设置为不感兴趣', 30, 3);
	        }
	    }elseif(!empty($data['where'])){
	        
	        $where	    =  $data['where'];

	        if (isset($data['norecycle']) && $data['norecycle'] == 1){

                $nid	=  $this -> delete_all('chat_log', $where, '', '', 1);
            }else{
                $nid	=  $this -> delete_all('chat_log', $where, '');
            }

	        
	        return $nid;
	    }
	}
	//获取单个聊天对象的相关数据
	public function getSingleChatOnlineData($data){
	    // 处理uid。管理员uid与其他身份不同
	    $data['toid']  =  str_replace('a', '', $data['toid']);
	    
		$uid 		= 	$data['uid'];
		$usertype 	= 	$data['usertype'];
		$toid 		= 	$data['toid'];
		$totype 	= 	$data['totype'];

		$return 	=	array();

		$br  		=  	$this->getBeginid(array(
			'toid'       =>  $toid,
            'tusertype'  =>  $totype,
            'fromid'     =>  $uid,
            'fusertype'  =>  $usertype), 'get');

	    $chat   	=  	$this->userinfo(array('uid'=>$toid,'usertype'=>$totype,'nowid'=>$uid,'nowtype'=>$usertype));
	    
	    $return 	= 	$chat['mine'];
		
	    $return['toid'] = $toid;
	    $return['totype'] = $totype;

	    $return['canwx']    =  $this->getFriendCan(array('type'=>'wx','uid'=>$uid,'usertype'=>$usertype,'fid'=>$toid,'fusertype'=>$totype));
	    $return['cantel']   =  $this->getFriendCan(array('type'=>'tel','uid'=>$uid,'usertype'=>$usertype,'fid'=>$toid,'fusertype'=>$totype));
		
		require_once ('job.model.php');
	   	$jobM  =  new job_model($this->db, $this->def);

	   	require_once ('lietoujob.model.php');
		$ltjobM  =  new lietoujob_model($this->db, $this->def);

		$return['expect']  =  array();
		$return['joblist']  =  array();

		if($totype==1){

			$expect  =  $this->select_once('resume_expect',array('uid'=>$toid,'defaults'=>1),'id,`uid`');

			if (!empty($expect)){

				require_once ('resume.model.php');

				$resumeM  =  new resume_model($this->db, $this->def);

				$einfo    =  $resumeM -> getExpect(array('id'=>$expect['id']),array('needCache'=>1,'field'=>'`id`,`uid`,`name`,`exp`,`edu`,`city_classid`,`report`'));

				$rinfo    =  $resumeM -> getResumeInfo(array('uid'=>$expect['uid']),array('field'=>'`name`,`sex`,`photo`,`birthday`,`description`','logo'=>2));

				$einfo['sex_n']   =  $rinfo['sex_n'];
				$einfo['age']     =  $rinfo['age'];
				$einfo['uname']   =  $rinfo['name'];
				$einfo['photo']   =  $rinfo['photo'];
				$einfo['description'] = mb_substr(strip_tags($rinfo['description']), 0, 60);
				$einfo['weburl']  =  Url('resume',array('c'=>'show','id'=>$expect['id']));
				
				$return['expect'] =  $einfo;
			}

		}else if($totype==2){

			$jobs  =  $jobM->getList(array('uid'=>$toid,'state'=>1,'r_status'=>1,'status'=>0,'limit'=>50),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));

			foreach ($jobs['list'] as $jobk=>$jobv){
        		$jobv['weburl']=Url('job',array('c'=>'comapply','id'=>$jobv['id']));
				$jobData_arr[$jobv['id']] = $jobv;
			}

			$return['joblist']  =  $jobData_arr;

		}else if($totype==3){

			$ltjobs    =  $ltjobM->getList(array('uid'=>$toid,'status'=>1,'zp_status'=>0,'r_status'=>1));

			foreach ($ltjobs as $ltjobk=>$ltjobv){

				$ltjobData_arr[$ltjobv['id']] = array(
					'id'            =>  $ltjobv['id'],
					'name'          =>  $ltjobv['job_name'],
					'com_name'      =>  $ltjobv['com_name'],
					'job_salary'    =>  $ltjobv['salary'],
					'citystr'       =>  isset($ltjobv['citystr']) ? $ltjobv['citystr'] : '',
					'job_exp'       =>  $ltjobv['exp_n'],
					'job_edu'       =>  $ltjobv['edu_n']
				);
			}

			$return['joblist']  =  $ltjobData_arr;
		}

		$chatWhere  =  array('beginid'=>$br['beginid'],'orderby'=>'id','limit'=>20);

		$chatList  =  $this -> getChatLogList($chatWhere);
        
        $return['history'] = array();

		if (!empty($chatList)) {
		   
			$chatjob   =  $this -> getChatLog(array('beginid'=>$br['beginid'],'msgtype'=>'job','orderby'=>'id,ASC'),array('field'=>'`id`'));

			$chatnum   =  $this -> getChatLogNum(array('beginid'=>$br['beginid']));

			$from      =  $this -> getMember(array('uid'=>$uid,'usertype'=>$usertype),array('field'=>'`nickname`,`avatar`'));

			$to        =  $this -> getMember(array('uid'=>$toid,'usertype'=>$totype),array('field'=>'`nickname`,`avatar`'));

			foreach ($chatList as $k=>$v){
				$chatlog[$k]['chatid']       =  $v['id'];
				$chatlog[$k]['content']      =  $v['content'];
				$chatlog[$k]['sendTime']     =  $v['sendTime'];
				$chatlog[$k]['fusertype']    =  $v['fusertype'];
				$chatlog[$k]['msgtype']      =  $v['msgtype'];
				$chatlog[$k]['voicelength']  =  $v['voicelength'];
				$chatlog[$k]['voicestatus']  =  $v['voicestatus'];
				$chatlog[$k]['timefromat']   =  date('Y-m-d H:i',ceil($v['sendTime']/1000));
				$chatlog[$k]['askstatus']    =  $v['askstatus'];
				$chatlog[$k]['read']         =  $v['status'] == 1 ? 1 : 0;

				if ($v['from'] == $data['fromid']){
				   
				   	$chatlog[$k]['mine']      =  true;
				   	$chatlog[$k]['username']  =  $from['nickname'];
				   	$chatlog[$k]['avatar']    =  checkpic($from['avatar']);
				   	$chatlog[$k]['confirmcon']=  $v['tconfirm'];
				   
				}elseif ($v['to'] == $data['fromid']){
				   
				   	$chatlog[$k]['mine']      =  false;
				   	$chatlog[$k]['username']  =  $to['nickname'];
				   	$chatlog[$k]['avatar']    =  checkpic($to['avatar']);
				   	$chatlog[$k]['confirmcon']=  $v['fconfirm'];
				}
				$chatlog[$k]['newjob']        =  0;
				if ($v['id'] == $chatjob['id']){
				   
					if ($v['from'] == $data['fromid']){
					   
					   $chatlog[$k]['newjob']    =  1;
					}else{
					   $chatlog[$k]['newjob']    =  2;
					}
				}
			}
			$return['history'] =  $chatlog;
			
		}

	    return $return;
	}
	//获取所有聊天用户相关数据
	public function getAllChatOnlineData($data){

		global $db_config;

		$uid = $data['uid'];
		$usertype = $data['usertype'];

		$return = array();
		$mine = array();
		if($uid && $usertype){

			// 根据后台设置聊天记录查询日期时限来查询
		    $day      =  !empty($this->config['sy_chat_day']) ? $this->config['sy_chat_day'] : 30;
		    
		    $time     =  strtotime('-' .$day. ' day');
		    
	        // 按聊天关系查询
			$page 	  = $data['page']?$data['page']:0;
        	$size     =  10;
        
        	$cw = array('uid'=>$uid,'usertype'=>$usertype,'ntime'=>array('>=',$time),'orderby'=>'ntime','state'=>1,'limit'=>array($page*$size, $size));

        	$friends  =  $this->select_all('chat_friend', $cw,'`uid`,`usertype`,`fid`,`fusertype`,`beginid`,`chating`');

        	
        	$lt_uids 	= array();
        	$com_uids 	= array();
        	$re_uids 	= array();

        	$lt_arr = array();
        	$com_arr = array();
        	$resume_arr = array();
        	$down_resumes = array();
        	$expect_arr = array();
        	$eid_arr = array();//所有expect简历表id
        	
        	$beginid = array();

        	$expectData_arr = array();
        	$ltjobData_arr = array();
        	$jobData_arr = array();
        	$chatlog_arr = array();

        	$comjobNum_arr = array();//统计对方企业的所有职位数量
        	$ltjobNum_arr = array();//统计对方猎头的所有职位数量

        	if($usertype==1){
        		$re_uids[] 	= $uid;
        	}else if($usertype==2){
        		$com_uids[] = $uid;
        	}else if($usertype==3){
        		$lt_uids[] 	= $uid;
        	}

        	foreach ($friends as $fk => $fv) {

        		if($fv['fusertype']==3 && !in_array($fv['fid'],$lt_uids)){
        			$lt_uids[]	= $fv['fid'];
        		}else if($fv['fusertype']==2 && !in_array($fv['fid'],$com_uids)){
        			$com_uids[] = $fv['fid'];
        		}else if($fv['fusertype']==1 && !in_array($fv['fid'],$re_uids)){
        			$re_uids[] 	= $fv['fid'];
        		}
        		$akey = $fv['fusertype']==9?'a'.$fv['fid'] : $fv['fid'];

        		$return[$akey] = array('ismine'=>false,'toid'=>$fv['fid'],'totype'=>$fv['fusertype'],'beginid'=>$fv['beginid']);

        		$bd  =  explode('-', $fv['beginid']);
                // beginid组成的两个字符串都为数字
                if (is_numeric($bd[0]) && is_numeric($bd[1]) && is_numeric($bd[2])){
                    
                    $beginid[]  =  $fv['beginid'];
                }
			}

			require_once ('job.model.php');
		   	$jobM  =  new job_model($this->db, $this->def);

		   	require_once ('lietoujob.model.php');
			$ltjobM  =  new lietoujob_model($this->db, $this->def);

			$userid_msg_arr = array();

			//当前用户是个人就只查聊天记录中的职位，不然就查企业或猎头下的所有职位
    		if($usertype==2){

    			$jobs  =  $jobM->getList(array('uid'=>$uid,'state'=>1,'r_status'=>1,'status'=>0,'limit'=>50),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));
    			//查询和企业聊天的个人用户中 邀请面试情况
    			if(!empty($re_uids)){

    				$userid_msg_data	=	$this->select_all('userid_msg',array('fid'=>$uid,'uid'=>array('in',pylode(',', $re_uids)),'isdel'=>'9','groupby'=>'uid'),'`uid`,count(*) as num');

    				foreach ($userid_msg_data as $umkey => $umvalue) {
    					$userid_msg_arr[$umvalue['uid']] = $umvalue['num'];
    				}
    			}
    			
    			
    		}else if($usertype==3){

    			$ltjobs    =  $ltjobM->getList(array('uid'=>$uid,'status'=>1,'zp_status'=>0,'r_status'=>1));

    		}else if($usertype==1){
    			//企业的职位数量
    			if(!empty($com_uids)){

    				$comjobNum  =	$this->select_all('company_job',array('uid'=>array('in',pylode(',', $com_uids)),'state'=>1,'r_status'=>1,'status'=>0,'groupby'=>'uid'),'`uid`,count(*) as num');

    				foreach($comjobNum as $cjnk=>$cjnv){
    					$comjobNum_arr[$cjnv['uid']] = $cjnv['num'];
    				}

				}
				//猎头的职位数量
    			if(!empty($lt_uids)){

    				$ltjobNum  =	$this->select_all('lt_job',array('uid'=>array('in',pylode(',', $lt_uids)),'status'=>1,'zp_status'=>0,'r_status'=>1,'groupby'=>'uid'),'`uid`,count(*) as num');

    				foreach($ltjobNum as $ljnk=>$ljnv){
    					$ltjobNum_arr[$ljnv['uid']] = $ljnv['num'];
    				}
				}
    			
				$chatjobwhere = array(
        			'beginid'	=>	array('in', '"'.@implode('","', $beginid).'"'),
        			'sendTime'	=>	array('>', $time),
        		);
        		$chatjobwhere['PHPYUNBTWSTART'] = '';
        		$chatjobwhere['msgtype'][] = array('=','job');
        		$chatjobwhere['msgtype'][] = array('=','adminjob','or');
        		$chatjobwhere['PHPYUNBTWEND']    =  '';
	        	//获取聊天记录中的所有职位
	        	$chats   =  $this->select_all('chat_log',$chatjobwhere,'`from`,`to`,`fusertype`,`tusertype`,`content`,`msgtype`');
	        	
	        	if(!empty($chats)){

	        		$jobid_arr = array();
	        		$ltjobid_arr = array();

					foreach($chats as $chatkey=>$chatval){

	        			if(($chatval['msgtype']=='job'||$chatval['msgtype']=='adminjob') && strpos($chatval['content'],'jobid=')!==false){

	        				$jobid   =  trim(str_replace('jobid=', '',$chatval['content']));

	        				if($chatval['fusertype']==3 || $chatval['tusertype']==3){

	        					$ltjobid_arr[] = $jobid;

	        				}else if($chatval['fusertype']==2 || $chatval['tusertype']==2){

	        					$jobid_arr[]   = $jobid;

	        				}else if($chatval['fusertype']==9 || $chatval['tusertype']==9){

	        					$jobid_arr[]   = $jobid;

	        				}

	        			}
	        		}

	        		if($ltjobid_arr){

						$ltjobs  =  $ltjobM->getList(array('id'=>array('in',pylode(',',$ltjobid_arr)),'status'=>1,'zp_status'=>0,'r_status'=>1));

					}
		    		if($jobid_arr){

		    			$jobs  =  $jobM->getList(array('id'=>array('in',pylode(',',$jobid_arr)),'state'=>1,'r_status'=>1,'status'=>0),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));

		    		}
	        		
	        	}
	        	//获取聊天记录中的所有职位 end
	        }

	        if(!empty($jobs['list'])){
	        	foreach ($jobs['list'] as $jobk=>$jobv){
	        		$jobv['weburl']=Url('job',array('c'=>'comapply','id'=>$jobv['id']));
					$jobData_arr[$jobv['uid']][$jobv['id']] = $jobv;

				}
				//后台客勤发布的职位单独拉出来
				foreach($chats as $chatkey=>$chatval){

        			if($chatval['msgtype']=='adminjob' && strpos($chatval['content'],'jobid=')!==false){

        				$jobid   =  trim(str_replace('jobid=', '',$chatval['content']));

        				foreach ($jobs['list'] as $job_k=>$job_v){
        					if($jobid == $job_v['id']){
        						$job_v['weburl']=Url('job',array('c'=>'comapply','id'=>$job_v['id']));
        						$crmjobData_arr[$chatval['from']][$jobid] = $job_v;
        					}
        				}

        			}
        		}
	        }

	        if(!empty($ltjobs)){
	        	foreach ($ltjobs as $ltjobk=>$ltjobv){

					$ltjobData_arr[$ltjobv['uid']][$ltjobv['id']] = array(
						'id'            =>  $ltjobv['id'],
						'name'          =>  $ltjobv['job_name'],
						'com_name'      =>  $ltjobv['com_name'],
						'job_salary'    =>  $ltjobv['salary'],
						'citystr'       =>  isset($ltjobv['citystr']) ? $ltjobv['citystr'] : '',
						'job_exp'       =>  $ltjobv['exp_n'],
						'job_edu'       =>  $ltjobv['edu_n']
					);

				}
	        }
			

	        //获取对方linkman identity  数据
        	if(!empty($lt_uids)){
        		$ltdata = $this -> select_all('lt_info',array('uid'=>array('in',pylode(',',$lt_uids))),'`realname`,`uid`,`com_name`,`photo_big`,`moblie`,`wxid`');

        		foreach($ltdata as $ltk=>$ltv){
        			$lt_arr[$ltv['uid']] = $ltv;
        		}
        	}

        	if(!empty($com_uids)){

        		$comdata = $this -> select_all('company',array('uid'=>array('in',pylode(',',$com_uids))),'`name`,`uid`,`shortname`,`logo`,`linkman`,`linktel`,`wxid`');
        		
        		foreach($comdata as $ck=>$cv){
        			$com_arr[$cv['uid']] = $cv;
        		}

        	}
        	if(!empty($re_uids)){

        		$resumedata = $this -> select_all('resume',array('uid'=>array('in',pylode(',',$re_uids))),'`name`,`uid`,`photo`,`defphoto`,`phototype`,`photo_status`,`sex`,`nametype`,`def_job`,`telphone`,`wxid`');

        		foreach($resumedata as $rk=>$rv){
        			
        			$resume_arr[$rv['uid']] = $rv;
        		}

        		$expectdata = $this->select_all('resume_expect',array('uid'=>array('in',pylode(',',$re_uids)),'defaults'=>1),'`id`,`uid`,`name`');

        		foreach ($expectdata as $ek => $ev) {

        			$expect_arr[$ev['uid']] = $ev['name'];

        			if(!in_array($ev['id'],$eid_arr)){

        				$eid_arr[] = $ev['id'];//获取所有待查eid

        			}
        		}

        		if($usertype!=1){
        			$downdata  =  $this->select_all('down_resume',array('uid'=>array('in',pylode(',',$re_uids)),'comid'=>$uid,'groupby'=>'uid'),"`uid`,count(*) as `num`");
        			foreach($downdata as $dk=>$dv){
	        			$down_resumes[$dv['uid']] = $dv['downnum'];
	        		}
        		}
        	}
        	//获取对方linkman identity  数据end

        	//获取所有expect
        	if(!empty($eid_arr)){
        		$e_ids = array();
        		$e_uids = array();
        		$all_expect = array();
        		$all_resume = array();
        		
        		require_once ('resume.model.php');
           		$resumeM  =  new resume_model($this->db, $this->def);

           		$expectsData = $resumeM->getList(array('id'=>array('in',pylode(',',$eid_arr))),array('field'=>'`id`,`uid`,`name`,`exp`,`edu`,`city_classid`,`report`'));
           		$all_expect = $expectsData['list'];

           		foreach ($all_expect as $aek => $aev) {
           			if(!in_array($aev['uid'],$e_uids)){
           				$e_uids[] = $aev['uid'];
           			}
           			if(!in_array($aev['id'],$e_ids)){
           				$e_ids[] = $aev['id'];
           			}
           		}
           		if(!empty($e_uids)){

           			$all_resume = $resumeM->getResumeList(array('uid'=>array('in',pylode(',',$e_uids))),array('field'=>'`uid`,`name`,`sex`,`photo`,`phototype`,`defphoto`, `photo_status`,`birthday`,`description`'));
           			
           			foreach($all_expect as $aekey=>$aeval){

           				foreach($all_resume as $arkey=>$arval){

           					if($arval['uid'] == $aeval['uid']){

           					    $expectData_arr[$aeval['uid']]['id']    = $aeval['id'];
								$expectData_arr[$aeval['uid']]['salary'] = $aeval['salary'];
           						$expectData_arr[$aeval['uid']]['city_classname'] = $aeval['city_classname'];
           						$expectData_arr[$aeval['uid']]['exp_n'] = $aeval['exp_n'];
           						$expectData_arr[$aeval['uid']]['edu_n'] = $aeval['edu_n'];
           						$expectData_arr[$aeval['uid']]['name']  = $aeval['name'];

           						$expectData_arr[$aeval['uid']]['sex_n'] = $arval['sex_n'];
           						$expectData_arr[$aeval['uid']]['age'] 	= $arval['age_n'];
           						$expectData_arr[$aeval['uid']]['uname'] = $arval['username_n'];
           						$expectData_arr[$aeval['uid']]['description'] = mb_substr(strip_tags($arval['description']), 0, 60);;
           						$expectData_arr[$aeval['uid']]['weburl'] = Url('resume',array('c'=>'show','id'=>$aeval['id']));
           						$expectData_arr[$aeval['uid']]['photo'] = $arval['photo'];

           						
           						
           					}
           				}
           			}

           		}

           	}

        	//获取所有expect end


        	//获取互换微信 电话 的权限数据
        	$fwhere['state'] = 1;
        	
        	$fwhere['PHPYUNBTWSTART_a_DOUBLE']  =  '';
        	$fwhere['uid'] = $uid;
        	$fwhere['usertype'] = $usertype;
        	$fwhere['PHPYUNBTWEND_a']    =  '';

        	$fwhere['PHPYUNBTWSTART_b']  =  'OR';
        	$fwhere['fid'] = $uid;
        	$fwhere['fusertype'] = $usertype;
        	$fwhere['PHPYUNBTWEND_b_DOUBLE']    =  '';

	        
        	$friend_all  =  $this->select_all('chat_friend',$fwhere,'`uid`,`usertype`,`beginid`,`fid`,`fusertype`,`wx`,`tel`');
        	
        	$friend_can	 =	array();

        	foreach ($friend_all as $fak => $fav) {
        		if($fav['beginid'] && $fav['uid']){
        			$friend_can[$fav['beginid']][$fav['uid']] = $fav;
        		}
        	}

        	//获取互换微信 电话 的权限数据 end


			//获取聊天历史记录信息
        	if(!empty($beginid)){

	        	$chat_member_list = array();
	        	$chatjob_ids= array();

        		
        		$user_chatmember_list  =  $this -> select_all('chat_member',array('uid'=>array('in',pylode(',',$re_uids)),'usertype'=>1),'`uid`,`nickname`,`usertype`,`avatar`');
        		$com_chatmember_list   =  $this -> select_all('chat_member',array('uid'=>array('in',pylode(',',$com_uids)),'usertype'=>2),'`uid`,`nickname`,`usertype`,`avatar`');
        		$lt_chatmember_list    =  $this -> select_all('chat_member',array('uid'=>array('in',pylode(',',$com_uids)),'usertype'=>3),'`uid`,`nickname`,`usertype`,`avatar`');

        		foreach ($user_chatmember_list as $uclk => $uclv) {
        			$chat_member_list[$uclv['uid']][$uclv['usertype']] = $uclv;
        		}
        		foreach ($com_chatmember_list as $cclk => $cclv) {
        			$chat_member_list[$cclv['uid']][$cclv['usertype']] = $cclv;
        		}
        		foreach ($lt_chatmember_list as $lclk => $lclv) {
        			$chat_member_list[$lclv['uid']][$lclv['usertype']] = $lclv;
        		}

        		$chatlogjobwhere = array(
        			'field'=>'`id`',
        			'beginid'=>	array('in',@implode(',',$beginid)),
        			'groupby'=>	'beginid'
        		);

        		$chatlogjobwhere['PHPYUNBTWSTART'] = '';
        		$chatlogjobwhere['msgtype'][] = array('=','job');
        		$chatlogjobwhere['msgtype'][] = array('=','adminjob','or');
        		$chatlogjobwhere['PHPYUNBTWEND']    =  '';

        		$chatjobList  =  $this -> getChatLogList($chatlogjobwhere);
        		foreach ($chatjobList as $cjlk => $cjlv) {
        			$chatjob_ids[] = $cjlv['id'];
        		}

        		$chatloglimit	=	20;

        		$chatlog_sql 	=	 "SELECT * FROM $db_config[def]chat_log a WHERE a.`beginid` IN(\"".@implode('","',$beginid)."\") AND (SELECT count(`id`) FROM $db_config[def]chat_log WHERE `beginid` = a.`beginid` AND `id` > a.`id`) < ".$chatloglimit." ORDER BY a.`beginid`,a.`id` desc";

        		$chatList       =   $this->DB_query_all($chatlog_sql,'all');
        		
        		foreach ($chatList as $chatk=>$chatv){
        			$chatlog = array();
					$chatlog['chatid']       =  $chatv['id'];
					$chatlog['content']      =  $chatv['content'];
					$chatlog['sendTime']     =  $chatv['sendTime'];
					$chatlog['fusertype']    =  $chatv['fusertype'];
					$chatlog['msgtype']      =  $chatv['msgtype'];
					$chatlog['voicelength']  =  $chatv['voicelength'];
					$chatlog['voicestatus']  =  $chatv['voicestatus'];
					$chatlog['timefromat']   =  date('Y-m-d H:i',ceil($chatv['sendTime']/1000));
					$chatlog['askstatus']    =  $chatv['askstatus'];
					$chatlog['read']         =  $chatv['status'] == 1 ? 1 : 0;

					if ($chatv['from'] == $uid){
					   
					   $chatlog['mine']      =  true;
					   $chatlog['username']  =  $chat_member_list[$uid][$usertype]['nickname'];
					   $chatlog['avatar']    =  checkpic($chat_member_list[$uid][$usertype]['avatar'],$this->config['sy_chat_logo']);
					   $chatlog['confirmcon']=  $chatv['tconfirm'];
					   
					}else{
					   
					   $chatlog['mine']      =  false;
					   $chatlog['username']  =  $chat_member_list[$chatv['from']][$chatv['fusertype']]['nickname'];
					   $chatlog['avatar']    =  checkpic($chat_member_list[$chatv['from']][$chatv['fusertype']]['avatar'],$this->config['sy_chat_logo']);
					   $chatlog['confirmcon']=  $chatv['fconfirm'];
					}
					$chatlog['newjob']        =  0;
					if (in_array($chatv['id'],$chatjob_ids)){

						if ($chatv['from'] == $uid){
						   
						   $chatlog['newjob']    =  1;
						}else{
						   $chatlog['newjob']    =  2;
						}
					}
					$chatlog_arr[$chatv['beginid']][] = $chatlog;
        		}
        	}
        	//获取聊天历史记录信息 end


        	foreach ($return as $toid => $val) {
        		$toid_v = $val['toid'];
        		//获取互换微信 电话 的权限
        		if($friend_can[$val['beginid']][$toid_v]['wx']==1 && $friend_can[$val['beginid']][$uid]['wx']==1){
	                $canwx = 1;//同意互换
	            }else{
	                if($friend_can[$val['beginid']][$toid_v]['wx']==3){
	                    $canwx = 3;//发出请求等待对方操作
	                }else{
	                    $canwx = 0;//尚未请求
	                }
	            }

	            if($friend_can[$val['beginid']][$toid_v]['tel']==1 && $friend_can[$val['beginid']][$uid]['tel']==1){
	                $cantel = 1;//同意互换
	            }else{
	                if($friend_can[$val['beginid']][$toid_v]['tel']==3){
	                    $cantel = 3;//发出请求等待对方操作
	                }else{
	                    $cantel = 0;//尚未请求
	                }
	            }
	            $return[$toid]['inviteNum'] = 0;
	            if($usertype==2 && !empty($userid_msg_arr[$toid])){
	            	$return[$toid]['inviteNum'] = $userid_msg_arr[$toid];
	            }

	            $return[$toid]['canwx'] = $canwx;

	            $return[$toid]['cantel'] = $cantel;

	            //获取互换微信 电话 的权限 end
	           
	            //获取对方linkman identity
        		if($val['totype']==1 && !empty($resume_arr[$toid_v])){

					$return[$toid]['nickname']  =  $resume_arr[$toid_v]['name'];
					$return[$toid]['tel']       =  $resume_arr[$toid_v]['telphone'];
					$return[$toid]['wxid']      =  $resume_arr[$toid_v]['wxid'];

					$photoArr  =  array('photo' => $resume_arr[$toid_v]['photo'], 'defphoto'=> $resume_arr[$toid_v]['defphoto'],'phototype'=> $resume_arr[$toid_v]['phototype'], 'photo_status' => $resume_arr[$toid_v]['photo_status'], 'sex' => $resume_arr[$toid_v]['sex']);

					$return[$toid]['avatar']    =  $this->setResumePhotoShow($photoArr);
					$return[$toid]['linkman']   =  $resume_arr[$toid_v]['name'];
					
					if ($down_resumes[$toid_v] && $down_resumes[$toid_v] > 0){
					   
					   $return[$toid]['linkman']=  $resume_arr[$toid_v]['name'];
					}else{
					   
					   $nameArr  =  array(
					       'name'     => $resume_arr[$toid_v]['name'],
					       'sex'      => $resume_arr[$toid_v]['sex'],
					       'nametype' => $resume_arr[$toid_v]['nametype'],
					       'eid'      => $resume_arr[$toid_v]['def_job']
					   );
					   $return[$toid]['linkman']   =  $this->setUsernameShow($nameArr);
					}

					$return[$toid]['nowtype']   =  $usertype;
					$return[$toid]['name']      =  $resume_arr[$toid_v]['name'];

					if (!empty($expect_arr[$toid_v])){

					   if (mb_strlen($expect_arr[$toid_v]) > 20){
					       $return[$toid]['identity']  =  mb_substr($expect_arr[$toid_v], 0, 20) . '...';
					   }else{
					       $return[$toid]['identity']  =  $expect_arr[$toid_v];
					   }
					   
					}else{
					   
					   $return[$toid]['identity']  =  '求职者';
					}
				}else if($val['totype']==2 && !empty($com_arr[$toid_v])){

					$name  =  $com_arr[$toid_v]['name'];

					$return[$toid]['nickname']  =  !empty($com_arr[$toid_v]['shortname']) ? $com_arr[$toid_v]['shortname'] : $name;

					if (!empty($com_arr[$toid_v]['logo'])){
					   
					   $return[$toid]['avatar'] =  $com_arr[$toid_v]['logo'];
					}else{
					   $return[$toid]['avatar'] =  $this->config['sy_unit_icon'];
					}

					$return[$toid]['linkman']   =  $com_arr[$toid_v]['linkman'];

					$return[$toid]['identity']  =  $return[$toid_v]['nickname'].'.招聘者';
					$return[$toid]['tel']       =  $com_arr[$toid_v]['linktel'];
					$return[$toid]['wxid']      =  $com_arr[$toid_v]['wxid'];

					$return[$toid]['comalljobnum']    =  $comjobNum_arr[$toid_v];

				}else if($val['totype']==3 && !empty($lt_arr[$toid_v])){

					$return[$toid]['nickname']  =  $lt_arr[$toid_v]['realname'];

					if (!empty($lt_arr[$toid_v]['photo_big'])){

						$return[$toid]['avatar']  =  $lt_arr[$toid_v]['photo_big'];
					}else{
						$return[$toid]['avatar']  =  $this->config['sy_lt_icon'];
					}

					$return[$toid]['linkman']   =  $return[$toid_v]['nickname'];

					$return[$toid]['identity']  =  $lt_arr[$toid_v]['com_name'].'.招聘者';
					$return[$toid]['tel']       =  $lt_arr[$toid_v]['moblie'];
					$return[$toid]['wxid']      =  $lt_arr[$toid_v]['wxid'];

					$return[$toid]['comalljobnum']    =  $ltjobNum_arr[$toid_v];

				}else if($val['totype']==9){
					$return[$toid]['linkman']   =  '官方客服';
				}
				//获取对方linkman identity   end

				//简历数据
				$return[$toid]['expect'] = !empty($expectData_arr[$toid_v]) ? $expectData_arr[$toid_v] : array();

				//职位数据
				$return[$toid]['joblist'] = array();
				if($val['totype']==3 && $ltjobData_arr[$toid_v]){
					$return[$toid]['joblist'] = $ltjobData_arr[$toid_v];
				}else if($val['totype']==2 && $jobData_arr[$toid_v]){
					$return[$toid]['joblist'] = $jobData_arr[$toid_v];
				}else if($val['totype']==9 && $crmjobData_arr[$toid_v]){
					$return[$toid]['joblist'] = $crmjobData_arr[$toid_v];
				}
				//聊天数据
				$return[$toid]['history'] = $chatlog_arr[$val['beginid']]?$chatlog_arr[$val['beginid']]:array();
				
			}
			//当前聊天者自身的相关信息
        	$mine = array(
        		'ismine'	=>	true,
        		'expect'	=>	!empty($expectData_arr[$uid]) ? $expectData_arr[$uid] : array(),
        		'joblist'	=>	array()
        	);
        	if($usertype==3 && !empty($ltjobData_arr[$uid])){

        		$mine['joblist'] = $ltjobData_arr[$uid];

        	}else if($usertype==2 && !empty($jobData_arr[$uid])){

        		$mine['joblist'] = $jobData_arr[$uid];

        	}
        	//当前聊天者自身的相关信息 end

		}

		$result['toall'] = $return;
		$result['mine'] = $mine;

		return $result;
	}
	/**
	 * 查询聊天记录
	 * @param number $uid
	 * @param number $usertype
	 * @param number $page
	 * @param number $friend // 是否展示全部好友列表（没有聊天记录也展示）
	 */
	public function getHistory($uid, $usertype, $page = 0, $isfriend = 0, $cate = 'all'){
        // 根据后台设置聊天记录查询日期时限来查询
	    $day      =  !empty($this->config['sy_chat_day']) ? $this->config['sy_chat_day'] : 30;
	    
	    $time     =  strtotime('-' .$day. ' day');
	    $history  =  array();
        $size     =  10;
        
        $cw = array('uid'=>$uid,'usertype'=>$usertype,'ntime'=>array('>=',$time),'orderby'=>'ntime','state'=>1,'limit'=>array($page*$size, $size));
        if ($cate == 'new'){
            // 招呼
            $cw['chating'] = 1;
        }elseif ($cate == 'old'){
            // 沟通中
            $cw['chating'] = array('<>', 1);
        }
        // 按聊天关系查询
        $friends  =  $this->select_all('chat_friend', $cw,'`uid`,`usertype`,`fid`,`fusertype`,`beginid`,`chating`,`ntime`');
        
        if (!empty($friends)){
            
            foreach ($friends as $v){
                
                $bd  =  explode('-', $v['beginid']);
                // beginid组成的两个字符串都为数字
                if (is_numeric($bd[0]) && is_numeric($bd[1]) && is_numeric($bd[2])){
                    
                    $fuid[]     =  $v['fid'];
                    $beginid[]  =  $v['beginid'];
                }
            }
            
            if (!empty($beginid)){
                
                $beginid  =  array_unique($beginid);
                // 按beginid查出最新聊天记录id
                $fchats   =  $this->select_all('chat_log', array('beginid'=>array('in', "\"".@implode('","',$beginid)."\""),'groupby'=>'beginid'), 'MAX(`id`) AS `id`');
                
                foreach ($fchats as $v){
                    
                    $chatid[]  =  $v['id'];
                }
                
                // 通过最新聊天记录id来查询聊天记录
                $chats   =  $this->select_all('chat_log', array('id'=>array('in', pylode(',', $chatid)),'orderby'=>'id'), '`beginid`,`from`,`fusertype`,`to`,`tusertype`,`sendTime`,`content`,`msgtype`');
                
                $fuid    =  array_filter(array_unique($fuid));
                
                $from    =  $this -> select_all('chat_member', array('uid'=>array('in',pylode(',', $fuid)),'usertype'=>array('<>',$usertype)),'`uid`,`usertype`,`nickname`,`linkman`,`avatar`');
                
                $unreadtime  =  strtotime('-' .$day. ' day') * 1000;
                
                $unread  =  $this -> select_all('chat_log',array('to'=>$uid,'tusertype'=>$usertype,'status'=>2,'sendTime'=>array('>',$unreadtime),'groupby'=>'`from`'),'`id`,`from`,`fusertype`,count(*) as `num`');
                
                if ($usertype == 2 || $usertype == 3 || $usertype == 9){
                    
                    $resume  =  $this -> select_all('resume', array('uid'=>array('in',pylode(',', $fuid))),'`uid`,`name`,`sex`,`nametype`,`def_job`');
                    $expect  =  $this -> select_all('resume_expect', array('uid'=>array('in',pylode(',', $fuid)),'defaults'=>1,'state'=>'1'),'uid,name');
                    if ($usertype == 2 || $usertype == 3){
                        $down    =  $this -> select_all('down_resume', array('comid'=>$uid,'uid'=>array('in',pylode(',', $fuid))),'`uid`');
                    }
                    
                    foreach ($resume as $k=>$v){
                        if ($usertype == 9){
                            $resume[$k]['linkman']  =  $v['name'];
                        }else{
                            $nameArr  =  array();
                            $nameArr['name']      =  $v['name'];
                            $nameArr['sex']       =  $v['sex'];
                            $nameArr['nametype']  =  $v['nametype'];
                            $nameArr['eid']       =  $v['def_job'];
                            
                            $resume[$k]['linkman']  =  $this->setUsernameShow($nameArr);
                            foreach ($down as $dv){
                                if ($v['uid'] == $dv['uid']){
                                    $resume[$k]['linkman']  =  $v['name'];
                                }
                            }
                        }
                    }
                }
                if ($usertype == 1){
                    
                    $usersq    =  $this -> select_all('userid_job', array('uid'=>$uid,'com_id'=>array('in',pylode(',', $fuid))),'`com_id`');
                }
                foreach ($from as $k=>$v){
                    $from[$k]['unread']  =  0;
                    foreach ($unread as $uval){
                        if ($v['uid'] == $uval['from'] && $v['usertype'] == $uval['fusertype']){
                            $from[$k]['unread']  =  $uval['num'];
                        }
                    }
                    if (!empty($resume)){
                        foreach ($resume as $rval){
                            if ($v['uid'] == $rval['uid']){
                                $from[$k]['linkman']  =  $rval['linkman'];
                            }
                        }
                    }
                    if (!empty($expect)){
                        foreach ($expect as $eval){
                            if ($v['uid'] == $eval['uid']){
                                $from[$k]['expect']  =  $eval['name'];
                            }
                        }
                    }
                }
                $flist  =  array();
                
                foreach ($friends as $key=>$val){
                    
                    $flist[$key]['from']       =  $val['uid'];
                    $flist[$key]['fusertype']  =  $val['usertype'];
                    $flist[$key]['to']         =  $val['fid'];
                    $flist[$key]['tusertype']  =  $val['fusertype'];
                    $flist[$key]['chating']    =  $val['chating'];
                    $flist[$key]['content']    =  '';
                    $flist[$key]['msgtype']    =  '';
                    
                    foreach ($chats as $k=>$v){
                        if ($val['beginid'] == $v['beginid']){
                            
                            $flist[$key]['from']       =  $v['from'];
                            $flist[$key]['fusertype']  =  $v['fusertype'];
                            $flist[$key]['to']         =  $v['to'];
                            $flist[$key]['tusertype']  =  $v['tusertype'];
                            $flist[$key]['content']    =  $v['content'];
                            $flist[$key]['sendTime']   =  $v['sendTime'];
                            $flist[$key]['msgtype']    =  $v['msgtype'];
                        }
                    }
                    //没有聊天记录的，要判断是否需要在聊天列表
                    if($flist[$key]['content']=='' && $isfriend == 0){
                        unset($flist[$key]);
                    }
                }
                foreach ($flist as $key=>$val){
                    foreach ($friends as $k=>$v){
                        if ($val['to'] == $v['fid'] && empty($val['sendTime'])){
                            // 没有聊天记录，按聊天关系表时间处理
                            $flist[$key]['sendTime'] = $v['ntime'] * 1000;
                        }
                    }
                }
                $today = strtotime('today');
                foreach ($flist as $key=>$val){
                    foreach ($from as $k=>$v){
                        if (($val['from']==$v['uid'] && $val['fusertype'] == $v['usertype']) || ($val['to']==$v['uid'] && $val['tusertype'] == $v['usertype'])){
                            
                            if ($val['from'] == $uid){
                                $hkey  =  $val['to'];
                            } elseif ($val['to'] == $uid){
                                $hkey  =  $val['from'];
                            }
                            if($v['usertype'] == 9){
                                // 管理员与其他用户身份的不同
                                $hkey = 'a' .$hkey;
                            }
                            if (isset($hkey)){
                                $msg        =  array();
                                $msg['id']  =  $hkey;
                                if (strpos($val['content'],'img[http')!==false){
                                    $msg['content']  =  '[图片]';
                                }elseif (strpos($val['content'],'voice[http')!==false){
                                    $msg['content']  =  '[语音]';
                                }elseif (strpos($val['content'],'inviteid=')!==false){
                                    $msg['content']  =  '面试消息';
                                }elseif (strpos($val['content'],'eid=')!==false){
                                    $msg['content']  =  '简历消息';
                                }elseif (strpos($val['content'],'jobid=')!==false){
                                    $msg['content']  =  '职位消息';
                                }elseif (strpos($val['content'],'ask=')!==false){
                                    $msg['content']  =  '请求互换联系方式';
                                }elseif (strpos($val['content'],'confirm=')!==false){
                                    $msg['content']  =  '互换联系方式';
                                }elseif (strpos($val['content'],'refuse=')!==false){
                                    $msg['content']  =  '互换联系方式';
                                }else{
                                    $msg['content']  =  $val['content'];
                                }
                                if ($val['msgtype'] == 'spview'){
                                    $msg['content']  =  '[视频面试]';
                                }elseif ($val['msgtype'] == 'map'){
                                    $msg['content']  =  '[位置]';
                                }
                                if(ceil($val['sendTime']/1000)>$today){
                                    $msg['time']  =  date('H:i',ceil($val['sendTime']/1000));
                                }else{
                                    $msg['time']  =  date('m-d',ceil($val['sendTime']/1000));
                                }
                                
                                if(!empty($v['unread'])){
                                    $msg['unread']  =  $v['unread'];
                                }
                                if ($val['from'] == $uid && $val['fusertype'] == $usertype){
                                    $msg['mine']    =  true;
                                    $msg['tusertype']  =  $val['tusertype'];
                                    $msg['fusertype']  =  $val['fusertype'];
                                }elseif ($val['to'] == $uid && $val['tusertype'] == $usertype){
                                    $msg['mine']    =  false;
                                    $msg['tusertype']  =  $val['fusertype'];
                                    $msg['fusertype']  =  $val['tusertype'];
                                }
                                $msg['username']    =  $v['nickname'];
                                $msg['usertype']    =  $v['usertype'];
                                $msg['linkman']     =  $v['linkman'];
                                $msg['avatar']      =  checkpic($v['avatar'] , $this->config['sy_chat_logo']);
                                $msg['expect']      =  isset($v['expect']) ? $v['expect'] : '';
                                $msg['chating']     =  $val['chating'];
                                
                                $history[]  =  $msg;
                            }
                        }
                    }
                }
            }
        }
        
        return $history;
   }
   /**
    * 更新并获取用户信息
    * @param string $uid
    * @return string
    */
   function userinfo($data = array('uid'=>'','usertype'=>'','history'=>'', 'friend'=>0))
   {
       if ($data['usertype'] == 9){
           // 管理员
           $return['mine'] = array(
               'avatar'    =>  checkpic($this->config['sy_chat_logo']),
               'id'        =>  'a' . $data['uid'],
               'username'  =>  '求职助手',
               'usertype'  =>  9,
               'linkman'   =>  '官方客服',
               'identity'  =>  '',
               'tel'       =>  '',
               'wxid'      =>  ''
           );
       }else{
           if (empty($data['uid']) || empty($data['usertype'])){
               
               return array();
           }
           $bArr  =  array(
               'uid'       =>  $data['uid'],
               'usertype'  =>  $data['usertype']
           );
           if (!empty($data['nowid']) && !empty($data['nowtype'])){
               
               $bArr['nowid']    =  $data['nowid'];
               $bArr['nowtype']  =  $data['nowtype'];
           }
           
           $user  =  $this -> getBeginInfo($bArr);
           
           $this -> checkMember($user);
           
           //聊天用户信息
           $return['mine'] = array(
               'avatar'    =>  checkpic($user['avatar']),
               'id'        =>  $user['uid'],
               'username'  =>  $user['nickname'],
               'usertype'  =>  $user['usertype'],
               'linkman'   =>  $user['linkman'],
               'identity'  =>  $user['identity'],
               'tel'       =>  $user['tel'],
               'wxid'      =>  $user['wxid']
           );
           if (!empty($data['history'])){
               
               $return['history']  =  $this -> getHistory($user['uid'], $user['usertype'], 0, $data['friend']);
           }
       }
       return $return;
   }
   /**
    * 判断聊天用户
    * @param 表：chat_member
    * @param 引用字段：$data:字段
    */
   public function checkMember($chat = array())
   {
       $chatMember  =  $this -> select_once('chat_member', array('uid'=>$chat['uid'],'usertype'=>$chat['usertype']), '`uid`,`nickname`,`avatar`,`linkman`');
       
       $arr  =  array(
           'nickname'  =>  $chat['nickname'],
           'avatar'    =>  $chat['avatar'],
           'linkman'   =>  $chat['linkman']
       );
       if (!empty($chatMember)){
           // 有内容不一致时，才需要修改
           if ($chatMember['nickname'] != $arr['nickname'] || $chatMember['avatar'] != $arr['avatar'] || $chatMember['linkman'] != $arr['linkman']){
               $this -> upMember($arr,array('uid'=>$chat['uid'],'usertype'=>$chat['usertype']));
           }
           
       }else{
           
           $arr['uid']       =  $chat['uid'];
           $arr['usertype']  =  $chat['usertype'];
           
           $this -> addMember($arr);
       }
   }
   function getBeginInfo($data = array())
   {
       include_once('userinfo.model.php');
       
       $userinfoM  =  new userinfo_model($this->db, $this->def);
       
       if ($data['usertype'] == 1){
           
           $field  =  '`name`,`photo`,`phototype`,`photo_status`,`sex`,`nametype`,`def_job`,`telphone`,`wxid`,`defphoto`';
           
       }elseif ($data['usertype']==2){
           
           $field  =  '`name`,`shortname`,`logo`,`linkman`,`linktel`,`wxid`';
           
       }elseif ($data['usertype']==3){
           
           $field  =  '`realname`,`com_name`,`photo_big`,`moblie`,`wxid`';
       }
       $userinfo   =  $userinfoM -> getUserInfo(array('uid'=>$data['uid']),array('usertype'=>$data['usertype'],'field'=>$field));
       
       if ($data['usertype'] == 1){
           
           $user['nickname']  =  $userinfo['name'];
           $user['tel']       =  $userinfo['telphone'];
           $user['wxid']      =  $userinfo['wxid'];
           
           $photoArr  =  array('photo' => $userinfo['photo'], 'phototype'=> $userinfo['phototype'], 'photo_status' => $userinfo['photo_status'], 'sex' => $userinfo['sex'],'defphoto'=>$userinfo['defphoto']);
           $user['avatar']    =  $this->setResumePhotoShow($photoArr);
           
           if (!empty($data['nowtype']) && $data['nowtype'] != 1){
               
               $down  =  $this->select_num('down_resume',array('uid'=>$data['uid'],'comid'=>$data['nowid']));
               
               if ($down > 0){
                   
                   $user['linkman']   =  $userinfo['name'];
               }else{
                   
                   $nameArr  =  array(
                       'name'     => $userinfo['name'],
                       'sex'      => $userinfo['sex'],
                       'nametype' => $userinfo['nametype'],
                       'eid'      => $userinfo['def_job']
                   );
                   $user['linkman']   =  $this->setUsernameShow($nameArr);
               }
               
               $user['nowtype']   =  $data['nowtype'];
               $user['name']      =  $userinfo['name'];
               
           }else{
               
               $user['linkman']   =  $userinfo['name'];
           }
           
           $expect  =  $this->select_once('resume_expect',array('uid'=>$data['uid'],'defaults'=>1),'`name`');
           
           if (!empty($expect)){
               
               if (mb_strlen($expect['name']) > 20){
                   $user['identity']  =  mb_substr($expect['name'], 0, 20) . '...';
               }else{
                   $user['identity']  =  $expect['name'];
               }
               
           }else{
               
               $user['identity']  =  '求职者';
           }
           
       }elseif ($data['usertype'] == 2){
           
           $name  =  $userinfo['name'];
           
           $user['nickname']  =  !empty($userinfo['shortname']) ? $userinfo['shortname'] : $name;
           
           if (!empty($userinfo['logo'])){
               
               $user['avatar']  =  $userinfo['logo'];
           }else{
               $user['avatar']  =  $this->config['sy_unit_icon'];
           }
           
           $user['linkman']   =  $userinfo['linkman'];
           
           $user['identity']  =  $user['nickname'].'.招聘者';
           $user['tel']       =  $userinfo['linktel'];
           $user['wxid']      =  $userinfo['wxid'];
           
       }elseif ($data['usertype'] == 3){
           
           $user['nickname']  =  $userinfo['realname'];
           
           if (!empty($userinfo['photo_big'])){
               
               $user['avatar']  =  $userinfo['photo_big'];
           }else{
               $user['avatar']  =  $this->config['sy_lt_icon'];
           }
           
           $user['linkman']   =  $user['nickname'];
           
           $user['identity']  =  $userinfo['com_name'].'.招聘者';
           $user['tel']       =  $userinfo['moblie'];
           $user['wxid']      =  $userinfo['wxid'];
           
       }
       $user['uid']       =  $data['uid'];
       $user['usertype']  =  $data['usertype'];
       
       if (empty($user['nickname'])){
           
           $member  =  $this->select_once('member',array('uid'=>$data['uid']), '`username`');
           
           if (CheckMobile($member['username'])){
               // 手机号用户名，才需要处理
               $user['nickname'] = substr_replace($member['username'],'****',4,4);
           }else{
               $user['nickname'] = $member['username'];
           }
       }
       
       return $user;
   }
   function beginChat($data = array())
   {
       // 首先处理接受方信息
       $fu  =  $this -> userinfo(array('uid'=>$data['fromid'],'usertype'=>$data['fusertype']));
       //二人聊天专用id，这两个人的聊天记录，就按这个查询
       $br  =  $this->getBeginid($data);
       
       return array('error'=>0,'time'=>time(),'br'=>$br);
   }
   /**
    * 查询两人聊天专用id
    * @param array $data
    */
   function getBeginid($data = array(), $type = '')
   {
       $time = time();
       // 查询、处理聊天关系
       $farr  =  array(
           'uid'        =>  $data['fromid'],
           'usertype'   =>  $data['fusertype'],
           'fid'        =>  $data['toid'],
           'fusertype'  =>  $data['tusertype']
       );
       $friend  =  $this->getFriend($farr);
       
       if (empty($friend)){
           
           if ($type == 'get'){
               // 只是查找。没查到，返回空数组
               return array();
           }
           //二人聊天专用id，这两个人的聊天记录，就按这个查询
           $beginid  =  $this->searchBeginid(array('toid'=>$data['toid'],'fromid'=>$data['fromid'],'tusertype'=>$data['tusertype'],'fusertype'=>$data['fusertype']));
           
           $farr['beginid']  =  $beginid;
           $farr['ntime']    =  $time;
           $farr['chating']  =  1;
           $this->addFriend($farr);
           // 为聊天对象也增加一条记录
           $parr  =  array(
               'uid'        =>  $data['toid'],
               'usertype'   =>  $data['tusertype'],
               'fid'        =>  $data['fromid'],
               'fusertype'  =>  $data['fusertype'],
               'beginid'    =>  $beginid,
               'ntime'      =>  $farr['ntime'],
               'chating'    =>  1
           );
           $this->addFriend($parr);
           
           $ischat  =  false;
       }else {
           if (!empty($friend['beginid'])){
               
               $beginid  =  $friend['beginid'];
               $ischat   =  true;
           }else{
               //二人聊天专用id，这两个人的聊天记录，就按这个查询
               $beginid  =  $this->searchBeginid(array('toid'=>$data['toid'],'fromid'=>$data['fromid'],'tusertype'=>$data['tusertype'],'fusertype'=>$data['fusertype']));
               
               $this->upFriend(array('id'=>$friend['id']),array('beginid'=>$beginid));
               
               $ischat  =  true;
           }
       }
       
       $return  =  array(
           'beginid'  =>  $beginid,
           'ischat'   =>  $ischat,
           'ntime'    =>  $farr['ntime'],
           'uid'      =>  $data['fusertype'] == 1 ? $data['fromid'] : $data['toid'],
           'comid'    =>  $data['fusertype'] == 1 ? $data['toid'] : $data['fromid'],
           'comtype'  =>  $data['fusertype'] == 3 || $data['tusertype'] == 3 ? 3 : 2  // comid身份
       );
       return $return;
   }
   /**
    * 处理初始biginid
    */
   private function searchBeginid($data = array())
   {
       $chatto    =  $this -> getChatLog(array('from'=>$data['fromid'],'fusertype'=>$data['fusertype'],'to'=>$data['toid'],'tusertype'=>$data['tusertype']));
       
       if (!empty($chatto['beginid'])){
           
           $beginid  =  $chatto['beginid'];
           
       } else{
           
           $chatfrom  =  $this -> getChatLog(array('from'=>$data['toid'],'fusertype'=>$data['tusertype'],'to'=>$data['fromid'],'tusertype'=>$data['fusertype']));
           
           if (!empty($chatfrom['beginid'])){
               
               $beginid  =  $chatfrom['beginid'];
               
           } else {
               
               $return['ischat']   =  false;
               $beginid  =  $data['fromid'].'-'.$data['toid'].'-'.$data['fusertype'].$data['tusertype'];
           }
       }
       
       return $beginid;
   }
	//聊天内容检测  检测文本 图片
	function chatConCheck($data=array()){

		$content 	= $data['content'];
		$msgtype 	= $data['msgtype'];
		$uid 		= $data['fromid'];
		$usertype 	= $data['fusertype'];
		$action 	= isset($data['action'])?$data['action']:'';

		$return = array('error'=>9,'errmsg'=>'');

		if($this->config['sy_chat_concheck']==2 && $msgtype=='char'){

			$check_con_data = array(
	            
	            'uid'       =>  $uid,
	            'usertype'  =>  $usertype,
	            'ctype'     =>  5,
	            'cid'       =>  $uid,
	            'action'    =>  $action
	        );
	        if(isset($data['source'])){
	            $check_con_data['source'] = $data['source'];
	        }
	        if(isset($data['openid'])){
	            $check_con_data['openid'] = $data['openid'];
	        }

			if (strpos($content,'img[http')!==false){
				
				preg_match('/img\[([^\s]+?)\]/u',$content,$m);
	            $check_con_data['type'] = 'pic';
                $check_con[] = $m[1];
            }else{
            	$check_con_data['type'] = 'text';
            	$check_con[] = $content;
            }

        	if(!empty($check_con)){
        	    
        	    require_once('concheck.model.php');
        	    $concheckM  =  new concheck_model($this->db,$this->def);
	            $cresult = $concheckM->checkContent($check_con,$check_con_data);

	            $code   =   isset($cresult['code']) ? $cresult['code'] : 0;
	            
	            if ($code != 1) {
	                $return['error'] = 3;
	                $return['errmsg'] = '发送内容涉嫌违规，请和谐聊天';
	            }
	        }
		}

		return $return;
	}
   /**
    * 信息发送时添加发送记录
    */
   function chatLog($data = array()){
       
       if (!empty($data['fromid']) && !empty($data['fusertype'])){
           // 处理管理员id
           $data['toid']  =  str_replace('a', '', $data['toid']);
           
           if ($data['fromid'] == $data['nowid'] && $data['fusertype'] == $data['nowtype']){
               
               $barr  =  array(
                   'fid'        =>  $data['fromid'],
                   'fusertype'  =>  $data['fusertype'],
                   'uid'        =>  $data['toid'],
                   'usertype'   =>  $data['tusertype']
               );
               
               $friend  =  $this->getFriend($barr);
               if (!empty($friend) && $friend['state'] == 2){
                   $return['error']   =  3;
                   $return['errmsg']  =  '对方已将你拉入黑名单，无法'.$this->config['sy_chat_name'];
                   return $return;
               }
               // 获取聊天专用id
               if (!empty($friend['beginid'])){
                   
                   $beginid  =  $friend['beginid'];
                   
               }else{
                   
                   $br       =  $this->getBeginid($data);
                   $beginid  =  $br['beginid'];
               }
               
               $from  =  $this -> getMember(array('uid'=>$data['fromid'],'usertype'=>$data['fusertype']),array('field'=>'`uid`,`usertype`,`nickname`'));
               $to    =  $this -> getMember(array('uid'=>$data['toid'],'usertype'=>$data['tusertype']),array('field'=>'`uid`,`usertype`,`nickname`'));
               
               $ccresult = $this->chatConCheck($data);
				if($ccresult['error']!=9){
					return $ccresult;
				}

               $this -> upChatLog(array('last'=>0), array('beginid'=>$beginid,'last'=>1));
               
               $log['from']      =  $from['uid'];
               $log['to']        =  $to['uid'];
               $log['beginid']   =  $beginid;
               $log['fname']     =  $from['nickname'];
               $log['tname']     =  $to['nickname'];
               $log['fusertype'] =  $from['usertype'];
               $log['tusertype'] =  $to['usertype'];
               $log['content']   =  $data['content'];
               $log['sendTime']  =  $this->checkTime($data['timestamp']);
               $log['msgtype']   =  $data['msgtype'];
               $log['voicelength']=  $data['voicelength'];
               $log['status']    =  2;
               $log['last']      =  1;
               $log['receive']   =  2;

               //如果是请求互换联系方式，记录该条聊天请求状态askstatus为3
               if($data['msgtype']=='ask'){

                  $askid              = str_replace('ask=', '', $data['content']);

                  $wheref             = array('uid'=>$data['fromid'],'fid'=>$data['toid'],'usertype'=>$data['fusertype'],'fusertype'=>$data['tusertype']);
                  $friend_f           = $this->getFriend($wheref);

                  $log['askstatus']   = 3;
                  $log['askvalue']    = $friend_f[$askid.'_tem'];

               }
               //如果是确认互换联系方式，则将双方的暂存于chat_friend表中的数据取出，之前的请求互换的聊天状态askstatus改为1
               if($data['msgtype']=='confirm'){

                  if (strpos($data['content'],'confirm=')!==false){

                      $confirmid = str_replace('confirm=', '', $data['content']);

                      if($confirmid == 'wx' || $confirmid=='tel'){


                        $where1   = array('uid'=>$data['fromid'],'fid'=>$data['toid'],'usertype'=>$data['fusertype'],'fusertype'=>$data['tusertype']);
                        $where2   = array('uid'=>$data['toid'],'fid'=>$data['fromid'],'usertype'=>$data['tusertype'],'fusertype'=>$data['fusertype']);
                        $friend_f  = $this->getFriend($where1);
                        $friend_t  = $this->getFriend($where2);

                        $log['fconfirm']   =  $friend_f[$confirmid.'_tem'];
                        $log['tconfirm']   =  $friend_t[$confirmid.'_tem'];
                      }

                  }
               }

               $nid  =  $this -> addChatLog($log);
               
               // 修改两个最新聊天时间
               $this->update_once('chat_friend',array('ntime'=>intval($data['timestamp']/1000)),array('beginid'=>$beginid));
               // 将自己与对方聊天状态改成沟通中
               $fdata = array('chating'=>2);
               
               if($data['msgtype']=='ask'){//发送请求互换微信或电话后，更改己方请求状态为请求中(3)

                  $askid   =  trim(str_replace('ask=', '',$data['content']));

                  $fdata[$askid] = 3;
               }
               $this->update_once('chat_friend',$fdata,array('uid'=>$data['fromid'],'usertype'=>$data['fusertype'],'fid'=>$data['toid'],'fusertype'=>$data['tusertype']));
               
               $return['error']   =  $nid ? 0 : -1;
               $return['chatid']  =  $nid;
               
           }else{
               require_once('cookie.model.php');
               $cookie  =  new cookie_model($this->db,$this->def);
               $cookie->unset_cookie();
               
               $return['error']   =  2;
               $return['errmsg']  =  '当前用户身份不符,请重新登录';
           }
       }else{
           $return['error']   =  1;
           $return['errmsg']  =  '请先登录';
       }
       
       return $return;
   }
   /**
    * 聊天记录分页
    * @param array $data
    */
   function getChatPage($data = array()){
       // 处理uid。管理员uid与其他身份不同
       $data['toid']  =  str_replace('a', '', $data['toid']);
       
       $br  =  $this->getBeginid($data, 'get');
       
       if (!empty($br)){
           
           $toid  =  $data['toid'];
           
           $limit  = 20;
           $select_from = ($data['page'] - 1) * $limit;
           
           $chatWhere  =  array('beginid'=>$br['beginid'],'orderby'=>'id','limit'=>array($select_from,$limit));
           
           //非第一页的，要按照原有的聊天记录查询，按新聊天记录会查询出重复内容
           if (!empty($data['lastid']) && is_numeric($data['lastid'])){
               
               $chatWhere['id']  =  array('<',$data['lastid']);
           }
           
           $chatList  =  $this -> getChatLogList($chatWhere);
           
           if (!empty($chatList)) {
               
               $chatjob   =  $this -> getChatLog(array('beginid'=>$br['beginid'],'msgtype'=>'job','orderby'=>'id,ASC'),array('field'=>'`id`'));
               
               $chatnum   =  $this -> getChatLogNum(array('beginid'=>$br['beginid']));
               
               $from      =  $this -> getMember(array('uid'=>$data['fromid'],'usertype'=>$data['fusertype']),array('field'=>'`nickname`,`avatar`'));
               
               $to        =  $this -> getMember(array('uid'=>$toid,'usertype'=>$data['tusertype']),array('field'=>'`nickname`,`avatar`'));
               
               $jobarr    =  array();
               $return['code']  =  0;
               
               foreach ($chatList as $k=>$v){
                   $chatlog[$k]['chatid']       =  $v['id'];
                   $chatlog[$k]['content']      =  $v['content'];
                   $chatlog[$k]['sendTime']     =  $v['sendTime'];
                   $chatlog[$k]['fusertype']    =  $v['fusertype'];
                   $chatlog[$k]['msgtype']      =  $v['msgtype'];
                   $chatlog[$k]['voicelength']  =  $v['voicelength'];
                   $chatlog[$k]['voicestatus']  =  $v['voicestatus'];
                   $chatlog[$k]['timefromat']   =  date('Y-m-d H:i',ceil($v['sendTime']/1000));
                   $chatlog[$k]['askstatus']    =  $v['askstatus'];
                   $chatlog[$k]['read']         =  $v['status'] == 1 ? 1 : 0;
                   
                   if ($v['from'] == $data['fromid'] && $v['fusertype'] == $data['fusertype']){
                       
                       $chatlog[$k]['mine']      =  true;
                       $chatlog[$k]['username']  =  $from['nickname'];
                       $chatlog[$k]['avatar']    =  checkpic($from['avatar'], $this->config['sy_chat_logo']);
                       $chatlog[$k]['confirmcon']=  $v['tconfirm'];
                       
                   }elseif ($v['to'] == $data['fromid'] && $v['tusertype'] == $data['fusertype']){
                       
                       $chatlog[$k]['mine']      =  false;
                       $chatlog[$k]['username']  =  $to['nickname'];
                       $chatlog[$k]['avatar']    =  checkpic($to['avatar'], $this->config['sy_chat_logo']);
                       $chatlog[$k]['confirmcon']=  $v['fconfirm'];
                   }
                   $chatlog[$k]['newjob']        =  0;
                   if ($v['id'] == $chatjob['id']){
                       
                       if ($v['from'] == $data['fromid']){
                           
                           $chatlog[$k]['newjob']    =  1;
                       }else{
                           $chatlog[$k]['newjob']    =  2;
                       }
                   }
                   if($v['msgtype'] == 'adminjob'){
                       $jobid = str_replace('jobid=', '', $v['content']);
                       if(!empty($jobid)){
                           $jobarr[] = $jobid;
                       }
                   }
               }
               $return['data']    =  $chatlog;
               $return['fuser']   =  $from;
               $return['tuser']   =  $to;
               $return['ismore']  =  ceil($chatnum/$limit) > $data['page'] ? true : false;
               
               if (!empty($jobarr)){
                   require_once ('job.model.php');
                   
                   $jobM  =  new job_model($this->db, $this->def);
                   // 招聘中职位
                   $jobs  =  $jobM->getList(array('id'=>array('in',pylode(',', $jobarr)),'state'=>1,'r_status'=>1,'status'=>0),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));
                   
                   $joblist  =  array();
                   foreach ($jobs['list'] as $k=>$v){
                       
                       $joblist[$v['id']] = $v;
                       $joblist[$v['id']]['wapurl'] = Url('wap',array('c'=>'job','a'=>'comapply','id'=>$v['id']));
                       $joblist[$v['id']]['weburl'] = Url('job',array('c'=>'comapply','id'=>$v['id']));
                   }
                   
                   $return['adminjob'] = $joblist;
               }
               
           }else{
               
               $return['data'] = array();
           }
       }else{
           
           $return  =  array('errcode'=>8, 'msg'=>'数据异常');
       }
       return $return;
   }
   /**
    * 条件聊天时，判断个人是否有简历，并判断是否申请过该企业职位/已被企业邀请面试
    * @param array $data
    */
   function userToChat($data = array('nowtype'=>''))
   {
       if ($data['uid']){
           
           if(intval($data['uid']) == intval($data['comid'])){
               
               $return['code']  =  10;
           } elseif (!empty($data['nowtype']) && $data['nowtype'] != $data['usertype']) {
               
               $return['code'] = 11;
               
           } else {
               
               $this -> userinfo(array('uid'=>$data['uid'],'usertype'=>$data['usertype']));

               $data['tusertype']  =  2;

               $where['uid']       =  $data['uid'];
               $where['defaults']  =  1;

               if ($data['jobtype'] == 'lt'){

                   $data['tusertype']       =  3;
                   $where['height_status']  =  2;
               }
               $row  =  $this -> select_once('resume_expect', $where, '`r_status`,`state`');


               if(!empty($row)){

                   //简历通过审核
                   if ($row['state'] == 1){

                       if ($this->config['sy_chat_limit']==2){

                           $useridmsg  =  $this -> select_once('userid_msg',array('uid'=>$data['uid'],'fid'=>$data['comid'],'isdel'=>9),'id');
                           //已邀请面试
                           if (!empty($useridmsg)){

                               $return['code']  =  5;

                           }else{
                               $chat_num  =  $this->select_num('chat_log',array('from'=>$data['uid'],'to'=>$data['comid'],'fusertype'=>$data['usertype'],'tusertype'=>$data['tusertype']));
                               // 企业对个人有聊天记录，或者从招聘会来的，不再需要判断权限
                               if ($chat_num > 0 || intval($data['zid']) > 0){

                                   $return['code'] = 1;  //可以查看

                               }else{

                                   // 是否申请了职位
                                   if (!empty($data['jobid'])){

                                       $useridjob  =  $this -> select_once('userid_job',array('uid'=>$data['uid'],'isdel'=>9,'job_id'=>$data['jobid']),'id');

                                   } else {

                                       $useridjob  =  $this -> select_once('userid_job',array('uid'=>$data['uid'],'isdel'=>9,'com_id'=>$data['comid']),'id');
                                   }
                                   if (!$useridjob){

                                       $return['code'] = 9;
                                   }else{
									   $return['code'] = 1;
								   }
                               }
                           }
                       }else{

                           $return['code']  =   1;
                       }

                   }elseif ($row['state'] == 3){

                       $return['code']  =  6;

                   }elseif ($row['state'] == 0){

                       $return['code']  =  7;

                   }elseif ($row['r_status'] == 2){

                       $return['code']  =  8;
                   }
               }else{
                   if ($data['jobtype'] == 'lt'){

                       $return['code']  =  3;

                   }else{

                       $return['code']  =  2;
                   }
               }

           }
       }else{
           
           $return['code']  =  4;
           
       }
       return $return;
   }

    /**
     * 条件聊天时，判断企业是否有查看个人简历的权限
     * @param array $data
     * @return mixed
     */
   function comToChat($data = array('nowtype'=>''))
   {
       if (!empty($data['fromid'])){
           
           if($data['fromid'] == $data['toid']){
               
               $return['code'] = 6;
               
           } elseif (!empty($data['nowtype']) && $data['nowtype'] != $data['fusertype']) {
               
               $return['code'] = 7;
               
           } else {
               
               if ($data['fusertype'] == 2){
                   
                   $company  =  $this->select_once('company',array('uid'=>$data['fromid']),'`r_status`');
                   
                   if ($company['r_status'] == 0){
                       $return['code'] = 8;
                   }elseif ($company['r_status'] == 2){
                       $return['code'] = 9;
                   }elseif ($company['r_status'] == 3){
                       $return['code'] = 10;
                   }
                   
               }elseif ($data['fusertype'] == 3){
                   
                   $lt  =  $this->select_once('lt_info',array('uid'=>$data['fromid']),'`r_status`');
                   
                   if ($lt['r_status'] == 0){
                       $return['code'] = 8;
                   }elseif ($lt['r_status'] == 2){
                       $return['code'] = 9;
                   }elseif ($lt['r_status'] == 3){
                       $return['code'] = 10;
                   }
               }
               if (empty($return['code'])){
                   
                   $this -> userinfo(array('uid'=>$data['fromid'],'usertype'=>$data['fusertype']));
                   
                   if (in_array($this->config['sy_chat_rates'], array(2,3))){
                       
                       $chat_num  =  $this->select_num('chat_log',array('from'=>$data['fromid'],'to'=>$data['toid'],'fusertype'=>$data['fusertype'],'tusertype'=>$data['tusertype']));
                       // 企业对个人有聊天记录，或者从网络招聘会来的，不再需要判断权限
                       if ($chat_num > 0 || intval($data['zid']) > 0){
                           
                           $return['code'] = 0;  //可以查看
                           
                       }else{
                           $time  =  time();
                           
                           //先判断是否有正在招聘中的职位
                           if ($data['fusertype'] == 2){
                               
                               $return['code']  =  1;
                               $job   =  $this -> select_once('company_job',array('uid'=>$data['fromid'],'r_status'=>1,'status'=>0,'state'=>1),'`id`');
                               
                           }elseif ($data['fusertype'] == 3){
                               
                               $return['code']  =  2;
                               $job   =  $this -> select_once('lt_job',array('uid'=>$data['fromid'],'zp_status'=>0,'status'=>1,'r_status'=>array('<>',2)),'`id`');
                           }
                           //有正在招聘职位
                           if (!empty($job)){
                               
                               $right  =  $this -> select_once('chat_right',array('uid'=>$data['toid'],'comid'=>$data['fromid'],'usertype'=>$data['fusertype']),'`id`');
                               
                               if (!empty($right)){
                                   $return['code'] = 0;  //可以查看
                               }else{
                                   //判断是否有聊天数量
                                   if ($data['fusertype'] == 2){
                                       
                                       $statis   =  $this -> select_once('company_statis',array('uid'=>$data['fromid']),'`vip_etime`,`rating_type`,`integral`,`chat_num`');
                                       
                                   }elseif ($data['fusertype'] == 3){
                                       
                                       $statis   =  $this -> select_once('lt_statis',array('uid'=>$data['fromid']),'`vip_etime`,`rating_type`,`integral`,`chat_num`');
                                   }
                                   
                                   $online    =  (int)$this->config['com_integral_online'];
                                   $chat_name = $this->config['sy_chat_name'];
                                   $spid      =  intval($data['spid']);
                                   /* 会员信息查询 */
                                   if(isVip($statis['vip_etime'])){
                                       
                                       if($statis['rating_type'] == 1){  // 套餐模式
                                           
                                           /* 收费会员聊天已用完 */
                                           
                                           if($statis['chat_num'] == 0){ // 弹出购买提示
                                               
                                               if(!empty($spid)){
                                                   $res['code']  =  4;
                                                   $res['msg']	 =  '当前账户套餐余量不足，请联系主账户增配！';
                                                   
                                                   return $res;
                                               }else{
                                                   //判断后台是否开启该单项购买
                                                   $single_can     =   @explode(',', $this->config['com_single_can']);
                                                   $serverOpen     =   1;
                                                   if(!in_array('chat',$single_can)){
                                                       $serverOpen =   0;
                                                   }
                                                   if($online != 4){ // 非套餐消费模式
                                                       
                                                       if($online == 3 && !in_array('chat', explode(',', $this->config['sy_only_price']))){ // 积分消费
                                                           
                                                           $tmpJifen     =	  $this->config['integral_chat_num'] * $this->config['integral_proportion'];
                                                           if($serverOpen){
                                                               $res['msg']   =   '你的等级特权已经用完，继续'.$chat_name.'将消费 '.$tmpJifen.$this->config['integral_pricename'].'，是否继续？';
                                                           }else{
                                                               $res['msg']     =  "你的等级特权已经用完，你可以购买会员！";
                                                           }
                                                           
                                                           
                                                           /* 积分模式，是否需要充值判断 */
                                                           $res['jifen']     =   $tmpJifen;
                                                           $res['integral']  =   intval($statis['integral']);
                                                           $res['pro']       =   $this->config['integral_proportion'];
                                                       }else{
                                                           $tmpYuan      =   $this->config['integral_chat_num'];
                                                           if($serverOpen){
                                                               $res['msg']   =   '你的等级特权已经用完，继续'.$chat_name.'将消费 '.$tmpYuan.' 元，是否继续?';
                                                           }else{
                                                               $res['msg']     =  "你的等级特权已经用完，你可以购买会员！";
                                                           }
                                                           
                                                           $res['price'] =   $tmpYuan;
                                                       }
                                                       
                                                   }else{ // 套餐消费模式
                                                       
                                                       $res['msg']		  =	 "你的等级特权已经用完，你可以购买会员！";
                                                   }
                                                   
                                                   $res['code']    =  3;
                                                   $res['online']  =  $online;
                                                   $res['uid']     =  $data['toid'];
                                                   return $res;
                                               }
                                               
                                           }else{
                                               
                                               //收费会员套餐数量没用完的状态,直接扣除，开始聊天
                                               if ($data['fusertype'] == 2){
                                                   
                                                   $suid     =   $spid ? $spid : $data['fromid'];
                                                   $this -> update_once('company_statis',array('chat_num'=>array('-',1)),array('uid'=>$suid));
                                                   
                                               }elseif ($data['fusertype'] == 3){
                                                   
                                                   $this -> update_once('lt_statis',array('chat_num'=>array('-',1)),array('uid'=>$data['fromid']));
                                               }
                                               $this->insert_into('chat_right',array('uid'=>$data['toid'],'comid'=>$data['fromid'],'ctime'=>$time,'usertype'=>$data['fusertype']));
                                               
                                               require_once ('log.model.php');
                                               $LogM = new log_model($this->db, $this->def);
                                               $LogM->addMemberLog($data['fromid'], $data['fusertype'], '使用聊天套餐,聊天对象(ID: '.$data['toid'].')', 30, 1);
                                               
                                               $res['code']  =	0;
                                               
                                               return $res;
                                           }
                                           
                                       }else if($statis['rating_type'] == 2){    //时间会员


                                           require_once 'company.model.php';
                                           $comM    =   new company_model($this->db,$this->def);
                                           $return  =   $comM->comVipDayActionCheck('chat', $data['fromid']);

                                           if ($return['status'] == 1){

                                               $this->insert_into('chat_right',array('uid'=>$data['toid'],'comid'=>$data['fromid'],'ctime'=>$time,'usertype'=>$data['fusertype']));
                                               
                                               require_once ('log.model.php');
                                               $LogM = new log_model($this->db, $this->def);
                                               $LogM->addMemberLog($data['fromid'], $data['fusertype'], '使用聊天套餐,聊天对象(ID: '.$data['toid'].')', 30, 1);
                                               
                                               $res['code'] =	0;
                                           }else{

                                               $res['code'] =	4;
                                               $res['msg']  =   $return['msg'];
                                           }

                                           return $res;
                                       }
                                       
                                   }else{ // 过期会员
                                       
                                       if(empty($spid)){
                                           
                                           if($online != 4){    // 非套餐模式消费
                                               
                                               if($online == 3 && !in_array('chat', explode(',', $this->config['sy_only_price']))){
                                                   
                                                   $tmpJifen2			=	$this->config['integral_chat_num'] * $this->config['integral_proportion'];
                                                   $res['msg']			=	"你的会员已到期，请先购买会员！";
                                                   $res['jifen']		=   $tmpJifen2;
                                                   $res['integral']	    =   intval($statis['integral']);
                                                   $res['pro']			=   $this->config['integral_proportion'];
                                               }else{
                                                   
                                                   $tmpYuan2			=   $this->config['integral_chat_num'];
                                                   $res['msg']			=   "你的会员已到期，请先购买会员！";
                                                   $res['price']		=   $tmpYuan2;
                                               }
                                               
                                           }else{
                                               
                                               $res['msg']  =  "你的会员已到期，你可以购买会员！";
                                           }
                                           $res['online']   =  $online;
                                           $res['code']		=  3;
                                           $res['uid']      =  $data['toid'];
                                           
                                       }else {
                                           
                                           $res['code']  =  4;
                                           $res['msg']	 =  '当前账户会员已到期，请联系主账户升级！';
                                       }
                                       return $res;
                                   }
                               }
                           }
                       }
                   }else{
                       
                       $return['code']  =  0;
                   }
               }
           }
       }else{
           
           $return['code'] = 5;
       }
       return $return;
   }
   /**
    * 设置个人头像展示
    */
   private function setResumePhotoShow($data = array())
   {
       $resumePhoto  =	'';
       $sexArr		 =	 array(1, 152);
       if($data['defphoto']==2){
           $resumePhoto        =   checkpic($data['photo']);
       }elseif(empty($this -> config['user_pic']) || $this -> config['user_pic'] == 1){
           if($data['photo'] && $data['photo_status'] == 0 && $data['phototype'] != 1){
               $resumePhoto		=	$data['photo'];
           }else{
               if(in_array($data['sex'], $sexArr)){
                   $resumePhoto	=	$this -> config['sy_member_icon'];
               }else{
                   $resumePhoto	=	$this -> config['sy_member_iconv'];
               }
           }
       }elseif($this -> config['user_pic'] == 2){
           if($data['photo'] && $data['photo_status'] == 0){
               $resumePhoto		=	$data['photo'];
           }else{
               if(in_array($data['sex'], $sexArr)){
                   $resumePhoto	=	$this -> config['sy_member_icon'];
               }else{
                   $resumePhoto	=	$this -> config['sy_member_iconv'];
               }
           }
       }elseif($this -> config['user_pic'] == 3){
           if(in_array($data['sex'], $sexArr)){
               $resumePhoto		=	$this -> config['sy_member_icon'];
           }else{
               $resumePhoto		=	$this -> config['sy_member_iconv'];
           }
       }
       return $resumePhoto;
   }
   /**
    * 设置姓名展示
    */
   private function setUsernameShow($data = array())
   {
       $resUserName				=	'';
       
       if(empty($this -> config['user_name']) || $this -> config['user_name'] == 1){
           
           if($data['nametype'] == 1){
               $resUserName  =  $data['name'];
           }else if($data['nametype'] == 2){
               $resUserName  =  'NO.'. $data['eid'];
           }else{
               if($data['sex'] == 1){
                   $resUserName  =  mb_substr($data['name'], 0, 1, 'utf-8').'先生';
               }else{
                   $resUserName  =	mb_substr($data['name'], 0, 1, 'utf-8').'女士';
               }
           }
       }elseif($this -> config['user_name'] == 2){
           
           $resUserName  =  'NO.'. $data['eid'];
           
       }elseif($this -> config['user_name'] == 3){
           
           if($data['sex'] == 1){
               $resUserName  =  mb_substr($data['name'], 0, 1, 'utf-8').'先生';
           }else{
               $resUserName  =  mb_substr($data['name'], 0, 1, 'utf-8').'女士';
           }
       }elseif($this -> config['user_name'] == 4){
           $resUserName  =  $data['name'];
       }
       if(empty($resUserName)){
           $resUserName  =  $data['name'];
       }
       return $resUserName;
   }
   public function getPrepare($data)
   {
       
       $list  =  array();
       // 简历
       if ($data['usertype'] == 1){
           
           $logo     =  1;
           $expect   =  $this->select_once('resume_expect',array('uid'=>$data['uid'],'defaults'=>1,'state'=>'1'),'`id`,`uid`');
           
       }elseif ($data['usertype'] == 2 || $data['usertype'] == 3 || $data['usertype'] == 9){
           if ($data['usertype'] == 9){
               // usertype = 9 管理员
               $logo  =  1;
           }else{
               $logo  =  2;
           }
           $expect  =  $this->select_once('resume_expect',array('uid'=>$data['toid'],'defaults'=>1),'id,`uid`');
       }
       if (!empty($expect)){
           
           require_once ('resume.model.php');
           
           $resumeM  =  new resume_model($this->db, $this->def);
           
           $einfo    =  $resumeM -> getExpect(array('id'=>$expect['id']),array('needCache'=>1,'field'=>'`id`,`uid`,`name`,`exp`,`edu`,`city_classid`,`report`'));
           
           $rinfo    =  $resumeM -> getResumeInfo(array('uid'=>$expect['uid']),array('field'=>'`name`,`sex`,`photo`,`birthday`,`description`','logo'=>$logo));
           
           $works    =  $resumeM -> getResumeWorks(array('eid'=>$expect['id']));
           
           $einfo['sex_n']   =  $rinfo['sex_n'];
           $einfo['age']     =  $rinfo['age'];
           $einfo['uname']   =  $rinfo['name'];
           $einfo['photo']   =  $rinfo['photo'];
           $einfo['description'] = mb_substr(strip_tags($rinfo['description']), 0, 60);
           $einfo['works']   =  $works;
           $einfo['weburl']  =  Url('resume',array('c'=>'show','id'=>$expect['id']));
           $einfo['wapurl']  =  Url('wap',array('c'=>'resume','a'=>'show','id'=>$expect['id']));
           
           $list['expect']  =  $einfo;
       }
       // 职位
       require_once ('job.model.php');
       
       $jobM  =  new job_model($this->db, $this->def);
       
       if ($data['usertype'] == 1){
           
           if ($data['totype'] == 2){
               // 招聘中职位
               $jobs  =  $jobM->getList(array('uid'=>$data['toid'],'state'=>1,'r_status'=>1,'status'=>0,'limit'=>50),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));
               
               $company['wapurl']  =  Url('wap',array('c'=>'company','a'=>'show','id'=>$data['toid']));
               
               $list['company']    =  $company;
           }
       }elseif ($data['usertype'] == 2){
           // 招聘中职位
           $jobs  =  $jobM->getList(array('uid'=>$data['uid'],'state'=>1,'r_status'=>1,'status'=>0,'limit'=>50),array('chat'=>1,'field'=>'`id`,`uid`,`name`,`com_name`,`provinceid`,`cityid`,`minsalary`,`maxsalary`,`exp`,`edu`'));
           
       }
       
       if (!empty($jobs['list'])){
           
           foreach ($jobs['list'] as $k=>$v){
               
               $joblist[$v['id']] = $v;
               $joblist[$v['id']]['wapurl'] = Url('wap',array('c'=>'job','a'=>'comapply','id'=>$v['id']));
               $joblist[$v['id']]['weburl'] = Url('job',array('c'=>'comapply','id'=>$v['id']));
           }
           $list['joblist']  =  $joblist;
       }
       // 猎头职位
       if ($data['usertype'] == 3 || $data['totype'] == 3){
           
           if ($data['totype'] == 3){
               
               $uid  =  $data['toid'];
           }else{
               $uid  =  $data['uid'];
           }
           
           require_once ('lietoujob.model.php');
           
           $ltjobM  =  new lietoujob_model($this->db, $this->def);
           
           $jobs    =  $ltjobM->getList(array('uid'=>$uid,'status'=>1,'zp_status'=>0,'r_status'=>1));
           
           foreach ($jobs as $k=>$v){
               
               $joblist[$v['id']]['id']            =  $v['id'];
               $joblist[$v['id']]['name']          =  $v['job_name'];
               $joblist[$v['id']]['com_name']      =  $v['com_name'];
               $joblist[$v['id']]['job_salary']    =  $v['salary'];
               $joblist[$v['id']]['citystr']       =  isset($v['citystr']) ? $v['citystr'] : '';
               $joblist[$v['id']]['job_exp']       =  $v['exp_n'];
               $joblist[$v['id']]['job_edu']       =  $v['edu_n'];
           }
           $list['joblist']  =  $joblist;
           
           $company['wapurl']  =  Url('wap',array('c'=>'post','a'=>'headhunter','uid'=>$data['toid']));
           
           $list['company']    =  $company;
       }
       
       return $list;
   }
   function setMsg($data=array())
   {
       $return  =  array();
       if (!empty($data['toid']) && !empty($data['tusertype'])){
           // 处理uid。管理员uid与其他身份不同
           $data['toid']  =  str_replace('a', '', $data['toid']);
           
           if ($data['nowid'] == $data['toid'] && $data['nowtype'] == $data['tusertype']){
               
               $br  =  $this->getBeginid($data);
               
               if ($br['beginid']){
                   
                   $this -> upChatLog(array('status'=>1,'receive'=>1), array('beginid'=>$br['beginid']));
               }
           }else{
               require_once('cookie.model.php');
               $cookie  =  new cookie_model($this->db,$this->def);
               $cookie->unset_cookie();
               
               $return['error']   =  2;
               $return['errmsg']  =  '当前用户身份不符,请重新登录';
           }
       }else{
           $return['error']   =  1;
           $return['errmsg']  =  '请先登录';
       }
       return $return;
   }
   function setVoiceStatus($data=array())
   {
       $return  =  array();
       if (!empty($data['toid']) && !empty($data['tusertype'])){
           
           if ($data['nowid'] == $data['toid'] && $data['nowtype'] == $data['tusertype']){
              // 处理uid。管理员uid与其他身份不同
              $data['toid']  =  str_replace('a', '', $data['toid']);
              
              $br  =  $this->getBeginid($data);
               
              if ($br['beginid'] && $data['id']){
                
                $where  = array('beginid'=>$br['beginid'],'id'=>$data['id']);
                    
                $vdata  =  array('voicestatus'=>1);

                $this -> upChatLog($vdata, $where);
              
              }else{
                $return['error']   =  2;
                $return['errmsg']  =  '参数错误';
              }
           }else{
               require_once('cookie.model.php');
               $cookie  =  new cookie_model($this->db,$this->def);
               $cookie->unset_cookie();
               
               $return['error']   =  2;
               $return['errmsg']  =  '当前用户身份不符,请重新登录';
           }
       }else{
           $return['error']   =  1;
           $return['errmsg']  =  '请先登录';
       }
       return $return;
   }
   /**
    * 添加条件直聊下可直聊对象
    */
   public function addChatRight($data)
   {
       if (!empty($data)){
           
           $nid  =  $this -> insert_into('chat_right',$data);
       }
       
       return $nid;
   }
   /**
    * 条件直聊下查询聊天对象是否可直聊
    */
   function getChatRight($where = array(), $data = array())
   {
       $row  =  $this->select_once('chat_right',$where);
       
       return $row;
   }
   /**
    * 用户不在线，收到消息，提醒用户
    * @param array $data
    */
   
   function setUnSend($data = array())
   {
       //当前身份类型与接收消息身份类型一致时，才需要处理
       if ($data['fusertype'] == $data['nowtype']){
           // 处理uid。管理员uid与其他身份不同
           $data['toid']  =  str_replace('a', '', $data['toid']);
           
           $br  =  $this->getBeginid($data);
           
           if ($br['beginid']){
               
               $time      =  time();
               $today     =  strtotime('today');
               $unSend    =  $this->getChatLog(array('beginid'=>$br['beginid'],'remindTime'=>array('<>',''),'orderby'=>'`id`,DESC'),array('field'=>'`id`,`remindTime`'));
               
               $this -> upChatLog(array('remindTime'=>$time), array('beginid'=>$br['beginid'],'limit'=>1,'orderby'=>'`id`,DESC'));
               
               // app推送和微信模板提醒，每4小时一次
               if (($unSend['remindTime'] && $unSend['remindTime']< ($time - 2400)) || empty($unSend['remindTime']) && $data['tusertype'] != 9){
                   // app推送
                   include_once ('push.model.php');
                   $pushM = new push_model($this->db, $this->def);
                   
                   $pushM->pushMsg('chat',
                       array(
                           'fuid'      =>  $data['fromid'],
                           'puser'     =>  $data['toid'],
                           'tid'       =>  0,
                           'title'     =>  $this->config['sy_webname'],
                           'content'   =>  '您收到新的'.$this->config['sy_chat_name'].'信息，请注意查看！',
                       )
                   );
                   $member   =  $this->select_once('member',array('uid'=>$data['toid']),'`uid`,`usertype`,`username`,`moblie`,`wxid`,`wxopenid`');
                   // 微信模板通知
                   if (!empty($member['wxid'])){
                       // 取得聊天双方uid
                       if ($data['tusertype'] == 1){
                           $userid  =  $data['toid'];
                           
                           if ($data['fusertype'] == 2){
                               
                               $comid  =  $data['fromid'];
                               
                           }elseif ($data['fusertype'] == 3){
                               
                               $ltid   =  $data['fromid'];
                           }
                           
                       }else{
                           $userid  =  $data['fromid'];
                           
                           if ($data['tusertype'] == 2){
                               
                               $comid  =  $data['toid'];
                               
                           }elseif ($data['tusertype'] == 3){
                               
                               $ltid   =  $data['toid'];
                           }
                       }
                       //取得聊天沟通意向
                       $jobChat  =  $this->getChatLog(array('beginid'=>$br['beginid'],'content'=>array('like','jobid'),'orderby'=>'`id`,DESC'),array('field'=>'`content`'));
                       
                       if (!empty($jobChat)){
                           
                           $jobid   =  trim(str_replace('jobid=', '',$jobChat['content']));
                           
                           if (isset($comid)){
                               
                               $job     =  $this->select_once('company_job',array('id'=>$jobid),'`name`');
                               $expect  =  mb_substr($job['name'], 0,20,'utf-8');
                               
                           }elseif (isset($ltid)){
                               
                               $job     =  $this->select_once('lt_job',array('id'=>$jobid),'`job_name`');
                               $expect  =  mb_substr($job['job_name'], 0,20,'utf-8');
                           }
                           
                       }else{
                           
                           $jl      =  $this->select_once('resume_expect',array('uid'=>$userid,'defaults'=>1),'`name`');
                           $expect  =  $jl['name'];
                       }
                       // 取得姓名
                       if (!empty($userid)){
                           
                           $qyid  =  isset($comid) ? $comid : $ltid;
                           // 聊天对象是个人，则发送方为企业/猎头
                           if ($data['tusertype'] == 1){
                               
                               $chat_member  =  $this->select_once('chat_member',array('uid'=>$qyid,'usertype'=>$data['fusertype']),'`linkman`');
                               $name         =  $chat_member['linkman'];
                               
                           }else{
                               
                               $resume  =  $this->select_once('resume',array('uid'=>$userid),'`name`,`sex`,`nametype`,`def_job`');
                               $down    =  $this->select_num('down_resume',array('uid'=>$userid,'comid'=>$qyid));
                               
                               if ($down > 0){
                                   
                                   $name   =  $resume['name'];
                               }else{
                                   
                                   $nameArr  =  array(
                                       'name'     => $resume['name'],
                                       'sex'      => $resume['sex'],
                                       'nametype' => $resume['nametype'],
                                       'eid'      => $resume['def_job']
                                   );
                                   $name   =  $this->setUsernameShow($nameArr);
                               }
                           }
                       }
                       
                       if (!empty($name) && !empty($expect)){
                           
                           include_once ('weixin.model.php');
                           $weixinM = new weixin_model($this->db, $this->def);
                           $sendInfo['wxid']    =  $member['wxid'];
                           $sendInfo['uid']     =  $member['uid'];
                           $sendInfo['usertype']=  $member['usertype'];
                           $sendInfo['name']    =  $name;
                           $sendInfo['expect']  =  $expect;
                           $sendInfo['time']    =  date('Y-m-d H:i:s');
                           
                           $weixinM->sendWxChat($sendInfo);
                       }
                   }
               }
               if (($unSend['remindTime'] && $unSend['remindTime']<$today) || empty($unSend['remindTime'])){
                   
                   // 短信提醒开启时，发送短信提醒，每天只1次
                   $msg  =  $this->select_once('moblie_msg',array('uid'=>$data['toid'],'content'=>array('like',$this->config['sy_chat_name']),'orderby'=>'id'),'`ctime`');
                   
                   if ($msg['ctime'] < $today){
                       
                       if (empty($member)){
                           
                           $member   =  $this->select_once('member',array('uid'=>$data['toid']),'`uid`,`username`,`moblie`');
                       }
                       if ($this->config['sy_msg_chat'] == 1){
                           
                           $msgData  =  array(
								'uid'       =>  $member['uid'],
								'username'  =>  $member['username'],
								'mobile'    =>  $member['moblie'],
								'date'      =>  date('Y-m-d/H:i:s'),
								'chat_name' =>  $this->config['sy_chat_name'],
								'type'      =>  'chat',
								'port'		=>	$data['port']
                           );
                           
                           require_once ('notice.model.php');
                           
                           $noticeM   =  new notice_model($this->db, $this->def);
                           
                           $result = $noticeM -> sendSMSType($msgData);
                       }
                   }
               }
           }
       }
   }
   /**
    * 从聊天平台获取token
    */
   function chatToken($uid = ''){
       
       $member  =  $this->select_once('chat_member',array('uid'=>$uid),'`expires_in`,`token`');
       // token未过期的不用重新获取
       if ((intval($member['expires_in']) - 200) < time()){
           
           $return  =  $this->chatRequest($uid);
           
       }else{
           
           $return  =  array('token'=>$member['token'],'expires_in'=>$member['expires_in']);
           
       }
       return $return;
   }
   /**
    * 请求聊天服务器
    */
   function chatRequest($uid = ''){
       
       $return = array('error'=>'请求异常');
       
       $protocol =	getprotocol($this->config['sy_weburl']);
       
       $url		 =  $protocol . 'liaotian.phpyun.com/chattoken.php';
       
       $post     =  array(
           'appkey'     =>  trim($this->config['sy_chat_appkey']),
           'appsecret'  =>  trim($this->config['sy_chat_appsecret']),
           'suid'       =>  $uid,
           'version'    =>  '510'
       );
       
       if (extension_loaded('curl')){
           
           $response  =  CurlPost($url, $post);
           
           $result    =  json_decode($response,true);
           
           if(!empty($result['token'])){
               
               $this->update_once('chat_member',array('token'=>$result['token'],'expires_in'=>$result['expires_in']),array('uid'=>$uid));
               
               $return  =  array('token'=>$result['token'],'expires_in'=>$result['expires_in']);
               
           }else{
               
               $return = array('error'=>$result['error']);
           }
           
       }else{
           
           $return = array('error'=>'不支持curl函数');
       }
       
       return $return;
   }
   /**
    * 查询单条聊天用户关系
    */
   function getFriend($where = array())
   {
       if (!empty($where)){
           
           $row  =  $this->select_once('chat_friend',$where);
           
           return $row;
       }
   }
   /**
    * 查询多条聊天用户关系
    */
   function getFriendList($where = array(),$data = array('utype'=>''))
   {
       if (!empty($where)){
           
           $list  =  $this->select_all('chat_friend',$where);
           
           if ($data['utype'] == 'admin'){
               
               $uids = $cuids = array();
               
               foreach($list as $val){
                   $uids[]   =  $val['uid'];
                   $cuids[]  =  $val['fid'];

               }
               $all     =  array_merge($uids,$cuids);
               $alluid  =  array_unique($all);
               
               $member  =  $this->select_all('member',array('uid'=>array('in',pylode(',', $alluid))),'`uid`,`username`,`usertype`');
               $List = $this->getDataList($member);

               if(!empty($List)){
                   
                   foreach($list as $k=>$v){
                       
                       foreach($List as $val){
                           
                           if($val['uid'] == $v['uid']){
                               
                               $username  =  $val['username'];

                               if ($val['usertype'] == 1){
                                   
                                   $username .= '(个人)';
                                   
                               }elseif ($val['usertype'] == 2){
                                   
                                   $username .= '(企业)';
                               }
                               $list[$k]['username']  =  $username;
                               $list[$k]['countname']  =  $val['countname'];
                           }
                           if($val['uid'] == $v['fid']){
                               
                               $list[$k]['rusername']  =  $val['username'];
                               $list[$k]['rcountname']  =  $val['countname'];
                           }
                       }
                   }
               }
           }
           return $list;
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
    * 添加聊天用户关系
    */
   function addFriend($data = array())
   {
       if (!empty($data)){
        
           $nid  =  $this->insert_into('chat_friend',$data);
           
           return $nid;
       }
   }
   /**
    * 修改聊天用户关系
    */
   function upFriend($where = array(), $data = array())
   {
       if (!empty($where) && !empty($data)){
           
           $nid  =  $this->update_once('chat_friend',$data, $where);
           
           return $nid;
       }
   }
   /**
    * 删除聊天用户关系
    */
   function delFriend($where = array())
   {
       if (!empty($where)){
           
           $this->delete_all('chat_friend', $where, '');
       }
   }
   /**
    * 获取互换电话、微信请求情况
    */
   function getFriendCan($data=array()){

        $uid      = $data['uid'];
        $usertype = $data['usertype'];
        $fid      = $data['fid'];
        $fusertype= $data['fusertype'];
        $type     = $data['type'];

        $can      = 0;

        if($uid && $usertype && $fid && $fusertype && $type){

            $where1   = array('uid'=>$uid,'fid'=>$fid,'usertype'=>$usertype,'fusertype'=>$fusertype);
            $where2   = array('uid'=>$fid,'fid'=>$uid,'usertype'=>$fusertype,'fusertype'=>$usertype);

            $chatfriend1  = $this->getFriend($where1);
            $chatfriend2  = $this->getFriend($where2);

            if($chatfriend1[$type]==1 && $chatfriend2[$type]==1){
                $can = 1;//同意互换
            }else{
                if($chatfriend1[$type]==3){
                    $can = 3;//发出请求等待对方操作
                }else{
                    $can = 0;//尚未请求
                }
            }
        }
        return $can;
   }
   /**
    * 发送互换电话、微信请求
    */
   function checkCanAsk($data = array())
   {
       $uid       =  $data['uid'];
       $usertype  =  $data['usertype'];
       $toid      =  $data['toid'];
       $totype    =  $data['totype'];
       $ask       =  $data['ask'];
       $askvalue  =  $data['askvalue'];
       
       if ($askvalue) {
           
           $can = $this->getFriendCan(array('type'=>$ask,'uid'=>$uid,'usertype'=>$usertype,'fid'=>$toid,'fusertype'=>$totype));
           
           $return['error'] = 9;
           $return['can']   = $can;
           
           if ($can != 3) {
               
               if ($ask == 'tel' && CheckMobile($askvalue) == false) {
                   
                   $return['error'] = 8;
                   $return['msg'] = '手机号格式错误';
               } else {
                   // 成功发送互换请求
                   $nid = $this->upFriend(array('uid'=>$uid,'usertype'=>$usertype,'fid'=>$toid,'fusertype'=>$totype), array($ask . '_tem' => $askvalue));
                   // 发送微信模板消息
                   if ($ask == 'wx'){
                       $title  =  '微信号';
                   }else{
                       $title  =  '电话';
                   }
                   
                   $member  =  $this->select_once('member',array('uid'=>$toid),'`uid`,`wxid`,`usertype`');
                   // 查询发送方信息
                   include_once('userinfo.model.php');
                   
                   $userinfoM  =  new userinfo_model($this->db, $this->def);
                   
                   if ($usertype == 1){
                       
                       $field  =  '`name`,`sex`';
                       
                   }elseif ($usertype==2){
                       
                       $field  =  '`name`';
                       
                   }elseif ($usertype==3){
                       
                       $field  =  '`realname` AS `name`';
                   }
                   $userinfo   =  $userinfoM -> getUserInfo(array('uid'=>$uid),array('usertype'=>$usertype,'field'=>$field));
                   // 保存微信号
                   if ($ask == 'wx'){
                       $userinfoM->UpdateUserInfo(array('usertype'=>$usertype,'post'=>array('wxid'=>$askvalue)), array('uid'=>$uid));
                   }
                   
                   if ($usertype == 1){
                       
                       $name  =  $userinfo['sex'] == 1 ? mb_substr($userinfo['name'], 0, 1, 'utf-8').'先生' : mb_substr($userinfo['name'], 0, 1, 'utf-8').'女士';
                       
                   }else{
                       
                       $name  =  $userinfo['name'];
                   }
                   
                   $sendData	=	array(
                       'title'		=>	'您有新的互换'.$title.'请求！',
                       'name'		=>	$name,
                       'ask'	    =>	$title,
                       'asktime'	=>	date("Y年m月d日 H:i"),
                       'url'		=>	Url('wap',array('c'=>'chat','id'=>$uid,'type'=>$usertype,'wxuid'=>$toid)),
                       'wxid'		=>	$member['wxid'],
                       'uid'		=>	$member['uid'],
                       'usertype'	=>	$member['usertype']
                   );
                   require_once ('weixin.model.php');
                   $weixinM  =	new weixin_model($this->db, $this->def);
                   
                   $weixinM->sendWxChatEx($sendData);
               }
           } else {
               
               $return['error'] = 7;
               $return['msg'] = '请勿重复申请';
           }
       } else {
           if ($ask == 'tel') {
               $asktype = '手机号';
           } else if ($ask == 'wx') {
               $asktype = '微信号';
           }
           $return['error'] = 8;
           $return['msg'] = '请填写' . $asktype;
       }
       return $return;
   }
   /**
    * 同意互换微信、电话
    */
   function confirmAsk($data){

      $uid      = $data['uid'];
      $usertype = $data['usertype'];
      $tuid     = $data['toid'];
      $totype   = $data['totype'];
      $ask      = $data['ask'];
      $askvalue = $data['askvalue'];
      $chatid   = $data['chatid'];

      if($tuid && $totype && $usertype && $uid && $ask){

          if($ask=='tel' && CheckMobile($askvalue) == false){

            $return['error']  = 8;
            $return['msg']    = '手机号格式错误';

          }else{

            $this->upFriend(array('uid'=>$uid,'usertype'=>$usertype,'fid'=>$tuid,'fusertype'=>$totype),array($ask=>1,$ask.'_tem'=>$askvalue));
            $this->upFriend(array('fid'=>$uid,'usertype'=>$usertype,'uid'=>$tuid,'usertype'=>$totype),array($ask=>1));

            $where   = array('uid'=>$tuid,'fid'=>$uid,'usertype'=>$totype,'fusertype'=>$usertype);
            
            $chatfriend  = $this->getFriend($where);

            if(!$chatid){
              // 获取聊天专用id
               
                $chatLogWhere = array(
                  'beginid' =>  $chatfriend['beginid'],
                  'msgtype' =>  'ask',
                  'content' =>  'ask='.$ask,
                  'orderby' =>  'id,desc'
                );

                $chatlog      = $this->getChatLog($chatLogWhere);

                $chatLogWhere = array('id'=>$chatlog['id'],'beginid'=>$chatfriend['beginid']);

            }else{

                $chatLogWhere = array('id'=>$chatid,'beginid'=>$chatfriend['beginid']);

            }

            $this->upChatLog(array('askstatus'=>1),$chatLogWhere);
            // 保存微信号
            if ($ask == 'wx'){
                include_once('userinfo.model.php');
                $userinfoM  =  new userinfo_model($this->db, $this->def);
                $userinfoM->UpdateUserInfo(array('usertype'=>$usertype,'post'=>array('wxid'=>$askvalue)), array('uid'=>$uid));
            }
            
            $return['to'.$ask]  = $chatfriend[$ask.'_tem'];

            $return['error']  = 1;
          }

      }else{
          $return['error'] =0;
      }

      return $return;
   }
   /**
    * 拒绝互换微信、电话
    */
   function refuseAsk($data){

      $uid      = $data['uid'];
      $usertype = $data['usertype'];
      $tuid     = $data['toid'];
      $totype   = $data['totype'];
      $ask      = $data['ask'];
      $chatid   = $data['chatid'];
      
      if($tuid && $totype && $usertype && $uid && $ask){
        
        $nid  =  $this->upFriend(array('uid'=>$uid,'usertype'=>$usertype,'fid'=>$tuid,'fusertype'=>$totype),array($ask=>2));

        $this->upFriend(array('uid'=>$tuid,'usertype'=>$totype,'fid'=>$uid,'fusertype'=>$usertype),array($ask=>0));
        
        $where   = array('uid'=>$tuid,'fid'=>$uid,'usertype'=>$totype,'fusertype'=>$usertype);
            
        $chatfriend  = $this->getFriend($where);

        if(!$chatid){
          // 获取聊天专用id
           
            $chatLogWhere = array(
              'beginid' =>  $chatfriend['beginid'],
              'msgtype' =>  'ask',
              'content' =>  'ask='.$ask,
              'orderby' =>  'id,desc'
            );

            $chatlog      = $this->getChatLog($chatLogWhere);
                
            $chatLogWhere = array('id'=>$chatlog['id'],'beginid'=>$chatfriend['beginid']);
        }else{

            $chatLogWhere = array('id'=>$chatid,'beginid'=>$chatfriend['beginid']);

        }

        $this->upChatLog(array('askstatus'=>2),$chatLogWhere);

        $return['error'] =1;
      }else{
        $return['error'] =2;
      }

      return $return;
   }
   /** 
    * 检查时间戳，如与服务器时间差别太大，按服务器时间来
    */
   private function checkTime($time){
       
       $now  =  time();
       
       if ((round($time/1000)-300 > $now) || (round($time/1000)+300 < $now)){
           return $now.'000';
       }else{
           return $time;
       }
   }
   function addXjhchatBlack($data = array())
   {
       $xid       =  (int)$data['xjhid'];
       $fuid      =  $data['fuid'];
       
       $black  =  $this->select_once('xjhlive_black',array('uid'=>$fuid,'xid'=>$xid));
       if(!empty($black)){
           
           $return['errcode']  = 8;
           $return['msg']      = "该用户已被禁言！";
           
           return $return;
       }
       
       $adata  =  array(
           'uid'       =>  $fuid,
           'usertype'  =>  $data['usertype'],
           'xid'       =>  $xid,
           'ctime'     =>  time()
       );
       
       $nid  =  $this->insert_into('xjhlive_black',$adata);
       
       if($nid){
           
           $return['errcode']	=	9;
           
           $return['msg']	=	"用户已被禁言！";
       }else{
           $return['errcode']	=	8;
           
           $return['msg']	=	"操作失败,请重试！";
       }
       
       return $return;
   }
   
   function getXjhchatBlackNum($where = array(),$data=array()){
       $num	=	0;
       if(!empty($where)){
           
           $num	=	$this->select_num("xjhlive_black",$where);
       }
       return $num;
   }
   
   function getXjhchatBlack($where = array(), $data = array())
   {
       if (!empty($where) ){
           
           $row  =  $this->select_once('xjhlive_black',$where);
           
           return $row;
       }
   }
   function getXjhchatBlackList($where = array(), $data = array())
   {
       if (!empty($where) ){
           
           $List  =  $this->select_all('xjhlive_black',$where);
           
           if(!empty($List)){
               
               $uid  =  $authid  =  $wxid  =  array();
               
               foreach($List as $v){
                   if (!empty($v['uid'])){
                       if ($v['usertype'] == 1 || $v['usertype'] == 2 || $v['usertype'] == 3){
                           $uid[]     =  $v['uid'];
                       }
                   }
               }
               if (!empty($uid)){
                   
                   $member     =   $this->select_all('member',array('uid'=>array('in',pylode(',',$uid))),'`uid`,`username`,`moblie`');
                   
                   $resume		=	$this->select_all('resume',array('uid'=>array('in',pylode(',',$uid))),'`uid`,`name`');
                   
                   $company	=	$this->select_all('company',array('uid'=>array('in',pylode(',',$uid))),'`uid`,`name`');
                   
                   $lietou     =   $this->select_all('lt_info',array('uid'=>array('in',pylode(',',$uid))),'`uid`,`realname`');
                   
               }
               
               foreach($List as $k => $v){
                   
                   $List[$k]['ctime_n']	=	date('Y-m-d H:i',$v['ctime']);
                   $List[$k]['username']  =	'';
                   $List[$k]['moblie']	   =	'';
                   
                   if (!empty($member)){
                       foreach($member as $val){
                           if($v['uid'] == $val['uid']){
                               $List[$k]['username']  =	$val['username'];
                               $List[$k]['moblie']	   =	$val['moblie'];
                           }
                       }
                   }
                   if (!empty($resume)){
                       foreach($resume as $val){
                           if($v['uid'] == $val['uid']){
                               $List[$k]['name']	=	$val['name'].'<span style="color:red">[个人]</span>';
                           }
                       }
                   }
                   if (!empty($company)){
                       foreach($company as $val){
                           if($v['uid'] == $val['uid']){
                               $List[$k]['name']	=	$val['name'].'<span style="color:red">[企业]</span>';
                           }
                       }
                   }
                   if (!empty($lietou)){
                       foreach($lietou as $val){
                           if($v['uid'] == $val['uid']){
                               $List[$k]['name']	=	$val['realname'].'<span style="color:red">[猎头]</span>';
                           }
                       }
                   }
               }
           }
           return $List;
       }
   }
   function delXjhchatBlack($id = null , $data = array()) {
       
       if(!empty($id)|| $data['where']){
           
           if(is_array($id)){
               
               $ids    =	$id;
               
               $return['layertype']	=	1;
               
           }else{
               
               $ids    =   @explode(',', $id);
               
               $return['layertype']	=	0;
               
           }
           
           $id            		=   pylode(',', $ids);
           
           if(!empty($id)){
               
               $return['id']      =  $this->delete_all('xjhlive_black',array('id'=>array('in',$id)),'');
               
           }elseif($data['where']){
               
               $return['id']      =  $this->delete_all('xjhlive_black',$data['where'],'');
           }
           
           $return['msg']		=	'禁言';
           
           $return['errcode']	=	$return['id'] ? '9' :'8';
           
           $return['msg']		=	$return['id'] ? $return['msg'].'解除成功！' : $return['msg'].'解除失败！';
           
       }else{
           
           
           $return['msg']		=	'请选择您要操作的数据！';
           
           $return['errcode']	=	8;
           
       }
       
       return	$return;
   }
   function delXjhchat($id = null , $data = array()) {
       
       if(!empty($id)){
           
           if(is_array($id)){
               
               $ids    =   $id;
               $return['layertype']	=	1;
           }else{
               
               $ids    =   @explode(',', $id);
               $return['layertype']	=	0;
           }
           
           $id =   pylode(',', $ids);
           
           if($data['uid']){
               
               $return['id']  =   $this -> delete_all('xjhlive_chat', array('id' => array('in', $id), 'uid' => $data['uid']), '');
           }else{
               
               $return['id']  =   $this->delete_all('xjhlive_chat', array('id' => array('in', $id)), '');
               
           }
           
           $return['msg']		=	'聊天消息';
           
           $return['errcode']	=	$return['id'] ? '9' :'8';
           
           
           $return['msg']		=	$return['id'] ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
           
       }else{
           
           
           $return['msg']		=	'请选择您要删除的数据！';
           
           $return['errcode']	=	8;
           
       }
       
       return	$return;
       
   }
   public function getChatNum($whereData = array()){
       
       
       return  $this->select_num('xjhlive_chat', $whereData);
   }
   /**
    * 宣讲会聊天记录
    * $data['fdata'] 是否需要消息发送人的数据
    */
   public function getChatList($whereData = array(), $data = array())
   {
       //非第一页的，要按照原有的聊天记录查询，按新聊天记录会查询出重复内容
       if (!empty($data['lastid'])){
           
           $whereData['id']  =  array('<=',$data['lastid']);
       }
       
       $field	=	empty($data['field']) ? '*' : $data['field'];
       $List   =   $this->select_all('xjhlive_chat', $whereData, $field);
       
       if(!empty($List)){
           
           $euidarr	=	array();//个人发送人uid
           $cuidarr	=	array();//企业发送人uid
           $luidarr	=	array();//猎头发送人uid
           foreach($List as $key=>$val){
               
               if($val['fusertype']==1){
                   if(!in_array($val['fuid'],$euidarr)){
                       $euidarr[]	=	$val['fuid'];
                   }
               }else if($val['fusertype']==2){
                   if(!in_array($val['fuid'],$cuidarr)){
                       $cuidarr[]	=	$val['fuid'];
                   }
                   
               }else if((int)$val['fusertype']==3){
                   if(!in_array($val['fuid'],$luidarr)){
                       $luidarr[]	=	$val['fuid'];
                   }
               }
           }
           $mid  =  array_merge($euidarr, $cuidarr, $luidarr);
           $mid  =  array_unique($mid);
           
           $xjhid	=	$whereData['xid'];
           //获取发送人相关信息
           if($data['fdata']){
               
               if(!empty($euidarr)){
                   
                   $allresumes	=	$this->select_all('resume',array('uid'=>array('in',pylode(',',$euidarr))),'`name`,`photo`,`phototype`,`sex`,`telphone`,`uid`');
               }
               if(!empty($cuidarr)){
                   
                   $allcoms	=	$this->select_all('company',array('uid'=>array('in',pylode(',',$cuidarr))),'`name`,`shortname`,`logo`,`linkman`,`linktel`,`uid`');
               }
               if(!empty($luidarr)){
                   
                   $alllts	=	$this->select_all('lt_info',array('uid'=>array('in',pylode(',',$luidarr))),'`realname`,`photo`,`moblie`,`uid`');
               }
               
               $member  =  $this->select_all('member',array('uid'=>array('in',pylode(',',$mid))),'`username`,`uid`');
               $user	=	array();
               
               $telphone	=	'';
               if(!empty($allresumes)){
                   
                   foreach($allresumes as $rk=>$rv){
                       
                       if($rv['name']){
                           if (isset($data['utype']) && $data['utype'] == 'admin'){
                               $rname  =  $rv['name'];
                           }else{
                               $rname  =  $rv['sex'] == 1 ? mb_substr($rv['name'], 0, 1, 'utf-8').'先生' : mb_substr($rv['name'], 0, 1, 'utf-8').'女士';
                           }
                       }else{
                           $rname  =  substr_replace($rv['telphone'],'****',4,4);
                       }
                       $user[$rv['uid']]['nickname']  =  $rname;
                       
                       $icon  =  $rv['sex'] == 1 ? $this->config['sy_member_icon'] : $this->config['sy_member_iconv'];
                       if($rv['phototype']==1){
                       		$rv['photo'] = '';
                       }
                       $user[$rv['uid']]['avatar']    =  checkpic($rv['photo'],$icon);
                       
                       foreach($member as $nk=>$nv){
                           if($nv['uid'] == $rv['uid']){
                               $user[$rv['uid']]['username']  =  $nv['username'];
                           }
                       }
                   }
               }
               
               if(!empty($allcoms)){
                   
                   foreach($allcoms as $ck=>$cv){
                       
                       $cname  	=	$cv['name'];
                       
                       $telphone	=	substr_replace($cv['linktel'],'****',4,4);
                       
                       $user[$cv['uid']]['nickname']  =  !empty($cv['shortname']) ? $cv['shortname'] : ($cname?$cname:$telphone);
                       
                       $user[$cv['uid']]['avatar']    =  checkpic($cv['logo'],$this->config['sy_unit_icon']);
                       
                       foreach($member as $nk=>$nv){
                           if($nv['uid'] == $cv['uid']){
                               $user[$cv['uid']]['username']  =  $nv['username'];
                           }
                       }
                       
                   }
               }
               if(!empty($alllts)){
                   
                   foreach($alllts as $lk=>$lv){
                       
                       $cname  	  =  $lv['realname'];
                       
                       $telphone  =  substr_replace($lv['moblie'],'****',4,4);
                       
                       $user[$lv['uid']]['nickname']  =  $cname?$cname:$telphone;
                       
                       $user[$lv['uid']]['avatar']    =  checkpic($lv['photo'],$this->config['sy_lt_icon']);
                       
                       foreach($member as $nk=>$nv){
                           if($nv['uid'] == $lv['uid']){
                               $user[$lv['uid']]['username']  =  $nv['username'];
                           }
                       }
                       
                   }
               }
           }
           //获取发送人相关信息 end
           
           $xjhList	=	$this->select_all('xjhlive',array('id'=>$xjhid), '`id`,`name`');
           
           if($data['sensitive']){
               
               include(LIB_PATH.'sensitive.class.php');
               $instance = Sensitive::getInstance();
           }
           if (isset($data['utype']) && $data['utype'] == 'admin'){
               
               $blacklist  =  $this->select_all('xjhlive_black', array('xid'=>$xjhid),'`uid`,`usertype`');
           }
           
           foreach($List as $key=>$val){
               
               foreach($xjhList as $k=>$v){
                   
                   if($val['xid'] == $v['id']){
                       $List[$key]['xjh_name']		=	$v['name'];
                   }
               }
               $List[$key]['sendTime'] =  ceil($val['sendTime']/1000);
               
               $List[$key]['user'] 	=  $user[$val['fuid']];
               
               if($data['sensitive'] && $instance){//过滤敏感词
                   
                   $content = $val['content'];
                   
                   if(file_exists(DATA_PATH.'sensitive/xjhword.txt')){
                       $instance->addSensitiveWords(DATA_PATH.'sensitive/xjhword.txt');
                       $content    =   $instance->execFilter($content);
                   }
                   
                   $List[$key]['content']	=	$content;
               }
               if (!empty($blacklist)){
                   
                   foreach ($blacklist as $bv){
                       
                       if ($bv['uid'] == $val['fuid'] && $bv['usertype'] == $val['fusertype']){
                           
                           $List[$key]['black'] = 1;
                       }
                   }
               }
           }
       }
       
       return $List;
   }
   
   public function getXjhChat($whereData = array(), $data = array())
   {
       
       $field	=	empty($data['field']) ? '*' : $data['field'];
       
       if(!empty($whereData)){
           
           $row   =   $this->select_once('xjhlive_chat', $whereData, $field);
       }
       
       return $row;
   }
   
   function xhjChat($data = array()){
       if (! empty($data['fuid'])) {
           
           $content	=	$data['content'] ? $data['content'] :'';
           
           $fuid      =  $data['fuid'];
           $usertype  =  (int)$data['fusertype'];
           
           $log['fuid']        =   $fuid;
           $log['ip']          =   $data['ip'];
           $log['fusertype']   =   $usertype;
           $log['content']     =   $content;
           $log['sendTime']    =   $this->checkTime($data['timestamp']);
           $log['msgtype']     =   $data['msgtype'];
           $log['xid']         =   $data['xjhid'];
           
           $nid = $this->addXjhchat($log);
           
           $return['error'] = $nid ? 0 : - 1;
       } else {
           $return['error'] = 1;
           $return['errmsg'] = '请先登录';
       }
       return $return;
   }
   
   public function addXjhchat($data=array()){
       
       $nid    =   $this -> insert_into('xjhlive_chat', $data);
       
       return $nid;
   }
   /**
    * 保存常用语
    */
   public function addChatUseful($data=array()){
       
       if (!isset($data['utype'])){
           if (empty($data['uid']) || empty($data['usertype'])){
               return array('msg'=>'请先登录', 'errcode'=>8);
           }
       }
       $nid  =  $this->insert_into('chat_useful', $data);
       if (isset($nid)){
           $res = array('msg'=>'添加成功', 'errcode'=>9,'id'=>$nid);
       }else{
           $res = array('msg'=>'添加失败', 'errcode'=>8);
       }
       return $res;
   }
   /**
    * 后台自定义常用语，添加
    */
   public function addChatUsefulSet($data=array()){
       $nid  =  $this->insert_into('chat_useful_set', $data);
       if (isset($nid)){
           $res = array('msg'=>'添加成功', 'errcode'=>9);
       }else{
           $res = array('msg'=>'添加失败', 'errcode'=>8);
       }
       return $res;
   }
   /**
    * 后台自定义常用语，修改
    */
   function upChatUsefulSet($where=array(),$data=array()){
       $nid  =  $this->update_once('chat_useful_set', $data, $where);

       if (isset($nid)){
           $res = array('msg'=>'修改成功', 'errcode'=>9);
       }else{
           $res = array('msg'=>'修改失败', 'errcode'=>8);
       }
       return $res;
   }
   /**
    * 后台自定义常用语，查询
    */
   function getUsefulSet($where=array(),$data=array()){
       
       $row   =  $this -> select_once('chat_useful_set', $where);
       return $row;
   }
   /**
    * 后台自定义常用语，查询列表
    */
   function getUsefulSetList($where=array(),$data=array()){
       $field  =  empty($data['field']) ? '*' : $data['field'];

       $List   =  $this -> select_all('chat_useful_set', $where, $field);
       return $List;
   }
   /**
    * 后台自定义常用语，删除
    */
   function delUsefulSet($where=array(),$data=array()){
        $nid  =  $this->delete_all('chat_useful_set', $where);

        if (isset($nid)){
            $res = array('msg'=>'删除成功', 'errcode'=>9);
        }else{
            $res = array('msg'=>'删除失败', 'errcode'=>8);
        }
        return $res;
    }
   /**
    * 修改常用语
    */
   public function upChatUseful($where=array(),$data=array()){
       
       if (!isset($data['utype'])){
           if (empty($data['uid']) || empty($data['usertype'])){
               return array('msg'=>'请先登录', 'errcode'=>8);
           }
           $where['uid'] 		= $data['uid'];
           $where['usertype'] 	= $data['usertype'];
       }
       $nid  =  $this->update_once('chat_useful', $data, $where);
       
       if (isset($nid)){
           $res = array('msg'=>'修改成功', 'errcode'=>9);
       }else{
           $res = array('msg'=>'修改失败', 'errcode'=>8);
       }
       return $res;
   }
   /**
    * 常用语列表
    */
   public function getChatUsefulList($where = array(), $data = array()){
       
       $rows = $this->select_all('chat_useful', $where);
       
       if (!empty($rows)){
           // 后台列表用数据
           if (isset($data['admin'])){
               $mid = $gid = $cid = $lid = array();
               foreach ($rows as $v){
                   if (!in_array($mid, $v['uid'])){
                       $mid[] = $v['uid'];
                   }
                   if ($v['usertype'] == 1 && !in_array($gid, $v['uid'])){
                       $gid[] = $v['uid'];
                   }elseif ($v['usertype'] == 2 && !in_array($cid, $v['uid'])){
                       $cid[] = $v['uid'];
                   }elseif ($v['usertype'] == 3 && !in_array($lid, $v['uid'])){
                       $lid[] = $v['uid'];
                   }
               }
               $member = $this->select_all('member', array('uid'=>array('in',pylode(',', $mid))), 'uid,username');
               if (!empty($gid)){
                   $user = $this->select_all('resume', array('uid'=>array('in',pylode(',', $mid))), 'uid,name');
               }
               if (!empty($cid)){
                   $com = $this->select_all('company', array('uid'=>array('in',pylode(',', $cid))), 'uid,name');
               }
               if (!empty($lid)){
                   $lt = $this->select_all('lt_info', array('uid'=>array('in',pylode(',', $lid))), 'uid,`realname` AS `name`');
               }
               foreach ($rows as $k=>$v){
                   $rows[$k]['username'] = '系统';
                   foreach ($member as $mv){
                       if ($v['uid'] == $mv['uid']){
                           $rows[$k]['username'] = $mv['username'];
                       }
                   }
                   if (!empty($user)){
                       foreach ($user as $uv){
                           if ($v['uid'] == $uv['uid']){
                               $rows[$k]['uname'] = $uv['name'].'&nbsp;&nbsp;<em style="color:#009688">[个人]</em>';
                           }
                       }
                   }
                   if (!empty($com)){
                       foreach ($com as $cv){
                           if ($v['uid'] == $cv['uid']){
                               $rows[$k]['uname'] = $cv['name'].'&nbsp;&nbsp;<em style="color:#009688">[企业]</em>';
                           }
                       }
                   }
                   if (!empty($lt)){
                       foreach ($lt as $lv){
                           if ($v['uid'] == $lv['uid']){
                               $rows[$k]['uname'] = $lv['name'].'&nbsp;&nbsp;<em style="color:#009688">[企业]</em>';
                           }
                       }
                   }
               }
           }
       }
      
       //用户使用时，混合后台定义及用户自定义
       if (isset($data['utype']) && !empty($where['uid']) && !empty($where['usertype'])){
       		$type = $where['usertype'] == 1 ? 2 : 1;
            $list = $this->getUsefulSetList(array('type'=>$type, 'orderby'=>'sort'));

            $useful_list = array();

            foreach ($rows as $key => $value) {
            	$useful = array();
            	if($value['content']){
            		$useful['id'] 		= $value['id'];
            		$useful['content'] = $value['content'];
            		$useful['uid'] 	= $value['uid'];
            		$useful_list[] 	= $useful;
            	}
            }

            foreach ($list as $k => $v) {
            	$useful = array();
            	if($v['content']){
            		$useful['id'] 		= $v['id'];
            		$useful['content'] = $v['content'];
            		$useful_list[] 	= $useful;
            	}
            }

            $rows = $useful_list;
       }
       return $rows;
   }
   /**
    * 删除常用语
    */
   public function delChatUseful($where=array(),$data=array()){
       
       if (!isset($data['utype'])){
           if (empty($where['uid']) || empty($where['usertype'])){
               return array('msg'=>'请先登录', 'errcode'=>8);
           }
           
       }
       $nid  =  $this->delete_all('chat_useful', $where,'');
       
       if (isset($nid)){
           $res = array('msg'=>'删除成功', 'errcode'=>9);
       }else{
           $res = array('msg'=>'删除失败', 'errcode'=>8);
       }
       return $res;
   }
}
?>