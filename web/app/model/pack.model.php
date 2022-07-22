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
class pack_model extends model{
    
    /**
     * @desc  分享红包职位，单条查询（phpyun 5.0）
     */
    function getShareJobOne($id, $data = array()){
        
        $where                  =   array();
        $where['id']            =   intval($id);
        $where['sharepack']     =   1;
        $where['state']         =   1;
        $where['r_status']      =   1;
        $where['status']        =   0;
        
        $jobOne                 =   $this -> select_once('company_job',$where);
        
        if(!empty($jobOne)){
            include (APP_PATH."/config/db.data.php");
            $cache  =   $this -> getClass(array('com','city','hy'));
            $jobOne['hy_n']			=	  $cache['industry_name'][$jobOne['hy']];
            $jobOne['cityname']		= 	  $cache['city_name'][$jobOne['cityid']];
            $jobOne['job_one']		=	  $cache['job_name'][$jobOne['job1']];
            $jobOne['job_two']		=	  $cache['job_name'][$jobOne['job1_son']];
            $jobOne['job_three']	=	  $cache['job_name'][$jobOne['job_post']];
            $jobOne['marriage_n']	=	  $cache['comclass_name'][$jobOne['marriage']];
            $jobOne['number_n']	    =	  $cache['comclass_name'][$jobOne['number']];
            $jobOne['report_n']	    =	  $cache['comclass_name'][$jobOne['report']];
            $jobOne['sex_n']		=	  $arr_data['sex'][$jobOne['sex']];
            $jobOne['age_n']	    =	  $cache['comclass_name'][$jobOne['age']];
			
            if($jobOne['maxsalary']>0){
                if($this->config['resume_salarytype']==1){
                    $jobOne['salary'] = $jobOne['minsalary'].'-'.$jobOne['maxsalary'];
                }else{
                    if($jobOne['maxsalary']<1000){
                        if($this->config['resume_salarytype']==2){
                            $jobOne['salary'] = "1千以下";
                        }elseif($this->config['resume_salarytype']==3){
                            $jobOne['salary'] = "1K以下";
                        }elseif($this->config['resume_salarytype']==4){
                            $jobOne['salary'] = "1k以下";
                        }
                    }else{
                        $jobOne['salary'] = changeSalary($jobOne['minsalary']).'-'.changeSalary($jobOne['maxsalary']);
                    }
                }
            }elseif($jobOne['minsalary']>0){
                if($this->config['resume_salarytype']==1){
                    $jobOne['salary'] = $jobOne['minsalary'];
                }else{
                    $jobOne['salary'] = changeSalary($jobOne['minsalary']);
                }
            }else{
                
                $jobOne['salary'] = '面议';
                
            }
            
            $jobOne['exp_n']    =   $cache['comclass_name'][$jobOne['exp']];
            $jobOne['edu_n']    =   $cache['comclass_name'][$jobOne['edu']];
            
            //联系方式
            $comInfo            =   $this->select_once('company',array('uid'=>$jobOne['uid']),'`name`,`address`,`linktel`,`linkphone`');
            
            if($jobOne['islink']=='2'){
                $jobLink        =   $this-> select_once('company_job_link',array('jobid'=>$jobOne['id']), '`linkman`,`linkmoblie`');
                
            }
            
            if(!empty($jobLink)){
                
                $jobOne['linktel'] = $jobLink['linkmoblie'];
                
            }else{
                
                if($comInfo['linktel']){
                    
                    $jobOne['linktel'] = $comInfo['linktel'];
                    
                }else{
                    
                    $jobOne['linktel'] = $comInfo['linkphone'];
                    
                }
                
            }
            
            $jobOne['address']  =   $comInfo['address'];
            
            
            //赏金信息
            $shareList          =   $this->select_once('company_job_share',array('jobid'=>intval($jobOne['id'])));
            
            if(!empty($shareList)){
                $jobOne['packid']       =   $shareList['id'];
                $jobOne['packnum']      =   $shareList['packnum'];
                $jobOne['packmoney']    =   $shareList['packmoney'];
                $jobOne['packprice']    =   $shareList['packprice'];
                $jobOne['nowprice']     =   sprintf("%.2f", $shareList['packnum']*$shareList['packmoney']);
            }
        }
        return $jobOne;
    }
    
    
    /**
     * @desc  分享红包职位，多条查询（phpyun 5.0）
     */
    function getShareJobList($whereData = array(), $data = array()) {
        
        $field  =   $data['field'] ? $data['field'] : '*';
            
        $List   =   $this -> select_all('company_job_share', $whereData, $field);
        
        if (!empty($List)){
            $List   =   $this -> subShareJob($List);
        }
        
        return $List;
            
        
    }
    
    /**
     * @desc 订单生成
     * @param array $data
     */
    private function addOrder($data = array()){
        require_once 'companyorder.model.php';
        $orderM     =   new companyorder_model($this->db, $this->def);
        return $orderM -> addOrder($data);
    }
    
    /**
     * @desc 分享红包职位 --  列表信息补充（phpyun 5.0）
     */
    private function subShareJob($List){
        
        foreach ($List  as   $v){
            
            $ids[]  =   $v['jobid'];
            
        }
        
        /* 提取职位信息 */
        $jWhere['id']       =   array('in', pylode(',', $ids));
        $jData['field']     =   '`id`,`name`,`com_name`,`lastupdate`';
        
        $jobList            =   $this -> getJobList($jWhere, $jData);
        
        $job                =   $jobList['list'];
        
        if (is_array($job)) {
            foreach ($job   as  $key => $value){
                
                $jobrows[$value['id']]  =   $value;
                
            }
        }
         
        /* 提取推广记录 */
        $lWhere['jobid']    =   array('in', pylode(',', $ids));
        $lData['field']     =   '`jobid`';
        
        $shareLog           =   $this -> getShareLogList($lWhere, $lData);

        $shareNum           =   array();
        if (is_array($shareLog)) {
            foreach ($shareLog as $val){
                $shareNum[$val['jobid']]++;
            }
        }
        
        foreach ($List  as  $k => $v){
            
            $List[$k]['name']           =   $jobrows[$v['jobid']]['name'];
            $List[$k]['com_name']       =   $jobrows[$v['jobid']]['com_name'];
            $List[$k]['nowprice']       =   sprintf("%.2f", $v['packnum'] * $v['packmoney']);
            $List[$k]['sharenum']       =   intval($shareNum[$v['jobid']]);
            $List[$k]['lastupdate']     =   timeForYear($jobrows[$v['jobid']]['lastupdate']);
            $List[$k]['wapurl']         =   Url('wap', array('c'=>'job','a'=>'comapply','id'=>$v['jobid']));
        }
        
        
        return $List;
        
    }
    
    /**
     * @desc 引用job类 ，获取职位信息 （phpyun 5.0）
     */
    private function getJobList($whereData, $data = array()) {
        
        require_once 'job.model.php';
        
        $jobM   =   new job_model($this->db, $this->def);
        
        return  $jobM -> getList($whereData, $data);
    }
     
    /**
     * @desc 查询分享红包职位记录，多条查询 （phpyun 5.0）
     */
    function getShareLogList($whereData, $data = array()) {
        
        $field  =   $data['field'] ? $data['field'] : '*';
        
        $List   =   $this -> select_all('company_job_sharelog', $whereData, $field);
		
		if(!empty($List)){
			foreach($List as $k=>$v){
				
				$List[$k]['time_n']	=	date('Y-m-d H:i:s',$v['time']);	
				
			}
		}
        
        return $List;
    }
    function getShareLogNum($where){
        return $this->select_num('company_job_sharelog',$where);
    }
    /**
     * $desc 悬赏职位查询（phpyun 5.0）
     */
    function getRewardJobInfo($id, $data = array()) {
        
        $field  =   $data['field'] ? $data['field'] : '*';
        if($data['uid']){
			$getWhere	=	array('jobid'=>intval($id),'uid'=>$data['uid']);
		}else{
			$getWhere	=	array('jobid'=>intval($id));
		}
        $info   =   $this -> select_once('company_job_reward', $getWhere, $field);
		
		if($data['isjob']==1  && !empty($info)){
		
			require_once 'job.model.php';
        
			$jobM   =   new job_model($this->db, $this->def);
		
			$jobInfo = $jobM->getInfo(array('id' => $info['jobid']),array('com'=>'yes'));
			$info['jobinfo'] = $jobInfo;
		}
        return $info;
        
    }
	
    /**
	 * $desc 悬赏职位查询（phpyun 5.0）
	 */
	function getRewardJobList($whereData = array(), $data = array()) {
	    
	    $field  =   $data['field'] ? $data['field'] : '*';
	
    	$List   =   $this -> select_all('company_job_reward', $whereData, $field);
     	
    	if ($data['utype'] == 'admin') {
    	    
    	    $List   =   $this -> subRewardJob($List);
    	    
    	}
    	
    	return $List;
    	
    }
    /**
     * @desc 补充悬赏职位列表信息 （phpyun 5.0）
     */
    private function subRewardJob($List) {
        
        foreach ($List as $v){
            
            $jobids[]   =   $v['jobid'];
            
        }
        
        /* 提取职位信息 */
        $JWhere['id']       =   array('in', pylode(',', $jobids));
        $JData['field']     =   '`id`,`name`,`com_name`,`status`,`lastupdate`';
        
        $jobListA           =   $this -> getJobList($JWhere, $JData);
        $job                =   $jobListA['list'];
        
        /* 应聘人数 */
        $rWhere['jobid']    =   array('in', pylode(',', $jobids));
        $rWhere['groupby']  =   'jobid';
        $rData['field']     =   '`jobid`, count(*) as num';
        
        $sqList             =   $this -> getJobRewardList($rWhere, $rData); 
        
        /* 仲裁 */
        $zWhere['jobid']    =   array('in', pylode(',', $jobids));
        $zWhere['status']   =   '26';
        $zData['field']     =   '`jobid`, `status`';
        
        $sqArb              =   $this -> getJobRewardList($zWhere, $zData); 
        
        foreach ($List as $k => $v){
            
            foreach ($job as $jv){
                
                if ($v['jobid'] == $jv['id']) {
                    $List[$k]['name']           =   $jv['name'];
                    $List[$k]['com_name']       =   $jv['com_name'];
                    $List[$k]['status']         =   $jv['status'];
                    $List[$k]['lastupdate']     =   $jv['lastupdate'];
                }
            }
            
            foreach ($sqList as $sv){
                
                if ($v['jobid'] == $sv['jobid']) {
                    $List[$k]['sqnum']  =   $sv['num'];
                }
            }
            foreach ($sqArb as $rv){
                
                if ($v['jobid'] == $rv['jobid']) {
                    $List[$k]['sqArb']  =   $rv['status'];
                }
            }
			$List[$k]['sqnum'] = $List[$k]['sqnum']?$List[$k]['sqnum']:0;
        }
        
        return $List;
        
    }
	 /**
	 * $desc 悬赏职位查询--小程序
	 */
	function getRewardJobWxList($whereData = array(), $data = array()) {
	    
	    $field  =   $data['field'] ? $data['field'] : '*';
	
    	$List   =   $this -> select_all('company_job', $whereData, $field);
     	
		if(is_array($List)){
			
			foreach($List as $key=>$value){
				
                $jobId[]	=	$value['id'];
				
            }
			
			$rewardList		=	$this->select_all('company_job_reward',array('jobid'=>array('in',pylode(',',$jobId))));
			
			if(is_array($rewardList)){
				
				foreach($rewardList as $key=>$value){
					
					$rewadArr[$value['jobid']] = $value;
				}
			}
			
			$cache  =   $this -> getClass(array('com','city'));
			
			foreach($List as $key=>$value){
				
				if($value['minsalary'] && $value['maxsalary']){
                    if($this->config['resume_salarytype']==1){
					   $List[$key]['job_salary'] =	$value['minsalary']."~".$value['maxsalary'];
                    }else{
                        if($value['maxsalary']<1000){
                            if($this->config['resume_salarytype']==2){
                                $List[$key]['job_salary'] = "1千";
                            }elseif($this->config['resume_salarytype']==3){
                                $List[$key]['job_salary'] = "1K";
                            }elseif($this->config['resume_salarytype']==4){
                                $List[$key]['job_salary'] = "1k";
                            }
                        }else{
                            $List[$key]['job_salary'] = changeSalary($value['minsalary'])."~".changeSalary($value['maxsalary']);
                        }
                    }
				}elseif($value['minsalary']){
                    if($this->config['resume_salarytype']==1){
					   $List[$key]['job_salary'] =	$value['minsalary'];
                    }else{
                       $List[$key]['job_salary'] =  changeSalary($value['minsalary']); 
                    }
				}else{
                    $List[$key]['job_salary'] =	"面议";
                }
				
				$List[$key]['cityname']		= 	$cache['city_name'][$value['cityid']]?$cache['city_name'][$value['cityid']]:$cache['city_name'][$value['provinceid']];
				$List[$key]['sqmoney'] 		=	floatval( $rewadArr[$value['id']]['sqmoney']);
				$List[$key]['invitemoney'] 	=	floatval( $rewadArr[$value['id']]['invitemoney']);
				$List[$key]['offermoney'] 	=	floatval( $rewadArr[$value['id']]['offermoney']);
				$List[$key]['money'] 		=	floatval( $rewadArr[$value['id']]['money']);
				$List[$key]['job_exp']		= 	$cache['comclass_name'][$value['exp']];
				$List[$key]['job_edu'] 		= 	$cache['comclass_name'][$value['edu']];
			}
			
		}
		
        return $List;   	
    	
    }
    
