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
class subpay_controller extends train{

	function index_action(){

		$CompanyOrderM	=	$this->MODEL('companyorder');
		
		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		

		//查询账户余额信息		
		$statis				=	$this->train_satic();
		$statis['freeze']	=	sprintf("%.2f", $statis['freeze']);
		$this->yunset("statis",$statis);

		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['type']			=	2;
		$where['pay_remark']	=	array('like','课程报名费');
		//查询金额明细记录
		$urlarr['c']			=	"subpay";
		$urlarr['consume']		=	"ok";
		$urlarr['pay_remark']	=	"{{page}}";
		$pageurl	=	Url('member',$urlarr);
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
	
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('pay_time,desc');

		$rows	=	$CompanyOrderM->getPayList($where);

		if(is_array($rows)){

			foreach($rows as $k=>$v){

				$rows[$k]['order_price']	=	floatval($v['order_price']);
				$rows[$k]['pay_time']		=	date("Y-m-d H:i:s",$v['pay_time']);
			}
		}
		$this->yunset("rows",$rows);
		$this->train_tpl('subpay');
	}

	//提现
	function withdraw_action(){
		//查询账户余额信息
		$PackM 	= 	$this->MODEL('pack');
		
		if($_POST){
			$return	=	$PackM->withDraw($this->uid,$this->usertype,$_POST['price'],$_POST['real_name']);
				
			if($return['errcode'] == 1){
				//提现成功
				$this->ACT_layer_msg("提现成功，请关注微信账户提醒！",9,$_SERVER['HTTP_REFERER']);
			}else{
				//生成失败 返回具体原因
				$this->ACT_layer_msg($return['msg'],8,$_SERVER['HTTP_REFERER']);
			}

		}else{
			$statis	=	$this->train_satic();
			$this->yunset("statis",$statis);
			$this->train_tpl('withdraw');
		}
	}

	function withdrawlist_action(){
		
		$PackM	=	$this->MODEL('pack');
		
		$where['uid']	=	$this->uid;
		$urlarr['c']	=	"subpay";
		$urlarr['act']	=	"withdrawlist";
		$urlarr['page']	=	"{{page}}";
		
		$pageurl	=	Url('member',$urlarr);
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('member_withdraw',$where,$pageurl,$_GET['page']);
	
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows	=	$PackM->getList($where);
		$this->yunset("rows",$rows);

		$statis	= 	$this->train_satic();
		$this->yunset("statis",$statis);

		$this->train_tpl('withdrawlist');
		
	}
	function change_action(){

		$StatisM		=	$this->MODEL('statis');
		$CompanyOrderM	=	$this->MODEL('companyorder');
		
		$statis	=	$StatisM->getInfo($this->uid,array('usertype'=>4));
		$this->yunset("statis",$statis);

		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);
		$where['pay_time']		=	array('>=',strtotime(date("Y-m-d 00:00:00")));
		
		$changeNum	=	$CompanyOrderM->getCompanyPayNum($where);
		$this->yunset("changeNum",$changeNum);

		$this->train_tpl('change');
	}
	function savechange_action(){

		$data['uid']			=	$this->uid;
		
		$data['usertype']		=	4;
		
		$data['changeprice'] 	=	$_POST['changeprice'];
		
		$data['changeintegral']	=	$_POST['changeintegral'];
		
		$packM					=	$this	->	MODEL('pack');
		$return					=	$packM	->	saveChange($data);
		
		echo json_encode($return);
	}
	function changelist_action(){
		
		$CompanyOrderM	=	$this->MODEL('companyorder');
		$StatisM		=	$this->MODEL('statis');
		
		$where['com_id']		=	$this->uid;
		$where['usertype']		=	$this->usertype;
		$where['pay_remark']	=	array('like','转换'.$this->config['integral_pricename']);

		$urlarr['c']	=	"subpay";
		$urlarr['act']	=	"changelist";
		$urlarr['page']	=	"{{page}}";
		
		$pageurl	=	Url('member',$urlarr);		
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
	
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('pay_time,desc');
		$rows	=	$CompanyOrderM->getPayList($where);
		$this->yunset("rows",$rows);
				
		$statis	=	$StatisM->getInfo($this->uid,array('usertype'=>4));
		$this->yunset("statis",$statis);
		
		$this->train_tpl('changelist');
	}
}
?>