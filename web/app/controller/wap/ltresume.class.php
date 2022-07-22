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
class ltresume_controller extends common{
	function index_action(){
		
		$CacheM		=	$this->MODEL('cache');
		$CacheArr	=	$CacheM->GetCache(array('user','job','city','hy','uptime'));
		$this->yunset($CacheArr);
		
		if($_GET['jobin']){
			$job_classid	=	@explode(',',$_GET['jobin']);
			$jobname		=	$CacheArr['job_name'][$job_classid[0]];
			$this->yunset("jobname",mb_substr($jobname,0,6,'utf-8'));
		}
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$searchurl	=	@implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);

		$this->yunset("backurl",Url('wap',array(),'member'));

		$this->get_moblie();

		$this->seo("user_search");

		$this->yunset("topplaceholder","请输入优质简历关键字");
		$this->yuntpl(array('wap/ltresume'));
	}
	function show_action(){
		$resumeM		=	$this->MODEL('resume');
		$jobM			=	$this->MODEL('job');
		$lookresumeM	=	$this->MODEL('lookresume');

		$CacheM			=	$this->MODEL('cache');
        $CacheArr		=	$CacheM->GetCache(array('user'));
        $this -> yunset($CacheArr);
		
		if($this->usertype!="3" && $_GET['look']=="" /*&& $this->uid!=$resume_expect['uid']*/){
			$this->ACT_msg_wap($_SERVER['HTTP_REFERER'],'您不是猎头用户，不能查看优质人才！', 1, 3);
		}
		if((int)$_GET['uid']){
			
			if((int)$_GET['type']=="2"){

			    $user	=	$resumeM->getExpect(array("uid"=>(int)$_GET['uid'],"height_status"=>'2'),array('field'=>'`id`'));
				$id		=	$user['id'];
			}else{
				$def	=	$resumeM->getResumeInfo(array("uid"=>(int)$_GET['uid'],'r_status' => 1),array('field'=>'`def_job`'));
				$id		=	$def['def_job'];
			}
		}else{
			$id			=	(int)$_GET['id'];
		}
		$user			=	$resumeM -> getInfoByEid(array('eid' => (int)$_GET['id'], 'uid' => $this -> uid, 'usertype' => $this -> usertype));

		$euid	=	$resumeM->getExpect(array("id"=>(int)$_GET['id']),array('field'=>'`uid`'));
		
		$talent_pool			=	$resumeM->getTalentNum(array('eid'=>(int)$_GET['id'],'cuid'=>$this->uid));
		$user['talent_pool']	=	$talent_pool;

		$userid_msg				=	$jobM->getYqmsNum(array('uid'=>$euid['uid'],'fid'=>$this->uid,'isdel'=>9));
		$user['userid_msg']		=	$userid_msg;

		$this->yunset("Info",$user);
		
        if($this->usertype=="2" || $this->usertype=="3"){
			
			$this->yunset("uid",$this->uid);

			
			$jobM->updSqJob(array("com_id"=>$this->uid,"eid"=>(int)$_GET['id'], "is_browse"=>"1"),array("is_browse"=>"2"));
			
			//简历浏览记录
			$look_resume	=	$lookresumeM->getInfo(array("com_id"=>$this->uid,"resume_id"=>$id));
			if(!empty($look_resume)){

				$lookresumeM->upInfo(array("datetime"=>time()),array("resume_id"=>$id,"com_id"=>$this->uid));
			}else{
				$resumeM->addExpectHits($id);

				$data		=	array(
					'uid'		=>	$user['uid'],
					'resume_id'	=>	$id,
					'com_id'	=>	$this->uid,
					'did'		=>	$this->userdid,
					'datetime'	=>	time()
				);
				$lookresumeM->addInfo($data);
			}
        }
		$this->get_moblie();

		$data['resume_username']	=	$user['username_n'];//简历人姓名
		$data['resume_city']		=	$user['city_one'].",".$user['city_two'];//城市
		$data['resume_job']			=	$user['hy'];//行业
		$this->data					=	$data;
		$this->seo("resume");

		$this->yunset("headertitle","优质人才");
		$this->yuntpl(array('wap/ltresumeshow'));
	}
}
?>