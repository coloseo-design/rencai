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
class subject_zixun_controller extends company{
	function index_action(){
		$this->public_action();
		
		$trainM			=	$this->MODEL('train');
		
		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	"subject_zixun";
		$pageurl		=	Url('member',$urlarr);
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('px_zixun',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			$where['orderby']	=	'id,desc';
			
		    $where['limit']		=	$pages['limit'];
			
		    $List				=	$trainM->getPxzxList($where,array('utype'=>'zixun'));
			
			$this->yunset("rows",$List);
		}
		
		$this->com_tpl('subject_zixun');
	}
	function del_action(){
		$trainM			=	$this->MODEL('train');
		if($_GET['id']){
			$return		=	$trainM -> delPxzx((int)$_GET['id'],array('uid'=>$this->uid,'usertype'=>$this->usertype));
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=subject_zixun");
		}
	}
}
?>