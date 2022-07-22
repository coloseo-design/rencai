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
class spview_model extends model{

	//获取企业信息列表
	private function getComList($whereData , $data = array()){

		require_once ('company.model.php');

		$CompanyM   =   new company_model($this->db, $this->def);

		return  $CompanyM   ->  getList($whereData , $data);
	}

	private function getClass($options)
    {
             
        include_once ('cache.model.php');
        
        $cacheM     =   new cache_model($this->db, $this->def);
        
        $cache      =   $cacheM -> GetCache($options);
        
        return $cache;
    }

	private function getJobList($whereData , $data = array()){

		require_once ('job.model.php');

		$jobM   =   new job_model($this->db, $this->def);

		return  $jobM   ->  getList($whereData , $data);
	}

	//获取单个预约信息
	function getSubinfo($whereData=array(),$data=array()){

		if (!empty($whereData)) {


            $select =   $data['field'] ? $data['field'] : '*';


            $Info   =   $this->select_once('spview_subscribe', $whereData, $select);

			if(!empty($Info)){
				
			    if (!empty($data['job']) && !empty($Info['jobid'])){
			        
			        $job	=	$this->select_once('company_job',array('id'=>$Info['jobid']), '`name`,`com_name`');
			        
			        $Info['jobname']	=	$job['name'];
			        $Info['com_name']	=	$job['com_name'];
			    }
			    if (!empty($data['resume']) && !empty($Info['uid'])){
			        
			        $resume  =  $this->select_once('resume',array('uid'=>$Info['uid']), '`name`,`sex`,`photo`,`def_job`');
			        
			        $Info['uname']    =  $resume['name'];
			        //$Info['eid']      =  $resume['def_job'];
			        
			        $icon             =  $resume['sex'] == 1 ? $this->config['sy_member_icon'] : $this->config['sy_member_iconv'];
			        $Info['photo_n']  =  checkpic($resume['photo'], $icon);
			    }
			}
            return $Info;
        }
	}
	
	//获取多个预约信息
	function getSublist($whereData=array(),$data=array()){

		if (!empty($whereData)) {
			
            $select =   $data['field'] ? $data['field'] : '*';
			
			$List   =   $this->select_all('spview_subscribe', $whereData, $select);
			
            if(!empty($List)){
				foreach($List as $key=>$val){

					$jids[]		=	$val['jobid'];
					$uids[]		=	$val['uid'];
					$sids[]		=	$val['sid'];
					$List[$key]['wapcom_url'] = Url('wap',array('c'=>'company','a'=>'show','id'=>$val['comid']));
                    $List[$key]['wapjob_url'] = Url('wap',array('c'=>'job','a'=>'comapply','id'=>$val['jobid']));
				}
				if (!empty($data['room'])){
				    
				    $time     =  time();
				    $spviews  =  $this->select_all('spview',array('id'=>array('in',pylode(',',$sids))));
				}
                
				if (!empty($data['job'])){
				    
				    $jobs	=	$this->select_all('company_job',array('id'=>array('in',pylode(',',$jids))));
				}
				
				if(!empty($data['resume'])){
					
					require_once ('resume.model.php');
					$resumeM    =   new resume_model($this->db, $this->def);
				
					$resumeList	=	$resumeM->getResumeList(array('uid' =>array('in', pylode(',', $uids))));
				}
				
				foreach($List as $key=>$val){
					
					$List[$key]['ctime_n']	=	date("Y-m-d H:i", $val['ctime']);
					
					if($val['status'] == '2'){
						$List[$key]['status_n']	=	"已面试";
					}else if($val['status'] == '1'){
						$List[$key]['status_n']	=	"正在面试";
					}else{
						$List[$key]['status_n']	=	"未面试";
					}
					if (!empty($spviews)){
					    
					    $List[$key]['canroom']	=	0;
					    
					    foreach ($spviews as $sv) {
					        
					        if($sv['id'] == $val['sid']){
					            
					            $List[$key]['sdate_n']	=	date("Y.m.d H:i", $sv['starttime']);
					            // 从面试前半小时开始，可以进入面试间
					            if($val['status'] !=2 && $sv['roomstatus']==0 && (($sv['starttime'] > $time && $sv['starttime'] < ($time + 1800)) || $sv['starttime'] < $time)){
					                
					                $List[$key]['canroom']	=	1;
					            }
					        }
					    }
					}
					
					if (!empty($jobs)){
					    
					    foreach($jobs as $k=>$v){
					        
					        if($v['id']==$val['jobid']){
					            
					            $List[$key]['jobname']	=	$v['name'];
					            
					            $List[$key]['comname']	=	$v['com_name'];
					        }
					    }
					}
					if (!empty($resumeList)){
					    
					    foreach($resumeList as $rk => $rv){
					        if($val['uid'] == $rv['uid']){
					            $List[$key]['name']	=	$rv['name_n'];
					            $List[$key]['age']	=	$rv['age_n'];
					            $List[$key]['sex']	=	$rv['sex_n'];
					            $List[$key]['exp']	=	$rv['exp_n'];
					            $List[$key]['edu']	=	$rv['edu_n'];
					            $List[$key]['eid']	=	$rv['def_job'];
					            $List[$key]['photo']=	$rv['photo'];
					        }
					    }
					}
				}
			}
            return $List;
        }
	}

	//预约数量
	function getSubNum($whereData=array(),$data=array()){

		if (!empty($whereData)) {
            
            $Info   =   $this->select_num('spview_subscribe', $whereData);

            return $Info;
        }
	}

