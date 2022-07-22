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
class index_controller extends lietou_controller{
	function index_action(){
		//关键字显示
		$CacheM		=	$this	->	MODEL('cache');
		$keyword	=	$CacheM	->	GetCache(array('keyword'));

        if(is_array($keyword)){

        	foreach($keyword as $k=>$v){

	            if($v['type']=='7'&&$v['tuijian']=='1'){

	            	$postkeyword[]	=	$v;

	            }

        	}

        }
        $this	->	yunset("postkeyword",$postkeyword);
		//关键字显示end

		$this	->	public_action();
		$this	->	seo('ltindex');
		$this	->	lietou_tpl('index');
	}
	
	function post_action(){
		$this		->	public_action();
        $CacheM		=	$this	->	MODEL('cache');
        $CacheList	=	$CacheM	->	GetCache(array('city','lt','ltjob','hy'));
        $this		->	yunset($CacheList);

		if(empty($CacheList['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        

		$uptime		=	array("1"=>"1个月内","3"=>"3个月内","6"=>"6个月内","12"=>"12个月内","-1"=>"12个月以上",);
		$this		->	yunset("uptime",$uptime);

		if($_GET['hy']||$_GET['jobid']||$_GET['citys']||$_GET['minsalary']||$_GET['maxsalary']||$_GET['uptime']){
			
			$this	->	yunset("searchtype","1");
			 
			if($_GET['jobid']){

				$jobid	=	@explode(",",$_GET['jobid']);
				foreach($jobid as $v){
					$jobname[]	=	$CacheList['ltjob_name'][$v];
				}
				$this	->	yunset("jobname",@implode(",",$jobname));
			}

			if($_GET['citys']){
				$citys	=	@explode(",",$_GET['citys']);
				foreach($citys as $v){
					$cityname[]	=	$CacheList[city_name][$v];
				}
				$this	->	yunset("cityname",@implode(",",$cityname));
			}
		}
		$_GET['keyword']		=	trim($_GET['keyword']);
		
		$jobM	=	$this	->	MODEL('job');
		$ypjob	=	$jobM	->	getSqJobList(array('uid'=>$this->uid,'isdel'=>9,'type'=>array('<>','1')),array('field'=>'`job_id`','utype'=>'simple'));
		if(is_array($ypjob)){
			foreach($ypjob as $k=>$v){
				$ypjobarr[]		=	$v['job_id'];
			}
		}
		$this	->	yunset("ypjob",$ypjobarr);

		$favjob	=	$jobM	->	getFavJobList(array('uid'=>$this->uid,'type'=>array('<>','1')),array('field'=>'`job_id`'));
		if(is_array($favjob)){
			foreach($favjob as $k=>$v){
				$favjobarr[]	=	$v['job_id'];
			}
		}
		$this	->	yunset("favjob",$favjobarr);

		$this	->	yunset('lietou_member_style',TPL_PATH.'member/lietou');
		$this	->	seo("ltpost");
		$this	->	lietou_tpl('post');
	}


    //猎头发布的职位，猎头信息、公司信息
	function jobshow_action(){
		$this				->	public_action();		
		//$M			=	$this	->	MODEL('lietou');
		$lietoujobM			=	$this		->	MODEL('lietoujob');
		$lietouM			=	$this		->	MODEL('lietou');
        $JobM				=	$this		->	MODEL('job');
        $job				=	$this		->	job($lietoujobM);	
		$LietouJobNum		=	$lietoujobM	->	getLtjobNum(array('uid'=>$job['uid'],"status"=>1,"zp_status"=>'0',"r_status"=>array('<>','2')));
        $lietoujobM			->	upInfo(array('id'=>intval($_GET['id'])),array('hits'=>array('+',1)));

		$Info				=	$lietouM	->	getInfo(array('uid'=>$job['uid']),array('datatype'=>'moreinfo'));	
		
		if($this->uid	&&	$this->usertype=='1'){
			$atnM			=	$this		->	MODEL('atn');
			$atn			=	$atnM		->	getatnInfo(array('uid'=>$this->uid,'sc_uid'=>$job['uid'], 'sc_usertype' => 3));
			$userjob		=	$JobM		->	getSqJobNum(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'3','isdel'=>9));
			$favjob			=	$JobM		->	getFavJob(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'3'));
			$this			->	yunset("favjob",$favjob);
			$this			->	yunset("userjob",$userjob);
		}
		$Info['atn']		=	empty($atn)	?	"关注TA"	:	"取消关注";
		
		if($job['uid']==$this->uid){
			$this			->	yunset("myself",1);
		}
		$data['job_name']	=	$job['job_name'];
		$data['job_desc']	=	$job['desc'];
		$this	->	data	=	$data;
		$this	->	yunset('user_job_num',$LietouJobNum);
		$this	->	yunset('Info',$Info);
		$this	->	seo('job_show');
		$this	->	lietou_tpl('job_lt_show');
	}
    //企业发布的猎头职位，公司信息
	function jobcomshow_action(){
		
		$lietoujobM			=	$this		->	MODEL('lietoujob');
        $companyM			=	$this		->	MODEL('company');
		$JobM				=	$this		->	MODEL('job');
        $job				=	$this		->	job($lietoujobM);
		$com_info			=	$companyM	->	getInfo($job['uid'],array('logo'=>'1'));
		$ComJobNum			=	$lietoujobM	->	getLtjobNum(array('uid'=>$job['uid']));
        $lietoujobM			->	upInfo(array('id'=>intval($_GET['id'])),array('hits'=>array('+',1)));
		$statisM			=	$this->MODEL('statis');
		$ratingM			=	$this->MODEL('rating');
		$userinfoM			=	$this->MODEL('userinfo');
		$meminfo			=	$userinfoM->getInfo(array('uid'=>$job['uid']),array('field'=>'login_date'));
		$statis				=	$statisM->getInfo($job['uid'],array('usertype'=>'2'));
		$ratInfo			=	$ratingM->getInfo(array('id'=>$statis['rating']),array('field'=>'`com_pic`'));
		$com_info['login_date']	=	$meminfo['login_date'];
		$com_info['ratlogo']	=	checkpic($ratInfo['com_pic']);
		if($this->uid){ 
			$atnM			=	$this		->	MODEL('atn');
			$atn			=	$atnM		->	getatnInfo(array('uid'=>$this->uid,'sc_uid'=>$job['uid']));
			$userjob		=	$JobM		->	getSqJobNum(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'2','isdel'=>9));
			$favjob			=	$JobM		->	getFavJob(array("uid"=>$this->uid,"job_id"=>$job['id'],"type"=>'2'));
			$this			->	yunset("favjob",$favjob);
			$this			->	yunset("userjob",$userjob);
		}
		$com_info['atn']	=	empty($atn)	?	"+关注"	:	"取消关注";
		
		if($job['uid']==$this->uid){
			$this			->	yunset("myself",1);
		}
		$data['job_name']	=	$job['job_name'];
		$data['job_desc']	=	$job['desc'];
		$this	->	data	=	$data;
		$this	->	yunset(array('Info'=>$com_info,'user_job_num'=>$ComJobNum));
		$this	->	public_action();
		$this	->	seo("job_show"); 
		$this	->	lietou_tpl('job_com_show');
	}
	function recuser_action(){

		$lietoujobM						=	$this -> MODEL('lietoujob');
		if($_POST['submit']){
			$_POST						=	$this -> post_trim($_POST);

			$rdata['uid']				=	$this->uid;
			$rdata['job_uid']			=	(int)$_POST['job_uid'];
			$rdata['job_id']			=	(int)$_POST['job_id'];
			$rdata['name']				=	$_POST['uname'];
			$rdata['phone']				=	$_POST['telphone'];
			$rdata['content']			=	strip_tags($_POST['content']);
			$rdata['datetime']			=	time();

			$tdata['job_uid']			=	(int)$_POST['job_uid'];
			$tdata['job_id']			=	(int)$_POST['job_id'];
			$tdata['name']				=	$_POST['uname'];
			$tdata['uname']				=	$_POST['uname'];
			$tdata['sex']				=	$_POST['sex'];
			$tdata['birthday']			=	$_POST['birthday'];
			$tdata['edu']				=	$_POST['edu'];
			$tdata['exp']				=	$_POST['exp'];
			$tdata['telphone']			=	$_POST['telphone'];
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
			$rdata['did']				=	$this->userdid;

			$lietouM					=	$this -> MODEL('lietou');
			$return						=	$lietouM -> addRebates($rdata,$tdata,array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this -> ACT_layer_msg($return['msg'],$return['cod'],$return['url']);
			
		}
		$jobinfo				=	$lietoujobM	->	getInfo(array('id'=>(int)$_GET['id']),array('datatype'=>'moreinfo','cache'=>'1'));
        $data['job_name']		=	$jobinfo['job_name'];//职位名称
		$this	->	data		=	$data;
		if(empty($jobinfo['cache']['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        if(empty($jobinfo['cache']['job_type'])){
            $this   ->  yunset('jionly',1);
        }
		$this					->	yunset("jobinfo",$jobinfo);
		$this					->	yunset($jobinfo['cache']);
		$this					->	public_action();
		$this					->	seo('rec_user');
		$this					->	lietou_tpl('rec_user');
	}
	function headhunter_action(){

        $lietouM			=	$this		->	MODEL("lietou");
		
		$ltjobM				=	$this		->	MODEL("lietoujob");
        if($this->usertype=="1"){
        	$atnM			=	$this		->	MODEL('atn');
			$atn			=	$atnM		->	getatnInfo(array('uid'=>$this->uid,'sc_uid'=>(int)$_GET['uid']));
			$this			->	yunset('atn',$atn);
        }
        $lietouM			->	upInfo(array('uid'=>(int)$_GET['uid']),array('hits'=>array('+',1)));

        $userinfoM			=	$this		->	MODEL("userinfo");
		$user				=	$userinfoM	->	getInfo(array('uid'=>(int)$_GET['uid']));
		if($user['uid']==''){
			$this			->	ACT_msg($this->config['sy_weburl'],"没有找到相关猎头！");
		}
		$this				->	yunset("user",$user);


		$info				=	$lietouM	->	getInfo(array('uid'=>(int)$_GET['uid']),array('utype'=>'wap','datatype'=>'moreinfo'));

  		$data['lt_name']	=	$info['realname'];
		$this->data			=	$data;
		
		$jobnum				=	$ltjobM		->	getLtjobNum(array('uid'=>$_GET['uid'],'status'=>1,'r_status'=>1));
		$this				->	yunset("jobnum",$jobnum);
		$this				->	yunset("info",$info);
		$this				->	public_action();
		$this				->	seo("headhunter");
		$this				->	lietou_tpl('headhunter');
	}
	function service_action(){
		$this					->	public_action();
        $CacheM					=	$this	->	MODEL('cache');
        $CacheList				=	$CacheM	->	GetCache(array('ltjob','lthy'));
		$this					->	yunset($CacheList);
		if($_GET['hyid']||$_GET['jobid']){
			$this				->	yunset("searchtype","1");
			if($_GET['hyid']){
				$hyid			=	@explode(",",$_GET['hyid']);
				foreach($hyid as $v){
					$hyname[]	=	$CacheList['lthy_name'][$v];
				}
				$this			->	yunset("hyname",@implode(",",$hyname));
			}
			if($_GET['jobid']){
				$jobid			=	@explode(",",$_GET['jobid']);
				foreach($jobid as $v){
					$jobname[]	=	$CacheList['ltjob_name'][$v];
				}
				$this			->	yunset("jobname",@implode(",",$jobname));
			}
		}
		$this					->	yunset('lietou_member_style',TPL_PATH.'member/lietou');
		$this					->	seo('ltservice');
		$this					->	lietou_tpl('service');
	}
	function famous_action(){
		
		$CacheM					=	$this	->	MODEL('cache');
        $CacheList				=	$CacheM	->	GetCache(array('hy','com','city'));
		$this					->	yunset($CacheList);
		if(empty($CacheList['city_type'])){
            $this   ->  yunset('cionly',1);
        }
        $UptimeNameList			=	array(1=>'今天',3=>'最近3天',7=>'最近7天',30=>'最近一个月',90=>'最近三个月');
        if($_GET['cityin']){
            $CityList			=	explode(',',$_GET['cityin']);
            foreach($CityList as $k=>$v){
                $CityNameList[]	=	$CacheList['city_name'][$v];
            }
            $CityName			=	implode('+',$CityNameList);
        }
		
        //当前猎头知名企业所需参数：关键字、企业性质、企业规模、所在城市、所属行业、更新时间
        $FilterList				=array(
        	'keyword'	=>	array(
        		'id'			=>	$_GET['keyword'],
        		'value'			=>	$_GET['keyword'],
        		'desc'			=>	'关键字',
        		'placeholder'	=>	'请输入你要查找的信息'
        	),
            'pr'		=>	array(
            	'id'			=>	$_GET['pr'],
            	'value'			=>	$CacheList['comclass_name'][$_GET['pr']],
            	'desc'			=>	'企业性质',
            	'placeholder'	=>	'请选择企业性质'
            ),
            'mun'		=>	array(
            	'id'			=>	$_GET['mun'],
            	'value'			=>	$CacheList['comclass_name'][$_GET['mun']],
            	'desc'			=>	'企业规模',
            	'placeholder'	=>	'请选择企业规模'
            ),
            'uptime'	=>	array(
            	'id'			=>	$_GET['uptime'],
            	'value'			=>	$UptimeNameList[$_GET['uptime']],
            	'desc'			=>	'更新时间',
            	'placeholder'	=>	'请选择更新时间'
            ),
            'cityin'	=>	array(
            	'id'			=>	$_GET['cityin'],
            	'value'			=>	$CityName,
            	'desc'			=>	'所在地区',
            	'placeholder'	=>	'请选择城市'
            ),
            'hy'		=>	array(
            	'id'			=>	$_GET['hy'],
            	'value'			=>	$CacheList['industry_name'][$_GET['hy']],
            	'desc'			=>	'行业',
            	'placeholder'	=>	'请选择行业'
            )
        );

		$SelectorList['count']	=	0;
        foreach($FilterList as $k=>$v){
            $SelectorList[$k]	=	$v;
            if(!trim($v['value'])){
                unset($FilterList[$k]);
            }else{
                $SelectorList['count']++;
                $SelectorList[$k][3]	=	$v[1];
            }
        }
        $this	->	yunset(array('FilterList'=>$FilterList,'SelectorList'=>$SelectorList,'UptimeNameList'=>$UptimeNameList));

		$this	->	public_action();
		$this	->	seo('ltfamous');
		$this	->	lietou_tpl('famous');
	}
	function register_action(){ 
		$this			->	public_action();
		$this			->	seo('register');
	    
		if($this->config['reg_user_stop']!=1){
			$this		->	lietou_tpl('stopreg');
		}else{ 
			if($this->uid!=""&&$this->username!=""){
				$this->logout(false);
			}
			if($_POST){
				session_start();
				$Member      				=   	$this->MODEL('userinfo');
				$data['usertype']			=		3;
				$data['uid']				=		$this->uid;
				$data['password']			=		$_POST['password'];
				$data['passconfirm']		=		$_POST['passconfirm'];
				$data['username']			=		$_POST['username'];
				$data['email']				=		$_POST['email'];
				$data['realname']			=		$_POST['realname'];
				$data['moblie_code']		=		$_POST['moblie_code'];
				$data['code']				=		$_POST['authcode'];
				$data['codeid']				=		$_POST['codeid'];
				$data['port']				=		'1';
				
				$return 					=		$Member->userRegSave($data);
				
				if($return['errcode']){
					$arr['status']			=		$return['errcode'];
					$arr['msg']  			= 		$return['msg'];
				}else{
					$arr['status']			=		8;
					$arr['msg']  			= 		$return['msg'];
				}
				
				echo json_encode($arr);die;
			}else{
				
				$this->lietou_tpl('register');
			}
		}
	}
	function login_action(){
    	$this		->	yunset("cookie", $_COOKIE['checkurl']);
		
		if($this->uid!=""&&$this->username!=""&&$this->usertype=="3"){
			$this	->	ACT_msg("index.php","您已经登录了！");
		}else{
			$this	->	cookie	->	unset_cookie();
		}
		if($this->uid!=""&&$this->username!=""){
			echo "您已经登录了！";die;
		}
		$this		->	public_action();
		$this		->	seo("login");
    $this->yunset("referurl",$_SERVER['HTTP_REFERER']);
		$this		->	lietou_tpl('login');
	}
	function loginsave_action(){
		$Member					=			$this	->	MODEL('userinfo');
			
		$lData['username']		=			$_POST['username'];
		$lData['uid']			=			$this->uid;
		$lData['usertype']		=			$this->usertype;
		$lData['password']		=			$_POST['password'];
        $lData['referurl']		=			$_POST['referurl'];
		$_POST['authcode']		=			$_POST['authcode'];
		$return					=			$Member->userLogin($lData);
		if($return['errcode']==9){
			echo json_encode(array('url'=>$return['url']));die;
		}else{
			echo json_encode(array('msg'=>$return['msg']));die;
		}
	}
	
	function logout_action(){
		$this->logout();
	}
	
	function favjob_action(){
		$data['job_id']		=	(int)$_POST['id'];
		$data['uid']		=	$this->uid;
		$data['usertype']	=	$this->usertype;
		$data['jobtype']	=	'lt';

		$jobM	=	$this	->	MODEL('job');
		$return	=	$jobM	->	collectJob($data);
		
		echo json_encode($return);
	}
}
?>