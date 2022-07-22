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
class rebates_controller extends user{
	//我推荐的悬赏列表
	function index_action(){
		$this->public_action();
		$where['uid']	=  $this->uid;
		$urlarr['c']	=	$_GET['c'];
		$urlarr['page']	=	'{{page}}';
	    $pageurl		=	Url('member',$urlarr);

	    $pageM			=	$this->MODEL('page');
	    $pages			=	$pageM->pageList('rebates',$where,$pageurl,$_GET['page']);
	    
	    if($pages['total'] > 0){
	        $where['orderby']		=	'id';
	        $where['limit']			=	$pages['limit'];
	        
	        $lietouM  =  $this->MODEL('lietou');
	        
	        $List   	=  $lietouM->getRebatesList($where);
	    }
		$this->yunset("rows",$List);
		$this->user_tpl('rebates');
	}
	//删除我推荐的悬赏
	function del_action(){
		$id			=	(int)$_GET['id'];
		$ltM		=	$this -> MODEL('lietou');
		$result		=	$ltM -> delRebates($id,array('uid'=>$this->uid,'usertype'=>$this->usertype,'type'=>1));//type==1我推荐的人才
		$this -> layer_msg($result['msg'],$result['errcode'], $result['layertype'], $_SERVER['HTTP_REFERER']);
		
	}
}
?>