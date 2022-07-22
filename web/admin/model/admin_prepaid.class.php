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
class admin_prepaid_controller extends adminCommon{
	function set_search(){
		$search_list[]=array("param"=>"time","name"=>'有效期',"value"=>array("1"=>"未过期","2"=>"已过期"));
		$search_list[]=array("param"=>"status","name"=>'使用状态',"value"=>array("1"=>"已使用","2"=>"未使用"));
		$search_list[]=array("param"=>"type","name"=>'状态',"value"=>array("1"=>"可用","2"=>"不可用"));
		$this->yunset("search_list",$search_list);
	}
	function index_action(){
		$this->set_search();
		
		if(trim($_GET['keyword'])){
			
			if($_GET['ctype']=='2'){
				
				$where['username']	=	array('like',trim($_GET['keyword']));
				
			}else{
				
				$where['card']		=	array('like',trim($_GET['keyword']));
				
			}
			$urlarr['keyword']		=	$_GET['keyword'];
		}
		if($_GET['type']){
			
			if($_GET['type']=='1'){
				
				$where['type']		=	$_GET['type'];
				
			}else{
				
				$where['type']		=	$_GET['type'];
				
			}
			$urlarr['type']			=	$_GET['type'];
		}
		if($_GET['status']){
			
			if($_GET['status']==1){
				
				$where['uid']		=	array('>','0');
				
			}else{
				
				$where['uid']		=	array('isnull');
				
			}
			$urlarr['status']		=	$_GET['status'];
		}
		if($_GET['time']){
			
			if($_GET['time']==1){
				
				$where['etime']		=	array('>',time());
				
			}else{
				
				$where['etime']		=	array('<',time());
				
				$where['uid']		=	array('isnull');
				
			}
			$urlarr['time']			=	$_GET['time'];
		}
		$urlarr        		=   $_GET;
		$urlarr['page']		=	"{{page}}";
		
		$pageurl			=	Url($_GET['m'],$urlarr,'admin');
		
		$pageM				=	$this  -> MODEL('page');
		
		$pages				=	$pageM -> pageList('prepaid_card',$where,$pageurl,$_GET['page']);
		
		if($pages['total'] > 0){
			
			if($_GET['order']){
				
				$where['orderby']		=	$_GET['t'].','.$_GET['order'];
				
				$urlarr['order']		=	$_GET['order'];
				
				$urlarr['t']			=	$_GET['t'];
				
			}else{
				
				$where['orderby']		=	'id';
				
			}
			
			$where['limit']				=	$pages['limit'];
			
			$prepaidM	=	$this->MODEL('prepaid');
			
			$rows   	=	$prepaidM -> getList($where);
			
			unset($where['limit']);
			
			session_start();
			
			$_SESSION['preXls'] = $where;
		}
		
		$this->yunset('rows',$rows);
		
		$this->yuntpl(array('admin/admin_prepaid'));
	}
	function upcard_action(){
		
		$prepaidM	=	$this->MODEL('prepaid');
		
		if($_POST['submit']){
			
			$where['id']	=	intval($_POST['id']);
			
			$where['utime']	=	array('isnull');
			
			$return			=	$prepaidM -> upInfo($_POST,$where);
			
			$return['id']?$this->ACT_layer_msg($return['msg'],$return['errcode'],"index.php?m=admin_prepaid",2,1):$this->ACT_layer_msg($return['msg'],$return['errcode'],$_SERVER['HTTP_REFERER']);
		}
		if($_GET['id']){
			
			$info	=	$prepaidM -> getInfo(array('id'=>intval($_GET['id'])));
			
			if($info['id']){
				
				$this->yunset("info",$info);
				
				$this->yuntpl(array('admin/admin_prepaid_upcard'));
				
			}else{
				
				$this->ACT_msg("index.php?m=admin_prepaid","非法操作");
				
			}
		}
	}

	function xls_action(){
		
		session_start();
		
		$where = $_SESSION['comXls'] ? $_SESSION['comXls'] : array('orderby'=>'id');
		
		if(!empty($_POST['type'])){
			
			if(in_array("card",$_POST['type']) || in_array("password",$_POST['type']) || in_array("quota",$_POST['type']) || in_array("stime",$_POST['type']) || in_array("etime",$_POST['type'])){
				
				foreach($_POST['type'] as $v){
					
					$type[]	=	$v;
				}
			}
			$field	=	pylode(',', $type).',id';
		}else{
			
			$field	=	'id';
		}
		$prepaidM	=	$this -> MODEL('prepaid');
		
		$where['id']=	array('in',$_POST['pid']);
		
		$list		=	$prepaidM -> getList($where,array('field'=>$field));
		
		if(!empty($list)){
			
			$this->yunset("list",$list);
			
			$this->yunset("type",$_POST['type']);
			
			$this->MODEL('log')->addAdminLog("导出充值卡信息");
			
			header("Content-Type: application/vnd.ms-excel");
			
			header("Content-Disposition: attachment; filename=prepaid.xls");
			
			$this->yuntpl(array('admin/admin_prepaid_xls'));
		}

	}

	function add_action(){
		if($_POST['submit']){
			
			$prepaidM	=	$this->MODEL('prepaid');
			
			$return		=	$prepaidM->addInfo($_POST);

			$this->ACT_layer_msg($return['msg'],$return['errcode'],"index.php?m=admin_prepaid");
		}
		$this->yuntpl(array('admin/admin_prepaid_add'));
	}
	function rec_action(){
		$prepaidM	=	$this->MODEL('prepaid');
		
		intval($_GET['rec'])=='1'?$type='1':$type='2';
		
		$postdata['type']	=	$type;
		
		$where['id']		=	$_GET['id'];
		
		$return['id']		=	$prepaidM -> upInfo($postdata,$where,array('rec'=>'1'));
		
		$this->MODEL('log')->addAdminLog("充值卡(ID:".$_GET['id'].")状态设置成功！");
		
		echo $return['id']?1:0;die;
	}

	function del_action(){
		
		$prepaidM	=	$this -> MODEL('prepaid');
		
		$return		=	$prepaidM -> delInfo($_GET['del']);
		
		$this -> layer_msg($return['msg'],$return['errcode'],$return['layertype'],$_SERVER['HTTP_REFERER']);
		
	}
}
?>