	function updateSubcribe($whereData, $data = array()){
        
        if (!empty($whereData)){
            
            $nid  =  $this -> update_once('spview_subscribe', $data, $whereData);
        }
    }
	//预定
	function addSubcribe($data=array()){
		
		$return = 	array();
		$dataV	=	array();
		if(!empty($data) && $data['sid']){
			
			if($data['uid']){
				
				if($data['usertype']=='1'){

					$spview_sub     =   $this -> select_once('spview_subscribe', array('uid'=>$data['uid'],'sid'=>$data['sid']));

					if(!empty($spview_sub)){

						$return['errcode'] 	= 7;
						$return['msg'] 		= '您已经预约了该场视频面试';
						return $return;
					}
					//判断简历是否符合投递和面试条件，符合的预约成功并投递简历
					require_once ('job.model.php');
    
			        $jobM = new job_model($this->db, $this->def);
			        
			        $adata				=	array(
						'uid'			=>	$data['uid'],
						'usertype'		=>	$data['usertype'],
						'did'			=>	$data['did'],
						'job_id'		=>	$data['jobid'],
						'spviewid'		=>	$data['sid'],
						'eid'			=>	$data['eid'],
						'port'			=>	$data['port']
					);

			        $applyReturn = $jobM -> applyJob($adata, 'spview');


			        if($applyReturn['errorcode']==9){//投递成功，执行预约

			        	$dataV['sid'] 	= 	$data['sid'];
						$dataV['uid'] 	= 	$data['uid'];
						$dataV['did']	=	$data['did'];
						$dataV['eid']	=	$data['eid'];
						$dataV['jobid']	=	$data['jobid'];
						$dataV['comid']	=	$data['comid'];
						$dataV['ctime'] = 	time();
						
						$nid	=	$this -> insert_into('spview_subscribe', $dataV);
						
						if($nid){

							$this->addSubcribeMsg($data['sid'],$data['uid'],$data['jobid'],$data['eid'],$nid);

							$return['errcode'] 	= 9;
							$return['msg'] 		= '预约成功';

							$member	=	$this -> select_once('member', array('uid'=>$data['uid']),'`wxid`,`wxopenid`,`unionid`');

							if(empty($member['wxid']) && empty($member['wxopenid']) && empty($member['unionid'])){

								$return['wxshow']	=	1;
							}

						}else{

							$return['errcode'] 	= 7;
							$return['msg'] 		= '预约失败，请重试';
				        }
			        }else{

			        	$return['errcode'] 	= $applyReturn['errorcode'];
						$return['msg'] 		= $applyReturn['msg'];
			        }
				}else{

					$return['errcode'] 	= 7;
					$return['msg'] 		= '只有个人用户才能预约';
				}
			}else{

				$return['showlogin']= 1;
				$return['errcode'] 	= 7;
				$return['msg'] 		= '请先登录';
			}
		}else{

			$return['errcode'] 	= 7;
			$return['msg'] 		= '数据错误';
		}

		return $return;
	}
	/**
	 * 添加视频面试开始通知待发送记录
	 */
	function addSubcribeMsg($sid = '',$uid = '',$jobid='',$eid='',$subid=''){
		
	    if($sid != ''){
	        
			$spview	=	$this -> select_once('spview', array('id'=>$sid),'`id`,`uid`,`starttime`,`did`');
			
			if(!empty($spview)){

			    $stime		=  $spview['starttime'] - 86400;//第一次提醒 提前一天提醒

			    $company	=	$this -> select_once('company', array('uid'=>$spview['uid']),'`uid`,`name`');
			    
			    if (!empty($uid)){
			        // 已登录用户记录
			        $member  =  $this->select_once('member',array('uid'=>$uid),'`uid`,`username`,`moblie`,`wxid`');
			        
			    }
			    
			    $msgData  	=  	array(
			        'sid'	   	=>  $spview['id'],
			        'subid'	   	=>  $subid,
			        'did'	   	=>  $spview['did'],
			        'comid'		=>	$spview['uid'],
			        'eid'		=>	$eid,
			        'jobid'		=>	$jobid,
			        'stime'	   	=>  $stime,
			        'comname'  	=>  $company['name'],
			        'sptime'  	=>  $spview['starttime']
			    );
			    
			    if (!empty($member)){
		            // 有这些参数，可用来发送短信通知
		            $msgData['uid']       =  $member['uid'];
		            $msgData['username']  =  $member['username'];
		            $msgData['moblie']    =  $member['moblie'];

		        }
			    
		        if($stime>time()){

		        	$msgData['type']	=	1;
		        	$this -> insert_into('spview_subscribe_msg', $msgData);

		        }
			    
			    
			    $msgData1 = $msgData;

			    $msgData1['stime']	=	$spview['starttime'] - 3600;//第二次提醒 提前一小时提醒
			    $msgData1['type']	=	2;
			    $this -> insert_into('spview_subscribe_msg', $msgData1);

			}
		}
	}
	/**
	 * 视频面试预约发送微信提醒,开始前一小时同时发送短信给企业
	 * 后台计划任务文件名：spview_sub.php; url执行方法：index.php?m=ajax&c=sendSpviewSub
	 */
	function sendSubmsg(){
		
		$time 	  =		time();

		$begined  =		$this->select_once('spview_subscribe_msg', array('status'=>1,'sptime'=>array('<',$time)));

	    if (!empty($begined)){
	        
	        $this->delete_all('spview_subscribe_msg', array('status'=>1,'sptime'=>array('<',$time)), '');
	    }

	    $list	=	$this -> select_all('spview_subscribe_msg', array('status'=>0,'stime'	=> array('<',time())));
	    
	    $uids	=	array();
	    $ids	=	array();
	    $jids	=	array();
	    $sids	=	array();
	    $comids	=	array();
	    foreach($list as $val){
	        
	        $ids[]	=	$val['id'];

	        if($val['uid']){
	        	$uids[] = $val['uid'];
	        }
			if($val['jobid']){
	        	$jids[] = $val['jobid'];
	        }

	        if($val['sptime']-$val['stime']<=3600){

	        	if(!in_array($val['sid'],$sids)){

	        		$sids[]		=	$val['sid'];
	        		$comids[]	=	$val['comid'];
	        	}

			}
	    }

	    if(!empty($list)){
	        
	        
	    	$member		=	$this -> select_all('member', array('uid'=>array('in', pylode(',',$uids))),'`uid`,`wxid`,`usertype`');

	    	$comarr		=	array();

	    	if(!empty($comids)){

	    		$coms		=	$this -> select_all('member', array('uid'=>array('in', pylode(',',$comids))),'`uid`,`moblie`,`usertype`');

		    	foreach($coms as $ck=>$cv){

		    		$comarr[$cv['uid']]	=	$cv['moblie'];
		    	
		    	}
	    	}
	    	

	    	$memWx		=	array();

	    	foreach($member as $mk=>$mv){

	    		$memWx[$mv['uid']]['wxid'] = $mv['wxid'];

	    		$memWx[$mv['uid']]['usertype'] = $mv['usertype'];
	    	}

			$jobList		=	$this->select_all('company_job', array('id' => array('in', pylode(',', $jids))), '`id`,`name`');
			$jobs	=	array();
			foreach($jobList as $jk => $jv){
				$jobs[$jv['id']]['jobname']	=	$jv['name'];
			}

	        require_once 'weixin.model.php';
	        
	        $weixinM    =   new weixin_model($this->db, $this->def);

	        require_once 'notice.model.php';
	        
	        $noticeM    =   new notice_model($this->db, $this->def);
	        
	        $sendData	=	array();
	        
	        foreach($list as $key=>$val){
	            
	            $sendData['title']	=	"您预约的视频面试即将开始！";
	            $sendData['name']	=	$val['comname'];

	            $sendData['jobname']=	$jobs[$val['jobid']]['jobname'];

	            $sendData['sptime']	=	date("Y年m月d日 H:i", $val['sptime']);

	            $sendData['sptype']	=	"视频面试";

	            $sendData['url']	=	Url('wap', array('c'=>'spview', 'a' => 'show', 'id' => $val['sid'], 'fr'=>'wxtz'));
	            
	        	$sendData['wxid']	=	$memWx[$val['uid']]['wxid'];

	        	$sendData['usertype']	=	$memWx[$val['uid']]['usertype'];

	        	$sendData['uid']	=	$val['uid'];

	        	$weixinM->sendWxSpview($sendData);

	        	//提前一小时短信通知企业
	        	if(in_array($val['sid'],$sids)){

	        		$skeys = array_keys($sids, $val['sid']);

					if(!empty($skeys)){
						foreach ($skeys as $skey) {
						  unset($sids[$skey]);
						}
					}

		        	$data		=	array(
						'uid'		=>	$val['comid'],
			            'usertype'	=>	2,
			            'moblie'	=>	$comarr[$val['comid']],
						'type'		=>	'spmsks',
						'date'		=>	date('Y-m-d H:i:s',$val['sptime']),
						'port'		=>	'1'
					);
		            $noticeM->sendSMSType($data);

		        }
	        	
	            
	        }
	        
	        $this->update_once('spview_subscribe_msg',array('status'=>1),array('id'=>array('in',pylode(',', $ids))));
	        
	    }
	}
	/**
	 * 视频面试关闭房间计划任务(已经开始的且不是今天的面试房间)
	 * 后台计划任务文件名：spview_close.php; url执行方法：index.php?m=ajax&c=closeSpview
	 */
	function closeRoom(){
		
		$time 		= time();

		$daybegin 	= strtotime('today');

        $spview 	= $this->select_once('spview', array('roomstatus'=>0,'starttime'=>array('<',$daybegin)));

        if(!empty($spview)){
            // 关闭面试房间，将正在面试中的，设为已面试，未面试的不做改变
            $this	->	updateSubcribe(array('roomstatus'=>0,'status'=>1,'starttime'=>array('<',$daybegin)),array('status'=>2));

        	$this 	-> 	update_once('spview',array('roomstatus'=>1),array('roomstatus'=>0,'starttime'=>array('<',$daybegin)));
        }
	}
	
	function getNum($Where=array()){
        return $this->select_num('spview', $Where);
    }	

