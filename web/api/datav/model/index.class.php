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
class index_controller extends datav_controller{
	
	function numdeal($num){

		$mul = 10000;

		if($num>=$mul){
			$num = number_format($num/$mul,1).'万+';
		}

		return $num;
	}
	/*中间上半部分*/
	function index_action(){
		//企业总数和今日新增企业数
		$total_com		=	$this -> obj -> select_num('member',array('usertype' => '2'));	
		$newToday_com	=	$this -> obj -> select_num('member',array('reg_date' => array('>=',strtotime(date('Y-m-d'))),'usertype' => '2'));	
		//求职者总数和今日新增数
		$total_user		=	$this -> obj -> select_num('member',array('usertype' => '1'));	
		$newToday_user	=	$this -> obj -> select_num('member',array('reg_date' => array('>=',strtotime(date('Y-m-d'))),'usertype' => '1'));	
		//招聘总数和今日新增数
		$total_job		=	$this -> obj -> select_num('company_job');	
		$newToday_job	=	$this -> obj -> select_num('company_job',array('sdate' => array('>=',strtotime(date('Y-m-d')))));	
		//招聘会总数和今日新增数
		$total_zphnet		=	$this -> obj -> select_num('zphnet');	
		$newToday_zphnet	=	$this -> obj -> select_num('zphnet',array('ctime' => array('>=',strtotime(date('Y-m-d')))));
		$total_zph		=	$this -> obj -> select_num('zhaopinhui');	
		$newToday_zph	=	$this -> obj -> select_num('zhaopinhui',array('ctime' => array('>=',strtotime(date('Y-m-d')))));

		$total_zphnum = $total_zph+$total_zphnet;
		$newToday_zphnum = $newToday_zph+$newToday_zphnet;

		$List['unit']['total']		=	$this->numdeal($total_com+$this->sy_datav_diydata['allcomnum']);	
		$List['unit']['newToday']	=	$this->numdeal($newToday_com+$this->sy_datav_diydata['daycomnum']);
		//职位总数和今日新增数
		$List['job']['total']		=	$this->numdeal($total_job+$this->sy_datav_diydata['alljobnum']);
		$List['job']['newToday']	=	$this->numdeal($newToday_job+$this->sy_datav_diydata['dayjobnum']);
		//求职者总数和今日新增数
		$List['post']['total']		=	$this->numdeal($total_user+$this->sy_datav_diydata['allusernum']);
		$List['post']['newToday']	=	$this->numdeal($newToday_user+$this->sy_datav_diydata['dayusernum']);	
		//招聘会总数和今日新增数
		$List['zph']['total']		=	$this->numdeal($total_zphnum+$this->sy_datav_diydata['allzphnum']);
		$List['zph']['newToday']	=	$this->numdeal($newToday_zphnum+$this->sy_datav_diydata['dayzphnum']);		
		
		$this -> success($List);
		
	}
	//左侧上部求职者区域
	function resume_action(){

		$resumeM 	= $this->MODEL('resume');
		$cacheM = $this->MODEL('cache');
		//性别分布
		$manNum 	= $resumeM->getResumeNum(array('sex'=>1));
		$womanNum 	= $resumeM->getResumeNum(array('sex'=>2));
		$sexData 	= array(
			0=>array('name'=>'男','value'=>$manNum),
			1=>array('name'=>'女','value'=>$womanNum)
		);
		//学历分布
		$cache 	= $cacheM->GetCache('user');
		$user_edu = $cache['userdata']['user_edu'];
		$userclass_name = $cache['userclass_name'];
		$eduwhere	=	array(
			'groupby'	=>	'edu',
			'edu'=>array('in',pylode(',',$user_edu))
		);

		$edulist	=	$this -> obj ->select_all('resume',$eduwhere,'edu,count(*) as num');
		
		$edutj	=	array();
		foreach ($edulist as $edukey => $eduvalue) {
			$edutj[$edukey]['name'] 	= 	$userclass_name[$eduvalue['edu']];
			$edutj[$edukey]['value']  	=	$eduvalue['num'];
		}
		//期望薪资
		$salary = array(
			0=>array('name'=>'2k-4k','val'=>'2000,4000'),
			1=>array('name'=>'4k-6k','val'=>'4000,6000'),
			2=>array('name'=>'6k-8k','val'=>'6000,8000'),
			3=>array('name'=>'8k-10k','val'=>'8000,10000'),
			4=>array('name'=>'10k以上','val'=>'10000,20000'),
			5=>array('name'=>'20k以上','val'=>'20000,0'),
		);
		foreach($salary as $salaryk=>$salaryv){

			$salarr = @explode(',',$salaryv['val']);

			if($salarr[1]==0){
				$where['minsalary'] = array('>=',$salarr[0]);
			}else{
				$where['PHPYUNBTWSTARTA'] = '';
				$where['minsalary'] = array('<=',$salarr[1]);
				$where['maxsalary'] = array('>=',$salarr[0]);
				$where['PHPYUNBTWENDA']  = '';
			}
			
			$num	=	$resumeM->getExpectNum($where);
			unset($salary[$salaryk]['val']);
			$salary[$salaryk]['value'] = $num;
		}
		//工作经历
		$user_exp = $cache['userdata']['user_word'];
		$userclass_name = $cache['userclass_name'];

		$expwhere	=	array(
			'groupby'	=>	'exp',
			'exp'=>array('in',pylode(',',$user_exp))
		);

		$explist	=	$this -> obj ->select_all('resume_expect',$expwhere,'`exp`,count(*) as num');
		
		$exptj	=	array();

		foreach ($explist as $expkey => $expvalue) {
			$exptj[$expkey]['name'] 	= 	$userclass_name[$expvalue['exp']];
			$exptj[$expkey]['value']  	=	$expvalue['num'];
		}

		//求职者动态
		$pageSize			=	$_POST['pageSize'] ? $_POST['pageSize'] : '10';

		$logwhere['limit']		=	$pageSize;	
		
		$logwhere['orderby']	=	'lastupdate,desc';

		$expectLog	= $this -> obj -> select_all('resume_expect',$logwhere,"`uname`,`lastupdate`");
		
		
		$logwhere['orderby']	=	'datetime,desc';
		$favLog		= $this -> obj -> select_all('fav_job',$logwhere,"`uid`,`job_name`,`datetime`");
		
		
		$lookJobLog = $this -> obj -> select_all('look_job',$logwhere,"`uid`,`jobid`,`datetime`");
		if(!empty($lookJobLog)){
			
			foreach($lookJobLog as $value){
				$jobid[] = $value['jobid'];
			}

			$jobList	=	$this -> obj -> select_all('company_job',array('id' => array('in',pylode(',',$jobid))),"`id`,`name`");
			foreach($jobList as $value){
				
				$jobName[$value['id']]	=	$value['name'];
			}
		}
		
		$sqJobLog	= $this -> obj -> select_all('userid_job',$logwhere,"`uid`,`job_name`,`datetime`");
		
		$nameInfo	=	$this -> getUid(array($favLog,$lookJobLog,$sqJobLog));
		
		$List		= array();

		foreach($expectLog as $value){
			
			$List[]	=	array('name' => $value['uname'] , 'type' => '更新了简历' , 'time' => date('Y-m-d H:i',$value['lastupdate']) , 'sort' => $value['lastupdate']);
		
		}
	
		foreach($favLog as $value){
			
			$List[]	=	array('name' => $nameInfo[$value['uid']] , 'type' => '收藏了'.$value['job_name'].'职位' , 'time' => date('Y-m-d H:i',$value['datetime']) , 'sort' => $value['datetime']);
		
		}

		foreach($lookJobLog as $value){
			
			$List[]	=	array('name' => $nameInfo[$value['uid']] , 'type' => '浏览了'. $jobName[$value['jobid']], 'time' => date('Y-m-d H:i',$value['datetime']) , 'sort' => $value['datetime']);
		
		}

		foreach($sqJobLog as $value){
			
			$List[]	=	array('name' => $nameInfo[$value['uid']] , 'type' => '申请了'.$value['job_name'].'职位' , 'time' => date('Y-m-d H:i',$value['datetime']) , 'sort' => $value['datetime']);
		
		}

		$List_sort = array();
		foreach ($List as $key => $value) {
			$List_sort[] = $value['sort'];
		}
		
		array_multisort($List_sort,SORT_DESC,$List);

		foreach($List as $key => $value){
			
			unset($List[$key]['sort']);
			if(($key+1) > $pageSize){
				
				unset($List[$key]);
			}
		
		}
		
		

		$return['sexData'] 		= $sexData;
		$return['eduData'] 		= $edutj;
		$return['salaryData'] 	= $salary;
		$return['expData'] 		= $exptj;
		$return['ListData'] 	= $List;

		$this -> success($return);
	}

