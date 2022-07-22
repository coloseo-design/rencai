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
class fav_agency_controller extends lietou{
	
	function index_action(){
		
		$where['uid']			=	$this->uid;
		
		$where['sc_usertype']	=	'4';
		
		$where['tid']			=	'';
		
		$urlarr					=	array("c"=>"fav_agency","page"=>"{{page}}");
		
		$pageurl				=	Url('member',$urlarr);
		
		$pageM					=	$this->MODEL('page');
		
		$pages					=	$pageM -> pageList('atn',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
	       
		    $where['orderby']	=	'id';
	        
			$where['limit']		=	$pages['limit'];
	        
	        $AtnM	 =	$this->MODEL('atn');
	        
			$rows    =  $AtnM->getatnList($where,array('utype'=>'antagency'));
	    
		}
		
		$this->public_action();
		
		$this->yunset("rows",$rows);
		
		$this->lietou_tpl('fav_agency');
	}
	
	function del_action(){
		
		$AtnM	=	$this->MODEL('atn');
		
		if($_GET['id']){
			
			$return		=	$AtnM->delAtnAll((int)$_GET['id'],array('sc_usertype'=>4,'uid'=>$this->uid,'usertype'=>$this->usertype));

			$this->layer_msg($return['msg'],$return['errcode'],$return['layertype'],"index.php?c=fav_agency");
		}
	}

}
?>