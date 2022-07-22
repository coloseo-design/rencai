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
class train_controller extends wap_controller{

	function waptpl($tpname){

		$this->yuntpl(array('wap/member/train/'.$tpname));
	}
	function index_action(){

		$TrainM						= 	$this->MODEL('train');	
		$UserinfoM				 	=	$this->MODEL('userinfo');
		
		$where['uid']				=	$this->uid;
		$info						=	$TrainM->getInfo($where,array('utype'=>'user'));
		$this->yunset("info",$info);
		
		$regwhere['uid']			=	$this->uid;
		$regwhere['usertype']		=	$this->usertype;
		$regwhere['date']			=	date("Ymd");
		$reg						=	$UserinfoM->getMemberregInfo($regwhere); 
		if($reg['id']){
			$signstate				=	1;
		}else{
			$signstate				=	0;
		}
		$this->yunset("signstate",$signstate);
		
		$backurl					=	Url('wap',array());
		$this->yunset('backurl',$backurl);
		$this->yunset('membernav', 1);
		
		$this->waptpl('index');
	}

	function info_action(){

		$TrainM	 =  $this->MODEL('train');

		if($_POST['submit']){
			$pinfo		=	$this->pxInfo;
			
			if($pinfo){
				$rstaus     =   $pinfo['r_status'];
			}else{
				$rstaus		=	$this->config['px_status'];
			}
			$_POST		=	$this -> post_trim($_POST);
			$mData		=	array(
				'moblie'		=>	$_POST['linktel'],
				'email'		    =>	$_POST['linkmail']
			);
			$trainData	=	array(
				'name'			=>	$_POST['name'],
				'sid'			=>	$_POST['sid'],
				'pr'			=>	$_POST['pr'],
				'provinceid'	=>	$_POST['provinceid'],
				'cityid'		=>	$_POST['cityid'],
				'threecityid'	=>	$_POST['threecityid'],
				'mun'			=>	$_POST['mun'],
				'address'		=>	$_POST['address'],
				'linkman'		=>	$_POST['linkman'],
				'linkphone'		=>	$_POST['linkphone'],
				'linktel'		=>	$_POST['linktel'],
				'sdate'			=>	$_POST['sdate'],
				'content' 		=>	str_replace(array("&amp;",'background-color:#ffffff','background-color:#fff','white-space:nowrap;'),array('&','background-color:','background-color:','white-space:'),$_POST['content']),
				'linkmail'		=>	$_POST['linkmail'],
				'linkqq'		=>	$_POST['linkqq'],
				'website'		=>	$_POST['website']
			);
			if(!$this -> pxInfo['uid']){
				$userinfoM    =   $this->MODEL("userinfo");
				$userinfoM -> activUser($this->uid,4);
			}
			$return  =	$TrainM	-> upTrainInfo(array('uid'=>$this->uid),array('trainData'=>$trainData,'mData'=>$mData,'utype'=>'user'));
		  if($return['url']){
				$return['url']  =  'index.php';//当修改成功 跳转到这个链接
		  }else{
			$retrun['url']='';//防止在保存数据 出现座机存在或者其他存在，跳转到首页
		  }
			
			
			echo json_encode($return);die;
		}
		$row				=	$TrainM->getInfo(array('uid'=>$this->uid),array('utype'=>'user'));
		$this	->	yunset("row",$row);
		
		$this	->	yunset($this->MODEL('cache')->GetCache(array('com','city','subject')));

		$this	->	yunset('header_title',"基本信息");
		$this	->	waptpl('info');
	}

