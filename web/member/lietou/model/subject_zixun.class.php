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
class subject_zixun_controller extends lietou{
	
	function index_action(){
		
		$where['uid']		=	$this->uid;
		$where['usertype']	=	$this->usertype;
		
		$urlarr			=	array("c"=>"subject_zixun","page"=>"{{page}}");
		$pageurl		=	Url('member',$urlarr);
		$pageM			=	$this->MODEL('page');
		$pages			=	$pageM -> pageList('px_zixun',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
	        
			$where['orderby']	=	'id';
			$where['limit']		=	$pages['limit'];
	        $TrainM			=	$this->MODEL('train');
	        
			$rows    =  $TrainM->getPxzxList($where,array('utype'=>'zixun'));
	   
	    }
		
		$this->public_action();
		
		$this->yunset("rows",$rows);
		
		$this->lietou_tpl('subject_zixun');
	
	}
	
	function del_action(){
		
		$TrainM		=	$this->MODEL('train');
		if($_GET['id']){
			
			$return	=	$TrainM->delPxzx((int)$_GET['id'],array('uid'=>$this->uid,'usertype'=>$this->usertype));
			
			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=subject_zixun");
		}
	}
}
?>