	//右侧上部企业数据
	function company_action(){

		$ComM 	= $this->MODEL('company');

		//行业分布
		include PLUS_PATH . 'industry.cache.php';

        $hyComs 	= $ComM->getList(array('uid' => array('>', 0)), array('field' => 'uid,hy'));

        $hyCount 	= array();
        foreach ($hyComs['list'] as $key => $value) {
            if (!$value['hy']) {
                $hyCount[0]['name'] = '其他';
                $hyCount[0]['value']++;
            } else {
                $hyCount[$value['hy']]['name'] = $industry_name[$value['hy']];
                $hyCount[$value['hy']]['value']++;
            }
        }
        //地区分布
        include PLUS_PATH . 'city.cache.php';
        $cityComS = $this->obj->select_all('company', array('orderby' =>'provinceid,desc'),'uid,provinceid');

        $cityCount = array();
        foreach ($cityComS as $key => $value) {
            if (!empty($city_name[$value['provinceid']])) {

                $cityCount[$value['provinceid']]['name'] = $city_name[$value['provinceid']];
                $cityCount[$value['provinceid']]['value']++;
            }
        }
        //企业规模
        include PLUS_PATH . 'com.cache.php';

        $muncomS = $this->obj->select_all('company', array('orderby'=>'mun,desc'), 'uid, mun');
        
        $munCount = array();
        foreach ($muncomS as $key => $value) {
            if ($value['mun'] != '' && $value['mun'] != 0) {

                $munCount[$value['mun']]['name'] = $comclass_name[$value['mun']];
                $munCount[$value['mun']]['value']++;
            }
        }
        //企业动态消息
        $pageSize			=	$_POST['pageSize'] ? $_POST['pageSize'] : '10';

		$where['limit']		=	$pageSize;	
		
		$where['orderby']	=	'sdate,desc';

		$jobLog	= $this -> obj -> select_all('company_job',$where,"`name`,`com_name`,`sdate`");
		
		$where['orderby']	=	'datetime,desc';
		$lookExLog = $this -> obj -> select_all('look_resume',$where,"`uid`,`com_id`,`datetime`");
	
		if(!empty($lookExLog)){
			
			foreach($lookExLog as $value){
				$comid[] = $value['com_id'];
			}

			$comList	=	$this -> obj -> select_all('company',array('uid' => array('in',pylode(',',$comid))),"`uid`,`name`");
			
			foreach($comList as $value){
				
				$comName[$value['uid']]	=	$value['name'];
			}

		}
		
		$where['orderby']	=	'downtime,desc';
		$downLog = $this -> obj -> select_all('down_resume',$where,"`uid`,`comid`,`downtime`");
		
		if(!empty($downLog)){
			
			foreach($downLog as $value){
				$comid[] = $value['comid'];
			}

			$comList	=	$this -> obj -> select_all('company',array('uid' => array('in',pylode(',',$comid))),"`uid`,`name`");
			foreach($comList as $value){
				
				$comName[$value['uid']]	=	$value['name'];
			}
		}
		
		$nameInfo	=	$this -> getUid(array($lookExLog,$downLog));
		
		$List		= array();

		foreach($jobLog as $value){
			
			$List[]	=	array('name' => $value['com_name'] , 'type' => '发布了'.$value['name'] , 'time' => date('Y-m-d H:i',$value['sdate']) , 'sort' => $value['sdate']);
		
		}
	
		
		foreach($lookExLog as $value){
			
			$List[]	=	array('name' => $comName[$value['com_id']] , 'type' => '浏览了'. $nameInfo[$value['uid']].'的简历', 'time' => date('Y-m-d H:i',$value['datetime']) , 'sort' => $value['datetime']);
		
		}

		foreach($downLog as $value){
			
			$List[]	=	array('name' => $comName[$value['comid']] , 'type' => '下载了'.$nameInfo[$value['uid']].'简历' , 'time' => date('Y-m-d H:i',$value['downtime']) , 'sort' => $value['downtime']);
		
		}

		$List_sort = array();
		foreach ($List as $key => $value) {
			$List_sort[] = $value['sort'];
		}
		
		array_multisort($List_sort,SORT_DESC,$List);

		foreach($List as $key => $value){
			
			unset($List[$key]['sort']);
			if(($key+1) > $pageSize){
				
				unset($List[$key]);
			}
		
		}
		
		$return['hyData'] 	= $hyCount;
        $return['cityData'] = $cityCount;
        $return['munData'] 	= $munCount;
        $return['listData'] = $List;

        $this->success($return);
        
	}

