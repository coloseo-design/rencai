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
class school_controller extends common{
	function index_action(){
		
		$this->seo('school');
		$this->yunset("headertitle","校园招聘");
		$this->yunset("backurl",Url('wap'));
		$this->yuntpl(array('wap/school'));
	}
	function schoolacademy_action(){
        foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$searchurl	=	@implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);
		
		$CacheM		=	$this->MODEL('cache');
		$CacheList	=	$CacheM->GetCache(array('school','city'));
		$this->yunset($CacheList);
		
		$this->seo('school_academy');
		$this->yunset("headertitle","院校列表");
		$this->yunset("topplaceholder","请输入关键");
		$this->yuntpl(array('wap/school_academy'));
	}
    function schoolacademyshow_action(){
        $schoolM	=	$this->MODEL('school');
		$atnM		=	$this->MODEL('atn');
		
		$list		=	$schoolM->getSchoolAcademyInfo(array('id'=>$_GET['id']));
		$row		=	$list['info'];
		$this->yunset("row",$row);
		
		$atnnum		=	$atnM->getAtnNum(array('sc_uid'=>$_GET['id'],'uid'=>$this->uid));
		$this->yunset("rows",$atnnum);
		
		$data['name']	=	$row['schoolname'];
		$this->data		=	$data;
        $this->seo('school_academy_show');
		$this->yunset("headertitle","院校详情信息");
		$this->yuntpl(array('wap/school_academy_show'));
	}
	function job_action(){
		$CacheM		=	$this->MODEL('cache');
		$CacheArr	=	$CacheM->GetCache(array('job','city','hy','com','uptime', 'lt'));
		if($_GET['jobin']){
			$job_classid	=	@explode(',',$_GET['jobin']);
			$jobname		=	$CacheArr['job_name'][$job_classid[0]];
			$this->yunset("jobname",mb_substr($jobname,0,6,'utf-8'));
		}
		$this->yunset($CacheArr);
		
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$searchurl=@implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);
		
		$backurl=Url('wap',array('c'=>'school'));
		$this->yunset('backurl',$backurl);
		
		$_GET['is_graduate']=1;
		
		$this->seo('ws');
		$this->yunset("headertitle","网申职位列表");
		$this->yunset("topplaceholder","请输入关键字");
		$this->yuntpl(array('wap/wangshen'));
	}
	function xjh_action(){
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]=$k."=".$v;
			}
		}
		$searchurl=@implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);
		
		$CacheM		=	$this->MODEL('cache');
		$CacheList	=	$CacheM->GetCache(array('school','city'));
		$this->yunset($CacheList);
		
		$adtime		=	array('1'=>'今天','3'=>'最近3天','7'=>'最近7天','15'=>'最近15天','30'=>'最近一个月','90'=>'最近三个月');
		$this->yunset("adtime",$adtime);
		
		$this->seo('xjh');
		$this->yunset("headertitle","校招宣讲会");
		$this->yunset("topplaceholder","请输入关键");
		$this->yuntpl(array('wap/school_xjh'));
	}
	function atnxjh_action(){
		if(!$this->uid||!$this->username){
			$arr['msg']		=	'请先登录！';
			$arr['status']	=	8;
		}elseif($this->uid==$_POST['comid']){
			$arr['msg']		=	'本人发布，无法关注！';
			$arr['status']	=	8;
		}
		$atnM		=	$this->MODEL('atn');
		$atnnum		=	$atnM->getAtnNum(array('xjhid'=>$_POST['id'],'uid'=>$this->uid));
		
		if($atnnum){
			$arr['msg']		=	'您已关注！';
			$arr['status']	=	8;
		}else{
			$userinfoM		=	$this->MODEL('userinfo');
			$adata	=	array(
				'uid'			=>	$this->uid,
				'usertype'		=>	$this->usertype,
				'sc_uid'		=>	$_POST['comid'],
				'sc_usertype'	=>	2,
				'xjhid'			=>	$_POST['id'],
				'time'			=>	time()
			);
			$nid	=	$atnM->addAtnInfo($adata);
			if($nid){
				$arr['msg']		=	'关注成功！';
				$arr['status']	=	9;
			}else{
				$arr['msg']		=	'关注失败！';
				$arr['status']	=	8;
			}
		}
		echo json_encode($arr);die;
	}
	
	function atnxjhdel_action(){
		$atnM		=	$this->MODEL('atn');
		$return		=	$atnM->delAtnAll((int)$_POST['id'],array('sc_usertype'=>2,'xjh'=>1,'uid'=>$this->uid,'usertype'=>$this->usertype));
		echo json_encode($return);die;
	}
	
	function report_action(){
		session_start();
		$reportM	= 	$this->MODEL('report');
		if(md5(strtolower($_POST['authcode']))!=$_SESSION['authcode']  || empty($_SESSION['authcode'])){
			unset($_SESSION['authcode']);
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$data['msg']	=	'验证码错误！';
			echo json_encode($data);die;  
		}
		$row		=	$reportM->getReportOne(array('p_uid'=>$this->uid,'eid'=>(int)$_POST['id'],'c_uid'=>(int)$_POST['x_uid'],'usertype'=>$this->usertype));
		
		if(is_array($row)){
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$data['msg']	=	'您已举报过该校招宣讲会！';
			echo json_encode($data);die;  
		}
		$data		=	array(
			'c_uid'		=>	(int)$_POST['x_uid'],
			'inputtime'	=>	mktime(),
			'p_uid'		=>	$this->uid,
			'usertype'	=>	(int)$this->usertype,
			'eid'		=>	(int)$_POST['id'],
			'r_name'	=>	$this->stringfilter($_POST['c_name']),
			'username'	=>	$this->username,
			'r_reason'	=>	$this->stringfilter($_POST['e_reason']).'@'.$this->stringfilter($_POST['r_reason']),
			'did'		=>	$this->userdid,
			'type'		=>	3
		);
		
		$nid		=	$reportM->addSchoolReport($data);
		if($nid){
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$data['msg']	=	'提交成功！';
			echo json_encode($data);die;  
		}else{
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$data['msg']	=	'提交失败！';
			echo json_encode($data);die;  
		}
	}
	
}
?>