    /**
     * @desc 查询company_job_rewardlist表
     */
    function getJobRewardList($whereData = array(), $data = array()) {
        
        $field  =   $data['field'] ? $data['field'] : '*';
        
        $List   =   $this -> select_all('company_job_rewardlist', $whereData, $field);
        
        if (!empty($List)) {
            
            if ($data['utype']) {
                
                $List   =   $this -> subJobReward($List,$data);
            }
        }
        
        return $List;
    }
    /**
     * @desc 悬赏应聘列表补充信息
     */
    private function subJobReward($List,$data=array()) {
        
        foreach ($List  as $v){
            
            $jobid[]    =   $v['jobid'];
            
            if ($v['usertype'] == '3') {
                
                $lteid[]    =   $v['eid'];
				
				$ltuids[]	=	$v['uid'];
                
            }else{
                
				$uids[]		=	$v['uid'];
				
                $eid[]      =   $v['eid'];
                
            }
            
            $rewardid[]     =   $v['id'];
            
        }
		require_once 'resume.model.php';
        
        $resumeM    =   new resume_model($this->db, $this->def);
		
		$members	=	$resumeM->getResumeList(array('uid'=>array('in',pylode(',',$uids))));
		
		require_once 'lietou.model.php';
        
        $ltM    	=   new lietou_model($this->db, $this->def);
		
		$lts		=	$ltM->getList(array('uid'=>array('in',pylode(',',$uids))));
		
         
        /* 提取职位名称信息 */
        $jWhere['id']       =   array('in', pylode(',', $jobid));
        $jData['field']     =   '`id`,`name`';
        
        $jobListA           =   $this -> getJobList($jWhere);
        $job                =   $jobListA['list'];
        
        /* 查询简历信息 */
        if (!empty($eid)) {
            $rWhere['id']   =   array('in', pylode(',', $eid));
            $rData['field'] =   '`id`,`uname`,`edu`,`exp`,`job_classid`';
            $listA          =   $this -> getResumeList($rWhere, $rData);
            $ulist          =   $listA['list'];
        }
        
        /* 查询猎头简历信息 */
        if (!empty($lteid)) {
            $ltWhere['id']      =   array('in', pylode(',', $lteid));
            $ltData['field']    =   '`id`,`name`,`edu`,`exp`,`jobname`,`linktel`';
            $ltulist            =   $this -> getLtResumeList($ltWhere, $ltData);
        }
        
        /* 查询操作日志 */
        $logWhere['rewardid']   =   array('in', pylode(',', $rewardid));
        $logWhere['orderby']    =   'id,asc';
        
        $logData['field']       =   '*';
        
        $logList                =   $this -> getJobRewardLogList($logWhere, $logData); 
        $logListArr             =   array();
        if (is_array($logList)) {
            foreach ($logList as $value){
                $logListArr[$value['rewardid']][]    =   $value;
            }
        }
        if($data['utype']=='admin' || $data['utype']=='com'){
			$utype=2;
		}else{
			$utype=1;
		}
        foreach ($List as $k => $v){
			
			if($v['usertype'==3]){
				foreach ($lts as $value){
                    if($value['uid'] == $v['uid']){
                        $List[$k]['photo']    =   $value['photo_big'];
                    }
					
				}
			}else{
				foreach ($members as $value){
                    if($value['uid'] == $v['uid']){
                        $List[$k]['photo']    =   $value['photo'];
                    }
					
				}
			}
            
            $List[$k]['wapinvite_url'] = Url('wap',array('c'=>'resume','a'=>'invite','uid'=>$v['uid'],'rewardid'=>$v['id'])); 
            $List[$k]['log']    =   $this -> getStatusInfo($v['id'], $utype, $v['status'],$logListArr[$v['id']]);
            
            if($v['datetime']){
                $List[$k]['datetime_n'] =   date('Y-m-d H:i',$v['datetime']);
            }
            foreach ($job as $jv){
                
                if ($v['jobid'] == $jv['id']) {
                    
                    $List[$k]['name']   =   $jv['name'];
                    $List[$k]['wapjob_url'] = Url('wap',array('c'=>'job','a'=>'comapply','id'=>$v['jobid']));
                }
            }
            
            if (is_array($ulist)) {
                
                foreach ($ulist as $uv){
                    
                    if ($v['eid'] == $uv['id']) {
                        $List[$k]['reid']       =   $uv['id'];
                        $List[$k]['uname']      =   $data['utype']=='admin'?$uv['uname']:mb_substr($uv['uname'],0,1,'utf-8').'**';
                        $List[$k]['edu']        =   $uv['edu_n'];
                        $List[$k]['exp']        =   $uv['exp_n'];
                        
                        if ($uv['job_classid']) {
                            $List[$k]['jobclass']   =   $uv['job_classname'];
                        }
                    }
                }
            }
            
            if (is_array($ltulist)) {
                
                foreach ($ltulist as $ltv){
                    
                    if ($v['eid'] == $ltv['id']) {
                        $List[$k]['uname']      =   $data['utype']=='admin'?$ltv['name']:mb_substr($ltv['name'],0,1,'utf-8').'**';
                        $List[$k]['edu']        =   $ltv['edu_n'];
                        $List[$k]['exp']        =   $ltv['exp_n'];
                        $List[$k]['jobclass']   =   $ltv['jobname'];
                        $List[$k]['linktel']    =   $ltv['linktel'];
                     }
                }
            }
        }
        
        return $List;
    }
    
    /**
     * @desc 查询简历信息
     */
    private function getResumeList($whereData = array(), $data = array()){
        
        require_once 'resume.model.php';
        
        $resumeM    =   new resume_model($this->db, $this->def);
        
        return  $resumeM -> getList($whereData, $data);
        
    }
    
    
    /**
     * @desc 查询猎头简历库信息
     */
    private function getLtResumeList($whereData = array(), $data = array()){
        
        require_once 'talent.model.php';
        
        $talentM    =   new talent_model($this->db, $this->def);
        
        return $talentM -> getList($whereData, $data);
        
    }
    
    /**
     * @desc 查询操作日志 company_job_rewardlog
     */
    function getJobRewardLogList($whereData = array(), $data = array()) {
        
        $field  =   $data['field'] ? $data['field'] : '*';
        
        $List   =   $this -> select_all('company_job_rewardlog', $whereData, $field);
        
        return $List;
        
    }
    
    
    //查询分享红包职位   
    function getShareJob(){
        $where      = array(
            'sharepack' =>  1,
            'state'     =>  1,
            'r_status'  =>  1,
            'status'    =>  0
        );
        $jobList    = $this->select_all('company_job',$where,"`id`,`uid`,`name`,`com_name`,`lastupdate`,`description`,`cityid`,`minsalary`,`maxsalary`");
        if(is_array($jobList)){
            foreach($jobList as $key=>$value){
                $jobId[] = $value['id'];
            }
            $shareList = $this->select_all(
                'company_job_share',
                array(
                    'jobid'     =>  array('in',pylode(',',$jobId)),
                    'orderby'   =>  'id' 
                )
            );

            if(is_array($shareList)){
                include PLUS_PATH."/city.cache.php";
                
                foreach($shareList as $k=>$v){

                    foreach($jobList as $key=>$value){
                        
                        if($v['jobid'] == $value['id']){
                            $job[$k]                  =   $value;
                            $job[$k]['description']   =   strip_tags($value['description']);
                            $job[$k]['cityname']      =   $city_name[$value['cityid']];
                            if($value['maxsalary']>0){
                                if($this ->config['resume_salarytype']==1){
                                    $job[$k]['salary']    =   $value['minsalary'].'-'.$value['maxsalary'];
                                }else{
                                    if($value['maxsalary']<1000){
                                        if($this->config['resume_salarytype']==2){
                                            $job[$k]['salary']      =   '1千';
                                        }elseif($this->config['resume_salarytype']==3){
                                            $job[$k]['salary']      =   '1K';
                                        }elseif($this->config['resume_salarytype']==4){
                                            $job[$k]['salary']      =   '1k';
                                        }
                                    }else{
                                        $job[$k]['salary']      =   changeSalary($value['minsalary']).'-'.changeSalary($value['maxsalary']);
                                    }
                                }
                            }elseif($value['minsalary']>0){
                                if($this ->config['resume_salarytype']==1){
                                    $job[$k]['salary']    =   $value['minsalary'];
                                }else{
                                    $job[$k]['salary']    =   changeSalary($value['minsalary']);
                                }
                            }

                            $job[$k]['packnum']       =   $v['packnum'];
                            $job[$k]['packmoney']     =   $v['packmoney'];
                            $job[$k]['packprice']     =   $v['packprice'];
                            $job[$k]['nowprice']      =   sprintf("%.2f", $v['packnum']*$v['packmoney']);
                        }
                    }
                }
                
            }
        }
        return $job;
    }
    
    
    
    /**
     * @desc 删除分享红包职位
     * @param int $uid
     * @param int $jobid
     * @param array $data :utype=admin，后台管理员删除
     */
    function delShareJob($uid,$jobid,$data = array()){
        
        
        //查询原有职位 是否有未用完的赏金
        $shareJob = $this->select_once('company_job_share',array('jobid' => $jobid, 'uid' => $uid), '`packnum`,`packmoney`,`uid`');

		
        if($shareJob['uid'] != $uid){
			$return['msg']		=	'非法操作！';
            
            $return['errcode']	=	'8';
            
            return $return;
		}
        if($shareJob['packnum']>0){
            
            $price  =   $shareJob['packnum'] * $shareJob['packmoney'];
            
            //退还赏金
            $this->update_once('company_statis',array('packpay'=>array('+', $price)),array('uid'=>intval($shareJob['uid'])));

            //生成记录
            $this->orderLog($price,intval($shareJob['uid']),'取消职位赏金分享，退还剩余赏金！',1);
        }
        
        $this -> update_once('company_job',array('sharepack'=>'0'),array('id'=>intval($jobid)));
		
		 
        $this -> delete_all('company_job_sharelog', array('jobid'=>intval($jobid)), '');
        
        /* 后台管理员删除，提示已经系统信息发送 */
        if ($data['utype'] == 'admin') {
            
            $job  = $this -> select_once('company_job',array('id'=>intval($jobid)), '`name`,`uid`');
            
            $return['id']   =   $this->delete_all("company_job_share",array('jobid'=>intval($jobid)),'');
            
            if($return['id']){
                
                $msg    =  '管理员删除职位《'.$job['name'].'》分享';
                 
                //发送系统通知
                include_once('sysmsg.model.php');
                
                $sysmsgM    =   new sysmsg_model($this->db, $this->def);
                
                $sysmsgM    ->  addInfo(array('uid'=>$uid,'usertype'=>2, 'content'=>$msg));
                
            }
            
            $return['msg']		=	'分享职位(ID:'.$jobid.')';
            
            $return['errcode']	=	$return['id'] ? '9' :'8';
            $return['msg']		=	$return['id'] ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
            
            return $return;
             
        }else{
            
            $nid = $this->delete_all("company_job_share",array('jobid'=>intval($jobid)),'');
            
            $return['errcode']  = $nid ? '9' : '8';
            
            $return['msg']      =   $nid ? '取消成功' : '取消失败';
            
            return $return;
        }
        
    }

	
	
