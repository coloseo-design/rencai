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
class admin_splog_controller extends adminCommon{
	//设置高级搜索功能
	function set_search(){

//		$search_list[]	=	array('param' => 'status','name' => '状态','value' => array('3' => '未开始','1' => '已开始','2' => '已结束'));
//
//		$this -> yunset('search_list',$search_list);

	}
	/**
	 * 视频记录
	 */
	function index_action(){
 		
		$spM	=	$this->MODEL('spview');
		 
		
		if($_GET['id']){
			
			$where['zid']	=	intval($_GET['id']);
			
			$urlarr['id']	=	$_GET['id'];
		}
		
		$urlarr['c']	 =	$_GET['c'];
		$urlarr          =   $_GET;
		$urlarr['page']  =	"{{page}}";
		
		$pageurl  =  Url($_GET['m'],$urlarr,'admin');
		$pageM	  =	 $this  -> MODEL('page');
		$pages	  =	 $pageM -> pageList('spview_log',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){	                 
			
		    $where['orderby']  	=  array('id,desc');
		    
		    $where['limit']		=  $pages['limit'];
		    
		    $rows  				=  $spM -> getSpLogList($where, array('utype'=>'admin'));
			
 		}
		
		$this -> yunset("rows",$rows);
		
		$this -> yuntpl(array('admin/admin_splog'));
	
	}
	
	//删除链接
	function delSplog_action(){
		
		$spM	=	$this->MODEL('spview');
		
		if($_GET['delid']){
			
			$this -> check_token();
			
			$delID	=  	intval($_GET['delid']);
			$zdid 	=  	intval($_GET['zid']);
		
		}elseif($_POST['del']){
			
			$delID	=	$_POST['del'];
			$zdid 	=  	intval($_POST['zid']);
		}
		
		$arr	=	$spM -> delSplog($delID,array('utype'=>'admin', 'zdid' => $zdid));
		
		$this -> layer_msg($arr['msg'], $arr['errcode'], $arr['layertype'],$_SERVER['HTTP_REFERER']);

	}

	/**
	 * 通话记录数据统计
	 */
	function splogNum_action(){
		
		$spM	=	$this->MODEL('spview');
		
		$id		=	intval($_GET['id']);
		
		echo $spM->spLogNum($id);
	}

}

?>