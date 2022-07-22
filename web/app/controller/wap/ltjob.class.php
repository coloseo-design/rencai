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
class ltjob_controller extends common{
	function index_action(){
		$CacheM		=	$this	->	MODEL('cache');
		$CacheArr	=	$CacheM	->	GetCache(array('job','city','hy','com','lt','ltjob'));		
		$uptime		=	array(1=>'今天',3=>'最近3天',7=>'最近7天',30=>'最近一个月',90=>'最近三个月');
		
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]	=	$k."=".$v;
			}
		}
		$searchurl	=	@implode("&",$searchurl);

		$this		->	seo("com_search");
		$this		->	yunset("topplaceholder","请输入职位关键字,如：会计...");
		$this		->	yunset("uptime",$uptime);
		$this		->	yunset($CacheArr);
		$this		->	yunset("searchurl",$searchurl);
		$this		->	yunset('backurl',Url('wap'));
		$this		->	yuntpl(array('wap/ltjoblist'));
	}
	//企业高端职位（悬赏）
	function show_action(){
		$lietoujobM			=	$this		->	MODEL('lietoujob');
        $companyM			=	$this		->	MODEL('company');
		$JobM				=	$this		->	MODEL('job');
        $job				=	$this		->	job($lietoujobM);
        $ComJobNum			=	$lietoujobM	->	getLtjobNum(array('uid'=>$job['uid']));
		$com_info			=	$companyM	->	getInfo($job['uid'],array('logo'=>'1'));
		if($this->uid){ 
			$atnM			=	$this		->	MODEL('atn');
			$atn			=	$atnM		->	getatnInfo(array('uid'=>$this->uid,'sc_uid'=>$job['uid']));
			$userjob		=	$JobM		->	getSqJobNum(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'2'));
			$favjob			=	$JobM		->	getFavJob(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'2'));
			$this			->	yunset("favjob",$favjob);
			$this			->	yunset("userjob",$userjob);
			$this			->	yunset('atn',$atn);
		}
		if($job['uid']==$this->uid){
			$this			->	yunset("myself",1);
		}
		
		$this				->	yunset(array('Info'=>$com_info,'user_job_num'=>$ComJobNum));
		$this				->	seo("job_show"); 
		if($this->config['lt_rec_rebates']=='1' && (int)$job['rebates']>0){
			$this			->	yunset("headertitle","悬赏职位详情");
		}else{
			$this			->	yunset("headertitle","高端职位详情");
		}
		$this				->	yuntpl(array('wap/ltjobshow'));
	}
	//猎头职位（悬赏）
	function recshow_action(){
		$M=$this->MODEL('lietou');
		$lietoujobM			=	$this		->	MODEL('lietoujob');
		$lietouM			=	$this		->	MODEL('lietou');
        $JobM				=	$this		->	MODEL('job');
        $job				=	$this		->	job($lietoujobM);	
        $LietouJobNum		=	$lietoujobM	->	getLtjobNum(array('uid'=>$job['uid'],"status"=>1,"zp_status"=>'0',"r_status"=>array('<>','2')));
		$lietoujobM			->	upInfo(array('id'=>intval($_GET['id'])),array('hits'=>array('+',1)));

		if($this->uid&&$this->usertype=='1'){
			$atnM			=	$this		->	MODEL('atn');
			$atn			=	$atnM		->	getatnInfo(array('uid'=>$this->uid,'sc_uid'=>$job['uid']));
			$userjob		=	$JobM		->	getSqJobNum(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'3'));
			$favjob			=	$JobM		->	getFavJob(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'3'));
			$this			->	yunset("favjob",$favjob);
			$this			->	yunset("userjob",$userjob);
			$this			->	yunset('atn',$atn);
		}
		 
		if($job['uid']==$this->uid){
			$this			->	yunset("myself",1);
		}
	    $Info				=	$lietouM	->	getInfo(array('uid'=>$job['uid']),array('datatype'=>'moreinfo'));	
	    
		
	    $this		->	yunset('Info',$Info);
	    $this		->	yunset('user_job_num',$LietouJobNum);
		$this		->	seo('job_show');
		if($this->config['lt_rec_rebates']=='1' && (int)$job['rebates']>0){
			$this	->	yunset("headertitle","悬赏职位详情");
		}else{
			$this	->	yunset("headertitle","猎头职位详情");
		}
		
		$this		->	yuntpl(array('wap/ltjobrecshow'));
	}
	//猎头详情
	function hunter_action(){
        $lietouM			=	$this		->	MODEL("lietou");
        if($this->usertype=="1"){
        	$atnM			=	$this		->	MODEL('atn');
			$atn			=	$atnM		->	getatnInfo(array('uid'=>$this->uid,'sc_uid'=>(int)$_GET['uid']));
			$this			->	yunset('atn',$atn);
        }
        $lietouM			->	upInfo(array('uid'=>(int)$_GET['uid']),array('hits'=>array('+',1)));

        $userinfoM			=	$this		->	MODEL("userinfo");
		$user				=	$userinfoM	->	getInfo(array('uid'=>(int)$_GET['uid']));
		if($user['uid']==''){
			$data['msg']	=	'没有找到相关猎头！';
			$data['url']	=	$_SERVER['HTTP_REFERER'];
			$this			->	yunset("layer",$data);
		}
		$this				->	yunset("user",$user);
		
        $info				=	$lietouM	->	getInfo(array('uid'=>(int)$_GET['uid']),array('utype'=>'wap','datatype'=>'moreinfo'));
		
		$statisM			=	$this		->	MODEL('statis');
		$ltstatis			=	$statisM	->	getInfo((int)$_GET['uid'],array('usertype'=>'3'));
		$ratingM			=	$this		->	MODEL('rating');
		$vip_pic 			= 	$ratingM	->	getInfo(array('id'=>$ltstatis['rating']),array('field'=>'`com_pic`','pic'=>1));
		$this				->	yunset("vip_pic",$vip_pic['com_pic']);
		$this				->	yunset("info",$info);
		$data['lt_name']	=	$info['realname'];
		$this->data			=	$data;
		$this				->	seo("headhunter");
		$this				->	yunset("headertitle","猎头介绍");
		$this				->	yuntpl(array('wap/lthunter'));
	}
	//推荐人才
	function recuser_action(){
		$lietoujobM				=	$this		->	MODEL('lietoujob');
		$jobinfo				=	$lietoujobM	->	getInfo(array('id'=>(int)$_GET['id']),array('datatype'=>'moreinfo','cache'=>'1'));
		$CacheList				=	$this		->	MODEL('cache')	->	GetCache(array('user'));
		$this					->	yunset($CacheList);
		
		$data['job_name']		=	$jobinfo['job_name'];//职位名称
		$this->data				=	$data;
		$this					->	yunset("jobinfo",$jobinfo);
		$this					->	yunset($jobinfo['cache']);
		
		$this					->	seo('rec_user');
		$this					->	yunset("headertitle","推荐人才");
		$this					->	yuntpl(array('wap/ltrecuser'));
	}
	function recusersave_action(){
		$_POST						=	$this	->	post_trim($_POST);

		$rdata['uid']				=	$this->uid;
		$rdata['job_uid']			=	(int)$_POST['job_uid'];
		$rdata['job_id']			=	(int)$_POST['job_id'];
		$rdata['name']				=	$_POST['name'];
		$rdata['phone']				=	$_POST['phone'];
		$rdata['content']			=	strip_tags($_POST['content']);
		$rdata['datetime']			=	time();

		$tdata['job_uid']			=	(int)$_POST['job_uid'];
		$tdata['job_id']			=	(int)$_POST['job_id'];
		$tdata['name']				=	$_POST['name'];
		$tdata['uname']				=	$_POST['name'];
		$tdata['sex']				=	$_POST['sex'];
		$tdata['birthday']			=	$_POST['birthday'];
		$tdata['edu']				=	$_POST['edu'];
		$tdata['exp']				=	$_POST['exp'];
		$tdata['telphone']			=	$_POST['phone'];
		$tdata['email']				=	$_POST['email'];
		$tdata['hy']				=	$_POST['hy'];
		$tdata['job_classid']		=	$_POST['job_classid'];
		$tdata['provinceid']		=	$_POST['provinceid'];
		$tdata['cityid']			=	$_POST['cityid'];
		$tdata['three_cityid']		=	$_POST['three_cityid'];
		$tdata['minsalary']			=	$_POST['minsalary'];
		$tdata['maxsalary']			=	$_POST['maxsalary'];
		$tdata['type']				=	$_POST['type'];
		$tdata['report']			=	$_POST['report'];
		$tdata['content']			=	$_POST['content'];
		$tdata['did']				=	$this->userdid;

		$lietouM					=	$this		->	MODEL('lietou');
		$return						=	$lietouM	->	addRebates($rdata,$tdata,array('uid'=>$this->uid,'usertype'=>$this->usertype));
		echo json_encode($return);
	}
	function job($M){
		
		include(CONFIG_PATH."db.data.php");		
		$this	->	yunset("arr_data",$arr_data);
		if((int)$_GET['id']){
			
			session_start();
			$where['id']	=	(int)$_GET['id'];
			$job			=	$M	->	getInfo($where,array('cache'=>'1','datatype'=>'moreinfo'));
			
			if (!empty($_SESSION['auid'])) {
				if(!is_array($job)){
			        $data['msg']	=	'没有找到相关职位！';
			        $data['url']	=	Url('wap',array('c'=>'ltjob'));
			        $this			->	yunset("layer",$data);
			    }
			}
			if ($job['uid']!=$this->uid){
			    if(!is_array($job)){
			        $data['msg']	=	'没有找到相关职位！';
			        $data['url']	=	Url('wap',array('c'=>'ltjob'));
			        $this			->	yunset("layer",$data);
			    }elseif($job['r_status']=='2'){
			        $data['msg']	=	'企业已被锁定！';
			        $data['url']	=	Url('wap',array('c'=>'ltjob'));
			        $this->yunset("layer",$data);
			    }elseif($job['zp_status']==1){
			        $data['msg']	=	'职位已下架！';
			        $data['url']	=	Url('wap',array('c'=>'ltjob'));
			        $this->yunset("layer",$data);
			    }elseif($job['status']==0){
			        $data['msg']	=	'职位还未审核，请耐心等待！';
			        $data['url']	=	Url('wap',array('c'=>'ltjob'));
			        $this->yunset("layer",$data);
			    }elseif($job['status']==3){
			        $data['msg']	=	'职位未通过审核！';
			        $data['url']	=	Url('wap',array('c'=>'ltjob'));
			        $this			->	yunset("layer",$data);
			    }
			}
			
			$this			->	yunset($job['cache']);
			
			$UserInfoM	=	$this		->	MODEL('userinfo');
			$com		=	$UserInfoM	->	getUserInfo(array('uid'=>$job['uid']),array('usertype'=>2));
			if($com['shortname']){
				$job['com_name']	=	$com['shortname'];
			}
			if($com['address']){
				$job['address']		=	$com['address'];
			}
			if($com['x']){
				$job['x']			=	$com['x'];
			}
			if($com['y']){
				$job['y']			=	$com['y'];
			}
			
			if($job['status']=='2'||$job['zp_status']=='1'){
			    $job['notuserjob']	=	1;
			}
			
			$this				->	yunset('job',$job);
			$data['job_name']	=	$job['job_name'];
			$this->data			=	$data;
			return $job;
		}else{
		    $data['msg']		=	'没有找到相关职位！';
		    $data['url']		=	Url('wap',array('c'=>'ltjob'));
		    $this				->	yunset("layer",$data);
		}
	}
	function favjob_action(){
		$data['job_id']		=	(int)$_POST['id'];
		$data['uid']		=	$this->uid;
		$data['usertype']	=	$this->usertype;
		$data['jobtype']	=	'lt';

		$jobM	=	$this	->	MODEL('job');
		$return	=	$jobM	->	collectJob($data);
		echo $return['error'];
		
	}
	function service_action(){
		$CacheM					=	$this	->	MODEL('cache');
        $CacheList				=	$CacheM	->	GetCache(array('city','ltjob','lthy'));
		$this					->	yunset($CacheList);
		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]	=	$k."=".$v;
			}
		}
		
		$searchurl				=	@implode("&",$searchurl);
		$this					->	yunset("searchurl",$searchurl);
		$this					->	seo('ltservice');
		$this					->	yunset("topplaceholder","请输入猎头名称");
		$this					->	yuntpl(array('wap/ltservice'));
	}	
	
	function famous_action(){
		$CacheM     =   $this->MODEL('cache');
        $CacheList  =	$CacheM->GetCache(array('city','hy','com'));
		$this -> yunset($CacheList);

		foreach($_GET as $k=>$v){
			if($k!=""){
				$searchurl[]    =   $k."=".$v;
			}
		}
		
		$searchurl  =   @implode("&",$searchurl);
		$this->yunset("searchurl",$searchurl);

		$this->seo('ltfamous');
		$this->yunset("topplaceholder","请输入企业名称");
		$this->yuntpl(array('wap/ltfamous'));
	}
	function share_action(){

		$this->get_moblie();
		$lietoujobM =   $this->MODEL('lietoujob');
        $job        =	$this->job($lietoujobM);

		if($job['usertype']=='3'){
			$lietouM    =	$this->MODEL('lietou');
			$info       =   $lietouM->getInfo(array('uid'=>$job['uid']));
		}else{
			$comM       =	$this->MODEL('company');
			$comM->getInfo(array('uid'=>$job['uid']));

			$UserInfoM  =   $this->MODEL('userinfo');
			$info       =	$UserInfoM->getInfo(array('uid'=>$job['uid']),array('logo'=>'1'));
		}
		
		$this->yunset("info",$info);
		$this->yunset("headertitle",$job['job_name'].'-'.$job['com_name'].'-'.$this->config['sy_webname']);
		$this->yunset("job_style",$this->config['sy_weburl']."/app/template/wap/job");
		$this->yuntpl(array('wap/job/ltjob'));
	}
	
}
?>