	function delrewardJob($uid, $jobid, $data = array()){
	    
	    $reward    =   $this -> getRewardJobInfo($jobid, array('field'=>'`id`,`uid`'));
		if($reward['uid'] != $uid && $data['utype']!='admin'){
			$return['msg']		=	'非法操作！';
            $data['error']		=	'1';
            $return['errcode']	=	'8';
            
            return $return;
		}
	    if($reward['id']){
	        
	        //查询原有职位 是否有未执行完流程的赏单
            $where['comid']     =   intval($reward['uid']);
            $where['jobid']     =   intval($jobid);
            $where['status']    =   array('notin', '0,8,18,9,20,21,23,26,27,28,29');
            
            $rewardJobNum       =   $this -> select_num('company_job_rewardlist', $where);
             
	        if($rewardJobNum > 0){
	            $data['errcode'] = 8;
	            $data['error'] = '1';
	            $data['msg'] = '当前职位还有未执行完的推荐赏单！';
	            
	        }else{
	            
	            $job   =   $this -> select_once('company_job', array('id'=>intval($jobid)),'`name`,`uid`');
	            
	            //删除相关职位以及赏单
	            $this -> delete_all('company_job_reward', array('uid'=>intval($reward['uid']), 'jobid'=>intval($jobid)),'');

	            if (!empty($job)) {
	                $this -> update_once('company_job', array('rewardpack'=>'0'), array('uid'=>intval($reward['uid']), 'id'=>intval($jobid)));
	            }
	            
	            //删除推荐简历列表
	            $this -> delete_all('company_job_rewardlist', array('comid'=>intval($reward['uid']), 'jobid'=>intval($jobid)), '');
	            
	            //删除流程日志记录
	            $this -> delete_all('company_job_rewardlog', array('jobid'=>intval($jobid)), '');
	            
	            $data['error'] = '0';
	            $data['errcode'] = 9;
	            
	            if ($data['utype']=='admin') {
	                
	                $msg    =  '管理员删除职位《'.$job['name'].'》悬赏';
	                
	                //发送系统通知
	                include_once('sysmsg.model.php');
	                
	                $sysmsgM    =   new sysmsg_model($this->db, $this->def);
	                
	                $sysmsgM    ->  addInfo(array('uid'=>intval($job['uid']),'usertype'=>2, 'content'=>$msg));
	                
	                
	                $data['msg'] = '删除悬赏职位《'.$job['name'].'》';
	            }
	            
	        }
	    }else{
            $data['errcode'] = 8;
	        $data['error'] = '1';
	        $data['msg'] = '请选择正确的职位！';
	    }
	    
	    return $data;
	}
	
	/*格式案例*/

	/*
	* @name 函数名称、作用 (必须)
	* @abstract 申明变量/类/方法（建议写）
	* @author 函数作者 （必须）
	* @other  其他需要注明事项
	*/
	
	/*单行说明*/
	
	/*
	* @name 分享红包浏览赏金发放处理函数
	* @abstract job:分享职位数据 uid：分享人UID openid：浏览者微信ID
	* @author KSC 2017-12-11 
	*/
	/*当前分享职位还有余额*/
	function shareJobLook($job, $uid, $openid)
    {

        /* 当前分享职位还有余额 */
        if ($job['packid'] && $job['packnum'] > 0) {

            // 查询相关openid是否已记录
            $lookLog    =   $this->select_num('company_job_sharelog', array( 'jobid' => $job['id'], 'wxid' => $openid));

            if ($lookLog < 1) {

                // 查询当前用户类型
                $User   =   $this->select_once('member', array('uid' => $uid),'`usertype`');

                if ($User['usertype'] == '1') {

                    $Table  =   'member_statis';
                } elseif ($User['usertype'] == '2') {

                    $Table  =   'company_statis';
                }

                if ($Table) {
                    // 此处单独查询statis表 只是为了兼容升级用户 防止新增红包金额字段为NULL导致无法增加金额
                    $Statis =   $this->select_once($Table, array('uid' => $uid));
                    if (! empty($Statis)) {
                        
                        // 减除分享余额
                        $this->update_once('company_job_share', array('packnum' => array('-', 1)), array('id' => $job['packid']));

                        // 当数量最后剩余1时 也就是本次分享结束 该职位的分享赏金已用完，取消该职位红包状态
                        if ($job['packnum'] == '1') {

                            $this->update_once('company_job', array('sharepack' => 0), array('id' => $job['id']));
                        }
                        
                        // 插入浏览记录
                        $this->insert_into('company_job_sharelog', array('uid' => (int)$uid, 'jobid' => $job['id'], 'jobname' => $job['name'], 'packmoney' => $job['packmoney'], 'comid' => $job['uid'], 'wxid' => $openid, 'time' => time()));

                        // 赏金发放到账户
                        $this->update_once($Table, array('packpay' => bcadd($Statis['packpay'], $job['packmoney'], 2)), array('uid' => $uid));

                        // 发放记录
                        $dingdan    =   time().rand(10000, 99999);
                        $this->insert_into('company_pay', array('order_id' => $dingdan, 'order_price' => $job['packmoney'], 'pay_time' => time(), 'pay_state' => 2, 'com_id' => $uid, 'pay_remark' => '分享红包浏览赏金', 'type' => 2, 'pay_type' => 2, 'did' => 0));
                        // 减除发布者数量
                    }
                }
            }
        }
    }
	
	//拉取微信访客OPENID
	function getWxOpenid($url, $isuser = ''){


		$app_id = $this->config['wx_appid'];
		$app_secret = $this->config['wx_appsecret'];
		$my_url = $url;
		$code = $_GET['code'];
		session_start();
		
		if(empty($code) || $code == $_SESSION['wxcode']){
			
			$_SESSION['wx']['state'] = md5(uniqid(rand(), TRUE));
			
			$dialog_url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$app_id."&redirect_uri=".urlencode($my_url)."&response_type=code&scope=snsapi_userinfo&state=".$_SESSION['wx']['state']."#wechat_redirect";
			header("location:".$dialog_url);
		}else{
			$_SESSION['wxcode'] = $code;
		}
		
		if($_GET['state'] == $_SESSION['wx']['state']){
			
			$token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $app_id . "&secret=" . $app_secret . "&code=".$code."&grant_type=authorization_code";
			if(function_exists('curl_init')) {

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$token_url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				$response=curl_exec ($ch);
				curl_close ($ch);

				$user = json_decode($response,true);
				//是否读取昵称等信息
				if($user['openid'] && $isuser == '1'){
					$nick_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$user['access_token'].'&openid='.$user['openid'].'&lang=zh_CN';

					$ch 		= 	curl_init();
					curl_setopt($ch, CURLOPT_URL,$nick_url);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
					$response	=	curl_exec ($ch);
					curl_close ($ch);

					$user 		= json_decode($response,true);
				}
			}
		}

		return $user;
	
	}
	
	//分享红包推广生成订单
	function redPackOrder($data){
	     
		if($data['jobid'] && $data['packmoney'] && $data['packnum']){
			//判断金额 数量
			$packmoney   =   sprintf("%.2f", $data['packmoney']);
			$packnum     =   floatval($data['packnum']);
			
			if($packmoney>0 && $packnum>0){
				//判断职位ID真实性
				$job    =   $this->select_once('company_job', array('id' => $data['jobid'], 'uid' => $data['uid']),'`id`,`uid`,`sharepack`');

				if(empty($job)){
				
				    $return['error'] = '请选择正确的推广职位！';
				}elseif($job['sharepack']=='1'){
					
				    $return['error'] = '当前职位正在推广中，请不要重复设置！';
				}else{
					//该职位是否已经做了推广，防止重复

					//计算需付费金额
					$price = $packnum * $packmoney;
					
					//最后确认金额完整性
					if($price < 1){
						$return['error'] = '推广总金额不得小于1元！';
					}else{
						//生成相关订单
						$dingdan=time().rand(10000,99999);
						$orderData['type']='8';//8 分享红包推广 9悬赏红包 10 职位置顶 11职位紧急 12 职位推荐 13自动刷新
						$orderData['order_id']=$dingdan;
						$orderData['order_price']=$price;
						$orderData['order_type']=$data['pay_type'];
						$orderData['order_time']=time();
						$orderData['order_state']="1";
						$orderData['order_remark']='分享职位推广';
						$orderData['uid']=$data['uid'];
						$orderData['usertype']=$data['usertype'];
						$orderData['did']=$data['did'];
						$orderData['order_info']=serialize(array('jobid'=>$data['jobid'],'packnum'=>$data['packnum'],'packmoney'=>$data['packmoney'],'packprice'=>$price));
						$id=$this->addOrder($orderData);
						
						if($id){
							$orderData['id']=$id;
							$return['order']=$orderData;
						}else{
							$return['error'] = '订单生成失败！';
						}
					}
				}
			}else{
				$return['error'] = '请正确填写推广金额及发放数量！';
			}
		}else{
			$return['error'] = '参数填写错误，请重新设置！';
		}
		return $return;
	}
	
	//悬赏红包推广生成订单
	function rewardPackOrder($data){
	    
	    $uid       =   intval($data['uid']);
	    $usertype  =   intval($data['usertype']);
	    $did       =   $data['did'] ? intval($data['did']) : $this->config['did'];
	    
	    $paytype   =   $data['paytype'];
	    
		if($data['jobid'] && $data['rewardid']){
		    
		    $jobid    =   intval($data['jobid']);
		    $rewardid =   intval($data['rewardid']);
		    
			//验证当前赏金职位真实性
		    $reward = $this -> select_once('company_job_rewardlist', array('id' => $rewardid, 'comid' => $uid,'jobid' => $jobid));
		    
			//判断金额 数量
			if($reward['money']>0){
			    
				//判断职位ID真实性
			    $job     =   $this->select_once('company_job', array('uid' => $uid, 'id' => $jobid),"`id`,`uid`");
			    
				if(empty($job)){
				    
					$return['error'] = '请选择正确的悬赏职位！';
				}else{
				    
					//该职位是否已经做了推广，防止重复
					//计算需付费金额
					$price = $reward['money'];
					//最后确认金额完整性
					
					if($price < 1){
					    
						$return['error'] = '职位赏金错误，请重试！';
					}else{
						//删除重复订单
						$order    =   $this->select_all('company_order', array('uid' => $uid, 'usertype' => 2, 'type' => 9, 'rewardid' => $rewardid, 'order_state' => '1'));

					    if ($order) {
					        $this->update_once('company_order', array('order_state' => 4, 'order_remark' => '重复下单，交易关闭'), array('uid' => $uid, 'usertype' => 2, 'type' => 9, 'rewardid' => $rewardid, 'order_state' => '1'));
					    }
						//生成相关订单
						$dingdan					=	time().rand(10000,99999);
						$orderData['type']			=	'9';// 9悬赏红包
						$orderData['order_id']		=	$dingdan;
						$orderData['order_price']	=	$price;
						$orderData['order_time']	=	time();
						$orderData['order_type']	=	$paytype;
						$orderData['order_state']	=	'1';
						$orderData['order_remark']	=	'预先支付职位赏金';
						$orderData['uid']			=	$uid;
						$orderData['usertype']		=	$usertype;
						$orderData['did']			=	$did;
						$orderData['rewardid']		=	$rewardid;
						
						$id   =   $this -> addOrder($orderData);
						
						if($id){
							$orderData['id']		=	$id;
							$return['order']		=	$orderData;
						}else{
							$return['error'] = '订单生成失败！';
						}
					}
				}
			}else{
				$return['error'] = '职位赏金不正确，请重试！';
			}
		}else{
			$return['error'] = '参数填写错误，请重新设置！';
		}
		return $return;
	}

	//发布悬赏职位
	function rewardJob($data){	    
		if($data['jobid']){
			
			if(($data['sqmoney']+$data['invitemoney']+$data['offermoney'])>1){
				//判断职位ID真实性
			    $job	=	$this -> select_once("company_job",array('uid'=>$data['uid'],'id'=>$data['jobid']),"`id`,`uid`,`rewardpack`");
				
				if(empty($job)){
					
					$return['error'] = '请选择正确的推广职位！';
					
				}elseif($job['rewardpack']=='1'){
					
					$return['error'] = '当前职位已是赏金职位，请不要重复设置！';
					
				}else{
					//生成悬赏职位
					$val['uid']			=	$job['uid'];
					
					$val['jobid']		=	$job['id'];
					
					$val['sqmoney']		=	floatval($data['sqmoney']);
					
					$val['invitemoney']	=	floatval($data['invitemoney']);
					
					$val['offermoney']	=	floatval($data['offermoney']);
					
					$val['money']		=	(floatval($data['offermoney'])+floatval($data['invitemoney'])+floatval($data['sqmoney']));
					
					$val['stime']		=	time();
					
					$val['project']		=	$data['project'];
					
					$val['exp']			=	$data['exp'];
					
					$val['edu']			=	$data['edu'];
					
					$val['skill']		=	$data['skill'];
					
					$this -> insert_into("company_job_reward",$val);
					//修改职位悬赏属性字段
					$this -> update_once("company_job",array('rewardpack'=>'1'),array('id'=>$job['id']));
					
					$return['error'] = 'ok';
					
				}
			}else{
				
				$return['error'] = '悬赏总金额不得低于1元！';
			}
		}else{
			
			$return['error'] = '参数填写错误，请重新设置！';
		}
		return $return;
	}
	
	
	//查询单个用户赏金申请记录（个人用）
	