	//最热门岗位
	function toppost_action(){
		
		include PLUS_PATH.'job.cache.php';
		//查出每个职位的申请数
		$Sql	=	'select job_id,count(*) as sqnum from '.DEF_DATA.'userid_job  group by job_id  ORDER  by sqnum desc';
		
		$sqjob	=	$this -> obj -> DB_query_all($Sql,"all");

		foreach($sqjob as $value){
			
			$jobids[] = $value['job_id'];
			$sqNum[$value['job_id']]  = $value['sqnum'];
		
		}

		//统计有申请记录的职位和岗位
		$joblist	=	$this -> obj -> select_all('company_job',array('id' => array('in',pylode(',',$jobids))),"`id`,`job1`");
		foreach($joblist as $value){
			if($value['job1']){

				$post		=	$job_name[$value['job1']];

				$delNumber	=	$List[$value['job1']]['delNumber']	+ $sqNum[$value['id']];

				$postNumber	=	$List[$value['job1']]['postNumber']	+ 1;
				if($post && $post!=''){
					$List[$value['job1']]	=	array('post' => $post , 'delNumber' => $delNumber , 'postNumber' => $postNumber);
				}
			}
		}
		//排序
		$List_sort = array();
		foreach ($List as $key => $value) {
			$List_sort[] = $value['delNumber'];
		}
		array_multisort($List_sort,SORT_DESC,$List);

		$sqnum_rand = $this->sy_datav_diydata['hotjob_sqnum_rand'];
		$jobs_rand = $this->sy_datav_diydata['hotjob_jobs_rand'];

		foreach($List as $key=>$value){
			
			if(($key+1)>10){
				unset($List[$key]);
			}else{

				$sqnum_rand_num	=	rand(-$sqnum_rand,$sqnum_rand);
				$jobs_rand_num	=	rand(-$jobs_rand,$jobs_rand);
				
				$List[$key]['delNumber'] += $this->sy_datav_diydata['hotjob_sqnum']+$sqnum_rand_num;
				$List[$key]['postNumber'] += $this->sy_datav_diydata['hotjob_jobs']+$jobs_rand_num;
			}
		}

		$this -> success($List);
	}

