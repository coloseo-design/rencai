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
class index_controller extends company{
	function index_action(){
		
		$this -> public_action();
	
		$statis			=	$this->company_satic();
		$jobM			=	$this->MODEL('job');
		$userinfoM		=	$this->MODEL('userinfo');
		$downresumeM	=	$this->MODEL('downresume');
		$companyorderM	=	$this->MODEL('companyorder');
		$MsgM			=	$this -> MODEL('msg');
		$couponM		=	$this -> MODEL('coupon');

		if($this->config['sy_couponday']>0){
            $coupontime     =           $this->config['sy_couponday'];
        }else{
            $coupontime     =           30;
        }

		$coupon 		=   $couponM->getCouponNum(array('uid' => $this->uid, 'status' => 1, 'validity' => array(array('>',time(),'AND'),array('<', strtotime('+ '.$coupontime.' days'),'AND'))));
		$this->yunset('coupon', $coupon);
    
    	$couponhist		=   $couponM->getCouponListOne(array('uid' => $this->uid, 'status' => 1, 'state' =>array('<>',1), 'validity' => array('>', time()),'orderby'=>array('ctime,desc')));
    	$this->yunset('couponhist', $couponhist);

		//收到的简历
		$des_resume		=	$jobM->getSqJobNum(array('com_id'=>$this->uid,'isdel'=>9,'type'=>array('<>',3)));
		$this->yunset('des_resume',$des_resume);
		
		//求职者咨询
		$msgnum			=	$MsgM -> getMsgNum(array('job_uid'=>$this->uid,'status'=>1));
		$this->yunset('msgnum',$msgnum);

        //谁看过我
        $look_jobnum	=	$jobM -> getLookJobNum(array('com_id'=>$this->uid,'com_status'=>0), array('usertype' => $this->usertype));
        $this->yunset('look_jobnum',$look_jobnum);
		
		//浏览量
        $comM           =   $this->MODEL('company');
        $hitsExporue    =   $comM->getHitsExpoure($this->uid);
		$this->yunset(array('hitsNum' => $hitsExporue['hits'], 'expoureNum' => $hitsExporue['expoure']));

		//收到未查看的简历
		$de_resume		=	$jobM->getSqJobNum(array('com_id'=>$this->uid,'isdel'=>9,'is_browse'=>'1','type'=>array('<>',3)));
        $this->yunset('de_resume',$de_resume);
		
		//下载简历
		$down_resume	=	$downresumeM->getDownNum(array('comid'=>$this->uid,'usertype'=>$this->usertype,'isdel'=>9));
		$this->yunset('down_resume',$down_resume);
	    // 对我感兴趣
	    $atnM  =  $this->MODEL('atn');
	    $atn   =  $atnM->getantnNum(array('sc_uid'=>$this->uid,'sc_usertype'=>2));
	    $this->yunset('atn',$atn);
		//刷新职位数量
		if((int)$statis['vip_etime'] == 0){

			$breakWhere	=	array(
				'uid'	=>  $this -> uid,
				'opera'	=>  1,
				'type'	=>  4,
				'ctime'	=>	array('>=', $statis['vip_stime'])
			);
		}else{
			$breakWhere 	=	array(
				'uid'                 =>  $this -> uid,
				'opera'               =>  1,
				'type'                =>  4,
				'PHPYUNBTWSTART_A'    =>  '',
				'ctime'               =>  array(
					'0'   =>  array('>=', $statis['vip_stime'], 'AND'),
					'1'   =>  array('<=', $statis['vip_etime'], 'AND')
				),
				'PHPYUNBTWEND_A'      =>  ''
			);
		}
		$breakjobNums	=	$this -> MODEL('log') -> getMemberLogNum($breakWhere);
		$this->yunset('breakjobNums', $breakjobNums);

		//正常职位数,判断是否弹出刷新职位
		$normal_job_num	=	$jobM -> getJobNum(array('uid' => $this->uid, 'state' => '1' , 'r_status' => 1, 'status' => 0));
		$this->yunset('normal_job_num',$normal_job_num);
		
		//今日未刷新职位,判断是否弹出刷新职位
		$un_refreshjob_num		=	$jobM -> getJobNum(array('uid' => $this->uid,'lastupdate' => array('<' , strtotime('today')),'state'=>'1','r_status'=>1,'status'=>0));
		$this->yunset('un_refreshjob_num',$un_refreshjob_num);
	
		//获取职位id、name
        $jobwhere['uid']		=   $this->uid;
		$jobwhere['state']		=	1;
		$jobwhere['r_status']	=	1;
		$jobwhere['status']		=	0;
		$jobsA	=   $jobM -> getList($jobwhere);//招聘中职位
		$jobs	=	$jobsA['list'];

		if($jobs && is_array($jobs)){//获取职位ID
		 
			foreach($jobs as $key=>$v){
				
				$ids[]			=	$v['id'];
				if ($key<3){
				    $jobnames[]	=	$v['name'];
				}
			}
			$jobids 			=	"".pylode(",",$ids)."";
			$jobnames 			=	"".@implode(",",$jobnames)."";
			if (count($jobs)>3){
			    $jobnames		.=	"等，<span style='color:blue'>共".count($jobs)."个职位</span>。";
			}
			$this->yunset('jobids',$jobids);
			$this->yunset('jobnames',$jobnames);
		}
 		
		$member	=	$userinfoM->getInfo(array('uid'=> $this->uid),array('field'=>'`login_date`,`status`,`wxid`,`unionid`'));
		$this->yunset('member',$member);
		
		if($statis['rating']>0){
			//获取会员图标
			$company_rating	=	$this->MODEL('rating')->getInfo(array('id'=>$statis['rating']));
      		$this->yunset('company_rating',$company_rating);
		}
    
		//浏览记录
		$look_resume	=	$this->MODEL('lookresume')->getLookNum(array('com_id'=>$this->uid,'com_status'=>'0'));
		$this->yunset('look_resume',$look_resume);
		//未付款订单
		$paying			=   $companyorderM -> getCompanyOrderNum(array('uid' => $this->uid,'usertype' => $this->usertype,'order_state' => '1'));
		$this->yunset('paying',$paying);
		
		//企业资质认证查询
		$yyzz			=   $this->MODEL('company')->getCertInfo(array('uid' => $this -> uid, 'type' => 3), array('field' => '`status`'));
		$this->yunset('yyzz', $yyzz);
		
		//查询优惠券sy_couponday
		$this->cookie->SetCookie('jobrefresh','1',(strtotime('today') + 86400));
		//判断微信绑定情况
		if($member['wxid']==''&&$member['unionid']=='' && $this->config['wx_author']=='1'){
		    $this->yunset('qrcode', 1);
		}
		$this->cookie->SetCookie('gzh','1',(strtotime('today') + 86400));
				
		$company	=	$this->comInfo['info'];

		if($company['hy']== ''){
			
			if($_COOKIE['indextip']=='1'){
				$indextip = 0;
			}else{
				$this->cookie->SetCookie('indextip','1',(strtotime('today') + 86400));
				$indextip = 1;
			}
			
			$this->yunset('indextip',$indextip);
		}else{

			$this->cookie->SetCookie('indextip','',(strtotime('today') - 86400));

		}

		$this->yunset('company', $this->comInfo['info']);
		
		$ggnum	=	0;
		if(empty($this->spid)){
			if($company['r_status'] !=1){
				$ggnum++;
			}
			if(empty($company['name'])){
				$ggnum++;
			}
			if($statis['vipIsDown']==1){
				$ggnum++;
			}elseif($statis['remind']==1 && empty($statis['vipIsDown'])){
				$ggnum++;
			}
		}
        $this->yunset('ggnum', $ggnum);

        $WhbM       =   $this->MODEL('whb');
        $maxNum     =   $normal_job_num > 6 ? 6 : $normal_job_num;
        $syComHb    =   $WhbM->getWhbList(array('type' => 2, 'isopen' => 1, 'num' => $maxNum ));
        $this->yunset('hbNum', count($syComHb));

        if(!empty($syComHb)){
            $hbids  =   array();
            foreach ($syComHb as $hk => $hv) {
                $hbids[] = $hv['id'];
            }
            $this->yunset('hbids', $hbids);
        }
        $this->yunset('hb_uid', $this->uid);
 		$this->com_tpl('index');
	}
	function couponsee_action(){
		//优惠券自动查看
		$couponM		=			$this->MODEL('coupon');
		$where['uid']	=			$this->uid;
		$where['id']	=			intval($_POST['couponid']);
		$data			=			array(
			'state'		=>			1
		);
		$couponM->upCouponList($where,$data);
	}
	
