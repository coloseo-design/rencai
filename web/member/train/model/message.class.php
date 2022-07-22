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
class message_controller extends train
{
	function index_action(){

		$TrainM		=	$this->MODEL('train');
		$UserinfoM	=	$this->MODEL('userinfo');
		
		$where['s_uid']	=	$this->uid;
		
		if($_GET['status']){
			$status				=	intval($_GET['status']);
			$where['status']	=	$status;
			$urlarr['status']	=	$status;
		}		
		$urlarr['c']		=	"message";
		$urlarr['page']		=	"{{page}}";
		$pageurl			=	Url('member',$urlarr);
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_zixun',$where,$pageurl,$_GET['page']);
	
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');
		$rows				=	$TrainM->getPxzxList($where);

		if(is_array($rows)){

			foreach($rows as $v){

				$uids[]		=	$v['uid'];
			}
			$mwhere['uid']	=	array('in', pylode(',', $uids));
			$minfo			=	$UserinfoM->getList($mwhere,array('field'=>'uid,username'));		
			foreach($rows as $k=>$v){

				foreach($minfo as $val){

					if($v['uid']==$val['uid']){

						$rows[$k]['nickname']	 =			$val['username'];
					}
				}
			}
		}
		$this->yunset("rows",$rows);
		$this->train_satic();
		$this->train_tpl('message');
	}
	function reply_action(){

		$TrainM	=	$this->MODEL('train');
		$LogM	=	$this->MODEL('log');

		$id		=	(int)$_POST['id'];
		
		if($_GET['reply']){
			
			if(trim($_POST['content'])==""){
			
				$this->ACT_layer_msg("回复内容不能为空！",8);
			}
			$where['id']	=	$id;
			$where['s_uid']	=	$this->uid;
			$data	=	array(
				'reply'			=>	trim($_POST['content']),
				'reply_time'	=>	time(),
				'status'		=>	2
			);
			$nid	=	$TrainM->upPxzixun($where,$data);
			
			if($nid){
				$LogM->addMemberLog($this->uid,$this->usertype,"回复咨询留言",18,1);
				$this->ACT_layer_msg("回复成功！",9,$_SERVER['HTTP_REFERER']);
			}else{
				$this->ACT_layer_msg("回复失败！",8,$_SERVER['HTTP_REFERER']);
				
			}
		}
	}
	function del_action(){

		$TrainM		=	$this->MODEL('train');
		$id			=	(int)$_GET['del'];
		if($id){
			
			$return	=	$TrainM -> delPxzx($id,array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype']);
		}
	}
}
?>