	function getRewardInfo($jobid,$uid,$usertype='1'){
		
		$rewardInfo = $this->select_once('company_job_rewardlist',array('jobid' => intval($jobid), 'uid' => intval($uid)));

		return $rewardInfo;
	
	}
	
	//用户申请记录 企业用
	function getReward($id,$uid){
		
		$rewardInfo = $this->select_once("company_job_rewardlist",array('id'=>(int)$id,'comid'=>(int)$uid));

		return $rewardInfo;
	
	}
	
	//悬赏应聘记录
	/*function getRewardJob($jobid,$isjob='0'){
		
		$rewardJob = $this->select_once("company_job_reward","`jobid`='".(int)$jobid."'");
		if($isjob=='1' && !empty($rewardJob)){
			//查询相关职位信息
			$jobInfo = $this->select_once("company_job","`id`='".$rewardJob['jobid']."'");
			$rewardJob['jobinfo'] = $jobInfo;
		}
		return $rewardJob;
	
	}*/
	
	/**
	 * @desc 查询悬赏单相关的各类信息 包括职位、企业、个人、状态等
	 */
	function getRewardAll($id,$status=''){
		
		$rewardJob = $this->select_once('company_job_rewardlist',array('id'=>(int)$id));
		
		if(!empty($rewardJob)){
			//查企业
			$comInfo = $this->select_once("company",array('uid'=>$rewardJob['comid']));
			//查职位
			$jobInfo = $this->select_once("company_job",array('id'=>$rewardJob['jobid']));
			//查个人
			$userInfo = $this->select_once("resume",array('uid'=>$rewardJob['uid']));
			if($status){
				$nowReward = $this->select_once("company_job_rewardlog",array('rewardid'=>$rewardJob['id'],'status'=>$status));
			
				$Data['loginfo'] =  $nowReward['loginfo'];
				$Data['arbinfo'] = $nowReward['remark'];
				$Data['arbpic'] = checkpic($nowReward['arbpic']);
			}
			//整理返回信息
			$Data['comname'] = $comInfo['name'];
			if(!$comInfo['linktel']){
				$Data['linkphone'] = $comInfo['linkphone'];
			}else{
				$Data['linktel'] = $comInfo['linktel'];
			}
			$Data['jobname'] = $jobInfo['name'];
			$Data['username'] = $userInfo['name'];
			$Data['telphone'] = $userInfo['telphone'];
		}
		return $Data;
	
	}