	function resumeajax_action(){
		$jobM		=	$this->MODEL('job');
		$resumeM	=	$this->MODEL('resume');
		
		
        $jobwhere['com_id']		=   $this->uid;
		$jobwhere['state']		=	1;
		$jobwhere['r_status']	=	1;
		$jobwhere['status']		=	0;
		
	    $joblist  =	 $jobM->getList($jobwhere,array('field'=>'`job1_son`,`job_post`,`cityid`'));
	    $joblist  =  $joblist['list'];
	    $cityids  =  array();
	    if(is_array($joblist) && !empty($joblist)){
	        foreach($joblist as $v){
	            if (!empty($v['cityid'])){
	                $cityids[]					=	$v['cityid'];
	            }
				
				$wherea['PHPYUNBTWSTART_A']		=	'' ;
				if($v['job1_son']){
					$wherea['job_classid'][]	=	array('findin',$v['job1_son']);
				}
				if($v['job_post']){
					$wherea['job_classid'][]	=	array('findin',$v['job_post'],'OR');
				}
				$wherea['PHPYUNBTWEND_A']		=	'' ;
	        }
			
			$whereSql['PHPYUNBTWSTART_B']		=	'' ;
			$whereSql['job_classid']			=	$wherea['job_classid'];
			//$whereSql['cityid']					=	array('in',pylode(',',$cityids));
			$whereSql['PHPYUNBTWEND_B']			=	'' ;
	    }
	    $blackM		=	$this->MODEL('black');
	    $blacklist	=	$blackM->getBlackList(array('p_uid'=>$this->uid),array('field'=>'`c_uid`'));
	    if(is_array($blacklist) && !empty($blacklist)){
	        foreach($blacklist as $v){
	            $bids[]=$v['c_uid'];
	        }
	        
	        $nwhereSql['uid']		=	$whereSql['uid'] 			=	array('notin',pylode(',',$bids)) ;
	    }
	    $cityids   = array_unique($cityids);
		$resumeeid = $resumeM->getResumeCityClassList(array('cityid'=>array('in',pylode(',',$cityids))),array('field'=>'`eid`'));
		foreach($resumeeid as $v){
			$eids[]=$v['eid'];
		}
		$nwhereSql['id']			=	$whereSql['id']				=	array('in',pylode(',',$eids));
		$nwhereSql['uname']			=	$whereSql['uname']			=	array('<>','');
		$nwhereSql['status']		=	$whereSql['status']			=	1;
		$nwhereSql['r_status']		=	$whereSql['r_status']		=	1;
		$nwhereSql['state']			=	$whereSql['state']			=	1;
		$nwhereSql['job_classid']	=	$whereSql['job_classid']	=	array('<>','');
		$nwhereSql['defaults']		=	$whereSql['defaults']		=	1;
		$nwhereSql['orderby']		=	$whereSql['orderby']		=	'lastupdate,desc';
		$nwhereSql['limit']			=	$whereSql['limit']			=	6;
		
	    $resumes 		= 	$resumeM->getList($whereSql);
	    
		$resume			=	$resumes['list'];
		if(empty($resume)){
			
			$resumes 	= 	$resumeM->getList($nwhereSql);
			$resume		=	$resumes['list'];
		}
	    $list			=	array();
	    if ($resume){
	        foreach ($resume as $v){
	            $uids[]	=	$v['uid'];
	        }
	        if ($uids){
	            $user 	= 	$resumeM->getResumeList(array('uid'=>array('in',pylode(',',$uids))),array('field'=>'`uid`,`name`,`nametype`,`sex`,`photo`,`phototype`,`photo_status`,`def_job`'));
	        }
	        foreach ($resume as $k=>$v){
	            $list[$k]['username_n']='';
	            foreach ($user as $val){
	                if ($v['uid']==$val['uid']){
	                    $list[$k]['username_n'] 	=	$val['name_n'];
						$list[$k]['photo']			=	$val['photo'];
	                }
	            }
	            $list[$k]['resumeurl']				=	Url('resume',array('c'=>'show','id'=>$v['id']));
	            
	            $list[$k]['edu_n']					=	$v['edu_n']?$v['edu_n'].'学历':'';
	            $list[$k]['exp_n']					=	$v['exp_n']?$v['exp_n'].'经验':'';
	            
	            $jobname							=	@explode(',', $v['job_classname']);
	            $list[$k]['jobname']				=	$jobname['0'];
				
	            $cityname							=	@explode(',', $v['city_classname']);
	            $list[$k]['cityname']				=	$cityname['0'];
	        }
	    }
	    $data['list']=$list;
	    echo json_encode($data);die;
	}
	function logout_action(){

		$this->logout();

	}
}
?>