    public function searchList($data){

    	$where 	= 	"";
        $page	=	$data['page'];
        $limit	=	$data['limit'] ? $data['limit'] : 20;
        $time	=	time();
        
        
        $where = "a.`status` = 1 AND a.`roomstatus` = 0";
        $pagewhere = "";$joinwhere = "";

		
        if($data['starttime']){

            if($data['starttime']=="today"){

                $stime = strtotime(date("Y-m-d"));

                $etime = $stime+86400;

                $where  .= " AND a.`starttime` >'".$stime."' AND a.`starttime` <'".$etime."'";

            }else if($data['starttime']=="endsub"){//预约中

                $subtime = time() - ($this->config['sy_spview_yytime']* 3600);

                $where  .= " AND a.`starttime` >'".$subtime."'";

            }

        }
        
        //企业表联查
        $comwhere = " AND b.`r_status` = 1";

        if($data['keyword']){
            
            $comwhere  .= " AND b.`name` LIKE '%".$data['keyword']."%'";
            
        }

        if($data['mun']){
            
            $comwhere  .= " AND b.`mun` = '".$data['mun']."'";
            
        }

        if($data['hy']){
            
            $comwhere  .= " AND b.`hy` = '".$data['hy']."'";
            
        }
        if($data['pr']){
            
            $comwhere  .= " AND b.`pr` = '".$data['pr']."'";
            
        }
        if($data['provinceid']){
            
            $comwhere  .= " AND b.`provinceid` = '".$data['provinceid']."'";
            
        }
        if($data['cityid']){
            
            $comwhere  .= " AND b.`cityid` = '".$data['cityid']."'";
            
        }
        if($data['three_cityid']){
            
            $comwhere  .= " AND b.`three_cityid` = '".$data['three_cityid']."'";
            
        }
        $pagewhere .=" ,`".$this->def."company`  b ";
        $joinwhere .= " a.`uid`=b.`uid` ".$comwhere;
		

		if($page){//分页
            $pagenav	=	($page-1)*$limit;
            $splimit=" limit $pagenav,$limit";
        }else{
            $splimit=" limit $limit";
        }

        $select = "*";
        $time = time();
        if($data['order']=="1"){
            // 条件排序，优先未开始，并按id倒序
            
            $order = " ORDER BY";
            $order .= " CASE";
            $order .= " WHEN a.`starttime`>'".$time."' THEN 1";
            $order .= " WHEN a.`starttime`<'".$time."' THEN 2";
            $order .= " END,a.`id`";
            $sort   =   " DESC";
        }else{
            //排序字段
            if($data['order']){
                $order = " ORDER BY a.`".$data['order']."`  ";
            }else{
                $order = " ORDER BY a.`id` ";
            }
            //排序规则 默认为倒序
            if($data['sort']){
                $sort = $data['sort'];
            }else{
                $sort = " DESC";
            }
        }

        $where.=$order.$sort.$splimit;

        if($pagewhere!=""){

            $sql = "select ".$select." from `".$this->def."spview` a ".$pagewhere." where ".$joinwhere." and ".$where;

        }else{
            $sql = "select ".$select." from `".$this->def."spview` a where ".$where;
        }
        $return = $this->DB_query_all($sql,"all");

        return $return;
    }

	public function getList($whereData=array(),$data=array())
	{
		
        $List  	  =  array();

        $time	  =	 time();

        $cache    =  $this -> getClass(array('user'));

        $select   =  $data['field'] ? $data['field'] : '*';

        if($data['search']){

			$List	=	$this	->	searchList($data['search']);

		}else{

        	$List   =  $this -> select_all('spview',$whereData, $select);

        }

        $jobidarr = array();

        foreach ($List as $lk => $lv){

        	$jids = array();

            if($lv['uid']){
                $uids[]     =   $lv['uid'];
            }

            if($lv['id']){
                $ids[]	=	$lv['id'];
            }

            if($lv['jobid']){
                $jobid[$lv['id']]	=	$jids	=	@explode(',',$lv['jobid']);
            }

            $jobidarr = array_unique(array_merge($jobidarr, $jids));

            if($lv['exp']){
                $exp[$lv['id']]	=	@explode(',',$lv['exp']);
            }

            if($lv['edu']){
                $edu[$lv['id']]	=	@explode(',',$lv['edu']);
            }

            if($lv['sex']){
                $sex[$lv['id']]	=	@explode(',',$lv['sex']);
            }
        }

        $company	=	$this -> getComList(array('uid' => array('in',pylode(',',$uids))),array('field'=>'`uid`,`name`,`welfare`,`hy`,`mun`,`pr`,`logo`,`logo_status`','logo'=>1));

        if(!empty($jobidarr)){

        	$jobwhere	=	array(
        		'id' 		=>	array('in',pylode(',',$jobidarr)),
        		'r_status'	=>	1,
        		'status'	=>	0,
        		'state'		=>	1,
        		'orderby'	=>	'id,desc'
        	);

        	$job		=	$this -> getJobList($jobwhere,array('field'=>'`id`,`uid`,`name`,`minsalary`,`maxsalary`'));
        }
        	
        $all		=	$this -> select_all('spview_subscribe',array('sid'=>array('in',pylode(',', $ids)),'groupby'=>'sid'),'sid,count(*) as num');	

        foreach ($job['list'] as $key => $value) {
            foreach ($jobid as $kk => $vv) {
                if(in_array($value['id'],$jobid[$kk])){
                    $jobname[$kk][] = $value['name'];
                    $spjobs[$kk][] = $value;
                }
            }
        }

        foreach ($jobname as $k => $v) {
        	
            $jobs[$k] = @implode(',', $v);
            
            if (count($v) > 2){
            	foreach ($v as $kk => $vv) {
            		if ($kk < 2){
            			$jjobs[$k][]	=	$vv;
            		}
            	}
            }else{
            	$jjobs[$k]	=	$v;
            }
        }
         
        if ($data['utype'] == 'admin'){
            
            foreach ($exp as $key => $value) {
                foreach ($value as $v) {
                    $expname[$key][] = $cache['userclass_name'][$v];
                }
            }
            
            foreach ($expname as $k => $v) {
                $exps[$k] = @implode(',', $v);
            }
            
            foreach ($edu as $key => $value) {
                foreach ($value as $v) {
                    $eduname[$key][] = $cache['userclass_name'][$v];
                }
            }
            
            foreach ($eduname as $k => $v) {
                $edus[$k] = @implode(',', $v);
            }
            
            foreach ($sex as $key => $value) {
                foreach ($value as $v) {
                    $sexname[$key][] = $cache['user_sex'][$v];
                }
            }
            
            foreach ($sexname as $k => $v) {
                $sexs[$k] = @implode(',', $v);
            }
            foreach ($List  as  $k  =>  $v) {
                
                foreach ($exps as $ek => $ev) {
                    if($v['id']==$ek){
                        $List[$k]['expname'] = $ev;
                    }
                }
                foreach ($edus as $ek => $ev) {
                    if($v['id']==$ek){
                        $List[$k]['eduname'] = $ev;
                    }
                }
                foreach ($sexs as $sk => $sv) {
                    if($v['id']==$sk){
                        $List[$k]['sexname'] = $sv;
                    }
                }
                if (!empty($v['minage'])){
                    if (!empty($v['maxage'])){
                        $List[$k]['agename']  =  $v['minage'] .'-'. $v['maxage'].'岁';
                    }else{
                        $List[$k]['agename']  =  $v['minage'] .'岁以上';
                    }
                }else{
                    if (!empty($v['maxage'])){
                        $List[$k]['agename']  =  $v['maxage'].'岁以下';
                    }
                }
            }
        }

        foreach ($List  as  $k  =>  $v) {
        	
        	if (empty($v['remark'])){
        		
        		foreach ($jjobs as $jjk => $jjv) {
        			if ($v['id'] == $jjk){
        				
        				$aT	=	date('Y/m/d', $v['starttime']);
        				$sT	=	date('H', $v['starttime']) > '12' ? '下午' : '上午';
        				
        				$List[$k]['remark']	=	@implode('，', $jjv).'等职位 -  '.$aT.' '.$sT.' 面试专场';
        			}
        		}
        	}

        	$List[$k]['subnum']	=	0;

        	$List[$k]['sqjobs'] = count($spjobs[$v['id']]) ? array_slice($spjobs[$v['id']],0,2) : array();

        	foreach ($company['list'] as $ck => $cv) {

        		if($v['uid']==$cv['uid']){

        			$List[$k]['name_n'] 	= $cv['name'];
        			$List[$k]['welfarearr'] = $cv['welfare'] ? @explode(',',$cv['welfare']) : array();
        			$List[$k]['hy_n'] 		= $cv['hy_n'] ? $cv['hy_n'] : '';
        			$List[$k]['pr_n'] 		= $cv['pr_n'] ? $cv['pr_n'] : '';
        			$List[$k]['mun_n'] 		= $cv['mun_n'] ? $cv['mun_n'] : '';
        			$List[$k]['logo'] 		= $cv['logo'] ? $cv['logo'] : '';
        		}
        	}

        	foreach($all as $val){
				if($v['id'] == $val['sid']){
                    $List[$k]['subnum']	=	$val['num'];
                }
            }

        	foreach ($jobs as $kk => $vv) {
        		if($v['id']==$kk){
        			$List[$k]['jobname'] = $vv;
        		}
        	}

        	if($v['status']==0){

        		$List[$k]['status_n']	=	'未审核';

        	}else if($v['status']==1){

        		$List[$k]['status_n']	=	'已审核';

        	}else if($v['status']==2){

        		$List[$k]['status_n']	=	'审核未通过';

        	}

        	$yytime	=	$this->config['sy_spview_yytime'] * 3600;

            if($v["starttime"] && ($v["starttime"] - $yytime) > $time){

                $List[$k]["s_status"] = 1;//未开始

            }else{

            	if ($v["roomstatus"]  == 1){

                    $List[$k]["s_status"] = 3;//已结束

                }else{

                    $List[$k]["s_status"] = 2;//已开始

                }
                
            }

        	$List[$k]['sdate_n'] = date('Y.m.d H:i',$v['starttime']);
        	$List[$k]['ctime_n'] = date('Y-m-d',$v['ctime']);
        }

        return $List;
    }