	//最热门行业
	function tophy_action(){
		
		include PLUS_PATH.'industry.cache.php';
		

		$sqsql ='SELECT b.hy,count(*) as sqnum FROM '.DEF_DATA.'userid_job a LEFT JOIN '.DEF_DATA.'company_job b ON a.`job_id` = b.`id` GROUP BY b.`hy` ORDER  by sqnum desc';

		$hysq	=	$this -> obj -> DB_query_all($sqsql,"all");

		$hyjob	=	$this -> obj -> select_all('company_job',array('groupby'=>'hy'),"`hy`,count(*) as jobnum");
		$jobnum_arr = array();
		foreach ($hyjob as $jkey => $jval) {
			if($jval['hy']){
				$jobnum_arr[$jval['hy']] = $jval['jobnum'];
			}
		}

		$List = array();

		$sqnum_rand = $this->sy_datav_diydata['hothy_sqnum_rand'];
		$jobs_rand = $this->sy_datav_diydata['hothy_jobs_rand'];

		foreach($hysq as $sqkey => $sqvalue){

		    if(count($List) < 10 && !empty($industry_name[$sqvalue['hy']])){

		    	$sqnum_rand_num	=	rand(-$sqnum_rand,$sqnum_rand);
				$jobs_rand_num	=	rand(-$jobs_rand,$jobs_rand);

		        $List[]	=	array(
		        	'name' 	=> 	$industry_name[$sqvalue['hy']],
		        	'sqnum' => 	$sqvalue['sqnum'] + $this->sy_datav_diydata['hothy_sqnum'] + $sqnum_rand_num,
		        	'jobnum'=>	$jobnum_arr[$sqvalue['hy']] + $this->sy_datav_diydata['hothy_jobs'] + $jobs_rand_num
		        );
		    }
		}
		$this -> success($List);
	}