        // 判断是否有申请资格
    function veriftyUser($jobid, $uid, $usertype)
    {
	    
        $return =   array();

        if (! $jobid) {

            $return['error']    =   5;
            $return['msg']      =   '请选择正确的赏金职位！';
        } else {
            
            if (! $uid) {
            
                $return['error']    =   0;
                $return['msg']      =   '请先登录！';
            } else {
                
                // 个人登录情况下 只有自荐
                if ($usertype == 1) {
                    
                    // 判断是否需要手机认证
                    if ($this->config['sy_reward_tel'] == '1') {
                        // 查询用户是否手机认证
                        $userInfo = $this->select_once('resume', array('uid' => intval($uid)), "`moblie_status`");
                        
                        if ($userInfo['moblie_status'] != '1') {
                            
                            $return['error']    =   9;
                            $return['msg']      =   '请先进行手机认证！';
                        }
                    }
                    
                    if (! $return['msg']) {

                        $sqNum  =   $this->select_num('company_job_rewardlist', array('uid' => intval($uid), 'status' => array('notin', '18, 19, 20, 21, 23, 26, 27, 28, 29')));
					
                        if ($this->config['sy_reward_sqnum'] > 0 && $sqNum >= $this->config['sy_reward_sqnum']) {
                            $return['error']    =   8;
                            $return['msg']      =   '最多只能同时申请' . $this->config['sy_reward_sqnum'] . '份悬赏职位';
                        } else {
                     
                            // 当前职位是否开通悬赏并正在招聘
                            $jobInfo    =   $this->select_once('company_job', array('id' => intval($jobid), 'rewardpack' => 1, 'state' => 1, 'r_status' => 1, 'status' => 0));
                          
							if (empty($jobInfo)) {
                                
                                $return['error']    =   3;
                                $return['msg']      =   '悬赏职位不存在或已停止赏金招聘！';
                            } else {
                                
                                // 判断之前是否已申请
                                $rows   =   $this -> select_once('userid_job', array('uid' => intval($uid),'isdel'=>9,'job_id' => intval($jobid)), '`id`');
							   if (! empty($rows)) {

                                    $return['error']    =   6;
                                    $return['msg']      =   '您已申请过该职位！';
                                } else {  
                                    
                                    $rewardInfo =   $this->getRewardInfo($jobid, $uid);

                                    if (! empty($rewardInfo)) {
                                        
                                        $return['error']    =   3;
                                        $return['msg']      =   '您已申请过该职位！';
                                    } else {
                                        
                                        $rewardJob  =   $this->select_once('company_job_reward', array('jobid' => intval($jobInfo['id'])));

                                        // 判断是否已邀请面试
                                        $useridmsg  =   $this->select_once('userid_msg', array('uid' => intval($uid),'isdel'=>9,'jobid' => intval($jobid)), '`id`');
                                        if (! empty($useridmsg)) {
                                            
                                            $return['error']    =   4;
                                            $return['msg']      =   '该职位已邀请您面试，无需再投简历！';
                                        } else {
                                            
                                            $rows   =   $this -> select_once('resume_expect', array('uid' => intval($uid), 'defaults' => 1), '`id`,`name`,`r_status`,`status`,`state`');
                                            
                                             
                                            if (! empty($rows)) {
                                                if ($rows['state'] == '1') {
                                                    if($rows['status'] != '1'){
                                                        $return['error']    =   13;
                                                        $return['msg']      =   '请先公开您的简历！';
                                                    }else{
                                                        $data['jobid']  =   $jobInfo['id'];
                                                        $data['comid']  =   $jobInfo['uid'];
                                                        $data['eid']    =   $rows['id'];
                                                        $data['name']   =   $rows['name'];

                                                        $return['error']    =   1;
                                                        // 测试匹配度
                                                        if ($rewardJob['exp'] == '1') {
                                                            
                                                            $expNum =   $this -> select_num('resume_work', array('eid' => $rows['id']));
                                                           
                                                            if ($expNum < 1) {
                                                                $data['exptype']    =   1; // 工作经历不匹配
                                                                $return['error']    =   7;
                                                                $return['msg']      =   '简历暂不符合职位要求,缺少工作经历';
                                                            }
                                                        }
                                                        
                                                        if ($rewardJob['edu'] == '1') {
                                                            
                                                            $eduNum =   $this -> select_num('resume_edu', array('eid' => $rows['id']));
                                                            
                                                            if ($eduNum < 1) {
                                                                $data['edutype']    =   1; // 教育经历不匹配
                                                                $return['error']    =   7;
                                                                $return['msg']      =   '简历暂不符合职位要求,缺少教育经历';
                                                            }
                                                        }
                                                        
                                                        if ($rewardJob['skill'] == '1') {
                                                            
                                                            $skillNum   =   $this->select_num('resume_skill', array('eid' => $rows['id'], 'pic' => array('<>', '')));
                    
                                                            if ($skillNum < 1) {

                                                                $return['error']    =   7;
                                                                $data['skilltype']  =   1;
                                                                $return['msg']      =   '简历暂不符合职位要求,缺少技能证书';
                                                            }
                                                        }
                                                        if ($rewardJob['project'] == '1') {
                                                            
                                                            $projectNum =   $this->select_num('resume_project', array('eid' => $rows['id']));
                                                            if ($projectNum < 1) {

                                                                $return['error']        =   7;
                                                                $data['projecttype']    =   1;
                                                                $return['msg']          =   '简历暂不符合职位要求,缺少项目经历';
                                                            }
                                                        }
                                                        $data['sqmoney']        =   $rewardJob['sqmoney'];
                                                        $data['invitemoney']    =   $rewardJob['invitemoney'];
                                                        $data['offermoney']     =   $rewardJob['offermoney'];
                                                        $data['money']          =   $rewardJob['money'];

                                                        $return['data']         =   $data;
                                                    }
                                                    
                                                } else {
                                                    
                                                    $return['error']    =   10;
                                                    $return['msg']      =   '您的简历正在审核，暂无法使用！';
                                                }
                                            } else {
                                                
                                                $return['error'] = 2;
                                                $return['msg'] = '您还没有合适的简历，是否先添加简历？';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
					
                } elseif ($usertype == 3) {
                    
                    // 查询简历库是否有合适简历
                    $talentNum  =   $this->select_num('lt_talent', array('uid' => intval($uid)));
                    if ($talentNum > 0) {
                        
                        $return['error'] = 12; // 简历库有简历 弹出推荐界面
                    } else {
                       
                        $return['error'] = 11; // 没有简历库 提醒创建
                    }
                } else {
                    
                    $return['error']    =   3;
                    $return['msg']      =   '仅支持个人自荐以及猎头中介推荐！';
                }
            }
        }
        if ($return['msg']) {
            $return['msg'] = $return['msg'];
        }
        return $return;
    }
	
	function veriftyLtuser($jobid,$uid,$usertype,$eid){
		if(!$jobid){
		    $return['error'] = 5;
			$return['msg'] = '请选择正确的赏金职位！';
		}else{
			if(!$uid){
				$return['error'] = 0;
				$return['msg'] = '请先登录！';
			}else{
				if($usertype==3){
					//当前职位是否开通悬赏并正在招聘
					$jobInfo		=	$this->select_once('company_job', array('id' => $jobid, 'rewardpack' => 1, 'state' => 1, 'r_status' => 1, 'status' => 0));
					if(empty($jobInfo)){
						$return['error']=	3;
						$return['msg'] 	= 	'悬赏职位不存在或已停止赏金招聘！';
					}else{
						//查询简历是否符合需求
						$expectInfo	=	$this->select_once('lt_talent', array('uid' => $uid, 'id' => $eid));
						if(!empty($expectInfo)){
							
							if($this->config['sy_reward_tel']=='1' && $expectInfo['telstatus']!='1'){
								$return['error']	= 	8;
								$return['msg'] 		= 	'当前简历还未授权认证，无法推荐!';
							}else{
								$sqNum	=	$this->select_num('company_job_rewardlist', array('eid' => $eid, 'status' => array('notin', '18,19,20,21,23,26,27,28,29')));
								
								if($sqNum>0){
									$return['error']= 	8;
									$return['msg'] 	= 	'当前简历已推荐，请耐心等待企业回复';
								}else{
									//验证是否重复推荐
									$sqNumjob	=	$this->select_num('company_job_rewardlist', array('eid' => $eid, 'jobid' => $jobid));
									if($sqNumjob>0){
										
										$return['error']	=	9;
										$return['msg'] 		= 	'请不要重复推荐';
									}else{
										//验证职位需求
										$rewardJob		=	$this->select_once('company_job_reward', array('jobid' => $jobInfo['id']));
										$data['jobid'] 	= 	$jobInfo['id'];
										$data['comid'] 	= 	$jobInfo['uid'];
										$data['eid'] 	= 	$expectInfo['id'];
										$data['name'] 	= 	$expectInfo['name'];
										$return['error']= 	1;
										
										//测试匹配度
										if($rewardJob['exp']=='1' && $expectInfo['expinfo']==''){
											$data['exptype']	= 	1;//工作经历不匹配
											$return['error'] 	= 	7;
											$return['msg'] 		= 	'简历暂不符合职位要求,缺少工作经历';
										}
										if($rewardJob['edu']=='1' && $expectInfo['eduinfo']==''){
											
											$data['edutype'] 	= 	1;//教育经历不匹配
											$return['error'] 	= 	7;
											$return['msg'] 		= 	'简历暂不符合职位要求,缺少教育经历';
										}
										if($rewardJob['skill']=='1' && $expectInfo['skillinfo']==''){
											$return['error'] 	= 	7;
											$data['skilltype'] 	= 	1;
											$return['msg'] 		= 	'简历暂不符合职位要求,缺少技能特长描述';
										}
										if($rewardJob['project']=='1' && $expectInfo['projectinfo']==''){
											$return['error'] 	= 	7;
											$data['projecttype']= 	1;
											$return['msg'] 		= 	'简历暂不符合职位要求,缺少项目经历';
										}
										$data['sqmoney'] 		= 	$rewardJob['sqmoney'];
										$data['invitemoney'] 	= 	$rewardJob['invitemoney'];
										$data['offermoney'] 	= 	$rewardJob['offermoney'];
										$data['money'] 			= 	$rewardJob['money'];

										$return['data'] = $data;
									}
								}
							}
						}else{
							$return['error']=	2;
							$return['msg'] 	= 	'简历数据错误，请重新推荐！';
						}
					}
				}else{
					$return['error']= 	3;
					$return['msg'] 	= 	'仅支持个人自荐以及猎头中介推荐！';
				}
			}
		}

		if($return['msg']){
			$return['msg']	=	$return['msg'];
		}
		
		return $return;
	}
	//申请悬赏职位
	function sqRewardJob($jobid,$uid,$usertype,$eid=''){
		//验证资格
		if($usertype==3){
			$verifty = $this->veriftyLtuser($jobid,$uid,$usertype,$eid);
		}else{
			$verifty = $this->veriftyUser($jobid,$uid,$usertype);
		}

		if($verifty['error']=='1'){//验证通过
			//插入申请记录
			$data['uid'] 		= 	(int)$uid;
			$data['eid']		= 	(int)$verifty['data']['eid'];
			$data['comid']		= 	(int)$verifty['data']['comid'];
			$data['jobid'] 		= 	(int)$jobid;
			$data['datetime'] 	= 	time();
			$data['status'] 	= 	0;
			$data['sqmoney'] 	= 	$verifty['data']['sqmoney'];
			$data['invitemoney']= 	$verifty['data']['invitemoney'];
			$data['offermoney'] = 	$verifty['data']['offermoney'];
			$data['money'] 		= 	$verifty['data']['money'];
			$data['usertype'] 	= 	$usertype;
			
			$cid	=	$this->insert_into('company_job_rewardlist',$data);

			return array('error'=>1,'comuid'=>$data['comid'],'tid'=>$cid);
		}else{
			return $verifty;
		}
	}
	function getStatusInfo($rewardid,$utype,$status,$rewardLog=array()){
		
		$hour = $this->config['sy_reward_hour'];
		if(empty($rewardLog)){
			$rewardLog  = $this->getJobRewardLogList(array('rewardid'=>$rewardid,'orderby'=>'id,asc'));
		}
		if(is_array($rewardLog)){
			foreach($rewardLog as $key=>$value){
				if($value['status']==$status){
					$rewardInfo = $value;
				}
				//展示操作流程记录
			   if($value['status']=='1'){
					
					$msg = '企业查阅简历，预先支付全额赏金';
					if($value['pay']>0){
						$msg.=',发放投递赏金'.$value['pay'].'元。';
					}
					
				}elseif($value['status']=='2'){
					$msg = '企业邀请面试。<br/>'.$value['loginfo'];

				}elseif($value['status']=='3'){

					$msg = '求职者接受面试邀请。';
					
				}elseif($value['status']=='4'){
					
					$msg = '求职者已确认面试。';
						
				}elseif($value['status']=='5'){

					$msg = '企业已确认求职者面试';
					if($value['pay']>0){
						$msg.=',发放面试赏金'.$value['pay'].'元。';
					}
					if($key==(count($rewardLog)-1)){
						$endMsg = '等待企业发放Offer';
					}
					
				}elseif($value['status']=='6'){

					$msg = '企业发出Offer';
				
				}elseif($value['status']=='7'){

					$msg = '求职者确认已入职';
					
				}elseif($value['status']=='8'){

					$msg = '企业确认入职';
					if($value['pay']>0){
						$msg.=',发放入职赏金'.$value['pay'].'元。';
					}
				}elseif($value['status']=='18'){

					$msg = '求职者取消申请';
					
				}elseif($value['status']=='19'){

					$msg = '企业结束赏单';
					
				}elseif($value['status']=='20'){

					$msg = '企业放弃该简历';
				}elseif($value['status']=='21'){

					$msg = '求职者拒绝面试';
				}elseif($value['status']=='22'){

					$msg = '企业否认求职者参与面试';
				}elseif($value['status']=='23'){

					$msg = '企业认为未达要求，本次推荐结束';
				}elseif($value['status']=='24'){

					$msg = '求职者放弃入职';
				}elseif($value['status']=='25'){

					$msg = '企业否认已入职';
				}elseif($value['status']=='26'){

					$msg = $value['loginfo'].'<br/>申请自述：'.$value['remark'];

				}elseif($value['status']=='27'){

					$msg = '求职者放弃仲裁';

				}elseif($value['status']=='28'){

					$msg = $value['loginfo'].'<br/>仲裁说明：'.$value['remark'];
				}elseif($value['status']=='29'){

					$msg = $value['loginfo'].'<br/>仲裁说明：'.$value['remark'];
				}
				$showLog['time'] = $value['ctime'];
                $showLog['time_n'] = date('Y-m-d H:i',$value['ctime']);
				$showLog['info'] = $msg;

				$logList['loglist'][] = $showLog;
				
			}
		}
		
		if($status=='0'){
			$nowMsg = '等待企业查看';
				
		}elseif($status=='1'){
			$nowMsg = '企业已预付赏金查看简历';
			$endMsg = '等待企业邀请面试';
			//可操作项
			if($utype=='2'){//企业操作

				$input[] = array('name'=>'邀请面试','status'=>'2');
			}
			
		}elseif($status=='2'){

			$nowMsg = '企业已邀请面试';

			$endMsg = '等待求职者接受面试邀请';
			if($utype=='1'){//企业操作
				$input[] = array('name'=>'接受面试','status'=>'3');
				$input[] = array('name'=>'拒绝面试','status'=>'21');
			}
			if($utype=='2'){
				
				//判断当前操作状态是否超过24小时,超过固定时间段个人无回应则可以直接结束赏单退回剩余赏金
				
				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){


					$input[] = array('name'=>'结束赏单','status'=>'19');

				}
			}

		}elseif($status=='3'){
			$nowMsg = '求职者接受邀请';
			$endMsg = '等待求职者确认面试';
			if($utype=='1'){//企业操作
				$input[] = array('name'=>'确认已面试','status'=>'4');

				
			}
			if($utype=='2'){
				
				//判断当前操作状态是否超过24小时,超过固定时间段个人无回应则可以直接结束赏单退回剩余赏金

				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){


					$input[] = array('name'=>'结束赏单','status'=>'19');

				}
			}
			
		}elseif($status=='4'){
			$nowMsg = '求职者确认面试';
			$endMsg = '等待企业确认面试';
			if($utype=='2'){//企业操作
				$input[] = array('name'=>'确认已面试','status'=>'5');
				$input[] = array('name'=>'否认已面试','status'=>'22');
				//判断当前操作状态是否超过24小时
			}
			if($utype=='1'){
				
				//判断当前操作状态是否超过24小时,超过固定时间段企业无回应则可以直接领取相应阶段赏金
				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){

					$input[] = array('name'=>'领取赏金','status'=>'18');

				}
			}

		}elseif($status=='5'){
			$nowMsg = '企业已确认面试';
			$endMsg = '等待企业发放Offer';
			if($utype=='2'){//企业操作
				$input[] = array('name'=>'发放Offer','status'=>'6');
				$input[] = array('name'=>'未达要求','status'=>'23');
			}
			
		}elseif($status=='6'){
			$nowMsg = '企业已发放Offer';
			$endMsg = '等待求职者入职';
			if($utype=='1'){//企业操作
				$input[] = array('name'=>'确认入职','status'=>'7');
				$input[] = array('name'=>'放弃入职','status'=>'24');
			}
			if($utype=='2'){
				
				//判断当前操作状态是否超过24小时,超过固定时间段个人无回应则可以直接结束赏单退回剩余赏金

				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){


					$input[] = array('name'=>'结束赏单','status'=>'19');

				}
			}
			
		}elseif($status=='7'){
			$nowMsg = '求职者已确认入职';
			$endMsg = '等待企业确认入职';
			if($utype=='2'){//企业操作
				$input[] = array('name'=>'确认入职','status'=>'8');
				$input[] = array('name'=>'否认入职','status'=>'25');
			}
			if($utype=='1'){
				
				//判断当前操作状态是否超过24小时,超过固定时间段企业无回应则可以直接领取相应阶段赏金
				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){


					$input[] = array('name'=>'领取赏金','status'=>'18');

				}
			}
			
		}elseif($status=='8'){
			$nowMsg = '企业确认入职';
			
		}elseif($status=='18'){
			$nowMsg = '求职者取消申请';
			
		}elseif($status=='19'){
			$nowMsg = '企业结束赏单';
			
		}elseif($status=='20'){
			$nowMsg = '企业放弃简历';

		}elseif($status=='21'){
			$nowMsg = '求职者拒绝面试';

		}elseif($status=='22'){
			

			$nowMsg = '企业否认求职者参与面试';
			if($utype=='1'){//企业操作
				$input[] = array('name'=>'申请仲裁','status'=>'26');
				$input[] = array('name'=>'放弃仲裁','status'=>'27');

			}
			if($utype=='2'){
					
				//判断当前操作状态是否超过24小时,超过固定时间段个人无回应则可以直接结束赏单退回剩余赏金

				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){

					$input[] = array('name'=>'结束赏单','status'=>'19');

				}
			}
		}elseif($status=='23'){

			$nowMsg = '企业认为未达要求';

		}elseif($status=='24'){

			$nowMsg = '求职者放弃入职';

		}elseif($status=='25'){

			$nowMsg = '企业否认已入职';
			if($utype=='1'){//企业操作
				$input[] = array('name'=>'申请仲裁','status'=>'26');
				$input[] = array('name'=>'放弃仲裁','status'=>'27');
			}
			if($utype=='2'){
					
				//判断当前操作状态是否超过24小时,超过固定时间段个人无回应则可以直接结束赏单退回剩余赏金
				$hourTime = $hour-round((time()-$rewardInfo['ctime'])/3600,1);
				if($hourTime<=0){

					$input[] = array('name'=>'结束赏单','status'=>'19');

				}
			}

		}elseif($status=='26'){

			$nowMsg = '求职者发起仲裁';

		}elseif($status=='27'){

			$nowMsg = '求职者放弃仲裁';

		}elseif($status=='28'){

			$nowMsg = '仲裁结果：企业胜出';

		}elseif($status=='29'){

			$nowMsg = '仲裁结果：求职者胜出';
		}
		
		$logList['nowmsg'] = $nowMsg;
		$logList['input'] = $input;
		$logList['endmsg']= $endMsg;
		$logList['rewardinfo'] = $rewardInfo;

		
		return $logList;
	}
	
	//日志操作
	/*当前操作状态
	 *0：待查看
	 *1：企业接受简历（冻结悬赏金额）
	 *2：企业邀请面试						20：取消录用
	 *3：个人接受面试						21：个人拒绝面试
	 *4：个人确认面试  
	 *5：企业确认面试,发放赏金				22：企业确认未面试
	 *6：企业发放offer						23：未达要求，面试不成功
	 *7：个人确认入职						24：拒绝入职
	 *8：企业确认入职,发放赏金				25：企业确认未入职
	 *
	 *26：个人申请仲裁						27：放弃仲裁	28：仲裁企业胜出 29：仲裁个人胜出  
	 *
	 *18：4，7企业长时间未操作 个人可直接领取赏金
	 *19:个人未操作，企业可申请结束赏单2、3、6、22、25状态超24小时企业可直接结束赏单
	 *22、25 个人可申请仲裁
	 */
		
	function logStatus($rewardid,$status,$uid,$utype,$data=array())
	{
	
		if($rewardid && $status){

			$hour		=	$this->config['sy_reward_hour'];

			//查询当前申请单数据
			$rewardInfo	=	$this->select_once('company_job_rewardlist', array('id'=>$rewardid));

			if(!empty($rewardInfo)){

				if ($data['base'] || $data['file']['tmp_name']){

                    $upArr   =  array(
                        'file'	=>	$data['file'],
                        'dir'	=>	'pack',
                        'base'	=>	$data['base'],
                    );

                    $result		=	$this -> upload($upArr);

                    if (!empty($result['msg'])){

                         $error	=	$result['msg'];
                    }elseif (!empty($result['picurl'])){
                        
                        $logData['arbpic']  =  $result['picurl'];
                    }
                }
                unset($data['file']);
                unset($data['base']);
                $rstatus	=	$rewardInfo['status'];
                if(in_array($rewardInfo['status'],array('18','19','20','21','23','27','28','29'))){//订单处于用户操作终结状态
                
                    $error = '本次悬赏单已结束，无法继续操作！';
              
                }else{
                    $logData['jobid']	=	$rewardInfo['jobid'];
                    $logData['rewardid']=	$rewardInfo['id'];
                    $logData['eid']		=	$rewardInfo['eid'];
                    $logData['uid']		=	$uid;
                    $logData['utype']	=	$utype;
                    $logData['status']	=	$status;
                    $logData['ostatus'] =	$rstatus;
					
					if($utype=='2'){//企业身份操作

						/******************************************企业操作选项************************************/
						if($rewardInfo['comid']!=$uid){

							$error = '操作人身份错误！';

						}elseif(!in_array($status,array('2','5','6','8','19','20','22','23','25'))){//检测操作状态
							
							$error = '请正确操作！';

						}else{
							if($status=='2'){//邀请面试
							
								if($rstatus!='1'){
									if($rstatus>1){
										$error = '请不要重复邀请！';
									}else{
										$error = '请先支付职位赏金！';
									}
									

								}else{
									//邀请面试信息是否完整
									if($data['linkman']==''){
										
										$error = '请填写联系人！';
									}elseif($data['linktel']==''){
										
										$error = '请填写联系人电话！';

									}elseif($data['intertime']==''){
										$error = '请选择面试日期！';

									}elseif($data['address']==''){

										$error = '请填写面试地址！';

									}else{
										$invitetime = strtotime($data['intertime']);
										if($invitetime>=strtotime(date('Y-m-d'))){

											$logData['loginfo'] = "联系人：".$data['linkman']."<br/>联系电话：".$data['linktel']."<br/>面试日期：".$data['intertime']."<br/>面试地址：".$data['address']."<br/>面试备注：".$data['content'];

										}else{
											$error = '面试日期不合理！';
										}
									}
								}

							}elseif($status=='5'){//企业确认面试发放赏金
								
								if($rstatus!='4'){

									$error = '请等待求职者确认面试！';
								}else{
									if($rewardInfo['invitemoney']>0){
										//发放面试赏金至个人账户
										$logData['pay'] = $rewardInfo['invitemoney'];
										$msg = '面试赏金：'.$rewardInfo['invitemoney'];
										//发放赏金
										$this->uppay($rewardInfo['comid'],$rewardInfo['uid'],$rewardInfo['usertype'],$rewardInfo['invitemoney'],$msg);
									}
								}
							
							}elseif($status=='6'){//企业发放Offer
								
								if($rstatus!='5'){

									$error = '请先确认求职者已面试！';
								}
							}elseif($status=='8'){//企业确认入职
								
								if($rstatus!='7'){

									$error = '请等待求职者确认入职！';
								}else{
									if($rewardInfo['offermoney']>0){
										//发放面试赏金至个人账户
										$logData['pay'] = $rewardInfo['offermoney'];
										$msg = '入职赏金：'.$rewardInfo['offermoney'];
										//发放赏金
										$this->uppay($rewardInfo['comid'],$rewardInfo['uid'],$rewardInfo['usertype'],$rewardInfo['offermoney'],$msg);
									}
								}
							}elseif($status=='19'){//个人久未回应 企业结束赏单
								
								if(!in_array($rstatus,array('2','3','6','22','25'))){

									$error = '请等待求职者回应！';
								}else{
									$nowReward = $this->select_once("company_job_rewardlog",array('rewardid'=>$rewardid,'status'=>$rstatus));

									$hourTime = $hour-round((time()-$nowReward['ctime'])/3600,1);
									if($hourTime<=0){
										if(in_array($rstatus,array('2','3','22'))){
										
											$hpay = $rewardInfo['invitemoney']+$rewardInfo['offermoney'];
											if($hpay>0){
												$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
												$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

												//归还赏金
												$this->orderLog($hpay,$rewardInfo['comid'],'求职者久未回应，归还面试、入职赏金至赏金账户!',2);
											}
										
										}elseif(in_array($rstatus,array('6','25'))){
										
											//退还剩余入职赏金
											$hpay = $rewardInfo['offermoney'];
											if($hpay>0){
												$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
												$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

												//归还赏金
												$this->orderLog($hpay,$uid,'求职者久未回应，归还入职赏金至赏金账户!',2);
											}
										}
									
									}else{
										$error = '请耐心等待求职者回应,剩余时间：'.$hourTime.'小时！';
									}
									
								
								}
							}elseif($status=='20'){//企业放弃简历
								
								if($rstatus!='1'){

									$error = '您还未接受简历，无需放弃！';
								}else{
									//退还赏金
									$hpay = $rewardInfo['invitemoney']+$rewardInfo['offermoney'];
									if($hpay>0){
										$statis = $this->select_once('company_statis',array('uid'=>$uid),"`packpay`");
										$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$uid));

										//归还赏金
										$this->orderLog($hpay,$uid,'放弃简历，归还职位赏金至赏金账户!',2);
									}
									
								}
							}elseif($status=='22'){//企业否认求职者参与面试
								
								if($rstatus!='4'){

									$error = '请等待求职者确认面试！';
								}
							}elseif($status=='23'){//面试失败 不录用该人才 
								
								if($rstatus!='5'){

									$error = '请先确认求职者是否参与面试！';
								}else{
									//退还剩余入职赏金
									$hpay = $rewardInfo['offermoney'];
									if($hpay>0){
										$statis = $this->select_once('company_statis',array('uid'=>$uid),"`packpay`");
										$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$uid));

										//归还赏金
										$this->orderLog($hpay,$uid,'企业认为未达要求，求职者面试失败，归还入职赏金至赏金账户!',2);
									}
								}
							}elseif($status=='25'){//企业否认求职者入职
								
								if($rstatus!='7'){

									$error = '请等待求职者是否确定入职！';
								}
							}
						}
						/******************************************企业操作选项END************************************/
					}elseif($utype=='1' || $utype=='3'){
						/******************************************求职者操作选项************************************/
						if($rewardInfo['uid']!=$uid){

							$error = '操作人身份错误！';

						}elseif(!in_array($status,array('3','4','7','18','21','24','26','27'))){//检测操作状态
							
							$error = '请正确操作！';

						}else{
							if($status=='3'){//接受
								if($rstatus!='2'){

									$error = '请先等待企业发出邀请！';
								}
							}elseif($status=='4'){//确认参与面试
								if($rstatus!='3'){

									$error = '请先接受邀请面试！';
								}
							}elseif($status=='7'){//确认入职

								if($rstatus!='6'){

									$error = '请先等待企业发出offer！';
								}
							}elseif($status=='18'){//企业未回应 直接领取剩余赏金

								if($rstatus!='4' && $rstatus!='7'){

									$error = '请先等待企业回应！';
								}else{
									$nowReward = $this->select_once("company_job_rewardlog",array('rewardid'=>$rewardid,'status'=>$rstatus));
									
									$hourTime = $hour-round((time()-$nowReward['ctime'])/3600,1);
									
									if($hourTime<=0){

										if($rstatus=='4'){//直接领取面试赏金

											if($rewardInfo['invitemoney']>0){
												//发放面试赏金至个人账户
												$logData['pay'] = $rewardInfo['invitemoney'];
												$msg = '面试赏金：'.$rewardInfo['invitemoney'];
												//发放赏金
												$this->uppay($rewardInfo['comid'],$rewardInfo['uid'],$rewardInfo['usertype'],$rewardInfo['invitemoney'],$msg);
												
											}
										}elseif($rstatus=='7'){//直接领取入职赏金
											if($rewardInfo['offermoney']>0){
							
												//发放面试赏金至个人账户
												$logData['pay'] = $rewardInfo['offermoney'];
												$msg = '入职赏金：'.$rewardInfo['offermoney'];
												//发放赏金
												$this->uppay($rewardInfo['comid'],$rewardInfo['uid'],$rewardInfo['usertype'],$rewardInfo['offermoney'],$msg);
											}
										}

									}else{
										$error = '请耐心等待企业回应,剩余时间：'.$hourTime.'小时！';
									}
								}

							}elseif($status=='21'){//拒绝面试
								if($rstatus!='2'){

									$error = '请先等待企业发出邀请！';
								}else{
									//系统返还企业面试、入职赏金
									$hpay = $rewardInfo['invitemoney']+$rewardInfo['offermoney'];
									if($hpay>0){
										$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
										$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

										//归还赏金
										$this->orderLog($hpay,$rewardInfo['comid'],'求职者拒绝面试，归还职位赏金至赏金账户!',2);
									}
								}
							}elseif($status=='24'){//拒绝入职
								if($rstatus!='6'){

									$error = '请先等待企业发出offer！';
								}else{
									//退还剩余入职赏金
									$hpay = $rewardInfo['offermoney'];
									if($hpay>0){
										$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
										$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

										//归还赏金
										$this->orderLog($hpay,$rewardInfo['comid'],'求职者拒绝入职，归还入职赏金至赏金账户!',2);
									}
								}
							}elseif($status=='26'){//申请仲裁 企业否认面试 企业否认入职情况下
								if($rstatus!='22' && $rstatus!='25' ){

									$error = '暂无可仲裁需求！';
								}else{
									if($rstatus=='22'){
										$logData['loginfo'] = '企业否认求职者参与面试，求职者发起仲裁需求，申请网站介入';
									}
									if($rstatus=='25'){
										$logData['loginfo'] = '企业否认求职者已入职，求职者发起仲裁需求，申请网站介入';
									}
									if($data['arbpic']){
										$logData['arbpic'] = $data['arbpic'];
									}
									if($data['content']){
										$logData['remark'] = $data['content'];
									}
								}
							}elseif($status=='27'){//放弃仲裁

								if($rstatus!='22' && $rstatus!='25' ){

									$error = '请按步骤操作！';
								}else{
									if($rstatus=='22'){//退还面试、入职赏金
										//系统返还企业面试、入职赏金
										$hpay = $rewardInfo['invitemoney']+$rewardInfo['offermoney'];
										if($hpay>0){
											$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
											$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

											//归还赏金
											$this->orderLog($hpay,$rewardInfo['comid'],'求职者放弃仲裁，归还职位赏金至赏金账户!',2);
										}

									}elseif($rstatus=='25'){//退还入职赏金
										//退还剩余入职赏金
										$hpay = $rewardInfo['offermoney'];
										if($hpay>0){
											$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
											$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

											//归还赏金
											$this->orderLog($hpay,$rewardInfo['comid'],'求职者放弃仲裁，归还入职赏金至赏金账户!',2);
										}
									
									}
								}
							}
						
						}
						/******************************************求职者操作选项END************************************/
					}elseif($utype=='admin'){
						if(!in_array($status,array('28','29'))){//检测操作状态
							
							$error = '请正确操作！';

						}else{
							
							if($rstatus!='26'){

								$error	=	'无人申请仲裁或仲裁已结束！';
							}else{
								$logData['remark'] = $data['content'];
								$nowReward	=	$this->select_once('company_job_rewardlog',array('rewardid'=>$rewardid,'status'=>$rstatus));

								if($status=='28'){//退款给企业

									$logData['loginfo']	=	'仲裁结果：企业胜出，系统退款结束赏单';

									if($nowReward['ostatus']=='22'){//退还面试、入职赏金
										$hpay	=	$rewardInfo['invitemoney'] + $rewardInfo['offermoney'];
										if($hpay>0){

											$statis	=	$this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
											$this->update_once('company_statis', array('packpay' => array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

											//归还赏金
											$this->orderLog($hpay,$rewardInfo['comid'],'管理员仲裁，面试、入职赏金退还至赏金账户!',2);
										}
									}elseif($nowReward['ostatus']=='25'){
										$hpay = $rewardInfo['offermoney'];
										if($hpay>0){
											$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
											$this->update_once("company_statis",array('packpay'=>array('+',$hpay)),array('uid'=>$rewardInfo['comid']));

											//归还赏金
											$this->orderLog($hpay,$rewardInfo['comid'],'管理员仲裁，归还入职赏金至赏金账户!',2);
										}
									}								
								}elseif($status=='29'){//发放赏金给个人

									

									if($nowReward['ostatus']=='22'){//发放面试赏金给个人 退还入职赏金给商家
										
										$logData['loginfo'] = '仲裁结果：求职者胜出，系统发放面试赏金，退还入职赏金，结束赏单';

										$uhpay = $rewardInfo['invitemoney'];
										$chpay = $rewardInfo['offermoney'];
										if($uhpay>0){
												
											$logData['pay'] = $uhpay;
											$msg = '管理员仲裁，发放面试赏金：'.$uhpay;
											//发放赏金
											$this->uppay($rewardInfo['comid'],$rewardInfo['uid'],$rewardInfo['usertype'],$uhpay,$msg);
										
										}
										if($chpay>0){
											$statis = $this->select_once('company_statis',array('uid'=>$rewardInfo['comid']),"`packpay`");
											$this->update_once("company_statis",array('packpay'=>array('+',$chpay)),array('uid'=>$rewardInfo['comid']));

											//归还赏金
											$this->orderLog($chpay,$rewardInfo['comid'],'管理员仲裁，发放面试赏金给用户，并退还剩余入职赏金!',2);
										}


									}elseif($nowReward['ostatus']=='25'){
										$uhpay = $rewardInfo['offermoney'];
										if($uhpay>0){
											
											$logData['loginfo'] = '仲裁结果：求职者胜出，系统发放入职赏金，结束赏单';


											$logData['pay'] = $uhpay;
											$msg = '管理员仲裁，发放入职赏金：'.$uhpay;
											//发放赏金
											$this->uppay($rewardInfo['comid'],$rewardInfo['uid'],$rewardInfo['usertype'],$uhpay,$msg);
										
										}
										
									}
								}
							}
						}
					}
					//以上操作条件判断完成 统一执行状态操作以及增加操作记录
					if($error==''){
					
						//更改状态
						$this->upstatus($rewardInfo['id'],$status);
						//操作记录
						$this->statusLog($logData);

						//短信微信通知
						$this->sendMsg($rewardInfo,$utype,$status, $data['port']);
						
					}
				}

			}else{
				
				$error = '当前悬赏职位数据出错！';
			}

		}else{
			//参数不全 
			$error = '参数不全 ！';
		}
		return array('error'=>$error);
	
	}
	
	function uppay($comid,$uid,$utype,$price,$mark){
		
		if($utype==3){
			$table = 'lt_statis';
		}else{
			$table = 'member_statis';
		}
		//$statis = $this->select_once($table,array('uid'=>$uid),"`packpay`");
		//增加金额记录
		$this->orderLog('-'.$price,$comid,'发放'.$mark,2);
		//增加求职者金额
		$this->update_once($table,array('packpay'=>array('+',$price)),array('uid'=>$uid));
		//增加金额记录
		$this->orderLog($price,$uid,'获得'.$mark,$utype);

	}
	//修改赏单状态
	function upstatus($id,$status){
		
		$this->update_once('company_job_rewardlist',array('status'=>$status),array('id'=>$id));
	}
	//查询参与悬赏数量
    function getrewardNum($where){
	    return $this->select_num('company_job_rewardlist',$where);
    }
	//操作记录
	function statusLog($data){
		
		$data['ctime'] = time();

		$this->insert_into("company_job_rewardlog",$data);
	
	}
	//金额记录
	function orderLog($price,$comid,$pay_remark,$utype=''){
		
		if(!$utype){
			$user = $this -> select_once('member',array('uid'=>$utype),"`usertype`");
			$utype = $user['usertype'];
		}
		$orderid = time().rand(1000,9999);

		$this->insert_into('company_pay',array('order_id' => $orderid, 'order_price' => $price, 'pay_time' => time(), 'pay_state' => '2', 'com_id' => $comid, 'pay_remark' => $pay_remark, 'type' => '2' , 'pay_type' => '100', 'usertype' => $utype));
		
	}

	//账户提现
	function withDraw($uid,$usertype,$money,$realname){
		
	    $errcode = 1;
	    
		if(!$realname || !$uid || !$usertype || !$money){

			$error   =   '参数不完整，请重试！';
			$errcode =   2;
			
		}elseif($this->config['sy_withdraw_minmoney']>0 && $this->config['sy_withdraw_minmoney']>$money){
		
		
			$error   =   '单次提现金额必须达到'.$this->config['sy_withdraw_minmoney'].'元！';
			$errcode =   3;
			
		}else{
			//判断当日已提现次数
			$withNum = $this ->  select_num("member_withdraw",array('uid'=>$uid,'time'=>array('>=',strtotime(date('Ymd')))));
			
			if($withNum>=$this->config['sy_withdraw_num']){

				$error   = '今日提现次数已用完，请明天再试！';
				$errcode = 4;
			}else{

				$TableNameListTwo   =   array(1=>'member_statis',2=>'company_statis',3=>'lt_statis',4=>'px_train_statis');
				
				$memberInfo     =   $this   ->  select_once('member',array('uid'=>(int)$uid));
				
				$TableNameTwo   =   $TableNameListTwo[$usertype];
				$statis         =   $this ->  select_once($TableNameTwo,array('uid'=>(int)$uid));
				if($statis['packpay']>0){
					
					if($money>$statis['packpay']){
						
						$error    =   '提现金额不足！';
						$errcode  =   5;

					}else{

						//判断是否绑定微信
						if($memberInfo['wxid']!=''){
							//生成提现单
                            $upackpay   =   bcsub($statis['packpay'], $money, 2);
                            $ufreeze    =   bcadd($statis['freeze'], $money, 2);
                            $nid        =   $this->update_once($TableNameTwo,array('packpay'=>$upackpay,'freeze'=>$ufreeze),array('uid'=>(int)$uid));

							if($nid){
								//生成提现单 交由后台管理员审核
								$order  =   $this   ->  setWdOrder($uid,$usertype,$money,$memberInfo['wxid'],$realname);
								require_once('admin.model.php');
                                $adminM = new admin_model($this->db,$this->def);
								//超过后台设定审核金额
								if($this->config['sy_withdraw_money']>0 && $money>$this->config['sy_withdraw_money']){

									$error   =  '超过限定金额，'.$this->config['sy_withdraw_money'].'元，需等待管理员审核通过后打款！';
									$errcode =  6;
									
									$adminM->sendAdminMsg(array('first'=>'用户:'.$memberInfo['username'].',申请提现:'.$money.'元','type'=>4));
								}else{

									$wxpay = $this -> transfersWxPay($order);

									//修改提现单
									$this  ->  update_once('member_withdraw',array('order_state'=>$wxpay['orderState'],'order_remark'=>$wxpay['remark']),array('id'=>$order['id']));
                                    
									if($wxpay['orderState']!='1'){

										$error   =  '提现失败:'.$wxpay['remark'];
										$errcode =  7;

									}else{
                                       
										//提现成功消除冻结金额
									    $this ->  update_once($TableNameTwo,array('freeze' => $statis['freeze']),array('uid'=>(int)$uid));
								        $adminM->sendAdminMsg(array('first'=>'用户:'.$memberInfo['username'].',成功提现:'.$money.'元','type'=>4));
								        
								        $error   =  '提现成功，请关注微信账户提醒！';
								        $errcode =  1;
									}
								}
							}else{
								$error   = '提现申请失败！';
								$errcode =  2;
							}
							
						}else{
							$error = '还未绑定微信账户！';
							$errcode = 8;
						}
					}


				}else{
					$error   = '暂无可提现金额！';
					$errcode =  9;
				}
			}
		}
		
		return  array('errcode'=>$errcode,'msg'=>$error);
	}
	function setWdOrder($uid,$usertype,$money,$wxid,$realname){
		
		
		$dingdan              =   time().rand(10000,99999);
		
		$wData['order_id']    =   $dingdan;
		$wData['price']       =   $money;
		

		if($this->config['sy_withdraw_pound']){

			$poundPrice  =   round($money*$this->config['sy_withdraw_pound']/100,2);

		}else{
			$poundPrice  =   0;
		}
		$wData['real_name']   =   $realname;
		$wData['order_price'] =   $money-$poundPrice;
		$wData['pound_price'] =   $poundPrice;
		$wData['uid']         =   (int)$uid;
		$wData['usertype']    =   (int)$usertype;
		$wData['order_state'] =   0;
		$wData['wxid']        =   $wxid;

		$wData['time']        =   time();

		$nid  =   $this   ->  insert_into("member_withdraw",$wData);
		$wData['id'] = $nid;
		return $wData;

	}
	//调用微信打款接口 
	function transfersWxPay($order){
		
		//调用企业付款接口 直接提现 

								
		$wxRedPackArr['openid'] 			= $order['wxid'];//微信用户身份ID
		$wxRedPackArr['amount'] 			= $order['order_price']*100;//发放金额
		$wxRedPackArr['partner_trade_no'] 	= $order['order_id'];//当前红包订单ID 自定义生成
		$wxRedPackArr['spbill_create_ip']	= $this->config['sy_wxredpack_ip'];//服务器IP
		$wxRedPackArr['desc'] 				= '商家提现';//
		$wxRedPackArr['real_name'] 			= $order['real_name'];//
		include(LIB_PATH."ApiWxHb.class.php");
		$wxHb 	= new ApiWxHb();
		
		$wxHbMsg = $wxHb->sendPay($wxRedPackArr);
		
		if($wxHbMsg['result_code']=='SUCCESS'){

			$return['orderState'] = '1';

		}else{

			if($wxHbMsg['err_code_des']){
				$return['remark'] = $wxHbMsg['err_code_des'];
			}elseif($wxHbMsg['return_msg']){
				$return['remark'] = $wxHbMsg['return_msg'];
			}else{
				$return['remark'] = '微信接口API调用错误';
			}
			$return['orderState'] = '2';
		}
		
		return $return;
	}
	//仅限后台调用
	function delWithdrawOrder($id){
	
		$order = $this -> select_once("member_withdraw",array('id'=>intval($id)));

		if(!empty($order)){
			if($order['order_state']!='1'){//提现不成功 删除提现单需要返还冻结金额
				$TableNameList	=	array(1=>'member_statis',2=>'company_statis',3=>'lt_statis',4=>'px_train_statis');

				$Table 			= 	$TableNameList[$order['usertype']];

				//查询当前提现用户资金数据
				$Statis 		= 	$this -> select_once($Table,array('uid'=>$order['uid']));
				if($Statis['freeze']>$order['price']){
					$freeze 	= 	$Statis['freeze'] - $order['price'];
				}else{
					$freeze 	= 	0;
				}
				$packpay 		=	 $Statis['packpay']+$order['price'];

				$this -> update_once($Table,array('freeze'=>$freeze,'packpay'=>$packpay),array('uid'=>$order['uid']));
				
				//增加操作记录
				
				$this -> orderLog($order['price'],$order['uid'],'管理员删除提现，解冻提现金：'.$order['price'],$order['usertype']);
			}
			$this -> delete_all('member_withdraw',array('id'=>$order['id']));

			return true;
		}else{
		
			return false;
		}
	}
	//短信、微信通知
	function sendMsg($rewardInfo, $usertype, $status, $port=null){
		if($usertype=='1'){
			$uid	=	$rewardInfo['comid'];
			$smsg	=	'您发布的赏金职位招聘进度有新的提醒';
		}else{
			$uid	=	$rewardInfo['uid'];
			$smsg	=	'您申请的赏金职位申请进度有新的提醒';
		}
		
		if($uid){
			$memberInfo	=	$this->select_once('member', array('uid' => $uid),"`username`,`wxid`,`moblie`,`uid`,`usertype`");
			$statusMsg	=	$this->getStatusInfo(0,0,$status);
			
			if($memberInfo['moblie'] && checkMsgOpen($this -> config)){
				
				$moblie	=	$memberInfo['moblie'];
				
				$content=	$smsg.':'.$statusMsg['nowmsg'].',请在'.$this->config['sy_reward_hour'].'小时内登录'.$this->config['sy_webname'].'作出回应。';
				
				if($moblie!=""){
					require_once('notice.model.php');
					$notice	=	new notice_model($this->db, $this->def);
					$notice -> sendSMS(array('mobile' => $moblie, 'content' => $content, 'uid' => $memberInfo['uid'], 'name' => $memberInfo['username'], 'port' => $port));
				}
			}
			if($memberInfo['wxid']){

				include PLUS_PATH."user.cache.php";

				$jobInfo	=	$this->select_once('company_job', array('id' => $rewardInfo['jobid']), '`name`');
				$resume		=	$this->select_once('resume', array('uid' => $rewardInfo['uid']), '`name`,`edu`, `exp`');					
				$uname		=	mb_substr($resume['name'],0,1,'utf-8').'**';
				$edu		=	$userclass_name[$resume['edu']];
				$exp		=	$userclass_name[$resume['exp']];
				$rinfo		=	$uname.'-'.$edu.'学历-'.$exp.'工作经验';

				include(APP_PATH.'app/model/weixin.model.php');
				$wxM		=	new weixin_model($this->db,$this->def,array());

				$wxM->sendWxReward(array(
                    'uid'       =>  $memberInfo['uid'],
                    'usertype'  =>  $memberInfo['usertype'],
                    'wxid'      =>  $memberInfo['wxid'], 
                    'first'     =>  $smsg, 
                    'jobname'   =>  '赏金职位：'.$jobInfo['name'], 
                    'rinfo'     =>  $rinfo,
                    'statusinfo'=>  $statusMsg['nowmsg'],
                    'remark'    =>  '请在'.$this->config['sy_reward_hour'].'小时内登录'.$this->config['sy_webname'].'作出回应。'
                ));
			}
		}
	}
	/**
     * @desc   引用userinfo类，查询member列表信息   
     */
    private function getMemberList($whereData = array(), $data = array()) {
        require_once ('userinfo.model.php');
        $MemberM = new userinfo_model($this->db, $this->def);
        return  $MemberM -> getList($whereData , $data); 
    }
	/**
     * @desc   获取用户姓名、企业名称   
     */
    private function getUserList($where = array()) {
        require_once ('userinfo.model.php');
        $userinfoM = new userinfo_model($this->db, $this->def);
        return  $userinfoM -> getUserList($where); 
    }
	/**
     * @desc   引用system类，添加系统消息  
     */
    private function addSystem($data) {
		include_once('sysmsg.model.php');
        $sysmsgM  =  new sysmsg_model($this->db, $this->def);
        $sysmsgM -> addInfo($data);
    }
    /**
     * 查询提现数
     */
    public function getWithdrawNum($whereData){
        return $this->select_num('member_withdraw',$whereData);
    }
	/**
      * 查询全部信息
      * @param 表：member_withdraw
      * @param 功能说明：获取member_withdraw表里面所有提现信息
      * @param 引用字段：$whereData：条件  2:$data:查询字段
      *
     */
	 public function getList($whereData, $data = array()) {
        $data['field']	=	empty($data['field']) ? '*' : $data['field'];
        $List			=	$this -> select_all('member_withdraw', $whereData, $data['field']);
		if (!empty($List)) {
            /* 处理后台所需数据 */
			include (APP_PATH."/config/db.data.php");
			
			foreach ($List  as  $k  =>  $v){
				//状态
				$List[$k]['order_state_n']=strip_tags($arr_data['withdrawstate'][$v['order_state']]);
        		$List[$k]['time_n']		  =date('Y-m-d H:i:s',$v['time']);
			}
			
            if ($data['utype']=='admin') {
                $uids   =   array();
				foreach ($List as $v){
					if ($v['uid'] && !in_array($v['uid'],$uids)) {
						$uids[$v['uid']]		= 	$v['uid'];
					}
				}
				if($uids){
					//  查询用户名
					$mWhere['uid']      =   array('in', pylode(',', $uids));
					$mData['field']     =   '`uid`,`username`';
					$mList              =   $this -> getMemberList($mWhere, $mData);
					
					//  查询企业名称、姓名
					$uWhere['uid']      =   array('in', pylode(',', $uids));
					$UList              =   $this -> getUserList($uWhere);
				}
				foreach ($List  as  $k  =>  $v){
					//  分站did字段为空的数据
					if($v['did']    ==  ''){
						$List[$k][did]  =   '0';
					}
					//  用户名
					if (!empty($mList)) {
						foreach ($mList as $va){
							if ($v['uid']	==	$va['uid']) {
								$List[$k]['username']	=	$va['username'];
							}
						}
					}
					//	企业名称（姓名）
					if (!empty($UList)) {
						foreach ($UList as $va){
							if ($v['uid']	==	$va['uid'] ) {
								$List[$k]['comname']	=	$va['name'];
							}
						}
					}
				}
            } 
			
			
        }
        return $List;
    }
	/**
     * 获取member_withdraw      提现详情
     * $whereData       查询条件
     * $data            自定义处理数组
     */
	public function getInfo($id,$data=array()){
	    $field		=	empty($data['field']) ? '*' : $data['field'];
	    if (!empty($id)) {
	        $info	=	$this -> select_once('member_withdraw',array('id'=>intval($id)), $field);
	        if($info && is_array($info)){
	            return $info;
            }
	    } 
	}
	/**
     * @desc 确认提现
     * @param int/array     $id
     * @param array         $where
     * @param array         $data
     */
    function setPay($id) {
        if (!empty($id)) {
			$row					=	$this->getInfo($id);
			if($row['order_state']!='1'){
				$TableNameListTwo	=	array(1=>'member_statis',2=>'company_statis',3=>'lt_statis',4=>'px_train_statis');
			
				$TableNameTwo		=	$TableNameListTwo[$row['usertype']];

				$statis 			= $this->select_once($TableNameTwo,array('uid'=>intval($row['uid'])));

				$wxpay 				= $this->transfersWxPay($row);
				
				$this -> update_once('member_withdraw',array('order_state'=>$wxpay['orderState'],'order_remark'=>$wxpay['remark']), array('id'=>$row['id']));
				
				if($wxpay['orderState']=='1'){
					$TableNameList	=	array(1=>'member_statis',2=>'company_statis');
					
					$TableNameTwo	=	$TableNameList[$row[usertype]];
					
					$this -> update_once($TableNameTwo,array('freeze'=>$statis['freeze']-$row['price']), array('uid'=>$row['uid']));
					
					$this -> addSystem(array('uid' => $row['uid'],'usertype'=>2,'content' => '管理员操作：提现单号(ID:'.$row['order_id'].')确认成功'));
				
					return array('errcode'=>'9','msg'=>"管理员手动提现(ID:".$id.")确认成功！");
				}else{
					return array('errcode'=>'8','msg'=>'提现失败:'.$wxpay['remark']);
				}
			}else{
				return array('errcode'=>'8','msg'=>"提现单已成功提现，请勿重复提现！");
			}
        }
    }
	/**
      * @desc   删除提现记录
      * @desc   表：member_withdraw
      * @desc   功能说明：删除member_withdraw表里面记录
      * @param  引用字段：$id:删除记录
      *
     */
	public function delWithDraw($id){

		if(!empty($id)){
			$result						=	$this ->delWithdrawOrder($id);
		
			if($result){

				$return['msg']      	=  '提现记录(ID:'.$id.')删除成功';
				$return['errcode']  	=  '9';
			}else{

				$return['msg']      	=  '提现记录(ID:'.$id.')删除失败';
				$return['errcode']  	=  '8';
			}
		}else{

			$return['msg']      		=  '请选择要删除的记录';
			$return['errcode']  		=  '8';
		}
		return $return;  
	}
  
      /**
     * @desc 统计赏金职位  company_job_reward
     * @param int $where
    
     */
     public function getCompanyJobRewardNum($whereData){
       
       if(!empty($whereData)){
          
          $num	=	$this -> select_num('company_job_reward',$whereData);
          
        }

        return $num;
       
     }
	
       /**
     * @desc 统计赏金职位  company_job_share
     * @param int $where
    
     */
     public function getCompanyJobShareNum($whereData){
       
       if(!empty($whereData)){
          
          $num	=	$this -> select_num('company_job_share',$whereData);
          
        }

        return $num;
       
     }
  
	/**
	 *  @desc   获取缓存数据
	 */
	private function getClass($options){
	    
	    if (!empty($options)){
	        
	        include_once ('cache.model.php');
	        
	        $cacheM     =   new cache_model($this->db, $this->def);
	        
	        $cache      =   $cacheM -> GetCache($options);
	        
	        return $cache;
	    }
	}
    /**
     * @desc   商家转换积分
     * 
     * @param array $data
     */ 
    function saveChange($data = array()){

		$data['uid'] = (int)$data['uid'];
        if($data['uid']){
            $changeNum  =   $this  ->  select_num("company_pay",array(
                'com_id'        =>  $data['uid'],
                'pay_remark'    =>  array('like','转换'.$this->config['integral_pricename']),
                'pay_time'      =>  array('>=',strtotime(date("Y-m-d")))
            ));
            
			$data['changeprice'] = (int)$data['changeprice'];
			
			if($changeNum >= $this->config['paypack_max_recharge'] && $this->config['paypack_max_recharge']){
                $data['msg']="今日转换次数已达上限，请明日再来！";
                $data['error']=3;
            }elseif($this -> config['packprice_min_recharge'] > $data['changeprice']){
				$data['msg']="系统最低转换金额为：".$this -> config['packprice_min_recharge'].'元';
                $data['error']=2;
			
			}elseif($data['changeprice']>0){

				//查询当前用户信息 
				require_once('statis.model.php');
                $statisM  =  new statis_model($this->db,$this->def);

				$stInfo	=	$statisM -> getInfo($data['uid'],array('usertype' => (int)$data['usertype']));
				
				if($stInfo['packpay'] >= $data['changeprice']){
					

					$nid  =  $statisM->upInfo(array('packpay'=>array('-',$data['changeprice'])),array('uid'=>$data['uid'],'usertype'=>$data['usertype']));
				
				}else{
					$data['msg']="请正确填写转换金额！";
					$data['error']=3;
				}
                
                if($nid){
					//计算转换积分
					$data['changeintegral'] = ceil($data['changeprice']*$this->config['integral_proportion']);

					if($data['changeintegral']>=1){
						require_once('integral.model.php');
						$integralM      =   new integral_model($this->db,$this->def);
						$integralM      ->  company_invtal($data['uid'],$data['usertype'],$data['changeintegral'],true,"赏金转换".$this->config['integral_pricename'],true,2,'integral',2);
						$data['msg']    =   '转换成功';
						$data['url']    =   'index.php?c=changelist';
						$data['error']  =   1;
					}else{
						$data['msg']    =   '请填写正确的兑换金额！';
						$data['url']    =   'index.php?c=change';
						$data['error']  =   2;
					
					}
                    
                }else{
                    $data['msg']    =   '转换失败';
                    $data['url']    =   'index.php?c=change';
                    $data['error']  =   2;
                }
            }else{
			
				$data['msg']    =   '请正确填写转换金额';
				$data['error']  =   2;
			}
        }
        return $data;
    }
	
	/**
     * @desc    获取赏金投递数目
     */
	function getPackNum($WhereData = array(),$data=array()){
		
		$Packnum	=	$this -> select_num('company_job_rewardlist', $WhereData);
		
		return $Packnum;
	}
	/**
     * @desc    获取赏金投递详细信息
     */
	function getPackInfo($whereData,$data=array()){
		
		$field		=	empty($data['field']) ? '*' : $data['field'];
		
		$PackInfo 	=	$this -> select_once('company_job_rewardlist', $whereData, $field);
		
		if($PackInfo){
			
		    $job	=	$this -> select_once('company_job',array('uid'=>$whereData['comid'],'id'=>$PackInfo['jobid']),'`name`');
			
			$resume	=	$this -> select_once('resume',array('uid'=>$PackInfo['uid']),'`name`');
			
			$PackInfo['job_name']	=	$job['name'];
			
			$PackInfo['username']	=	$resume['name'];

            if($PackInfo['datetime']){

                $PackInfo['datetime_n']  =    date('Y-m-d H:i',$PackInfo['datetime']);
                
            }
		
		}
		
		return $PackInfo;
		
	}
    /**
   * 处理单个图片上传
   * @param file/需上传文件; dir/上传目录; type/上传图片类型; base/需上传base64; preview/pc预览即上传
   */
    private function upload($data = array('file'=>null,'dir'=>null,'type'=>null,'base'=>null,'preview'=>null)){
        require_once('upload.model.php');
        $UploadM  =   new upload_model($this->db,$this->def);  
       
        $upArr    =  array(
            'file'     =>  $data['file'],
            'dir'      =>  $data['dir'],
            'type'     =>  $data['type'],
            'base'     =>  $data['base'],
            'preview'  =>  $data['preview']
        );
        $return   =  $UploadM -> newUpload($upArr);
        
        return $return;
    }
}
?>