    public function getInfo($whereData=array(),$data=array())
	{

        if (!empty($whereData)) {

            $select =   $data['field'] ? $data['field'] : '*';

            $Info   =   $this->select_once('spview', $whereData, $select);

            if ($Info && is_array($Info)) {
                
                include_once('cache.model.php');
    	        $cacheM		=	new cache_model($this->db, $this->def);
            	$CacheArr   =   $cacheM->GetCache(array('job','user'));

                if (!empty($Info['starttime'])){
                    $Info['sdate_n']  =   date('Y-m-d H:i',$Info['starttime']);
                }


		        if($Info['minage'] && $Info['maxage']){

		        	$Info['age_n'] = $Info['minage'].'-'.$Info['maxage'].'岁';

		        }else if($Info['minage']){

		        	$Info['age_n'] = $Info['minage'].'岁以上';

		        }else if($Info['maxage']){

		        	$Info['age_n'] = $Info['maxage'].'岁以下';

		        }

                if (!empty($Info['exp'])){

                    $Info['exp_n']		= 	@explode(',', $Info['exp']);

                    $exp_req_varr 		= 	@explode(',',$Info['exp']);

		            $exp_req_name 		= 	array();

		            foreach($exp_req_varr as $expk=>$expv){

		            	$exp_req_name[]	= 	$CacheArr['userclass_name'][$expv];

		            }

		            $Info['exp_req_n'] 	= 	@implode(',',$exp_req_name);
                }	
                if (!empty($Info['edu'])){

                    $Info['edu_n']    	=   @explode(',',$Info['edu']);
                    $edu_req_varr 		= 	@explode(',',$Info['edu']);

		            $edu_req_name 		= 	array();

		            foreach($edu_req_varr as $eduk=>$eduv){

		            	$edu_req_name[]	= 	$CacheArr['userclass_name'][$eduv];

		            }

		            $Info['edu_req_n'] 	= 	@implode(',',$edu_req_name);

                }

                if (!empty($Info['jobid'])){

                    $Info['jobid_n']  	=   @explode(',', $Info['jobid']);

                    $jobwhere   		=   array(
                    	'id'		=>	array('in',$Info['jobid']),
			            'state'     =>  1,
			            'status'    =>  0,
			            'r_status'  =>  1
			        );

			        if($data['uid']){

			        	$jobwhere['uid']=	$data['uid'];
			        
			        }

                    $jobs   			=   $this->select_all('company_job', $jobwhere,'`id`,`name`');

                    foreach($jobs as $jk=>$jv){
                    	
                    	$jobnameArr[] 	= 	$jv['name'];
                    	
                    	if ($jk < 2){
                    		$jobNameA[]	=	$jv['name'];
                    	} 
                    
                    }

                    $Info['job_n']		=	@implode('，', $jobnameArr);
                }
                
                if (empty($Info['remark'])){
                	$aT	=	date('Y/m/d', $Info['starttime']);
                	$sT	=	date('H', $Info['starttime']) > '12' ? '下午' : '上午';
                	$Info['remark']	=	@implode('，', $jobNameA).'等职位 - '.$aT.' '.$sT.' 面试专场';
                }

                if (!empty($Info['other'])){
                    $Info['other_n']  =   @explode(',', $Info['other']);
                    
                    if (isset($data['wxapp'])){
                        // 处理简历完善要求直接显示文字
                        $arr  =  array(1=>'工作经历',2=>'教育经历',3=>'项目经历');
                        
                        foreach ($Info['other_n'] as $v){
                            $other[]  =  $arr[$v];
                        }
                        $Info['other_w']  =  implode(',', $other);
                    }
                }
            }
            return $Info;
        }
    }
    

    //获取面试间内排队列表/正在面试中个人等信息,
    public function getLineData($data=array(), $type = ''){

    	$sid			=	$data['sid'];
		$nowuid			=	$data['nowuid'];

    	$uid			=	$data['uid'];

    	$res['resume']	=	array();
    	$res['expects']	=	array();
    	$res['subnum']	=	0;
    	$res['linenum']	=	0;
    	$res['msnum']	=	0;

    	if($sid){

			$spview		=	$this->getInfo(array('id'=>$sid,'uid'=>$uid));

			if(empty($spview)){

				$res['errorcode']	=	8;
				$res['msg']			=	'该面试间不存在';

			}else if($spview['status']!=1){

				$res['errorcode']	=	8;
				$res['msg']			=	'该面试间尚未通过审核';

			}else if($spview['roomstatus']==1){
			    
			    $res['errorcode']	=	8;
			    $res['msg']			=	'该面试间已关闭';
			    
			}else{
 
				$nowwhere 	=	array(
					'sid'		=>	$sid,
					'status'	=>	1,
				);
				$subInfo	=	$this->getSubinfo($nowwhere);

				if($nowuid){//切换选择面试人选

					$this->viewUser(array('sid'=>$sid,'nowuid'=>$nowuid));	
				}else{
				    if($subInfo){
				        
				        $nowuid = $subInfo['uid'];
				    }
				}
				
				$res['nowuid']	=	$nowuid ? $nowuid : '';

				//排队列表
				$subwhere 	=	array(
					'sid'		=>	$sid,
					'status'	=>	array('<>',2),
					'rtime'		=>	array('>',0),
					'orderby'	=>	'rtime,asc',
				    'limit'     =>  10
				);
				
				$sublist	=	$this->getSublist($subwhere, array('field'=>'`uid`,`jobid`','job'=>1));

				include_once('resume.model.php');
    	    	$resumeM	=	new resume_model($this->db, $this->def);
				//等待面试列表
				if(!empty($sublist)){

					$useruids 	=	array();
					
					foreach($sublist as $k=>$v){
					
						$useruids[]  =	$v['uid'];
					
					}
                    
					if(!empty($useruids)){

						$selects 	=	'`uid`,`name`,`photo`,`phototype`,`photo_status`,`sex`,`def_job`';
						$resumes 	= 	$resumeM -> getResumeList(array('uid' => array('in',pylode(',',$useruids))),array('field'=>$selects));
						// 按照预约顺序处理待面试列表
						$list       =   array();
						foreach($sublist as $sk=>$sv){
						    foreach($resumes as $rv){
						        if($rv['uid'] == $sv['uid']){
						            $list[$sk]['eid']      =  !empty($sv['eid']) ? $sv['eid'] : $rv['def_job'];
						            $list[$sk]['uid']      =  $sv['uid'];
						            $list[$sk]['jobname']  =  $sv['jobname'];
						            $list[$sk]['jobid']	   =  $sv['jobid'];
						            $list[$sk]['uname']	   =  $rv['username_n'];
						            $list[$sk]['photo_n']  =  $rv['photo'];
						        }
						    }
						}
						$res['expects']  =	$list;
					}
				}
				//正在面试用户
				if($nowuid && $type == ''){

					$subInfoNow		=	$this->getSubinfo(array('uid'=>$nowuid,'sid'=>$sid));

					if($subInfoNow['eid']){

						$eid 		=	$subInfoNow['eid'];
					
					}else{

						$expect     =	$this -> select_once('resume_expect',array('uid' => $nowuid,'defaults'=>1), '`id`');
						$eid 		=	$expect['id'];
					}
					
					
					$resume 		=	$resumeM -> getInfoByEid(array('uid'=>$uid,'eid'=>$eid,'usertype'=>2));

					$res['resume']  =	$resume;
				}

				$res['subnum'] 		=	$this->getSubNum(array('sid'=>$sid));

				$res['linenum'] 	= 	$this->getSubNum(array('sid'=>$sid,'status'=>0,'rtime'=>array('>',0)));

				$res['msnum'] 		= 	$this->getSubNum(array('sid'=>$sid,'status'=>2));
                
				$res['jobid']       =   $spview['jobid'];
				
				$res['remark']      =   !empty($subInfo['content']) ? $subInfo['content'] : '';
				
				$res['errorcode']	=	9;
				$res['msg']         =   '';
			}

		}else{
			$res['errorcode']	=	8;
			$res['msg']			=	'参数错误';
		}

		return $res;
    }

    //面试某人
    public function viewUser($data=array()){

    	$sid 	= $data['sid'];
    	$nowuid = $data['nowuid'];

    	//排队列表
		$subwhere 	=	array(
			'sid'		=>	$sid,
			'uid'		=>	$nowuid,
			'status'	=>	0,
		);
		
		$subInfo	=	$this->getSubinfo($subwhere);
        // 正在面试中的，改成面试结束
		$this->updateSubcribe(array('sid'=>$sid,'status'=>1),array('status'=>2));

		if($subInfo){

			$this->updateSubcribe(array('sid'=>$sid,'uid'=>$nowuid),array('status'=>1));
		}
    }
		
