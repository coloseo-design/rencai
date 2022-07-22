<?php
/*
* $Author ：PHPYUN开发团队
*
* 官网: http://www.phpyun.com
*
* 版权所有 2009-2021 宿迁鑫潮信息技术有限公司，并保留所有权利。
*
* 软件声明：未经授权前提下，不得用于商业运营、二次开发以及任何形式的再次发布。
 */
class admin_app_push_controller extends adminCommon{
	function set_search(){
		$ad_time		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]	=	array("param"=>"ctime","name"=>'推送时间',"value"=>$ad_time);
		$result			=	array('1'=>'推送有效','2'=>'推送无效');
		$search_list[]	=	array("param"=>"result","name"=>'推送状态',"value"=>$result);
		$this	->	yunset("search_list",$search_list);
	}
	function index_action(){
		$this	->	set_search();
		$where	=	array();
		$swhere	=	array();

		if(trim($_GET['keyword'])){

			if($_GET['type']=="2"){
			    $where['suid']	=	$_GET['keyword'];
			}else{
			    $where['fuid']	=	$_GET['keyword'];
			}

			$urlarr['keyword']	=	$_GET['keyword'];

			$urlarr['type']		=	$_GET['type'];
		}

		if($_GET['ctime']){

			if($_GET['ctime']=='1'){

				$where['ctime']			=	array('>=',strtotime(date("Y-m-d 00:00:00")));

			}else{

				$where['ctime']			=	array('>=',strtotime('-'.$_GET['end'].'day'));

			}

			$urlarr['ctime']	=	$_GET['ctime'];
		}

		if($_GET['result']){

		    if($_GET['result']=='1'){

		    	$where['result']	=	'ok';

		    }else{

		    	$where['result']	=	array('<>','ok');

		    }

		    $urlarr['result']	=	$_GET['result'];
		}
		$urlarr        	=   $_GET;
		$urlarr['page']	=	'{{page}}';
	    
	    $pageurl		=	Url($_GET['m'], $urlarr, 'admin');
	    
	    //提取分页
	    $pageM			=	$this  -> MODEL('page');
	    
	    $pages			=	$pageM -> pageList('app_push', $where, $pageurl, $_GET['page']);
	    //分页数大于0的情况下 执行列表查询
	    if($pages['total'] > 0){
	        
	        //limit order 只有在列表查询时才需要
	        if($_GET['order']){
	            
	            $where['orderby']		=	$_GET['t'].','.$_GET['order'];

	            $urlarr['order']		=	$_GET['order'];

	            $urlarr['t']			=	$_GET['t'];
	            
	        }else{
	            
	            $where['orderby']		=	array('id,desc');
	            
	        }
	        
	        $where['limit']				=	$pages['limit'];
 	        
	        $pushM		=	$this	->	MODEL('push');

	        $ListNew    =   $pushM	->	getAppPushList($where);
	        
	        unset($where['limit']);
	        
	        $this		->	yunset(array('rows'=>$ListNew['list']));
	        
	    }
  
		$this	->	yuntpl(array('admin/admin_app_push'));
	}
   
	function del_action(){

		$this	->	check_token();
		$pushM	=	$this	->	MODEL('push');
		$return	=	$pushM	->	delAppPush($_GET['del']);
		$this	->	layer_msg($return['msg'],$return['errcode'],$return['laytype'],$return['url']);
	    
	}
}