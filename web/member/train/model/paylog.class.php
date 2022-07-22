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
class paylog_controller extends train
{
	function index_action(){

		$CompanyOrderM		=	$this->MODEL('companyorder');

		include(CONFIG_PATH."db.data.php");
		$this->yunset("arr_data",$arr_data);
		
		$where['com_id']	=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['c']		=	"paylog";
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url('member',$urlarr);
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('company_pay',$where,$pageurl,$_GET['page']);
		
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
		$this->yunset("ordertype","ok");
		
		$this->train_satic();
		$this->train_tpl('paylog');
	}
}
?>