	// 预约面试表，企业备注人才信息
	public function setContent($data = array()){
		if($data['content']==''){
			$return['msg']      =  '备注内容不能为空！';
			$return['errcode']  =  8;
		}
		$id	=   $this ->  update_once('spview_subscribe',array('content'=>$data['content']),array('id'=>intval($data['id']),'comid'=>$data['comid']));
		if ($id){
			$return['msg']      =  '备注成功！';
			$return['errcode']  =  '9';
		}else{
			$return['msg']      =  '备注失败！';
			$return['errcode']  =  '8';
		}
	    return $return;
	}
	public function setSpContent($data = array()){
		if($data['content']==''){
			$return['msg']      =  '备注内容不能为空！';
			$return['errcode']  =  8;
		}
		
		$id	=   $this ->  update_once('spview_log',array('remark'=>$data['content']),array('id'=>intval($data['id']),'comid'=>$data['comid']));
		if ($id){
			$return['msg']      =  '备注成功！';
			$return['errcode']  =  '9';
		}else{
			$return['msg']      =  '备注失败！';
			$return['errcode']  =  '8';
		}
	    return $return;
	}

	/**
	 * 添加/修改视频面试
     */
    public function addInfo($data, $utype = '')
	{

    	$id     =   $data['id'];
        $uid    =   intval($data['uid']);

        if(empty($this->config['sy_spview_appkey']) || empty($this->config['sy_spview_appsecret'])){
            
            $return['msg']      =   '网站未配置视频面试，请联系网站管理员配置';
            $return['errcode']  =   8;
            return $return;
        }
        
        if($utype == ''){

        	$data['status'] =	0;

        	if($data['starttime']<time()){

				$return['msg']      =   '开始面试时间不得小于当前时间';
		        $return['errcode']  =   8;
		        return $return;
			}
			if(empty($data['jobid'])){

				$return['msg']      =   '请选择面试职位';
		        $return['errcode']  =   8;
		        return $return;
			}
        }else if($utype == 'admin'){

			$data['status']	=	1;
		}

		if (empty($data['remark'])){
			
			$jobs	=	$this->select_all('company_job', array('id' => array('in', $data['jobid']), 'limit' => '2'), '`id`, `name`');
			
			$jobNameA	=	array();
			foreach ($jobs as $v) {
				$jobNameA[]	=	$v['name'];
			}
			$jobName	=	@implode(',', $jobNameA);
			$sDate		=	date('Y/m/d', $data['starttime']);
			
			$sTime		=	date('H', $data['starttime']) > '12' ? '下午' : '上午';
			
			$data['remark']	=	$jobName.'等职位 -  '.$sDate.' '.$sTime.' 面试专场';
		}
		
        if(!$id){

            $statis  =  $this->select_once('company_statis',array('uid'=>$data['uid']),'`rating_type`,`vip_etime`,`spview_num`');
            
            if(isVip($statis['vip_etime'])){
                
                if($statis['rating_type'] == 1){  // 套餐模式
                    if ($statis['spview_num'] < 1){
                        $return['msg']      =   '发布视频面试数量已用完';
                        $return['errcode']  =   8;
                        return $return;
                    }
                }
            }else{
                $return['msg']      =   '会员已过期';
                $return['errcode']  =   8;
                return $return;
            }

        	$data['ctime']	=	time();

			$nid	=	$this -> insert_into('spview',$data);
            $msg	=	'发布视频面试';
			// 扣除数量
			$this->update_once('company_statis', array('spview_num'=>array('-',1)), array('uid'=>$data['uid']));
			
        }else{

            $where['id']	=	$id;
            $where['uid']	=	$uid;

            $row	=	$this->select_once('spview',$where, '`starttime`,`roomstatus`');
            
            if ($utype == '' && $row['starttime'] < time()){
                
                $return['msg']	=	'视频面试已开始，无法修改';
                
            }elseif ($utype == '' && $row['roomstatus'] == 1){
                
                $return['msg']  =	'视频面试已结束，无法修改';
                
            }else{
                
                $nid  =  $this -> update_once('spview',$data,$where);
                $msg  =  '更新视频面试';

                //修改面试开始时间，需重新通知预约用户,并更改spview_subscribe_msg表的开播时间和预定发送时间
                if($row['starttime']!=$data['starttime']){

                	if($data['starttime'] - 86400<time()){

                		$this -> delete_all('spview_subscribe_msg', array('sid'=>$id,'type'=>1), '');

                	}else{

                		$this -> update_once('spview_subscribe_msg',array('sptime'=>$data['starttime'],'stime'=>$data['starttime'] - 86400),array('sid'=>$id,'type'=>1));

                	}
                	
                	$this -> update_once('spview_subscribe_msg',array('sptime'=>$data['starttime'],'stime'=>$data['starttime'] - 3600),array('sid'=>$id,'type'=>2));

                	if ($utype == ''){//企业修改开始时间，需重新通知预约用户
                		$this -> sendSpviewChangeMsg($id);
                	}
                }
            }
        }

        if($nid){
            if($utype=='admin'){

                $return['msg']  =   $msg.'成功';
            }else{

            	$return['msg']  =   $msg.'成功,等待审核';
                
                $cominfo	=	$this->select_once('company',array('uid'=>$uid), '`name`');

            	require_once ('admin.model.php');
                $adminM = new admin_model($this->db, $this->def);
                $adminM->sendAdminMsg(array('first'=>'有新的视频面试需要审核，企业《'.$cominfo['name'].'》'.$msg.'，视频面试ID（'.$nid.'）','type'=>31));
            
            }

            $return['url']      =   'index.php?c=spview';
            $return['errcode']  =   9;
        }else{

            $return['msg']      =   isset($return['msg']) ? $return['msg'] : $msg.'失败';
            $return['errcode']  =   8;
            $return['url']      =   $_SERVER['HTTP_REFERER'];
        }
        return $return;
    }
    //修改了面试开始时间后重新通知预约用户
    function sendSpviewChangeMsg($id){
		
		if($id){

			$time 	=	time();

			$spview = 	$this->select_once('spview',array('id'=>$id));

			$list	=	$this -> select_all('spview_subscribe',array('sid'=>$id,'status'=>0));

			$uids	=	array();
		    $jids	=	array();
		    $comid	=	$spview['uid'];
		    foreach($list as $val){
		        
		        if($val['uid']){
		        	$uids[] = $val['uid'];
		        }

				if($val['jobid']){
		        	$jids[] = $val['jobid'];
		        }

		        
		    }

		    if(!empty($list)){
		        
		        $company 	= 	$this->select_once('company',array('uid'=>$comid),'`name`');

		        $member			=	$this -> select_all('member', array('uid'=>array('in', pylode(',',$uids))),'`uid`,`wxid`,`moblie`,`email`,`usertype`');

		    	$memdata		=	array();

		    	foreach($member as $mk=>$mv){

		    		$memdata[$mv['uid']]['wxid'] 	= $mv['wxid'];

		    		$memdata[$mv['uid']]['usertype']= $mv['usertype'];

		    		$memdata[$mv['uid']]['moblie'] 	= $mv['moblie'];

		    		$memdata[$mv['uid']]['email'] 	= $mv['email'];
		    	}

				$jobList		=	$this->select_all('company_job', array('id' => array('in', pylode(',', $jids))), '`id`,`name`');
				$jobs	=	array();
				foreach($jobList as $jk => $jv){
					$jobs[$jv['id']]['jobname']	=	$jv['name'];
				}

		        require_once 'weixin.model.php';
		        
		        $weixinM    =   new weixin_model($this->db, $this->def);

		        require_once 'notice.model.php';
		        
		        $noticeM    =   new notice_model($this->db, $this->def);
		        
		        $sendData	=	array();
		        
		        foreach($list as $key=>$val){
		            
		            $sendData['title']		=	"您预约的视频面试变更了面试时间！";
		            $sendData['name']		=	$company['name'];

		            $sendData['jobname']	=	$jobs[$val['jobid']]['jobname'];

		            $sendData['sptime']		=	date("Y年m月d日 H:i", $spview['starttime']);

		            $sendData['sptype']		=	"视频面试";

		            $sendData['url']		=	Url('wap', array('c'=>'spview', 'a' => 'show', 'id' => $val['sid']));
		            
		        	$sendData['wxid']		=	$memdata[$val['uid']]['wxid'];

		        	$sendData['usertype']	=	$memdata[$val['uid']]['usertype'];

		        	$sendData['uid']		=	$val['uid'];

		        	$weixinM->sendWxSpview($sendData);

		        	
		        	$data		=	array(
						'uid'		=>	$val['uid'],
			            'usertype'	=>	$memdata[$val['uid']]['usertype'],
			            'moblie'	=>	$memdata[$val['uid']]['moblie'],
			            'email'		=>	$memdata[$val['uid']]['email'],
						'type'		=>	'spmsbg',
						'company'	=>	$company['name'],
						'jobname'	=>	$jobs[$val['jobid']]['jobname'],
						'date'		=>	date('Y-m-d H:i',$spview['starttime']),
					);

					$noticeM->sendEmailType($data);

					$data['port']	=	'1';

		            $noticeM->sendSMSType($data);

			    }
		        
		        
		    }
	    }
	}
    public function upStatusInfo($id , $where = array(), $data = array()){

		if(!empty($id)){
			
			if(is_array($id)){
				
				$where['id']	=	array('in',pylode(',',$id));
			}else{
				
				$where['id']	=	intval($id);
			}
			
			$nid  =  $this -> update_once('spview', $data, $where);
		}
		
		return $nid;
	
	}

