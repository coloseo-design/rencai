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
class atn_teacher_controller extends user{
    //关注讲师
	function index_action(){
		$this->public_action();
		$atnM	=	$this->MODEL('atn');
		
		$where['uid']			=	$this->uid;
		$where['tid']			=	array('<>','');
		$where['sc_usertype']	=	'4';
		
		
		//分页链接
		$urlarr['page']	=	'{{page}}';
		$urlarr['c']	=	$_GET['c'];
		$pageurl		=	Url('member',$urlarr);
		
		//提取分页
		$pageM			=	$this  -> MODEL('page');
		$pages			=	$pageM -> pageList('atn',$where,$pageurl,$_GET['page']);
		
		//分页数大于0的情况下 执行列表查询
		if($pages['total'] > 0){
			
			
			$where['orderby']	=	'id,desc';
			
		    $where['limit']		=	$pages['limit'];
			
		    $List				=	$atnM->getatnList($where,array('utype'=>'antteacher'));
			
			$this->yunset("rows",$List);
		}
 		$this->user_tpl('atn_teacher');
	}
	//取消关注讲师
	function del_action(){
		$atnM	=	$this->MODEL('atn');
	
		$return	=	$atnM->delAtnAll(intval($_GET['id']),array('sc_usertype'=>4,'tid'=>intval($_GET['tid']),'uid'=>$this->uid,'usertype'=>$this->usertype));
		
		$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=atn_teacher");
	}
}
?>