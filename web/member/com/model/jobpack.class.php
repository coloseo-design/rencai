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
class jobpack_controller extends company{

	function index_action(){
		$this->public_action();
		$this->company_satic();
		if($_GET['t']=='r'){//悬赏职位
			$this->rewardjob();
		}else{//分享职位
			$this->sharejob();
		}
	}
	
	function sharejob(){	
		$packM	=	$this->MODEL('pack');
		$urlarr			=	array("c"=>"jobpack","page"=>"{{page}}");
		$where['uid']	=	$this->uid;
		$pageurl		=	Url('member',$urlarr);
		
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_share',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$packM -> getShareJobList($where, array('utype'=>'admin'));
			
			$this->yunset("rows" , $List);
		}
		
		$this->com_tpl('jobshrelist');
	
	}
	//取消分享职位
	function delshare_action(){
		
		
		if($_GET['id']){
			
			$packM = $this->MODEL('pack');
			$return = $packM->delShareJob($this->uid,$_GET['id']);
			
			$this->layer_msg('赏金职位'.$return['msg'], $return['errcode'], 0, $_SERVER['HTTP_REFERER']);
		}else{
			$this->layer_msg('请选择正确的职位！',8,0,$_SERVER['HTTP_REFERER']);
		}
	
	}
	//取消悬赏职位
	function delreward_action(){
		
		
		if($_GET['id']){
			
			$packM = $this->MODEL('pack');
			$return = $packM->delrewardJob($this->uid,$_GET['id']);
			if($return['msg']){
				$this->layer_msg($return['msg'],8,0,$_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg('悬赏职位取消成功！',9,0,$_SERVER['HTTP_REFERER']);
			}
			
		}else{
			$this->layer_msg('请选择正确的职位！',8,0,$_SERVER['HTTP_REFERER']);
		}
	
	}
	function rewardjob(){
		$packM = $this->MODEL('pack');
		$urlarr			=	array("c"=>"jobpack",'t'=>'r',"page"=>"{{page}}");
		$where['uid']	=	$this->uid;
		
		$pageurl		=	Url('member',$urlarr);

		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_reward',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'id';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$packM -> getRewardJobList($where,array('utype'=>'admin'));
			
			$this->yunset("rows" , $List);
		}
		
		$this->com_tpl('jobrewardlist');
	}
	//生成分享红包推广订单
	function pay_action(){
	
		if($_POST){
			 
		    $_POST['uid']         =   $this->uid;
		    $_POST['usertype']    =   $this->usertype;
		    $_POST['username']    =   $this->username;
		    $_POST['did']         =   $this->config['did'];
		    
			 $M      =   $this->MODEL('pack');
			 
			 $return =   $M -> redPackOrder($_POST);
			
			 if($return['order']['order_id']&&$return['order']['id']){
				//订单生成成功
				echo json_encode(array('error'=>0,'orderid'=>$return['order']['order_id'],'id'=>$return['order']['id']));
					
			 }else{
				 //生成失败 返回具体原因
				 echo json_encode(array('error'=>1,'msg'=>$return['error']));
			 }
		}else{
			echo json_encode(array('error'=>1,'msg'=>'参数错误，请重试！'));
		}
	
	}
	//生成悬赏红包推广订单
	function rewardpay_action()
    {
        if ($_POST) {
            
            $_POST['uid']       =   $this->uid;
            $_POST['usertype']  =   $this->usertype;
            $_POST['username']  =   $this->username;
            $_POST['did']       =   $this->config['did'];
            
            $M      =   $this->MODEL('pack');
            $return =   $M->rewardPackOrder($_POST);

            if ($return['order']['order_id'] && $return['order']['id']) {
                // 订单生成成功

                echo json_encode(array(
                    'error'     => 0,
                    'orderid'   => $return['order']['order_id'],
                    'id'        => $return['order']['id']
                ));
            } else {
                // 生成失败 返回具体原因

                echo json_encode(array(
                    'error' =>  1,
                    'msg'   =>  $return['error']
                ));
            }
        } else {
            echo json_encode(array(
                'error' => 1,
                'msg' => '参数错误，请重试！'
            ));
        }
    }
	//查询分享红包职位记录
	function loglist_action(){
		$this	->	public_action();
		
		//红包收益
		$urlarr['c']	=	$_GET['c'];
		$urlarr['act']	=	$_GET['act'];
		$urlarr["page"]	=	"{{page}}";
		$pageurl		=	Url('member',$urlarr);
		$where			=	array('uid'=>$this->uid,'orderby'=>'time,desc');
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_sharelog',$where,$pageurl,$_GET['page']);
		if($pages['total'] > 0){
		    $packM			=	$this	-> MODEL('pack');
		    $where['limit']	=	$pages['limit'];
		    $rows			=	$packM	->	getShareLogList($where);
		    $this	->	yunset('rows',$rows);
		}
		$this	->	company_satic();
		$this	->	com_tpl('loglist');
	}
	
	function rewardjob_action(){
		
		if($_POST){
			
			$M		=	$this -> MODEL('pack');
			$_POST['uid']	=	$this->uid;
			$return	=	$M -> rewardJob($_POST);
				
			if($return['error']=='ok'){
				//悬赏职位设定成功
				
				echo json_encode(array('error'=>1));
					
			}else{

				 //生成失败 返回具体原因
				 
				echo json_encode(array('msg'=>$return['error']));
			}
		}else{

			echo json_encode(array('msg'=>'参数错误，请重试！'));
		}
	}
	function rewardlog_action(){
		$packM = $this->MODEL('pack');
		
		include(CONFIG_PATH."db.data.php");
		
		$this->public_action();
		
		$urlarr					=	array("c"=>"jobpack",'c'=>'rewardlog',"page"=>"{{page}}");
		
		$where['comid']			=	$this->uid;
		
		if($_GET['jobid']){
			
			$where['jobid']		=	(int)$_GET['jobid'];
			
			$urlarr['jobid']	=	$_GET['jobid'];
		}
		if($_GET['state']){
			
			$where['status']	=	array('in',pylode(',',$arr_data['rewardstate'][$_GET['state']]['state']));
			
			$urlarr['state']	=	$_GET['state'];
		}
		$pageurl	=	Url('member',$urlarr);
		
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_job_rewardlist',$where,$pageurl,$_GET['page'],$this->config['sy_listnum']);
		
		if($pages['total'] > 0){
			if($_GET['order'])
			{
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				$urlarr['order']		=	$_GET['order'];
				$urlarr['t']			=	$_GET['t'];
			}else{
				$where['orderby']		=	'datetime';
			}
			$where['limit']	=	$pages['limit'];
			
			$List	=	$packM -> getJobRewardList($where,array('utype'=>'admin'));
			
			$this->yunset("rows" , $List);
		}
		$statisM  = $this->MODEL('statis');
		
		$statis = $statisM->getInfo($this->uid,array('usertype'=>2));
		
		$this->yunset("statis",$statis);
		
		$this->yunset("StateList",$arr_data['rewardstate']);
		
		$this->com_tpl('jobrewardlog');
	}

	function logstatus_action(){
		
		if($_POST){
			
			$M		=	$this -> MODEL('pack');
			$_POST['port']	=	'1';
			$return	=	$M -> logStatus((int)$_POST['rewardid'],(int)$_POST['status'],$this->uid,'2',$_POST);
			
			if($return['error']==''){

				//悬赏职位设定成功
				echo json_encode(array('error'=>'ok'));
			}else{

				//生成失败 返回具体原因
				echo json_encode(array('error'=>$return['error']));
			}
		}
	}

	function lookresume_action(){
	
		if($_GET['id']){
			
			$M		=	$this -> MODEL('pack');
			
			$reward	=	$M -> getReward((int)$_GET['id'],$this->uid); 
			
			if(empty($reward)){
				
				$this->ACT_msg('index.php?c=jobpack&t=r', '未找到相关数据！',8);

			}elseif($reward['status']=='0'){

				$this->ACT_msg('index.php?c=jobpack&act=rewardlog&jobid='.$reward['jobid'], '请先支付职位赏金！',8);
			
			}else{
				//根据赏单数据 判断是用户自荐还是第三方推荐
				if($reward['usertype']=='3'){
					
					$talentM	=	$this -> MODEL('talent');
					
					$Info		=	$talentM -> getList(array('uid'=>$reward['uid'],'id'=>$reward['eid']));
					
				}else{

					$resumeM	=	$this -> MODEL('resume');
					$cacheM		=	$this -> MODEL('cache');
					$cache		=	$cacheM->GetCache('user');
					
					$Info 		=	$resumeM -> getInfoByEid(array('uid'=>$reward['uid'],'eid'=>$reward['eid']));
					
					include(CONFIG_PATH."db.data.php");
					
					$Info['sex']=$cache['user_sex'][$Info['sex']];
					
				}
				
				$this->yunset(array("resumestyle"=>$this->config['sy_weburl']."/app/template/resume"));
				
				$this->yunset("Info",$Info);
				
				$this->yunset("reward",$reward);
			}
			$this->company_satic();
			
			$this->public_action();
			
			$this->com_tpl('lookresume');
		}
	}

	//提现
	function withdraw_action(){
		//查询账户余额信息
		
		if($_POST){

			$M		= $this	->	MODEL('pack');
			$return	= $M	->	withDraw($this->uid,$this->usertype,$_POST['price'],$_POST['real_name']);
				
			if($return['errcode'] == 1){
				//提现成功
				$this	->	ACT_layer_msg("提现成功，请关注微信账户提醒！",9,$_SERVER['HTTP_REFERER']);
			}else{
				//生成失败 返回具体原因
				$this	->	ACT_layer_msg($return['msg'],8,$_SERVER['HTTP_REFERER']);
			}

		}else{
			$userinfoM	= 	$this -> MODEL('userinfo');
			$member		=   $userinfoM -> getInfo(array('uid'=> $this->uid),array('field'=>'`wxid`'));
			if(!$member['wxid']){
				$this -> ACT_msg("index.php?c=binding","请先绑定微信！");
			}
			$this	->	company_satic();
			$this	->	com_tpl('withdraw');
		}
		
	}
	function change_action(){
		
		$this	->	company_satic();
		$where	=	array(
			'com_id'		=>	$this->uid,
			'usertype'		=>	$this->usertype,
			'pay_remark'	=>	array('like','转换'.$this->config['integral_pricename'])
		);
		$orderM		=	$this	->	MODEL('companyorder');
		$changeNum 	=	$orderM	->	getCompanyPayNum($where);
		$this	->	yunset("changeNum",$changeNum);
		$this	->	com_tpl('change');
	}
	
	function savechange_action(){
		
		$data['changeprice']	=	$_POST['changeprice'];
		$data['changeintegral']	=	$_POST['changeintegral'];
		$data['uid']			=	$this	->	uid;
		$data['usertype']		=	$this	->	usertype;
		$packM					=	$this	->	MODEL('pack');
		$return					=	$packM	->	saveChange($data);

		echo json_encode($return);
	}
	function changelist_action(){
		$urlarr					=	array("c"=>"jobpack","act"=>"changelist","page"=>"{{page}}");
		$pageurl				=	Url('member',$urlarr);
		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);
		$where['orderby']		=	'pay_time,desc';

		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
		    $orderM				=	$this	-> MODEL('companyorder');
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$orderM	->	getPayList($where);
		    $this	->	yunset("rows",$rows);
		}


		$this	->	company_satic();
		$this	->	com_tpl('changelist');
	}
	function withdrawlist_action(){
		
		$urlarr["c"]		=	"jobpack";
		$urlarr["act"]		=	"withdrawlist";
		$urlarr["page"]		=	"{{page}}";
		$pageurl			=	Url('member',$urlarr);
		$where['uid']		=	$this->uid;
		$where['orderby']	=	'id,desc';
		
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('member_withdraw',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
		    $packM		=	$this  -> MODEL('pack');
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$packM	->	getList($where);
		    $this	->	yunset("rows",$rows);
		}
		$this	->	company_satic();
		$this	->	com_tpl('withdrawlist');
	}
}
?>