	function upSpviewHits($id){
		
		if(!empty($id)){
			
			$this -> update_once('spview', array('hits' => array('+', 1)), array('id' => $id));
		}
	}

    public function delSpview($delId,$data=array()){

        if (empty($delId)) {

            $return     =   array( 'errcode' => 8, 'msg' => '请选择要删除的数据！');

        } else {

            if (is_array($delId)) {

                $delId  =   pylode(',', $delId);

                $return['layertype']    =   1;

            } else {

                $return['layertype']    =   0;
            }

            if($data['uid']){

            	$spwhere = array('id' => array('in', $delId),'uid'=>$data['uid']);

            }else{

            	$spwhere = array('id' => array('in', $delId));

            }

            $delid      =   $this -> delete_all('spview', $spwhere, '');

            if ($delid) {
            	$this -> delete_all('spview_log', array('sid' => array('in',$delId)), '');
                $this -> delete_all('spview_subscribe', array('sid' => array('in', $delId)), '');
                $this -> delete_all('spview_subscribe_msg', array('sid' => array('in', $delId)), '');
            }
            $return['msg']      =   '视频面试';

            $return['errcode']  =   $delid ? '9' : '8';

            $return['msg']      =   $delid ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }

        return $return;
    }
    // 面试记录数量
    function getSplogNum($whereData=array(),$data=array()){
        
        if (!empty($whereData)) {
            
            $Info   =   $this->select_num('spview_log', $whereData);
            
            return $Info;
        }
    }
    /**
     * 查询单条面试记录
     */
    function getSpviewLog($where, $data = array()){
        
        if (!empty($where)){
            
            $field  =  !empty($data['field']) ? $data['field'] : '*';
            
            $row  =  $this->select_once('spview_log', $where, $field);
            
            return $row;
        }
    }
    /**
     * 添加面试记录，已经有面试记录但面试时间为0的新记录，不重复添加
     */
    function addSpviewLog($data = array()){
        
        $log  =  $this->select_once('spview_log', array('uid'=>$data['uid'], 'comid'=>$data['comid'], 'sptime'=>0,'orderby'=>'ctime'));
        
        if (!empty($log)){
            
            $nid  =  $log['id'];
            
        }else{
            
            $arr  =  array(
                'uid'     =>  $data['uid'],
                'comid'   =>  $data['comid'],
                'jobid'   =>  $data['jobid'],
                'roomid'  =>  $data['roomId'],
                'sid'     =>  $data['sid'],
                'zid'     =>  $data['zid'],
                'ctime'   =>  time()
            );
            $nid  =  $this->insert_into('spview_log', $arr);
        }
        return $nid;
    }
    /**
     * 修改面试记录
     */
    function updateSpviewLog($whereData, $data = array()){
        
        if (!empty($whereData)){
            
            $nid  =  $this -> update_once('spview_log', $data, $whereData);
        }
    }