	function subject_action(){

		$TrainM	=	$this->MODEL('train');
		$LogM	=	$this->MODEL('log');
		if((int)$_GET['pause_status']){

			$pswhere['id']	=	(int)$_GET['id'];
			$pswhere['uid']	=	$this->uid;
			$data			=	array(
				'pause_status'	=>	(int)$_GET['pause_status']	
			);
			$nid			=	$TrainM->upSubInfo($pswhere,$data);
			if($nid){
				
				$LogM->addMemberLog($this->uid,$this->usertype,"设置培训课程显示状态",21,3);
				$this->layer_msg('显示状态设置成功！',9,0,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('显示状态设置失败！',8,0,$_SERVER['HTTP_REFERER']);
			}
		}

		if($_GET['del']){
			
			$return	=	$TrainM->delsubInfo((int)$_GET['del'],array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}
		
		if($_GET['status']=="1"){
			$where['status']		=	0;
			$where['pause_status']	=	1;
			$urlarr['status']		=	intval($_GET['status']);

		}elseif($_GET['status']=="2"){
	
			$where['status']		=	2;
			$where['pause_status']	=	1;
			$urlarr['status']		=	intval($_GET['status']);
		}else{
			$where['status']		=	1;
			$where['pause_status']	=	1;
		}
		if($_GET['pstatus'] == "2"){
			
			$where['pause_status']	=	2;
			$urlarr['pstatus']		=	$_GET['pstatus'];
		}		

		$where['uid']		=	$this->uid;
		$urlarr['c']		=	"subject";
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url('wap',$urlarr,'member');
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_subject',$where,$pageurl,$_GET['page']);

		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows				=	$TrainM->getSubList($where);
		$this->yunset("rows",$rows);

		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"课程管理");
		
		$this->waptpl('subject');
	}

	function addsubject_action(){

		$TrainM		=	$this->MODEL('train');
		$UserinfoM	=	$this->MODEL('userinfo');
		$train		=	$UserinfoM->getUserInfo(array('uid'=>$this->uid),array('usertype'=>'4','field'=>'name,r_status'));
		$this->yunset("train",$train);
		if($train['name']==""){

			$data['msg']	=	"";
			$data['url']	=	'index.php?c=info';
			$this->yunset("layer",$data);
			$this->Act_msg_wap(Url('wap',array('c' => 'info'),'member'), '请先完善基本资料！', 2, 5);
		}
		$teach	=	$TrainM->getPxTeacherNum(array('uid'=>$this->uid,'status'=>1));
		$this->yunset("teach",$teach);
		
		$tinfo	=	$TrainM->getTeaList(array('uid'=>$this->uid,'status'=>1),array('field'=>'id,name'));
		$this->yunset("teachinfo",$tinfo);
	
		if($_POST['submit']){
			$pinfo		=	$this->pxInfo;
			$rstatus	=	$pinfo['r_status'];
			$_POST	=	$this->post_trim($_POST);
			$post	=	array(
				'name'			=>	$_POST['name'],
				'nid'			=>	$_POST['nid'],
				'tnid'			=>	$_POST['tnid'],
				'provinceid'	=>	$_POST['provinceid'],
				'cityid'		=>	$_POST['cityid'],
				'threecityid'	=>	$_POST['threecityid'],
				'address'		=>	$_POST['address'],
				'hours'			=>	$_POST['hours'],
				'price'			=>	$_POST['price'],
				'isprice'		=>	$_POST['isprice'],
				'moblie'		=>	$_POST['moblie'],
				'crowd'			=>	$_POST['crowd'],
				'superiority'	=>	$_POST['superiority'],
				'content'		=>	$_POST['content'],
				'type'			=>	pylode(',',$_POST['type']),
				'teachid'		=>	pylode(',',$_POST['teachid']),
				'status'		=>	0,
				'base'			=>	$_POST['preview'],
				'r_status'		=>	$rstatus
			);

			$data	=	array(
				'post'		=>	$post,
				'id'		=>	(int)$_POST['id'],
				'uid'		=>	$this->uid,
				'usertype'	=>	$this->usertype,
				'did'		=>	$this->userdid
			);
			$return			=	$TrainM->addSubjectInfo($data);

			$data['url']	=	'index.php?c=subject&status=1';

			echo json_encode($return);die;
		}
		$row	=	$TrainM->getSubInfo(array('id'=>(int)($_GET['id']),'uid'=>$this->uid));
		if($row['type']){
			$row['typeid']	=	@explode(",",$row['type']);
		}
		if($row['teachid']){
			$row['teach']	=	@explode(",",$row['teachid']);
		}
		
		if($row['content']){
			$row['content_tags']	=	strip_tags($row['content']);
		}
		$this->yunset("row",$row);

		$this->yunset($this->MODEL('cache')->GetCache(array('city','subject','subjecttype')));

		$this->yunset('header_title',"发布课程");
		$this->waptpl('addsubject');
	}

	function uppic_action(){

		$TrainM		=	$this -> MODEL('train');

		if($_POST['submit']){

			if(!$this -> pxInfo['uid']){
				$userinfoM    =   $this->MODEL("userinfo");
				$userinfoM -> activUser($this->uid,4);
			}

			$return   =  $TrainM -> upLogo(array('uid'=>$this->uid),array('utype'=>'user','base'=>$_POST['uimage']));

			$this->layer_msg($return['msg'],$return['errcode']);
		}else{

			$px_train	=	$TrainM	->	getInfo(array('uid'=>$this->uid),array('field'=>'`logo`,`logo_status`','utype'=>'user'));
			$this -> yunset("px_train",$px_train);

			$backurl	=	Url('wap',array(),'member');
			$this -> yunset('backurl',$backurl);

			
			$this -> yunset('header_title',"机构LOGO");
			$this -> waptpl('uppic');
		}	
	}

	function signup_action(){

		$TrainM			=	$this->MODEL('train');
		$CompanyorderM	=	$this->MODEL('companyorder');
		$LogM			=	$this->MODEL('log');
		
		$statuss		=	intval($_GET['status']);

		if($statuss	=="1"){

			$pxbwhere['id']		=	$_GET['id'];
			$pxbwhere['s_uid']	=	$this->uid;
			$pxbdata	=	array(
				'status'	=>	$statuss
			);
			$oid	=	$TrainM->upBmInfo($pxbwhere,$pxbdata);

			if($oid){

				$LogM->addMemberLog($this->uid,$this->usertype,"报名信息设为已联系",6,2);
	
				$this->layer_msg('设置成功！',9,0,"index.php?c=signup");
			}else{
				$this->layer_msg('设置失败！',8,0,"index.php?c=signup");
			}
		}
		if($_GET['delid']){
			$delid	=	(int)$_GET['delid'];

			$delRes	=	$TrainM->delBm(array('id' => $delid),array('usertype'=>$this->usertype,'s_uid'=>$this->uid));

			if($delRes['errcode'] == 9){
				$this->layer_msg('删除成功！',9,0,"index.php?c=signup");

			}else{

				$this->layer_msg('删除失败！',8,0,"index.php?c=signup");

			}
		}

		$where['s_uid']	=	$this->uid;
		$state			=	intval($_GET['state']);

		if($state=="1"){
			
			$where['status']	=	1;
			$urlarr['state']	=	$state;

		}elseif($state=="2"){
			
			$where['status']	=	0;
			$urlarr['state']	=	$state;
		}

		$urlarr['c']	=	"signup";
		$urlarr['page']	=	"{{page}}";
		$pageurl		=	Url('wap',$urlarr,'member');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_baoming',$where,$pageurl,$_GET['page']);

		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows	=	$TrainM->getBmList($where);

		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);

		if(is_array($rows)){

			foreach($rows as $v){

				$sid[]	=	$v['sid'];
				$ids[]	=	$v['id'];
			}
			$pxswhere['id']	=	array('in', pylode(',', $sid));
			$subject		=	$TrainM->getSubList($pxswhere,array('field'=>'id,name,isprice'));

			$cwhere['sid']	=	array('in', pylode(',', $ids));
			$order			=	$CompanyorderM->getList($cwhere);

			foreach($rows as $k=>$v){

				foreach($subject as $val){

					if($v['sid']==$val['id']){

						$rows[$k]['sub_name']	=	$val['name'];
						$rows[$k]['isprice']	=	$val['isprice'];
					}
				}
				foreach($order as $val){

					if($v['id']==$val['sid']){

						$rows[$k]['order_state']=$val['order_state'];
					}
				}
			}
		}

		$this->yunset("rows",$rows);

		$this->yunset('header_title',"课程预约");
		$this->waptpl('signup');
	}

