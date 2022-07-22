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
class show_controller extends train{
	function index_action(){
		$trainM				=	$this  -> MODEL('train');
		//删除
		if($_GET['did']){
			$return	=	$trainM	->	delPxshowInfo(
				array(
					'id'		=>	(int)$_GET['did'],
					'member'	=>	'1',
					'uid'		=>	$this->uid,
					'usertype'	=>	$this->usertype
				)
			);
			$this	->	layer_msg($return['msg'],$return['cod']);
		}
		$urlarr['c']		=	"show";
		$urlarr["page"]		=	"{{page}}";
		$pageurl			=	Url('member',$urlarr);
		$where['uid']		=	$this->uid;
		$where['orderby']	=	'id,desc';
		$pageM				=	$this  -> MODEL('page');
		$pages				=	$pageM -> pageList('px_train_show',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
		    
		    $where['limit']		=	$pages['limit'];
		    $rows				=	$trainM	->	getPxshowList($where);
		    $this	->	yunset("rows",$rows);
		    $this	->	yunset("total",$pages['total']);
		}

		$this	->	train_satic();
		$this	->	train_tpl('show');
	}
}
?>