	function viewSub($data=array()){
		
		if(!empty($data)){
			
		    if(empty($data['uid']) || $data['usertype']!=1){
		        
		        $return['msg']	    	=	'只有个人用户才能预约';
		        
		        $return['errcode'] 	=	7;
		        
		        return $return;
		    }

		    $info  =  $this->select_once('company_job',array('id' => $data['jobid']), '`job1`');
		    
		    if(empty($info)){
		        
		        $res['msg']	    	=	'该职位不存在';
		        
		        $res['errcode']	=	7;
		        
		        return $res;
		    }
		    
		    $resume  		=	$this->select_once('resume',array('uid'=>$data['uid']));
		    
		    $data['eid']	=	$data['eid'] ? $data['eid'] : $resume['def_job'];
		    
		    $expect  		=  	$this->select_once('resume_expect', array('id'=>$data['eid'],'uid'=>$data['uid']), '`id`,`state`,`integrity`,`status`');
		    
		    if(empty($expect)){
		    	$res['msg']	    	=	'您还没有简历，请先添加简历';
		        $res['errcode']	=	7;
		        return $res;
		    }elseif($expect['state'] == 0){
		        
		        $res['msg']	    	=	'简历正在审核中，请联系管理员';
		        $res['errcode']	=	7;
		        return $res;
		    }elseif($expect['state'] == 2){
		        
		        $res['msg']	    	=	'简历被举报，请联系管理员';
		        $res['errcode']	=	7;
		        return $res;
		    }elseif($expect['state'] == 3){
		        
		        $res['msg']	    	=	'简历未通过审核，请联系管理员';
		        $res['errcode']	=	7;
		        return $res;
		    }elseif($this->config['user_sqintegrity'] && $expect['integrity'] < $this->config['user_sqintegrity']){
		        
		        $res['msg']	    	=	'该简历完整度未达到'.$this->config['user_sqintegrity'].'%,请先完善简历！';
		        $res['errcode']	=	7;
		        return $res;
		    }elseif($expect['status']!='1'){
		        $res['msg']     	=   '请先公开您的简历！';
		        $res['errcode']	=	7;
		        return $res;
		    }
		    
		    $spview     =   $this -> select_once('spview', array('id'=>$data['sid']));
		    
		    if($data['uid']==$spview['uid']){
		        
		        $return['msg']	    	=	'您不能预约自己发布的视频面试';
		        
		        $return['errcode'] 	=	7;
		        
		        return $return;
		    }

		    $data['comid']	=	$spview['uid'];
		    
		    $startDay   =   $spview['starttime'] - ($this->config['sy_spview_yytime'] * 3600);
		    
		    $sp_jobids  =   @explode(',',$spview['jobid']);
		    
		    $sp_exps    =   !empty($spview['exp']) ? $spview['exp'] : '';
		    
		    $sp_edus    =   !empty($spview['edu']) ? $spview['edu'] : '';
		    
		    $sp_sexs    =   !empty($spview['sex']) ? @explode(',',$spview['sex']) : array();
		    
		    $sp_others  =   !empty($spview['other']) ? @explode(',',$spview['other']) : array();
		    
		    //视频面试预约截止时间为视频面试开始时间前一天
		    if($startDay < time()){
		        
		        $return['errcode']	=	7;
		        $return['msg']      	= '面试已开始无法预约';
		        return $return;
		    }
		    
		    //该视频面试是否存在此职位
		    if(!empty($sp_jobids) && !in_array($data['jobid'],$sp_jobids)){
		        
		        $return['errcode']		=	7;
		        $return['msg']			= '该面试不包含此职位';
		        return $return;
		    }
		    //是否满足经验需求
		    if($sp_exps){
		        
		        $sexp	=	$this	->	select_once('userclass',array('id'=>$sp_exps),'`sort`');

		        $rexp	=	$this	->	select_once('userclass',array('id'=>$resume['exp']),'`sort`');

		        if(!empty($rexp)){

		        	if($rexp['sort']<$sexp['sort']){

			    		$return['exp_check']	=	1;
			    	}
		        }else{

		        	$return['exp_check']	=	1;
		        }
		    }
		    //是否满足学历需求
		    if($sp_edus){
		        
		        $sedu	=	$this	->	select_once('userclass',array('id'=>$sp_edus),'`sort`');

		        $redu	=	$this	->	select_once('userclass',array('id'=>$resume['edu']),'`sort`');

		        if(!empty($redu)){

		        	if($redu['sort']<$sedu['sort']){

			    		$return['edu_check']	=	1;
			    	}
		        }else{

		        	$return['edu_check']	=	1;
		        }
		    }
		    //是否满足性别需求
		    if(!empty($sp_sexs) && !in_array($resume['sex'],$sp_sexs)){
		        
		        $return['sex_check']	=	1;
		    }
		    
		    //是否满足年龄需求
		    $age  =  date('Y') - date('Y',strtotime($resume['birthday']));
		    
		    if(($spview['minage'] && $age<$spview['minage'])||($spview['maxage'] && $age>$spview['maxage'])){
		        
		        $return['age_check']	=	1;
		        
		        if (!empty($spview['minage'])){
		            if (!empty($spview['maxage'])){
		                $return['job_age']  =  $spview['minage'] .'-'. $spview['maxage'].'岁';
		            }else{
		                $return['job_age']  =  $spview['minage'] .'岁以上';
		            }
		        }else{
		            if (!empty($spview['maxage'])){
		                $return['job_age']  =  $spview['maxage'].'岁以下';
		            }
		        }
		        $return['my_age']  =  $age.'岁';
		    }
		    //简历的职位类别顶级类是否包含预定职位的类别
		    if (!empty($info['job1'])){
		        
		        $resume_jobclass     =   $this -> select_all('resume_jobclass', array('eid'=>$expect['id'],'uid'=>$resume['uid']));
		        
		        foreach($resume_jobclass as $jk=>$jv){
		            
		            $resume_jobclass_arr[] = $jv['job1'];
		        }
		        if (!empty($resume_jobclass_arr)){
		            $resume_jobclass_arr  =  array_unique($resume_jobclass_arr);
		            
		            if(!in_array($info['job1'],$resume_jobclass_arr)){
		                
		                $return['hy_check']		=	1;
		            }
		        }
		    }
		    if (isset($return['sex_check']) || isset($return['edu_check']) || isset($return['exp_check'])){
		        $cacheOptions[]  =  'user';
		    }
		    if (isset($return['hy_check'])){
		        $cacheOptions[]  =  'job';
		    }
		    if (!empty($cacheOptions)){
		        // 处理求职要求类别
		        include_once('cache.model.php');
		        $cacheM  =  new cache_model($this->db,$this->def);
		        $cache   =  $cacheM -> GetCache($cacheOptions);
		        if (isset($return['sex_check']) || isset($return['edu_check']) || isset($return['exp_check'])){
		            
		            $user_sex        =  $cache['user_sex'];
		            $userclass_name  =  $cache['userclass_name'];
		            
		            if (isset($return['sex_check'])){
		                foreach ($sp_sexs as $v){
		                    $sexarr[]  =  $user_sex[$v];
		                }
		                $return['job_sex']   =  implode(',', $sexarr);
		                $return['my_sex']    =  $user_sex[$resume['sex']];
		            }
		            if (isset($return['edu_check'])){
		                $return['job_edu']   =  $userclass_name[$sp_edus];
		                $return['my_edu']    =  $userclass_name[$resume['edu']];
		            }
		            if (isset($return['exp_check'])){
		                $return['job_exp']   =  $userclass_name[$sp_exps];
		                $return['my_exp']    =  $userclass_name[$resume['exp']];
		            }
		        }
		        if (isset($return['hy_check'])){
		            $job_name  =  $cache['job_name'];
		            $return['hy']    =  $job_name[$info['job1']];
		            $return['n_hy']  =  mb_substr($return['hy'], 0, 6);
		            
		            foreach ($resume_jobclass_arr as $k=>$v){
		                $my_hy[]  =  $job_name[$v];
		            }
		            $return['m_hy']   =  mb_substr($my_hy[0], 0, 6);
		            $return['my_hy']  =  implode(',', $my_hy);
		        }
		    }
		    if (!empty($sp_others)){
		        if(in_array(1, $sp_others)){
		            $work  =  $this->select_num('resume_work',array('eid'=>$expect['id'],'uid'=>$data['uid']));
		            if ($work==0){
		                $return['iswork']  =  1;
		            }
		        }
		        
		        if(in_array(2, $sp_others)){
		            $edu  =  $this->select_num('resume_edu',array('eid'=>$expect['id'],'uid'=>$data['uid']));
		            if ($edu==0){
		                $return['isedu']  =  1;
		            }
		        }
		        
		        if(in_array(3, $sp_others)){
		            $project  =  $this->select_num('resume_project',array('eid'=>$expect['id'],'uid'=>$data['uid']));
		            if ($project==0){
		                $return['isproject']  =  1;
		            }
		        }
		    }

		    if (isset($return['hy_check']) || isset($return['sex_check']) || isset($return['exp_check']) || isset($return['edu_check']) || isset($return['age_check']) || isset($return['iswork']) || isset($return['isedu']) || isset($return['isproject'])){
		        
		        $return['errcode']  =  8;
		        
		    }else{
		        
		        $return  =  $this->addSubcribe($data);
		    }
			return $return;
		}
	}

    //面试暂停 必传面试房间id 和 企业uid
    function spviewPause($data=array()){

    	$sid = $data['sid'];
    	$uid = $data['uid'];

    	if($sid){

			$spview		=	$this->getInfo(array('id'=>$sid,'uid'=>$uid));

			if($spview){

				$this->updateSubcribe(array('sid'=>$spview['id'],'status'=>1),array('status'=>2));

				$res['errorcode']	= 	9;

			}else{
				$res['errorcode']	= 	8;
				$res['msg']			= 	'参数错误';
			}
			
		}else{
			$res['errorcode']	= 	8;
			$res['msg']			= 	'参数错误';
		}

		return $res;
    }
    //下一位 必传面试房间id 和 企业uid
    function spviewNext($data=array()){

    	$sid = $data['sid'];
    	$uid = $data['uid'];

    	if($sid){

			$spview		=	$this->getInfo(array('id'=>$sid,'uid'=>$uid));

			if($spview){

				$this	->	updateSubcribe(array('sid'=>$spview['id'],'status'=>1),array('status'=>2));
                
				if (empty($data['nowuid'])){
				    // 直接点的下一位，不是在列表中邀请的
				    $subwhere 	=	array(
				        'sid'		=>	$spview['id'],
				        'status'	=>	0,
				        'rtime'		=>	array('>',0),
				        'orderby'	=>	'rtime,asc'
				    );
				    
				    $subInfo	=	$this->getSubinfo($subwhere);
				    
				}else{
				    
				    $subInfo['uid']  =  $data['nowuid'];
				}

				if(!empty($subInfo)){

					$res['errorcode']	= 	9;
					$res['nextuid'] 	=	$subInfo['uid'];

				}else{
					$res['errorcode']	= 	8;
					$res['msg']			= 	'暂无待面试用户';
				}

			}else{

				$res['errorcode']	= 	8;
				$res['msg']			= 	'参数错误';

			}

		}else{
			$res['errorcode']	= 	8;
			$res['msg']			= 	'参数错误';
		}
		return $res;
    }
    //关闭面试间 必传面试房间id 和 企业uid
    function spviewFinish($data=array()){

    	$sid = $data['sid'];
    	$uid = $data['uid'];

    	if($sid){

			$spview		=	$this->getInfo(array('id'=>$sid,'uid'=>$uid));

			if($spview){

				$this	->	updateSubcribe(array('sid'=>$spview['id'],'status'=>1),array('status'=>2));

				$this	->	upStatusInfo($spview['id'],array('uid'=>$uid),array('roomstatus'=>1));

				$res['errorcode']	= 	9;
				$res['msg']			= 	'操作成功';

			}else{

				$res['errorcode']	= 	8;
				$res['msg']			= 	'参数错误';
			}

		}else{

			$res['errorcode']	= 	8;
			$res['msg']			= 	'参数错误';
		}
		return $res;
    }
	
