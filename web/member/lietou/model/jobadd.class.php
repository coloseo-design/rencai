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
class jobadd_controller extends lietou{
    //职位 status -1为草稿，0为未审核 1为审核通过 2过期 3为未通过
	
	function index_action(){
	     
		$ltM	=	$this -> MODEL('lietou');
		
		$row	=	$ltM -> getInfo(array('uid'=>$this->uid));
		
		$msg	=	array();
		
		$isallow_addjob	=	"1";
		
		if($this->config['lt_enforce_emailcert']=="1"){
			if($row['email_status']!="1"){
				$isallow_addjob	=	"0";
				$msg[]			=	"邮箱认证";
			}
		}
		if($this->config['lt_enforce_mobilecert']=="1"){
			if($row['moblie_status']!="1"){
				$isallow_addjob	=	"0";
				$msg[]			=	"手机认证";
			}
		}
		if($this->config['lt_enforce_licensecert']=="1"){
            $comM   =   $this->MODEL('company');
            $cert   =   $comM -> getCertInfo(array('uid'=>$this->uid,'type'=>4), array('field' => 'uid,status'));

			if($row['yyzz_status']!="1" && (empty($cert) || $cert['status'] == 2)){
				$isallow_addjob	=	"0";
				$msg[]			=	"职业资格认证";
			}
		}
		 
		if($isallow_addjob=="0"){
		    
			$this->ACT_msg('index.php?c=binding',"请先完成".implode("、",$msg)."！");
		}
		
		$info	=	$this->ltInfo;
		$this->yunset("info",$info);
		 
		
		if($info['com_name']==''){
			$this->ACT_msg("index.php?c=info","请先完善基本资料！");
		}
		$static = $this->lt_satic();
		
		if($static['addltjobnum'] == 0){
			$this->ACT_msg("index.php?c=right","会员已到期！",8);
		}
		
		if( $static['addltjobnum'] == 2 ){
			if( $this->config['integral_job']!='0'){
			    
				$this->ACT_msg("index.php?c=right","你的套餐已用完！",8);
			}else{
			    
				$ltM -> upStatis(array('uid'=>$this->uid),array('lt_job_num'=>'1'));
			}
		} 
		$row['edate']=strtotime("+1 month");
		unset($row['provinceid']);
		unset($row['cityid']);
		unset($row['three_cityid']);
		unset($row['exp']);
		$this->yunset("row",$row);
		
		$this->public_action();
		$this->user_shell();
		
		$this->yunset($this->MODEL('cache')->GetCache(array('city','lt','ltjob','lthy','hy')));
		
		$this->lietou_tpl('jobadd');
	}
	function edit_action(){
		
        $info	=	$this->ltInfo;
        $this->yunset("info",$info);
		$row	=	$this -> MODEL('lietoujob') -> getInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid));
		$this->yunset("row",$row);
		$this->yunset("part",$_GET['part']);
		
		$this->yunset($this->MODEL('cache')->GetCache(array('city','lt','ltjob','lthy','hy')));

		$this->user_shell();
		$this->public_action();
		$this->lietou_tpl('jobadd');
	}
	function save_action(){
		$ltjobM	=	$this -> MODEL('lietoujob');
		
		if($_POST['submit']){
			$info	=	$this->ltInfo;
			$rstatus	=	$info['r_status'];
			$_POST	=	$this->post_trim($_POST);

			$post	= 	array(
				'job_name'    	=>	$_POST['job_name'],
				
				'jobone'       	=>	$_POST['jobone'],
				'jobtwo'       	=>	$_POST['jobtwo'],
				
				'department'   	=>	$_POST['department'],
				'report'       	=>	$_POST['report'],

				'provinceid'  	=>	$_POST['provinceid'],
				'cityid'       	=>	$_POST['cityid'],
				'three_cityid'	=>	$_POST['three_cityid'],

				'minsalary'  	=>	$_POST['minsalary'],
				'maxsalary'    	=>	$_POST['maxsalary'],

				'constitute'   	=>	pylode(',',$_POST['constitute']),
				'job_desc'    	=>	$_POST['job_desc'],
				'age'         	=>	$_POST['age'],
				'sex'         	=>	$_POST['sex'],
				'exp'         	=>	$_POST['exp'],
				'edu'         	=>	$_POST['edu'],
				'eligible'    	=>	$_POST['eligible'],
				'welfare'      	=>	pylode(',',$_POST['welfare']),
				'language'     	=>	pylode(',',$_POST['language']),
				'rebates'     	=>	$_POST['rebates'],
				'other'      	=>	$_POST['other'],
				'r_status'      =>	$rstatus,
				'com_name'		=>	$_POST['com_name'],
				'real_name'		=>	$_POST['real_name'],
				'pr'			=>	$_POST['pr'],
				'hy'			=>	$_POST['hyid'],
				'mun'			=>	$_POST['mun'],
				'desc'			=>	$_POST['desc'],

				'lastupdate'  	=>	time(),
				'uid'       	=>	$this->uid,
				'usertype'		=>	$this->usertype,
				'did'			=>	$this->userdid
			);
            $data	=	array(
				'post'	=>	$post,
				'id'	=>	(int)$_POST['id']
			);
			
			$return	=	$ltjobM->addLtJobInfo($data);

          	if($return['url']){
				$this->ACT_layer_msg($return['msg'],$return['errcode'],$return['url']);
			}else{
				$this->ACT_layer_msg($return['msg'],$return['errcode']);
			}
		}
	}
	
	/**
	 *  @desc 发布职位条件查询
	 */
	function jobCheck_action()
	{
	    
	    $jobM   =   $this->MODEL('job');
	    $statisM=   $this->MODEL('statis');
	    
	    $statis =   $statisM -> getInfo($this->uid, array('usertype' => 3, 'field' => '`integral`'));
	    $result =   $jobM->getAddJobNeedLtInfo($this->uid, 1);
	    
	    $return =   array(
	        
	        'msgList'   =>  $result['pc'],
	        'integral'  =>  (int)$statis['integral']
	    );
	    
	    echo json_encode($return);
	    
	    die();
	    
	}
}
?>