	//一年招聘企业趋势

	function comyear_action(){
		
		$date = strtotime(date('Y-m',strtotime('-11 month')));

		$data = array();

		$Sql	= "SELECT count(uid) value,FROM_UNIXTIME(reg_date,'%y.%m') name FROM ".DEF_DATA."member where reg_date > ".$date." AND usertype = 2 GROUP BY name ORDER BY name DESC;";

		$List	=	$this -> obj -> DB_query_all($Sql,"all");

		//排序
		$List_sort = array();
		foreach ($List as $key => $value) {
			$List_sort[] = $value['name'];
		}
		array_multisort($List_sort,SORT_ASC,$List);

		$totalSql = "select count(*) as num from (select uid from ".DEF_DATA."company_job where state=1 AND r_status=1 AND status = 0 group by uid ) as num";
		$total	=	$this -> obj -> DB_query_all($totalSql);
		
		$monthreg_rand = $this->sy_datav_diydata['yearcom_monthreg_rand'];

		foreach ($List as $key => $value) {
			$monthreg_rand_num		=	rand(-$monthreg_rand,$monthreg_rand);
			$List[$key]['value'] 	= 	$value['value'] + $this->sy_datav_diydata['yearcom_monthreg'] + $monthreg_rand_num;
		}

		$data['List'] 		= 	$List;
		$data['unitTotal']	=	$this->numdeal($total['num']+$this->sy_datav_diydata['yearcom_regnum']);
		
		$this -> success($data);
	}
	//最近一年求职动态
	function resumeLog_action(){

		$date = strtotime(date('Y-m',strtotime('-11 month')));

		$data = array();

		$Sql	= "SELECT count(uid) value,FROM_UNIXTIME(reg_date,'%y.%m') name FROM ".DEF_DATA."member where reg_date > ".$date." AND usertype = 1 GROUP BY name ORDER BY name DESC;";

		$List	=	$this -> obj -> DB_query_all($Sql,"all");

		//排序
		$List_sort = array();
		foreach ($List as $key => $value) {
			$List_sort[] = $value['name'];
		}
		
		array_multisort($List_sort,SORT_ASC,$List);

		//最近一个月注册总数
		$month = $this -> obj -> select_all('member',array('usertype'=>1,'reg_date'=>array('>',strtotime('-1 month'))),"count(*) as num");

		//今日新增人数
		$day = $this -> obj -> select_all('member',array('usertype'=>1,'reg_date'=>array('>',strtotime(date('Y-m-d',time())))),"count(*) as num");
		//最近一年的投递简历数
		$sq	=	$this -> obj -> select_all('userid_job',array('datetime'=>array('>',$date)),"count(*) as num");
		//最近一年的面试邀请数
		$yqms	=	$this -> obj -> select_all('userid_msg',array('datetime'=>array('>',$date)),"count(*) as num");
		//最近一年的直聊沟通次数
		$chat	=	$this -> obj -> select_all('chat_log',array('sendTime'=>array('>',$date)),"count(*) as num");
		//最近一年的简历浏览次数
		$look_resume	=	$this -> obj -> select_all('look_resume',array('datetime'=>array('>',$date)),"count(*) as num");
		//最近一年的岗位浏览次数
		$look_job	=	$this -> obj -> select_all('look_job',array('datetime'=>array('>',$date)),"count(*) as num");

		$monthreg_rand = $this->sy_datav_diydata['yearuser_monthreg_rand'];
		
		foreach ($List as $key => $value) {
			$monthreg_rand_num		=	rand(-$monthreg_rand,$monthreg_rand);
			$List[$key]['value'] 	= 	$value['value'] + $this->sy_datav_diydata['yearuser_monthreg'] + $monthreg_rand_num;
		}
		$sqjob_log =$this->sqjoblog();
		$data['List'] 		= 	$List;
		$data['monthnum'] 	= 	$this->numdeal($month[0]['num'] + $this->sy_datav_diydata['monthreg_user']);
		$data['daynum'] 	= 	$this->numdeal($day[0]['num'] + $this->sy_datav_diydata['dayreg_user']);
		$data['sqnum'] 		= 	$this->numdeal($sq[0]['num'] + $this->sy_datav_diydata['year_sqnum']);
		$data['yqnum'] 		= 	$this->numdeal($yqms[0]['num'] + $this->sy_datav_diydata['year_yqnum']);
		$data['chatnum'] 	= 	$this->numdeal($chat[0]['num'] + $this->sy_datav_diydata['year_chatnum']);
		$data['lresumenum'] = 	$this->numdeal($look_resume[0]['num'] + $this->sy_datav_diydata['year_lrnum']);
		$data['ljobnum'] 	= 	$this->numdeal($look_job[0]['num'] + $this->sy_datav_diydata['year_ljnum']);
		$data['sqjoblog'] 	= 	$sqjob_log;
		$this -> success($data);
	}
	function sqjoblog(){

		$UserinfoM	=	$this->MODEL('userinfo'); 
        $JobM		=	$this->MODEL('job');
        $ResumeM	=	$this->MODEL('resume');

		$where['orderby']	=	array('datetime,desc');
		$where['limit']	=	15;
		$List           =   $this ->obj -> select_all('userid_job', $where); 
		$sqjob_log = array();
		if (is_array($List)) {
            foreach ($List as $v) {
                if (!empty($v['uid'])) {
                    $uid[] = $v['uid'];
                }
                if (!empty($v['com_id'])) {
                    $com_id[] = $v['com_id'];
                }
                if (!empty($v['job_id'])) {
                    $jobid[] = $v['job_id'];
                }
            }
            
            $uidwhere['uid']	=	array('in',pylode(',',array_unique($uid)));
            $member2			=	$UserinfoM->getUserInfoList($uidwhere, array('usertype'=>1,'field'=>'`uid`,`name`,`sex`'));
            
            
            $com_idwhere['uid']	=	array('in',pylode(',',array_unique($com_id)));
            $member3			=	$UserinfoM->getUserList($com_idwhere);
        
            $jobwhere['id']	=	array('in',pylode(',',array_unique($jobid)));
            $jobA			=	$JobM->getList($jobwhere,array('field'=>'`id`,`name`'));
            $job			=	$jobA['list'];
         	
            foreach ($List as $k => $v) {
            	$content =$UserName=$jobname=$comname=$time_n='';
            	foreach ($member2 as $uval) {

                    if ($v['uid'] == $uval['uid']) {

                    	if($uval['sex'] == 1){

							$UserName 		=	mb_substr($uval['name'], 0, 1, 'utf-8').'先生';
						}else{

							$UserName 		=	mb_substr($uval['name'], 0, 1, 'utf-8').'女士';
						}
                        
                    }
                }
                foreach ($job as $jval) {

                    if ($v['job_id'] == $jval['id']) {

                        $jobname		=	$jval['name'];
                    }
                }
                
                
                foreach ($member3 as $cval) {

                    if ($v['com_id'] == $cval['uid']) {

                        $comname	=	$cval['name'];
                    }
                }

                $time	=	time() - $v['datetime'];

                if ($time > 60 && $time < 3600) {

                    $time_n	=	ceil($time / 60) . "分钟前";

                } elseif ($time < 60) {

                    $time_n	=	"刚刚";
                }

                $content = $UserName.'申请了'.$comname.'的'.$jobname;

                $sqjob_log[$k]['content'] = $content;
                $sqjob_log[$k]['time_n'] = $time_n;
                
            }

        }
        return $sqjob_log;
	}
	function getUid($data){
		
		foreach($data as $key=>$value){
			
			foreach($value as $k => $v){
				
				if($v['uid']){
					$uids[] = $v['uid'];
				}
				
			
			}
		
		}
		
		$resume	=	$this -> obj -> select_all('resume',array('uid' => array('in',pylode(',',$uids))),"`uid`,`name`");

		if(is_array($resume)){
			
			foreach($resume as $key=>$value){
			
				$info[$value['uid']]	=	mb_substr($value['name'],0,1).'**'; 
			
			}
		}
	
	
		return $info;
	}
}
?>