	public function delSub($delId, $data=array(), $utype=''){

        if (empty($delId)) {

            $return     =   array( 'errcode' => 8, 'msg' => '请选择要删除的数据！');

        } else {

			if (is_array($delId)) {

                $delId  =   pylode(',', $delId);

                $return['layertype']    =   1;

            } else {

                $return['layertype']    =   0;
            }

			if($utype == 'admin'){

				$delWhere	=	array('id' => array('in', $delId));
			}else if(!empty($data['uid'])){

				$delWhere	=	array('id' => array('in', $delId), 'uid' => $data['uid']);		
			}else if(!empty($data['comid'])){

				$delWhere	=	array('id' => array('in', $delId), 'comid' => $data['comid']);		
			}

			$subInfo		=	$this -> select_all('spview_subscribe', $delWhere);

			$subIds			=	array();

			foreach($subInfo as $k => $v){

				$subIds[]	=	$v['id'];
			}

            $delid      	=   $this -> delete_all('spview_subscribe', $delWhere, '');

            if ($delid) {

                $this -> delete_all('spview_subscribe_msg', array('subid'  => array('in', pylode(',', $subIds))), '');
            }

            $return['msg']      =   '视频面试';

            $return['errcode']  =   $delid ? '9' : '8';

            $return['msg']      =   $delid ? $return['msg'].'删除成功！' : $return['msg'].'删除失败！';
        }

        return $return;
    }
    /**
     * 检查个人用户是否有待参加的视频面试
     */
    function canRoom($where){
        
        $can     =  false;
        $sptime  =  '';
        $List    =   $this->select_all('spview_subscribe', $where);
        
        if(!empty($List)){
            
            foreach($List as $key=>$val){
                
                $sids[]		=	$val['sid'];
            }
            $time     =  time();
            $spviews  =  $this->select_all('spview',array('id'=>array('in',pylode(',',$sids))));
            
            foreach($List as $key=>$val){
                
                foreach ($spviews as $sv) {
                    
                    if($sv['id'] == $val['sid']){
                        
                        // 未成为待面试，从面试前半小时开始，进行提示.开始时间过5小时，不再提示
                        if($val['status'] ==0 && $sv['roomstatus']==0 && (($sv['starttime'] > $time && $sv['starttime'] < ($time + 1800)) || ($sv['starttime'] < $time && $sv['starttime'] + (3600 * 5) > $time))){
                            
                            $can     =  true;
                            
                            if ($sv['starttime'] > $time && $sv['starttime'] < ($time + 1800)){
                                
                                $sptime  =  '将于'. round(($sv['starttime'] - $time)/60) .'分钟后（' . date("Y-m-d H:i", $sv['starttime']) . '）开始，请提前做好准备！';
                            }
                        }
                    }
                }
            }
        }
        
        if ($can){
            
            return array('can'=>$can, 'sptime'=>$sptime);
            
        }else{
            
            return array();
        }
    }

	/**
     * 查询视频通话记录
     * @param $where
     * @param $data utype=admin 后台查询数据
     */
    function getSpLogList($where = array(), $data = array())
    {
        
        $row  =  $this->select_all('spview_log',$where);
		
        if (!empty($row)){
            
            $comids =   $uids   =   $zphIds =   array();
            
            $cache   =   $this -> getClass(array('user'));

            foreach ($row as $val) {
                
                $comids[$val['comid']]  =   $val['comid'];
                $uids[$val['uid']]      =   $val['uid'];
                $zphIds[$val['zid']]  	=   $val['zid'];
                $splogids[$val['id']]  	=   $val['id'];
                $jobids[$val['jobid']]  =   $val['jobid'];
            }
            
            $companys   =   $this->select_all('company', array('uid' => array('in', pylode(',', $comids))), '`uid`,`name`,`address`');
            $resumes    =   $this->select_all('resume_expect', array('uid' => array('in', pylode(',', $uids))), '`uid`,`name`,`uname`,`edu`,`exp`,`sex`,`birthday`');
			
			//$zphnets    =   $this->select_all('zphnet', array('id' => array('in', pylode(',', $zphIds))), '`id`,`title`');
			
			//$remarks    =   $this->select_all('interview_remark', array('splogid' => array('in', pylode(',', $splogids))), '`splogid`,`isremark`,`content`');

			$jobs    =   $this->select_all('company_job', array('id' => array('in', pylode(',', $jobids))), '`id`,`name`,`edu`,`exp`,`welfare`,`minsalary`,`maxsalary`');
			
            

            foreach ($row as $k => $v) {
                
                $row[$k]['ctime_n'] =    date('Y-m-d H:i:s',$v['ctime']);
                
                $row[$k]['sptime_n']=    $v['sptime'] < 60 ? $v['sptime'].'秒': ceil($v['sptime'] / 60).'分钟';
                
                foreach ($companys as $cv) {
                    if ($v['comid'] == $cv['uid']){
                        $row[$k]['comname'] =   $cv['name'];
                        $row[$k]['address'] =   $cv['address'];
                        $row[$k]['comname'] =   $cv['name'];
                    }
                }

                foreach ($jobs as $jv) {
                    if ($v['jobid'] == $jv['id']){
                        $row[$k]['jobname'] =   $jv['name'];
                        $row[$k]['edu'] =   $jv['edu'];
                        $row[$k]['exp'] =   $jv['exp'];
                        $row[$k]['arraywelfare'] =   explode(',', $jv['welfare']);

                        if (!empty($cv['minsalary']) || !empty($jv['maxsalary'])) {
                     
                            if(!empty($cv['minsalary']) && !empty($jv['maxsalary'])){
                        
                                $row[$k]['salary']  =  '￥'.$jv['minsalary'].'-'.$jv['maxsalary'].'元/月';
                        
                            }elseif (!empty($cv['minsalary'])){
                        
                                $row[$k]['salary']  =  '￥'.$jv['minsalary'].'元/月';
                        
                            }else{
                        
                                $row[$k]['salary']  =  '面议';
                            }
                        }else{
                    
                            $row[$k]['salary']      =  '面议';
                        }

                    }
                }

                
                foreach ($resumes as $rv) {
                    if ($v['uid'] == $rv['uid']){
                        $row[$k]['rname']   =   $rv['name'];
                        $row[$k]['edu_n']   =   $cache['userclass_name'][$rv['edu']];
                        $row[$k]['exp_n']   =   $cache['userclass_name'][$rv['exp']];
                        $row[$k]['sex_n']   =   $cache['user_sex'][$rv['sex']];
                        $row[$k]['age_n']   =   date('Y') - date('Y',strtotime($rv['birthday']));
                        $row[$k]['runame']  =   $rv['uname'];
                    }
                }
                
                
            }
        }
        
        return $row;
    }

	/**
	 * @desc 删除视频记录
	 * @param int|array $delId
	 * @param array $data: admin, zdid, uid, usertype
	 */
    public function delSplog($delId = null, $data = array()){
        
        if (empty($delId)) {

            $return         =   array('errcode' => 8, 'msg' => '请选择要删除的数据！');
        } else {

            if (is_array($delId)) {

                $delId                  =   pylode(',', $delId);

                $return['layertype']    =   1;
            } else {

                $return['layertype']    =   0;
            }
            
            $splogs =   $this->getSpLogList(array('id' => array('in', $delId)), array('field' => '`splogid`'));
            if (!empty($splogs)) {
                $splogIds   =   array();
                foreach ($splogs as $sk => $sv) {
                    $splogIds[] =   $sv;
                }
            }

            if ($data['utype'] == 'admin'){
            
                $delWhere	=	array('id' => array('in',$delId));

                $return['id']       =   $this -> delete_all('spview_log', $delWhere, '');

            }
            // else{
            	
            // 	$delWhere['id']	=	array('in', $delId);
            	
            // 	if ($data['usertype'] == '1'){
            		
            // 		$delWhere['uid']	=	$data['uid'];
            // 	}else if ($data['usertype'] == '2'){
            		
            // 		$delWhere['comid']	=	$data['uid'];
            // 	}

            // 	$return['id']       =   $this -> update_once('spview_log',array('del'=>1),$delWhere);
            // }
            
            $return['errcode']  =   $return['id'] ? 9 : 8;
            
            $msg                =   '视频通话记录';
            
            $return['msg']      =   $return['id'] ? $msg.'删除成功！' : '删除失败！';
        }
        return $return;
    }
	function spLogNum($zphID = NULL){
		
		$arr	=	$where	=	array();
		
		if($zphID){
			$where['zid']	=	$zphID;
		}

		$where['sptime']	=	array('>',0);
		//
 		$spLogAll						=	$this -> select_once('spview_log', $where,"count(*) as num,SUM(sptime) as time");
 		
 		if(!empty($spLogAll) && $spLogAll['num']>0){
			$arr['spLogAllNum']			=	$spLogAll['num'];

			if($spLogAll['time'] > 60 ){
			
				$arr['spLogAlltime']		=	round($spLogAll['time']/60,2).'分钟';

			}else{

				$arr['spLogAlltime']		=	$spLogAll['time'].'秒';
			
			}
			
			
			$avg	=	round($spLogAll['time']/$spLogAll['num'],2);

			if($avg > 60){
				$arr['spLogAvgNum']			=	round($avg/60,2).'分钟';
			}else{
				$arr['spLogAvgNum']			=	$avg.'秒';
			}
			
		}
		return json_encode($arr);
	
	}
}
?>