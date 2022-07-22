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
class invoice_controller extends siteadmin_controller{
	//设置高级搜索功能
	function set_search(){
		$search_list[]	=	array("param"=>"status","name"=>'发票状态',"value"=>array("0"=>"未审核","1"=>"已审核","2"=>"未通过","3"=>"已打印","4"=>"已邮寄"));
		
		$lo_time		=	array('1'=>'今天','3'=>'最近三天','7'=>'最近七天','15'=>'最近半月','30'=>'最近一个月');
		$search_list[]	=	array("param"=>"time","name"=>'申请时间',"value"=>$lo_time);
		
		$this -> yunset("search_list",$search_list);
	}
	function index_action(){
		$this -> set_search();
		
		$InvoiceM					=	$this -> MODEL('invoice');
		
		$where         				=   array();
	   
	    $keywordStr	   				=   trim($_GET['keyword']);
		
		if (!empty($keywordStr)) {
	        $where['order_id']		=	array('like', $keywordStr);
			$urlarr['keyword']		=	$keywordStr;
	    }
		if($_GET['status']!=""){
			$where['status']		=	$_GET['status'];

			$urlarr['status']		=	$_GET['status'];
		}
		if($_GET['time']){
			if($_GET['time'] == 1){
				$where['addtime']	=	array('>=',strtotime(date("Y-m-d 00:00:00")));
			}else{
				$where['addtime']	=	array('>=',strtotime('-'.intval($_GET['time']).' day'));
			}
			$urlarr['time']			=	$_GET['time'];
		}
		$urlarr['page']				=	"{{page}}";
		
		$pageurl					=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM						=	$this  -> MODEL('page');
		
		$pages						=	$pageM -> pageList('invoice_record',$where,$pageurl,$_GET['page']);

		if($pages['total'] > 0){
	        //limit order 只有在列表查询时才需要
	        if($_GET['order']){
	            $where['orderby']	=	$_GET['t'].','.$_GET['order'];

	            $urlarr['order']	=	$_GET['order'];
	            $urlarr['t']		=	$_GET['t'];
	        }else{
	            $where['orderby']	=	array('status,asc');
	        }
	        $where['limit']			=	$pages['limit'];

	        $rows    				=   $InvoiceM -> getRecordList($where,array('utype'=>'admin','field'=>'id,oid,price,addtime,title,style,uid,link_moblie,email,status'));
	    }
		$this -> yunset("rows",$rows);
		$this -> siteadmin_tpl(array('admin_invoice'));
	}
	function status_action(){
		$InvoiceM	=	$this -> MODEL('invoice');

		$post		=	array(
				'status'     =>  intval($_POST['status']),
				'statusbody' =>  trim($_POST['statusbody'])
	    );
		
		$return    =  $InvoiceM -> setStatus(array('id' => array('in',$_POST['pid'])),array('post'=>$post));

	    $this -> ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER'],2,1);
	}
	function statusbody_action(){
		$id			=   intval($_POST['id']);
        $InvoiceM	=	$this -> MODEL('invoice');
        $row		=   $InvoiceM -> getRecordInfo($_POST['id'],array('field'=>'statusbody'));
		echo $row['statusbody'];die;
	}
	function show_action(){
		$id			=	intval($_GET['id']);
        $InvoiceM	=	$this -> MODEL('invoice');
        $row		=	$InvoiceM ->getRecordInfo($id);
		$this -> yunset("invoice",$row);
		$this -> siteadmin_tpl(array('admin_invoice_show'));
	}
	function del_action(){
		$this -> check_token();
		$InvoiceM	=	$this -> MODEL('invoice');
		$delID		=	is_array($_GET['del']) ? $_GET['del'] : $_GET['id'];
		$return		=	$InvoiceM -> del($delID);
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
	}
}
?>