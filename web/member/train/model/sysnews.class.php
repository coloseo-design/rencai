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
class sysnews_controller extends train{
	function index_action(){

		$SysmsgM	=	$this->MODEL('sysmsg');
		
		$where['fa_uid']	=	$this->uid;
		$where['usertype']	=	$this->usertype;

		$urlarr['c']	=	"sysnews";
		$urlarr['page']	=	"{{page}}";

		$pageurl	=	Url('member',$urlarr);
		$pageM		=	$this  -> MODEL('page');
		$pages		=	$pageM -> pageList('sysmsg',$where,$pageurl,$_GET['page']);
		
		$where['limit']		=	$pages['limit'];
		$where['orderby']	=	array('id,desc');

		$rows	=	$SysmsgM->getList($where);
		$this->yunset("rows",$rows);

		$this->train_satic();

		$this->train_tpl('sysnews');
	}
	function del_action(){
		$SysmsgM	=	$this->MODEL('sysmsg');
		
		if($_GET['del']||$_GET['id']){
		
			if($_GET['del']){

				$del		=	$_GET['del'];
				$layer_type	=	1;
			}else{
				$del		=	intval($_GET['id']);
				$layer_type	=	0;
			}

			$delRes	=	$SysmsgM->delInfo($del,array('fa_uid'=>$this->uid));
		
			$this->layer_msg( $delRes['msg'], $delRes['errcode'],$layer_type,"index.php?c=sysnews");
		}
	}
	function set_action(){

		$SysmsgM	=	$this->MODEL('sysmsg');
		$id			=	intval($_POST['id']);
		
		$where['id']			=	$id;
		$where['fa_uid']		=	$this->uid;
		$where['remind_status']	=	0;
		if($id){
			$SysmsgM->upSysmsg($where,array('remind_status'=>'1'));
		}
	}
}
?>