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
class jobpack_controller extends lietou{
	
	function index_action(){
		
		$this->public_action();
		include(CONFIG_PATH."db.data.php");
		
		$packM					=	$this->MODEL('pack');
		
		$where['uid']			=	$this->uid;
		
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
			 
			$List	=	$packM -> getJobRewardList($where,array('utype'=>'lietou'));
			
			$this->yunset("rows" , $List);
		}
		$this->yunset("StateList",$arr_data['rewardstate']);
		
		$this->lietou_tpl('jobpack');
	}

	function logstatus_action()
	{
	
		if($_POST){

			$M	=	$this->MODEL('pack');

			$_POST['port']	=	'1';
			$return	=	$M->logStatus((int)$_POST['rewardid'],(int)$_POST['status'],$this->uid,'1',$_POST);

			if($return['error']==''){

				//悬赏职位设定成功
				echo json_encode(array('error'=>'ok'));
			}else{

				//生成失败 返回具体原因
				echo json_encode(array('error'=>$return['error']));
			}
		}
	}

	function arb_action(){
		if($_POST){

			if(!$_POST['rewardid']){
				$this->ACT_layer_msg("请选择需要仲裁的赏单！",8,$_SERVER['HTTP_REFERER']);
			}
			if(!$_POST['content']){
				$this->ACT_layer_msg("请填写仲裁原因！",8,$_SERVER['HTTP_REFERER']);
			}else{
				$data['content'] = $_POST['content'];
			}
			
			$data['file'] 	= $_FILES['file'];
			$M		=	$this->MODEL('pack');
			$data['port']	=	'1';
			$return	=	$M->logStatus((int)$_POST['rewardid'], 26, $this->uid, '1', $data);
				
			if($return['error']==''){
				//悬赏职位设定成功
				$this->ACT_layer_msg("仲裁提交成功！",9,$_SERVER['HTTP_REFERER']);
					
			}else{
				 //生成失败 返回具体原因
				$this->ACT_layer_msg($return['error'],8,$_SERVER['HTTP_REFERER']);
			}
		}
	
	
	}
	function loglist_action(){
		$packM		=	$this->MODEL('pack');
		
		$where['uid']	=	$this->uid;
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['act']	=	$_GET['act'];
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('member',$urlarr);
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_job_sharelog',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']		=	'time,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$packM->getShareLogList($where);
			$this->yunset("rows",$List);
		}
		$this->getStatis('loglist');
		$this->public_action();
		$this->lietou_tpl('loglist');
	}
	//提现
	function withdraw_action(){
		//查询账户余额信息
		if($_POST['price']	&&	$_POST['real_name']){
			$packM	=	$this->MODEL('pack');
			
			$return	=	$packM->withDraw($this->uid,$this->usertype,$_POST['price'],$_POST['real_name']);

			if($return['errcode'] == 1){
				$this->ACT_layer_msg("提现成功，请关注微信账户提醒！",9,$_SERVER['HTTP_REFERER']);
				
			}else{
				$this->ACT_layer_msg($return['msg'],8,$_SERVER['HTTP_REFERER']);
			}
			
		}else{
			$userinfoM	= 	$this -> MODEL('userinfo');
			$member		=   $userinfoM -> getInfo(array('uid'=> $this->uid),array('field'=>'`wxid`'));
			if(!$member['wxid']){
				$this -> ACT_msg("index.php?c=binding","请先绑定微信！");
			}
			
			$this->getStatis();
			$this->public_action();
			$this->lietou_tpl('withdraw');
		}
		
	}
	function change_action(){
		
		$orderM		=	$this->MODEL('companyorder');
		
		$nWhere['com_id']		=	$this->uid;
		$nWhere['usertype']		=	$this->usertype;
		$nWhere['pay_remark']	=	array('like', '转换'.$this->config['integral_pricename']);
		$nWhere['pay_time']		=	array('>=', strtotime(date("Y-m-d 00:00:00")));
		
		$changeNum 	= 	$orderM->getCompanyPayNum($nWhere);	

		$this->getStatis();
		
		$this->public_action();
		$this->yunset("changeNum",$changeNum);
		$this->lietou_tpl('change');
	}
	
	function savechange_action(){
		
		
		$data['uid']			=	$this->uid;
		
		$data['usertype']		=	3;
		
		$data['changeprice'] 	=	$_POST['changeprice'];
		
		$data['changeintegral']	=	$_POST['changeintegral'];
		
		$packM					=	$this	->	MODEL('pack');
		$return					=	$packM	->	saveChange($data);
		
		echo json_encode($return);
	}
	
	function changelist_action(){
		$orderM			=	$this->MODEL('companyorder');
		
		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['act']	=	"changelist";
		$urlarr['c']	=	"jobpack";
		$pageurl		=	Url('member',$urlarr);
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']	=	'pay_time,desc';
		    $where['limit']		=	$pages['limit'];
			
		    $List				=	$orderM->getPayList($where);
			$this->yunset("rows",$List);
		}
		$this->getStatis();
		$this->public_action();
		$this->lietou_tpl('changelist');
	}
	
	function withdrawlist_action(){
		$packM			=	$this->MODEL('pack');
		
		$where['uid']	=	$this->uid;
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"jobpack";
		$urlarr["act"]	=	"withdrawlist";
		$pageurl		=	Url('member',$urlarr);
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('member_withdraw',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']		=	'id,desc';
		    $where['limit']			=	$pages['limit'];
			
		    $List					=	$packM->getList($where);
			$this->yunset("rows",$List);
		}
		$this->getStatis('');
		$this->public_action();
		$this->lietou_tpl('withdrawlist');
	}
	
	function getStatis($type = ''){
		$statisM  	= 	$this->MODEL('statis');
		
		$statis		= 	$statisM->getInfo($this->uid,array('usertype'=>3));
		
		if($type=='loglist'){
			$statis['freeze'] = sprintf("%.2f", $statis['freeze']);
		}
		
		$this->yunset("statis",$statis);
	}
}
?>