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
class sign_up_controller extends train{

	function index_action(){

		$TrainM			=	$this->MODEL('train');
		$CompanyorderM	=	$this->MODEL('companyorder');
		$LogM			=	$this->MODEL('log');
		
		$statuss	=	intval($_POST['status']);

		if($statuss=="1"){//设为已联系
			
			if(is_array($_POST['delid'])){
				
				$delid  =  pylode(",",$_POST['delid']);
			}else{
			    $delid  =  $_POST['delid'];
			}
			$pxbwhere['id']		=	array('in', pylode(',', $delid));
			$pxbwhere['s_uid']	=	$this->uid;
			$pxbdata	=	array(
				'status'	=>	$statuss
			);
			$oid	=	$TrainM->upBmInfo($pxbwhere,$pxbdata);
			if($oid){
				$LogM->addMemberLog($this->uid,$this->usertype,"报名信息设为已联系",6,2);
				$this->layer_msg('设置成功！',9);
			}else{
				$this->layer_msg('设置失败！',8);
			}
		}
		if($_POST['delid'] || $_GET['delid']){//删除

			if(is_array($_POST['delid'])){
				
				$delid		=	pylode(",",$_POST['delid']);
				$layer_type	=	'1';
			}else{
				$delid		=	(int)$_GET['delid'];
				$layer_type	=	'0';
			}
			
			$delRes	=	$TrainM->delBm(array('id' => $delid),array('usertype'=>$this->usertype,'s_uid'=>$this->uid));
			
			if($delRes['errcode'] == 9){
				$this->layer_msg($delRes['msg'], 9, $layer_type, $_SERVER['HTTP_REFERER']);
			}else{
				$this->layer_msg($delRes['msg'], 8, $layer_type, $_SERVER['HTTP_REFERER']);
			}
		}
		$where['s_uid']	=	$this->uid;
		$status			=	intval($_GET['status']);

		if($status=="1"){

			$where['status']	=	1;
			$urlarr['status']	=	$status;

		}elseif($status=="2"){

			$where['status']	=	0;
			$urlarr['status']	=	$status;
		}
		$urlarr['c']		=	"sign_up";
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url('member',$urlarr);
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_baoming',$where,$pageurl,$_GET['page']);
	
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
		
		$this->train_satic();
		$this->train_tpl('sign_up');
	}
}
?>