	function subpay_action(){

		$CompanyOrderM	=	$this->MODEL('companyorder');
		$StatisM		=	$this->MODEL('statis');

		$uid			=	$this->uid;
		//查询账户余额信息
		$statis				=	$StatisM->getInfo($uid,array('usertype'=>'4'));
		$statis['freeze']	=	sprintf("%.2f", $statis['freeze']);
		$this->yunset("statis",$statis);

		$where['com_id']		=	$uid;
		$where['usertype']		=	$this -> usertype;
		$where['type']			=	2;
		$where['pay_remark']	=	array('like','报名费');
		//红包收益
		$urlarr['c']	=	$_GET['c'];
		$urlarr["page"]	=	"{{page}}";
		$pageurl		=	Url('wap',$urlarr,'member');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('pay_time,desc');

        $rows	            =	$CompanyOrderM->getPayList($where);
		$this->yunset("rows",$rows);
		
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"金额管理");
		$this->waptpl('subpay');
	}

	function change_action(){
		
		$StatisM		=	$this->MODEL('statis');
		$CompanyOrderM	=	$this->MODEL('companyorder');

		//查询账户余额信息
		$statis	=	$StatisM->getInfo($this->uid,array('usertype'=>'4'));
		$this->yunset("statis",$statis);

		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);
		$where['pay_time']		=	array('>=',strtotime(date("Y-m-d 00:00:00")));

		$changeNum	=	$CompanyOrderM->getCompanyPayNum($where);
		$this->yunset("changeNum",$changeNum);

		
		$backurl=Url('wap',array('c'=>'subpay'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"金额转换".$this->config['integral_pricename']);
		$this->waptpl('change');
	}
	/**
	 * 执行转换积分
	 */
	function saveChange_action(){
	    
	    if($_POST){
	        $data['changeprice']	=	$_POST['changeprice'];
	        $data['changeintegral']	=	$_POST['changeintegral'];
	        $data['uid']			=	$this	->	uid;
	        $data['usertype']		=	$this	->	usertype;
	        $packM					=	$this	->	MODEL('pack');
	        $return					=	$packM	->	saveChange($data);
	        
	        echo json_encode($return);
	    }
	}
	function changelist_action(){
		
		$CompanyOrderM	=	$this->MODEL('companyorder');
		$StatisM		=	$this->MODEL('statis');

		$uid			=	$this->uid;

		$where['com_id']		=	$uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);

		$urlarr["c"]	=	"changelist";
		$urlarr["page"]	=	"{{page}}";
		$pageurl		=	Url('wap',$urlarr,'member');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('pay_time,desc');

		$rows	=	$CompanyOrderM->getPayList($where);
		$this->yunset("rows",$rows);

		$statis	=	$StatisM->getInfo($uid,array('usertype'=>4));
		$this->yunset("statis",$statis);
		
		$this->yunset('header_title',"金额转换".$this->config['integral_pricename']."明细");
		$this->waptpl('changelist');
	}
	//提现
	function withdraw_action(){

		//查询账户余额信息
		$PackM	=	$this->MODEL('pack');

		if($_POST){
			$return	=	$PackM->withDraw($this->uid,$this->usertype,$_POST['price'],$_POST['real_name']);
	
			if($return['errcode']==1){
				//提现成功
				$data['msg']	=	'提现成功，请关注微信账户提醒！';
				$data['url']	=	'index.php?c=withdrawlist';
				$this->yunset("layer",$data);
			}else{
				//生成失败 返回具体原因
				$data['msg']	=	$return['msg'];
				$data['url']	=	'index.php?c=withdraw';
				$this->yunset("layer",$data);
			}
		}else{
			$StatisM	=	$this->MODEL('statis');
			$uid		=	$this->uid;
			//查询账户余额信息
			$statis		=	$StatisM->getInfo($uid,array('usertype'=>'4'));
			$this->yunset("statis",$statis);
		}
		$backurl	=	Url('wap',array('c'=>'subpay'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"提现");
		$this->waptpl('withdraw');
	}

	function withdrawlist_action(){

		$PackM		=	$this->MODEL('pack');
		$StatisM	=	$this->MODEL('statis');

		$uid				=	$this->uid;
		$where['uid']		=	$uid;

		$urlarr["c"]		=	"withdrawlist";
		$urlarr["page"]		=	"{{page}}";
		$pageurl			=	Url('wap',$urlarr,'member');
		$pageM				=	$this -> MODEL('page');
		$pages				=	$pageM -> pageList('member_withdraw',$where,$pageurl,$_GET['page']);
	
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows	=	$PackM->getList($where);
		$this->yunset("rows",$rows);
		//查询账户余额信息
		$statis	=	$StatisM->getInfo($uid,array('usertype'=>'4'));
		$this->yunset("statis",$statis);
		
		$backurl=Url('wap',array('c'=>'subpay'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"提现明细");
		$this->waptpl('withdrawlist');

	}

	function team_action(){

		$trainM	=	$this	->	MODEL('train');

		if($_GET['del']){
			$return	=	$trainM	->	delTea(array('id'=>(int)$_GET['del'],'uid'=>$this->uid),array('member'=>'train','uid'=>$this->uid,'usertype'=>$this->usertype));

			$this -> layer_msg($return['msg'],$return['cod'],$return['laytype'],$return['url']);
		}
		$where['status']	=	isset($_GET['status'])	?	intval($_GET['status']) : '1';
		$where['uid']		=	$this->uid;
		$where['orderby']	=	'id,desc';

		$urlarr['c']		=	$_GET['c'];
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url('member',$urlarr);
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_teacher',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){

			$where['limit']	=	$pages['limit'];

			$rows			=	$trainM	->	getTeaList($where);

			$this -> yunset("rows",$rows);
		}
		$this -> yunset($this->MODEL('cache')->GetCache(array('city','hy','subject')));

		$backurl	=	Url('wap',array(),'member');
		$this -> yunset('backurl',$backurl);
		
		$this -> yunset('header_title',"讲师管理");
		$this -> waptpl('team');
	}

	function addteam_action(){

		$trainM	=	$this -> MODEL('train');

		if($_POST['submit']){

			$_POST	=	$this -> post_trim($_POST);
			$pinfo					=	$this->pxInfo;
			$rstatus				=	$pinfo['r_status'];
			$rows	=	$trainM -> getTeaInfo(array('id'=>(int)$_POST['id'],'uid'=>$this->uid,'pic'=>array('<>','')));
			
			$data['base']			=	$_POST['preview'];
			$data['name']			=	$_POST['name'];
			$data['sid']			=	$_POST['sid'];
			$data['hy']				=	$_POST['hy'];
			$data['provinceid']		=	$_POST['provinceid'];
			$data['cityid']			=	$_POST['cityid'];
			$data['threecityid']	=	$_POST['threecityid'];
			$data['content']		=	$_POST['content'];
			$data['r_status']		=	$rstatus;
			$data['ctime']			=	time();
			$data['status']			=	0;
			if($_POST['id']){

				if($data['msg']==""){

					$where['uid']	=	$this -> uid;
					$where['id']	=	$_POST['id'];
					$data			=	$trainM -> upTeaInfo(array('id'	=>$_POST['id'],'uid'=>$this->uid),$data,array('uid'=>$this->uid,'usertype'=>	$this->usertype,'member'=>'train','wap'=>'1'));
				}else{
					$data['msg']	=	$data['msg'];
				}
			}else{

				if($data['msg']==""){
					$data['uid']	=	$this -> uid;
					$where['uid']	=	$this -> uid;
					$where['did']	=	$this -> userdid;
					$data			=	$trainM -> addTeaInfo($data,array('uid'=>	$this->uid,'usertype'=>$this->usertype,'member'=>'train','wap'=>'1'));
				}else{
					$data['msg'] 	=	$data['msg'];
				}
			}
			echo json_encode($data);die;
		}

		if((int)$_GET['id']){

			$row	=	$trainM	->	getTeaInfo(array('id'=>(int)$_GET['id'],'uid'=>$this->uid));
			$this -> yunset("row",$row);
		}
		$defaultpic    =   checkpic('',$this->config['sy_pxteacher_icon']); 
		$this -> yunset("defaultpic",$defaultpic);
		$this -> yunset($this->MODEL('cache')->GetCache(array('city','hy','subject')));
		
		$this -> yunset('header_title',"发布讲师");
		$this -> waptpl('addteam');
	}
	function password_action(){

		$backurl	=	Url('wap',array(),'member');
		$this -> yunset('backurl',$backurl);
		
		$this -> yunset('header_title',"修改密码");
		$this -> waptpl('password');
	}

	function binding_action(){

		$TrainM	=	$this	->	MODEL('train');
		$userM	=	$this	->	MODEL('userinfo');
		$comM   =   $this 	-> 	MODEL('company');
	
		if($_POST['moblie']){//手机绑定
	
			$CookieM	=	$this->MODEL('cookie');
			$CookieM -> SetCookie('delay', '', time() - 60);
	
			$CompanyM	=	$this->MODEL('company');
	
			$data	=	array(
				'uid'		=>	$this -> uid,
				'usertype'	=>	$this -> usertype,
				'moblie'	=>	$_POST['moblie']
			);
			$errCode	=	$CompanyM -> upCertInfo(array('uid'=> $this->uid, 'check2' => $_POST['code']), array('status'=>'1'), $data);
	
			echo $errCode; die;
		}
		if($_GET['type']){//解除绑定

			$return	=	$comM -> delBd($this->uid,array('type'=>$_GET['type'],'usertype'=>$this->usertype));

			$this -> waplayer_msg($return['msg']);
		}
		$member	=	$userM	->	getInfo(array('uid'=> $this->uid), array('setname'=>'1'));
		$this	->	yunset("member",$member);
		$train	=	$TrainM	->	getInfo(array('uid'=>$this->uid));	
		$this	->	yunset("train",$train);	
		
		$cert	=	$comM 	-> 	getCertInfo(array('uid'=>$this->uid,'type'=>'5'));
		$this	->	yunset("cert",$cert);
		
		$backurl	=	Url('wap',array(),'member');
		$this	->	yunset('backurl',$backurl);
		
		$this	->	yunset('header_title',"账户绑定");
		$this	->	waptpl('binding');
	}	
	function bindingbox_action(){
		
		$userM		=	$this -> MODEL('userinfo');
		$member		=	$userM -> getInfo(array('uid'=> $this->uid));
		$this -> yunset("member",$member);
	
		$backurl	=	Url('wap',array('c'=>'binding'),'member');
		$this -> yunset('backurl',$backurl);
		
		$this -> yunset('header_title',"账户绑定");
		$this -> waptpl('bindingbox');
	}
	function message_action(){
		
		$TrainM		=	$this->MODEL('train');
		$UserinfoM	=	$this->MODEL('userinfo');
		$LogM		=	$this->MODEL('log');

		$id			=	(int)$_POST['id'];
		$uid		=	$this->uid;

		if($_GET['reply']){

			if($_POST['content']==''){

				$data['msg']	=	'回复内容不能为空！';
			}
			if ($data['msg']==''){
				$where['id']	=	$_POST['id'];
				$where['s_uid']	=	$this->uid;
				$data	=	array(
					'reply'			=>	trim($_POST['content']),
					'reply_time'	=>	time(),
					'status'		=>	2
				);

				$nid	=	$TrainM->upPxzixun($where,$data);

				if($nid){

					$LogM->addMemberLog($this->uid,$this->usertype,"回复咨询留言",18,1);

					$data['msg']	=	'回复成功！';
					$data['url']	=	$_SERVER['HTTP_REFERER'];
				
				}else{

					$data['msg']	=	'回复失败！';
					$data['url']	=	$_SERVER['HTTP_REFERER'];
				}
			}

			echo json_encode($data);exit;
			// $this->yunset("layer",$data);
		}

		if($_GET['del']){

			$tid	=	(int)$_GET['del'];
			$return	=	$TrainM -> delPxzx($tid,array('uid'=>$this->uid,'usertype'=>$this->usertype));

			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype']);
		}
		$where['s_uid']		=	$this->uid;
		if($_GET['status']){

			$status				=	intval($_GET['status']);
			$where['status']	=	$status;
			$urlarr['status']	=	$status;
		}
		$urlarr['c']		=	$_GET['c'];
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url('wap',$urlarr,'member');
		$pageM			  	=	$this  -> MODEL('page');
		$pages			 	=	$pageM -> pageList('px_zixun',$where,$pageurl,$_GET['page']);

		$where['limit']   	=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows				=	$TrainM->getPxzxList($where);

		if(is_array($rows)){

			foreach($rows as $v){

				$uids[]	=	$v['uid'];
			}
			$mwhere['uid']	=	array('in', pylode(',', $uids));

			$minfo			=	$UserinfoM->getList($mwhere,array('field'=>'uid,username'));

			foreach($rows as $k=>$v){

				foreach($minfo as $val){

					if($v['uid']==$val['uid']){

						$rows[$k]['nickname']	=		$val['username'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);

		$backurl=Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"咨询留言");
		$this->waptpl('message');
	}

	function show_action(){
		
		$trainM	=	$this -> MODEL('train');
	
		if($_GET['del']){//删除环境
	
			$return	=	$trainM	->	delPxshowInfo(array('id'=>(int)$_GET['del'],'member'=>'1','uid'=>$this->uid,'usertype'	=>	$this->usertype));
			
			$this -> layer_msg($return['msg'],$return['cod']);
		}
		//环境列表
		$urlarr['c']		=	"show";
		$urlarr["page"]		=	"{{page}}";
		$pageurl			=	Url('wap',$urlarr,'member');
		$where['uid']		=	$this->uid;
		$where['orderby']	=	'id,desc';
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_train_show',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
			$where['limit']		=	$pages['limit'];
			$rows				=	$trainM	->	getPxshowList($where);
			$this	->	yunset("rows",$rows);
		}
		$this	->	yunset('backurl','index.php');
		$this	->	yunset('header_title',"机构环境");
		$this	->	waptpl('show');
	}
	function addshow_action(){

        if($_POST['submit']){

            $trainM	=	$this -> MODEL('train');

            $info	=	$trainM -> getInfo(array('uid'=>$this->uid));

            if($_POST['preview']){
                //  实例化上传类
                $data   =   array(
                    'title'     =>  $_POST['title'],
                    'ctime'     =>  time(),
                    'status'    =>  $info['r_status'] == 0 ? 1 : $this->config['px_show_status'],
                    'uid'       =>  $this->uid,
                    'base'      =>  $_POST['preview']
                );

                $trainM =	$this	->	MODEL('train');
                $trainM	->	addPxshowInfo($data,array('member' => 'train', 'uid' =>	$this->uid, 'usertype' => $this->usertype, 'type' => 'wap'));
                $data['msg']	=	'上传机构环境成功！';
                $data['url']	=	'index.php?c=show';
            }else{

                $data['msg']	=	'请上传机构环境！';
                $data['url']	=	'index.php?c=addshow';
            }
            echo json_encode($data);exit;
            // $this -> yunset("layer",$data);
        }

        $backurl    =   Url('wap',array('c'=>'show'),'member');
        $this->yunset('backurl',$backurl);

        $this->yunset('header_title',"上传机构环境");
        $this->waptpl('addshow');

	}
	/**
      * @desc 处理单个图片上传
      * @param file/需上传文件; dir/上传目录; type/上传图片类型; base/需上传base64; preview/pc预览即上传
     */
    private function upload($data = array('file'=>null,'dir'=>null,'type'=>null,'base'=>null,'preview'=>null)){
          
        include_once('upload.model.php');
          
        $UploadM  =  new upload_model($this->db, $this->def);
          
        $upArr  =  array(
            'file'     =>  $data['file'],
            'dir'      =>  $data['dir'],
            'type'     =>  $data['type'],
            'base'     =>  $data['base'],
            'preview'  =>  $data['preview']
        );
        $return  =  $UploadM -> newUpload($upArr);
        return $return;
    }
	function reward_list_action(){
		
		$redeemM				=	$this->MODEL('redeem');
		$StatisM				=	$this->MODEL('statis');
	
		$uid					=	$this->uid;
		$where['uid']			=	$uid;
		$where['usertype']      =	$this->usertype;
		
		$urlarr['c']			=	'reward_list';
		$urlarr['page']			=	'{{page}}';
		$pageurl				=	Url('wap',$urlarr,'member');
		$pageM			      	=	$this  -> MODEL('page');
		$pages			     	=	$pageM -> pageList('change',$where,$pageurl,$_GET['page']);

		$where['limit']   		=	$pages['limit'];
		$where['orderby']		=	array('id,desc');

		$rowlist				=	$redeemM->getChangeList($where, array('utype'=>'wap'));
		$rows					=	$rowlist['list'];
		$this->yunset(array('dh'=>$rowlist['dh'],'sh'=>$rowlist['sh'],'wtg'=>$rowlist['wtg']));

		$statis				=	$StatisM->getInfo($uid,array('usertype'=>'4'));
		$statis[integral]	=	number_format($statis[integral]);
		$this->yunset("statis",$statis);

		$this->yunset('rows',$rows);

		$backurl=Url('wap',array('c'=>'integral'),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',"兑换记录");
		$this->waptpl('reward_list');
	}
	function rewarddel_action(){
		
		if(empty($_GET['id'])){
			$this->waplayer_msg('参数异常！');
		}else{
			$redeemM	=	$this->MODEL('redeem');

			$data		=	array(
			    'member'=>'train',
			    'uid'=>$this->uid,
			    'id'=>(int)$_GET['id'],
			    'usertype'=>$this->usertype
			);
			$whereData = ['uid'=>$this->uid, 'id'=>(int)$_GET['id'], 'usertype'=>$this->usertype]; 

			$return		=	$redeemM->delChange($whereData, $data);
		
			$this->layer_msg($return['msg'],$return['errcode'],0,$_SERVER['HTTP_REFERER']);
		}
	}

	function cert_action(){

		$TrainM		    =   $this->MODEL('train');
      
        $where['uid']   =   $this->uid;
    
		$train		    =   $TrainM	->	getInfo($where,array('field'=>'`name`,`yyzz_status`,`r_status`'));
    
		if($_POST['submit']){

			$CookieM   	=   $this->MODEL('cookie');

			$CookieM   	->  SetCookie('delay', '', time() - 60);
			
			$ComapnyM  	=   $this->MODEL('company');
			
			$uid       	=   intval($this->uid);
			
			$usertype  	=   intval($this->usertype);

			$row       	=   $ComapnyM -> getCertInfo(array('uid'=>$uid, 'type' => '5'));

			if($train['r_status']==0){
				
				$status	=	$train['r_status'];
			}else{
				
				$status	=	$this -> config['px_cert_status'] == '1' ? 0 : 1;
			}

			 /* 更新培训执照参数整理  */
			$upData     =   array(
			
				'status'       =>  $status,

				'base'         =>  $_POST['preview'],

				'check2'	   =>  '0',

				'step'		   =>  '1',

				'ctime'        =>  time()

			);

			/* 自定义参数整理  */
			$pdata       =   array(
				
					'yyzz'      =>  '1',

					'type'      =>  '5',
				
					'usertype'  =>  $usertype,
				
					'px_name'   =>  trim($_POST['name'])
				
			);

			if (!empty($row) && is_array($row) && $row['ctime']) {
				
				$err =   $ComapnyM -> upCertInfo(array('id'=>intval($row['id']) , 'uid' => $uid), $upData, $pdata);
				
			}else{
	
				/* 新增培训执照参数补充，包含自定义查询参数  */
				$postData   =   array(

                    'type'      =>  '5',

                    'uid'       =>  $uid,

                    'did'       =>  $this->userdid,

                    'usertype'  =>  $usertype,

                    'px_name'   =>  trim($_POST['name'])
				);

				$postData   =  		 array_merge($postData, $upData);

				$err        =  		 $ComapnyM -> addCertInfo($postData);

			}

			$data['msg']	=		$err['msg'] ?	$err['msg']	:	'';

			$data['url']	=		'index.php?c=cert';
		}
		
		$comM  				=   	$this 	-> 	MODEL('company');

		$cert				=		$comM 	-> 	getCertInfo(array('uid'=>$this->uid,'type'=>'5'));

		$this	->	yunset("train",$train);

		$this	->	yunset("cert",$cert);

		$this	->	yunset("layer",$data);

		$this	->	yunset("backurl","index.php?c=binding");

		

		$this	->	yunset('header_title',"培训执照");

		$this	->	waptpl('pxcert');
	}

	function sysnews_action(){

		$SysmsgM	=	$this->MODEL('sysmsg');
		$TrainM		=	$this->MODEL('train');
		//私信
		
		$where['fa_uid']	=	$this->uid;
		$where['usertype']	=	$this->usertype;
		$where['orderby']	=	array("ctime,desc");
		$sxrows	=	$SysmsgM->getSysmsgInfo($where);
		$sxrows['content']  =  strip_tags($sxrows['content']);
		$this->yunset('sxrows',$sxrows);

		$numwhere['fa_uid']			=	$this->uid;
		$numwhere['usertype']		=	$this->usertype;
		$numwhere['remind_status']	=	0;
		$sxrowsnum	=	$SysmsgM->getSysmsgNum($numwhere);
		$this->yunset('sxrowsnum',$sxrowsnum);
		//课程预约	
		$pxbwhere['s_uid']		=	$this->uid;
		$pxbwhere['orderby']	=	array('ctime,desc');
		$baoming	=	$TrainM->getBmInfo($pxbwhere);
		$this->yunset('baoming',$baoming);

		$subject	=	$TrainM->getSubInfo(array('uid'=>$this->uid));
		$this->yunset('subject',$subject);

		$pxbnumwhere['s_uid']	=	$this->uid;
		$pxbnumwhere['status']	=	0;
		$wlnum	=	$TrainM->getPxBaomingNum($pxbnumwhere);
		$this->yunset('wlnum',$wlnum);
		//咨询留言
		$pzwhere['s_uid']	=	$this->uid;
		$pzwhere['orderby']	=	array('ctime,desc');
		$zxrows	=	$TrainM->getPxzixunInfo($pzwhere);
		$this->yunset("zxrows",$zxrows);

		$zwhere['s_uid']	=	$this->uid;
		$zwhere['status']	=	1;
		$zxnum	=	$TrainM->getZixungNum($zwhere);
		$this->yunset("zxnum",$zxnum);

		$backurl=Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"系统消息");
		$this->waptpl('sysnews');
	
	}
	//私信
	function sxnews_action(){

		$SysmsgM		=	$this->MODEL('sysmsg');
		
		$where['fa_uid']	=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['c']	=	$_GET['c'];
		$urlarr["page"]	=	"{{page}}";
		$pageurl		=	Url('wap',$urlarr,'member');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('sysmsg',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
    		$where['limit']		=	$pages['limit'];
    		$where['orderby']	=	array('id,desc');
    		$rows	=	$SysmsgM->getList($where, array('from' => 'wap_member'));
		}
		$this->yunset("rows",$rows);

		$backurl=Url('wap',array('c'=>'sysnews'),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"私信");
		$this->waptpl('sxnews');
	}	

	function sxnewsset_action(){

		$SysmsgM	=	$this->MODEL('sysmsg');

		$id			=	(int)$_POST['id'];
		
		$where['id']			=	$id;
		$where['fa_uid']		=	$this->uid;
		$where['remind_status']	=	0;

		if($id){
			$nid	=	$SysmsgM->upSysmsg($where,array('remind_status'=>(int)$_POST['remind_status']));
			$LogM   =   $this->MODEL('log');
			$LogM->addMemberLog($this->uid,$this->usertype,"更改系统消息状态（ID:".$id."）",18,2);
		}
		$nid?$this->waplayer_msg("操作成功！"):$this->waplayer_msg("操作失败！");
	}
		
	function delsxnews_action(){

		$SysmsgM	=	$this->MODEL('sysmsg');
		$LogM		=	$this->MODEL('log');
		
		if($_GET['id']){

			$del	=	(int)$_GET['id'];
			$delRes	=	$SysmsgM->delInfo($del,array('fa_uid'=>$this->uid));
			
			$LogM->addMemberLog($this->uid,$this->usertype,"报名信息设为已联系",18,3);

			$this->layer_msg( $delRes['msg'], $delRes['errcode'],0,"index.php?c=sysnews");
		} 
	}

	function integral_action(){

		$IntegralM	=	$this->MODEL('integral');
		
		$statusList	=	$IntegralM -> integralMission(array('type'=>'train','uid'=>$this->uid,'usertype'=>$this->usertype));
		$StatisM	=	$this->MODEL('statis');
		
		$statis		=	$StatisM->getInfo($this->uid,array('usertype'=>'4'));
		$this->yunset("statis",$statis);
		$this->yunset("statusList",$statusList);
		
		$backurl	=	Url('wap',array(),'member');
		$this->yunset('backurl',$backurl);
		
		$this->yunset('header_title',$this->config['integral_pricename']."管理");
		$this->waptpl('integral');
	}

	function consume_action(){

		$CompanyOrderM	=	$this->MODEL('companyorder');
		
		$where['com_id']	=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['c']		=	'consume';
		$urlarr['page']		=	"{{page}}";
		$pageurl	=	Url('wap',$urlarr,'member');
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('pay_time,desc');
	
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
	
		$rows	=	$CompanyOrderM->getPayList($where);
	
		if(is_array($rows)){

			foreach($rows as $k=>$v){

				$rows[$k]['order_price']	=	floatval($v['order_price']);
				$rows[$k]['pay_time']		=	date("Y-m-d H:i:s",$v['pay_time']);
			}
		}
		$this->yunset("rows",$rows);

		$backurl	=	Url('wap',array('c'=>'integral'),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',"账务明细");
		$this->waptpl('consume');
	}

	function integral_reduce_action(){

		$backurl	=	Url('wap',array('c'=>'integral'),'member');
		$this->yunset('backurl',$backurl);

		$this->yunset('header_title',$this->config['integral_pricename']."规则");
		$this->waptpl('integral_reduce');
	}

	function banner_action(){

		$trainM	=	$this->MODEL('train');

		$banner	=	$trainM	-> getBannerInfo(array('uid'=>$this->uid),array('pic'=>'1'));

		if($_POST['submit']){
		
			$data['uid']		=	$this->uid;
			$data['usertype']	=	$this->usertype;
			$data['did']		=	$this->userdid;
			$data['base']		=	$_POST['preview'];
			$data['type']      	=	'5';
			if($banner['id']){

				$data['type']	=	'update';
			}else{
				$data['type']	=	'add';
			}
			$return	=	$trainM -> setBanner($data);	
		}	 
		$this -> yunset("banner",$banner);
		$this -> yunset("layer",$return);

		$backurl	=	Url('wap',array('c'=>'integral'),'member');
		$this -> yunset("backurl",$backurl);

		$this -> yunset('header_title',"机构横幅");
		$this -> waptpl('banner');
	}
}
?>